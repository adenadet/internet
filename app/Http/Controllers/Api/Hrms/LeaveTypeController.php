<?php

namespace App\Http\Controllers\Api\Hrms;

use App\Http\Controllers\Controller;
use App\Http\Traits\Hrms\LeaveTrait;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    use LeaveTrait;
    
    public function assign(Request $request){
        return response()->json([
            'leave_types' =>$this->hrms_leave_employee_assign_leave_types($request->input('employee_id'), $request->input('leave_types')),
        ]);
    }

    public function index()
    {
        return response()->json([
            'leave_types' => $this->hrms_leave_type_get_all_types('all', true, true),    
        ]);
    }

    public function initials()
    {
        return response()->json([
            'my_leave_types' => $this->hrms_leave_types_get_my_current_leave_types(null, false, true),    
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:8',
            'no_of_days' => 'required|numeric',
            'status' => 'required|boolean',
            'start_date' => 'sometimes|date|nullable',
            'end_date' => 'sometimes|date|nullable',
        ]);

        return response()->json([
            'leave_type' => $this->hrms_leave_types_create_type($request),
            'leave_types' => $this->hrms_leave_type_get_all_types('all', true, true),    
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'leave_type' => $this->hrms_leave_types_show_type($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|min:8',
            'no_of_days' => 'required|numeric',
            'status' => 'required|boolean',
            'start_date' => 'sometimes|date|nullable',
            'end_date' => 'sometimes|date|nullable',
        ]);

        return response()->json([
            'leave_type'=> $this->hrms_leave_types_update_type($request, $id),
            'leave_types' => $this->hrms_leave_type_get_all_types('all', true, true),    
        ]);
    }

    public function destroy($id)
    {
        return response()->json([
            'leave_type'=> $this->hrms_leave_types_delete_by_id($id),
            'leave_types' => $this->hrms_leave_type_get_all_types('all', true, true),    
        ]);
    }
}
