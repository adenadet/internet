<?php

namespace App\Http\Controllers\Api\Coop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AllBank;
use App\Models\Branch;
use App\Models\Bank;
use App\Models\Closure;
use App\Models\Loan;
use App\Models\LoanGuarantor;
use App\Models\LoanType;
use App\Models\Payment;
use App\Models\Saving;
use App\Models\Withdrawal;
use App\Models\User;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

class ClosuresController extends Controller
{
    public function index()
    {
        $all_banks = AllBank::orderBy('bank_name', 'ASC')->get();
        $accounts = Bank::all();
        $branches = Branch::with('users.savings')->get();
        $closures = Closure::with('saving_dtl.user')->with('bank_paid')->with('user')->orderBy('request_date', 'DESC')->paginate(30);
        $savings = Saving::where('user_id',  auth('api')->id())->get();
        $withdrawals = Withdrawal::with('savings.user')->with('bank_paid')->with('user')->get();
        
        return response()->json([
            'all_banks' => $all_banks, 
            'branches' => $branches,      
            'closures' => $closures,      
            'savings' => $savings,
            'withdrawals' => $withdrawals,
            'accounts' => $accounts,      
            ]);
    }

    public function initials()
    {
        $all_banks = AllBank::all();
        $loans = Loan::where('user_id', auth('api')->id())->get();
        $savings = Saving::where('user_id', auth('api')->id())->get();
        return response()->json([
            'all_banks' => $all_banks,       
            'loans' => $loans,       
            'savings' => $savings,       
        ]);
    }
    
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $array = ['active', 'completed', 'initials', 'pending', 'rejected', ];
        if (is_string($id) && in_array($id, $array)){
            switch ($id){
                case 'active':
                    $closures = Closure::with('saving_dtl.user')->with('bank_paid')->with('user')->orderBy('request_date', 'DESC')->paginate(30);
                    break;
                case 'initials':
                    $closures = Closure::with('saving_dtl.user')->with('bank_paid')->with('user')->orderBy('request_date', 'DESC')->paginate(30);
                    break;
                case 'pending':
                    $closures = Closure::where('status', '=', 0)->with('saving_dtl.user')->with('bank_paid')->with('user')->orderBy('request_date', 'DESC')->paginate(30);
                    break;
                case 'completed':
                    $closures = Closure::with('saving_dtl.user')->with('bank_paid')->with('user')->orderBy('request_date', 'DESC')->paginate(30);
                    break;
                case 'rejected':
                    $closures = Closure::with('saving_dtl.user')->with('bank_paid')->with('user')->orderBy('request_date', 'DESC')->paginate(30);
                    break;
            }
            
            $all_banks = AllBank::orderBy('bank_name', 'ASC')->get();
            $accounts = Bank::all();
            $banks = Bank::all();
            $branches = Branch::with('users.savings')->get();
            //$closures = Closure::with('saving_dtl.user')->with('bank_paid')->with('user')->orderBy('request_date', 'DESC')->paginate(30);
            
            return response()->json([
                'accounts' => $accounts,
                'all_banks' => $all_banks,
                'banks' => $banks,       
                'branches' => $branches,       
                'closures' => $closures,       
            ]);
        }
        else{}
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
        $loan_balance = 0;
        $saving_balance = 0;
        $savings_fixed = 0;

        $closure = Closure::findorFail($id);
        $user = User::find($closure->user_id);
        //Get User Details
        $savings = Saving::where('user_id', '=', $closure->user_id)->get();
        $loans = Loan::where('user_id', '=', $closure->user_id)->get();

        foreach ($savings as $saving){
            $saving_balance += $saving->balance - $saving->fixed;
            $savings_fixed += $saving->fixed;
        }

        foreach ($loans as $loan){
            $loan_balance += $loan->balance;
        }

        if ($loan_balance > $saving_balance){ $status = 'error'; $message = "Pending Loan is higher than total savings balance"; }
        else{
            $user->delete();
            $closure->status = 3; $closure->save();
            foreach ($savings as $saving){$saving->delete();}
            foreach ($loans as $loan){$loan->delete();}
            $status = 'success'; $message = "User has been deactivated successfully";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'accounts' => Bank::all(),
            'all_banks' => AllBank::orderBy('bank_name', 'ASC')->get(),
            'branches' => Branch::with('users.savings')->get(), 
            'closures' => Closure::where('status', '=', 0)->with('saving_dtl.user')->with('bank_paid')->with('user')->orderBy('request_date', 'DESC')->paginate(30),
            'savings' => Saving::where('user_id',  auth('api')->id())->get(),
            'loans' => Loan::where('status', '=', 0)->with('user.branch')->with('payment_bank')->with('loan_guarantors.guarantor')->orderBy('requested_date', 'ASC')->get(),      
        ]);

    }

    private function sendSMS($number, $message = "Thanks for registering"){
        $client = new Client();
        $url = 'http://customer.smsprovider.com.ng/api/?username=adenadet01@gmail.com&password=yetunde01&message='.$message.'&sender=DLCIK&mobiles='.$number;
        $response = $client->request('GET', $url);
        $body = json_decode($response->getBody() , true);
        
        return $body['status'];
    }
}