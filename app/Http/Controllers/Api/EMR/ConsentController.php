<?php

namespace App\Http\Controllers\Api\EMR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\Appointment;
use App\Models\EMR\Consent;
use App\Models\EMR\Patient;
use Illuminate\Support\Facades\Auth;


class ConsentController extends Controller
{
    public function index()
    {
        //
    }

    public function signature(Request $request)
    {
        $this->validate($request, [
            'appointment_id' => 'required',
            'service_id'     => 'required',
        ]);

        $signaturePad = 10;
        $signaturePad1 = null;
        $signaturePad2 = null;
        $signaturePad3 = null;
        $signaturePad4 = null;
        $appointment = Appointment::find($request->input('appointment_id'));
        if (!is_null($request->input('signaturePad'))){
            $signature_pad = $request->input('appointment_id')."-".time().".".explode('/',explode(':', substr( $request->input('signaturePad'), 0, strpos($request->input('signaturePad'), ';')))[1])[1];
            \Image::make($request->input('signaturePad'))->save(public_path('img/consents/').$signature_pad);
            $signaturePad = $signature_pad;
        }

        if (!is_null($request->input('signaturePad1'))){
            $signature_pad1 = $request->input('appointment_id')."-".time().".".explode('/',explode(':', substr( $request->input('signaturePad1'), 0, strpos($request->input('signaturePad1'), ';')))[1])[1];
            \Image::make($request->input('signaturePad_1'))->save(public_path('img/consents/').$signature_pad1);
            $signaturePad1 = $signature_pad1;
        }

        if (!is_null($request->input('signaturePad2'))){
            $signature_pad2 = $request->input('appointment_id')."-".time().".".explode('/',explode(':', substr( $request->input('signaturePad2'), 0, strpos($request->input('signaturePad2'), ';')))[1])[1];
            \Image::make($request->input('signaturePad_2'))->save(public_path('img/consents/').$signature_pad2);
            $signaturePad2 = $signature_pad2;
        }
        
        if (!is_null($request->input('signaturePad3'))){
            $signature_pad3 = $request->input('appointment_id')."-".time().".".explode('/',explode(':', substr( $request->input('signaturePad3'), 0, strpos($request->input('signaturePad3'), ';')))[1])[1];
            \Image::make($request->input('signaturePad3'))->save(public_path('img/consents/').$signature_pad3);
            $signaturePad3 = $signature_pad3;
        }

        if (!is_null($request->input('signaturePad4'))){
            $signature_pad4 = $request->input('appointment_id')."-".time().".".explode('/',explode(':', substr( $request->input('signaturePad4'), 0, strpos($request->input('signaturePad4'), ';')))[1])[1];
            \Image::make($request->input('signaturePad4'))->save(public_path('img/consents/').$signature_pad4);
            $signaturePad4 = $signature_pad4;
        }

        Consent::create([
            'service_id'        => $request->input('service_id'),
            'appointment_id'    => $request->input('appointment_id'),
            'signaturePad'      => $signaturePad ?? null,
            'signaturePad_1'    => $signaturePad1 ?? null,
            'signaturePad_2'    => $signaturePad2 ?? null,
            'signaturePad_3'    => $signaturePad3 ?? null,
            'signaturePad_4'    => $signaturePad4 ?? null,
            'guardian'          => $request->input('guardian') ?? null,
            'guardian_relationship' => $request->input('guardian_relationship') ?? null,
            'interpreter'       => $request->input('interpreter') ?? null,
            'pregnancy'         => $request->input('pregnancy') ?? null,
            'physician_id'      => Auth::id() ?? 1,
            'created_by'        => Auth::id() ?? 1,
            'updated_by'        => Auth::id() ?? 1,
        ]);

        $appointment->status = 5;
        $appointment->doctor_id = auth('api')->id();
        $appointment->doctor_at = date('Y-m-d H:i:s');
        $appointment->save();

        return redirect('/eservices/doctor/consultation/'.$appointment->id);

    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'appointment_id' => 'required',
            'service_id'     => 'required',
        ]);

        $signaturePad = 10;
        $signaturePad1 = null;
        $signaturePad2 = null;
        $signaturePad3 = null;
        $signaturePad4 = null;
        $appointment = Appointment::find($request->input('appointment_id'));
        if (!is_null($request->input('signaturePad'))){
            $signature_pad = $request->input('appointment_id')."-".time().".".explode('/',explode(':', substr( $request->input('signaturePad'), 0, strpos($request->input('signaturePad'), ';')))[1])[1];
            \Image::make($request->input('signaturePad'))->save(public_path('img/consents/').$signature_pad);
            $signaturePad = $signature_pad;
        }

        if (!is_null($request->input('signaturePad1'))){
            $signature_pad1 = $request->input('appointment_id')."-".time().".".explode('/',explode(':', substr( $request->input('signaturePad1'), 0, strpos($request->input('signaturePad1'), ';')))[1])[1];
            \Image::make($request->input('signaturePad_1'))->save(public_path('img/consents/').$signature_pad1);
            $signaturePad1 = $signature_pad1;
        }

        if (!is_null($request->input('signaturePad2'))){
            $signature_pad2 = $request->input('appointment_id')."-".time().".".explode('/',explode(':', substr( $request->input('signaturePad2'), 0, strpos($request->input('signaturePad2'), ';')))[1])[1];
            \Image::make($request->input('signaturePad_2'))->save(public_path('img/consents/').$signature_pad2);
            $signaturePad2 = $signature_pad2;
        }
        
        if (!is_null($request->input('signaturePad3'))){
            $signature_pad3 = $request->input('appointment_id')."-".time().".".explode('/',explode(':', substr( $request->input('signaturePad3'), 0, strpos($request->input('signaturePad3'), ';')))[1])[1];
            \Image::make($request->input('signaturePad3'))->save(public_path('img/consents/').$signature_pad3);
            $signaturePad3 = $signature_pad3;
        }

        if (!is_null($request->input('signaturePad4'))){
            $signature_pad4 = $request->input('appointment_id')."-".time().".".explode('/',explode(':', substr( $request->input('signaturePad4'), 0, strpos($request->input('signaturePad4'), ';')))[1])[1];
            \Image::make($request->input('signaturePad4'))->save(public_path('img/consents/').$signature_pad4);
            $signaturePad4 = $signature_pad4;
        }

        Consent::create([
            'service_id'        => $request->input('service_id'),
            'appointment_id'    => $request->input('appointment_id'),
            'signaturePad'      => $signaturePad ?? null,
            'signaturePad_1'    => $signaturePad1 ?? null,
            'signaturePad_2'    => $signaturePad2 ?? null,
            'signaturePad_3'    => $signaturePad3 ?? null,
            'signaturePad_4'    => $signaturePad4 ?? null,
            'guardian'          => $request->input('guardian') ?? null,
            'guardian_relationship' => $request->input('guardian_relationship') ?? null,
            'interpreter'       => $request->input('interpreter') ?? null,
            'pregnancy'         => $request->input('pregnancy') ?? null,
            'physician_id'      => auth('api')->id(),
            'created_by'        => auth('api')->id(),
            'updated_by'        => auth('api')->id(),
        ]);

        $appointment->status = 5;
        $appointment->doctor_id = auth('api')->id();
        $appointment->doctor_at = date('Y-m-d H:i:s');
        $appointment->save();

        return response()->json([
            'appointment' => Appointment::where('id',$request->input('appointment_id'))->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee', 'consultation', 'report.findings', 'consent' ])->first(),
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
