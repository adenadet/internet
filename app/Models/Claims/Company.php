<?php

namespace App\Models\Claims;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'claims_companies';
    protected $fillable = array('name', 'created_at', 'updated_at', 'deleted_at');

    public function hmos(){
        return $this->hasMany('App\Models\Claims\CompanyHMO', 'company_id', 'id');
    }

}
