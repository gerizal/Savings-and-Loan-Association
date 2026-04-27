<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Taspen;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Domicile;
use App\Models\FamilyMember;
use App\Models\SubDistrict;
use App\Models\Product;
use App\Models\FinanceType;
use App\Models\Application;
use App\Models\BranchUnit;
use App\Models\Referral;
use App\Models\ServiceUnit;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Bank;
use App\Models\Slik;
use App\Models\Verification;
use App\Models\Approval;
use App\Models\Disbursement;
use App\Models\Document;

class ApplicationController extends Controller
{
    public function __construct(){
        $this->middleware('role.feature.check:pengajuan_slik,view', ['only' => ['index']]);
        $this->middleware('role.feature.check:pengajuan_slik,create', ['only' => ['create', 'store']]);
        $this->middleware('role.feature.check:pengajuan_slik,edit', ['only' => ['edit','update']]);
        $this->middleware('role.feature.check:pengajuan_slik,delete', ['only' => ['delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::select('id','name')->get();
        return view('application.loan.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $application = new Application;
        $application->simulation_date = date('d-m-Y');
        $data=[
            'data'   =>$application,
            'form' =>[
                'url'       => route('application.loan.store'),
                'method'    => 'POST',
                'files'     => true
            ],
            'products' => Product::select('id','name')->get()->pluck('name','id'),
            'types' => FinanceType::select('id','name')->get()->pluck('name','id'),
            'taspens' => Taspen::orderBy('nopen')->get()->mapWithKeys(fn($t) => [$t->id => $t->nopen.' - '.$t->name]),
            'provinces'=> Province::orderBy('name','DESC')->pluck('name','id'),
            'cities'=> [],
            'districts'=> [],
            'sub_districts'=> [],
            'service_units'=>ServiceUnit::orderBy('name','ASC')->pluck('name','id'),
            'branch_units'=> [],
            'marketings'=> [],
            'referral'=>Referral::orderBy('name','ASC')->pluck('name','id'),
            'mode'=>'create',
            'id'=>0,
        ];

        return view('application.loan.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'taspen_id'             => 'required',
            'product_id'            => 'required',
            'finance_type_id'       => 'required',
            'service_unit_id'       => 'required',
            'branch_unit_id'        => 'required',
            'id_number'             => 'required',
            'interest'              => 'required',
            // 'mutation_fee'          => 'required',
            'insurance_fee'         => 'required',
            'tenor'                 => 'required',
            'plafon'                => 'required',
            'administration_fee'    => 'required',
            // 'coop_fee' => 'required',
            // 'other_fee' => 'required',
            'management_fee'        => 'required',
            'stamp_fee'             => 'required',
            'account_opening_fee'   => 'required',
            // 'installment_fee' => 'required',
            // 'flagging_fee' => 'required',
            // 'epotpen_fee' => 'required',
            'provision_fee'         => 'required',
            'round_off'             => 'required',
            // 'is_flash' => 'required',
            // 'original_paymaster' => 'required',
            // 'destination_paymaster' => 'required',
            // 'previous_loan' => 'required',
            // 'bank_name' => 'required',
            // 'account_bank_number' => 'required',
            'marketing_id'          => 'required',
            'fronting_agent'        => 'required',
            'interest_type'         => 'required',
            'referral_id'           => 'required',
            'purpose'               => 'required',
            'installment'           =>'required',
            'salary'                =>'required'
        ];

        $personal_data_validator = [
            'id_number' => 'required',
            'name' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'gender' => 'required',
            'education' => 'required',
            'phone_number' => 'required',
            'religion' => 'required',
            'tax_number' => 'required',
            'mother_name' => 'required',
            'address' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'sub_district_id' => 'required',
            'district_id' => 'required',
            'city_id' => 'required',
            'province_id' => 'required',
            'post_code' => 'required',
            'geo_location' => 'required',
            'is_domicile' => 'required',
            'current_job' => 'required',
            'current_job_address' => 'required',
            'business_type' => 'required',
            'marital_status' => 'required',
            'nopen' => 'required',
            'employee_code' => 'required',
            // 'work_periode' => 'required',
            'employee_grade' => 'required',
            'skep_name' => 'required',
            'skep_number' => 'required',
            'guarantee_skep_date' => 'required',
            'guarantee_skep_publisher' => 'required',
            'retirement_type' => 'required',
            // 'participant_status' => 'required',
            // 'nipnrp' => 'required',
            // 'start_flagging' => 'required',
            // 'end_flagging' => 'required',
            'residential_status' => 'required',
            'occupied_at' => 'required',
        ];

        $spouse_validator = [
            'spouse_id_number' => 'required',
            'spouse_name' => 'required',
            'spouse_birth_place' => 'required',
            'spouse_birth_date' => 'required',
            'spouse_job' => 'required'
        ];

        $domicile_validator = [
            'domicile_address' => 'required',
            'domicile_rt' => 'required',
            'domicile_rw' => 'required',
            'domicile_sub_district_id' => 'required',
            'domicile_district_id' => 'required',
            'domicile_city_id' => 'required',
            'domicile_province_id' => 'required',
            'domicile_post_code' => 'required',
            'domicile_geo_location' => 'required'
        ];

        $allowance_validator = [
            'anak' => 'required',
            'istri' => 'required',
            'beras' => 'required',
            'cacat' => 'required',
            'dahor' => 'required',
            'alimentasi' => 'required',
            'askes' => 'required',
            'assos' => 'required',
            'ganti_rugi' => 'required',
            'kasda' => 'required',
            'kpkn' => 'required',
            'pph21' => 'required',
            'sewa_rumah' => 'required',
            'spn' => 'required'
        ];

        if(isset($request->marital_status)){
            if($request->marital_status=='Kawin'){
                $personal_data_validator = array_merge($personal_data_validator, $spouse_validator);
            }
        }

        if(isset($request->is_domicile)){
            if(intval($request->is_domicile)==0){
                $personal_data_validator = array_merge($personal_data_validator, $domicile_validator);
            }
        }

        $rules = array_merge($rules, $personal_data_validator);

        $validate = validator($request->all(), $rules);

        if($validate->fails()){
            \Log::info("application form request");
            \Log::info($request->all());
            \Log::info('application form error result');
            \Log::info($validate->errors());
            return redirect()->back()->withInput($request->all())->withErrors($validate->errors());
        }
        try {
            // Custom validation
            if(!$request->has('mutation_fee') || $request->mutation_fee == null){
                $request->mutation_fee = 0;
            }
            // end Custom validation

            DB::beginTransaction();
            $taspen_id = $request->taspen_id;
            if($request->taspen_id == $request->nopen){
                $taspen = Taspen::fromRequest($request, null);
                $taspen_id = $taspen->id;
            }else{
                $taspen = Taspen::fromRequest($request, $request->taspen_id);
                $taspen_id = $taspen->id;
            }
            $data = Application::fromRequest($request, $taspen_id);

            // PERBAIKAN: Tidak langsung membuat Slik, Verification, Approval, Disbursement
            // Hanya dibuat saat confirm/submit (method confirm)
            // Data disimpan dengan is_confirm = false untuk pelengkapan data oleh admin

            DB::commit();
            return redirect()->route('application.loan.index')->withSuccess('Data Berhasil disimpan. Silakan lengkapi data kemudian ajukan ke verifikasi.');
        } catch (\Exceptions $e) {
            DB::rollback();
            \Log::info('Error Loan',['data'=>$e->all()]);
            return redirect()->back()->withInput($request->all())->withErrors($e->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $application = Application::find($id);
        $marketing = User::find($application->marketing_id);
        if($marketing){
            $application->job_position = $marketing->job_title;
            $application->pkwt_status = $marketing->status_pkwt;
        }
        $product = Product::find($application->product_id);
        $bank = Bank::find($product->bank_id);
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
        $application->document = Document::whereDocumentId($application->id)->orderBy('id','ASC')->get();
        $application->documents = Document::whereDocumentId($application->id)->whereNotNull('url')->groupBy('type')->orderBy('id','DESC')->get();
        $domicile = Domicile::whereTaspenId($application->taspen_id)->first();

        $city = [];
        $districts=[];
        $sub_districts = [];
        if($domicile){
            $new_documents = new \stdClass();
            $new_documents->type='map';
            $new_documents->address = $domicile->address;
            $new_documents->latitude = $domicile->latitude;
            $new_documents->longitude = $domicile->longitude;
            $application->documents[] = $new_documents;

            $application->address = $domicile->address;
            $application->rt = $domicile->rt;
            $application->rw = $domicile->rw;
            $application->sub_district_id = $domicile->sub_district_id;
            $application->district_id = $domicile->district_id;
            $application->city_id = $domicile->city_id;
            $application->province_id = $domicile->province_id;
            $application->post_code = $domicile->post_code;
            $application->latitude = $domicile->latitude;
            $application->longitude = $domicile->longitude;

            $application->residential_status= $domicile->residential_status;
            $application->occupied_at = $domicile->occupied_at;
            $application->domicile_address = $domicile->address;
            $application->domicile_rt = $domicile->rt;
            $application->domicile_rw = $domicile->rw;
            $application->domicile_sub_district_id = $domicile->sub_district_id;
            $application->domicile_district_id = $domicile->district_id;
            $application->domicile_city_id = $domicile->city_id;
            $application->domicile_province_id = $domicile->province_id;
            $application->domicile_post_code = $domicile->post_code;
            $application->domicile_address_latitude = $domicile->latitude;
            $application->domicile_address_longitude = $domicile->longitude;
            $city = City::whereProvinceId($domicile->province_id)->get()->pluck('name','id');
            $districts=District::whereCityId($domicile->city_id)->get()->pluck('name','id');
            $sub_districts = SubDistrict::whereDistrictId($domicile->district_id)->get()->pluck('name','id');
        }
        if(count($application->document)>0){
            foreach ($application->document as $key => $value) {
                $value->url = generateSecureUrl($value->url);
                if($value->type == 'slik'){
                    $application->slik = $value->url;
                }
                if($value->type == 'application'){
                    $application->application = $value->url;
                }

                if($value->type == 'interview_video'){
                    $application->interview_video = $value->url;
                }

                if($value->type == 'insurance_video'){
                    $application->insurance_video = $value->url;
                }

            }
        }
        $taspen = Taspen::whereId($application->taspen_id)->first();
        $application->id_number = $taspen->id_number;
        $application->name = $taspen->name;
        $application->birth_place = $taspen->birth_place;
        $application->birth_date = date('d-m-Y',strtotime($taspen->birth_date));
        $application->gender = $taspen->gender;
        $application->education = $taspen->education;
        $application->phone_number = $taspen->phone_number;
        $application->religion = $taspen->religion;
        $application->tax_number = $taspen->tax_number;
        $application->mother_name = $taspen->mother_name;
        $application->address = $taspen->address;
        $application->rt = $taspen->rt;
        $application->rw = $taspen->rw;
        $application->sub_district_id = $taspen->sub_district_id;
        $application->district_id = $taspen->district_id;
        $application->city_id = $taspen->city_id;
        $application->province_id = $taspen->province_id;
        $application->post_code = $taspen->post_code;
        $application->is_domicile = $taspen->is_domicile;
        $application->current_job = $taspen->current_job;
        $application->current_job_address = $taspen->current_job_address;
        $application->business_type = $taspen->business_type;
        $application->marital_status = $taspen->marital_status;
        $application->nopen = $taspen->nopen;
        $application->employee_code = $taspen->employee_code;
        $application->work_periode = $taspen->work_periode;
        $application->employee_grade = $taspen->employee_grade;
        $application->skep_name = $taspen->skep_name;
        $application->skep_number = $taspen->skep_number;
        $application->skep_date = date('d-m-Y',strtotime($taspen->skep_date));
        $application->guarantee_skep_date = date('d-m-Y',strtotime($taspen->skep_date));
        $application->skep_publisher = $taspen->skep_publisher;
        $application->guarantee_skep_publisher = $taspen->skep_publisher;
        $application->retirement_type = $taspen->retirement_type;
        $application->participant_status = $taspen->participant_status;
        $application->nipnrp = $taspen->nipnrp;
        $application->start_flagging = $taspen->start_flagging;
        $application->end_flagging = $taspen->end_flagging;
        $application->address_latitude     = $taspen->latitude;
        $application->address_longitude    = $taspen->longitude;
        $family_member=FamilyMember::whereTaspenId($application->taspen_id)->whereRelationStatus('spouse')->first();
        if( $family_member){
            $application->spouse_id_number = $family_member->id_number;
            $application->spouse_name = $family_member->name;
            $application->spouse_birth_place = $family_member->birth_place;
            $application->spouse_birth_date = date('d-m-Y',strtotime($family_member->birth_date));
            $application->spouse_job = $family_member->occupation;
            $application->relation_status = 'spouse';
        }

        $data=[
            'data'   =>$application,
            'form' =>[
                'url'       => route('application.loan.confirm',$application),
                'method'    => 'POST',
                'files'     => true,
                'id'        =>'form-loan'
            ],
            'products' => Product::select('id','name')->get()->pluck('name','id'),
            'types' => FinanceType::select('id','name')->get()->pluck('name','id'),
            'taspens' => Taspen::orderBy('nopen')->get()->mapWithKeys(fn($t) => [$t->id => $t->nopen.' - '.$t->name]),
            'provinces'=> Province::orderBy('name','DESC')->pluck('name','id'),
            'cities'=> $city,
            'districts'=> $districts,
            'sub_districts'=> $sub_districts,
            'service_units'=>ServiceUnit::orderBy('name','ASC')->pluck('name','id'),
            'branch_units'=> BranchUnit::whereServiceUnitId($application->service_unit_id)->orderBy('name','ASC')->pluck('name','id'),
            'marketings'=> User::whereBranchUnitId($application->branch_unit_id)->orderBy('id','ASC')->pluck('name','id'),
            'referral'=>Referral::orderBy('name','ASC')->pluck('name','id'),
            'update_url'=>route('application.loan.update', $application),
            'confirm_url'=>route('application.loan.confirm',$application),
            'mode'=>'view',
            'id'=>0,
        ];
        return view('application.loan.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $application = Application::find($id);
        $marketing = User::find($application->marketing_id);
        if($marketing){
            $application->job_position = $marketing->job_title;
            $application->pkwt_status = $marketing->status_pkwt;
        }
        $product = Product::find($application->product_id);
        $bank = Bank::find($product->bank_id);
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
        $application->document = Document::whereDocumentId($application->id)->orderBy('id','ASC')->get();
        $application->documents = Document::whereDocumentId($application->id)->whereNotNull('url')->groupBy('type')->orderBy('id','DESC')->get();
        $domicile = Domicile::whereTaspenId($application->taspen_id)->first();
        $city = [];
        $districts=[];
        $sub_districts = [];
        if($domicile){
            $new_documents = new \stdClass();
            $new_documents->type='map';
            $new_documents->address = $domicile->address;
            $new_documents->latitude = $domicile->latitude;
            $new_documents->longitude = $domicile->longitude;
            $application->documents[] = $new_documents;
            $application->address = $domicile->address;
            $application->rt = $domicile->rt;
            $application->rw = $domicile->rw;
            $application->sub_district_id = $domicile->sub_district_id;
            $application->district_id = $domicile->district_id;
            $application->city_id = $domicile->city_id;
            $application->province_id = $domicile->province_id;
            $application->post_code = $domicile->post_code;
            $application->latitude = $domicile->latitude;
            $application->longitude = $domicile->longitude;

            $application->residential_status= $domicile->residential_status;
            $application->occupied_at = $domicile->occupied_at;
            $application->domicile_address = $domicile->address;
            $application->domicile_rt = $domicile->rt;
            $application->domicile_rw = $domicile->rw;
            $application->domicile_sub_district_id = $domicile->sub_district_id;
            $application->domicile_district_id = $domicile->district_id;
            $application->domicile_city_id = $domicile->city_id;
            $application->domicile_province_id = $domicile->province_id;
            $application->domicile_post_code = $domicile->post_code;
            $application->domicile_address_latitude = $domicile->latitude;
            $application->domicile_address_longitude = $domicile->longitude;
            $city = City::whereProvinceId($domicile->province_id)->get()->pluck('name','id');
            $districts=District::whereCityId($domicile->city_id)->get()->pluck('name','id');
            $sub_districts = SubDistrict::whereDistrictId($domicile->district_id)->get()->pluck('name','id');
        }
        if(count($application->document)>0){
            foreach ($application->document as $key => $value) {
                $value->url = generateSecureUrl($value->url);
                if($value->type == 'slik'){
                    $application->slik = $value->url;
                }
                if($value->type == 'application'){
                    $application->application = $value->url;
                }

                if($value->type == 'interview_video'){
                    $application->interview_video = $value->url;
                }

                if($value->type == 'insurance_video'){
                    $application->insurance_video = $value->url;
                }

            }
        }
        $taspen = Taspen::whereId($application->taspen_id)->first();
        $application->id_number = $taspen->id_number;
        $application->name = $taspen->name;
        $application->birth_place = $taspen->birth_place;
        $application->birth_date = date('d-m-Y',strtotime($taspen->birth_date));
        $application->gender = $taspen->gender;
        $application->education = $taspen->education;
        $application->phone_number = $taspen->phone_number;
        $application->religion = $taspen->religion;
        $application->tax_number = $taspen->tax_number;
        $application->mother_name = $taspen->mother_name;
        $application->address = $taspen->address;
        $application->rt = $taspen->rt;
        $application->rw = $taspen->rw;
        $application->sub_district_id = $taspen->sub_district_id;
        $application->district_id = $taspen->district_id;
        $application->city_id = $taspen->city_id;
        $application->province_id = $taspen->province_id;
        $application->post_code = $taspen->post_code;
        $application->is_domicile = $taspen->is_domicile;
        $application->current_job = $taspen->current_job;
        $application->current_job_address = $taspen->current_job_address;
        $application->business_type = $taspen->business_type;
        $application->marital_status = $taspen->marital_status;
        $application->nopen = $taspen->nopen;
        $application->employee_code = $taspen->employee_code;
        $application->work_periode = $taspen->work_periode;
        $application->employee_grade = $taspen->employee_grade;
        $application->skep_name = $taspen->skep_name;
        $application->skep_number = $taspen->skep_number;
        $application->skep_date = date('d-m-Y',strtotime($taspen->skep_date));
        $application->guarantee_skep_date = date('d-m-Y',strtotime($taspen->skep_date));
        $application->skep_publisher = $taspen->skep_publisher;
        $application->guarantee_skep_publisher = $taspen->skep_publisher;
        $application->retirement_type = $taspen->retirement_type;
        $application->participant_status = $taspen->participant_status;
        $application->nipnrp = $taspen->nipnrp;
        $application->start_flagging = $taspen->start_flagging;
        $application->end_flagging = $taspen->end_flagging;
        $application->address_latitude     = $taspen->latitude;
        $application->address_longitude    = $taspen->longitude;
        $family_member=FamilyMember::whereTaspenId($application->taspen_id)->whereRelationStatus('spouse')->first();
        if( $family_member){
            $application->spouse_id_number = $family_member->id_number;
            $application->spouse_name = $family_member->name;
            $application->spouse_birth_place = $family_member->birth_place;
            $application->spouse_birth_date = date('d-m-Y',strtotime($family_member->birth_date));
            $application->spouse_job = $family_member->occupation;
            $application->relation_status = 'spouse';
        }
        $data=[
            'data'   =>$application,
            'form' =>[
                'url'       => route('application.loan.update', $application->id),
                'method'    => 'PUT',
                'files'     => true,
                'id'        =>'form-loan'
            ],
            'products' => Product::select('id','name')->get()->pluck('name','id'),
            'types' => FinanceType::select('id','name')->get()->pluck('name','id'),
            'taspens' => Taspen::orderBy('nopen')->get()->mapWithKeys(fn($t) => [$t->id => $t->nopen.' - '.$t->name]),
            'provinces'=> Province::orderBy('name','DESC')->pluck('name','id'),
            'cities'=> $city,
            'districts'=> $districts,
            'sub_districts'=> $sub_districts,
            'service_units'=>ServiceUnit::orderBy('name','ASC')->pluck('name','id'),
            'branch_units'=> BranchUnit::whereServiceUnitId($application->service_unit_id)->orderBy('name','ASC')->pluck('name','id'),
            'marketings'=> User::whereBranchUnitId($application->branch_unit_id)->orderBy('id','ASC')->pluck('name','id'),
            'referral'=>Referral::orderBy('name','ASC')->pluck('name','id'),
            'update_url'=>route('application.loan.update', $application),
            'confirm_url'=>route('application.loan.confirm',$application),
            'mode'=>'edit',
            'id'=>$id
        ];

        return view('application.loan.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // \Log::info('UPDATE',['DATA'=>$request->all()]);
        $rules = [
            'taspen_id' => 'required',
            'product_id' => 'required',
            'finance_type_id' => 'required',
            'service_unit_id' => 'required',
            'branch_unit_id' => 'required',
            'id_number' => 'required',
            'interest' => 'required',
            'mutation_fee' => 'required',
            'insurance_fee' => 'required',
            'tenor' => 'required',
            'plafon' => 'required',
            'administration_fee' => 'required',
            // 'coop_fee' => 'required',
            // 'other_fee' => 'required',
            'management_fee' => 'required',
            'stamp_fee' => 'required',
            'account_opening_fee' => 'required',
            // 'installment_fee' => 'required',
            // 'flagging_fee' => 'required',
            // 'epotpen_fee' => 'required',
            'provision_fee' => 'required',
            'round_off' => 'required',
            // 'is_flash' => 'required',
            // 'original_paymaster' => 'required',
            // 'destination_paymaster' => 'required',
            // 'previous_loan' => 'required',
            // 'bank_name' => 'required',
            // 'account_bank_number' => 'required',
            'marketing_id' => 'required',
            'fronting_agent' => 'required',
            'interest_type' => 'required',
            'referral_id' => 'required',
            'purpose' => 'required',
            'installment'=>'required',
            'salary'=>'required'
        ];

        $personal_data_validator = [
            'id_number' => 'required',
            'name' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'gender' => 'required',
            'education' => 'required',
            'phone_number' => 'required',
            'religion' => 'required',
            'tax_number' => 'required',
            'mother_name' => 'required',
            'address' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'sub_district_id' => 'required',
            'district_id' => 'required',
            'city_id' => 'required',
            'province_id' => 'required',
            'post_code' => 'required',
            'geo_location' => 'required',
            'is_domicile' => 'required',
            'current_job' => 'required',
            'current_job_address' => 'required',
            'business_type' => 'required',
            'marital_status' => 'required',
            'nopen' => 'required',
            'employee_code' => 'required',
            // 'work_periode' => 'required',
            'employee_grade' => 'required',
            'skep_name' => 'required',
            'skep_number' => 'required',
            'guarantee_skep_date' => 'required',
            'guarantee_skep_publisher' => 'required',
            'retirement_type' => 'required',
            // 'participant_status' => 'required',
            // 'nipnrp' => 'required',
            // 'start_flagging' => 'required',
            // 'end_flagging' => 'required',
            'residential_status' => 'required',
            'occupied_at' => 'required',
        ];

        $spouse_validator = [
            'spouse_id_number' => 'required',
            'spouse_name' => 'required',
            'spouse_birth_place' => 'required',
            'spouse_birth_date' => 'required',
            'spouse_job' => 'required'
        ];

        $domicile_validator = [
            'domicile_address' => 'required',
            'domicile_rt' => 'required',
            'domicile_rw' => 'required',
            'domicile_sub_district_id' => 'required',
            'domicile_district_id' => 'required',
            'domicile_city_id' => 'required',
            'domicile_province_id' => 'required',
            'domicile_post_code' => 'required',
            'domicile_geo_location' => 'required'
        ];

        $allowance_validator = [
            'anak' => 'required',
            'istri' => 'required',
            'beras' => 'required',
            'cacat' => 'required',
            'dahor' => 'required',
            'alimentasi' => 'required',
            'askes' => 'required',
            'assos' => 'required',
            'ganti_rugi' => 'required',
            'kasda' => 'required',
            'kpkn' => 'required',
            'pph21' => 'required',
            'sewa_rumah' => 'required',
            'spn' => 'required'
        ];

        if(isset($request->marital_status)){
            if($request->marital_status=='Kawin'){
                $personal_data_validator = array_merge($personal_data_validator, $spouse_validator);
            }
        }

        if(isset($request->is_domicile)){
            if(intval($request->is_domicile)==0){
                $personal_data_validator = array_merge($personal_data_validator, $domicile_validator);
            }
        }

        $rules = array_merge($rules, $personal_data_validator);

        $validate = validator($request->all(), $rules);

        if($validate->fails()){
            return redirect()->back()->withInput($request->all())->withErrors($validate->errors());
        }
        try {
            DB::beginTransaction();
            $data = Application::updateFromRequest($request, $id);
            if($request->taspen_id == $request->nopen){

                \Log::info('Create Taspen');
                $taspen = Taspen::fromRequest($request, null);
            }else{
                \Log::info('Update Taspen');
                $taspen = Taspen::fromRequest($request, $request->taspen_id);
            }
            DB::commit();
            return redirect()->route('application.loan.index')->withSuccess('Data Berhasil diperbaharui');
        } catch (\Exceptions $e) {
            DB::rollback();
            return \redirect()->back()->withInput($request->all())->withErrors($e->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            if(check_access('pengajuan_slik','delete')  == true){
                Application::find($id)->delete();
                Slik::whereApplicationId($id)->delete();
                Verification::whereApplicationId($id)->first();
                Approval::whereApplicationId($id)->first();
                Disbursement::whereApplicationId($id)->first();
                DB::commit();
                return redirect()->route('application.loan.index')->withSuccess('Data Berhasil dihapus');
            }else{
                return back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('application.loan.index')->withErrors('Data tidak bisa dihapus');
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
        $data = Application::dataTable($request);
        return datatables()->of($data)
        ->addColumn('action', function($row){
            $action = '<div class="text-center">
                    <a href="'.route('application.loan.show', $row->id).'" class="btn btn-info btn-sm btn-md"><i class="fas fa-eye"></i> Detail</a>
                </div>';
            $action .= '<div class="text-center">
                    <a href="'.route('application.loan.edit', $row->id).'" class="btn btn-info btn-sm btn-md"><i class="fas fa-edit"></i> Edit</a>
                </div>';

            // Tambahkan tombol "Ajukan ke Verifikasi" jika belum di-confirm
            if(!$row->is_confirm){
                $action .= '<div class="text-center">
                    <form action="'.route('application.loan.confirm', $row->id).'" method="POST" style="display:inline;">
                        '.csrf_field().'
                        <button type="submit" class="btn btn-success btn-sm btn-md" onclick="return confirm(\'Apakah Anda yakin ingin mengajukan data ini ke verifikasi?\')"><i class="fas fa-paper-plane"></i> Ajukan ke Verifikasi</button>
                    </form>
                </div>';
            }

            $action .= '<div class="text-center">
                <a href="'.route('application.loan.destroy', $row->id).'" class="btn btn-danger btn-sm btn-md btn-delete btn-modal-delete"><i class="fas fa-trash"></i> Hapus</a>
            </div>';
            return $action;
        })
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    /**
     * Confirm Application.
     * Mengajukan pengajuan ke proses verifikasi
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm(Request $request, $id)
    {
        // \Log::info('Request',['data'=>$request->all()]);
        try {
            $user = \Auth::user();
            DB::beginTransaction();
            $data = Application::find($id);
            if($data){
                // Cek apakah sudah pernah di-confirm
                if($data->is_confirm){
                    DB::rollback();
                    return redirect()->route('application.loan.index')->withErrors('Pengajuan sudah pernah diajukan ke verifikasi.');
                }

                // Buat record Slik dengan status queue
                $slik                       = Slik::whereApplicationId($data->id)->first();
                if(!$slik){
                    $slik                   = new Slik;
                    $slik->status               = 'queue';
                }
                $slik->application_id  = $data->id;
                $slik->save();

                // Buat record Verification dengan status queue
                $verification                       = Verification::whereApplicationId($data->id)->first();
                if(!$verification){
                    $verification                   = new Verification;
                    $verification->status               = 'queue';
                }
                $verification->application_id  = $data->id;
                $verification->save();

                // Buat record Approval
                $approval                       = Approval::whereApplicationId($data->id)->first();
                if(!$approval){
                    $approval                   = new Approval;
                }
                $approval->application_id       = $data->id;
                $approval->save();

                // Buat record Disbursement
                $disbursement                       = Disbursement::whereApplicationId($data->id)->first();
                if(!$disbursement){
                    $disbursement                   = new Disbursement;
                }
                $disbursement->application_id       = $data->id;
                $disbursement->save();

                // Set is_confirm menjadi true
                $data->is_confirm = true;
                $data->save();
            }
            DB::commit();
            return redirect()->route('application.loan.index')->withSuccess('Pengajuan berhasil diajukan ke proses verifikasi.');
        } catch (\Exceptions $e) {
            \Log::info('ERROR CONFIRM',['data'=>$e->all()]);
            DB::rollback();
            return redirect()->back()->withInput($request->all())->withErrors($e->all());
        }
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
            $data = Application::find($id);
            if($data){
                $slik                       = Slik::where('application_id', $id)->first();
                if($slik){
                    $slik->status               = $request->status;
                    $slik->checked_by           = \Auth::id();
                    $slik->description          = $request->description;
                    $slik->save();
                }
            }
            DB::commit();
            return redirect()->route('application.loan.index')->withSuccess('Success');
        } catch (\Exceptions $e) {
            DB::rollback();
            return redirect()->back()->withInput($request->all())->withErrors($e->all());
        }
    }
}
