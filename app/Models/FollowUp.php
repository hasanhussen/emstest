<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    use HasFactory;
    protected $fillable = [ 'doctor_id','patient_id','clinic_id','note','follow_up','alert','time','date'];
    public function clinic(){
        return $this->belongsTo(Clinic::class,'clinic_id');
    }
    public function doctor(){
        return $this->belongsTo(User::class,'doctor_id');
    }
    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id');
    }
    public function file(){
        return $this->hasMany(FollowUpFile::class,'followup_id');
    }
}
