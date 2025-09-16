<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $fillable = ['trequest_id', 'subclass_id','value'];
    public function subclass(){
        return $this->belongsTo(Subclassification::class,'subclass_id');
    }
    public function testrequest(){
        return $this->belongsTo(TestRequest::class,'trequest_id');

    }

}
