<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use DB;
class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->truncate();
    	// $feature = [
        //     'user',
        //     'master_data',
        //     'dashboard',
        //     'simulasi_pinjaman',
        //     'pengajuan_slik',
        //     'pengajuan_internal',
        //     'pengajuan_komite',
        //     'monitoring_pembiayaan',
        //     'angsuran',
        //     'pemberkasan',
        //     'laporan',
        //     'data_bisnis',
        //     'absensi_karyawan'
        // ];
    	// $acccess = array('view','create','edit','delete');
        // //user permissions
        // for($i=0; $i<count($feature); $i++){
        // 	for($j=0; $j<count($acccess); $j++){
        // 		$permissions = new Permission();
        // 		$permissions->feature = $feature[$i];
        //         $permissions->access =$acccess[$j];
        // 		$permissions->save();
        // 	}
        // }

        $features = [
            'dashboard'=>['view'],
            'simulasi_pinjaman'=>['view','create','edit','delete'],
            'pengajuan_slik'=>['view','create','edit','delete'],
            'verifikasi_slik'=>['view','approve'],
            'verifikasi_pembiayaan'=>['view','approve'],
            'approval_bank'=>['view','approve'],
            'cetak_si_pencairan'=>['view','cetak'],
            'pencairan'=>['view','update'],
            'pencairan_tahap_2'=>['view','update'],
            'upload_dokumen'=>['view','update'],
            'monitoring_pembiayaan'=>['view','print','delete'],
            'angsuran'=>['view','update'],
            'berkas_pembiayaan'=>['view','update'],
            'cetak_berkas_penyerahan'=>['view','update'],
            'upload_surat_berkas'=>['view','update'],
            'cetak_penyerahan_jaminan'=>['view','update'],
            'upload_jaminan'=>['view','update'],
            'laporan'=>['view','create'],
            'data_bisnis'=>['view'],
            'absensi_karyawan'=>['view'],
            'laporan_absensi_karyawan'=>['view','create'],
            'master_data_pembiayaan'=>['view','create','edit','delete'],
            'master_data_taspen'=>['view','create','edit','delete'],
            'master_data_referral'=>['view','create','edit','delete'],
            'master_data_karyawan'=>['view','create','edit','delete'],
            'master_data_pelayanan'=>['view','create','edit','delete'],
            'master_data_cabang'=>['view','create','edit','delete'],
            'user'=>['view','create','edit','delete'],
            'role_user'=>['view','create','edit','delete'],
        ];

        foreach ($features as $feature => $access) {
            foreach ($access as $value) {
                $exist = Permission::whereFeature($feature)->whereAccess($value)->first();
                if(!$exist){
                    $permissions = new Permission;
                }
                $permissions->feature   = $feature;
                $permissions->access    = $value;
                $permissions->save();
            }

        }

    }
}
