<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAssessmentQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_assessment_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('employee_assessment_id');
            $table->unsignedInteger('policy_question_id');
            $table->unsignedInteger('assessment_scale_id');
            $table->enum('status', ['pass', 'fail'])->nullable();
            $table->decimal('time_allocated', 8,2)->default(40);
            $table->decimal('time_taken', 8,2)->default(40);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_assessment_questions');
    }
}
