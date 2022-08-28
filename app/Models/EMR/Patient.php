<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'emr_patients';
    protected $fillable = array('last_name', 'first_name', 'other_name', 'image', 'nationality_id', 'passport_no', 'sex', 'phone', 'dob', 'email', 'unique_id', 'password', 'created_by', 'created_at', 'updated_at', 'deleted_by', 'deleted_at');

}
