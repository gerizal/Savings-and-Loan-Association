<?php

namespace App\Models;

use App\Models\ApplicationFile;
use App\Models\InstallmentSchedule;
use App\Traits\Shardable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class Contract extends Model
{
    use HasFactory, SoftDeletes, Shardable;

    // Co-locate with Application on same shard
    protected string $shardKey = 'application_id';

    protected $fillable = [
        'application_id',
        'number',
        'date',
        'settlement_date',
        'file_url',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'date'            => 'date',
        'settlement_date' => 'date',
        'application_id'  => 'integer',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function installmentSchedules(): HasMany
    {
        return $this->hasMany(InstallmentSchedule::class, 'application_id', 'application_id');
    }

    // -------------------------------------------------------------------------
    // Static helpers (retained — complex installment schedule generation)
    // -------------------------------------------------------------------------

    /**
     * Create or update a Contract for an application and generate installment
     * schedules. Renamed from createUpdateByApplication().
     */
    public static function fromRequest($request, $application_id): self
    {
        $application = Application::findOrFail($application_id);

        $data = self::whereApplicationId($application_id)->first() ?? new self;
        $data->fill([
            'application_id' => $application_id,
            'date'           => date('Y-m-d', strtotime($request->contract_date)),
            'number'         => $request->contract_number,
            'created_by'     => \Auth::id(),
        ]);
        $data->save();

        $remains         = $application->plafon;
        $settlement_date = '';
        $number          = 1;

        for ($i = 0; $i < $application->tenor; $i++) {
            $schedule = InstallmentSchedule::whereApplicationId($application_id)
                ->whereNumber($number)->first() ?? new InstallmentSchedule;

            $installment  = $application->installment;
            $primary_loan = $application->primary_loan;
            $margin       = $application->margin;
            $interest     = $application->interest;

            if (strtolower($application->interest_type) === 'anuitas') {
                $margin       = round($remains * ($interest / 12 / 100));
                $primary_loan = $installment - $margin;
            }

            $remains -= $primary_loan;
            if ($remains <= 0) {
                $remains = 0;
            }

            $schedule->fill([
                'application_id' => $application_id,
                'number'         => $number,
                'amount'         => $installment,
                'primary_loan'   => $primary_loan,
                'margin'         => $margin,
                'margin_bank'    => $application->bank_installment,
                'colfee'         => $application->col_fee,
                'remains'        => $remains,
                'status'         => false,
                'payment_date'   => \Carbon\Carbon::parse($request->contract_date)->addMonths($number),
            ]);
            $schedule->save();

            $settlement_date = $schedule->payment_date;
            $number++;
        }

        $data->settlement_date = $settlement_date;
        $data->save();

        return $data;
    }

    /**
     * Generate the contract PDF and store it in Azure. Retained — complex logic.
     */
    public static function generateContract($application_id)
    {
        try {
            $application = Application::find($application_id);
            if (!$application) return null;

            $contract  = self::whereApplicationId($application->id)->first();
            $marketing = User::find($application->marketing_id);
            if ($marketing) {
                $application->job_position = $marketing->job_title;
                $application->pkwt_status  = $marketing->status_pkwt;
            }

            $taspen   = Taspen::find($application->taspen_id);
            $province = Province::find($taspen->province_id);
            $city     = City::find($taspen->city_id);
            $district = District::find($taspen->district_id);
            $sub_district = SubDistrict::find($taspen->sub_district_id);
            $taspen->complete_address = "{$taspen->address}, {$sub_district->name}, {$district->name}, {$city->name}, {$province->name}, {$taspen->post_code}";

            $application->taspen = $taspen->toArray();

            $product = Product::find($application->product_id);
            $application->product = $product->toArray();

            $bank = Bank::find($product->bank_id);
            $bank->logo = ($bank->logo !== null && $bank->logo !== '') ? generateSecureUrl($bank->logo) : '';
            $application->bank = $bank->toArray();

            $branch = BranchUnit::find($application->branch_unit_id);
            $application->branch = $branch ? $branch->toArray() : [
                'name' => '', 'code_area' => '', 'number_code' => '', 'address' => '', 'service_unit_id' => '',
            ];

            $finance_type = FinanceType::find($application->finance_type_id);
            $application->finance_type = $finance_type;

            $by_info          = $bank->epotpen_fee + $bank->flagging_fee;
            $block_installment = $application->block_installment * $application->installment;
            $deduction = intval($application->administration_fee)
                + intval($application->management_fee)
                + intval($application->insurance_fee)
                + intval($application->account_opening_fee)
                + intval($application->stamp_fee)
                + intval($by_info)
                + intval($application->provision_fee)
                + intval($block_installment);

            $application->total_cost       = $deduction - intval($application->repayment_fee) - intval($application->bpp_fee);
            $application->gross_amount     = $application->plafon - $deduction;
            $application->net_amount       = $application->plafon - $deduction - intval($application->repayment_fee) - intval($application->bpp_fee);
            $application->rest_salary      = $application->salary - $application->installment;
            $application->blockir_fee      = $block_installment;
            $application->information_fee  = $by_info;
            $application->contract_number  = $contract->number;
            $application->contract_date    = \Carbon\Carbon::parse($contract->date)->format('d-m-Y');
            $application->settlement_date  = \Carbon\Carbon::parse($contract->settlement_date)->format('d-m-Y');

            $spouse = FamilyMember::whereTaspenId($taspen->id)->whereRelationStatus('spouse')->first();
            $application->has_relation = (bool) $spouse;
            $application->spouse       = $spouse;
            $application->start_date   = \Carbon\Carbon::parse($contract->date)->format('d-m-Y');

            $application->other_fee = ($bank->code === 'BPR SIP')
                ? $application->management_fee + $by_info
                : $application->management_fee + $application->mutation_fee + $application->provision_fee + $by_info;

            $application->end_date      = \Carbon\Carbon::parse($contract->settlement_date)->format('d-m-Y');
            $application->enter_age     = intval(round($application->year));
            $application->paid_age      = $application->year + ($application->tenor / 12);
            $application->paid_date     = \Carbon\Carbon::parse($contract->settlement_date)->format('d-m-Y');
            $application->installment_schedules = InstallmentSchedule::whereApplicationId($application->id)
                ->orderBy('number', 'ASC')->get()->toArray();

            $PDFOptions = ['isRemoteEnabled' => true, 'enable_remote' => true, 'chroot' => public_path('img')];
            $pdf = Pdf::setOptions($PDFOptions)->loadView('monitoring.contract', $application->toArray())->setPaper('a4');

            $file_name = \Carbon\Carbon::now('UTC')->format('YmdHis') . '_' . str_replace(['/', ' '], '_', $contract->number);
            $file_path = "documents/{$file_name}";
            Storage::disk('azure')->put($file_path, $pdf->output());

            $contract->file_url = $file_path;
            $contract->save();

            $contract_file = ApplicationFile::whereApplicationId($application_id)->first() ?? new ApplicationFile;
            $contract_file->akad      = $file_path;
            $contract_file->akad_date = \Carbon\Carbon::now('UTC');
            $contract_file->save();

            return $pdf->download('akad.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
