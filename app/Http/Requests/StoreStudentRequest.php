<?php

namespace App\Http\Requests;

use App\Models\Student;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreStudentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('student_create');
    }

    public function rules()
    {
        return [
            'date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'name' => [
                'string',
                'required',
            ],
            'nrc' => [
                'string',
                'nullable',
            ],
            'address' => [
                'required',
            ],
            'phone_no' => [
                'string',
                'required',
            ],
            'acca_student_no' => [
                'string',
                'nullable',
            ],
            'subject' => [
                'string',
                'nullable',
            ],
            'exam_session_period' => [
                'string',
                'nullable',
            ],
            'old_student' => [
                'string',
                'nullable',
            ],
        ];
    }
}
