@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.questionOption.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.question-options.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
            <div class="col-xl-4 col-lg-4 col-12">
                <div class="form-group">
                    <label for="question_id">{{ trans('cruds.questionOption.fields.question') }}</label>
                    <select class="form-control select2 {{ $errors->has('question') ? 'is-invalid' : '' }}" name="question_id" id="question_id">
                        @foreach($questions as $id => $entry)
                            <option value="{{ $id }}" {{ old('question_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('question'))
                        <div class="invalid-feedback">
                            {{ $errors->first('question') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.questionOption.fields.question_helper') }}</span>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-12">
                <div class="form-group">
                    <label class="required" for="option_text">{{ trans('cruds.questionOption.fields.option_text') }}</label>
                    <input class="form-control {{ $errors->has('option_text') ? 'is-invalid' : '' }}" type="text" name="option_text" id="option_text" value="{{ old('option_text', '') }}" required>
                    @if($errors->has('option_text'))
                        <div class="invalid-feedback">
                            {{ $errors->first('option_text') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.questionOption.fields.option_text_helper') }}</span>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-12 pt-4">
                <div class="form-group">
                    <div class="form-check {{ $errors->has('is_correct') ? 'is-invalid' : '' }}">
                        <input type="hidden" name="is_correct" value="0">
                        <input class="form-check-input" type="checkbox" name="is_correct" id="is_correct" value="1" {{ old('is_correct', 0) == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_correct">{{ trans('cruds.questionOption.fields.is_correct') }}</label>
                    </div>
                    @if($errors->has('is_correct'))
                        <div class="invalid-feedback">
                            {{ $errors->first('is_correct') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.questionOption.fields.is_correct_helper') }}</span>
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