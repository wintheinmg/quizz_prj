@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.courseStudent.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.course-students.update", [$courseStudent->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
           <div class="row">
            <div class="col-xl-4 col-lg-4 col-12">
                    <div class="form-group">
                        <label class="required" for="course_id">{{ trans('cruds.courseStudent.fields.course') }}</label>
                        <select class="form-control select2 {{ $errors->has('course') ? 'is-invalid' : '' }}" name="course_id" id="course_id" required>
                            @foreach($courses as $id => $entry)
                                <option value="{{ $id }}" {{ (old('course_id') ? old('course_id') : $courseStudent->course->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('course'))
                            <div class="invalid-feedback">
                                {{ $errors->first('course') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.courseStudent.fields.course_helper') }}</span>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-12">
                    <div class="form-group">
                        <label class="required" for="student_id">{{ trans('cruds.courseStudent.fields.student') }}</label>
                        <select class="form-control select2 {{ $errors->has('student') ? 'is-invalid' : '' }}" name="student_id" id="student_id" required>
                            @foreach($students as $id => $entry)
                                <option value="{{ $id }}" {{ (old('student_id') ? old('student_id') : $courseStudent->student->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('student'))
                            <div class="invalid-feedback">
                                {{ $errors->first('student') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.courseStudent.fields.student_helper') }}</span>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-12 pt-4">
                    <div class="form-group">
                        <button class="btn btn-success " type="submit">
                            {{ trans('global.save') }}
                        </button>
                        <a onclick=history.back() class="btn btn-light ms-2">Cancel</a>
                    </div>
                </div>
           </div>
        </form>
    </div>
</div>



@endsection