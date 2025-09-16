<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MedicalConsultation;
use App\Models\Patient;
use Illuminate\Http\Request;

class MedicalConsultationsController extends Controller
{
    public function index($id)
    {
        $consultations = MedicalConsultation::where('patient_id',$id)->get();
        $patient = Patient::where('id',$id)->first();

        return view('consultation.index',compact('consultations','patient'));

    }
}
