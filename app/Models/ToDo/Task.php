<?php

namespace App\Models\ToDo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Task extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'todo_tasks';
    protected $fillable = array('title', 'description', 'is_done', 'owner_id', 'assigned_at', 'created_by', 'updated_by', 'deleted_by', 'deleted_at' ); 
}