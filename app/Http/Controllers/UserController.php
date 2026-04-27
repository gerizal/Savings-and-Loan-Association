<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Auth;
use Mail;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\Models\Bank;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    public function __construct(){
        $this->middleware('role.feature.check:user,view', ['only' => ['index']]);
        $this->middleware('role.feature.check:user,create', ['only' => ['create', 'store']]);
        $this->middleware('role.feature.check:user,edit', ['only' => ['edit','update']]);
        $this->middleware('role.feature.check:user,delete', ['only' => ['delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(check_access('user','view')  == true){
            return view('user.index');
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
            // $roles = Role::where('slug','!=','superadmin')->pluck('name','id')->toArray();
            // $banks = Bank::select('id','name')->pluck('name','id')->toArray();
            // $create = true;
            // return view('user.create', compact('roles','create','banks'));
            $data=[
                'data'  =>new User,
                'form'  =>[
                    'url'       => route('user.store'),
                    'method'    => 'POST',
                    'files'     => true
                ],
                'roles'=> Role::where('slug','!=','superadmin')->pluck('name','id'),
                'banks'=> Bank::select('id','name')->pluck('name','id'),
                'create'=>true
            ];

            return view('user.form', $data);
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
            $rules = [
                'name' => 'required|max:60',
                'email' => 'required|email|max:100|unique:users',
                'role_id'=>'required'
            ];
            if(isset($request->role_name)){
                $role_name = strtolower($request->role_name);
                if($role_name=='approval' || $role_name =='bank'){
                    $rules['bank_id'] = 'required';
                }
            }
            $validate = validator($request->all(), $rules);
            if($validate->fails()){
                \Log::info('unvalidated',['data'=>$validate->errors()]);
                return redirect()->back()->withInput($request->all())->withErrors($validate->errors());
            }

            try {
                DB::beginTransaction();
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt(env('PASSWORD_DEFAULT'));
                $user->is_active=false;
                if(isset($request->bank_id)){
                    $user->bank_id = $request->bank_id;
                }
                $user->save();

                $role_user = new UserRole;
                $role_user->role_id = $request->role_id;
                $role_user->user_id = $user->id;
                $role_user->save();
                self::sendEmailPassword($user, $user->id);
                DB::commit();
                return redirect('user')->withSuccess('Data Berhasil disimpan');
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::info('ERROR CREATE USER',['data'=>$e->getMessage(),'file'=>$e->getFile(),'LINE'=>$e->getLine()]);
                return redirect()->back()->withInput($request->all());
            }
        }
        else
        {
            return back()->withInput($request->all());
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
        $profile = Auth::user();
        return view('user.profile', compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ( check_access('user','edit') == TRUE){
            // $roles = Role::where('slug','!=','superadmin')->pluck('name','id')->toArray();
            $user = User::find($id);
            // $banks = Bank::select('id','name')->pluck('name','id')->toArray();
            // $create = true;
            // return view('user.edit', compact('user','roles','create','banks'));
            $role_user = UserRole::where('user_id',$id)->first();
            $user->role_id = null;
            if($role_user){
                $user->role_id = $role_user->role_id;
            }
            $data=[
                'data'  =>$user,
                'form'  =>[
                    'url'       => route('user.update', $user->id),
                    'method'    => 'PUT',
                    'files'     => true
                ],
                'roles'=> Role::where('slug','!=','superadmin')->pluck('name','id'),
                'banks'=> Bank::select('id','name')->pluck('name','id'),
                'create'=>false
            ];

            return view('user.form', $data);
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
            $rules = [
                'name' => 'required|max:60',
                'email' => 'required|email|max:100',
                'role_id'=>'required'
            ];
            $check_email = User::whereEmail($request->email)->first();
            if($check_email){
                if($check_email->id!=$id){
                    $rules['email']='required|email|max:100|unique:users';
                }
            }
            if(isset($request->role_name)){
                $role_name = strtolower($request->role_name);
                if($role_name=='approval' || $role_name =='bank'){
                    $rules['bank_id'] = 'required';
                }
            }
            $validate = validator($request->all(), $rules);
            if($validate->fails()){
                return redirect()->back()->withInput($request->all())->withErrors($validate->errors());
            }

            try {
                DB::beginTransaction();
                $user = User::find($id);
                $user->name = $request->name;
                if(isset($request->email)){
                    $user->email = $request->email;
                }

                if($request->password != ''){
                    $user->password = bcrypt($request->password);
                }

                if(isset($request->bank_id)){
                    $user->bank_id = $request->bank_id;
                }
                $user->save();


                $role_user = UserRole::where('user_id',$id)->first();
                if(!$role_user){
                    $role_user = new UserRole;
                }
                $role_user->role_id = $request->role_id;
                $role_user->user_id = $id;
                $role_user->save();
                DB::commit();
                return redirect('user')->withSuccess('Data Berhasil diperbaharui');
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::info('ERROR Update USER',['data'=>$e->getMessage(),'file'=>$e->getFile(),'LINE'=>$e->getLine()]);
                return redirect()->back()->withInput($request->all());
            }
        }
        else
        {
            return back()->withInput($request->all());
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
            if($id == 1){
                return redirect('/user')->withSuccess('Data User tidak bisa di hapus');
            }else{
                $user = User::find($id);
                $user->delete();
                return redirect('/user')->withSuccess('Data Berhasil dihapus');
            }
        }
        else
        {
            return back();
        }
    }
    public function datatable()
    {
        $user = \Auth::user();
        $user_role = user_role();

        $model = User::with('role')
            ->when($user_role && in_array($user_role->slug, ['approval', 'bank']),
                fn($q) => $q->where('bank_id', $user->bank_id)
            )
            ->get()
            ->map(function($u){
                // Keep 'role' attribute name to match frontend expectations
                $u->setAttribute('role', optional($u->role)->name);
                return $u;
            });

        return datatables()->of($model)
        ->addColumn('action', function($row){
            $action = '<div class="text-center">
                    <a href="'.route('user.edit', $row->id).'" class="btn btn-warning btn-sm btn-md"><i class="fas fa-edit"></i> Edit</a>
                    <a href="'.route('user.destroy', $row->id).'" class="btn btn-danger  btn-sm btn-md btn-modal-delete"><i class="fas fa-trash"></i> Hapus</a>
                </div>';
            return $action;
        })
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    private function sendEmailPassword($user, $user_id)
    {
        $email      = $user->email;
        $token      = Crypt::encryptString($user_id);
        $deeplink   = env('APP_URL') . '/password/user/set/' . $token;
        $data = array(
            'email'     => $email,
            'name'      => $user->name,
            'deeplink'  => $deeplink
        );

        Mail::send('email.password-fill', $data, function ($message) use ($email) {
                $message->subject('User verification');
                $message->from('admin@kpfi.co.id', 'Admin KPFI');
                $message->to($email);
            }
        );
    }

    public function updateProfile(Request $request, $id )
    {
      	$profile = User::find($id);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
        ]);
 		$profile->name = $request->name;
        $profile->email = $request->email;
        $profile->save();
        session()->flash('success','Data Profile Berhasil Disimpan');
        return redirect('/user/profile');
    }

}
