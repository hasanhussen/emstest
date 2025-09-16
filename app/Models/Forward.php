<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forward extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'from',
        'to',
        'date',
       
    ];
    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'patient_forward', 'forward_id', 'patient_id');
    }
}
