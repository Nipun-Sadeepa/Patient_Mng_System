<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable =['patientId', 'prescriptionPath', 'drFee', 'prescriptionNotes', 'date'];

    public function patients(){
        return $this->belongsTo('App\Model\Patient');
    }
}
