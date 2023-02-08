<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Consent extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_consent_forms';
    protected $fillable = array('service_id', 'appointment_id', 'signaturePad', 'signaturePad_1', 'signaturePad_2', 'signaturePad_3', 'signaturePad_4', 'guardian', 'guardian_relationship', 'interpreter', 'pregnancy', 'physician_id', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at');

    public function appointment(){
    	return $this->belongsTo('App\Models\EMR\Appointment', 'appointment_id', 'id');
	}

    public function physician(){
    	return $this->belongsTo('App\Models\User', 'physician_id', 'id');
	}

    public function service(){
    	return $this->belongsTo('App\Models\EMR\Service', 'service_id', 'id');
	}
}