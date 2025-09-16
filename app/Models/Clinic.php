<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','image' ];
        public function patientfollow_ups(){
            return $this->hasMany(FollowUp::class,'clinic_id');
        }
        public function patientconsultations(){
            return $this->hasMany(MedicalConsultation::class,'clinic_id');
        }
        public function doctor(){
            return $this->hasMany(User::class,'clinic_id');
        }
}
