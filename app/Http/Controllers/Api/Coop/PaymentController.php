<?php

namespace App\Http\Controllers\Api\Coop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Bank;
use App\Models\Branch;
use App\Models\Contribution;
use App\Models\Loan;
use App\Models\LoanType;
use App\Models\Payment;
use App\Models\Repayment;
use App\Models\Saving;
use App\Models\User;

class PaymentController extends Controller
{
    public function initials()
    {
        $loans = Loan::where('user_id', auth('api')->id())->with('branch')->with('repayments')->with('user')->get();
        $loan_types = LoanType::where('status', '1')->get();
        $banks = Bank::all();
        $branches = Branch::all();
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

    public function index()
    {
        $payments = Payment::orderBy('date', 'DESC')->with('bank')->with('user')->with('contribution.savings')->with('repayment.loan')->with('confirmed_by')->paginate(100);

        return response()->json([
            'payments' => $payments,
            ]);
    }

    public function store(Request $request)
    {
        
    }

    public function show($id)
    {
        if ($id == 'recent'){
            $payments = Payment::orderBy('date', 'DESC')->with('bank')->with('user')->with('contribution.savings')->with('repayment.loan')->with('confirmed_by')->paginate(100);
            }
        else if ($id == 'unconfirm'){
            $payments = Payment::where('status', '<', 3)->orderBy('date', 'DESC')->with('bank')->with('user')->with('contribution.savings')->with('repayment.loan')->with('confirmed_by')->paginate(100);
        }
        else if ($id == 'unconfirmed'){
            $payments = Payment::where('status', '<', 3)->orderBy('date', 'DESC')->with('bank')->with('user')->with('contribution.savings')->with('repayment.loan')->with('confirmed_by')->paginate(100);
        }
        else if ($id == 'confirm'){
            $payments = Payment::where('status', '>=', 3)->orderBy('date', 'DESC')->with('bank')->with('user')->with('contribution.savings')->with('repayment.loan')->with('confirmed_by')->paginate(100);
        }
        return response()->json([
            'payments' => $payments,
        ]);
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);

        if ($payment->payment_type == 'Repayment'){
            $repayment = Repayment::find($payment->ref_id);
            $loan = Loan::find($repayment->loan_id);
            
            $loan->total_paid = $loan->total_paid + $repayment->amount;
            $loan->save();

            $repayment->status = 4;
            $repayment->confirmed_by = auth('api')->id();
            $repayment->confirmed_date = date('Y-m-d H:i:s');
            $repayment->save();


        }
        else if(($payment->payment_type == 'Contributions payment') || ($payment->payment_type == 'Contribution payment')) {
            $contribution = Contribution::find($payment->ref_id);
            $savings = Saving::find($contribution->saving_id);

            if (($savings->unconfirmed != 0) && ($savings->unconfirmed < $contribution->amount)){
                $savings->unconfirmed = $savings->unconfirmed - $contribution->amount;
            }
            
            $savings->balance = $savings->balance + $contribution->amount;
            $savings->save();

            $contribution->status = 4;
            $contribution->confirmed_by = auth('api')->id();
            $contribution->confirmed_date = date('Y-m-d H:i:s');
            $contribution->save();
        }

        $payment->status = 4;
        $payment->confirmed_by = auth('api')->id();
        $payment->save();

        $payments = Payment::where('status', '<', 3)->orderBy('date', 'DESC')->with('bank')->with('user')->with('contribution.savings')->with('repayment.loan')->with('confirmed_by')->paginate(100);

        return response()->json([
            'payments' => $payments,
            ]);
    }

    public function destroy($id)
    {
        $payment = Payment::find($id);
        
        if ($payment->payment_type == 'Repayment'){
            $repayment = Repayment::find($payment->ref_id);
            
            $repayment->deleted_by = auth('api')->id();
            $repayment->status = 5;
            $repayment->save();
            $repayment->delete();
        }

        else if(($payment->payment_type == 'Contributions payment') || ($payment->payment_type == 'Contribution payment')) {
            $contribution = Contribution::find($payment->ref_id);
            $savings = Saving::find($contribution->saving_id);

            if (($savings->unconfirmed != 0) && ($savings->unconfirmed >= $contribution->amount)){
                $savings->unconfirmed = $savings->unconfirmed - $contribution->amount;
                $savings->save();
            }
            
            $contribution->deleted_by = auth('api')->id();
            $contribution->status = 5;
            $contribution->save();
            $contribution->delete();    
        }
        
        $payment->status = 5;
        $payment->save();

        return response()->json([
            'payments' => $payments = Payment::where('status', '<', 3)->orderBy('date', 'DESC')->with('bank')->with('user')->with('contribution.savings')->with('repayment.loan')->with('confirmed_by')->paginate(100),
        ]);
    }
}
