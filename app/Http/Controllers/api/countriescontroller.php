<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class countriescontroller extends Controller
{
    public function index()
    {

        $countries = Country::get();
        return $countries;
    }
}
