@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.student.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.students.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.student.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $student->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.student.fields.date') }}
                                    </th>
                                    <td>
                                        {{ $student->date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.student.fields.name') }}
                                    </th>
                                    <td>
                                        {{ $student->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.student.fields.nrc') }}
                                    </th>
                                    <td>
                                        {{ $student->nrc }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.student.fields.address') }}
                                    </th>
                                    <td>
                                        {{ $student->address }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.student.fields.phone_no') }}
                                    </th>
                                    <td>
                                        {{ $student->phone_no }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.student.fields.email') }}
                                    </th>
                                    <td>
                                        {{ $student->email }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.student.fields.acca_student_no') }}
                                    </th>
                                    <td>
                                        {{ $student->acca_student_no }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.student.fields.subject') }}
                                    </th>
                                    <td>
                                        {{ $student->subject }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.student.fields.exam_session_period') }}
                                    </th>
                                    <td>
                                        {{ $student->exam_session_period }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.student.fields.old_student') }}
                                    </th>
                                    <td>
                                        {{ $student->old_student }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.student.fields.how_knew_acca') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Student::HOW_KNEW_ACCA_SELECT[$student->how_knew_acca] ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.students.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection