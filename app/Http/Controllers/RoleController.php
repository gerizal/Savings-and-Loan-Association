<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\PermissionRole;
use App\Models\Permission;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\New_;

class RoleController extends Controller
{
    public function __construct(){
        $this->middleware('role.feature.check:role_user,view', ['only' => ['index']]);
        $this->middleware('role.feature.check:role_user,create', ['only' => ['create', 'store']]);
        $this->middleware('role.feature.check:role_user,edit', ['only' => ['edit','update']]);
        $this->middleware('role.feature.check:role_user,delete', ['only' => ['delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(check_access('user','view')  == true){
            return view('role.index');
        }
        else
        {
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ( check_access('user','create') == TRUE){
            $permissions = Permission::All();
            $permissions_group = [];
            $max_column = 4;
            foreach($permissions as $data){
                $data->checked = '';
                $data->selected = false;
                if(isset($permissions_group[$data->feature])){
                    array_push($permissions_group[$data->feature],$data);
                }else{
                    $permissions_group[$data->feature]=[$data];
                }
                $total_data = count( $permissions_group[$data->feature]);
                if($total_data>$max_column){
                    $max_column = $total_data;
                }
            }

            $data=[
                'data'  =>new Role,
                'form'  =>[
                    'url'       => route('role.store'),
                    'method'    => 'POST',
                ],
                'permissions_group'=> $permissions_group,
                'max_column'=> $max_column
            ];
            return view('role.form', $data);
        }
        else{
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(check_access('user','create')  == true){
            $role = new Role;
             $this->validate($request, [
                'name' => 'required|max:255|unique:roles,slug'
            ]);
            $role->slug = Str::slug($request->name, '-');
            $role->name = $request->name;
            $role->save();
            $data_permissions = $request->permission;

            $hitungdata =count($data_permissions);
            for ($i=0; $i<$hitungdata;$i++){
                $permissions = new PermissionRole();
                $permissions['permission_id']=$data_permissions[$i];
                $permissions['role_id'] = $role->id;
                $permissions->save();
            }

           return redirect()->route( 'role.index' )->withSuccess('Data Berhasil disimpan');
        }
        else{
            return back();
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
        if(check_access('user','edit')  == true){
            $data_permission = PermissionRole::select('permission_id')->where('role_id',$id)->pluck('permission_id')->toArray();
            $permissions = Permission::All();
            $permissions_group = [];
            $max_column = 4;
            foreach($permissions as $data){
                $access = $data;
                $selected = false;
                $checked = '';
                if(in_array($data->id,$data_permission)){
                    $selected = true;
                    $checked = 'checked';
                }
                $data->checked = $checked;
                $data->selected = $selected;
                if(isset($permissions_group[$data->feature])){
                    array_push($permissions_group[$data->feature],$data);
                }else{
                    $permissions_group[$data->feature]=[$data];
                }
                $total_data = count( $permissions_group[$data->feature]);
                if($total_data>$max_column){
                    $max_column = $total_data;
                }
            }

            $data=[
                'data'  =>Role::find($id),
                'form'  =>[
                    'url'       => route('role.update', $id),
                    'method'    => 'PUT',
                ],
                'permissions_group'=> $permissions_group,
                'max_column'=> $max_column
            ];
            return view('role.form', $data);
        }
        else{
            return back();
        }
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
        if(check_access('user','edit')  == true){
            $role = Role::find($id);
            $this->validate($request, [
                'name' => 'required|max:255'
            ]);
            $role['name'] = $request->name;
            $role->save();
            $delete_access = PermissionRole::where('role_id',$id)->delete();
            $data_permissions = $request->permission;
            for ($i=0; $i<count($data_permissions);$i++){
                $permissions = new PermissionRole();
                $permissions['permission_id']=$data_permissions[$i];
                $permissions['role_id'] = $role->id;
                $permissions->save();
            }

            return redirect('/role')->withSuccess('Data Berhasil diperbaharui');
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
        if(check_access('user','delete')  == true){
        	if($id == 1) {
            	return redirect('/role')->withSuccess('Data tidak bisa di hapus');
        	}else{
        		$role = Role::find($id);
	            $role->delete();
	            PermissionRole::where('role_id',$id)->delete();
	            return redirect('/role')->withSuccess('Data Berhasil dihapus');
        	}

        }
        else
        {
            return back();
        }
    }

    public function datatable()
    {
        $model = Role::all();

        return datatables()->of($model)
        ->addColumn('action', function($row){
            $action = '<div class="text-center">
                    <a href="'.route('role.edit', $row->id).'" class="btn btn-warning btn-sm btn-md"><i class="fas fa-edit"></i> Edit</a>
                    <a href="'.route('role.destroy', $row->id).'" class="btn btn-danger  btn-sm btn-md btn-modal-delete"><i class="fas fa-trash"></i> Hapus</a>
                </div>';
            return $action;
        })
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }
}
