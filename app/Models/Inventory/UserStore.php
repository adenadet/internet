<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStore extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'inventory_user_stores';
    protected $fillable = array('user_id', 'store_id', 'created_at', 'updated_at', 'deleted_at');

    public function store(){
    	return $this->belongsTo('App\Models\Inventory\Store', 'store_id', 'id');
    }

    public function user(){
    	return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
