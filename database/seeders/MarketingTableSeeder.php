<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Role;
use Illuminate\Support\Str;
use App\Models\BranchUnit;
use App\Models\ServiceUnit;
use DB;

class MarketingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::beginTransaction();
            $users = DB::connection(env('DB_CONNECTION_2'))->table('User')->orderBy('created_at','ASC')->get();
            foreach($users as $user){
                $new = User::where('email', strtolower($user->email))->first();
                if(!$new){
                    $new = new User;
                }

                $new->name=$user->username;
                $new->email=strtolower($user->email);
                $new->password=$user->password;
                $new->email_verified_at=\Carbon\Carbon::now();
                $new->employee_id=$user->nip;
                $new->id_number=$user->nik;
                $new->first_name=$user->first_name;
                $new->last_name=$user->last_name;
                $new->address=$user->alamat;
                $new->phone_number=$user->no_telepon;
                $new->birth_date=date('Y-m-d',strtotime($user->tanggal_lahir));
                $new->birth_place=$user->tempat_lahir;
                $new->job_title= $user->posisi;
                $new->status_pkwt= $user->status_pkwt;
                $new->is_active= $user->status_active;
                $new->contract_start= $user->mulai_kontrak;
                $new->contract_term= $user->masa_kotrak;
                $new->target= $user->target;

                $_branch =  DB::connection(env('DB_CONNECTION_2'))->table('UnitCabang')->where('id',$user->unit_cabang_id)->first();
                if($_branch){
                    $_service_unit = DB::connection(env('DB_CONNECTION_2'))->table('UnitPelayanan')->where('id',$_branch->unit_pelayanan_id)->first();
                    $service_unit_id = 0;
                    if($_service_unit){
                        $service_unit = ServiceUnit::whereRaw('lower(name) = "'.strtolower($_service_unit->name).'"')->first();
                        if(!$service_unit){
                            $service_unit = new ServiceUnit;
                        }
                        $service_unit->name = $_service_unit->name;
                        $service_unit->code_area = $_service_unit->kode_area;
                        $service_unit->number_code = $_service_unit->number_kode;
                        $service_unit->save();
                        $service_unit_id = $service_unit->id;
                    }

                    $branch = BranchUnit::whereRaw('lower(name) = "'.strtolower($_branch->name).'"')->where('service_unit_id', $service_unit_id)->first();
                    if(!$branch){
                        $branch = new BranchUnit;
                    }
                    $branch->name = $_branch->name;
                    $branch->number_code = $_branch->number_code;
                    $branch->code_area = $_branch->kode_area;
                    $branch->service_unit_id = $service_unit_id;
                    $branch->save();
                    $new->branch_unit_id = $branch->id;
                }

                $new->save();

                $role_name = ucwords(str_replace('_',' ', strtolower($user->role)));
                $role = Role::whereRaw('lower(slug) ="'.Str::slug($role_name, '-').'"')->first();
                if(!$role){
                    $role = new Role;
                    $role->slug = Str::slug($role_name, '-');
                    $role->name = $role_name;
                    $role->save();
                }

                $role_user = UserRole::where('role_id',$role->id)->where('user_id',$new->id)->first();
                if(!$role_user){
                    $role_user = new UserRole;
                    $role_user->role_id = $role->id;
                    $role_user->user_id = $new->id;
                    $role_user->save();
                }
            }
            DB::commit();
            \Log::info('FINISH');
        } catch (\Exception $e) {
            \Log::info('ERROR',['file'=>$e->getFile(),'line'=>$e->getLine(),'message'=>$e->getMessage()]);
            DB::rollback();
        }
    }
}
