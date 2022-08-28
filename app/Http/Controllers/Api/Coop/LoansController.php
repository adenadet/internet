<?php

namespace App\Http\Controllers\Api\Coop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AllBank;
use App\Models\Branch;
use App\Models\Bank;
use App\Models\Loan;
use App\Models\LoanGuarantor;
use App\Models\LoanType;
use App\Models\Payment;
use App\Models\Saving;
use App\Models\User;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

class LoansController extends Controller
{
    public function initials()
    {
        $all_banks = AllBank::all();
        $loans = Loan::where('user_id', auth('api')->id())->with('branch')->with('repayments')->with('user')->get();
        $loan_types = LoanType::where('status', '1')->get();
        $banks = Bank::all();
        $branches = Branch::all();
        $accounts = Bank::all();
        $users = User::all();
        return response()->json([
            'all_banks' => $all_banks,
            'accounts' => $accounts,
            'banks' => $banks,       
            'branches' => $branches,       
            'loan_types' => $loan_types,       
            'loans' => $loans,
            'users' => $users, 
            'user_id'=> auth('api')->id(),      
            ]);
    }

    public function index()
    {
        $all_banks = AllBank::orderBy('bank_name', 'ASC')->get();
        $loans = Loan::where('user_id', auth('api')->id())->with('branch')->with('repayments')->with('user')->get();
        $loan_types = LoanType::where('status', '1')->get();
        $banks = Bank::all();
        $branches = Branch::select('id', 'name')->with('users.loans')->get();
        $accounts = Bank::all();
        $users = User::all();
        return response()->json([
            'all_banks' => $all_banks = AllBank::all(),
            'accounts' => $accounts,
            'banks' => $banks,       
            'branches' => $branches,       
            'loan_types' => $loan_types,       
            'loans' => $loans,
            'users' => $users,       
            ]);
    }

    public function store(Request $request)
    {
        if ($request->input('user_id')){
            $this->validate($request, [
                'user_id' => 'required|numeric',
                ]);
            $user_id = $request->input('user_id'); 
            }
        else{
            $user_id = auth('api')->id(); 
            }

        $this->validate($request, [
            'loan_type_id' => 'required|numeric',
            'amount'=> 'required|numeric',
            'description' => 'nullable|string',
            'guarantors' => 'required|array',
            ]);

        $loan_type = LoanType::find($request['loan_type_id']);

        $loan = Loan::create([
            'type_id' => $request['loan_type_id'],
            'user_id' => $user_id,
            'amount' => $request['amount'],
            'payable' => ($request['amount'] * (100 + $loan_type->rate)) /100,
            'duration' => 12,
            'name' => 'Loan',
            'bank_id' => $request->input('bank_id'),
            'acct_name' => $request->input('acct_name'),
            'acct_number' => $request->input('acct_number'),
            'total_paid' => 0,
            'status' => 0,
            'status_date' => date('Y-m-d H:i:s'),
            'request_date' => date('Y-m-d H:i:s'),
            'requested_by' => $user_id,
        ]);

        $user = User::find($user_id);
        
        if($request['guarantors']){
            foreach ($request['guarantors'] as $guarantor){
                $loan_guarantor = LoanGuarantor::create([
                    'loan_id' => $loan->id,
                    'guarantor_id' => $guarantor['id'],
                    'requester_id' => $loan->user_id,
                    'status' => 0,
                    'status_date' => date('Y-m-d'),
                ]);
            }
        }
        
        $message = 'Hello Admin, User ID: '.$user->unique_id.' has requested a loan of '.$loan->amount.'.%0aKindly process.';
        //$sms_sender = $this->sendSMS('2348067881594', $message);

        return response()->json([
            'loan' => $loan,       
            'status' => 'Successfully created',
        ]);
    }

    public function pending()
    {
        $loan_types = LoanType::where('status', '1')->get();
        $banks = Bank::all();
        $branches = Branch::select('id', 'name')->with('users.loans')->get();
        $accounts = Bank::all();
        $users = User::all();
        return response()->json([
            'accounts' => $accounts,
            'banks' => $banks,       
            'branches' => $branches,       
            'loan_types' => $loan_types,       
            'loans' => $loans,
            'users' => $users,       
        ]);
    }
    
    public function show($id)
    {
        $array = ['active', 'completed', 'initials', 'pending', 'rejected', ];
        if (is_string($id) && in_array($id, $array)){
            switch ($id){
                case 'active':
                    $loans = Loan::where('status', '=', 1)->with('user.branch')->with('payment_bank')->with('loan_guarantors.guarantor')->orderBy('requested_date', 'ASC')->get();
                    break;
                case 'initials':
                    $loans = Loan::where('user_id', auth('api')->id())->with('branch')->with('repayments')->with('user')->get();
                    break;
                case 'pending':
                    $loans = Loan::where('status', '=', 0)->orWhere('status', '=', 1)->with('user.branch')->with('payment_bank')->with('loan_guarantors.guarantor')->orderBy('requested_date', 'ASC')->get();
                    break;
                case 'completed':
                    $loans = Loan::where('status', '=', 2)->with('user.branch')->with('payment_bank')->with('loan_guarantors.guarantor')->orderBy('requested_date', 'ASC')->get();
                    break;
                case 'rejected':
                    $loans = Loan::where('status', '=', 2)->with('user.branch')->with('payment_bank')->with('loan_guarantors.guarantor')->orderBy('requested_date', 'ASC')->get();
                    break;
            }

            $banks = Bank::all();
            $branches = Branch::select('id', 'name')->with('users.loans')->get();
            $accounts = Bank::all();
            $users = User::all();

            return response()->json([
                'accounts' => $accounts,
                'all_banks' => AllBank::all(),
                'banks' => $banks,       
                'branches' => $branches,       
                'loan_types' => LoanType::where('status', '1')->get(),       
                'loans' => $loans,
                'user_id'=> auth('api')->id(),
                'users' => $users,       
            ]);
        }
        else{

        }
    }

