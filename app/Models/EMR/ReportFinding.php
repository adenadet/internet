<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportFinding extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'emr_appointment_report_findings';
    protected $fillable = array('report_id', 'finding_id');

}
