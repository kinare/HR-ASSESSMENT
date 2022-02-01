<?php

namespace App\Http\Controllers;

use App\Models\AssessmentScale;
use App\Models\EmployeeAssessment;
use App\Models\EmployeeAssessmentQuestion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeAssessmentController extends Controller
{

    public function index(Request $request)
    {
        $exams = EmployeeAssessment::where('user_id', $request->user()->id)->with([
            'questions' => function($query){
                $query->with('scale', 'policyQuestion');
            }
        ])->get();

        return response()->json($exams);
    }

    public function store(Request $request)
    {
       $assessment = new EmployeeAssessment();
       $assessment->user_id = $request->user()->id;
       $assessment->assessment_date = Carbon::now();
       $assessment->save();

       $questions = $request->all();
       $scale = AssessmentScale::all();

       foreach ($questions as $question){
           $question = (object)$question;
           $quiz = new EmployeeAssessmentQuestion();
           $quiz->employee_assessment_id = $assessment->id;
           $quiz->policy_question_id = $question->policy_question_id;
           $quiz->status = $question->status;
           $quiz->time_allocated = $question->time_allocated;
           $quiz->time_taken = $question->time_taken;

           foreach ($scale as $item) {
               if ($quiz->time_taken > $item->max)
                   $quiz->assessment_scale_id = $item->id;

               if ( $quiz->time_taken >= $item->min && $quiz->time_taken <= $item->max){
                   $quiz->assessment_scale_id = $item->id;
               }
           }

           $quiz->save();
       }
    }
}
