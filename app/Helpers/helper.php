<?php

namespace App\Helpers;

use App\Models\QuestionOption;
use App\Models\Test;
use App\Models\TestAnswer;
use App\Models\TestResult;
use App\Models\User;
use Carbon\Carbon;
use DateInterval;
use Illuminate\Support\Facades\DB;

class helper
{
    /**
     * Get user count that un approved
     *
     * @return int
     */
    static function getUnApprovedUserCount(): int
    {
        return User::where('approved', 0)->count();
    }

    /**
     * Get student join course  count that un approved
     *
     * @return int
     */
    static function getJoinCourseCount(): int
    {
        return DB::table('course_students')->where('status', 0)->count();
    }
    
    /**
     * Get unseen finished test result count that un approved
     *
     * @return int
     */
    static function getUnseenFinishedTestResultCount(): int
    {
        return TestResult::where('finished', 1)->where('is_seen', 0)->count();
    }

    /**
     * Get student id with user id
     *
     * @return int
     */
    static function getStudentId(int $user_id): int
    {
        return User::find($user_id)->getStudents[0]->id;
    }


    /**
     * Get answered question option id with question id
     *
     * @return int
     */
    static function getAnsweredOption(int $question_id, int $test_result_id): int
    {
        $testAnswer = TestAnswer::where('question_id', $question_id)->where('test_result_id', $test_result_id)->first();
        return $testAnswer ? $testAnswer->option_id : 0;
    }

    /**
     * Get correct question option id with question id
     *
     * @return int
     */
    static function getCorrectOption(int $question_id): int
    {
        return QuestionOption::where('question_id', $question_id)->where('is_correct', 1)->first()->id;
    }

    
    /**
     * Check exist test answer with test result id
     *
     * @return bool
     */
    static function checkFinishedTest(int $test_result_id): bool
    {
        return TestResult::where('id', $test_result_id)->where('finished', 1)->first() ? true : false;
    }

    /**
     * check test is expired
     * @return bool
     */
    static function isTestExpired($end_time): bool
    {
        return Carbon::now()->format('Y-m-d H:i') >= $end_time;
    }

    /**
     * check timeout
     * @return string
     */
    static function getEndTime($time, $duration)
    {
        $start_time = $time->format('Y-m-d H:i');
        $time->add(new DateInterval('PT' . $duration . 'M'));
        $stamp = $time->format('Y-m-d H:i');
        return $stamp;
    }
    
    /**
     * count questions by test id
     * @param $test_id
     * @return int
     */
    static function getquestionsCount($test_id): int
    {
        $test = Test::find($test_id);
        return count($test->questions->toArray());
    }
}