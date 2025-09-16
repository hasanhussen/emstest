<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pharmaceuticalClass extends Model
{
    use HasFactory;
    protected $fillable = [ 'name','image' ];
    public function drugs(){
        return $this->hasMany(pharmaceutical::class,'pharma_id');
    }
}
