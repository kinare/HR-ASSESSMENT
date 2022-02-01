<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAssessmentQuestion extends Model
{
    use HasFactory;

    public function scale()
    {
        return $this->belongsTo(AssessmentScale::class, 'assessment_scale_id', 'id');
    }

    public function policyQuestion()
    {
        return $this->belongsTo(PolicyQuestion::class);
    }
}
