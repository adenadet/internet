<?php 

namespace App\Http\Traits\Hrms;

use App\Http\Traits\LogTrait;
use App\Http\Traits\FileManagementTrait;

use App\Models\HRMS\AttendanceSummary;
use App\Models\HRMS\Branch;
use App\Models\HRMS\Employee;
use App\Models\HRMS\EmployeeLeaveType;
use App\Models\HRMS\LeaveRequest;
use App\Models\HRMS\LeaveType;
use App\Models\HRMS\OrganizationHierarchy;

use App\Mail\AdminApplyLeaveMail;
use App\Mail\ApplyLeaveMail;
use App\Mail\Leave\RequestMail;
use App\Mail\LeaveStatusMail;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Session;

trait LeaveTrait{
    use FileManagementTrait, LogTrait;
    public function hrms_leave_employee_assign_leave_types($employee_id, $leave_types){
        DB::beginTransaction();

        try{
            foreach($leave_types as $leave_type){
                $employee_leave_type = EmployeeLeaveType::create([
                    'employee_id' => $employee_id,
                    'leave_type_id' => $leave_type,
                    'days_used' => 0,
                    'pending_days' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                $this->log_user_activity('leave_request_confirm', $leave_types, false);
            }
        } 
        catch(Exception $e){
            $this->log_user_activity('leave_request_confirm', $leave_types, false);
            $complete = false;
        }
        if ($complete){
            DB::commit();
            $employee_leave_types = $this->hrms_leave_types_get_my_current_leave_types($employee_id, true, true);
            return $employee_leave_types;
        }
        else{
            DB::rollBack();
        } 
    }
    public function hrms_leave_request_confirm_leave($id){
        DB::beginTransaction();
        try{
            //Update the leave request to confirmed 
            $leave_request = LeaveRequest::where('id', '=', $id)->with(['employee.user', 'leave_type'])->first();
            $leave_request->status = 3;
            $leave_request->approved_by = auth('api')->id();
            $leave_request->approved_at = date('Y-m-d H:i:s');
            $leave_request->save();

            $days = $this->hrms_leave_request_number_of_days($leave_request);
            
            //Update Employee Leave Type to ensure the dates are aligned 
            $employee_leave_type = EmployeeLeaveType::where('employee_id', '=', $leave_request->employee_id)->where('leave_type_id', '=', $leave_request->leave_type_id)->first();
            $employee_leave_type->pending_days -= $days;
            $employee_leave_type->days_used += $days;
            $employee_leave_type->save();
            
            $this->log_user_activity('leave_request_confirm', $id, true);
            $complete = true;
        }
        catch(Exception $e){
            $this->log_user_activity('leave_request_confirm', $id, false);
            $complete = false;
        }
        if ($complete){
            DB::commit();
            return $leave_request;
        }
        else{
            DB::rollBack();
        }    
    }

    public function hrms_leave_request_create_leave($request, $employee){
        DB::beginTransaction();
        try{
            //upload leave attachment
            $leave_attachment = !(is_null($request->input('leave_attachment'))) ?$this->file_upload($request->input('pdf'), null, 'uploads/leave_requests', $employee->user_id): null;
            //create a new leave request
            $leave_request = LeaveRequest::create([
                'employee_id' => $employee->id,
                'leave_type_id' => $request->input('leave_type_id'),
                'department_id' => $employee->department_id,
                'from_date' => $request->input('from_date'), 
                'to_date' => $request->input('to_date'), 
                'applied_on' => $request->input('applied_on') ?? date('Y-m-d H:i:s'), 
                'reason' => $request->input('reason'), 
                'remarks' => $request->input('remarks'), 
                'status' => $request->input('status') ?? 1, 
                'is_half_day' => $request->input('is_half_day'), 
                'is_notify' => 0, 
                'leave_attachment' => $leave_attachment ?? NULL, 
                'created_by' => auth('api')->id(), 
                'updated_by' => auth('api')->id(), 
            ]);
            //if creation successful, 
            if ($leave_request){
                //Create log activity
                $this->log_user_activity('leave_request_new', $leave_request->id, true);
                $days = $this->hrms_leave_request_number_of_days($leave_request);
                
                //send mail to line manager 
                $supervisor = Employee::where('id', '=', $employee->supervisor_id)->with(['user'])->first();
                $line_manager = $supervisor->user;
                //try to send notification to line manager not a breaking issue
                $mailed = null;
                if (!(is_null($line_manager->email))){$mailed = Mail::to($line_manager->email)->send(new RequestMail($leave_request, $employee, $line_manager, $days));}
                $leave_request->is_notify = $mailed ? 1: 0; 
                $leave_request->save();

                //Update Employee Leave Type 
                $employee_leave_type = EmployeeLeaveType::where('employee_id', '=', $leave_request->employee_id)->where('leave_type_id', '=', $leave_request->leave_type_id)->first();
                $employee_leave_type->pending_days += $days;
                $employee_leave_type->save();

                $complete = true;
            }
            else{
                //create a log activity
                $complete = false;
            }
        }
        catch(Exception $e){
            $this->log_user_activity('leave_request_new', null, false);
            $complete = false;
        }
        if ($complete){
            DB::commit();
            return $leave_request;
        }
        else{
            DB::rollBack();
        }        
    }
    public function hrms_leave_request_delete_leave($id){
        DB::beginTransaction();

        try{
            $leave_request = LeaveRequest::where('id', '=', $id)->where('status', '=', 1)->first();
            if ($leave_request){
                $leave_request->status = 2;
                $leave_request->deleted_by = auth('api')->id();
                $leave_request->deleted_at = date('Y-m-d H:i:s');
                $leave_request->save();

                $days = $this->hrms_leave_request_number_of_days($leave_request);
                $employee_leave_type = EmployeeLeaveType::where('employee_id', '=', $leave_request->employee_id)->where('leave_type_id', '=', $leave_request->leave_type_id)->first();
                $employee_leave_type->pending_days += $days;
                $employee_leave_type->save();
            
                $this->log_user_activity('leave_request_delete', $id, true);
                $complete = true;
            }
            else{
                $this->log_user_activity('leave_request_delete', $id, false);
                $complete = false;    
            }
        }
        catch (Exception $e){
            $this->log_user_activity('leave_request_delete', $id, false);
            $complete = false;
        }
        if ($complete){
            DB::commit();
            return $leave_request;
        }
        else{
            DB::rollBack();
        }     
    }
    public function hrms_leave_request_get_all_leaves($status, $paginated, $detailed){
        switch ($status){
            case 'active':
                $query = LeaveRequest::whereDate('start_date', '>=', date('Y-m-d'))->whereDate('end_date', '<=', date('Y-m-d'))->where('status', '=', 3);
                break;
            case 'cancelled':
                $query = LeaveRequest::where('status', '=', 2);
                break;
            case 'completed':
                $query = LeaveRequest::whereDate('end_date', '>', date('Y-m-d'))->where('status', '=', 3);
                break;
            case 'my_leaves':
                $employee = Employee::where('user_id', '=', auth('api')->id())->first();
                $query = EmployeeLeaveType::where('employee_id', '=', $employee->id)->orderBy('start_date', 'DESC');
                break; 
            case 'my_team':
                $employee = Employee::select('id')->where('user_id', '=', auth('api')->id())->first();
                $team_members = Employee::where('supervisor_id', '=', $employee->id)->pluck('id');
                $query = LeaveRequest::whereIn('employee_id', $team_members)->whereDate('end_date', '>', date('Y-m-d'))->where('status', '=', 1);
                break;
            case 'pending':
                $query = LeaveRequest::whereDate('start_date', '<=', date('Y-m-d'))->where('status', '=', 1);
                break;
            case 'rejected':
                $query = LeaveRequest::where('status', '=', 4);
                break;
            default:
                $query = null;
        }
        
        if(is_null($query)){
            return [];
        }
        else{
            $quest = $detailed ? $query->with(['employee.user', 'leave_type', 'approver']) : $query;
            $leaves = $paginated ? $quest->paginate(50) : $quest->get();
            
            return $leaves;
        }
    }

    public function hrms_leave_request_number_of_days($leave_request){
        $datetime1 = new DateTime($leave_request->start_date);
        $datetime2 = new DateTime($leave_request->end_date);
        $interval = $datetime1->diff($datetime2);
        $days = $leave_request->is_half_day ? (($interval->format('%a') + 1) / 2):($interval->format('%a') + 1);

        return $days;
    }

    public function hrms_leave_request_reject_leave($id){
        DB::beginTransaction();
        try{
            $leave_request = LeaveRequest::where('id', '=', $id)->where('status', '=', 1)->first();
            if ($leave_request){
                $leave_request->status = 2;
                $leave_request->save();

                $days = $this->hrms_leave_request_number_of_days($leave_request);
                $employee_leave_type = EmployeeLeaveType::where('employee_id', '=', $leave_request->employee_id)->where('leave_type_id', '=', $leave_request->leave_type_id)->first();
                $employee_leave_type->pending_days += $days;
                $employee_leave_type->save();
            
                $this->log_user_activity('leave_request_reject', $id, true);
                $complete = true;
            }
            else{
                $this->log_user_activity('leave_request_reject', $id, false);
                $complete = false;    
            }
        }
        catch(Exception $e){
            $this->log_user_activity('leave_request_reject', $id, false);
            $complete = false;
        }
        if ($complete){
            DB::commit();
            return $leave_request;
        }
        else{
            DB::rollBack();
        }    
    }

    public function hrms_leave_request_show_leave($id, $viewer){
        return $leave_request = LeaveRequest::where('id', '=', $id)->with(['approver', 'employee.user', 'leave_type'])->first();
    }

    public function hrms_leave_request_update_leave($request, $id){
        DB::beginTransaction();
        try{
            $old_request = $leave_request = LeaveRequest::where('id', '=', $id)->first();
            if ($leave_request){
                $leave_request->leave_type_id = $request->input('leave_type_id');
                $leave_request->from_date = $request->input('from_date'); 
                $leave_request->to_date = $request->input('to_date');
                $leave_request->applied_on = $request->input('applied_on'); 
                $leave_request->reason = $request->input('reason'); 
                $leave_request->remarks = $request->input('remarks'); 
                $leave_request->status = $request->input('status') ?? 1; 
                $leave_request->is_half_day = $request->input('is_half_day'); 
                $leave_request->is_notify = 0;
                $leave_request->leave_attachment = $leave_attachment ?? NULL; 
                $leave_request->updated_by = auth('api')->id();
                
                $leave_request->save();
                $employee = Employee::where('employee_id', '=', $leave_request->employee_id)->with('user')->first();
                $days = $this->hrms_leave_request_number_of_days($leave_request);
                $old_days = $this->hrms_leave_request_number_of_days($old_request);
                $employee_leave_type = EmployeeLeaveType::where('employee_id', '=', $leave_request->employee_id)->where('leave_type_id', '=', $leave_request->leave_type_id)->first();
                $employee_leave_type->pending_days += ($days - $old_days);
                $employee_leave_type->save();
            
                //send mail to line manager 
                $supervisor = Employee::where('id', '=', $employee->supervisor_id)->with(['user'])->first();
                $line_manager = $supervisor->user;
                //try to send notification to line manager not a breaking issue
                $mailed = null;
                if (!(is_null($line_manager->email))){$mailed = Mail::to($line_manager->email)->send(new RequestMail($leave_request, $employee, $line_manager, $days));}
                $leave_request->is_notify = $mailed ? 1: 0; 
                $leave_request->save();

                $this->log_user_activity('leave_request_update', $id, true);
                $complete = true;
            }
            else{
                $this->log_user_activity('leave_request_update', $id, false);
                $complete = false;    
            }
        }
        catch(Exception $e){
            $this->log_user_activity('leave_request_reject', $id, false);
            $complete = false;
        }
        if ($complete){
            DB::commit();
            return $leave_request;
        }
        else{
            DB::rollBack();
        }
    }

    public function hrms_leave_types_create_type($request){
        DB::beginTransaction();
        try{
            $leave_type = LeaveType::create([
                'name' => $request->input('name'),
                'no_of_days' => $request->input('no_of_days'),
                'status' => 1,
                'start_date' => $request->input('start_date') ?? date('Y-m-d'),
                'end_date' => $request->input('end_date'),
                'created_by' => auth('api')->id(),
                'updated_by' => auth('api')->id(),
            ]);
            if ($leave_type){$this->log_user_activity('leave_type_create', $leave_type->id, true); $complete = true;}
            else{
                $this->log_user_activity('leave_type_create', null, false);
                $complete = false;
            }
        }
        catch(Exception $e){
            $this->log_user_activity('leave_type_create', null, false);
            $complete = false;
        }
        if ($complete){
            DB::commit();
            return $leave_type;
        }
        else{
            DB::rollBack();
        }   

    }

    public function hrms_leave_types_update_type($request, $id){
        DB::beginTransaction();
        try{
            $leave_type = LeaveType::where('id', '=', $id)->first();
            $leave_type->name = $request->input('name');
            $leave_type->no_of_days = $request->input('no_of_days');
            $leave_type->status = $request->input('status');
            $leave_type->start_date = $request->input('start_date') ?? date('Y-m-d');
            $leave_type->end_date = $request->input('end_date');
            $leave_type->updated_by = auth('api')->id();
            
            $leave_type->save();

            if ($leave_type){$this->log_user_activity('leave_type_create', $leave_type->id, true); $complete = true;}
            else{
                $this->log_user_activity('leave_type_create', null, false);
                $complete = false;
            }
        }
        catch(Exception $e){
            $this->log_user_activity('leave_type_update', $id, false);
            $complete = false;
        }
        if ($complete){
            DB::commit();
            return $leave_type;
        }
        else{
            DB::rollBack();
        }  
    }

    public function hrms_leave_types_delete_by_id($id){
        DB::beginTransaction();

        try{
            $leave_type = LeaveType::where('id', '=', $id)->first();

            if($leave_type){ 
                $leave_type->deleted_by = auth('api')->id();
                $leave_type->deleted_at = date('Y-m-d H:i:s');
                $leave_type->save();

                $this->log_user_activity('leave_type_delete', $id, true);
            }
            else{
                $this->log_user_activity('leave_type_delete', $id, false);
                $complete = false;    
            }
        }
        catch(Exception $e){
            $this->log_user_activity('leave_type_delete', $id, false);
            $complete = false;
        }
        if ($complete){
            DB::commit();
            return $leave_type;
        }
        else{
            DB::rollBack();
        }  

    }

    public function hrms_leave_types_get_all($paginated, $detailed){
        $query = $detailed ? LeaveType::orderBy('name')->with('creator') : LeaveType::orderBy('name', 'ASC');
        $leave_types = $paginated ? $query->paginated(20): $query->get();
        return $leave_types;
    }

    public function hrms_leave_types_get_my_current_leave_types($employee_id, $paginated, $detailed){
        if(!is_null($employee_id)){
            $employee = Employee::where('user_id', '=', auth('api')->id())->first();

            $query = EmployeeLeaveType::where('employee_id', '=', $employee->id);
        }
        else{
            $query = EmployeeLeaveType::where('employee_id', '=', $employee_id);
        }
        $quest = $query->leftJoin('hrms_leave_types as hlt', function ($join) {
            $join->on('hlt.id', '=', 'hrms_employee_leave_types.leave_type_id');
            $join->on('hlt.days_used', '<', 'hrms_employee_leave_types.no_of_days');
        })
        ->orderBy('hlt.end_date', 'DESC');

        $employee_leave_types = $paginated ? $query->paginate(20) :$query->get();
        return $employee_leave_types;
    }
}