<?php

namespace App\Http\Controllers\Api\Som;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SOM\Month;
use App\Models\SOM\Winner;

class MonthController extends Controller
{
    public function index()
    {
        return response()->json([
            'staff_months'   => Month::orderBy('month', 'DESC')->paginate(12),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'month' => 'required', 
            'nomination_start' => 'required|date',
            'voting_start' => 'required|date', 
        ]);

        $staff_month = Month::create([
            'month' => $request->input('month').'-01',
            'nomination_start' => $request->input('nomination_start'),
            'nomination_end' => (($request->input('nomination_end') != '') || is_null($request->input('nomination_end'))) ?$request->input('nomination_end') : NULL,
            'voting_start' => $request->input('voting_start'),
            'voting_end' => (($request->input('voting_end') != '') || !(is_null($request->input('voting_end')))) ? $request->input('voting_end') : NULL,
            'nomination_end_id' => (($request->input('nomination_end') != '') || !(is_null($request->input('nomination_end')))) ? auth('api')->id() : NULL,
            'nominate_initiate_id' => auth('api')->id(),
            'voting_initiate_id' => auth('api')->id(),
            'voting_end_id' => (($request->input('voting_end') != '') || !(is_null($request->input('voting_end'))))  ? auth('api')->id() : NULL
        ]);

        return response()->json([
            'staff_months'   => Month::orderBy('month', 'DESC')->paginate(12),
        ]);

    }

    public function show($id)
    {
        $month = Month::where('month', '=', $id.'-01')->with(['nomination_close', 'nomination_open', 'voting_close', 'voting_open',])->first();

        return response()->json([
            'month'   => $month,
        ]);

    }

    public function update(Request $request,$id)
    {
        //
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
