<?php

namespace App\Http\Controllers\Api\Coop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Branch;
use App\Models\Bank;
use App\Models\Payment;
use App\Models\Saving;
use App\Models\SavingType;

class SavingsController extends Controller
{
    public function branch($id)
    {
        $saving_types = SavingType::where('status', '1')->get();
        $branches = Branch::select('id', 'name')->where('id', '=', $id)->with('users')->get();
        return response()->json([
            'branches' => $branches,       
            'saving_types' => $saving_types,       
            ]);
    }

    public function initials()
    {
        $savings = Saving::where('user_id', auth('api')->id())->with('branch')->with('contributions')->with('user')->get();
        $saving_types = SavingType::where('status', '1')->get();
        $banks = Bank::all();
        $branches = Branch::all();
        $accounts = Bank::all();
        return response()->json([
            'accounts' => $accounts,
            'banks' => $banks,       
            'branches' => $branches,       
            'saving_types' => $saving_types,       
            'savings' => $savings,       
            ]);
    }

    public function index()
    {
        $saving_types = SavingType::where('status', '1')->get();
        $branches = Branch::select('id', 'name')->with('users')->get();
        return response()->json([
            'branches' => $branches,       
            'saving_types' => $saving_types,       
            ]);
    }

    public function balance($id)
    {
        $saving = Saving::where('user_id', '=', $id)->where('name', 'LIKE', '%Contribution%')->first();
        $balance = $saving ?  1.9 * ($saving->balance - $saving->fixed) : 0;
        return response()->json(['balance' => $balance,]);
    }

    public function store(Request $request)
    {
        if ($request->input('user_id')){
            $this->validate($request, [
                'user_id' => 'required|numeric',
                'branch_id' => 'required|numeric',
                ]);

            $branch_id = $request->input('branch_id'); 
            $user_id = $request->input('user_id'); 
            }
        else{
            $branch_id = $request->input('branch_id'); 
            $user_id = auth('api')->id(); 
            }
        $this->validate($request, [
            'saving_type_id' => 'required|numeric',
            'name' => 'required|string',
            'target'=> 'required|numeric',
            ]);

        $saving = Saving::create([
            'type_id' => $request['saving_type_id'],
            'user_id' => $user_id,
            'balance' => 0,
            'fixed' => 0,
            'unconfirmed' => 0,
            'name' => $request['name'],
            'target' => $request['target'],
            'status' => 1,
            'status_date' => date('Y-m-d H:i:s'),
            'request_date' => date('Y-m-d H:i:s'),
            'requested_by' => auth('api')->id(),
        ]);

        return response()->json([
            'saving' => $saving,       
            'status' => 'Successfully created',
            ]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
