<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vitalsign extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','image','min','max' ];
        public function patients()
        {
            return $this->belongsToMany(Patient::class, 'vital_patients', 'vital_id', 'patient_id');
        }
}
