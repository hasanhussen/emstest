<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
    use SoftDeletes;


    
    protected $table="conversations";
    protected $fillable = ["user_id" ,"order_id","message"];
    

    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
        
    }

}
