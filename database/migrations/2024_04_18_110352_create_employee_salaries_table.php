<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrms_employee_salaries', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->integer('salary_type_id')->nullable();
            $table->float('salary')->nullable();
            $table->float('basic_salary')->nullable(); 
            $table->float('daily_wages')->nullable();
            $table->float('salary_ssempee')->nullable(); 
            $table->float('salary_ssempeer')->nullable(); 
            $table->float('salary_income_tax')->nullable(); 
            $table->float('salary_overtime')->nullable(); 
            $table->float('salary_commission')->nullable(); 
            $table->float('salary_claims')->nullable(); 
            $table->float('salary_paid_leave')->nullable(); 
            $table->float('salary_director_fees')->nullable(); 
            $table->float('salary_bonus')->nullable(); 
            $table->float('salary_advance_paid')->nullable(); 
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hrms_employee_salaries');
    }
}