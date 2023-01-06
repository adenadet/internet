<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Laboratory extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'emr_appointment_laboratories';
    protected $fillable = array('appointment_id', 'patient_id', 'summary', 'details', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at');

    public function creator(){
    	return $this->belongsTo('App\Models\User', 'created_by', 'id');
	}

    public function deleter(){
        return $this->belongsTo('App\Models\User', 'deleted_by', 'id');
    }
}
