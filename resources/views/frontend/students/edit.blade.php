@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.student.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.students.update", [$student->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="date">{{ trans('cruds.student.fields.date') }}</label>
                            <input class="form-control date" type="text" name="date" id="date" value="{{ old('date', $student->date) }}">
                            @if($errors->has('date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.student.fields.date_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.student.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $student->name) }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.student.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="nrc">{{ trans('cruds.student.fields.nrc') }}</label>
                            <input class="form-control" type="text" name="nrc" id="nrc" value="{{ old('nrc', $student->nrc) }}">
                            @if($errors->has('nrc'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('nrc') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.student.fields.nrc_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="address">{{ trans('cruds.student.fields.address') }}</label>
                            <textarea class="form-control" name="address" id="address" required>{{ old('address', $student->address) }}</textarea>
                            @if($errors->has('address'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('address') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.student.fields.address_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="phone_no">{{ trans('cruds.student.fields.phone_no') }}</label>
                            <input class="form-control" type="text" name="phone_no" id="phone_no" value="{{ old('phone_no', $student->phone_no) }}" required>
                            @if($errors->has('phone_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('phone_no') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.student.fields.phone_no_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ trans('cruds.student.fields.email') }}</label>
                            <input class="form-control" type="email" name="email" id="email" value="{{ old('email', $student->email) }}">
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.student.fields.email_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="acca_student_no">{{ trans('cruds.student.fields.acca_student_no') }}</label>
                            <input class="form-control" type="text" name="acca_student_no" id="acca_student_no" value="{{ old('acca_student_no', $student->acca_student_no) }}">
                            @if($errors->has('acca_student_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('acca_student_no') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.student.fields.acca_student_no_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="subject">{{ trans('cruds.student.fields.subject') }}</label>
                            <input class="form-control" type="text" name="subject" id="subject" value="{{ old('subject', $student->subject) }}">
                            @if($errors->has('subject'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('subject') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.student.fields.subject_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="exam_session_period">{{ trans('cruds.student.fields.exam_session_period') }}</label>
                            <input class="form-control" type="text" name="exam_session_period" id="exam_session_period" value="{{ old('exam_session_period', $student->exam_session_period) }}">
                            @if($errors->has('exam_session_period'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('exam_session_period') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.student.fields.exam_session_period_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="old_student">{{ trans('cruds.student.fields.old_student') }}</label>
                            <input class="form-control" type="text" name="old_student" id="old_student" value="{{ old('old_student', $student->old_student) }}">
                            @if($errors->has('old_student'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('old_student') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.student.fields.old_student_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.student.fields.how_knew_acca') }}</label>
                            <select class="form-control" name="how_knew_acca" id="how_knew_acca">
                                <option value disabled {{ old('how_knew_acca', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Student::HOW_KNEW_ACCA_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('how_knew_acca', $student->how_knew_acca) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('how_knew_acca'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('how_knew_acca') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.student.fields.how_knew_acca_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection