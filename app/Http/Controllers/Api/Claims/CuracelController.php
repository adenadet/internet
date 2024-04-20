<?php

namespace App\Http\Controllers\Api\Claims;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Claims\Company;
use App\Models\Claims\CompanyHMO;

class CuracelController extends Controller
{
    public function index()
    {
        
    }

    public function initials()
    {
        return response()->json([
            'hmos' => CompanyHMO::where('company_id', '=', 1)->orderBy('name', 'ASC')->get(),
        ]);
    }
    
    public function store(Request $request)
    {
        //
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
