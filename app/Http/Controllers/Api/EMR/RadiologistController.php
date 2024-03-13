<?php

namespace App\Http\Controllers\Api\EMR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\Appointment;
use App\Models\EMR\Patient;
use App\Models\EMR\RadFinding;
use App\Models\EMR\Report;
use App\Models\EMR\ReportFinding;
use App\Models\EMR\Schedule;
use App\Models\EMR\Service;
use App\Models\Area;
use App\Models\State;
use App\Models\Country;
use App\Models\User;


class RadiologistController extends Controller
{
    public function index()
    {
        return response()->json([
            'findings'      => RadFinding::orderBy('code', 'ASC')->get(), 
            'reports'       => Appointment::whereNull('radiologist_id')->Where('status', '=', 6)->with(['service', 'patient',])->orderBy('date', 'DESC')->orderBy('schedule', 'ASC')->paginate(10),
            'nations'       => Country::orderBy('name', 'ASC')->get(),   
            'patients'      => Patient::orderBy('last_name', 'ASC')->get(),
            'services'      => Service::orderBy('name', 'ASC')->get(),  
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'appointment_id' => 'required',
            'patient_id'     => 'required',
            'summary'        => 'required',
            'details'         => 'required',
        ]);

        $report = Report::create([
            'appointment_id' => $request->input('appointment_id'), 
            'patient_id' => $request->input('patient_id'), 
            'summary' => $request->input('summary'), 
            'details' => $request->input('details'), 
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(), 
        ]);

        foreach ($request->input('findings') as $finding){
            ReportFinding::create([
                'report_id' => $report->id,
                'finding_id' => $finding,
            ]);
        }

        $appointment = Appointment::findorfail($request->input('appointment_id'));
        
        $appointment->radiologist_id = auth('api')->id();
        $appointment->radiologist_remark =  $request->input('details');
        $appointment->radiologist_at = date('Y-m-d H:i:s');
        $appointment->status = 7;

        $appointment->save();
 
        return response()->json([
            'findings'      => RadFinding::orderBy('code', 'ASC')->get(), 
            'report'        => Appointment::where('id',$request->input('appointment_id'))->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee' ])->first(),
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

        $app_query = Appointment::whereIn('patient_id', $patients)->where('status', '>=', 6);
        if (!is_null($request->input('start_date'))){$app_query->whereDate('date', '>=', $request->input('start_date'));}
        if (!is_null($request->input('end_date'))){$app_query->whereDate('date', '<=', $request->input('end_date'));}
        $reports = $app_query->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee', 'consent', 'consultation', 'report.findings', 'issuing_officer'])->paginate(30);

        return response()->json([
            'findings'      => RadFinding::orderBy('code', 'ASC')->get(), 
            'reports'       => $reports,
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'findings'      => RadFinding::orderBy('code', 'ASC')->get(), 
            'report' => Appointment::where('id',$id)->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee', 'report.findings', 'consent' ])->first(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'appointment_id' => 'required',
            'patient_id'     => 'required',
            'summary'        => 'required',
            'findings'       => 'required',
            'details'         => 'required',
        ]);

        $report = Report::find($id);

        $report->summary = $request->input('summary'); 
        $report->details = $request->input('details'); 
        $report->updated_by = auth('api')->id();
        
        $report->save();
        
        $report_finding = ReportFinding::where('report_id', '=', $id)->delete();

        foreach ($request->input('findings') as $finding){
            ReportFinding::create([
                'report_id' => $report->id,
                'finding_id' => $finding,
            ]);
        }

        $appointment = Appointment::findorfail($request->input('appointment_id'));
        
        $appointment->radiologist_id = auth('api')->id();
        $appointment->radiologist_remark =  $request->input('details');
        $appointment->radiologist_at = date('Y-m-d H:i:s');
        $appointment->status = 7;

        $appointment->save();
 
        return response()->json([
            'findings'      => RadFinding::orderBy('code', 'ASC')->get(), 
            'report'        => Appointment::where('id',$request->input('appointment_id'))->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee' ])->first(),
        ]);
    }

    public function destroy($id)
    {
        
    }

    public function reviews(){
        return response()->json([
            'findings'      => RadFinding::orderBy('code', 'ASC')->get(), 
            'reports'       => Appointment::where('status', '>', 6)->with(['service', 'patient', 'report.findings', 'radiologist'])->orderBy('radiologist_at', 'DESC')->orderBy('schedule', 'ASC')->paginate(30),
            'nations'       => Country::orderBy('name', 'ASC')->get(),   
            'patients'      => Patient::orderBy('last_name', 'ASC')->get(),
            'services'      => Service::orderBy('name', 'ASC')->get(),  
        ]);
    }
}