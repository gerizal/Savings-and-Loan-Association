<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Taspen;
use App\Models\Province;
use App\Models\Product;
use App\Models\FinanceType;
use App\Models\Application;
use App\Models\BranchUnit;
use App\Models\Referral;
use App\Models\ServiceUnit;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Bank;
use App\Models\Verification;
use App\Models\Document;
use App\Models\Domicile;

class VerificationController extends Controller
{
    public function __construct(){
        $this->middleware('role.feature.check:verifikasi_pembiayaan,view', ['only' => ['index']]);
        $this->middleware('role.feature.check:verifikasi_pembiayaan,approve', ['only' => ['approveReject']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::select('id','name')->get();
        return view('application.verification.index', compact('banks'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $application = Application::find($id);
        if($application){
            $marketing = User::find($application->marketing_id);
            if($marketing){
                $application->job_position = $marketing->job_title;
                $application->pkwt_status = $marketing->status_pkwt;
            }

            $product = Product::find($application->product_id);
            $bank = Bank::find($product->bank_id);
            $finance_type = FinanceType::find($application->finance_type_id);
            $interest = $product->interest/100;
            $monthlyInterest = $interest/12;
            $maxInstallment = $application->salary*($bank->installment_fee/100);
            $maxPlafon = PV($monthlyInterest,$application->tenor, $maxInstallment);
            $application->max_plafon = $maxPlafon;
            $maxTenor = $product->max_tenor;
            $year = 73;
            $month = 8;
            if((($product->max_paid_age-$year)*12)-($month+1) <= $maxTenor){
                $maxTenor = (($product->max_paid_age-$year)*12)-($month+1);
            }
            $application->max_tenor = $maxTenor;
            $application->max_installment = $maxInstallment;
            $administration_fee = $application->administration_fee;
            $management_fee = $application->management_fee;
            $insurance_fee = $application->insurance_fee;
            $account_opening_fee = $application->account_opening_fee;
            $stamp_fee = $application->stamp_fee;
            $by_info = $bank->epotpen_fee + $bank->flagging_fee;
            $mutation_fee = $application->mutation_fee;
            $provision_fee = $application->provision_fee;
            $block_installment = $application->block_installment * $application->installment;
            $deduction = intval($administration_fee)+intval($management_fee)+intval($insurance_fee)+intval($account_opening_fee)+intval($stamp_fee)+intval($by_info)+intval($mutation_fee)+intval($provision_fee)+intval($block_installment);
            $gross_amount = $application->plafon-$deduction;
            $repayment_fee = $application->repayment_fee;
            $bpp_fee = $application->bpp_fee;
            $net_amount = $application->plafon-$deduction-intval($repayment_fee)-intval($bpp_fee);
            $application->gross_amount = $gross_amount;
            $application->net_amount = $net_amount;
            $application->rest_salary = $application->salary - $application->installment;
            $application->blockir_fee = $block_installment;
            $application->information_fee = $by_info;
            $verification = Verification::whereApplicationId($id)->first();
            if($verification){
                $application->status = $verification->status;
                $application->checker_name = $verification->checker_name;
                $application->checked_by = $verification->checked_by;
                $application->checked_at = $verification->updated_at;
            }
            $application->documents = Document::whereDocumentId($id)->whereNotNull('url')->groupBy('type')->orderBy('id','ASC')->get();
            $domicile = Domicile::whereTaspenId($application->taspen_id)->first();
            if($domicile){
                $new_documents = new \stdClass();
                $new_documents->type='map';
                $new_documents->address = $domicile->address;
                $new_documents->latitude = $domicile->latitude;
                $new_documents->longitude = $domicile->longitude;
                $application->documents[] = $new_documents;
            }

            $data=[
                'data'   =>$application,
                'form' =>[
                    'url'       => route('application.verification.approve-reject',$application->id),
                    'method'    => 'POST',
                    'files'     => true,
                    'id'        =>'form-loan'
                ],
                'products' => Product::select('id','name')->get()->pluck('name','id'),
                'types' => FinanceType::select('id','name')->get()->pluck('name','id'),
                'taspens' => Taspen::orderBy('nopen')->get()->mapWithKeys(fn($t) => [$t->id => $t->nopen.' - '.$t->name]),
                'provinces'=> Province::orderBy('name','DESC')->pluck('name','id'),
                'cities'=> [],
                'districts'=> [],
                'sub_districts'=> [],
                'service_units'=>ServiceUnit::orderBy('name','ASC')->pluck('name','id'),
                'branch_units'=> BranchUnit::whereServiceUnitId($application->service_unit_id)->orderBy('name','ASC')->pluck('name','id'),
                'marketings'=> User::whereBranchUnitId($application->branch_unit_id)->orderBy('id','ASC')->pluck('name','id'),
                'referral'=>Referral::orderBy('name','ASC')->pluck('name','id')
            ];

            return view('application.verification.view', $data);
        }else{
            return redirect('404');
        }
    }

    /**
     * get datatable.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function datatable(Request $request)
    {
        $data = Verification::dataTable($request);
        return datatables()->of($data)
        ->addColumn('action', function($row){
            $action = '<div class="text-center">
                    <a href="'.route('application.verification.show', $row->application_id).'" class="btn btn-info btn-sm btn-md"><i class="fas fa-eye"></i> Detail</a>
                </div>';
            // $action .= '<div class="text-center">
            //     <a href="'.route('application.slik.delete', $row->application_id).'" class="btn btn-danger btn-sm btn-md btn-delete btn-modal-delete"><i class="fas fa-trash"></i> Hapus</a>
            // </div>';
            return $action;
        })
        ->addColumn('status', function($row){

            $status = '<span class="badge badge-pill badge-primary">Antri</span>';
            if($row->status == 'on process'){
                $status = '<span class="badge badge-pill badge-info">Proses</span>';
            }
            if($row->status == 'reject'){
                $status = '<span class="badge badge-pill badge-danger">Ditolak</span>';
            }
            if($row->status == 'pending'){
                $status = '<span class="badge badge-pill badge-warning">Pending</span>';
            }
            if($row->status == 'approve'){
                $status = '<span class="badge badge-pill badge-success">Setuju</span>';
            }

            return $status;
        })
        ->addColumn('updated_at', function($row){
            return date("d-m-Y  H:i", strtotime($row->updated_at));
        })
        ->addIndexColumn()
        ->rawColumns(['action','status','updated_at'])
        ->make(true);
    }

    /**
     * get datatable.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approveReject(Request $request, $id)
    {
        $request->validate(['status' => 'required']);

        try {
            DB::beginTransaction();
            $user = \Auth::user();
            $data = Application::find($id);
            if($data){
                $verification                       = Verification::where('application_id', $id)->first();
                if(!$verification){
                    $verification = new Verification;
                }

                $verification->application_id       = $id;
                $verification->status               = $request->status;
                $verification->checked_by           = $user->id;
                $verification->checker_name         = $user->name;
                $verification->description          = $request->description;
                $verification->save();
                $data->verification_status = $request->status;
                $data->save();
            }
            DB::commit();
            return redirect()->route('application.verification.index')->withSuccess('Success');
        } catch (\Exceptions $e) {
            DB::rollback();
            return redirect()->back()->withInput($request->all())->withErrors($e->all());
        }
    }

    /**
     * Delete the specified data.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            if(check_access('pengajuan_slik','delete')  == true){
                Verification::whereApplicationId($id)->delete();
                DB::commit();
                session()->flash('message','Delete Successfully');
                return redirect()->route('application.verification.index');
            }else{
                return back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('message','Data cannot be deleted');
            return redirect()->route('application.verification.index');
        }
    }
}
