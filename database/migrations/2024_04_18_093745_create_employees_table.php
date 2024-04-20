<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('hrms_employees', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('supervisor_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('unit_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->string('salary_template')->nullable();
            $table->date('joined_at')->nullable();
            $table->date('left_at')->nullable();
            $table->integer('designation_id');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hrms_employees');
    }
}
