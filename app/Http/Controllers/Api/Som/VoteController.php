<?php

namespace App\Http\Controllers\Api\Som;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SOM\Nomination;
use App\Models\SOM\Vote;
use App\Models\SOM\Winner;

class VoteController extends Controller
{
    public function index()
    {
        $date = date("Y-m",strtotime("-1 month"));
        $vote = Vote::where('created_by', '=', auth('api')->id())->where('month', '=', $date)->first(); 
        if ($vote){$previous = 1;}
        else{$previous = 0;}

        return response()->json([
            'nominations'   => Nomination::where('month', '=', $date)->with('nominee')->get(),
            'previous'      => $previous,
            'vote'          => $vote,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'month'         => 'required',
            'user_id'       => 'required|numeric', 
        ]);

        $test_nomination = Vote::where('created_by', '=', auth('api')->id())->where('month', '=', $request->input('month'))->count();
        if ($test_nomination > 0){
            return response()->json([
                'previous'  => 1,
                'vote'      => Vote::where('created_by', '=', auth('api')->id())->where('month', '=', $request->input('month'))->first(),
            ]);
        } 
        else{
            $vote = Vote::create([
                'user_id'       => $request->input('user_id'), 
                'month'         => $request->input('month'), 
                'created_by'    => auth('api')->id(), 
                'updated_by'    => auth('api')->id(), 
            ]);

            return response()->json([
                'vote'    => $vote,
                'previous'      => 0,
            ]);
        }
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
