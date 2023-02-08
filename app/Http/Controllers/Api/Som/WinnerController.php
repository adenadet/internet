<?php

namespace App\Http\Controllers\Api\Som;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SOM\Winner;
use App\Models\SOM\Month;

class WinnerController extends Controller
{
    public function index()
    {
        $som_months = Month::with('winners.user.branch')->orderBy('month', 'DESC')->paginate(10);
        
        $staff_month = $this->staff_months('1');
        
        return response()->json([
            'som_months'   => $som_months,
            'staff_months'  => Winner::where('month_id', '=', $staff_month)->with('user.department')->with('branch')->get(),
        ]);

    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $som_months = Month::with('winners.user.branch')->orderBy('month', 'DESC')->paginate(10);
        
        return response()->json([
            'som_months'   => $som_months,
            'staff_months'  => Winner::where('month_id', '=', $id)->with('user.department')->with('branch')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    private function staff_months($i){
        if (!is_numeric($i)){return $i;}
        $date = date('Y-m-01', strtotime("-".$i." months"));
        
        $staff_month = Month::where('month', '=', $date)->with('winners')->first(); 
        
        if ($staff_month && (count($staff_month->winners) != 0)){ 
            return $staff_month->id;
        }
        else { return $this->staff_months($i+1); }
    }
}
