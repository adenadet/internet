<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveTypesTable extends Migration
{
    public function up()
    {
        Schema::create('hrms_leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('no_of_days');
            $table->integer('status');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hrms_leave_types');
    }
}
