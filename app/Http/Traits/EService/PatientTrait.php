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

trait PatientTrait{
    public function patient_get_all(){
        return Patient::select('id', 'first_name', 'last_name', 'middle_name')->orderBy('last_name', 'ASC')->get();    
    }

    public function patient_get_all_paginated(){
        return Patient::orderBy('last_name', 'ASC')->paginate(50);    
    }
}