<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    use SoftDeletes;


    //offer_status   0: procccessing  1:ecxepted  2:reject 
    protected $table="offers";
    protected $fillable = ["user_id","order_id","dilever_coust","offer_status"];
    

    public function delegate_offer(){
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function order_offer(){
        return $this->belongsTo('App\Models\Order','order_id');
    }
}
