<?php
namespace App\Http\Traits\EService;

use App\Models\EMR\Appointment;
use App\Models\EMR\Patient;
use App\Models\EMR\RadFinding;
use App\Models\EMR\Schedule;
use App\Models\EMR\Service;
use App\Models\Area;
use App\Models\State;
use App\Models\Country;
use App\Models\User;

trait AppointmentTrait{
    public function appointment_get_all($type, $page, $paginated, $sort_order){
        if(is_null($type)){
            $query = Appointment::whereDate('date', '>=', date('Y-m-d'))->with(['service', 'patient', 'payment']);
        }
        else if($type == 'certificate'){
            $query = Appointment::whereDate('date', '>=', date('Y-m-d', strtotime('-1 month')))->whereDate('date', '<=', date('Y-m-d'))->whereNotNull(['doctor_id', 'front_office_id',])->Where('status', '>=', 7)->with(['consent', 'consultation', 'front_officer', 'issuing_officer', 'patient', 'medical_officer', 'radiologist', 'referral', 'report.findings']);
        }
        else if($type == 'consultation'){
            $query = Appointment::whereDate('date', '=', date('Y-m-d'))->whereIn('status', [4, 5])->with(['service', 'patient', 'payment']);
        }
        else if($type == 'missed'){
            $query = Appointment::whereDate('date', '<=', date('Y-m-d'))->whereNull(['front_office_id',])->where('status', '=', 1)->with(['service', 'patient', 'payment']);
        }
        else if($type == 'pending'){
            $query = Appointment::whereDate('date', '>=',date('Y-m-d', strtotime('-1 month')))->whereDate('date', '<=', date('Y-m-d'))->whereIn('status', [6, 7, 8, 9])->with(['service', 'patient',]);
        }
        else if($type == 'review'){
            $query = Appointment::whereDate('date', '>=',date('Y-m-d', strtotime('-1 month')))->whereDate('date', '<=', date('Y-m-d'))->whereIn('status', [6, 7, 8, 9, 10])->with(['service', 'patient']);
        }
        else if ($type == 'xray'){
            $query = Appointment::where('status', '=', 6)->whereDate('date', '=', date('Y-m-d'))->where('status_end', '!=', 1)->with(['service', 'patient']);
        }

        if($paginated){return $query->orderBy('date', $sort_order)->orderBy('schedule', 'ASC')->paginate(50);}
        else{return $query->orderBy('date', $sort_order)->orderBy('schedule', 'ASC')->get();}
    }

    public function appointment_get_all_services(){
        return Service::orderBy('name', 'ASC')->get();
    }

    public function appointment_get_by_id($id, $type = NULL){
        $query = Appointment::where('id',$id);
        if(is_null($type)){
            return $query->with(['consultation', 'front_officer', 'medical_officer', 'radiologist', 'service', 'patient.nationality', 'payment.employee', 'report.findings'])->first();
        }
        else if($type == 'consultation'){
            return $query->with(['consent', 'consultation', 'front_officer', 'issuing_officer', 'medical_officer', 'patient.nationality', 'payment.employee', 'radiologist', 'report.findings', 'referral.creator', 'service',])->first();
        }
        else if($type == 'radiologist'){
            return $query->with(['certificate', 'consent', 'consultation', 'front_officer', 'medical_officer', 'service', 'patient.nationality', 'payment.employee', 'radiologist',])->first();
        }
        else if($type == 'referral'){
            return $query->with(['front_officer', 'medical_officer', 'service', 'patient', 'referral.creator',])->first();
        }
        else if ($type == 'xray'){
            $query = Appointment::where('status', '=', 6)->whereDate('date', '=', date('Y-m-d'))->where('status_end', '!=', 1)->with(['service', 'patient', 'payment']);
        }
    }

}