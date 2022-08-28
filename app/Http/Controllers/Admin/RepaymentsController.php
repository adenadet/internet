<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Branch;
use App\Models\Bank;
use App\Models\Contribution;
use App\Models\Payment;
use App\Models\Saving;
use App\Models\User;

use App\Imports\RepaymentsImport;
use Maatwebsite\Excel\Facades\Excel;

class RepaymentsController extends Controller
{
    public function index()
    {
        return view('repayment');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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

    public function import(Request $request){
        $request->validate(['sample_file' => 'required|file|mimes:xls,xlsx,csv']);

        Excel::import(new RepaymentsImport,$request->file('sample_file'));
        
        return redirect()->route('repayments.index')->with('success', "The New Repayments have imported successfully");
        
    }
}
