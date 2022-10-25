<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'emr_patients';
    protected $fillable = array('last_name', 'first_name', 'middle_name', 'dob', 'sex', 'image', 'passport_page', 'lmp', 'email', 'phone', 'alt_phone', 'nigerian_address', 'uk_address', 'accompanying_kids', 'nationality_id', 'passport_no', 'visa_type','created_by', 'created_at', 'updated_at', 'deleted_by', 'deleted_at');

    public function nationality(){
    	return $this->belongsTo('App\Models\Country', 'nationality_id', 'id');
	}

    public function user(){
    	return $this->belongsTo('App\Models\User', 'user_id', 'id');
	}
}
