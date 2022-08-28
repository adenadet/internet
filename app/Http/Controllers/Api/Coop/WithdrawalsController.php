<?php

namespace App\Http\Controllers\Api\Coop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AllBank;
use App\Models\Branch;
use App\Models\Bank;
use App\Models\Contribution;
use App\Models\Payment;
use App\Models\Saving;
use App\Models\SavingType;
use App\Models\User;
use App\Models\Withdrawal;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

class WithdrawalsController extends Controller
{
    public function index()
    {
        $all_banks = AllBank::orderBy('bank_name', 'ASC')->get();
        $accounts = Bank::all();
        $branches = Branch::with('users.savings')->get();
        $savings = Saving::where('user_id',  auth('api')->id())->get();
        $withdrawals = Withdrawal::with('savings.user')->with('bank_paid')->with('user')->get();
        
        return response()->json([
            'all_banks' => $all_banks, 
            'branches' => $branches,      
            'savings' => $savings,
            'withdrawals' => $withdrawals,
            'accounts' => $accounts,      
            ]);
    }

    public function initials()
    {
        $all_banks = AllBank::orderBy('bank_name', 'ASC')->get();
        $accounts = Bank::all();
        $savings = Saving::where('user_id',  auth('api')->id())->get();
        $withdrawals = Withdrawal::where('user_id', auth('api')->id())->with('savings')->with('bank_paid')->get();
        return response()->json([
            'all_banks' => $all_banks,       
            'savings' => $savings,
            'user' => auth('api')->user(),
            'withdrawals' => $withdrawals,       
            ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'saving_id' => 'required',
            'agreed' => 'required',
            'bank_id'=> 'numeric',
            'amount'=>'numeric',
            'acct_name'=> 'required',
            'acct_number'=> 'required|numeric',
            'user_id' => 'required|numeric',
        ]);

        $saving = Saving::find($request['saving_id']);

        $withdrawal = Withdrawal::create([
            'user_id' => $saving->user_id, 
            'saving_id' => $request['saving_id'], 
            'amount' => $request['amount'], 
            'bank_id' => $request['bank_id'], 
            'acct_name' => $request['acct_name'], 
            'acct_number' => $request['acct_number'], 
            'request_date' => date('Y-m-d'),
            'requested_by' => auth('api')->id(),
            'status' => 0,
        ]);
        
        $message = 'Hello Admin, User ID: '.auth('api')->user()->unique_id.' has requested a withdrawal of '.$withdrawal->amount.'.%0aKindly process.';
        //$sms_sender = $this->sendSMS('2347067881594', $message);
        
        return "We got your data";
    }

    public function show($id)
    {
        $array = ['pending'];
        if (is_string($id) && in_array($id, $array)){
            $all_banks = AllBank::orderBy('bank_name', 'ASC')->get();
            $banks = Bank::all();
            $withdrawals = Withdrawal::where('status','=', 0)->with('savings.user.branch')->with('bank_paid')->with('user')->get();
            return response()->json([
                'all_banks' => $all_banks,       
                'banks' => $banks,
                'user' => auth('api')->user(),
                'withdrawals' => $withdrawals,       
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        //Find the withdrawal request first
        $withdrawal = Withdrawal::find($id);

        $all_banks = AllBank::orderBy('bank_name', 'ASC')->get();
        $accounts = Bank::all();
        $branches = Branch::with('users.savings')->get();
        $savings = Saving::where('user_id',  auth('api')->id())->get();
        
        //Check that the Savings amount is upto the withdrawal, then withdrawal from the balance
        $saving = Saving::find($withdrawal->saving_id);
        if ($withdrawal->amount > ($saving->balance - $saving->fixed)){
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient Balance',
                'accounts' => Bank::all(),
                'all_banks' => AllBank::orderBy('bank_name', 'ASC')->get(),
                'branches' => Branch::with('users.savings')->get(),      
                'savings' => Saving::where('user_id',  auth('api')->id())->get(),
                'withdrawals' => Withdrawal::where('status','=', 0)->with('savings.user.branch')->with('bank_paid')->with('user')->get(),      
            ]);
        }
        else if ($withdrawal->amount <= ($saving->balance - $saving->fixed)){
            $saving->balance = $saving->balance - (1.05 * $withdrawal->amount);
            $saving->save();

            $withdrawal->status = 1;
            $withdrawal->admin_id = auth('api')->id();
            $withdrawal->admin_approval_date = date('y-m-d H:i:s');
            $withdrawal->save();

            $user = User::find($withdrawal->user_id);
            $message = 'Hello Cooperator '.$user->unique_id.', your withdrawal request for '.$withdrawal->amount.' has been approved. The payment would be made into your account within 7 days';
            $sms_sender = $this->sendSMS('234'.substr($user->phone, -10), $message);
            
            return response()->json([
                'status' => 'success',
                'message' => 'An apporoval message has been sent to the Cooperator: '.$user->unique_id,
                'accounts' => Bank::all(),
                'all_banks' => AllBank::orderBy('bank_name', 'ASC')->get(),
                'branches' => Branch::with('users.savings')->get(),      
                'savings' => Saving::where('user_id',  auth('api')->id())->get(),
                'withdrawals' => Withdrawal::where('status','=', 0)->with('savings.user.branch')->with('bank_paid')->with('user')->get(),      
            ]);
        }
    }

    public function destroy($id)
    {
        $withdrawal = Withdrawal::find($id);

        $withdrawal->status = 6;
        $withdrawal->admin_id = auth('api')->id();
        $withdrawal->admin_approval_date = date('y-m-d H:i:s');
        $withdrawal->save();

        $user = User::find($withdrawal->user_id);
        $message = 'Hello Cooperator '.$user->unique_id.', your withdrawal request for '.$withdrawal->amount.' has been rejected.';
        $sms_sender = $this->sendSMS('234'.substr($user->phone, -10), $message);
        return response()->json([
            'status' => 'success',
            'message' => 'A rejection message has been sent to the Cooperator: '.$user->unique_id,
            'accounts' => Bank::all(),
            'all_banks' => AllBank::orderBy('bank_name', 'ASC')->get(),
            'branches' => Branch::with('users.savings')->get(),      
            'savings' => Saving::where('user_id',  auth('api')->id())->get(),
            'withdrawals' => Withdrawal::with('savings')->with('bank_paid')->with('user')->get(),      
        ]);
    }

    private function sendSMS($number, $message = "Thanks for registering"){
        // Create a new Guzzle Plain Client
        $client = new Client();
        $url = 'http://customer.smsprovider.com.ng/api/?username=adenadet01@gmail.com&password=yetunde01&message='.$message.'&sender=DLCIK&mobiles='.$number;
        //dump($url);
        $response = $client->request('GET', $url);
        //dump($response);
        // Obtain the body into an array format.
        $body = json_decode($response->getBody() , true);
        
        // If there were some error on the request, throw the exception
        

        // Returns the array with information about the desired currency
        return $body['status'];
    }
}
