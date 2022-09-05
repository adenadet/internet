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

class UserController extends Controller
{
    public function initials()
    {
        $users = User::where('branch_id', auth('api')->user()->branch_id)->paginate(52);
        return response()->json(['users' => $users]);
    }
      
    public function index()
    {
        $areas = Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get();
        $branches = Branch::select('id', 'name')->orderBy('name', 'ASC')->get();
        $departments = Department::select('id', 'name')->orderBy('name', 'ASC')->get();
        $nok = NextOfKin::where('user_id', auth('api')->id())->get();
        $states = State::orderBy('name', 'ASC')->get();
        $users = User::orderBy('first_name', 'ASC')->with('area')->with('state')->with('branch')->with('department')->with('roles')->paginate(51);
        
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

        $user = User::find($request->input('user_id'));
        $roles = Role::whereIn('id', $request->input('roles'))->get();
        $role_names = [];
        foreach ($roles as $role){
            array_push($role_names, $role->name);
            $user->removeRole($role->name);
        }
        $user->syncRoles($role_names);
        
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
        ]);

        $image_url = null;
        if (!is_null($request['image'])){
            $image = $request['id']."-".time().".".explode('/',explode(':', substr( $request['image'], 0, strpos($request['image'], ';')))[1])[1];
            \Image::make($request['image'])->save(public_path('img/profile/').$image);
            $image_url = $image;
        }
        
        $user = User::create([
            'email' => $request['email'],
            'first_name' => $request['first_name'],
            'middle_name' => $request['middle_name'],
            'last_name' => $request['last_name'],
            'street' => $request['street'],
            'street2' => $request['street2'],
            'city' => $request['city'],
            'state_id' => $request['state_id'],
            'area_id' => $request['area_id'],
            'personal_email' => $request['personal_email'],
            'phone' => $request['phone'],
            'alt_phone' => $request['alt_phone'],
            'branch_id' => $request['branch_id'],
            'department_id' => $request['department_id'],
            'sex' => $request['sex'],
            'dob' => $request['dob'],
            'image' => $image_url,
            'updated_at' => date('Y-m-d H:i:s'),
            'joined_at' => $request['joined_at'],
            'unique_id' => $request['unique_id'],
            ]);

        $user->save();

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
        if ($search = \Request::get('q')){
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
        
        if ($request->input('image')){
            $name = time().'.'.explode('/',explode(':', substr($request->input('image'), 0, strpos($request->input('image'), ';'))))[1][1];
        }
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
            'patient' => Patient::where('user_id',  auth('api')->id())->first(),       
        ]);
    }
    
    public function show($id)
    {
        
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

        $user = User::find($id);
        $image_url = $currentPhoto = $user->image;
         
        if (($request['image'] != $currentPhoto) && ($request['image'] != '')){
            $image = $request['id']."-".time().".".explode('/',explode(':', substr( $request['image'], 0, strpos($request['image'], ';')))[1])[1];
            \Image::make($request['image'])->save(public_path('img/profile/').$image);
            $image_url = $image;
            $old_image = public_path('img/profile/').$currentPhoto;

            if (file_exists($old_image)){ @unlink($old_image); }
        }

        $user->email = $request['email'];
        $user->first_name = $request['first_name'];
        $user->middle_name = $request['middle_name'];
        $user->last_name = $request['last_name'];
        $user->street = $request['street'];
        $user->street2 = $request['street2'];
        $user->city = $request['city'];
        $user->state_id = $request['state_id'];
        $user->area_id = $request['area_id'];
        $user->personal_email = $request['personal_email'];
        $user->phone = $request['phone'];
        $user->alt_phone = $request['alt_phone'];
        $user->branch_id = $request['branch_id'];
        $user->department_id = $request['department_id'];
        $user->sex = $request['sex'];
        $user->dob = $request['dob'];
        $user->image = $image_url;
        $user->updated_at = date('Y-m-d H:i:s');
        $user->joined_at = $request->input('joined_at');
        $user->dob = $request->input('dob');
        $user->unique_id = $request->input('unique_id');
            
        $user->save();

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

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json([
            // This are the required for User page
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'branches' => Branch::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'departments' => Department::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'nok' => NextOfKin::where('user_id', auth('api')->id())->get(),
            'states' => State::orderBy('name', 'ASC')->get(),       
            'users' => User::orderBy('first_name', 'ASC')->with('area')->with('state')->with('branch')->with('department')->paginate(51),

            //This is the based on the service requested
            'message' => 'The user '.$user->first_name.' '.$user->last_name.' has been deleted',
            'status' => 'success', 
            'user' => $user,
        ]);
    }
}
