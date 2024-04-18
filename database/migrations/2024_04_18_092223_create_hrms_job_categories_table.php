<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmsJobCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('hrms_job_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unique_id')->nullable();
            $table->text('description');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hrms_job_categories');
    }
}
