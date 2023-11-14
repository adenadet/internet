<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'inventory_categories';
    protected $fillable = array( 'name', 'description', 'type_id', 'primary_category_id', 'created_at', 'updated_at', 'deleted_at');
    
    public function category(){
        return $this->belongsTo('App\Models\Inventory\Category', 'category_id', 'id');
    }

    public function item_types(){
        return $this->belongsTo('App\Models\Inventory\ItemType', 'item_type_id', 'id');
    }
}
