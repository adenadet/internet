<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Structure;

class Wallet extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_wallets';
    protected $fillable = array('id', 'user_id', 'balance', 'updated_by', 'deleted_by', 'deleted_at');

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

}