<?php 

namespace App\Http\Traits\Finance;

use App\Http\Traits\LogTrait;

use DB;
use App\Models\HRMS\AttendanceSummary;
use App\Models\HRMS\Branch;
use App\Models\HRMS\Employee;
use App\Models\HRMS\EmployeeLeaveType;
use App\Models\HRMS\Leave;
use App\Models\HRMS\LeaveType;
use App\Models\HRMS\OrganizationHierarchy;
//use App\Traits\MetaTrait;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Mail;
use App\Mail\AdminApplyLeaveMail;
use App\Mail\ApplyLeaveMail;
use App\Mail\LeaveStatusMail;
use Session;

trait LeaveTrait{
    public function hrms_leave_confirm_leave_request($request, $id){}

    public function hrms_leave_create_leave_request($request){}

    public function hrms_leave_get_all_my_leave_requests($user_id){}

    public function hrms_leave_get_all_pending_leave_requests(){}
    
    public function hrms_leave_get_my_team_members_leave_requests($team_members){}

    public function hrms_leave_reject_leave_request($request, $id){}

    public function hrms_leave_types_create($request){}

    public function hrms_leave_types_update($request, $id){}

    public function hrms_leave_types_delete_by_id($request){}

    public function hrms_leave_types_get_all(){}

    public function hrms_leave_types_get_my_current_leave_types($user_id){}

}