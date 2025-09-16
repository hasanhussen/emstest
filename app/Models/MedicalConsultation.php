<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalConsultation extends Model
{
    use HasFactory;
    protected $fillable = [ 'doctor_id','patient_id','clinic_id','doctor_id2','consultation','severity'];
    public function clinic(){
        return $this->belongsTo(Clinic::class,'clinic_id');
    }
    public function doctor(){
        return $this->belongsTo(User::class,'doctor_id');
    }
    public function doctor2(){
        return $this->belongsTo(User::class,'doctor_id2');
    }
    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id');
    }
}
