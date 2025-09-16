<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestRequest extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id', 'user_id','state','condition'];

    public function Patients(){
        return $this->belongsTo(Patient::class,'patient_id');
    }
    public function users(){
        return $this->belongsTo(User::class,'user_id');

    }
    public function test(){
        return $this->hasMany(Test::class);

    }
    public function note(){
        return $this->hasMany(Note::class);

    }

}
