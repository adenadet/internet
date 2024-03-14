<?php

namespace App\Http\Controllers\Api\EMR;

use App\Http\Controllers\Controller;
use App\Models\EMR\Appointment;
use App\Models\EMR\Referral;
use App\Models\EMR\ReferralTemplate;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index()
    {
        //
    }

    public function initials()
    {
        return response()->json([
            'templates' => ReferralTemplate::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'details'       => 'required',
            'appointment_id' => 'required | numeric',
        ]);

        $appointment = Appointment::where('id', '=', $request->input('appointment_id'))->first();

        $referral = Referral::create([
            'appointment_id'    =>  $request->input('appointment_id'),
            'details'           => $request->input('details'),
            'created_by'        => auth('api')->id(),
            'updated_by'        => auth('api')->id(),
        ]);

        return response()->json([
            'referral'  => $referral,
            'templates' => ReferralTemplate::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'appointment' => Appointment::where('id', '=', $id)->with(['patient', 'service'])->first(),
            'referral' => Referral::where('appointment_id', '=', $id)->with(['creator'])->first(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'details'       => 'required',
            'appointment_id' => 'required | numeric',
        ]);

        $referral = Referral::where('id', '=', $id)->first();

        $referral->appointment_id = $request->input('appointment_id');
        $referral->details = $request->input('details');

        $referral->save();

        return response()->json([
            'referral'  => $referral,
            'templates' => ReferralTemplate::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function destroy($id)
    {
        //
    }
}
