<?php

namespace App\Models\HRMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'hrms_jobs';
    protected $fillable = array('employer_id', 'category_id', 'company_id', 'job_title', 'designation_id', 'job_url', 'job_type', 'category_url', 'is_featured', 'type_url', 'job_vacancy', 'gender', 'minimum_experience', 'date_of_closing', 'short_description', 'long_description', 'status', 'created_at', 'updated_at', 'deleted_at');
    
    public function category(){
        return $this->belongsTo('App\Models\Inventory\Category', 'category_id', 'id');
    }

    public function company(){
        return $this->belongsTo('App\Models\Inventory\ItemType', 'item_type_id', 'id');
    }
}
