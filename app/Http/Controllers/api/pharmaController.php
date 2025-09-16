<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\pharmaceuticalClass;
use Illuminate\Http\Request;

class pharmaController extends Controller
{
    public function getpharmaclass()
    {

        $pharma = pharmaceuticalClass::with('drugs')->get();
        return $pharma;
    }
}
