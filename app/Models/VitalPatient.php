<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VitalPatient extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id','user_id','vital_id','time','date','value' ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function vitalsign()
    {
        return $this->belongsTo(Vitalsign::class, 'vital_id');
    }
  
   
}
