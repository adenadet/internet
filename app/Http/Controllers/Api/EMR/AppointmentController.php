<?php

namespace App\Http\Controllers\Api\EMR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\Appointment;
use App\Models\EMR\Patient;
use App\Models\EMR\Schedule;
use App\Models\EMR\Service;
use App\Models\Area;
use App\Models\State;
use App\Models\Country;
use App\Models\User;

class AppointmentController extends Controller
{
    public function index()
    {
        return response()->json([
            'applicants' => User::whereIn('user_type', ['Patient', 'Both'])->orderBy('first_name', 'ASC')->with(['area', 'state',])->get(),
            'appointments' => Appointment::whereNotIn('status', [6, 7, 8, 9])->with(['service', 'patient'])->orderBy('date', 'DESC')->orderBy('schedule', 'ASC')->paginate(10),
            'nations' => Country::orderBy('name', 'ASC')->get(),   
            'patients'      => Patient::orderBy('last_name', 'ASC')->get(),
            'services'      => Service::orderBy('name', 'ASC')->get(),   
        ]);
    }

    public function initials()
    {
        return response()->json([
            'applicants' => User::whereIn('user_type', ['Patient', 'Both'])->orderBy('first_name', 'ASC')->with(['area', 'state',])->get(),
            'appointments' => Appointment::where('patient_id', auth('api')->id())->with(['service', 'patient'])->orderBy('date', 'ASC')->paginate(10),
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'services' => Service::orderBy('name', 'ASC')->get(),
            'states' => State::orderBy('name', 'ASC')->get(),
            'nations' => Country::orderBy('name', 'ASC')->get(), 
            'patient' => User::find(auth('api')->id()),     
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'patient_id' => 'required',
            'service_id' => 'required',
            'date' => 'required | date',
            'schedule' => 'sometimes',
        ]);

        $appointment = Appointment::create([
            'patient_id' => $request->input('patient_id'),
            'service_id' => $request->input('service_id'),
            'date'       => $request->input('date'),
            'schedule'   => $request->input('schedule'),
            'status'     => 0,
        ]);

        return response()->json([
            'applicants' => User::whereIn('user_type', ['Patient', 'Both'])->orderBy('first_name', 'ASC')->with(['area', 'state',])->get(),
            'appointments' => Appointment::with(['service', 'patient'])->orderBy('date', 'ASC')->paginate(10),
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'services' => Service::orderBy('name', 'ASC')->get(),
            'states' => State::orderBy('name', 'ASC')->get(),
            'nations' => Country::orderBy('name', 'ASC')->get(), 
            'patient' => User::find(auth('api')->id()),     
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'appointment' => Appointment::where('id',$id)->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee', 'consent', 'consultation'])->first(),
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function schedules()
    {
        //$date = \Request::get('date');
        //$service_id = \Request::get('service_id');
        if (($date = \Request::get('date')) && ($service_id = \Request::get('service_id'))){
            $taken = Appointment::select('schedule')->where([['date', '=', $date], ['service_id', '=', $service_id]])->get();
            $schedules = Schedule::select('schedule')->where('service_id', '=', $service_id)->whereNotIn('schedule', $taken)->get();
            }
        else{
            $schedules = Schedule::select('schedule')->where('service_id', '=', $service_id)->get();
        }
        
        return response()->json(['schedules' => $schedules,]);
    }

    public function to_doctor($id)
    {
        $appointment = Appointment::findOrfail($id);

        $appointment->status = 4;
        $appointment->arrived_at = date('Y-m-d H:i:s');
        $appointment->front_office_id = auth('api')->id();
        $appointment->front_office_remark = "<p>The patient has arrived for Consultation.</p>";
        
        $appointment->save();

        return response()->json([
            'appointment' => Appointment::where('id',$id)->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee' ])->first(),
        ]);
    }
}
