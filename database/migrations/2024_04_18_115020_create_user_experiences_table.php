<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserExperiencesTable extends Migration
{
    public function up()
    {
        Schema::create('hrms_applicant_experiences', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('institution_name');
            $table->string('institution_location');
            $table->string('institution_job_description');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hrms_applicant_experiences');
    }
}
