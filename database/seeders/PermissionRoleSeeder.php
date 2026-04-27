<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PermissionRole;
use App\Models\Permission;
use App\Models\Role;
use DB;
class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_roles')->truncate();
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $permissions = new PermissionRole;
        	$permissions->permission_id = $permission->id;
        	$permissions->role_id = '1';
        	$permissions->save();
        }


        $permissions = Permission::whereIn('feature',['simulasi_pinjaman','pengajuan_slik','absensi_karyawan'])->get();
        $role = Role::whereName('Marketing')->first();
        if($role){
            foreach ($permissions as $permission) {
                $permissions = new PermissionRole;
                $permissions->permission_id = $permission->id;
                $permissions->role_id = $role->id;
                $permissions->save();
            }
        }

        $permissions = Permission::all();
        $role = Role::whereName('Operasional')->first();
        if($role){
            foreach ($permissions as $permission) {
                $permissions = new PermissionRole;
                $permissions->permission_id = $permission->id;
                $permissions->role_id = $role->id;
                $permissions->save();
            }
        }

        $permissions = Permission::whereIn('feature',['pengajuan_slik','approval_bank','cetak_si_pencairan','pencairan','pencairan_tahap_2','upload_dokumen','absensi_karyawan','laporan_absensi_karyawan'])->get();
        $role = Role::whereName('Approval')->first();
        if($role){
            foreach ($permissions as $permission) {
                $permissions = new PermissionRole;
                $permissions->permission_id = $permission->id;
                $permissions->role_id = $role->id;
                $permissions->save();
            }
        }

        $permissions = Permission::whereIn('feature',['dashboard','pengajuan_slik','approval_bank','cetak_si_pencairan','pencairan','pencairan_tahap_2','upload_dokumen','monitoring_pembiayaan','laporan','absensi_karyawan','laporan_absensi_karyawan'])->get();
        $role = Role::whereName('Bank')->first();
        if($role){
            foreach ($permissions as $permission) {
                $permissions = new PermissionRole;
                $permissions->permission_id = $permission->id;
                $permissions->role_id = $role->id;
                $permissions->save();
            }
        }

        $permissions = Permission::all();
        $role = Role::whereName('Master')->first();
        if($role){
            foreach ($permissions as $permission) {
                $permissions = new PermissionRole;
                $permissions->permission_id = $permission->id;
                $permissions->role_id = $role->id;
                $permissions->save();
            }
        }

        $permissions = Permission::whereIn('feature',['dashboard','pengajuan_slik','approval_bank','cetak_si_pencairan','pencairan','pencairan_tahap_2','upload_dokumen','berkas_pembiayaan','cetak_berkas_penyerahan','upload_surat_berkas','cetak_penyerahan_jaminan','upload_jaminan','data_bisnis'])->get();
        $role = Role::whereName('Data')->first();
        if($role){
            foreach ($permissions as $permission) {
                $permissions = new PermissionRole;
                $permissions->permission_id = $permission->id;
                $permissions->role_id = $role->id;
                $permissions->save();
            }
        }

        $permissions = Permission::whereIn('feature',['berkas_pembiayaan','cetak_berkas_penyerahan','upload_surat_berkas','cetak_penyerahan_jaminan','upload_jaminan'])->get();
        $role = Role::whereName('Pemberkasan')->first();
        if($role){
            foreach ($permissions as $permission) {
                $permissions = new PermissionRole;
                $permissions->permission_id = $permission->id;
                $permissions->role_id = $role->id;
                $permissions->save();
            }
        }

        $permissions = Permission::whereIn('feature',[
            'simulasi_pinjaman','monitoring_pembiayaan','laporan','absensi_karyawan','laporan_absensi_karyawan',
            'laporan_cash_flow', 'laporan_outstanding', 'laporan_monthly', 'laporan_fixed_cost', 'laporan_alternative_cost', 'laporan_insurance', 'laporan_debtor'
        ])->get();
        $role = Role::whereName('Verifikasi')->first();
        if($role){
            foreach ($permissions as $permission) {
                $permissions = new PermissionRole;
                $permissions->permission_id = $permission->id;
                $permissions->role_id = $role->id;
                $permissions->save();
            }
        }
    }
}
