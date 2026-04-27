<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Taspen;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Domicile;
use App\Models\FamilyMember;
use App\Models\Product;
use App\Models\SubDistrict;
use Illuminate\Support\Facades\DB;
use App\Models\Application;

class TaspenController extends Controller
{
    public function __construct(){
        $this->middleware('role.feature.check:master_data_taspen,view', ['only' => ['index']]);
        $this->middleware('role.feature.check:master_data_taspen,create', ['only' => ['create', 'store']]);
        $this->middleware('role.feature.check:master_data_taspen,edit', ['only' => ['edit','update']]);
        $this->middleware('role.feature.check:master_data_taspen,delete', ['only' => ['delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master-data.taspen.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=[
            'data'  =>new Taspen,
            'form'  =>[
                'url'       => route('master-data.taspen.store'),
                'method'    => 'POST',
                'files'     => true
            ],
            'provinces'=> Province::orderBy('name','DESC')->pluck('name','id'),
            'cities'=> [],
            'districts'=> [],
            'sub_districts'=> []
        ];

        return view('master-data.taspen.form', $data);
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
            'skep_date' => 'required',
            'skep_publisher' => 'required',
            'retirement_type' => 'required',
            'participant_status' => 'required',
            'nipnrp' => 'required',
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
            'domicile_post_code' => 'required'
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
                $rules = array_merge($rules, $spouse_validator);
            }
        }

        if(isset($request->is_domicile)){
            if(intval($request->is_domicile)==0){
                $rules = array_merge($rules, $domicile_validator);
            }
        }

        $validate = validator($request->all(), $rules);
        if($validate->fails()){
            return redirect()->back()->withInput($request->all())->withErrors($validate->errors());
        }
        try {
            DB::beginTransaction();
            Taspen::fromRequest($request, null);
            DB::commit();
            return redirect()->route('master-data.taspen.index')->withSuccess('Data Berhasil disimpan');
        } catch (\Exceptions $e) {
            DB::rollback();
            return \redirect()->back()->withInput($request->all())->withErrors($e->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $taspen = Taspen::find($id);
        $taspen->address_longitude = $taspen->longitude;
        $taspen->address_latitude = $taspen->latitude;
        if($taspen->address_latitude && $taspen->address_longitude) {
            $taspen->geo_location = "$taspen->address_latitude,$taspen->address_longitude";
        }
        $spouse = FamilyMember::whereTaspenId($id)->whereRelationStatus('spouse')->first();
        $domicile = Domicile::whereTaspenId($id)->first();
        if($spouse){
            $taspen->spouse_id_number = $spouse->id_number;
            $taspen->spouse_name = $spouse->name;
            $taspen->spouse_birth_place = $spouse->birth_place;
            $taspen->spouse_birth_date = date('d-m-Y',strtotime($spouse->birth_date));
            $taspen->spouse_job = $spouse->occupation;
        }

        if($domicile){
            $taspen->residential_status = $domicile->residential_status;
            $taspen->occupied_at = $domicile->occupied_at;
            if(!isset($taspen->is_domicile) || $taspen->is_domicile==0){
                $taspen->domicile_address = $domicile->address;
                $taspen->domicile_rt = $domicile->rt;
                $taspen->domicile_rw = $domicile->rw;
                $taspen->domicile_sub_district_id = $domicile->sub_district_id;
                $taspen->domicile_district_id = $domicile->district_id;
                $taspen->domicile_city_id = $domicile->city_id;
                $taspen->domicile_province_id = $domicile->province_id;
                $taspen->domicile_post_code = $domicile->post_code;
                $taspen->domicile_address_longitude = $domicile->longitude;
                $taspen->domicile_address_latitude = $domicile->latitude;
                if($taspen->domicile_address_latitude && $taspen->domicile_address_longitude) {
                    $taspen->domicile_geo_location = "$taspen->domicile_address_latitude,$taspen->domicile_address_longitude";
                }
            }
        }

        $data=[
            'data'      => $taspen,
            'form' =>[
                'url'       => route('master-data.taspen.update', $id),
                'method'    => 'PUT',
                'files'     => true
            ],
            'provinces'=> Province::orderBy('name','DESC')->pluck('name','id'),
            'cities'=> City::whereProvinceId($taspen->province_id)->orderBy('name','DESC')->pluck('name','id'),
            'districts'=> District::whereCityId($taspen->city_id)->orderBy('name','DESC')->pluck('name','id'),
            'sub_districts'=> SubDistrict::whereDistrictId($taspen->district_id)->orderBy('name','DESC')->pluck('name','id')
        ];
        return view('master-data.taspen.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
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
            // 'is_domicile' => 'required',
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
            'skep_date' => 'required',
            'skep_publisher' => 'required',
            'retirement_type' => 'required',
            'participant_status' => 'required',
            'nipnrp' => 'required',
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
            'domicile_post_code' => 'required'
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
                $rules = array_merge($rules, $spouse_validator);
            }
        }

        if(isset($request->is_domicile)){
            if(intval($request->is_domicile)==0){
                $rules = array_merge($rules, $domicile_validator);
            }
        }

        $validate = validator($request->all(), $rules);

        if($validate->fails()){
            return redirect()->back()->withInput($request->all())->withErrors($validate->errors());
        }
        try {
            DB::beginTransaction();
            $data = Taspen::fromRequest($request, $id);
            DB::commit();
            return redirect()->route('master-data.taspen.index')->withSuccess('Data Berhasil diperbaharui');
        } catch (\Exceptions $e) {
            DB::rollback();
            return \redirect()->back()->withInput($request->all())->withErrors($e->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $data = Taspen::find($id);
            if($data){
                $data->delete();
                DB::commit();
                return redirect()->route('master-data.taspen.index')->withSuccess('Data Berhasil dihapus');
            }
            return redirect()->route('master-data.taspen.index')->withErrors('error', 'Data Tidak Ditemukan');
        } catch (\Exceptions $e) {
            DB::rollback();
            return \redirect()->back()->withInput($request->all())->withErrors($e->all());
        }
    }

    /**
     * get datatable.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        $model = Taspen::all();

        return datatables()->of($model)
        ->addColumn('action', function($row){
            $action = '<div class="text-center">
                    <a href="'.route('master-data.taspen.edit', $row->id).'" class="btn btn-warning btn-sm btn-md"><i class="fas fa-edit"></i> Edit</a>
                    <a href="'.route('master-data.taspen.destroy', $row->id).'" class="btn btn-danger  btn-sm btn-md btn-modal-delete"><i class="fas fa-trash"></i> Hapus</a>
                </div>';
            return $action;
        })
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        $activeLoan = false;
        // if($request->type=='check'){
        //     $activeLoan = Application::whereTaspenId($request->id)->whereIsPaid(0)->first();
        // }

        $activeLoan = false;

        if($activeLoan){
            return response()->json(
                [
                    'status'=>'error',
                    'message'=>'User ini masih memiliki pinjaman aktif, Silahkan lunasi terlebih dahulu',
                    'data'=>[]
                ]
            );
        }else{
            if($request->has('byNopen'))
            {
                $taspen = Taspen::whereNopen($request->nopen)->first();
            }else{
                $taspen = Taspen::whereId($request->id)->first();
            }
            if($taspen){
                $taspen->domicile = Domicile::whereTaspenId($taspen->id)->first();
                $taspen->spouse = FamilyMember::whereTaspenId($taspen->id)->whereRelationStatus('spouse')->first();
                $taspen->birth_date_formated = date('d-m-Y',strtotime($taspen->birth_date));
                $taspen->skep_date_formated = date('d-m-Y',strtotime($taspen->skep_date));
                
                if($taspen->latitude && $taspen->longitude) {
                    $taspen->geo_location = "$taspen->latitude,$taspen->longitude";
                }

                if($taspen->domicile){
                    if($taspen->domicile->latitude && $taspen->domicile->longitude) {
                        $taspen->domicile->geo_location = ($taspen->domicile->latitude.",".$taspen->domicile->longitude);
                    }
                }
            }
            return response()->json(
                [
                    'status'=>'success',
                    'data'=>$taspen
                ]
            );
        }
    }
}
