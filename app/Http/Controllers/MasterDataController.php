<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\SubDistrict;
use App\Models\BranchUnit;
use App\Models\ServiceUnit;
use App\Models\User;

class MasterDataController extends Controller
{
    public function provinces(Request $request){
        $data = Province::orderBy('id','ASC')->get();
        return response()->json($data, 200);

    }

    public function cities(Request $request){
        $data = City::orderBy('id','ASC');
        if(isset($request->province_id)){
            $data = $data->whereProvinceId($request->province_id);
        }
        $data = $data->get();
        return response()->json($data, 200);
    }

    public function districts(Request $request){
        $data = District::orderBy('id','ASC');
        if(isset($request->city_id)){
            $data = $data->whereCityId($request->city_id);
        }
        $data = $data->get();
        return response()->json($data, 200);

    }

    public function subDistricts(Request $request){
        $data = SubDistrict::orderBy('id','ASC');
        if(isset($request->district_id)){
            $data = $data->whereDistrictId($request->district_id);
        }
        $data = $data->skip(0)->take(100)->get();
        return response()->json($data, 200);

    }

    public function branchUnit(Request $request){
        $data = BranchUnit::orderBy('id','ASC');
        if(isset($request->service_unit_id)){
            $data = $data->whereServiceUnitId($request->service_unit_id);
        }
        $data = $data->get();
        return response()->json($data, 200);
    }

    public function marketing(Request $request){
        $data = User::select('id','name','job_title','status_pkwt')->whereNotNull('branch_unit_id')->orderBy('id','ASC')->whereBranchUnitId($request->branch_unit_id)->get();
        return response()->json($data, 200);
    }
}
