<?php

namespace App\Http\Controllers;

use App\Models\EmployeeAssessment;
use App\Models\Policy;
use Illuminate\Support\Facades\Auth;

class PolicyController extends Controller
{
    public function index()
    {
        $ids = [];

        $hasAssessments = EmployeeAssessment::where("user_id", Auth::user()->id)->count() > 0;

        if ($hasAssessments){
            $lastAssess = EmployeeAssessment::where("user_id", Auth::user()->id)
                ->with(['questions' => function ($query) {
                    $query->whereStatus('fail');
                },])
                ->get()
                ->pluck('questions')
                ->last()
                ->toArray();

            $ids = array_column($lastAssess, 'policy_question_id');
        }


        $assessments = Policy::with([
            'documents',
            'questions' => function ($query) use ($ids, $hasAssessments) {
                if ($hasAssessments){
                    $query->whereIn('id', $ids)->with('options')->inRandomOrder();
                }else{
                    $query->with('options')->inRandomOrder();
                }
            },

        ])->inRandomOrder()->get();

        return response()->json($assessments);
    }
}
