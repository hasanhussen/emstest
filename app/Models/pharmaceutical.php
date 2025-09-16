<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pharmaceutical extends Model
{
    use HasFactory;
    protected $fillable = ['name','pharma_id','scientificName','description' ];
    public function class(){
        return $this->belongsTo(pharmaceuticalClass::class,'pharma_id');
    }
    public function patientMedication(){
        return $this->hasMany(PatientMedications::class,'med_id');
    }
}
