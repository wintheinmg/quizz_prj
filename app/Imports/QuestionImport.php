<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithLimit;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionImport implements WithHeadingRow, ToCollection, WithLimit
{
    public $test_id;
    public function  __construct($test_id)
    {
        $this->test_id= $test_id;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        // 
        if ($this->test_id != 0) {
            $question_list = [];
            foreach ($collection as $key => $value) {
                if(isset($value['question'])){
                    if ($value['question'] != '' && $value['question'] != null) {
                        $question = Question::create([
                            'question_text' => $value['question'],
                            'point'         => $value['point'] ?? 1,
                            'test_id'       => $this->test_id,
                        ]);
                        foreach ($value as $index => $val) {
                            if ($index != 'question' && $index != 'point' && $index != 'correct_answer') {
                                $is_correct = $val == $value['correct_answer'] ? 1 : 0;
                                if ($val != '' && $val != null) {
                                    QuestionOption::create([
                                        'option_text'   => $val,
                                        'is_correct'     => $is_correct,
                                        'question_id'    => $question->id,
                                    ]);
                                }
                            }
                        }
                        array_push($question_list, $question);
                    }
                }
            }
            return $question_list;
        }
    }

    public function limit(): int
    {
        return 50; // only take 50 rows
    }
}
