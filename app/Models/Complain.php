<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    use HasFactory;
    use SoftDeletes;


    //user1_id is the client   
    //user2_id is the delegate  
    protected $table="complains";
    protected $fillable = ["user1_id" ,"user2_id","complainType_id","complain_date","image","notes","type"];
    

    public function user1(){
        return $this->belongsTo('App\Models\User','user1_id');
    }
    public function user2(){
        return $this->belongsTo('App\Models\User','user2_id');
    }
    public function complain_type(){
        return $this->belongsTo('App\Models\ComplainType','complainType_id');
    }
}
