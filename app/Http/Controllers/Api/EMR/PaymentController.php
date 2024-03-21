<?php

namespace App\Http\Controllers\Api\EMR;

use App\Http\Controllers\Controller;
use App\Models\EMR\Appointment;
use App\Models\EMR\Payment;
use App\Models\EMR\Service;
use Illuminate\Http\Request;

use App\Http\Traits\EService\AppointmentTrait;
use App\Http\Traits\EService\PaymentTrait;

class PaymentController extends Controller
{
    use AppointmentTrait, PaymentTrait;
    public function index()
    {
        return response()->json([
            'payments' => Payment::with(['service', 'patient', 'appointment', 'employee'])->latest()->paginate(30),
            'unpaid_appointments' => Appointment::where('status', 0)->with(['service', 'patient'])->orderBy('date', 'ASC')->get(),
        ]);
    }

    public function initials()
    {
        return response()->json([
            'payments' => Payment::where('patient_id', '=', auth('api')->id())->with(['service', 'patient', 'appointment', 'employee'])->latest()->paginate(10),
            'unpaid_appointments' => Appointment::where(['status', 0], ['patient_id', auth('api')->id()])->with(['service', 'patient'])->orderBy('date', 'ASC')->get(),
        ]);
    }

    public function store(Request $request)
    {
        //Validate the request
        $this->validate($request, [
            'service_id' => 'required|numeric',
            'patient_id' => 'required|numeric',
            'appointment_id' => 'required|numeric',
            'channel'=> 'required|string',
            'amount'=> 'required|numeric',
            'details' => 'nullable|string',
        ]);

        //Insert Payment
        $payment = $this->payment_create_new($request);
        
        //Return Values
        return response()->json([
            'payment' => $this->payment_get_by_id($payment->id),
            'payments' => $this->payment_get_all(),
            'appointments' => $this->appointment_get_all(NULL, 1, true, 'ASC'),
            'appointment' => $this->appointment_get_by_id($request->input('appointment_id'), NULL),
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'payment' => $this->payment_get_by_id($id),
            'payments' => $this->payment_get_all(),
            'appointments' => $this->appointment_get_all(NULL, 1, true, 'ASC'),
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

    public function report(Request $request)
    {
        
    }
}
