@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.course.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.courses.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="teacher_id">{{ trans('cruds.course.fields.teacher') }}</label>
                            <select class="form-control select2" name="teacher_id" id="teacher_id">
                                @foreach($teachers as $id => $entry)
                                    <option value="{{ $id }}" {{ old('teacher_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('teacher'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('teacher') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.course.fields.teacher_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="course_category_id">{{ trans('cruds.course.fields.course_category') }}</label>
                            <select class="form-control select2" name="course_category_id" id="course_category_id">
                                @foreach($course_categories as $id => $entry)
                                    <option value="{{ $id }}" {{ old('course_category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('course_category'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('course_category') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.course.fields.course_category_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="title">{{ trans('cruds.course.fields.title') }}</label>
                            <input class="form-control" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                            @if($errors->has('title'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.course.fields.title_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="description">{{ trans('cruds.course.fields.description') }}</label>
                            <textarea class="form-control" name="description" id="description" required>{{ old('description') }}</textarea>
                            @if($errors->has('description'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.course.fields.description_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="price">{{ trans('cruds.course.fields.price') }}</label>
                            <input class="form-control" type="number" name="price" id="price" value="{{ old('price', '') }}" step="0.01">
                            @if($errors->has('price'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('price') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.course.fields.price_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="thumbnail">{{ trans('cruds.course.fields.thumbnail') }}</label>
                            <div class="needsclick dropzone" id="thumbnail-dropzone">
                            </div>
                            @if($errors->has('thumbnail'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('thumbnail') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.course.fields.thumbnail_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', 0) == 1 ? 'checked' : '' }}>
                                <label for="is_published">{{ trans('cruds.course.fields.is_published') }}</label>
                            </div>
                            @if($errors->has('is_published'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_published') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.course.fields.is_published_helper') }}</span>
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

@section('scripts')
<script>
    var uploadedThumbnailMap = {}
Dropzone.options.thumbnailDropzone = {
    url: '{{ route('frontend.courses.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="thumbnail[]" value="' + response.name + '">')
      uploadedThumbnailMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedThumbnailMap[file.name]
      }
      $('form').find('input[name="thumbnail[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($course) && $course->thumbnail)
      var files = {!! json_encode($course->thumbnail) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="thumbnail[]" value="' + file.file_name + '">')
        }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}

</script>
@endsection