<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    //protected $redirectTo = RouteServiceProvider::HOME;
    public function redirectTo() {
        $role = Auth::user()->user_type; 
        dd($role);
        switch ($role) {
            case 'SuperAdmin':
                return '/admin/dashboard'; break;
            case 'staff':
                return '/staff/dashboard'; break;
            case 'patient':
                return '/patients/dashboard'; break;
            case 'doctor':
                return '/doctors/dashboard'; break; 
            case 'hospital':
                return '/hospitals/dashboard'; break; 
            default:
                return '/home'; break;
        }
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {   
        $input = $request->all();
  
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
  
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'unique_id';
        if(auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password'])))
        {
            if (Auth::user()->user_type == 'staff'){
                return redirect()->route('dashboard');
            }
            else{
                return redirect()->route('applicants');
            }
        }
        else{
            return redirect()->route('login')->with('error','Email-Address And Password Are Wrong.');
        }
          
    }
}
