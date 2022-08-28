<?php

namespace App\Http\Controllers\Api\Coop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Branch;
use App\Models\Bank;
use App\Models\Loan;
use App\Models\LoanGuarantor;
use App\Models\LoanType;
use App\Models\Payment;
use App\Models\Saving;

class GuarantorController extends Controller
{
    public function initials()
    {
        $guarantees = LoanGuarantor::where(['requester_id'=> auth('api')->id(), ])->with('loan')->with('requested_by')->with('guarantor')->orderBy('status_date')->get();
        $users = User::all();
        return response()->json([
            'guarantees' => $guarantees,       
            'users' => $users,
            ]);
    }
    
    public function index()
    {
        $loans = Loan::where('user_id', auth('api')->id())->with('loan_guarantors')->with('repayments')->with('user')->get();
        $guarantors = LoanGuarantor::where(['guarantor_id'=> auth('api')->id(),])->with('guarantor')->with('loan')->with('requested_by')->orderBy('status_date')->get();
        $saving = Saving::where(['user_id'=> auth('api')->id(), 'type_id'=> 3])->get();
        return response()->json([
            'guarantors' => $guarantors,       
            'loans' => $loans,
            'saving' => $saving,       
            ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //echo $id;
        $loan_guarantor = LoanGuarantor::find($id);

        if($request['type'] == 'guarantee'){
            $loan_guarantor->status = 0;
            $loan_guarantor->loan_id = $request['loan_id'];
            $loan_guarantor->guarantor_id = $request['guarantor_id'];
            $loan_guarantor->status_date = date('Y-m-d');
        }
        elseif($request['type'] == 'guarantor'){
            $loan_guarantor->status = 1;
            $loan_guarantor->status_date = date('Y-m-d');
            $loan_guarantor->amount = $request['amount'];    
            //Check if the sums of loans is equal to the guaranteed sums * 1.05
            $all_guarantors = LoanGuarantor::where('loan_id', '=', $loan_guarantor->loan_id)->where('status', '=', 1)->get();
            echo $loan_guarantor->loan_id;
            $loan = Loan::find($loan_guarantor->loan_id);
            $sum = 0;
            foreach ($all_guarantors as $guarantor){$sum += $guarantor->amount;}
            if ($sum >= ($loan->amount * 1.05)){$loan->status = 1; echo "Working";}
            else{$loan->status = 0;}

            $loan->save();

        }
        $loan_guarantor->save();

        $guarantees = LoanGuarantor::where(['requester_id'=> auth('api')->id(),])->with('guarantor')->with('loan')->with('requested_by')->orderBy('status_date')->get();
        
        $users = User::all();
        return response()->json([
            'guarantees' => $guarantees,       
            'users' => $users,
            ]);
    }

    public function destroy($id)
    {
        $loan_guarantor = LoanGuarantor::find($id);

        $loan_guarantor->status = 5;
        $loan_guarantor->save();

        $loans = Loan::where('user_id', auth('api')->id())->with('guarantors')->with('repayments')->with('user')->get();
        $guarantors = LoanGuarantor::where(['guarantor_id'=> auth('api')->id(),])->with('guarantor')->with('loan')->with('requested_by')->orderBy('status_date')->get();
        $saving = Saving::where(['user_id'=> auth('api')->id(), 'type_id'=> 3])->get();
        return response()->json([
            'accounts' => $accounts,
            'banks' => $banks,       
            'branches' => $branches,       
            'guarantees' => $guarantees,       
            'guarantors' => $guarantors,       
            'loans' => $loans,
            //'users' => $users,
            'saving' => $saving,       
            ]); 
    }

    public function death($id)
    {
        $loan_guarantor = LoanGuarantor::find($id);

        $loan_guarantor->status = 6;
        $loan_guarantor->save();

        $loans = Loan::where('user_id', auth('api')->id())->with('guarantors')->with('repayments')->with('user')->get();
        $guarantees = LoanGuarantor::where(['guarantor_id'=> auth('api')->id(), 'status'=> 0 ])->with('loan')->with('requested_by')->orderBy('status_date')->get();
        $guarantors = LoanGuarantor::where(['guarantor_id'=> auth('api')->id(),])->with('guarantor')->with('loan')->with('requested_by')->orderBy('status_date')->get();
        $banks = Bank::all();
        $branches = Branch::all();
        $accounts = Bank::all();
        //$users = User::all();
        $saving = Saving::where(['user_id'=> auth('api')->id(), 'type_id'=> 3])->get();
        return response()->json([
            'accounts' => $accounts,
            'banks' => $banks,       
            'branches' => $branches,       
            'guarantees' => $guarantees,       
            'guarantors' => $guarantors,       
            'loans' => $loans,
            //'users' => $users,
            'saving' => $saving,       
            ]); 
    }
}
