<?php

namespace App\Http\Controllers\api;

use App\Models\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {

        $cities = City::with('region')->get();
        return $cities;
    }
}
