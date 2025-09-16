<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class aboutUscontroller extends Controller
{
    public function index()
    {

        $about = About::first();
        return $about;
    }
}
