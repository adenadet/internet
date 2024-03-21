<?php
namespace App\Http\Traits\EService;

use App\Models\EMR\Appointment;
use App\Models\EMR\Payment;
use App\Models\EMR\Service;

use App\Http\Traits\EService\AppointmentTrait; 

trait PaymentTrait{
    public function payment_create_new($request){
        $payment = Payment::create([
            'service_id' => $request->input('service_id'), 
            'patient_id' => $request->input('patient_id'), 
            'appointment_id' => $request->input('appointment_id'),
            'amount' => $request->input('amount'), 
            'employee_id' => $request->input('employee_id') ?? auth('api')->id(),
            'channel' => $request->input('channel'), 
            'details' => $request->input('details'),    
        ]);
        
        //Update the appointment with payment details
        $appointment = Appointment::find($request->input('appointment_id'));

        $appointment->status = 1;
        $appointment->payment_channel = $payment->channel;
        $appointment->paid_by = auth('api')->id();
        $appointment->save();

        return $payment;
    }
    
    public function payment_get_all(){
        return Payment::with(['service', 'patient'])->latest()->paginate(100);
    }

    public function payment_get_by_id($id){
        return Payment::where('id', '=', $id)->with(['service', 'patient'])->first();
    }

    
}