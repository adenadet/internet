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

use App\Http\Traits\UserTrait;

class StaffController extends Controller
{
    use userTrait;

    public function index()
    {
        $areas = Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get();
        $branches = Branch::select('id', 'name')->orderBy('name', 'ASC')->get();
        $departments = Department::select('id', 'name')->orderBy('name', 'ASC')->get();
        $nok = NextOfKin::where('user_id', auth('api')->id())->get();
        $states = State::orderBy('name', 'ASC')->get();
        
        return response()->json([
            'areas' => $areas,
            'branches' => $branches,
            'departments' => $departments,
            'nok' => $nok,
            'states' => $states,       
            'users' => $this->user_get_all_staffs(true),
        ]);
    }
    
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return response()->json([
            'staff' => Staff::where('user_id', '=', $id)->with(['branch', 'department'])->first(),       
            'user' => User::find($id),
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
