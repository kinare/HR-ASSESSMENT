<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAssessment extends Model
{
    use HasFactory;

    public function questions()
    {
        return $this->hasMany(EmployeeAssessmentQuestion::class);
    }

    protected $appends = ['policy_documents'];

    public function getPolicyDocumentsAttribute()
    {
        $failed_questions = $this->questions()->whereStatus('fail')->with('policyQuestion')->get();
        $policy_ids = [];
        foreach ($failed_questions as $question){
            $policy_ids[] = $question->policyQuestion->policy_id;
        }

        return PolicyDocument::whereIn('policy_id', $policy_ids)->with('policy')->get();
    }

}
