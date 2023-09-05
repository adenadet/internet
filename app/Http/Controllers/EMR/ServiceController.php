<?php

namespace App\Http\Controllers\EMR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\EMR\Appointment;
use App\Models\EMR\Consent;
use App\Models\EMR\Patient;

class ServiceController extends Controller
{
    public function administrator()
    {
        $params = [
            'page_title' => 'E-Services | Administrator',
        ];
        return view('eservices')->with($params);
    }

    public function certificate()
    {
        $params = [
            'page_title' => 'E-Services | Certificate',
        ];
        return view('eservices')->with($params);
    }

    public function consent($id)
    {
        $appointment = Appointment::where('id', '=', $id)->with(['front_officer', 'service', 'patient.nationality', 'consent' ])->first();

        $params = [
            'page_title' => 'E-Services | Consent Form',
            'appointment' => $appointment,
        ];
        return view('consent')->with($params);
    }

    public function consent_save(Request $request)
    {
        $this->validate($request, [
            'appointment_id' => 'required',
            'service_id'     => 'required',
        ]);

        $signaturePad = 10;

        $appointment = Appointment::find($request->input('appointment_id'));

        if (!is_null($request->input('signaturePad'))){
            $signature_pad = $request->input('appointment_id')."-".time().".".explode('/',explode(':', substr( $request->input('signaturePad'), 0, strpos($request->input('signaturePad'), ';')))[1])[1];
            \Image::make($request->input('signaturePad'))->save(public_path('img/consents/').$signature_pad);
            $signaturePad = $signature_pad;
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
            'physician_id'      => Auth::id(),
            'created_by'        => Auth::id(),
            'updated_by'        => Auth::id(),
        ]);

        $appointment->status = 5;
        $appointment->doctor_id = auth('api')->id();
        $appointment->doctor_at = date('Y-m-d H:i:s');
        $appointment->save();

        return redirect('/eservices/doctor/consultation/'.$appointment->id);
    }

    public function front()
    {
        $params = [
            'page_title' => 'E-Services | Front Office',
        ];
        return view('eservices')->with($params);
    }

    public function front_admin()
    {
        $params = [
            'page_title' => 'E-Services | Front Admin',
        ];
        return view('eservices')->with($params);
    }

    public function medical()
    {
        $params = [
            'page_title' => 'E-Services | Medical Officer',
        ];
        return view('eservices')->with($params);
    }

    public function radiologist()
    {
        $params = [
            'page_title' => 'E-Services | Radiologist',
        ];
        return view('eservices')->with($params);
    }
}
