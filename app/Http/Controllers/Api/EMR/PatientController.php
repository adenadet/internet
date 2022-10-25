<?php

namespace App\Http\Controllers\Api\EMR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\Appointment;
use App\Models\EMR\Patient;
use App\Models\EMR\Service;
use App\Models\Area;
use App\Models\State;
use App\Models\Country;
use App\Models\User;

class PatientController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        Patient::create([
            'last_name'     => $request->input('last_name'),
            'first_name'    => $request->input('first_name'),
            'middle_name'   => $request->input('middle_name'),
            'dob' => $request->input('dob'),
            'sex' => $request->input('sex'),
            'image' => $request->input('image'),
            'passport_page' => $request->input('passport_image'),
            'lmp' => $request->input('lmp'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'alt_phone' => $request->input('alt_phone'),
            'nigerian_address' => $request->input('nigerian_address'),
            'uk_address' => $request->input('uk_address'),
            'accompanying_kids' => $request->input('accompanying_kids'),
            'nationality_id' => $request->input('nationality_id'),
            'passport_no' => $request->input('passport_no'),
            'visa_type' => $request->input('visa_type'),
        ]);

        return response()->json([
            'applicants' => User::whereIn('user_type', ['Patient', 'Both'])->orderBy('first_name', 'ASC')->with(['area', 'state',])->get(),
            'appointments' => Appointment::where('patient_id', auth('api')->id())->with(['service', 'patient'])->orderBy('date', 'ASC')->paginate(10),
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'services' => Service::orderBy('name', 'ASC')->get(),
            'states' => State::orderBy('name', 'ASC')->get(),
            'nations' => Country::orderBy('name', 'ASC')->get(), 
            'patients' => Patient::orderBy('first_name', 'ASC')->get(),     
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
