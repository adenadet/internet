<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Structure;

class Appointment extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_appointments';
    protected $fillable = array('patient_id', 'service_id', 'date', 'schedule', 'status', 'arrived_at', 'payment_channel', 'paid_by', 'created_at', 'deleted_by', 'deleted_at');

    public function patient(){
        return $this->belongsTo('App\Models\EMR\Patient', 'patient_id', 'id');
    }

    public function consent(){
        return $this->belongsTo('App\Models\EMR\Consent', 'id', 'appointment_id');
    }

    public function consultation(){
        return $this->belongsTo('App\Models\EMR\Consultation', 'id', 'appointment_id');
    }

    public function report(){
        return $this->belongsTo('App\Models\EMR\Report', 'id', 'appointment_id');
    }

    public function service(){
        return $this->belongsTo('App\Models\EMR\Service', 'service_id', 'id');
    }

    public function issuing_officer(){
        return $this->belongsTo('App\Models\User', 'issuer', 'id');
    }
    
    public function radiologist(){
        return $this->belongsTo('App\Models\User', 'radiologist_id', 'id');
    }
    
    public function medical_officer(){
        return $this->belongsTo('App\Models\User', 'doctor_id', 'id');
    }
    
    public function front_officer(){
        return $this->belongsTo('App\Models\User', 'front_office_id', 'id');
    }

    public function creator(){
    	return $this->belongsTo('App\Models\User', 'created_by', 'id');
	}

    public function deleter(){
        return $this->belongsTo('App\Models\User', 'deleted_by', 'id');
    }

    public function payment(){
    	return $this->belongsTo('App\Models\EMR\Payment', 'id', 'appointment_id');
	}
}