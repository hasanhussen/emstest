<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Xray extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id','user_id','imageType','part','injection','state','time','date' ];
        public function user()
        {
            return $this->belongsTo(User::class, 'user_id');
        }
        public function patient()
        {
            return $this->belongsTo(Patient::class, 'patient_id');
        }
        public function image()
        {
            return $this->hasMany(XrayImage::class, 'image_id');
        }
}
