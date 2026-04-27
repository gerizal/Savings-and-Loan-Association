<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaspensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taspens', function (Blueprint $table) {
            $table->id();
            $table->string('id_number')->nullable();
            $table->string('name')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender',['Laki - laki','Perempuan'])->nullable();
            $table->enum('education',['SD','SMP','SMA','S1','S2','S3','DI','DII','DIII','DIV','Lainnya'])->nullable();
            $table->string('phone_number')->nullable();
            $table->enum('religion',['Islam','Kristen Katholik','Kristen Protestan','Konghucu','Hindu','Budha'])->nullable();
            $table->string('tax_number')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('address')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->unsignedInteger('sub_district_id')->nullable();
            $table->unsignedInteger('district_id')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->unsignedInteger('province_id')->nullable();
            $table->string('post_code')->nullable();
            $table->boolean('is_domicile')->default(true);
            $table->string('current_job')->nullable();
            $table->string('current_job_address')->nullable();
            $table->string('business_type')->nullable();
            $table->enum('marital_status',['Kawin','Belum Kawin','Duda', 'Janda'])->nullable();
            //Data Pensiun
            $table->string('nopen')->nullable();
            $table->string('employee_code')->nullable();
            $table->string('work_periode')->nullable();
            $table->string('employee_grade')->nullable();
            $table->string('skep_name')->nullable();
            $table->string('skep_number')->nullable();
            $table->date('skep_date')->nullable();
            $table->string('skep_publisher')->nullable();
            $table->string('retirement_type')->nullable();
            $table->string('participant_status')->nullable();
            $table->string('nipnrp')->nullable();
            $table->date('start_flagging')->nullable();
            $table->date('end_flagging')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taspens');
    }
}
