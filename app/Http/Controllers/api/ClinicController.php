<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function index()
    {

        $clinic = Clinic::get();
        return $clinic;
    }
}
