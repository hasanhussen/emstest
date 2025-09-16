<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subclassification extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'class_id','value'];
    public function classification(){
        return $this->belongsTo(Classification::class,'class_id');
    }
    public function test(){
        return $this->hasMany(Test::class);

    }

}
