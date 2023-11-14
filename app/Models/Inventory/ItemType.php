<?php

namespace App\Models\Inventory;

use App\Models\Structure;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemType extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'inventory_item_types';
    protected $fillable = array('name', 'description', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at');
    
    public function categories(){
        return $this->hasMany('App\Models\Inventory\Category', 'type_id', 'id');
    }

}
