<?php 

namespace App\Http\Traits\Finance;

use App\Http\Traits\LogTrait;
use App\Http\Traits\FileManagementTrait;

use DB;
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

use Illuminate\Support\Facades\Mail;
use Session;

trait LeaveTrait{
    use FileManagementTrait, LogTrait;
    public function hrms_leave_confirm_leave_request($request, $id){}

    public function hrms_leave_create_leave_request($request, $employee){
        $leave_attachment = !(is_null($request->input('leave_attachment'))) ?$this->file_upload(null, 'uploads/leave_requests', $employee->user_id): null;
        $leave_request = LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_type_id' => $request->input('leave_type_id'),
            'department_id' => $employee->department_id,
            //'company_id' =, 
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
        if ($leave_request){
            $this->log_user_activity('leave_request_new', $leave_request->id, true);
            $supervisor = Employee::where('id', '=', $employee->supervisor_id)->with(['user'])->first();
            $line_manager = $supervisor->user;
            //try to send notification to line manager
            $mailed = null;
            if (!(is_null($line_manager->email))){$mailed = Mail::to($line_manager->email)->send(new RequestMail($leave_request, $employee, $line_manager));}
            $leave_request->is_notify = $mailed ? 1: 0; 
            $leave_request->save();
        }
        else{
            $this->log_user_activity('leave_request_new', null, false);
        }

        return $leave_request;
    }

    public function hrms_leave_get_all_my_leave_requests($user_id, $paginated, ){}

    public function hrms_leave_get_all_pending_leave_requests(){}
    
    public function hrms_leave_get_my_team_members_leave_requests($team_members){}

    public function hrms_leave_reject_leave_request($request, $id){}

    public function hrms_leave_types_create($request){}

    public function hrms_leave_types_update($request, $id){}

    public function hrms_leave_types_delete_by_id($request){}

    public function hrms_leave_types_get_all(){}

    public function hrms_leave_types_get_my_current_leave_types($user_id){}

}