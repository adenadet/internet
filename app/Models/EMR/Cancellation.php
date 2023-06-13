<?php

namespace App\Models\EMR;

use App\Models\Structure;

class Cancellation extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'emr_cancellations';
    protected $fillable = array('appointment_id', 'payment_id', 'status', 'payout_at', 'payout_by', 'bank_id', 'account_name', 'account_number', 'created_at', 'updated_at', 'deleted_by', 'deleted_at');


    public function bank(){
        return $this->belongsTo('App\Models\Bank', 'id', 'bank_id');
    }
}
