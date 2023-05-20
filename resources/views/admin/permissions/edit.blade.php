@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.permission.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.permissions.update", [$permission->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
            <div class="col-xl-4 col-lg-4 col-12">
                <div class="form-group">
                    <label class="required" for="title">{{ trans('cruds.permission.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $permission->title) }}" required>
                    @if($errors->has('title'))
                        <div class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.permission.fields.title_helper') }}</span>
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