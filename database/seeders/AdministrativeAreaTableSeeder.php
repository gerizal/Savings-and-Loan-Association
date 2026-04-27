<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\SubDistrict;

class AdministrativeAreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $province= file_get_contents(public_path('administrative-area/provinces.json'));
        $city = file_get_contents(public_path('administrative-area/cities.json'));
        $district = file_get_contents(public_path('administrative-area/districts.json'));
        $sub_district = file_get_contents(public_path('administrative-area/sub-districts.json'));

        $provinces = json_decode($province, true);
        $cities = json_decode($city, true);
        $districts = json_decode($district, true);
        $sub_districts = json_decode($sub_district, true);

        Province::truncate();
        City::truncate();
        District::truncate();
        SubDistrict::truncate();
        foreach ($provinces as $province) {
            $data = new Province;
            $data->name = $province['name'];
            $data->save();
        }

        foreach($cities as $city){
            $data = new City;
            $data->name = $city['name'];
            $data->province_id = $city['province_id'];
            $data->save();
        }


        foreach ($districts as $district) {
            $data = new District;
            $data->name = $district['name'];
            $data->city_id = $district['city_id'];
            $data->save();
        }

        foreach ($sub_districts as $sub_district) {
            $data = new SubDistrict;
            $data->name = $sub_district['name'];
            $data->district_id = $sub_district['district_id'];
            $data->save();
        }

    }
}
