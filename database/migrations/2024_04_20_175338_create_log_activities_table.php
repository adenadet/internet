<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogActivitiesTable extends Migration
{
    public function up()
    {
        Schema::create('user_log_activities', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('url');
            $table->string('method');
            $table->string('ip');
            $table->text('agent');
            $table->integer('user_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_log_activities');
    }
}
