<?php

namespace App\Http\Controllers\Api\EMR;

use App\Http\Controllers\Controller;
use App\Models\EMR\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return response()->json([
            'appointments' => Appointment::whereNOTIN('status', [6, 7, 8, 9])->with(['service', 'patient'])->orderBy('date', 'ASC')->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return response()->json([
            'appointment' => Appointment::where('id',$id)->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality' ])->first(),
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
