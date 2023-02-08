<?php

namespace App\Http\Controllers\Api\Coop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Branch;
use App\Models\State;
use App\Models\User;


class BranchesController extends Controller
{
    public function index()
    {
        $branches = Branch::select('id', 'name', 'current')->with('users')->get();
        $states = State::select('id', 'name')->with('areas')->get(); 

        return response()->json([
            'branches' => $branches,
            'states' => $states,
        ]);

    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $branches = Branch::select('id', 'name', 'current')->where('id', '=', $id)->with('users')->get();
        $states = State::select('id', 'name')->with('areas')->get(); 

        return response()->json([
            'branches' => $branches,
            'states' => $states,
        ]);
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
}
