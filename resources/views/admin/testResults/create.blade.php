@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.testResult.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.test-results.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
            <div class="col-xl-4 col-lg-4 col-12">
                <div class="form-group">
                    <label class="required" for="test_id">{{ trans('cruds.testResult.fields.test') }}</label>
                    <select class="form-control select2 {{ $errors->has('test') ? 'is-invalid' : '' }}" name="test_id" id="test_id" required>
                        @foreach($tests as $id => $entry)
                            <option value="{{ $id }}" {{ old('test_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('test'))
                        <div class="invalid-feedback">
                            {{ $errors->first('test') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.testResult.fields.test_helper') }}</span>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-12">
                <div class="form-group">
                    <label class="required" for="student_id">{{ trans('cruds.testResult.fields.student') }}</label>
                    <select class="form-control select2 {{ $errors->has('student') ? 'is-invalid' : '' }}" name="student_id" id="student_id" required>
                        @foreach($students as $id => $entry)
                            <option value="{{ $id }}" {{ old('student_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('student'))
                        <div class="invalid-feedback">
                            {{ $errors->first('student') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.testResult.fields.student_helper') }}</span>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-12">
                <div class="form-group">
                    <label for="score">{{ trans('cruds.testResult.fields.score') }}</label>
                    <input class="form-control {{ $errors->has('score') ? 'is-invalid' : '' }}" type="number" name="score" id="score" value="{{ old('score', '') }}" step="1">
                    @if($errors->has('score'))
                        <div class="invalid-feedback">
                            {{ $errors->first('score') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.testResult.fields.score_helper') }}</span>
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