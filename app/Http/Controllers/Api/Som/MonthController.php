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
            'staff_month'    => Month::orderBy('month', 'DESC')->first(),
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
            'staff_month'    => Month::orderBy('month', 'DESC')->first(),
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
        $this->validate($request, [
            'month' => 'required', 
            'nomination_start' => 'required|date',
            'voting_start' => 'required|date', 
        ]);

        $staff_month = Month::find($id);
            
        $staff_month->month = $request->input('month').'-01';
        $staff_month->nomination_start = $request->input('nomination_start');
        $staff_month->nomination_end = (($request->input('nomination_end') != '') || is_null($request->input('nomination_end'))) ?$request->input('nomination_end') : NULL;
        $staff_month->voting_start = $request->input('voting_start');
        $staff_month->voting_end = (($request->input('voting_end') != '') || !(is_null($request->input('voting_end')))) ? $request->input('voting_end') : NULL;
        $staff_month->nomination_end_id = (($request->input('nomination_end') != '') || !(is_null($request->input('nomination_end')))) ? auth('api')->id() : NULL;
        $staff_month->nominate_initiate_id = auth('api')->id();
        $staff_month->voting_initiate_id = auth('api')->id();
        $staff_month->voting_end_id = (($request->input('voting_end') != '') || !(is_null($request->input('voting_end'))))  ? auth('api')->id() : NULL;
    
        $staff_month->save();

        return response()->json([
            'staff_months'  => Month::orderBy('month', 'DESC')->paginate(12),
            'staff_month'   => $staff_month, 
        ]);
    }

    public function destroy($id)
    {
        //
    }
}
