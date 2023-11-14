<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'inventory_stores';
    protected $fillable = array('name', 'branch_id', 'department_id', 'status', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at');
    
    public function branch(){
        return $this->belongsTo('App\Models\Branch', 'branch_id', 'id');
    }

    public function department(){
        return $this->belongsTo('App\Models\Department', 'department_id', 'id');
    }
}
