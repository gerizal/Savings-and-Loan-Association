<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\BranchUnit;
use App\Models\ServiceUnit;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BusinessDataController extends Controller
{
    public function __construct(){
        $this->middleware('role.feature.check:data_bisnis,view', ['only' => ['index']]);
    }
    public function index(){
        $service_areas = ServiceUnit::select('id','name')->get();
        return view('business-data.index', compact('service_areas'));
    }

    public function dataTable(Request $request){
        $status = ['approve'];
        if(isset($request->status)){
            $status=$request->status;
        }
        $data = BranchUnit::select('branch_units.id','branch_units.name',DB::raw("CONCAT('Rp ',FORMAT(SUM(applications.plafon), 2,'id_ID')) as plafond"), DB::raw('COUNT(applications.id) as noa'))
        ->leftjoin('applications','applications.branch_unit_id','=','branch_units.id')
        ->whereIn('disbursement_status',$status);
        if(isset($request->service_id)){
            if($request->service_id!=''){
                $data = $data->where('branch_units.service_unit_id', $request->service_id);
            }
        }
        if(isset($request->start_date) && isset($request->end_date)){
            if($request->start_date != '' && $request->end_date != ''){
                $data = $data->whereDate('applications.created_at','>=', $request->start_date)->whereDate('applications.created_at','<=', $request->end_date);
            }
        }


        $user = \Auth::user();
        $user_role = user_role();
        if($user_role){
            if($user_role->slug=='approval' || $user_role->slug=='bank'){
                $data = $data->where('applications.bank_id', $user->bank_id);
            }
        }
        $data = $data->groupBy('branch_units.id');
        return datatables()->of($data)->make(true);

    }
    public function dataTableMarketing(Request $request){
        $status = ['approve'];
        if(isset($request->status)){
            $status=$request->status;
        }
        $data = User::select('users.id','users.name as name',DB::raw("CONCAT('Rp ',FORMAT(SUM(applications.plafon), 2,'id_ID')) as plafond"), DB::raw('COUNT(applications.id) as noa'))
        ->leftJoin('applications','applications.marketing_id','=','users.id')
        ->where('users.branch_unit_id', $request->branch_id)
        ->whereIn('disbursement_status',$status);
        if(isset($request->start_date) && isset($request->end_date)){
            if($request->start_date != '' && $request->end_date != ''){
                $data = $data->whereDate('applications.created_at','>=', $request->start_date)->whereDate('applications.created_at','<=', $request->end_date);
            }
        }


        $user = \Auth::user();
        $user_role = user_role();
        if($user_role){
            if($user_role->slug=='approval' || $user_role->slug=='bank'){
                $data = $data->where('applications.bank_id', $user->bank_id);
            }
        }
        $data = $data->groupBy('applications.marketing_id');
        return datatables()->of($data)->make(true);

    }
    public function dataTableDebitur(Request $request){
        $status = ['approve'];
        if(isset($request->status)){
            $status=$request->status;
        }
        $data = Application::select(DB::raw("CONCAT('Rp ',FORMAT(applications.plafon, 2,'id_ID')) as plafond"),'applications.tenor','taspens.name','taspens.nopen','banks.name as bank_name')
        ->join('taspens','taspens.id','=','applications.taspen_id')
        ->join('banks','banks.id','applications.bank_id')
        ->whereMarketingId($request->marketing_id)
        ->whereIn('disbursement_status',$status);
        if(isset($request->start_date) && isset($request->end_date)){
            if($request->start_date != '' && $request->end_date != ''){
                $data = $data->whereDate('applications.created_at','>=', $request->start_date)->whereDate('applications.created_at','<=', $request->end_date);
            }
        }


        $user = \Auth::user();
        $user_role = user_role();
        if($user_role){
            if($user_role->slug=='approval' || $user_role->slug=='bank'){
                $data = $data->where('applications.bank_id', $user->bank_id);
            }
        }
        return datatables()->of($data)->make(true);
    }
}
