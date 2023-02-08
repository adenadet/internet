<?php

namespace App\Http\Controllers\Api\Coop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Branch;
use App\Models\Bank;
use App\Models\Loan;
use App\Models\LoanType;
use App\Models\Payment;
use App\Models\Repayment;
use App\Models\User;

class RepaymentsController extends Controller
{
    public function initials()
    {
        $loans = Loan::where('user_id', auth('api')->id())->with('branch.users.loans')->with('repayments')->with('user')->get();
        $loan_types = LoanType::all();
        $branches = Branch::with('users.loans')->get();
        $accounts = Bank::all();
        $users = User::with('branch')->get();
        return response()->json([
            'accounts' => $accounts,       
            'branches' => $branches,       
            'loan_types' => $loan_types,       
            'loans' => $loans,
            'users' => $users,       
            ]);
    }

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'loan_id' => 'required|numeric',
            'bank_id' => 'required|numeric',
            'payment_date'=> 'required|date',
            'amount'=> 'required|numeric',
            'description' => 'nullable|string',
            ]);

        if ($request->input('user_id')){
            //$this->validate($request, ['user_id' => 'required|numeric',]);
            $loan = Loan::find($request['loan_id']);
            $user_id = $loan->user_id; 
            }
        else{
            $user_id = auth('api')->id(); 
            }

        $repayment = Repayment::create([
            'loan_id' => $request['loan_id'],
            'bank_id' => $request['bank_id'],
            'payment_date'=> $request['payment_date'],
            'amount'=> $request['amount'],
            'description' => $request['description'],
            'user_id' => $user_id,
            'payment_channel' => 'Bank payment',
            'trans_type' => 1,
            'status' => 2,
            'logged_by' => auth('api')->id(),
            'logged_date' => date('Y-m-d H:i:s'), 
        ]);

        $loan = Loan::find($request['loan_id']);
        
        $payment = Payment::create([
            'user_id' => $loan->user_id,
            'amount' => $request['amount'],
            'ref_id' => $loan->id,
            'date' => $request['payment_date'],
            'payment_type' => "Repayment",
            'bank_id' => $request['bank_id'],
            'status' => 2,
            'description' => $request['description'], 
        ]);

        return response()->json([
            'repayment' => $repayment,
            'status' => 'Repayment successfully added',
            ]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'loan_id' => 'required|numeric',
            'id' => 'required|numeric',
            'bank_id' => 'required|numeric',
            'payment_date'=> 'required|date',
            'amount'=> 'required|numeric',
            'description' => 'nullable|string',
            ]);

        $repayment = Repayment::find($id);
        $payment = Payment::where(['ref_id' => $id, 'payment_type' => 'Repayment'])->get();
        $loan = Loan::find($request['loan_id']);
        print_r($payment);
        if (($repayment->status >= 3) && ($repayment->status != 5)) {
            return response()->json([
                'contribution' => $repayment,
                'status' => 'Something went wrong!',
                ]);
        }

        else{
            $repayment->loan_id = $request['loan_id'];
            $repayment->bank_id = $request['bank_id'];
            $repayment->payment_date = $request['payment_date'];
            $repayment->amount = $request['amount'];
            $repayment->description = $request['description'];
            $repayment->user_id = auth('api')->id();
            $repayment->payment_channel = 'Bank payment';
            $repayment->status = 2;
            $repayment->logged_by = auth('api')->id();
            $repayment->logged_date = date('Y-m-d'); 
            
            $repayment->save();

            $payment = Payment::updateOrCreate(['ref_id' => $repayment->id, 'payment_type' => 'Repayment'],
            ['user_id' => $loan->user_id, 'amount' => $request['amount'], 'date' => $request['date'], 'bank_id' => $request['bank_id'], 'status' => 2, 'description' => $request['description'],]);

            return response()->json([
                'repayment' => $repayment,
                'status' => 'Repayment successfully updated',
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
