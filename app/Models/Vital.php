<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vital extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id','user_id','time','date','pressure','temperature','pulse','RespiratoryRate','Oxygenation' ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function patients()
    {
        return $this->hasMany(Patient::class, 'patient_id');
    }

}
