<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmsJobsTable extends Migration
{
    public function up()
    {
        Schema::create('hrms_jobs', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id'); 
            $table->integer('company_id'); 
            $table->string('job_title')->length(191); 
            $table->integer('designation_id'); 
            $table->string('job_url'); 
            $table->integer('job_type_id'); 
            $table->integer('is_featured'); 
            $table->integer('type_url'); 
            $table->boolean('job_vacancy'); 
            $table->string('gender')->nullable(); 
            $table->integer('minimum_experience'); 
            $table->date('date_of_closing')->nullable(); 
            $table->text('short_description'); 
            $table->text('long_description'); 
            $table->integer('status');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hrms_jobs');
    }
}
