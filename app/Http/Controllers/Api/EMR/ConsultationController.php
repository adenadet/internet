<?php

namespace App\Http\Controllers\Api\EMR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\Appointment;
use App\Models\EMR\Consultation;
use App\Models\EMR\Patient;
use App\Models\EMR\Schedule;
use App\Models\EMR\Service;
use App\Models\Area;
use App\Models\State;
use App\Models\Country;
use App\Models\User;

class ConsultationController extends Controller
{
    public function index()
    {
        return response()->json([
            'appointments' => Appointment::whereDate('date', '>=', date('Y-m-d'))->whereIn('status', [6, 7, 8, 9, 10, 11])->with(['service', 'patient'])->orderBy('date', 'DESC')->orderBy('schedule', 'ASC')->paginate(30),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'remarks'       => 'required',
            'decision'      => 'required',
            'appointment_id'=> 'required'
        ]);

        $consultation = Consultation::create([
            'appointment_id'=> $request->input('appointment_id'),
            'all_previous_tb'=> $request->input('all_previous_tb') ?? false,
            'all_household_tb'=> $request->input('all_household_tb') ?? false,
            'all_recent_contact'=> $request->input('all_recent_contact') ?? false,
            'kid_respiratory'=> $request->input('kid_respiratory') ?? false,
            'kid_throaic_surgery'=> $request->input('kid_throaic_surgery') ?? false,
            'kid_cyanosis'=> $request->input('kid_cyanosis') ?? false,
            'kid_respiratory_insufficiency'=> $request->input('kid_respiratory_insufficiency') ?? false,
            'sym_cough'=> $request->input('sym_cough') ?? false,
            'sym_fever'=> $request->input('sym_fever') ?? false,
            'sym_haemoptysis'=> $request->input('sym_haemoptysis') ?? false,
            'sym_night_sweats'=> $request->input('sym_night_sweats') ?? false,
            'sym_weight_loss'=> $request->input('sym_weight_loss') ?? false,
            'decision'=> $request->input('decision'),
            'remarks'=> $request->input('remarks'),
            'created_by'=> auth('api')->id(),
            'updated_by'=> auth('api')->id(),
        ]);

        $appointment = Appointment::find($request->input('appointment_id'));

        $appointment->doctor_id = auth('api')->id();
        $appointment->doctor_at = date('Y-m-d H:i:s');
        $appointment->medical_officer_remark = $request->input('remarks');
        $appointment->status = $request->input('decision');

        $appointment->save();

        return response()->json([
            'appointment' => Appointment::where('id',$request->input('appointment_id'))->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee' ])->first(),
        ]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
