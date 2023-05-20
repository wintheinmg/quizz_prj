@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.test.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.tests.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-12">
                        <div class="form-group">
                            <label for="course_id">{{ trans('cruds.test.fields.course') }}</label>
                            <select class="form-control select2 {{ $errors->has('course') ? 'is-invalid' : '' }}"
                                name="course_id" id="course_id">
                                @foreach ($courses as $id => $entry)
                                    <option value="{{ $id }}" {{ old('course_id') == $id ? 'selected' : '' }}>
                                        {{ $entry }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('course'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('course') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.test.fields.course_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-12">
                        <div class="form-group">
                            <label for="title">{{ trans('cruds.test.fields.title') }}</label>
                            <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text"
                                name="title" id="title" value="{{ old('title', '') }}">
                            @if ($errors->has('title'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.test.fields.title_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-12">
                        <div class="form-group">
                            <label for="description">{{ trans('cruds.test.fields.description') }}</label>
                            <textarea rows="1" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description"
                                id="description">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.test.fields.description_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-12">
                        <div class="form-group">
                            <label for="duration">{{ trans('cruds.test.fields.duration') }} (
                                {{ trans('global.minutes') }} )</label>
                            <input class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" type="number"
                                name="duration" id="duration" value="{{ old('duration', '') }}">
                            @if ($errors->has('duration'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('duration') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.test.fields.duration_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-12 pt-3">
                        <div class="form-group">
                            <label for="pass_score">{{ trans('cruds.test.fields.pass_score') }}</label>
                            <input class="form-control {{ $errors->has('pass_score') ? 'is-invalid' : '' }}" type="number"
                                name="pass_score" id="pass_score" value="{{ old('pass_score', 0) }}" min="0">
                            @if ($errors->has('pass_score'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('pass_score') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.test.fields.pass_score_helper') }}</span>
                        </div>
                    </div>
                    {{-- <div class="col-xl-3 col-lg-3 col-12 pt-5">
                        <div class="form-group">
                            <div class="form-check {{ $errors->has('is_published') ? 'is-invalid' : '' }}">
                                <input type="hidden" name="is_published" value="0">
                                <input class="form-check-input" type="checkbox" name="is_published" id="is_published"
                                    value="1" {{ old('is_published', 0) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="is_published">{{ trans('cruds.test.fields.is_published') }}</label>
                            </div>
                            @if ($errors->has('is_published'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_published') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.test.fields.is_published_helper') }}</span>
                        </div>
                    </div> --}}
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
