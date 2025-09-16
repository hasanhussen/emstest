<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMedications extends Model
{
    use HasFactory;
    protected $fillable = [ 'doctor_id','patient_id','med_id','note','dose',
    'dosage_amount1','dosage_amount2','date','state','details'];
    public function medication(){
        return $this->belongsTo(pharmaceutical::class,'med_id');
    }
    public function doctor(){
        return $this->belongsTo(User::class,'doctor_id');
    }
    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id');
    }
}
