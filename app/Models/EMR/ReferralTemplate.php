<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralTemplate extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'emr_referral_templates';
    protected $fillable = array('name', 'content', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at');

    public function creator(){
    	return $this->belongsTo('App\Models\User', 'created_by', 'id');
	}

    public function deleter(){
        return $this->belongsTo('App\Models\User', 'deleted_by', 'id');
    }
}
