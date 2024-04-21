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
class UserController extends Controller
{
    use UserTrait;

    public function initials()
    {
        return response()->json(['users' => $this->user_get_all()]);
    }
      
    public function index()
    {
        $areas = Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get();
        $branches = Branch::select('id', 'name')->orderBy('name', 'ASC')->get();
        $departments = Department::select('id', 'name')->orderBy('name', 'ASC')->get();
        $nok = NextOfKin::where('user_id', auth('api')->id())->get();
        $states = State::orderBy('name', 'ASC')->get();
        $users = $this->user_get_all();
        
        return response()->json([
            'areas' => $areas,
            'branches' => $branches,
            'departments' => $departments,
            'nok' => $nok,
            'states' => $states,       
            'users' => $users,
        ]);
    }

    public function roles(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|numeric',
            'roles' => 'required|array',
        ]);

        print_r($request->input('roles'));
        $user = User::find($request->input('user_id'));
        
        $roles = Role::select('id', 'name')->whereIn('id', $request->input('roles'))->get();
        print_r($roles);
        
        $user->syncRoles($request->input('roles'));
        
        $areas = Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get();
        $branches = Branch::select('id', 'name')->orderBy('name', 'ASC')->get();
        $departments = Department::select('id', 'name')->orderBy('name', 'ASC')->get();
        $nok = NextOfKin::where('user_id', auth('api')->id())->get();
        $states = State::orderBy('name', 'ASC')->get();
        $users = User::orderBy('first_name', 'ASC')->with('area')->with('state')->with('branch')->with('roles')->paginate(51);

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
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'street' => 'sometimes',
            'street2' => 'sometimes',
            'city' => 'required',
            'state_id' => 'numeric',
            'area_id' => 'numeric',
            'phone' => 'numeric',
            'alt_phone' => 'nullable|numeric',
            //'branch_id' => 'required|numeric',
            'sex' => 'required|string',
            'dob' => 'required|date',
            //'unique_id' => 'required|unique:users',
            'supervisor_id' => 'sometimes|numeric',
        ]);
    
        $user = $this->user_create_new_staff($request, null);

        return response()->json([
            // This are the required for User page
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'branches' => Branch::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'departments' => Department::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'nok' => NextOfKin::where('user_id', auth('api')->id())->get(),
            'states' => State::orderBy('name', 'ASC')->get(),       
            'users' => User::orderBy('first_name', 'ASC')->with('area')->with('state')->with('branch')->with('department')->paginate(51),

            //This is the based on the service requested
            'message' => 'Your password has been changed successfully',
            'status' => 'success', 
            'user' => $user,
        ]);
    }
    
    public function search()
    {
        if ($search = $_GET['q']){
            $users = User::orderBy('first_name', 'ASC')->with('area')->with('state')->with('branch')->with('department')->where(function($query) use ($search){
                $query->where('first_name', 'LIKE', "%$search%")
                ->orWhere('middle_name', 'LIKE', "%$search%")
                ->orWhere('last_name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%");
                })->paginate(52);
            }
        else{
            $users = User::orderBy('first_name', 'ASC')->with('area')->with('state')->with('branch')->with('department')->paginate(52);
        }
        
        return response()->json(['users' => $users,]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();

        return response()->json(['status' => 'Successful']);
    }

    public function password(Request $request)
    {
        $this->validate($request, [
            'npw' => 'required|min:8|required_with:cpw|same:cpw',
            'opw' => 'required',
            'cpw' => 'required|min:8',
        ]);

        $user = User::find(auth('api')->id());
        
        $user->password = bcrypt($request->npw);
        $user->save();
        return response()->json(['status' => 'success', 'message' => 'Your password has been changed successfully']);
        
    }
    
    public function profile()
    {
        $areas = Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get();
        $branches = Branch::select('id', 'name')->orderBy('name', 'ASC')->get();
        $departments = Department::select('id', 'name')->orderBy('name', 'ASC')->get();
        $nok = NextOfKin::where('user_id', auth('api')->id())->first();
        $states = State::orderBy('name', 'ASC')->get();
        $user = User::where('id', auth('api')->id())->with('area')->with('state')->with('branch')->first();
        
        return response()->json([
            'nations' => Country::orderBy('name', 'ASC')->get(),
            'areas' => $areas,
            'user' => $user,
            'branches' => $branches,
            'departments' => $departments,
            'nok' => $nok,
            'states' => $states,
            //'patient' => Patient::where('user_id',  auth('api')->id())->first(),       
        ]);
    }
    
    public function show($id)
    {
        $user = User::find($id);
        $areas = Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get();
        $branches = Branch::select('id', 'name')->orderBy('name', 'ASC')->get();
        $departments = Department::select('id', 'name')->orderBy('name', 'ASC')->get();
        $nok = NextOfKin::where('user_id', auth('api')->id())->get();
        $states = State::orderBy('name', 'ASC')->get();
        $users = $this->user_get_all();

        return response()->json([
            'nations' => Country::orderBy('name', 'ASC')->get(),
            'areas' => $areas,
            'user' => $user,
            'branches' => $branches,
            'departments' => $departments,
            'nok' => $nok,
            'states' => $states,
            'patient' => Patient::where('user_id',  auth('api')->id())->first(),       
        ]);
    }


    public function details(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'nationality_id' => 'required',
            'passport_no' => 'required',
        ]);

        $patient = Patient::find($request->input('user_id'));

        $patient->nationality_id = $request->input('nationality_id');
        $patient->passport_no = $request->input('passport_no');

        $patient->save();
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'street' => 'sometimes',
            'street2' => 'sometimes',
            'city' => 'required',
            'state_id' => 'numeric',
            'area_id' => 'numeric',
            'phone' => 'numeric',
            'alt_phone' => 'nullable|numeric',
            'branch_id' => 'required|numeric',
            'sex' => 'required|string',
            'dob' => 'required|date',
        ]);

        $user = $this->user_update_user($request, $id);

        return response()->json([
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'branches' => Branch::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'departments' => Department::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'nok' => NextOfKin::where('user_id', auth('api')->id())->get(),
            'states' => State::orderBy('name', 'ASC')->get(),       
            'users' => $this->user_get_all(),
            'message' => 'Your password has been changed successfully',
            'status' => 'success', 
            'user' => $user,
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        
        return response()->json([
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'branches' => Branch::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'departments' => Department::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'nok' => NextOfKin::where('user_id', auth('api')->id())->get(),
            'states' => State::orderBy('name', 'ASC')->get(),       
            'users' => $this->user_get_all(),
            'message' => 'The user '.$user->first_name.' '.$user->last_name.' has been deleted',
            'status' => 'success', 
            'user' => $user,
        ]);
    }
}
