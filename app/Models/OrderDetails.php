<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    use SoftDeletes;
  
    protected $table="order_details";
    protected $fillable = ["order_id", "product_id", "price","quantity","total_coust"];
   
                  

    public function product(){
        return $this->belongsTo('App\Models\CompanyProducts','product_id');
    }

}
