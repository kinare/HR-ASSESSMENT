<?php

namespace Database\Seeders;

use App\Models\AssessmentScale;
use App\Models\EmployeeAssessment;
use App\Models\EmployeeAssessmentQuestion;
use App\Models\Policy;
use App\Models\PolicyDocument;
use App\Models\PolicyOption;
use App\Models\PolicyQuestion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HrPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $policies = [
            [
                'topic' => 'Leave Policy',
                'document' => [
                    'description' => 'You are entitled to 21 Annual Leave days, 60 Day maternity leave, 20 days paternity leave and 12 sick leave days '
                ],
                'questions' => [
                    'How many leave days per year?' => [
                        ['18', false], ['12', false], ['21', true]
                    ],
                    'How many sick leave days' => [
                        ['3', false], ['12', true], ['10', false]
                    ],
                    'How many paternity leave days' => [
                        ['30', false], ['20', true], ['50', false]
                    ]
                ],
            ],
            [
                'topic' => 'Termination Policy',
                'document' => [
                    'description' => 'One month written notice shall be presented by staff, Hand over firm properties and assignments, termination any time by firm'
                ],
                'questions' => [
                    'Whats is notice period of resigning' => [
                        ['One Day', false], ['One month', true], ['21 Days', false]
                    ],
                    'Can Firm Terminate Contract without anytime' => [
                        ['Yes', true], ['No', false]
                    ],
                    'Is handover required' => [
                        ['No', false], ['Yes', true]
                    ]
                ],
            ],
            [
                'topic' => 'Performance review policy',
                'document' => [
                    'description' => 'Performance review is conducted annually, in the first week of the year, mode of review is peer to peer'
                ],
                'questions' => [
                    'How many performance reviews in a year?' => [
                        ['1', true], ['12', false], ['2', false]
                    ],
                    'When is Performace appraisal conducted' => [
                        ['Every month', false], ['First week of Year', true], ['End of the year', false]
                    ],
                    'Which review mode is used' => [
                        ['Peer to peer', true], ['Top down approach', false], ['360 method', false]
                    ]
                ],
            ],
        ];
        $assessmentScale = [
            [ 'min' => 0, 'max' => 10, 'description' => 'Employee not concentrating they answered too fast'],
            [ 'min' => 15, 'max' => 20, 'description' => 'Employee answered using appropriate time'],
            [ 'min' => 30, 'max' => 40, 'description' => ' Employee cutting it close and unsure'],
        ];
        $employees = [
          [ 'name' => 'Employee one', 'email' => 'test1@mail.com', ],
          [ 'name' => 'Employee two', 'email' => 'test2@mail.com', 'password' => Hash::make('password')],
          [ 'name' => 'Employee three', 'email' => 'test3@mail.com', 'password' => Hash::make('password')],
        ];

        Policy::truncate();
        PolicyOption::truncate();
        PolicyQuestion::truncate();
        PolicyDocument::truncate();
        User::truncate();
        EmployeeAssessment::truncate();
        EmployeeAssessmentQuestion::truncate();
        AssessmentScale::truncate();

        foreach ($policies as $policy){
            $p = new Policy();
            $p->topic = $policy['topic'];
            $p->save();

            foreach ($policy['document'] as $item){
                $pd = new PolicyDocument();
                $pd->description = $item;
                $pd->policy_id = $p->id;
                $pd->save();
            }

            foreach ($policy['questions'] as $question => $options){
                $pq = new PolicyQuestion();
                $pq->question = $question;
                $pq->policy_id = $p->id;
                $pq->save();

                $randomAnswer = array_rand($options, 1);
                foreach ($options as $option){
                    dump($option);
                    $o = new PolicyOption();
                    $o->policy_question_id = $pq->id;
                    $o->option = $option[0];
                    $o->correct = $option[1];
                    $o->save();
                }
            }
        }

        foreach ($assessmentScale as $item){
            $scale = new AssessmentScale();
            $scale->fill($item);
            $scale->save();
        }

        foreach ($employees as $item){
            $user = new User();
            $user->fill($item);
            $user->password =Hash::make('password');
            $user->save();
        }
    }
}
