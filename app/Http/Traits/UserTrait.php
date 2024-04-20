<?php
namespace App\Http\Traits;

use App\Http\Traits\FileManagementTrait;

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

trait UserTrait{

    use FileManagementTrait;

    public function user_create_new_user($request, $image_url){
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
            'password' => bcrypt('asdfasdf'),
        ]);
        return $user;
    }

    public function user_get_all(){
        return User::orderBy('first_name', 'ASC')->with(['area', 'branch', 'department', 'roles', 'state'])->paginate(51);
    }

    public function user_get_all_staffs($paginated){
        $staffs = Staff::select('user_id')->get();
        $users = User::whereIn('id', $staffs)->orderBy('first_name', 'ASC')->with(['area', 'branch', 'department', 'roles', 'state']);

        if ($paginated){$users = $users->paginate(51);}
        else{$users = $users->get();}
        
        return $users;
    }
    public function user_update_user($request, $id){
        $user = User::where('id', '=', $id)->first();

        $image_url = ((!(is_null($request->input('image')))) && ($request->input('image') != $user->image))? $this->file_upload('image', 'uploads/profile', $id): $user->image;
        
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

        return $user;
    }
}