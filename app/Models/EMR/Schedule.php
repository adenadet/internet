<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'emr_service_schedules';
    protected $fillable = array('service_id', 'schedule');
}
