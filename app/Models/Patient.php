<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
        'motherName',
        'fatherName',
        'gFatherName',
        'lastName',
        'birthday',
        'gender',
        'phone',
        'address',
        'city_id',
        'region_id',
        'patientCondition',
        'visit',
    ];
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function forwards()
    {
        return $this->belongsToMany(Forward::class, 'patient_forward', 'patient_id', 'forward_id');
    }
    public function vitals()
    {
        return $this->belongsToMany(VitalPatient::class, 'vital_patients', 'patient_id', 'vital_id');
    }
    public function vital()
    {
        return $this->belongsTo(Vital::class, 'patient_id');
    }
    public function xray(){
        return $this->hasMany(Xray::class);
  
  
    }
    public function Testrequest(){
        return $this->hasMany(TestRequest::class);
  
  
    }
    public function patientMedication(){
        return $this->hasMany(PatientMedications::class,'patient_id');
    }
    public function patientfollow_ups(){
        return $this->hasMany(FollowUp::class,'patient_id');
    }
    public function patientconsultations(){
        return $this->hasMany(MedicalConsultation::class,'patient_id');
    }
    public function service(){
        return $this->hasMany(PatientService::class,'patient_id');
    }
    public function medhistory(){
        return $this->hasMany(MedicalHistory::class,'patient_id');
    }
    public function tranfer(){
        return $this->hasMany(Transfer::class,'patient_id');
    }
    public function entry(){
        return $this->hasMany(Entry::class,'patient_id');
    }
}

