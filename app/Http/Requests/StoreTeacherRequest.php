<?php

namespace App\Http\Requests;

use App\Models\Teacher;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTeacherRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('teacher_create');
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
                'unique:teachers',
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
