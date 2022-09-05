<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'emr_patients';
    protected $fillable = array('user_id', 'nationality', 'passport_no', 'created_by', 'created_at', 'updated_at', 'deleted_by', 'deleted_at');

    public function nationality(){
    	return $this->belongsTo('App\Models\Country', 'nationality_id', 'id');
	}

    public function user(){
    	return $this->belongsTo('App\Models\User', 'user_id', 'id');
	}
}
