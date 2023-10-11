<?php
namespace App\Http\Controllers\Api\EMR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\Appointment;
use App\Models\EMR\Cancellation;
use App\Models\EMR\Patient;
use App\Models\EMR\RadFinding;
use App\Models\EMR\Schedule;
use App\Models\EMR\Service;
use App\Models\Area;
use App\Models\State;
use App\Models\Country;
use App\Models\User;
use App\Models\EMR\Payment;

use App\Mail\RegistrationMail as RegMail;
use App\Mail\RescheduleMail as ResMail;


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
            'email' => 'required',
            'service_id' => 'required',
            'date' => 'required | date',
            'schedule' => 'sometimes',
        ]);

        $patient = Patient::create([
            'last_name'     => $request->input('last_name'),
            'first_name'    => $request->input('first_name'),
            'middle_name'   => $request->input('middle_name'),
            'dob' => $request->input('dob'),
            'sex' => $request->input('sex'),
            'image' => NULL,
            'passport_page' => NULL,
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
            'status'     => 1,
            'created_by' => 0,
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

        $appointment->transaction_id = "SNH-".$appointment->id."-".$payment->id."-".$patient->id;
        $appointment->save();

        $consultation = Appointment::where('id', '=', $appointment->id)->with(['service', 'patient', 'payment'])->first();

        $dayOfWeek = date('w', strtotime($request->input('date')));
        if ($dayOfWeek != 0 || $dayOfWeek != 6) {
            \Mail::to($patient->email)->send(new RegMail($consultation));
            return response()->json([
                'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
                'services' => Service::orderBy('name', 'ASC')->get(),
                'nations' => Country::orderBy('name', 'ASC')->get(), 
                'patients' => Patient::orderBy('last_name', 'ASC')->get()     
            ]);
        }

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
            $old_image = public_path('img/passports/').$currentPassportPhoto;

            if (file_exists($old_image)){ @unlink($old_image); }
        }

        $patient->image = $image_url;
        
        $patient->save();
        
        return response()->json([
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'services' => Service::orderBy('name', 'ASC')->get(),
            'nations' => Country::orderBy('name', 'ASC')->get(), 
            'patients' => Patient::orderBy('last_name', 'ASC')->get()     
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'appointment' => Appointment::where('transaction_id', '=', $id)->where('status', '=', 1)->with(['service', 'patient', 'payment'])->first(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'preferred_date' => 'required|date',
            'preferred_time' => 'required',
            'tracking_id' => 'required'
        ]);

        $appointment = Appointment::where('transaction_id', '=', $request->input('tracking_id'))->with(['service', 'patient', 'payment'])->first();

        $appointment->date = $request->input('preferred_date');
        $appointment->schedule = $request->input('preferred_time');

        $appointment->save();

        $consultation = Appointment::where('id', '=', $appointment->id)->with(['service', 'patient', 'payment'])->first();

        \Mail::to($appointment->patient->email)->send(new ResMail($consultation));

        return response()->json([
            'appointment' => Appointment::where('transaction_id', '=', $id)->with(['service', 'patient', 'payment'])->first(),
            'message' => 'Cancelled successfully',
        ]);
    }

    public function destroy($id)
    {
        //
    }

    public function resend($id)
    {
        $appointment = Appointment::where('id', '=', $id)->first();
        $payment = Payment::where('appointment_id', '=', $id)->first();

        if ((is_null($appointment)) || (is_null($payment))){
            return response()->json([
                'message' => 'Appointment has not been paid or does not exist',
                'status' => 'error',
            ]);
        }

        $appointment->transaction_id = "SNH-".$appointment->id."-".$payment->id."-".$appointment->patient_id;
        $appointment->save();

        $consultation = Appointment::where('id', '=', $appointment->id)->with(['service', 'patient', 'payment'])->first();
        if(is_null($consultation->patient->email)){
            return response()->json([
                'message' => 'Patient does not have a valid email address',
                'status' => 'error',
            ]);
        }
        \Mail::to($consultation->patient->email)->send(new RegMail($consultation));
        return response()->json([
            'message' => 'Mail has been resent successfully',
            'status' => 'success',
        ]);
    }
    public function schedules()
    {
      	$date = \Request::get('date');
      	$public_holidays = ['2023-01-02', '2023-06-28', '2023-06-29', '2023-06-30', '2023-07-19', '2023-10-02', '2023-09-23', '2023-09-23', '2023-12-24', '2023-12-25', '2023-12-26', '2023-12-27'];
        if (in_array($date, $public_holidays)){
        	$schedules = [];
        }
        else if (($date = \Request::get('date')) && ($service_id = \Request::get('service_id'))){
            $taken = Appointment::select('schedule')->where([['date', '=', $date]])->get();
            $schedules = Schedule::select('schedule')->where('service_id', '=', $service_id)->whereNotIn('schedule', $taken)->get();
            }
        else{
            $schedules = Schedule::select('schedule')->where('service_id', '=', $service_id)->get();
        }
        
        return response()->json(['schedules' => $schedules,]);
    }
}
