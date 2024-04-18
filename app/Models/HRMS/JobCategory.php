<?php

namespace App\Models\HRMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'hrms_job_categories';
    protected $fillable = array('id', 'name', 'url', 'created_at', 'updated_at', 'deleted_at');
    
    public function jobs(){
        return $this->hasMany('App\Models\Hrms\Job', 'category_id', 'id');
    }

    public function company(){
        return $this->belongsTo('App\Models\Inventory\ItemType', 'item_type_id', 'id');
    }
}
