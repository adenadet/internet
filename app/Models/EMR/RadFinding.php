<?php

namespace App\Models\EMR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadFinding extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'emr_radiology_findings';
    protected $fillable = array('name', 'code', 'description');

}
