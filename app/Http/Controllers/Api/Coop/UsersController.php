<?php

namespace App\Http\Controllers\Api\Coop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Bank;
use App\Models\Branch;
use App\Models\Contribution;
use App\Models\Loan;
use App\Models\NextOfKin;
use App\Models\Repayment;
use App\Models\Saving;
use App\Models\State;
use App\Models\Withdrawal;
use App\Models\User;

class UsersController extends Controller
{
    public function dashboard()
    {
        $date = date("Y-m-d", strtotime("-6 months"));
        $con_sum = Contribution::selectRaw("DATE_FORMAT(payment_date, '%Y-%m') as month, SUM(amount) as sum")->groupBy( 'month')->where([
            ['payment_date', '>', $date],
            ['user_id', '=', auth('api')->id()],
            
        ])->get();
        $loans = Loan::where('user_id', auth('api')->id())->get();
        $nok = NextOfKin::where('user_id', auth('api')->id())->get();
        $savings = Saving::where('user_id', auth('api')->id())->get();
        $states = State::orderBy('name', 'ASC')->get();
        
        $user = User::where('id', auth('api')->id())->with('area')->with('state')->with('branch')->with('loans')->with('savings')->get();

       

        return response()->json([
            //'branches' => $branches,
            'con_sum' => $con_sum,
            'loans' => $loans,
            'nok' => $nok,
            'savings' => $savings,      
            'states' => $states,       
            'user' => $user,
            ]);
    }
    
    public function index()
    {
        //
        $users = User::with('state')->with('branch')->orderBy('branch_id')->get();

        return response()->json(['users' => $users]);
    }

    public function store(Request $request)
    {
        //
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
        
        if ($request->input('image')){
            $name = time().'.'.explode('/',explode(':', substr($request->input('image'), 0, strpos($request->input('image'), ';'))))[1][1];
        }

        return response()->json(['status' => 'Successful']);
    }

    public function profile()
    {
        $branches = Branch::all();
        $user = User::where('id', auth('api')->id())->with('area')->with('state')->with('branch')->get();
        $nok = NextOfKin::where('user_id', auth('api')->id())->get();
        $states = State::orderBy('name', 'ASC')->get();
        return response()->json([
            'user' => $user,
            'branches' => $branches,
            'nok' => $nok,
            'states' => $states,       
            ]);
    }
    
    public function show($id)
    {
        $banks = Bank::all();  
        $contributions = Contribution::where('user_id', '=', $id)->with('savings')->get();
        $repayments = Repayment::where('user_id', '=', $id)->with('loan')->get();
        $user = User::find($id);
        $withdrawals = Withdrawal::where('user_id', '=', $id)->with('savings')->get();

        return response()->json([
            'banks' => $banks,
            'contributions' => $contributions,
            'repayments' => $repayments,
            'user' => $user,
            'withdrawals' => $withdrawals,
            ]);
    }

    public function update(Request $request, $id)
    {
        //

        $user = User::find($id);

        $user->first_name = $request->input('first_name');
        $user->middle_name = $request->input('middle_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email'); 
        $user->unique_id = $request->input('unique_id');
        $user->street = $request->input('street');
        $user->street2 = $request->input('street2'); 
        $user->city = $request->input('city');
        $user->sex = $request->input('sex');
        $user->state_id = $request->input('state_id'); 
        $user->phone = $request->input('phone');
        $user->branch_id = $request->input('branch_id');

        $user->save();      
        

    }

    public function destroy($id)
    {
        //
    }
}
