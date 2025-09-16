<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\CompanyType;
use App\Models\Company;
use App\Models\Cataloge;
use App\Models\cityRegion;
use App\Models\Slider;
use App\Models\City;
use App\Models\Country;
class home_control extends Controller
{
    
    
    public function category(){
        
            $data = CompanyType::get();
            return $data;
        
    }
    
    
    
        
    public function getslider(){
        
            $data = Slider::get();
            return $data;
        
    }
    
    
    
    
        public function catalog(){
        
            $data = Cataloge::get();
            return $data;
        
    }
        
    public function getstore(Request $request){
        
            $data = Company::with('company_owner')->where('company_type',$request->id)->get();
            
            
                       
            return $data;
        
    }
        public function Country(){
        
                $countries = Country::get();
            return $countries;
        
    }
    
        public function city(){
        
               
        $cities = City::get();
            return $cities;
        
    }
    

    
    
}
