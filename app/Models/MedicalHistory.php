<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    use HasFactory;
    protected $fillable = [ 'user_id','patient_id','text','date','time'];
  
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id');
    }
}
