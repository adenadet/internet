<?php

namespace App\Models\HRMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Structure;

class LeaveRequest extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'hrms_leave_requests';
    protected $fillable = array('id', 'company_id', 'employee_id', 'department_id', 'leave_type_id', 'from_date', 'to_date', 'applied_on', 'reason', 'remarks', 'status', 'is_half_day', 'is_notify', 'leave_attachment', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at');
    
    public function employee(){
        return $this->belongsTo('App\Models\Hrms\Employee', 'employee_id', 'id');
    }

    public function company(){
        return $this->belongsTo('App\Models\Inventory\ItemType', 'item_type_id', 'id');
    }
}
