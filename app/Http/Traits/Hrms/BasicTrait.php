<?php 

namespace App\Http\Traits\Hrms;

use App\Http\Traits\LogTrait;

use DB;
use App\Models\HRMS\AttendanceSummary;
use App\Models\HRMS\Branch;
use App\Models\HRMS\Employee;
use App\Models\HRMS\EmployeeLeaveType;
use App\Models\HRMS\Leave;
use App\Models\HRMS\LeaveType;
use App\Models\HRMS\OrganizationHierarchy;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Mail;
use App\Mail\AdminApplyLeaveMail;
use App\Mail\ApplyLeaveMail;
use App\Mail\LeaveStatusMail;
use Session;

trait BasicTrait{
    //Departments

    public function hrms_basic_confirm_basic_request($request, $id){}

    public function hrms_basic_create_basic_request($request){}

    public function hrms_basic_get_all_my_basic_requests($user_id){}

    public function hrms_basic_get_all_pending_basic_requests(){}
    
    public function hrms_basic_get_my_team_members_basic_requests($team_members){}

    public function hrms_basic_reject_basic_request($request, $id){}

    public function hrms_basic_types_create($request){}

    public function hrms_basic_types_update($request, $id){}

    public function hrms_basic_types_delete_by_id($request){}

    public function hrms_basic_types_get_all(){}

    public function hrms_basic_types_get_my_current_basic_types($user_id){}

}