<?php

namespace App\Models\EMR;

use App\Models\Structure;

class Referral extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_appointment_referrals';
    protected $fillable = array('appointment_id', 'details', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at');

    public function creator(){
    	return $this->belongsTo('App\Models\User', 'updated_by', 'id');
	}

    public function deleter(){
        return $this->belongsTo('App\Models\User', 'deleted_by', 'id');
    }
}
