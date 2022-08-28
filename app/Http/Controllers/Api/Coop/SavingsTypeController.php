<?php

namespace App\Http\Controllers\Api\Coop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SavingType;

class SavingsTypeController extends Controller
{
    //
    public function initials()
    {
        $saving_types = SavingType::where('status', '1')->get() ;
        return response()->json([
            'saving_types' => $saving_types,       
            ]);
    }
}
