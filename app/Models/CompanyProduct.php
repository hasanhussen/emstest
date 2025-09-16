<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CompanyProduct extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table="company_products";
    protected $fillable = ["company_id", "name", "price","calories","image"];
   


    public function comp_product()
    {
        return $this->belongsTo('App\Models\Company', 'company_id');
    }       
    
    public function comp(){
        return $this->hasMany('App\Models\ProductComponent','product_id');
    }

}
