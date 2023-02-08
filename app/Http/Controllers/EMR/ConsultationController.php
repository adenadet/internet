<?php

namespace App\Http\Controllers\Api\EMR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\Appointment;
use App\Models\EMR\Patient;


class ConsultationController extends Controller
{
    public function index()
    {
        return response()->json([
            'consultations' => Appointment::all(),
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $consultation = Appointment::find($id)->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality' ])->first();

        $patient = Patient::where('id', '=', $consultation->patient_id)->with('nationality')->first();

        return response()->json([
            'consultation' => $consultation,
            'patient'      => $patient,
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
}
