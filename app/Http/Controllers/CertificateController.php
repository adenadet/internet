<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EMR\Appointment;

class CertificateController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $params = [
            'appointment' => Appointment::where('id',$id)->with(['front_officer', 'medical_officer', 'radiologist','service', 'patient.nationality', 'payment.employee', 'consent', 'consultation', 'laboratory', 'report.findings', 'issuing_officer'])->first(), 
        ];

        return view('certificates.horizontal')->with($params);
    }

    public function edit($id)
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
