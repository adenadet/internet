<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create('hrms_job_applications', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('job_id');
            $table->string('unique_id')->nullable();
            $table->text('cover_letter')->nullable();
            $table->text('resume')->nullable();
            $table->text('hr_remarks')->nullable();
            $table->integer('status');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hrms_job_applications');
    }
}
