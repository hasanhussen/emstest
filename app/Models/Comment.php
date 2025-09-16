<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;


    //user1_id is the client   
    //user2_id is the delegate  
    protected $table="comments";
    protected $fillable = ["user1_id","user2_id" ,"comment"];
    

    public function user1(){
        return $this->belongsTo('App\Models\User','user1_id');
    }
    public function user2(){
        return $this->belongsTo('App\Models\User','user2_id');
    }
}
