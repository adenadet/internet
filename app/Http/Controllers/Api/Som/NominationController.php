<?php

namespace App\Http\Controllers\Api\Som;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Branch;
use App\Models\Department;
use App\Models\SOM\Nomination;
use App\Models\SOM\Month;

class NominationController extends Controller
{
    public function close(Request $request, $id){
        $month = Month::find($id);
    }
    
    public function index()
    {
        $date = date("Y-m",strtotime("-1 month"));
        $nomination = Nomination::where('created_by', '=', auth('api')->id())->where('month', '=', $date)->with('nominee')->first(); 
        if ($nomination){$already = 1;}
        else{$already = 0;}


        $user = User::find(auth('api')->id());
        
        if ($user->hasRole('Exco') || $user->hasRole('Super Admin')){$dept_users = User::all();}
        else if ($user->hasRole('Chief Consultant') || $user->hasRole('Practice Manager') || $user->hasRole('Head Nurse')){
            $medicine = Department::select('id')->where('name', '=', 'Clinical Services')->get();
            $nursing = Department::select('id')->where('name', '=', 'Nursing Services')->get();
                
            if ($user->hasRole('Chief Consultant')){
                $branches = Branch::select('id')->where('cinc_id', '=', auth('api')->id())->distinct()->get();
                $dept_users = User::whereIn('department_id', $medicine)->whereIn('branch_id', $branches)->get(); 
            }
            else if ($user->hasRole('Head Nurse')){
                $branches = Branch::select('id')->where('hon_id', '=', auth('api')->id())->distinct()->get();
                $dept_users = User::whereIn('department_id', $nursing)->whereIn('branch_id', $branches)->get();
            }
            else if ($user->hasRole('Practice Manager')){
                $branches = Branch::select('id')->where('pm_id', '=', auth('api')->id())->distinct()->get();
                $dept_users = User::whereNotIn('department_id', $nursing)->whereNotIn('department_id', $medicine)->whereIn('branch_id', $branches)->get();
            }
        }
        else if ($user->hasRole('Head of Department')){
            $dept_users = User::where('department_id', '=', auth('api')->user()->department_id)->get();
        }
        
        return response()->json(['previous' => $already, 'dept_users' => $dept_users, 'nomination' => $nomination,]);
    }

    public function store(Request $request)
    {
        $this->validate($request, ['month' => 'required', 'user_id' => 'required|numeric', 'description'   => 'required',]);

        $test_nomination = Nomination::where('created_by', '=', auth('api')->id())->where('month', '=', $request->input('month'))->count();
        if ($test_nomination > 0){
            return response()->json([
                'previous'      => 1,
                'nomination'    => Nomination::where('created_by', '=', auth('api')->id())->where('month', '=', $request->input('month'))->first(),
            ]);
        } 
        else{
            $nomination = Nomination::create([
                'user_id'       => $request->input('user_id'), 
                'month'         => $request->input('month'), 
                'description'   => $request->input('description'),
                'created_by'    => auth('api')->id(), 
                'updated_by'    => auth('api')->id(), 
            ]);

            return response()->json([
                'nomination'    => $nomination,
                'previous'      => 0,
            ]);
        }
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'id'            => 'required|numeric',
            'month'         => 'required',
            'user_id'       => 'required|numeric', 
            'description'   => 'required',  
        ]);

        $nomination = Nomination::find($id);

        $nomination->user_id        = $request->input('user_id');
        $nomination->description    = $request->input('description');
        $nomination->updated_by     = $request->input('updated_by');

        $nomination->save();
        
        return response()->json([
            'nomination'    => $nomination,
            'previous'      => 0,
        ]);
    }

    public function destroy($id)
    {
        //
    }
}
