<?php

namespace App\Http\Controllers\Api\EMR;

use App\Http\Controllers\Controller;
use App\Http\Traits\Eservice\AppointmentTrait;
use App\Models\EMR\Appointment;
use App\Models\EMR\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    use AppointmentTrait;
    public function destroy($id)
    {
        
    }

    public function home_office_report(Request $request){
        $this->validate($request, [
            'end_date' => 'required | date',
            'report_type' => 'required',
            'start_date' => 'required | date',
        ]);

        $appointments = $this->appointment_get_by_period($request->input('report_type'), $request->input('start_date'), $request->input('end_date'), true, false);

        return response()->json(['appointments' => $appointments,]);
    }

    public function index()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function show($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function summary_report(Request $request){
        $this->validate($request, [
            'report_type' => 'required',
            'end_date' => 'required | date',
            'start_date' => 'required | date',
        ]);

        switch ( $request->input('report_type')){
            case "all":
                $reports = Appointment::select(
                        'emr_appointments.date', DB::raw('count(emr_appointments.date) as total'),
                        DB::raw('SUM(CASE WHEN emr_consultations.decision = 6 THEN 1 ELSE 0 END) as x_ray'),
                        DB::raw('SUM(CASE WHEN emr_consultations.decision = 7 THEN 1 ELSE 0 END) as sputum'),
                        DB::raw('SUM(CASE WHEN emr_consultations.decision = 8 THEN 1 ELSE 0 END) as kid_under_11'),
                        DB::raw('SUM(CASE WHEN emr_consultations.decision = 10 THEN 1 ELSE 0 END) as postponed'),
                        DB::raw('SUM(CASE WHEN emr_appointments.doctor_at IS NULL THEN 1 ELSE 0 END) as missed')
                    )
                    ->leftJoin('emr_consultations', function($query){
                        $query->on('emr_appointments.id','=','emr_consultations.appointment_id')
                        ->whereRaw('emr_consultations.id IN (select MAX(a2.id) from emr_consultations as a2 join emr_appointments as u2 on u2.id = a2.appointment_id group by u2.id)');
                    })
                    ->where('status', '>', 1)
                    ->where('date', '>=', $request->input('start_date'))
                    ->where('date', '<=', $request->input('end_date'))
                    ->groupBy('date')
                    ->orderBy('date', 'ASC')
                    ->get();
                break;
            case "pending":
                $reports = Appointment::select(DB::raw('max(emr_appointments.date) as date'),
                        DB::raw('count(emr_appointments.date) as total_no'),
                        DB::raw('sum(emr_payments.amount) as total_amount'),
                        DB::raw('SUM(CASE WHEN emr_payments.amount = 60000 THEN 1 ELSE 0 END) as no_adult'),
                        DB::raw('SUM(CASE WHEN emr_payments.amount = 30000 THEN 1 ELSE 0 END) as no_kids'),
                        DB::raw('SUM(CASE WHEN emr_payments.amount <> 30000 AND emr_payments.amount <> 60000 THEN 1 ELSE 0 END) as no_strange'),
                        DB::raw('SUM(CASE WHEN emr_payments.amount = 60000 THEN 60000 ELSE 0 END) as total_adult'),
                        DB::raw('SUM(CASE WHEN emr_payments.amount = 30000 THEN 30000 ELSE 0 END) as total_kids'),
                        DB::raw('SUM(CASE WHEN emr_payments.amount <> 30000 AND emr_payments.amount <> 60000 THEN emr_payments.amount ELSE 0 END) as total_strange'),
                    )
                    ->leftJoin('emr_payments', function($query){
                        $query->on('emr_appointments.id','=','emr_payments.appointment_id')
                        ->whereRaw('emr_payments.id IN (select MAX(a2.id) from emr_payments as a2 join emr_appointments as u2 on u2.id = a2.appointment_id group by u2.id)');
                    })
                    ->where('status', '=', 1)
                    ->where('date', '>=', $request->input('start_date'))
                    ->where('date', '<=', $request->input('end_date'))
                    //->groupBy('date')
                    ->orderBy('date', 'ASC')
                    ->get();
                break;
            default:
                $reports = [];
         }
    
        return response()->json([
            'reports' => $reports,
            'report_type' => $request->input('report_type'),
        ]);
    }

    public function detailed_report(Request $request){
        $this->validate($request, [
            'report_type' => 'required',
            'date' => 'required | date',
        ]);

        $appointments = [];
        switch ( $request->input('report_type')){
            case "all":
                $appointments = Appointment::select('emr_appointments.*',
                    DB::raw('(select (CASE 
                    WHEN emr_consultations.decision = 6 THEN "Xray" 
                    WHEN emr_consultations.decision = 7 THEN "Sputum"
                    WHEN emr_consultations.decision = 8 THEN "Kid under 11"
                    WHEN emr_consultations.decision = 10 THEN "Postponed_or_cancelled"
                    WHEN emr_consultations.decision IS NULL THEN "Missed_appointment"
                    ELSE "Missed Appointment" END
                    ) as decision 
                    from emr_consultations where emr_consultations.appointment_id = emr_appointments.id  and emr_consultations.deleted_at IS NULL order by id asc limit 1) as decision') )
                    ->where('date', '=', $request->input('date'))
                    //->where('status', '>', 1)
                    ->orderBy('unique_id', 'ASC')
                    ->with(['medical_officer', 'radiologist', 'patient', 'laboratory', 'report', 'issuing_officer'])
                    ->get();
                break;
            case "started":
                $appointments = Appointment::select('emr_appointments.*',
                    DB::raw('(select (CASE 
                    WHEN emr_consultations.decision = 6 THEN "Xray" 
                    WHEN emr_consultations.decision = 7 THEN "Sputum"
                    WHEN emr_consultations.decision = 8 THEN "Kid under 11"
                    WHEN emr_consultations.decision = 10 THEN "Postponed_or_cancelled"
                    WHEN emr_consultations.decision IS NULL THEN "Missed_appointment"
                    ELSE "Missed Appointment" END
                    ) as decision 
                    from emr_consultations where emr_consultations.appointment_id = emr_appointments.id  and emr_consultations.deleted_at IS NULL order by id asc limit 1) as decision') )
                    ->where('date', '=', $request->input('date'))
                    ->where('status', '>', 1)
                    ->orderBy('unique_id', 'ASC')
                    ->with(['medical_officer', 'radiologist', 'patient', 'laboratory', 'report', 'issuing_officer'])
                    ->get();
                break;
            case "completed":
                $appointments = Appointment::select('emr_appointments.*',
                    DB::raw('(select (CASE 
                    WHEN emr_consultations.decision = 6 THEN "Xray" 
                    WHEN emr_consultations.decision = 7 THEN "Sputum"
                    WHEN emr_consultations.decision = 8 THEN "Kid under 11"
                    WHEN emr_consultations.decision = 10 THEN "Postponed_or_cancelled"
                    WHEN emr_consultations.decision IS NULL THEN "Missed_appointment"
                    ELSE "Missed Appointment" END
                    ) as decision 
                    from emr_consultations where emr_consultations.appointment_id = emr_appointments.id  and emr_consultations.deleted_at IS NULL order by id asc limit 1) as decision') )
                    ->where('date', '=', $request->input('date'))
                    ->where('status', '=', 10)
                    ->orderBy('unique_id', 'ASC')
                    ->with(['medical_officer', 'radiologist', 'patient', 'laboratory', 'report', 'issuing_officer'])
                    ->get();
                break;
            case "missed":
                $appointments = Appointment::select('emr_appointments.*',
                    DB::raw('(select (CASE 
                    WHEN emr_consultations.decision = 6 THEN "Xray" 
                    WHEN emr_consultations.decision = 7 THEN "Sputum"
                    WHEN emr_consultations.decision = 8 THEN "Kid under 11"
                    WHEN emr_consultations.decision = 10 THEN "Postponed_or_cancelled"
                    WHEN emr_consultations.decision IS NULL THEN "Missed_appointment"
                    ELSE "Missed Appointment" END
                    ) as decision 
                    from emr_consultations where emr_consultations.appointment_id = emr_appointments.id  and emr_consultations.deleted_at IS NULL order by id asc limit 1) as decision') )
                    ->where('date', '=', $request->input('date'))
                    ->where('status', '=', 1)
                    ->orderBy('unique_id', 'ASC')
                    ->with(['medical_officer', 'radiologist', 'patient', 'laboratory', 'report', 'issuing_officer'])
                    ->get();
                break;
            default:
                $appointment = [];
        }
        return response()->json([
            'appointments' => $appointments,
        ]);
    }
}
