<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    // order_status :   0:processing;  1:done    2:deliverd   3:reject
    protected $table="orders";
    protected $fillable = ["user1_id",
                           "user2_id" ,
                           "company_id",
                           "order_date",
                           "payment_type",
                           "distance",
                           "dilever_coust",
                           "order_bill",
                           "tax_value",
                           "earn_value",
                           "total_bill",
                           "delivery_location",
                           "receiving_location",
                           
                           "order_status",
                           "company_order_status",
                           "client_order_status",
                           "notes",
                    ];
    

    public function user1(){
        return $this->belongsTo('App\Models\User','user1_id');
    }
    // public function user2(){
    //     return $this->belongsTo('App\Models\User','user2_id');
    // }

    public function company(){
        return $this->belongsTo('App\Models\Company','company_id');
    }

    public function order_details(){
         
        return $this->hasMany("App\Models\OrderDetails","order_id");

     }

     public function conversation(){
         
        return $this->hasMany("App\Models\Conversation","order_id");

     }

}
