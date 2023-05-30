<?php

namespace App\Http\Controllers\Api\EMR;

use App\Http\Controllers\Controller;
use App\Models\EMR\Appointment;
use App\Models\EMR\Laboratory;
use Illuminate\Http\Request;

class LaboratoryController extends Controller
{
    public function index()
    {
        
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'appointment_id' => 'required',
            'summary' => 'required',
            'details' => 'required',
        ]);

        $appointment = Appointment::where('id', '=', $request->input('appointment_id'))->first();

        Laboratory::create([
            'appointment_id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
            'summary' => $request->input('summary'), 
            'details' => $request->input('details'), 
            'created_by' => auth('api')->id(), 
            'updated_by' => auth('api')->id(),
        ]);

        return response()->json([
            'appointment' => Appointment::where('id','=', $request->input('appointment_id'))->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee', 'consent', 'consultation', 'laboratory', 'lab_officer', 'report.findings', 'issuing_officer'])->first(),
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
