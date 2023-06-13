<?php

namespace App\Http\Controllers\Api\EMR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Bank;
use App\Models\EMR\Appointment;
use App\Models\EMR\Cancellation;

use App\Mail\CancelMail;

class CancellationController extends Controller
{
    public function index()
    {
        return response()->json([
            'banks' => Bank::orderBy('bank_name', 'ASC')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'account_name' => 'required',
            'account_number' => 'required',
            'bank_id' => 'required',
            'reason' => 'required',
            'tracking_id' => 'required',
        ]);

        $appointment = Appointment::where('transaction_id', '=', $request->input('tracking_id'))->where('status', '=', 1)->first();

        if ($appointment){
            $appointment->deleted_by = $appointment->patient_id;
            $appointment->deleted_at = date('Y-m-d H:i:s');

            $appointment->save();
        }
        else{
            return response()->json([
                'message' => 'Appointment has already been done',
            ]);
        }

        $cancellation = Cancellation::create([
            'appointment_id' => $appointment->id,
            'bank_id' => $request->input('bank_id'),
            'account_name' => $request->input('account_name'),
            'account_number' => $request->input('account_number'),
            'reason' => $request->input('reason'),
        ]);

        $consultation = Appointment::where('id', '=', $appointment->id)->with(['service', 'patient', 'cancellation.bank'])->first();

        \Mail::to($appointment->patient->email)->send(new CancelMail($consultation));

        return response()->json([
            'cancellation' => $cancellation,
        ]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        //
    }
}
