<?php

namespace App\Http\Controllers\Api\Icms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Network\Check;

class CheckController extends Controller
{
    public function index(){
        //Get All the Checks
        $checks = Check::all();

        return response()->json([
            'checks' => $checks, 
            'current_time' => date('Y-m-d H:i:s'),  
            'message' => 'Working',    
        ]);
        
    }


    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $response = null;

        $check = Check::findorfail($id);

        return response()->json([
            'check' => $check,     
            'current_time' => date('Y-m-d H:i:s'),  
        ]);
        
    }

    public function checked($id)
    {
        $stat = $_GET['stat'];
        $check = Check::findorfail($id);

        if ($stat == 1){
            $check->last_check_time = $check->last_active_time = date('Y-m-d H:i:s');
            $check->status = 1;
            $check->save();
        }
        else if ($stat == 2){
            $check->last_check_time = date('Y-m-d H:i:s');
            $check->status = 2;
            $check->save();
        }
        
        return response()->json([
            'check' => $check,     
            'current_time' => date('Y-m-d H:i:s'),  
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
}
