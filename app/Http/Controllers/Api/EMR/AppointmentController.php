<?php

namespace App\Http\Controllers\Api\EMR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\Appointment;
use App\Models\EMR\Patient;
use App\Models\EMR\RadFinding;
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
            'appointments' => Appointment::whereDate('date', '>=', date('Y-m-d'))->with(['service', 'patient'])->orderBy('date', 'ASC')->orderBy('schedule', 'ASC')->paginate(30),
            'nations' => Country::orderBy('name', 'ASC')->get(),   
            'patients'      => Patient::orderBy('last_name', 'ASC')->get(),
            'services'      => Service::orderBy('name', 'ASC')->get(),   
            'findings'      => RadFinding::all(),
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
            'nations' => Country::orderBy('name', 'ASC')->get(), 
            'patients' => Patient::orderBy('last_name', 'ASC')->get()     
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'appointment' => Appointment::where('id',$id)->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee', 'consent', 'consultation', 'report.findings', 'issuing_officer'])->first(),
            'findings'    => RadFinding::all(),
            'nations' => Country::orderBy('name', 'ASC')->get(), 
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $appointment = Appointment::where('id',$id)->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee', 'consent', 'consultation', 'report.findings', 'issuing_officer'])->first();
        if (!is_null($appointment->payment)){
            $message = "Appointment has already been paid for, you can only reschedule.";
        }
        else if (!is_null(($appointment->report)) || !is_null(($appointment->consultation)) || !is_null(($appointment->consent)) || !is_null(($appointment->front_officer))){
            $message = "Appointment has already been completed, you can not delete.";
        }
        else{
            $appointment->status = -1;
            $appointment->deleted_by = auth('api')->id();
            $appointment->deleted_at = date('Y-m-d H:i:s');
            $appointment->save();

            $message = "Appointment was deleted successfully";
        }
    }

    public function schedules()
    {
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

    public function certificates(){
        $appointments = Appointment::whereNotNull(['radiologist_id', 'doctor_id', 'front_office_id', 'issuing_officer'])->orWhere('status', '>=', 7)->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee', 'consent', 'consultation', 'report.findings', 'issuing_officer'])->orderBy('date', 'DESC')->paginate(52);
        
        return response()->json([
            'appointments' => $appointments,
        ]);
    }

    public function issue(Request $request, $id)
    {
        $this->validate($request, [
            'issue_action' => 'required',
            'issue_detail' => 'required',
        ]);

        $appointment = Appointment::find($id);

        $appointment->issuer = auth('api')->id();
        $appointment->issue_action = $request->input('issue_action');
        $appointment->issue_detail = $request->input('issue_detail');
        $appointment->issue_at =date('Y-m-d H:i:s');
        $appointment->status = 8;

        $appointment->save();

        return response()->json([
            'appointment' => Appointment::where('id',$id)->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee', 'consent', 'consultation', 'report.findings', 'issuing_officer'])->first(),
            'findings'    => RadFinding::all(),
            'nations'   => Country::orderBy('name', 'ASC')->get(), 
        ]);

    }

    public function missed(){
        $appointments = Appointment::whereNull(['front_office_id',])->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee', 'consent', 'consultation', 'report.findings', 'issuing_officer'])->orderBy('date', 'DESC')->paginate(30);
        
        return response()->json([
            'appointments' => $appointments,
        ]);
    }


    public function search(){
        if ($search = \Request::get('q')){
            $patients = Patient::select('id')->orderBy('first_name', 'ASC')->where(function($query) use ($search){
                $query->where('first_name', 'LIKE', "%$search%")
                ->orWhere('middle_name', 'LIKE', "%$search%")
                ->orWhere('last_name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('unique_id', 'LIKE', "%$search%");
                })->get();
            }
        else{
            $applicants = Patient::orderBy('first_name', 'ASC')->paginate(52);
        }

        $appointments = Appointment::whereNull(['front_office_id',])->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee', 'consent', 'consultation', 'report.findings', 'issuing_officer'])->orderBy('date', 'DESC')->paginate(30);
        
        return response()->json([
            'appointments' => $appointments,
        ]);
    }

}
