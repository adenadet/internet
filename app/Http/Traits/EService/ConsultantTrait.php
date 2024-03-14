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
use App\Models\EMR\Referral;
use App\Models\EMR\ReferralTemplate;

trait ConsultantTrait{
    public function consultant_create_referral($request){
        $referral = Referral::create([
            'appointment_id'    => $request->input('appointment_id'),
            'details'           => $request->input('details'),
            'created_by'        => auth('api')->id(),
            'updated_by'        => auth('api')->id(),
        ]);

        return $referral;
    }

    public function consultant_create_referral_template($request){
        $template = ReferralTemplate::create([
            'name'          => $request->input('name'),
            'content'       => $request->input('content'),
            'created_by'    => auth('api')->id(),
            'updated_by'    => auth('api')->id(),
        ]);

        return $template;
    }

    public function consultant_referral_templates(){
        return ReferralTemplate::all();
    }
}