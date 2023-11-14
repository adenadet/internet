<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreItem extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'inventory_store_items';
    protected $fillable = array('store_id', 'item_id', 'batch_id', 'quantity', 'created_at', 'updated_at', 'deleted_at');
    
    public function item(){
        return $this->belongsTo('App\Models\Inventory\Item', 'item_id', 'id');
    }

    public function store(){
        return $this->belongsTo('App\Models\Inventory\Store', 'store_id', 'id');
    }
}
