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
use App\Models\EMR\Payment;

class RegistrationController extends Controller
{
    public function index()
    {
        return response()->json([
            'nations' => Country::orderBy('name', 'ASC')->get(),   
            'services'      => Service::orderBy('name', 'ASC')->get(),   
        ]);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'last_name' => 'required',
            'first_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'nigerian_address' => 'required',
            'uk_address' => 'required',
            'service_id' => 'required',
            'date' => 'required | date',
            'schedule' => 'sometimes',
            'passport_no' => 'required',
            'visa_type' => 'required',
        ]);


        $image_url = $currentPhoto = null;
        $passport_image_url = $currentPassportPhoto = null;

        if (($request['image'] != $currentPhoto) && ($request['image'] != '')){
            $image = $request['id']."-".time().".".explode('/',explode(':', substr( $request['image'], 0, strpos($request['image'], ';')))[1])[1];
            \Image::make($request['image'])->save(public_path('img/applicants/').$image);
            $image_url = $image;
            $old_image = public_path('img/applicants/').$currentPhoto;

            if (file_exists($old_image)){ @unlink($old_image); }
        }

        if (($request['passport_image'] != $currentPhoto) && ($request['passport_image'] != '')){
            $image = $request['id']."-".time().".".explode('/',explode(':', substr( $request['passport_image'], 0, strpos($request['passport_image'], ';')))[1])[1];
            \Image::make($request['passport_image'])->save(public_path('img/passports/').$image);
            $passport_image_url = $passport_image;
            $old_image = public_path('img/passports/').$currentPassportPhoto;

            if (file_exists($old_image)){ @unlink($old_image); }
        }
        
        $patient = Patient::create([
            'last_name'     => $request->input('last_name'),
            'first_name'    => $request->input('first_name'),
            'middle_name'   => $request->input('middle_name'),
            'dob' => $request->input('dob'),
            'sex' => $request->input('sex'),
            'image' => $image_url,
            'passport_page' => $passport_image_url,
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
            'created_by' => 0,
        ]);

        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'service_id' => $request->input('service_id'),
            'date'       => $request->input('date'),
            'schedule'   => $request->input('schedule'),
            'status'     => 0,
        ]);

        $payment = Payment::create([
            'service_id' => $request->input('service_id'), 
            'patient_id' => $patient->id, 
            'appointment_id' => $appointment->id,
            'amount' => $request->input('amount'), 
            'employee_id' => 0,
            'channel' => "Paystack", 
            'details' => $request->input('payment_transaction').' | '.$request->input('payment_reference'),    
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
}
