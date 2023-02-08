<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Notice extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'notices';
    protected $fillable = array('topic', 'image', 'content', 'user_id', 'department_id', 'start_date', 'end_date', 'created_at', 'updated_at', 'deleted_by', 'deleted_at');

    public function creator(){
    	return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}