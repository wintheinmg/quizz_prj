@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.courseCategory.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.course-categories.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-12">
                    <div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.courseCategory.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.courseCategory.fields.name_helper') }}</span>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-12 pt-4 ">
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