    public function update(Request $request, $id)
    {
        $loan = Loan::find($id);
        
        //Check if the number are still valid
        $user = User::find($loan->user_id);
        $saving = Saving::where('user_id', '=', $user->id)->where('name', 'LIKE', '%Contribution%')->where('status', '=', 1)->first();
        
        if ($loan->status != 1){
            return response()->json([
                'loan' => $loan,
                'status' => 'error',
                'message' => 'Not Yet Guaranteed 1',
                'accounts' => Bank::all(),
                'all_banks' => AllBank::orderBy('bank_name', 'ASC')->get(),
                'branches' => Branch::with('users.savings')->get(),      
                'savings' => Saving::where('user_id',  auth('api')->id())->get(),
                'loans' => Loan::where('status', '=', 0)->with('user.branch')->with('payment_bank')->with('loan_guarantors.guarantor')->orderBy('requested_date', 'ASC')->get(),      
            ]);
        }
        else if ($loan->amount > (2 * ($saving->balance - $saving->fixed))){
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient Balance',
                'accounts' => Bank::all(),
                'all_banks' => AllBank::orderBy('bank_name', 'ASC')->get(),
                'branches' => Branch::with('users.savings')->get(),      
                'savings' => Saving::where('user_id',  auth('api')->id())->get(),
                'loans' => Loan::where('status', '=', 0)->with('user.branch')->with('payment_bank')->with('loan_guarantors.guarantor')->orderBy('requested_date', 'ASC')->get(),      
            ]);
        }
        else{
            // Fix the guaranteed amounts in guarantors balance
            $guarantors = LoanGuarantor::where('loan_id', '=', $loan->id)->get();
            // Fix the half the amount
            foreach ($guarantors as $guarantor){
                $saving = Saving::where('name', 'LIKE', '%Contribution%')->where('user_id', '=', $guarantor->guarantor_id)->first();
                if ($guarantor->amount > ($saving->balance - $saving->fixed)){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Not Yet Guaranteed 2',
                        'accounts' => Bank::all(),
                        'all_banks' => AllBank::orderBy('bank_name', 'ASC')->get(),
                        'branches' => Branch::with('users.savings')->get(),      
                        'savings' => Saving::where('user_id',  auth('api')->id())->get(),
                        'loans' => Loan::where('status', '=', 0)->with('user.branch')->with('payment_bank')->with('loan_guarantors.guarantor')->orderBy('requested_date', 'ASC')->get(),      
                    ]);
                }
                else{
                    $saving->fixed = $saving->fixed + $guarantor->amount;
                    $saving->save();
                }
            }
            //Confirm the Loan
            $loan->status = 3;
            $loan->save();

            //Send SMS to user
            $user = User::find($loan->user_id);
            $message = 'Hello Cooperator '.$user->unique_id.', your loan request for '.$loan->amount.' has been approved by Admin. It would be paid into your account within 7 days.';
            $sms_sender = $this->sendSMS('234'.substr($user->phone, -10), $message);

            //Send sweet response
            return response()->json([
                'status' => 'success',
                'message' => 'Loan has been confirmed, an approval SMS has been sent to the Cooperator',
                'accounts' => Bank::all(),
                'all_banks' => AllBank::orderBy('bank_name', 'ASC')->get(),
                'branches' => Branch::with('users.savings')->get(),      
                'savings' => Saving::where('user_id',  auth('api')->id())->get(),
                'loans' => Loan::with('savings')->with('bank_paid')->with('user')->get(),      
            ]);
        }
    }

    public function destroy($id)
    {
        $loan = Loan::find($id);

        $loan->status = 3;
        $loan->admin_id = auth('api')->id();
        $loan->admin_date = date('y-m-d H:i:s');
        $loan->save();

        $user = User::find($loan->user_id);
        $message = 'Hello Cooperator '.$user->unique_id.', your loan request for '.$loan->amount.' has been rejected by Admin.';
        $sms_sender = $this->sendSMS('234'.substr($user->phone, -10), $message);

        return response()->json([
            'status' => 'success',
            'message' => 'A rejection message has been sent to the Cooperator: '.$user->unique_id,
            'accounts' => Bank::all(),
            'all_banks' => AllBank::orderBy('bank_name', 'ASC')->get(),
            'branches' => Branch::with('users.savings')->get(),      
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
