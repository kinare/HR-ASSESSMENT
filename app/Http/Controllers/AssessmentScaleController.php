<?php

namespace App\Http\Controllers;

use App\Models\AssessmentScale;
use Illuminate\Http\Request;

class AssessmentScaleController extends Controller
{
   public function index()
   {
       return response()->json(AssessmentScale::all());
   }
}
