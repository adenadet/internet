<?php

namespace App\Http\Controllers\Api\Som;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SOM\Month;
use App\Models\SOM\Nomination;
use App\Models\SOM\Vote;
use App\Models\SOM\Winner;

use App\Models\Branch;

class VoteController extends Controller
{
    public function close(Request $request, $id){
        $month = Month::where('month', '=', $id.'-01')->first();
        $month->voting_end = date('Y-m-d H:i:s');
        $month->voting_end_id = auth('api')->id();
        $month->save();

        $branches = Branch::all();
        foreach ($branches as $branch){
            $query = Nomination::select('id')->where([['month', '=', $id], ['branch_id', '=', $branch->id]])->withCount('votes');
            $count = $query->count();
            if ($count > 0){
                $queries = $query->get()->toArray();

                /*echo $queries[0]->votes_count;*/
                $nominations = usort($queries,function($first,$second){
                    return $first['votes_count'] < $second['votes_count'];
                });

                $nomination = Nomination::where('id', '=', $queries[0]['id'])->first();

                $winner = Winner::create([
                    'user_id' => $nomination->user_id,
                    'month_id' => $month->id,
                    'branch_id' => $branch->id,
                    'created_by' => auth('api')->id() ?? 1,
                    'updated_by' => auth('api')->id() ?? 1,
                ]);
            }
        }
        return response()->json([
            'nominations'   => Nomination::where('month', '=', $id)->with(['branch', 'nominee', 'nominator', 'votes'])->get(),
            'previous'      => 0,
            'staff_month'   => $month,
        ]);
    }
    
    public function index(){
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
            'nomination_id' => 'required|numeric', 
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
                'nomination_id'       => $request->input('nomination_id'), 
                'month'         => $request->input('month'), 
                'user_id'       => auth('api')->id(),
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
        return response()->json([
            'nominations'    => Nomination::where('month', '=', $id)->with(['branch', 'nominee', 'nominator', 'votes'])->get(),
            'previous'      => 0,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'month'         => 'required',
            'nomination_id' => 'required|numeric', 
        ]);

        $vote = Vote::find($id);

        $vote->nomination_id = $request->input('nomination_id');
        $vote->month         = $request->input('month');
        $vote->updated_by    = auth('api')->id();
        
        $vote->save();

        return response()->json([
            'vote'    => $vote,
            'previous'      => 0,
        ]);

    }

    public function destroy($id)
    {
        //
    }
}
