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

trait SalaryTrait{
    public function hrms_salary_confirm_salary_request($request, $id){}

    public function hrms_salary_create_salary_request($request){}

    public function hrms_salary_get_all_my_salary_requests($user_id){}

    public function hrms_salary_get_all_pending_salary_requests(){}
    
    public function hrms_salary_get_my_team_members_salary_requests($team_members){}

    public function hrms_salary_reject_salary_request($request, $id){}

    public function hrms_salary_types_create($request){}

    public function hrms_salary_types_update($request, $id){}

    public function hrms_salary_types_delete_by_id($request){}

    public function hrms_salary_types_get_all(){}

    public function hrms_salary_types_get_my_current_salary_types($user_id){}

}