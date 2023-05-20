<?php

namespace App\Http\Requests;

use App\Models\Teacher;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTeacherRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('teacher_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'date_of_birth' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'age' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'parent_name' => [
                'string',
                'required',
            ],
            'nation_and_religion' => [
                'string',
                'required',
            ],
            'nrc' => [
                'string',
                'required',
                'unique:teachers,nrc,' . request()->route('teacher')->id,
            ],
            'contact_no' => [
                'string',
                'required',
            ],
            'address' => [
                'required',
            ],
            'start_date_of_employment' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'certificate_files' => [
                'array',
            ],
        ];
    }
}
