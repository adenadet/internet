<?php

namespace App\Http\Controllers\Api\Ums;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Models\Area;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Department;
use App\Models\NextOfKin;
use App\Models\Staff;
use App\Models\State;
use App\Models\User;

use App\Models\EMR\Patient;

use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    public function index()
    {
        $areas = Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get();
        $branches = Branch::select('id', 'name')->orderBy('name', 'ASC')->get();
        $departments = Department::select('id', 'name')->orderBy('name', 'ASC')->get();
        $nok = NextOfKin::where('user_id', auth('api')->id())->get();
        $states = State::orderBy('name', 'ASC')->get();
        $staffs = Staff::select('user_id')->get();
        $users = User::whereIn('id', $staffs)->orderBy('first_name', 'ASC')->with('area')->with('state')->with('branch')->with('department')->with('roles')->paginate(51);
        
        return response()->json([
            'areas' => $areas,
            'branches' => $branches,
            'departments' => $departments,
            'nok' => $nok,
            'states' => $states,       
            'users' => $users,
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
