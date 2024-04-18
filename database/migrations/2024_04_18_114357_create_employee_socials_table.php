<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeSocialsTable extends Migration
{
    public function up()
    {
        Schema::create('hrms_employee_socials', function (Blueprint $table) {
            $table->id();
            $table->text('skype_id')->nullable();
            $table->text('contact_no')->nullable(); 
            $table->text('facebook_link')->nullable(); 
            $table->text('twitter_link')->nullable(); 
            $table->text('blogger_link')->nullable(); 
            $table->text('linkdedin_link')->nullable();
            $table->text('google_plus_link')->nullable();
            $table->text('instagram_link')->nullable();
            $table->text('pinterest_link')->nullable();
            $table->text('youtube_link')->nullable();
            $table->text('thread_link')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hrms_employee_socials');
    }
}
