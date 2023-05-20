<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Test;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $users = [
            [
                'id'                 => 3,
                'name'               => 'Student Test One',
                'email'              => 'testone@student.com',
                'password'           => bcrypt('password'),
                'remember_token'     => null,
                'approved'           => 1,
                'verified'           => 1,
                'verified_at'        => '2022-12-12 04:44:16',
                'verification_token' => '',
            ],
        ];
        User::insert($users);
        User::findOrFail(3)->roles()->sync(3);

        $students = [
            [
                'id'                 => 1,
                'user_id'            => 3,
                'name'               => 'Student Test One',
                'date'               => Carbon::now(),
                'nrc'                => '12/SAMPLE(N)654321',
                'address'            => 'Yangon, Myanmar',
                'phone_no'           => '09977698934',
                'email'              => 'testone@student.com',
                'acca_student_no'    => '102598',
                'subject'            => 'LCCI',
                'exam_session_period' => '30 days',
                'old_student'        => 'yes',
                'how_knew_acca'      => 2
            ],
        ];
        Student::insert($students);

        $teachers = [
            [
                'id'                 => 1,
                'name'               => 'Daw Mya',
                'date_of_birth'      => '1982-10-1',
                'age'                => 40,
                'parent_name'        => 'U Ba',
                'nation_and_religion' => 'Burmese & Buddhist',
                'nrc'                => '12/SAMPLE(N)123456',
                'contact_no'         => '09987698934',
                'address'            => 'Yangon, Myanmar',
                'start_date_of_employment' => '2005-06-01',
            ],
        ];
        Teacher::insert($teachers);

        $courseCategories = [
            [
                'id'                 => 1,
                'name'               => 'LCCI',
            ],
            [
                'id'                 => 2,
                'name'               => 'ACCA',
            ],
        ];
        CourseCategory::insert($courseCategories);

        $courses = [
            [
                'id'                 => 1,
                'title'               => 'LCCI Level 1 & 2',
                'description'        => 'this is LCCI Level 1 & 2 class',
                'price'              => 500000,
                'course_category_id' => 1,
            ],
        ];
        Course::insert($courses);

        $tests = [
            [
                'id'                 => 1,
                'title'               => 'LCCI Level 1 & 2 Testing One',
                'description'        => 'this is LCCI Level 1 & 2 testing, you need to know accounting',
                'duration'           => 10,
                'pass_score'         => 4,
                'is_published'       => 1,
                'course_id'          => 1
            ],
        ];
        Test::insert($tests);

        $questions = [
            [
                'id'                 => 1,
                'question_text'      => 'This is question One',
                'points'             => 1,
                'test_id'            => 1
            ],
            [
                'id'                 => 2,
                'question_text'      => 'This is question two',
                'points'             => 1,
                'test_id'            => 1
            ],
            [
                'id'                 => 3,
                'question_text'      => 'This is question three',
                'points'             => 1,
                'test_id'            => 1
            ],
            [
                'id'                 => 4,
                'question_text'      => 'This is question four',
                'points'             => 1,
                'test_id'            => 1
            ],
            [
                'id'                 => 5,
                'question_text'      => 'This is question five',
                'points'             => 1,
                'test_id'            => 1
            ],
            [
                'id'                 => 6,
                'question_text'      => 'This is question six',
                'points'             => 1,
                'test_id'            => 1
            ],
        ];
        Question::insert($questions);

        $questionOptions = [
            [
                'id'                 => 1,
                'option_text'        => 'one',
                'is_correct'         => 0,
                'question_id'        => 1
            ],
            [
                'id'                 => 2,
                'option_text'        => 'two',
                'is_correct'         => 1,
                'question_id'        => 1
            ],
            [
                'id'                 => 3,
                'option_text'        => 'three',
                'is_correct'         => 0,
                'question_id'        => 1
            ],
            [
                'id'                 => 4,
                'option_text'        => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis facere earum rerum magni vitae repudiandae natus distinctio nesciunt suscipit nisi, eum cum ea eos enim consequatur magnam tenetur similique accusantium.',
                'is_correct'         => 0,
                'question_id'        => 2
            ],
            [
                'id'                 => 5,
                'option_text'        => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis facere earum rerum magni vitae repudiandae natus distinctio nesciunt suscipit nisi, eum cum ea eos enim consequatur magnam tenetur similique accusantium.',
                'is_correct'         => 1,
                'question_id'        => 2
            ],
            [
                'id'                 => 6,
                'option_text'        => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis facere earum rerum magni vitae repudiandae natus distinctio nesciunt suscipit nisi, eum cum ea eos enim consequatur magnam tenetur similique accusantium.',
                'is_correct'         => 0,
                'question_id'        => 2
            ],
            [
                'id'                 => 7,
                'option_text'        => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis facere earum rerum magni vitae.',
                'is_correct'         => 0,
                'question_id'        => 3
            ],
            [
                'id'                 => 8,
                'option_text'        => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis facere earum rerum magni vitae repudiandae.',
                'is_correct'         => 1,
                'question_id'        => 3
            ],
            [
                'id'                 => 9,
                'option_text'        => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis facere earum rerum magni vitae repudiandae natus distinctio nesciunt suscipit nisi.',
                'is_correct'         => 0,
                'question_id'        => 3
            ],
            [
                'id'                 => 10,
                'option_text'        => 'ichi',
                'is_correct'         => 0,
                'question_id'        => 4
            ],
            [
                'id'                 => 11,
                'option_text'        => 'ni',
                'is_correct'         => 1,
                'question_id'        => 4
            ],
            [
                'id'                 => 12,
                'option_text'        => 'san',
                'is_correct'         => 0,
                'question_id'        => 4
            ],
            [
                'id'                 => 13,
                'option_text'        => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis facere earum rerum magni vitae repudiandae natus distinctio nesciunt suscipit nisi, eum cum ea eos enim consequatur magnam tenetur similique accusantium.',
                'is_correct'         => 0,
                'question_id'        => 5
            ],
            [
                'id'                 => 14,
                'option_text'        => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis facere earum rerum magni vitae repudiandae natus distinctio nesciunt suscipit nisi, eum cum ea eos enim consequatur magnam tenetur similique accusantium.',
                'is_correct'         => 1,
                'question_id'        => 5
            ],
            [
                'id'                 => 15,
                'option_text'        => 'Both of above',
                'is_correct'         => 0,
                'question_id'        => 5
            ],
            [
                'id'                 => 16,
                'option_text'        => 'Lorem ipsum dolor',
                'is_correct'         => 0,
                'question_id'        => 6
            ],
            [
                'id'                 => 17,
                'option_text'        => 'Lorem',
                'is_correct'         => 1,
                'question_id'        => 6
            ],
            [
                'id'                 => 18,
                'option_text'        => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
                'is_correct'         => 0,
                'question_id'        => 6
            ],
        ];
        QuestionOption::insert($questionOptions);
    }
}
