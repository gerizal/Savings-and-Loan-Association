<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Taspen;
use App\Models\Province;
use App\Models\District;
use App\Models\SubDistrict;
use App\Models\City;
use App\Models\Domicile;
use App\Models\FamilyMember;
use DB;

class TaspenTableSeeder extends Seeder
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
            $taspens = DB::connection(env('DB_CONNECTION_2'))->table('DataTaspen')->orderBy('created_at','ASC')->get();
            foreach($taspens as $key => $taspen){
                $domicile = DB::connection(env('DB_CONNECTION_2'))->table('DataDomisili')->where('id', $taspen->dataDomisiliId)->first();
                $potongan = DB::connection(env('DB_CONNECTION_2'))->table('TunjanganPotongan')->where('id', $taspen->tunjanganPotonganId)->get();
                $new = Taspen::where('id_number', $taspen->nik)->first();
                if(!$new){
                    $new = new Taspen;
                }

                if($domicile){
                    $province = Province::whereRaw('LOWER(name) = "'.strtolower($domicile->provinsi).'"')->first();
                    $province_id = $province ? $province->id:0;
                    $city = City::whereRaw('LOWER(name) = "'.str_replace('kabupaten ','',strtolower(trim($domicile->kota))).'"')->whereProvinceId($province_id)->first();
                    $city_id = $city->id;
                    $district = District::whereRaw('LOWER(name) LIKE "'.strtolower(trim($domicile->kecamatan)).'%"')->whereCityId($city_id)->first();
                    $district_id = $district ? $district->id:0;
                    $sub_district = SubDistrict::whereRaw('LOWER(name) LIKE "%'.strtolower(trim($domicile->kelurahan)).'"')->whereDistrictId($district_id)->first();
                    $sub_district_id = $sub_district?$sub_district->id:0;
                    $new->post_code = $domicile->kode_pos;
                    $new->address = $domicile->alamat;
                    $new->province_id = $province_id;
                    $new->city_id = $city_id;
                    $new->district_id = $district_id;
                    $new->sub_district_id = $sub_district_id;
                    $new->rt = $domicile->rt;
                    $new->rw = $domicile->rw;
                    $location = explode(',',$domicile->geo_location);
                    $latitude = isset($location[0]) ? $location[0]:null;
                    $longitude = isset($location[1]) ? $location[1]:null;
                    $new->latitude = $latitude;
                    $new->longitude = $longitude;
                    $new->birth_place = $city? $city->name:null;
                }

                $new->birth_date = date('Y-m-d',strtotime($taspen->tanggal_lahir));
                $new->business_type = $taspen->jenis_usaha;
                $new->current_job = $taspen->pekerjaan_sekarang;
                $new->current_job_address = $taspen->alamat_pekerjaan;
                $new->education = $taspen->pendidikan == 'LAINNYA' ? 'Lainnya' : $taspen->pendidikan;
                $new->employee_code = $taspen->kode_jiwa;
                $new->employee_grade = $taspen->golongan;
                $new->end_flagging = $taspen->awal_flagging;
                $new->gender = $taspen->jenis_kelamin == 'PEREMPUAN' ? 'Perempuan':'Laki - laki';
                $new->id_number = $taspen->nik==null ? '':$taspen->nik;
                $new->is_active = $taspen->is_active;
                $new->marital_status = ucwords(str_replace('_',' ',$taspen->status_kawin));
                $new->mother_name = $taspen->nama_ibu_kandung;
                $new->name = $taspen->nama;
                $new->nipnrp = $taspen->nipnrp;
                $new->nopen = $taspen->nopen;
                $new->participant_status = $taspen->status_peserta;
                $new->phone_number = $taspen->no_telepon;
                $new->religion = ucwords($taspen->agama);
                $new->retirement_type = $taspen->jenis_pensiun;
                $new->skep_date = date('Y-m-d',strtotime($taspen->tanggal_sk_pensiun));
                $new->skep_name = $taspen->nama_skep;
                $new->skep_number = $taspen->no_skep;
                $new->skep_publisher = $taspen->penerbit_sk;
                $new->start_flagging = $taspen->akhir_flagging;
                $new->tax_number = $taspen->npwp;
                $new->work_periode = $taspen->masa_kerja;
                $new->id_number_periode = $taspen->masa_ktp;
                $new->tmt_pensiun = date('Y-m-d',strtotime($taspen->tmt_pensiun));
                $new->account_number = $taspen->no_rek;
                $new->bad_data = $taspen->data_tidak_baik;
                $new->save();

                if($domicile){
                    $province = Province::whereRaw('LOWER(name) = "'.strtolower($domicile->provinsi_domisili).'"')->first();
                    $province_id = $province ? $province->id:0;
                    $city = City::whereRaw('LOWER(name) = "'.strtolower(str_replace('Kabupaten ','',trim($domicile->kota_domisili))).'"')->whereProvinceId($province_id)->first();
                    $city_id = $city ? $city->id:0;
                    $district = District::whereRaw('LOWER(name) LIKE "%'.strtolower(trim($domicile->kecamatan_domisili)).'%"')->whereCityId($city_id)->first();
                    $district_id = $district? $district->id:0;
                    $sub_district = SubDistrict::whereRaw('LOWER(name) LIKE "%'.strtolower(trim($domicile->kelurahan_domisili)).'%"')->whereDistrictId($district_id)->first();
                    $sub_district_id = $sub_district? $sub_district->id:0;
                    $location = explode(',',$domicile->geo_location);
                    $latitude= isset($location[0]) ? $location[0]:null;
                    $longitude=isset($location[1]) ? $location[1]:null;

                    $new_domicile = Domicile::whereTaspenId($new->id)->first();
                    if(!$new_domicile){
                        $new_domicile = new Domicile;
                    }

                    $new_domicile->taspen_id            = $new->id;
                    $new_domicile->residential_status   = ucwords($taspen->status_rumah);
                    $new_domicile->occupied_at          = $taspen->menempati_tahun;
                    $new_domicile->address              = $domicile->alamat_domisili;
                    $new_domicile->rt                   = $domicile->rt_domisili;
                    $new_domicile->rw                   = $domicile->rw_domisili;
                    $new_domicile->sub_district_id      = $sub_district_id;
                    $new_domicile->district_id          = $district_id;
                    $new_domicile->city_id              = $city_id;
                    $new_domicile->province_id          = $province_id;
                    $new_domicile->post_code            = $domicile->kode_pos_domisili;
                    $new_domicile->latitude             = $latitude;
                    $new_domicile->longitude            = $longitude;
                    $new_domicile->save();
                }

                $pasangan = DB::connection(env('DB_CONNECTION_2'))->table('DataPasangan')->where('id', $taspen->dataPasanganId)->first();
                if($pasangan){
                    $spouse = FamilyMember::whereTaspenId($new->id)->whereRelationStatus('spouse')->first();
                    if(!$spouse){
                        $spouse = new FamilyMember;
                    }

                    $spouse->taspen_id = $new->id;
                    $spouse->id_number = $pasangan->nik_pasangan==null ?'':$pasangan->nik_pasangan;
                    $spouse->name = $pasangan->nama_pasangan == null ? '' : $pasangan->nama_pasangan;
                    $spouse->birth_place = '';
                    $spouse->birth_date = date('Y-m-d',strtotime($pasangan->tanggal_lahir_pasangan));
                    $spouse->occupation = $pasangan->pekerjaan_pasangan == null ? '':$pasangan->pekerjaan_pasangan;
                    $spouse->relation_status = 'spouse';
                    $spouse->save();
                }

                \Log::info('SAVE '. $key);
            }
            DB::commit();
            \Log::info('FINISH');
        } catch (\Exception $e) {
            \Log::info('ERROR',['file'=>$e->getFile(),'line'=>$e->getLine(),'message'=>$e->getMessage()]);
            DB::rollback();
        }

    }
}
