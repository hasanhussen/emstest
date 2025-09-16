<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;


    //user1_id is the client   
    //user2_id is the delegate  
    protected $table="companies";
    protected $fillable = ["arabic_name","english_name" ,"user_id","company_type","city_id","region_id",
    "commercial_registration_number","delivery","use_other_app","company_url","image","location"];
    

    public function company(){
        return $this->belongsTo('App\Models\CompanyType','company_type');
    }

    public function city(){
        return $this->belongsTo('App\Models\City','city_id');
    }
    public function region(){
        return $this->belongsTo('App\Models\cityRegion','region_id');
    }
    public function company_owner(){
        return $this->belongsTo('App\Models\User','user_id');
    }

    
}
