<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('hrms_leave_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->integer('employee_id');
            $table->integer('department_id');
            $table->integer('leave_type_id');
            $table->date('start_date');
            $table->date('to_date');
            $table->text('description');
            $table->text('remarks');
            $table->integer('status');
            $table->boolean('is_half_day');
            $table->integer('approved_by');
            $table->timestamp('approved_at');
            $table->text('leave_attachment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hrms_leave_requests');
    }
}
