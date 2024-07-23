<?php

namespace App\Models\HRMS;

use App\Models\Structure;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'hrms_employee_leave_types';
    protected $fillable = array('name', 'no_of_days', 'status', 'start_date', 'end_date', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at');

    public function employee(){
        return $this->belongsTo('App\Models\HRMS\Employee', 'employee_id', 'id');
    }

    public function leave_type(){
        return $this->belongsTo('App\Models\HRMS\LeaveType', 'leave_type_id', 'id');
    }
}
