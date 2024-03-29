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
        return response()->json([
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'nations' => Country::orderBy('name', 'ASC')->get(), 
            'applicants' => Patient::orderBy('created_at', 'DESC')->with('nationality')->paginate(50),     
        ]);
    }

    public function store(Request $request)
    {

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
        
        Patient::create([
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
            'created_by' => auth('api')->id(),
        ]);

        return response()->json([
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'nations' => Country::orderBy('name', 'ASC')->get(), 
            'applicants' => Patient::orderBy('created_at', 'DESC')->with('nationality')->paginate(50),     
        ]);
        }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);

        $image_url = $currentPhoto = $patient->image;
        $passport_image_url = $currentPassportPhoto = $patient->passport_image;

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

        $patient->last_name     = $request->input('last_name');
        $patient->first_name    = $request->input('first_name');
        $patient->middle_name   = $request->input('middle_name');
        $patient->dob = $request->input('dob');
        $patient->sex = $request->input('sex');
        $patient->image = $image_url;
        $patient->passport_page = $passport_image_url;
        $patient->lmp = $request->input('lmp');
        $patient->email = $request->input('email');
        $patient->phone = $request->input('phone');
        $patient->alt_phone = $request->input('alt_phone');
        $patient->nigerian_address = $request->input('nigerian_address');
        $patient->uk_address = $request->input('uk_address');
        $patient->accompanying_kids = $request->input('accompanying_kids');
        $patient->nationality_id = $request->input('nationality_id');
        $patient->passport_no = $request->input('passport_no');
        $patient->visa_type = $request->input('visa_type');
        
        $patient->save();

        return response()->json([
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'nations' => Country::orderBy('name', 'ASC')->get(), 
            'applicants' => Patient::orderBy('created_at', 'DESC')->with('nationality')->paginate(50),        
        ]);
    }

    public function destroy($id)
    {
        

    }

    public function search()
    {
        if ($search = \Request::get('q')){
            $applicants = Patient::orderBy('first_name', 'ASC')->where(function($query) use ($search){
                $query->where('first_name', 'LIKE', "%$search%")
                ->orWhere('middle_name', 'LIKE', "%$search%")
                ->orWhere('last_name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%");
                })->paginate(100);
            }
        else{
            $applicants = Patient::orderBy('first_name', 'ASC')->paginate(100);
        }
        
        return response()->json(['applicants' => $applicants,]);
    }
}