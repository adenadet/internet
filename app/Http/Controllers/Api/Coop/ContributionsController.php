<?php
namespace App\Http\Controllers\Api\Coop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Branch;
use App\Models\Bank;
use App\Models\Contribution;
use App\Models\Payment;
use App\Models\Saving;
use App\Models\User;

use App\Imports\ContributionsImport;
use Maatwebsite\Excel\Facades\Excel;

class ContributionsController extends Controller

{

    public function initials()

    {

        $savings = Saving::where('user_id', auth('api')->id())->with('branch')->with('contributions')->with('user')->get();

        $branches = Branch::all();

        $accounts = Bank::all();

        return response()->json([

            'accounts' => $accounts,       

            'branches' => $branches,       

            'savings' => $savings,       

            ]);

    }

    

    public function index()

    {

        //

    }



    public function store(Request $request)

    {

        //Validation

        $this->validate($request, [

            'saving_id' => 'required|numeric',

            'bank_id' => 'required|numeric',

            'payment_date'=> 'required|date',

            'amount'=> 'required|numeric',

            'description' => 'nullable|string',

            ]);

        

        //Get Defaults

        $saving = Saving::find($request->input('saving_id'));

        $description = ($request['description']) ? $request['description'] : ' ';

        

        //Insert Contribution

        $contribution = Contribution::create([

            'saving_id' => $request['saving_id'],

            'bank_id' => $request['bank_id'],

            'payment_date'=> $request['payment_date'],

            'amount'=> $request['amount'],

            'description' => $description,

            'user_id' => auth('api')->id(),

            'payment_channel' => 'Bank payment',

            'trans_type' => 1,

            'status' => 2,

            'logged_by' => auth('api')->id(),

            'logged_date' => date('Y-m-d H:i:s'), 

        ]);

        

        //Insert Payment

        $payment = Payment::create([

            'user_id' => auth('api')->id(),

            'ref_id' => $contribution->id,

            'payment_type' => 'Contribution payment', 

            'date' => $request->input('payment_date'),

            'amount' => $request->input('amount'),

            'bank_id' => $request->input('bank_id'),

            'admin_id' => $request->input('admin_id'),

            'status' => 2,

        ]);

        

        //Increase Unconfrmed

        $saving->unconfirmed = $saving->unconfirmed + $request['amount'];



        //Return Values

        return response()->json([

            'contribution' => $contribution,

            'status' => 'Contribution successfully added',

            ]);

         

    }



    public function show($id)

    {

        //

    }



    public function update(Request $request, $id)

    {

        $this->validate($request, [

            'saving_id' => 'required|numeric',

            'bank_id' => 'required|numeric',

            'payment_date'=> 'required|date',

            'amount'=> 'required|numeric',

            'description' => 'nullable|string',

            ]);



        $contribution = Contribution::find($id);



        if (($contribution->status >= 3) && ($contribution->status != 5)) {

            return response()->json([

                'contribution' => $contribution,

                'status' => 'Something went wrong!',

                ]);

        }



        else{

            $contribution->saving_id = $request['saving_id'];

            $contribution->bank_id = $request['bank_id'];

            $contribution->payment_date = $request['payment_date'];

            $contribution->amount = $request['amount'];

            $contribution->description = $request['description'];

            $contribution->user_id = auth('api')->id();

            $contribution->payment_channel = 'Bank payment';

            $contribution->trans_type = 1;

            $contribution->status = 2;

            $contribution->logged_by = auth('api')->id();

            $contribution->logged_date = date('Y-m-d H:i:s'); 

            

            $contribution->save();



            return response()->json([

                'contribution' => $contribution,

                'status' => 'Contribution successfully updated',

                ]);

        }

    }



    public function destroy($id)

    {

        //

    }



    public function import(Request $request)

    {

        $request->validate(['import_file' => 'required|file|mimes:xls,xlsx']);



        $path = $request->file('import_file');

        $data = Excel::import(new ContributionsImport, $path);



        return response()->json(['message' => 'uploaded successfully'], 200);

    }

}

