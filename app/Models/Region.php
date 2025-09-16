<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    
    protected $fillable = ['name','city_id'];
   
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    
    public function patients()
    {
        return $this->hasMany(Patient::class, 'region_id');
    }
}
