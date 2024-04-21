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
//use App\Traits\MetaTrait;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Mail;
use App\Mail\AdminApplyLeaveMail;
use App\Mail\ApplyLeaveMail;
use App\Mail\LeaveStatusMail;
use Session;

trait EmployeeTrait{
    public function hrms_applicant_create($request){}

    public function hrms_applicant_upgrade_to_staff($user_id){}

    public function hrms_employee_confirm_employee_request($request, $id){}

    public function hrms_employee_create_employee_request($request){}

    public function hrms_employee_get_all_my_employee_requests($user_id){}

    public function hrms_employee_get_all_pending_employee_requests(){}
    
    public function hrms_employee_get_my_team_members_employee_requests($team_members){}

    public function hrms_employee_reject_employee_request($request, $id){}

    public function hrms_employee_types_create($request){}

    public function hrms_employee_types_update($request, $id){}

    public function hrms_employee_types_delete_by_id($request){}

    public function hrms_employee_types_get_all(){}

    public function hrms_employee_types_get_my_current_employee_types($user_id){}

    public function hrms_resignation_create($request){}
    
    public function hrms_resignation_confirm($request){}

    public function hrms_resignation_reject($request){}

}
