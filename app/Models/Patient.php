<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable=['name', 'bday', 'contactNo', 'nic', 'imagePath', 'notes'];

    public function prescriptions(){
        return $this->hasMany('App\Model\Prescription');   
    }
}
