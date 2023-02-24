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
        $month = Month::where('month', '=', $id.'-01')->first();
        $month->nomination_end = date('Y-m-d H:i:s');
        $month->nomination_end_id = auth('api')->id();
        $month->save();

        return response()->json([
            'staff_month'   => Month::where('month', '=', $id.'-01')->first(),
            'nominations'    => Nomination::where('month', '=', $id)->with(['branch', 'nominee.branch', 'nominator'])->get(),
            'previous'      => 0,
        ]);
    }
    
    public function index()
    {
        $queen = Month::whereDate('nomination_start', '<=', date('Y-m-d'))
        ->whereNotNull('nomination_start')
        ->where(function($query){
            return $query->whereDate('nomination_end', '>=', date('Y-m-d'))->orWhereNull('nomination_end');
            });

        $staff_month = $queen->first();
        
        if (($queen->count() == 0)){
            $already = 0; 
            $dept_users = [];
            $nomination = [];
        
            return response()->json(['open' => 0, 'previous' => 0, 'dept_users' => $dept_users, 'nomination' => $nomination, 'month'=> $staff_month]); 
        }
        $quest = Nomination::where('created_by', '=', auth('api')->id())->where('month', '=', $staff_month->month);
        $already = $quest->count(); 
        $nomination = $quest->with('nominee')->first();
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
        
        return response()->json(['open' => $queen->count(), 'previous' => $already, 'dept_users' => $dept_users, 'nomination' => $nomination, 'month' => $staff_month]);
    }

    public function open($id)
    {
        $month = Month::where('month', '=', $id.'-01')->count();
        if ($month == 0){
            Month::create([
                'month' => $id.'-01',
                'nomination_start' => date('Y-m-d H:i:s'),
                'nominate_initiate_id' => auth('api')->id(), 
            ]);
            $message = "Nominating is now open";
        }
        else{
            $staff_month = Month::where('month', '=', $id.'-01')->first();
            if ($staff_month->nomination_start == null){
                $staff_month->nomination_start = date('Y-m-d H:i:s');
                $staff_month->nominate_initiate_id = auth('api')->id();
                $staff_month->save();

                $message = "Nominating is now open";
            }
            else{
                $message = "Nominating had been previously opened";
            }
        }
        

        return response()->json(['message' => $message,]);
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
        return response()->json([
            'staff_month'   => Month::where('month', '=', $id.'-01')->first(),
            'nominations'    => Nomination::where('month', '=', $id)->with(['branch', 'nominee', 'nominator'])->get(),
            'previous'      => 0,
        ]);
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
