<?php

namespace App\Services;

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\TestAnswer;

class CheckTestResultService 
{
    /**
     * Get score with answer array
     *
     * @return int
     */
    public static function getScore($answerArray): int
    {
        $score = 0;
        if ($answerArray <> null ) {
            foreach ($answerArray as $key => $value) {
                $questionOption = $value['questionOption'] ?? false;
                $is_correct = $questionOption ? (new self)->checkAnswerCorrect($questionOption) : 0;
                if($is_correct == 1){
                    $score += (new self)->getPoints($value['question']);
                }
            }
        }
        return $score;
    }

    /**
     * Get answer array include correct or incorrect with answer array
     *
     * @return array
     */
    public static function insertTestAnswer($answerArray, $test_result_id): array
    {
        $resultArray = [];
        if ($answerArray <> null) {
            foreach ($answerArray as $key => $value) {
                $questionOption = $value['questionOption'] ?? false;
                if ($questionOption) {
                    $testAnswer = TestAnswer::create([
                        'is_correct'        => (new self)->checkAnswerCorrect($questionOption),
                        'test_result_id'    => $test_result_id,
                        'question_id'       => $value['question'],
                        'option_id'         => $value['questionOption'],
                    ]);
                    array_push($resultArray, $testAnswer);  
                }       
            }
        }
        return $resultArray;
    }

    private function checkAnswerCorrect($questionOption)
    {
        return QuestionOption::where('id', $questionOption)->first()->is_correct;
    }

    private function getPoints($question)
    {
        return (int)Question::where('id', $question)->first()->points;
    }
}
