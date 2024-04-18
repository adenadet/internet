<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEducationTable extends Migration
{
    public function up()
    {
        Schema::create('hrms_user_education', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('educational_level_id');
            $table->string('institution_name')->length(191);
            $table->text('institution_address');
            $table->text('source')->nullable();
            $table->timestamps();
            $table->softDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hrms_user_education');
    }
}
