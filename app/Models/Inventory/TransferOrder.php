<?php

namespace App\Models\Inventory;

use App\Models\Structure;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferOrder extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'inventory_transfer_orders';
    protected $fillable = array('name', 'description', 'unique_id', 'from_store_id', 'to_store_id', 'status', 'approved_by', 'approval_note', 'approved_at', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at');

    public function returned_items(){
    	return $this->hasMany('App\Models\Inventory\ReturnItem', 'category_id', 'id');
    }

    public function sales_order(){
    	return $this->hasMany('App\Models\Inventory\Product', 'category_id', 'id');
    }
}
