<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'inventory_items';
    protected $fillable = array('name', 'item_type_id', 'category_id', 'quantity', 'minimum_level', 'current_cost_price', 'status', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at');
    
    public function category(){
        return $this->belongsTo('App\Models\Inventory\Category', 'category_id', 'id');
    }

    public function item_type(){
        return $this->belongsTo('App\Models\Inventory\ItemType', 'item_type_id', 'id');
    }
}
