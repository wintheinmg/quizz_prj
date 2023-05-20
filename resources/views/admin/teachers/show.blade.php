@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.teacher.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.teachers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.id') }}
                        </th>
                        <td>
                            {{ $teacher->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.name') }}
                        </th>
                        <td>
                            {{ $teacher->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.date_of_birth') }}
                        </th>
                        <td>
                            {{ $teacher->date_of_birth }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.age') }}
                        </th>
                        <td>
                            {{ $teacher->age }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.parent_name') }}
                        </th>
                        <td>
                            {{ $teacher->parent_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.parent_occupation') }}
                        </th>
                        <td>
                            {!! $teacher->parent_occupation !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.nation_and_religion') }}
                        </th>
                        <td>
                            {{ $teacher->nation_and_religion }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.nrc') }}
                        </th>
                        <td>
                            {{ $teacher->nrc }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.contact_no') }}
                        </th>
                        <td>
                            {{ $teacher->contact_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.address') }}
                        </th>
                        <td>
                            {!! $teacher->address !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.start_date_of_employment') }}
                        </th>
                        <td>
                            {{ $teacher->start_date_of_employment }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.attended_courses') }}
                        </th>
                        <td>
                            {!! $teacher->attended_courses !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teacher.fields.certificate_files') }}
                        </th>
                        <td>
                            @foreach($teacher->certificate_files as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.teachers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection