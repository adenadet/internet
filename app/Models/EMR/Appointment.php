<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Structure;

class Appointment extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_appointments';
    protected $fillable = array('patient_id', 'service_id', 'date', 'schedule', 'unique_id', 'sp_id', 'issuer', 'issue_action', 'issue_detail', 'issue_at', 'radiologist_id', 'radiologist_at', 'doctor_id', 'doctor_at', 'front_office_id', 'lab_officer_id', 'lab_officer_remark', 'lab_at', 'status', 'arrived_at', 'payment_channel', 'front_office_remark', 'medical_officer_remark', 'radiologist_remark', 'xray_officer_id', 'xray_at', 'status_end', 'suggestive_summary', 'paid_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at');

    public function cancellation(){
        return $this->belongsTo('App\Models\EMR\Cancellation', 'id', 'appointment_id');
    }

    public function consent(){
        return $this->belongsTo('App\Models\EMR\Consent', 'id', 'appointment_id');
    }

    public function consultation(){
        return $this->belongsTo('App\Models\EMR\Consultation', 'id', 'appointment_id');
    }

    public function issuing_officer(){
        return $this->belongsTo('App\Models\User', 'issuer', 'id');
    }    

    public function laboratory(){
        return $this->belongsTo('App\Models\EMR\Laboratory', 'id', 'appointment_id');
    }

    public function lab_officer(){
        return $this->belongsTo('App\Models\User', 'lab_officer_id', 'id');
    }

    public function medical_officer(){
        return $this->belongsTo('App\Models\User', 'doctor_id', 'id');
    }
    
    public function patient(){
        return $this->belongsTo('App\Models\EMR\Patient', 'patient_id', 'id');
    }

    public function payment(){
    	return $this->belongsTo('App\Models\EMR\Payment', 'id', 'appointment_id');
	}
    
    public function radiologist(){
        return $this->belongsTo('App\Models\User', 'radiologist_id', 'id');
    }

    public function referral(){
        return $this->belongsTo('App\Models\EMR\Referral', 'id', 'appointment_id');
    }

    public function report(){
        return $this->belongsTo('App\Models\EMR\Report', 'id', 'appointment_id');
    }

    public function service(){
        return $this->belongsTo('App\Models\EMR\Service', 'service_id', 'id');
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

}