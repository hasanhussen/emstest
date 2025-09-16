<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Region;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function regions()
    {
        return $this->hasMany(Region::class, 'city_id');
    }
    
    public function patients()
    {
        return $this->hasMany(Patient::class, 'city_id');
    }
    
   
}
