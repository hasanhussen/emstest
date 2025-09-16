<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class privacycontroller extends Controller
{
    public function index(){
        $privacy=PrivacyPolicy::first();
        return $privacy;
    }
}
