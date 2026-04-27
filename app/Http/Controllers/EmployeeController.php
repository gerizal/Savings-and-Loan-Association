<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\BranchUnit;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function __construct(){
        $this->middleware('role.feature.check:master_data_karyawan,view', ['only' => ['index']]);
        $this->middleware('role.feature.check:master_data_karyawan,create', ['only' => ['create', 'store']]);
        $this->middleware('role.feature.check:master_data_karyawan,edit', ['only' => ['edit','update']]);
        $this->middleware('role.feature.check:master_data_karyawan,delete', ['only' => ['delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master-data.employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=[
            'data'   =>new Employee,
            'form' =>[
                'url'       => route('master-data.employee.store'),
                'method'    => 'POST',
                'files'     => true
            ],
            'branch_unit'=>BranchUnit::select('id','name')->get()->pluck('name','id'),
            'roles'=>Role::select('id','name')->get()->pluck('name','id')
        ];

        return view('master-data.employee.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = validator($request->all(), [
            'employee_id' => 'required|numeric',
            'id_number' => 'required|numeric',
            'first_name' => 'required',
            'last_name' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'address' => 'required',
            'phone_number' => 'required|numeric',
            'password' => 'required',
            'role_id' => 'required',
            'job_title' => 'required',
            'status_pkwt' => 'required',
            'masa_kontrak' => 'required',
            'target' => 'required',
            'branch_unit_id' => 'required|numeric',
        ]);
        \Log::info('REQUEST',['data'=>$request->all()]);
        if($validate->fails()){
            \Log::info('Validation',['data'=>$validate->errors()]);
            return redirect()->back()->withInput($request->all())->withErrors($validate->errors());
        }
        try {
            DB::beginTransaction();
            $data = Employee::fromRequest($request, null);
            DB::commit();
            return redirect()->route('master-data.employee.index')->withSuccess('Data Berhasil disimpan');
        } catch (\Exceptions $e) {
            DB::rollback();
            \Log::info('Error',['data'=>$e->all()]);
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
        $user = Employee::find($id);
        $branch_unit=BranchUnit::select('id','name')->get()->pluck('name','id');
        $roles=Role::select('id','name')->get()->pluck('name','id');
        return view('master-data.employee.view',['data'=>$user, 'branch_unit'=>$branch_unit, 'roles'=>$roles]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Employee::find($id);
        $data->masa_kontrak = $data->contract_term;
        $data->password = '';
        $user_role = UserRole::where('user_id', $data->id)->first();
        $data->role_id = $user_role ? $user_role->role_id:null;
        $data=[
            'data'      => $data,
            'form' =>[
                'url'       => route('master-data.employee.update', $id),
                'method'    => 'PUT',
                'files'     => true
            ],
            'branch_unit'=>BranchUnit::select('id','name')->get()->pluck('name','id'),
            'roles'=>Role::select('id','name')->get()->pluck('name','id')
        ];

        return view('master-data.employee.form', $data);
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
        $validate = validator($request->all(), [
            'employee_id' => 'required|numeric',
            'id_number' => 'required|numeric',
            'first_name' => 'required',
            'last_name' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'address' => 'required',
            'phone_number' => 'required|numeric',
            'role_id' => 'required',
            'job_title' => 'required',
            'status_pkwt' => 'required',
            'masa_kontrak' => 'required',
            'target' => 'required',
            'branch_unit_id' => 'required|numeric',
        ]);

        if($validate->fails()){
            \Log::info('Validation',['data'=>$validate->errors()]);
            return redirect()->back()->withInput($request->all())->withErrors($validate->errors());
        }
        try {
            DB::beginTransaction();
            $data = Employee::fromRequest($request, $id);
            DB::commit();
            return redirect()->route('master-data.employee.index')->withSuccess('Data Berhasil diperbaharui');
        } catch (\Exceptions $e) {
            DB::rollback();
            \Log::info('Error',['data'=>$e->all()]);
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
            $data = Employee::find($id);
            if($data){
                $data->delete();
                DB::commit();
                return redirect()->route('master-data.employee.index')->withSuccess('Data Berhasil hapus');
            }
            return redirect()->route('master-data.employee.index')->withErrors('error', 'Data Tidak Ditemukan');
        } catch (\Exceptions $e) {
            DB::rollback();
            return \redirect()->back()->withErrors($e->all());
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
        $user = \Auth::user();
        $user_role = user_role();

        $model = Employee::leftjoin('banks','banks.id','=','users.bank_id')
                        ->leftjoin('branch_units','branch_units.id','users.branch_unit_id')
                        ->select('users.*','banks.name as bank_name','branch_units.name as cabang_name')
                        ->orderBy('users.created_at','desc');

        if($user_role && in_array($user_role->slug, ['approval', 'bank'])){
            $model->where('banks.id', $user->bank_id);
        }

        return datatables()->of($model)
        ->addColumn('action', function($row){
            $action = '<div class="text-center">
                    <a href="'.route('master-data.employee.show', $row->id).'" class="btn btn-info btn-sm btn-md"><i class="fas fa-eye"></i> Detail</a>
                    <a href="'.route('master-data.employee.edit', $row->id).'" class="btn btn-warning btn-sm btn-md"><i class="fas fa-edit"></i> Edit</a>
                    <a href="'.route('master-data.employee.destroy', $row->id).'" class="btn btn-danger  btn-sm btn-md btn-modal-delete"><i class="fas fa-trash"></i> Hapus</a>
                </div>';
            return $action;
        })
        ->addColumn('status', function($row){
            $status = '<span class="text-green"><b>Aktif</b></span>';
            if($row->is_active!=1){
                $status = '<span class="text-red"><b>Non Aktif</b></span>';
            }
            return $status;
        })
        ->addIndexColumn()
        ->rawColumns(['action','status'])
        ->make(true);
    }
}
