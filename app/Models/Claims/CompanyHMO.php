<?php

namespace App\Models\Claims;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyHMO extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'claims_company_hmos';
    protected $fillable = array('company_id', 'name', 'code', 'created_by', 'updated_at', 'deleted_at');

    public function company(){
        return $this->belongsTo('App\Models\Claims\Company', 'company_id', 'id');
    }
}
