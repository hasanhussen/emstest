<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductComponent extends Model
{
    use HasFactory;
    use SoftDeletes;
  
    protected $table="product_components";
    protected $fillable = ["product_id", "name","order_id"];
   
                  
     


}
