<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vitalsign;
use Illuminate\Http\Request;

class vitalSignsController extends Controller
{

    public function index()
    {

        $sign = Vitalsign::get();
        return $sign;
    }
   
}
