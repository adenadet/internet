<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class Consultation extends Structure
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'emr_consultations';
    protected $fillable = array('appointment_id', 'all_previous_tb', 'all_household_tb', 'all_recent_contact', 'kid_respiratory', 'kid_throaic_surgery', 'kid_cyanosis', 'kid_respiratory_insufficiency', 'women_pregnant', 'sym_cough', 'sym_fever', 'sym_haemoptysis', 'sym_night_sweats', 'sym_weight_loss', 'decision', 'remarks', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at');


}
