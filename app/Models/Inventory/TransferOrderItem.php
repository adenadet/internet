<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferOrderItem extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'inventory_transfer_order_items';
    protected $fillable = array('transfer_order_id', 'item_id', 'requested_quantity', 'approved_quantity', 'transfer_quantity', 'created_at', 'updated_at', 'deleted_at');

    public function item(){
    	return $this->belongsTo('App\Models\Inventory\Item', 'item_id', 'id');
    }

    public function transfer_order(){
    	return $this->hasMany('App\Models\Inventory\TransferOrder', 'transfer_order_id', 'id');
    }
}