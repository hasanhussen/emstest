<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class servicecontroller extends Controller
{
    
    public function index()
    {

        $services = Service::get();
        return $services;
    }
}
