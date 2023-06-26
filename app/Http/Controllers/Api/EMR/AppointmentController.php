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

use Dompdf\Adapter\PDFLib;
use PDF;
use Mail;
use App\Mail\Certificate\NormalMail;

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
            'applicants' => User::whereIn('user_type', ['Patient', 'Both'])->orderBy('fir`st_name', 'ASC')->with(['area', 'state',])->get(),
            'appointments' => Appointment::whereDate('date', '>=', date('Y-m-d'))->where('patient_id', auth('api')->id())->with(['service', 'patient'])->orderBy('date', 'ASC')->orderBy('schedule', 'ASC')->paginate(10),
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
            'schedule' => 'required',
        ]);

        $appointment = Appointment::create([
            'patient_id' => $request->input('patient_id'),
            'service_id' => $request->input('service_id'),
            'date'       => $request->input('date'),
            'schedule'   => $request->input('schedule'),
            'status'     => 0,
            'created_by' => auth('api')->id(),
        ]);

        return response()->json([
            'applicants' => User::whereIn('user_type', ['Patient', 'Both'])->orderBy('first_name', 'ASC')->with(['area', 'state',])->get(),
            'appointments' => Appointment::whereDate('date', '>=', date('Y-m-d'))->with(['service', 'patient'])->orderBy('date', 'ASC')->orderBy('schedule', 'ASC')->paginate(50),
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'services' => Service::orderBy('name', 'ASC')->get(),
            'nations' => Country::orderBy('name', 'ASC')->get(), 
            'patients' => Patient::orderBy('last_name', 'ASC')->get()     
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'appointment' => Appointment::where('id',$id)->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee', 'consent', 'consultation', 'laboratory', 'lab_officer', 'report.findings', 'issuing_officer'])->first(),
            'findings'    => RadFinding::all(),
            'nations' => Country::orderBy('name', 'ASC')->get(), 
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'id' => 'required | numeric',
            'patient_id' => 'required',
            'service_id' => 'required',
            'date' => 'required | date',
            'schedule' => 'required',
        ]);

        $appointment = Appointment::find($request->input('id'));

        $appointment->patient_id = $request->input('patient_id');
        $appointment->service_id = $request->input('service_id');
        $appointment->date = $request->input('date');
        $appointment->schedule = $request->input('schedule');
        //$appointment->updated_by = auth('api')->id();

        $appointment->save();

        return response()->json([
            'applicants' => User::whereIn('user_type', ['Patient', 'Both'])->orderBy('first_name', 'ASC')->with(['area', 'state',])->get(),
            'appointments' => Appointment::whereDate('date', '>=', date('Y-m-d'))->with(['service', 'patient'])->orderBy('date', 'ASC')->orderBy('schedule', 'ASC')->paginate(50),
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'services' => Service::orderBy('name', 'ASC')->get(),
            'nations' => Country::orderBy('name', 'ASC')->get(), 
            'patients' => Patient::orderBy('last_name', 'ASC')->get()     
        ]);
    }

    public function destroy($id)
    {
        $appointment = Appointment::where('id','=',$id)->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee', 'consent', 'consultation', 'report.findings', 'issuing_officer'])->first();
        
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

            //$appointment = Appointment::find($id);

            //$appointment->deleted_by = auth('api')->id();
            //$appointment->deleted_at = date('Y-m-d H:i:s');

            //$appointment->save();

            return response()->json([
                'applicants' => Patient::orderBy('created_at', 'DESC')->with(['nationality',])->paginate(100),
                'appointments' => Appointment::where('patient_id', auth('api')->id())->with(['service', 'patient'])->orderBy('date', 'ASC')->orderBy('schedule', 'ASC')->paginate(50),
                'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
                'services' => Service::orderBy('name', 'ASC')->get(),
                'states' => State::orderBy('name', 'ASC')->get(),
                'nations' => Country::orderBy('name', 'ASC')->get(), 
                'patients' => Patient::orderBy('first_name', 'ASC')->get(), 
                'message' => $message,    
            ]);
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
        $last_month = date('Y-m-d', strtotime('-1 month'));
        $appointments = Appointment::whereDate('date', '>=', $last_month)->whereDate('date', '<=', date('Y-m-d'))->whereNotNull(['doctor_id', 'front_office_id',])->Where('status', '>=', 7)->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee', 'consent', 'consultation', 'report.findings', 'issuing_officer'])->orderBy('date', 'DESC')->paginate(70);
        
        return response()->json([
            'appointments' => $appointments,
        ]);
    }

    public function issue(Request $request, $id)
    {
        $this->validate($request, [
            'issue_action' => 'sometimes',
            'issue_detail' => 'sometimes',
        ]);

        $appointment = Appointment::find($id);

        $appointment->issuer = auth('api'->id());
        $appointment->issue_action = $request->input('issue_action');
        $appointment->issue_detail = $request->input('issue_detail');
        $appointment->issue_at =date('Y-m-d H:i:s');
        $appointment->status = 10;

        $appointment->save();

        $consultation = Appointment::where('id', '=', $id)->with(['service', 'patient'])->first()->toArray();
        $app = Appointment::where('id', '=', $id)->with(['service', 'patient'])->first();

        if (is_null($app)){
            return response()->json([
                'message' => 'Error invalid ID',
            ]);
        }

        /* Option 1, Not interacting with the template for now
        $pdf = \PDF::loadView('certificates.normal', $consultation);

        \Mail::send('mails.certificates.normal', $consultation, function ($message) use ($consultation, $pdf) {
            $message->to($consultation['patient']['email'], $consultation['patient']['email'])
                ->subject('Certificate for'.$consultation['service']['name'].' '.$consultation['patient']['first_name'].' '.$consultation['patient']['last_name'])
                ->attachData($pdf->output(), $consultation['service']['name']." Certificate for ".$consultation['patient']['first_name']." ".$consultation['patient']['last_name'].".pdf");
        });*/

        /* Option 2, Using Mail */
        \Mail::to($app->patient->email)->send(new NormalMail($app));

        return response()->json([
            'appointment' => Appointment::where('id',$id)->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee', 'consent', 'consultation', 'report.findings', 'issuing_officer'])->first(),
        ]);

    }

    public function missed(){
        $appointments = Appointment::whereDate('date', '<=', date('Y-m-d'))->whereNull(['front_office_id',])->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee', 'consent', 'consultation', 'report.findings', 'issuing_officer'])->orderBy('date', 'DESC')->paginate(30);
        
        return response()->json([
            'appointments' => $appointments,
        ]);
    }

    public function getXray(){
        $appointments = Appointment::where('status', '=', 6)
        ->whereDate('date', '=', date('Y-m-d'))
        ->where('status_end', '!=', 1)
        ->with(['front_officer', 'medical_officer', 'radiologist','lab_officer', 'service', 'patient.nationality', 'payment.employee', 'consent', 'consultation', 'report.findings', 'issuing_officer'])
        ->orderBy('date', 'DESC')->paginate(30);
        
        return response()->json([
            'appointments' => $appointments
        ]);
    }

    public function postXray(Request $request, $id){
        $appointment = Appointment::find($id);

        $appointment->status_end = true;
        $appointment->xray_officer_id = auth('api')->id();
        $appointment->xray_at = date('Y-m-d H:i:s');

        $appointment->save();

        $appointments = Appointment::where('status', '=', 6)
        ->whereDate('date', '=', date('Y-m-d'))
        ->where('status_end', '!=', 1)
        ->with(['front_officer', 'medical_officer', 'radiologist','lab_officer', 'service', 'patient.nationality', 'payment.employee', 'consent', 'consultation', 'report.findings', 'issuing_officer'])
        ->orderBy('date', 'DESC')->paginate(30);
        
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

            $appointments = Appointment::whereIn('patient_id', $patients)->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee', 'consent', 'consultation', 'report.findings', 'issuing_officer'])->orderBy('date', 'DESC')->paginate(30);
        }
        else{
            $appointments = Appointment::whereNull(['front_office_id',])->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee', 'consent', 'consultation', 'report.findings', 'issuing_officer'])->orderBy('date', 'DESC')->paginate(30);        
        }

        return response()->json([
            'appointments' => $appointments,
        ]);
    }

    public function search_appointment(Request $request)
    {
        $this->validate($request, [
            'patient' => 'required',
            'start_date' => 'nullable | sometimes | date',
            'end_date' => 'nullable | sometimes | date',
        ]);
        //Search for Patients
        $search = $request->input('patient');

        $patients = Patient::select('id')->orderBy('first_name', 'ASC')->where(function($query) use ($search){
            $query->where('first_name', 'LIKE', "%$search%")
            ->orWhere('middle_name', 'LIKE', "%$search%")
            ->orWhere('last_name', 'LIKE', "%$search%")
            ->orWhere('email', 'LIKE', "%$search%");
        })->get();

        $app_query = Appointment::whereIn('patient_id', $patients);
        if (!is_null($request->input('start_date'))){$app_query->whereDate('date', '>=', $request->input('start_date'));}
        if (!is_null($request->input('end_date'))){$app_query->whereDate('date', '<=', $request->input('end_date'));}
        $appointments = $app_query->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee', 'consent', 'consultation', 'report.findings', 'issuing_officer'])->paginate(30);

        return response()->json([
            'appointments'  => $appointments,
            'nations'       => Country::orderBy('name', 'ASC')->get(),   
            'patients'      => Patient::orderBy('last_name', 'ASC')->get(),
            'services'      => Service::orderBy('name', 'ASC')->get(),   
        ]);
    }

    public function toDoctor(Request $request, $id){

        $this->validate($request, [
            'unique_id' => 'required',
            'details' => 'required',
        ]);

        $appointment = Appointment::findOrfail($id);

        $appointment->status = 4;
        $appointment->arrived_at = date('Y-m-d H:i:s');
        $appointment->front_office_id = auth('api')->id();
        $appointment->front_office_remark = $request->input('details');
        $appointment->unique_id = $request->input('unique_id');
        
        $appointment->save();

        return response()->json([
            'appointment' => Appointment::where('id',$id)->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee' ])->first(),
        ]);
    }
}
