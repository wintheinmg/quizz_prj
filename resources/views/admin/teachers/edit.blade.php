@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.teacher.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.teachers.update", [$teacher->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
            <div class="col-xl-4 col-lg-4 col-12">
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.teacher.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $teacher->name) }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.teacher.fields.name_helper') }}</span>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-12">
                <div class="form-group">
                    <label class="required" for="date_of_birth">{{ trans('cruds.teacher.fields.date_of_birth') }}</label>
                    <input class="form-control date {{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}" type="text" name="date_of_birth" id="date_of_birth" placeholder="YYYY-MM-DD"  value="{{ old('date_of_birth', $teacher->date_of_birth) }}" required>
                    @if($errors->has('date_of_birth'))
                        <div class="invalid-feedback">
                            {{ $errors->first('date_of_birth') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.teacher.fields.date_of_birth_helper') }}</span>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-12">
                <div class="form-group">
                    <label class="required" for="age">{{ trans('cruds.teacher.fields.age') }}</label>
                    <input class="form-control {{ $errors->has('age') ? 'is-invalid' : '' }}" type="number" name="age" id="age" value="{{ old('age', $teacher->age) }}" step="1" required>
                    @if($errors->has('age'))
                        <div class="invalid-feedback">
                            {{ $errors->first('age') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.teacher.fields.age_helper') }}</span>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-12">
                <div class="form-group">
                    <label class="required" for="parent_name">{{ trans('cruds.teacher.fields.parent_name') }}</label>
                    <input class="form-control {{ $errors->has('parent_name') ? 'is-invalid' : '' }}" type="text" name="parent_name" id="parent_name" value="{{ old('parent_name', $teacher->parent_name) }}" required>
                    @if($errors->has('parent_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('parent_name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.teacher.fields.parent_name_helper') }}</span>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-12">
                <div class="form-group">
                    <label for="parent_occupation">{{ trans('cruds.teacher.fields.parent_occupation') }}</label>
                    <textarea rows="1"  class="form-control ckeditor {{ $errors->has('parent_occupation') ? 'is-invalid' : '' }}" name="parent_occupation" id="parent_occupation">{!! old('parent_occupation', $teacher->parent_occupation) !!}</textarea>
                    @if($errors->has('parent_occupation'))
                        <div class="invalid-feedback">
                            {{ $errors->first('parent_occupation') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.teacher.fields.parent_occupation_helper') }}</span>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-12">
                <div class="form-group">
                    <label class="required" for="nation_and_religion">{{ trans('cruds.teacher.fields.nation_and_religion') }}</label>
                    <input class="form-control {{ $errors->has('nation_and_religion') ? 'is-invalid' : '' }}" type="text" name="nation_and_religion" id="nation_and_religion" value="{{ old('nation_and_religion', $teacher->nation_and_religion) }}" required>
                    @if($errors->has('nation_and_religion'))
                        <div class="invalid-feedback">
                            {{ $errors->first('nation_and_religion') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.teacher.fields.nation_and_religion_helper') }}</span>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-12">
                <div class="form-group">
                    <label class="required" for="nrc">{{ trans('cruds.teacher.fields.nrc') }}</label>
                    <input class="form-control {{ $errors->has('nrc') ? 'is-invalid' : '' }}" type="text" name="nrc" id="nrc" value="{{ old('nrc', $teacher->nrc) }}" required>
                    @if($errors->has('nrc'))
                        <div class="invalid-feedback">
                            {{ $errors->first('nrc') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.teacher.fields.nrc_helper') }}</span>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-12">
                <div class="form-group">
                    <label class="required" for="contact_no">{{ trans('cruds.teacher.fields.contact_no') }}</label>
                    <input class="form-control {{ $errors->has('contact_no') ? 'is-invalid' : '' }}" type="text" name="contact_no" id="contact_no" value="{{ old('contact_no', $teacher->contact_no) }}" required>
                    @if($errors->has('contact_no'))
                        <div class="invalid-feedback">
                            {{ $errors->first('contact_no') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.teacher.fields.contact_no_helper') }}</span>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-12">
                <div class="form-group">
                    <label for="address">{{ trans('cruds.teacher.fields.address') }}</label>
                    <textarea rows="1"  class="form-control ckeditor {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" id="address">{!! old('address', $teacher->address) !!}</textarea>
                    @if($errors->has('address'))
                        <div class="invalid-feedback">
                            {{ $errors->first('address') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.teacher.fields.address_helper') }}</span>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-12">
                <div class="form-group">
                    <label class="required" for="start_date_of_employment">{{ trans('cruds.teacher.fields.start_date_of_employment') }}</label>
                    <input class="form-control date {{ $errors->has('start_date_of_employment') ? 'is-invalid' : '' }}" type="text" name="start_date_of_employment" id="start_date_of_employment" placeholder="YYYY-MM-DD"  value="{{ old('start_date_of_employment', $teacher->start_date_of_employment) }}" required>
                    @if($errors->has('start_date_of_employment'))
                        <div class="invalid-feedback">
                            {{ $errors->first('start_date_of_employment') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.teacher.fields.start_date_of_employment_helper') }}</span>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-12">
                <div class="form-group">
                    <label for="attended_courses">{{ trans('cruds.teacher.fields.attended_courses') }}</label>
                    <textarea rows="1"  class="form-control ckeditor {{ $errors->has('attended_courses') ? 'is-invalid' : '' }}" name="attended_courses" id="attended_courses">{!! old('attended_courses', $teacher->attended_courses) !!}</textarea>
                    @if($errors->has('attended_courses'))
                        <div class="invalid-feedback">
                            {{ $errors->first('attended_courses') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.teacher.fields.attended_courses_helper') }}</span>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-xl-12 col-lg-12 col-12">
                <div class="form-group">
                    <label for="certificate_files">{{ trans('cruds.teacher.fields.certificate_files') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('certificate_files') ? 'is-invalid' : '' }}" id="certificate_files-dropzone">
                    </div>
                    @if($errors->has('certificate_files'))
                        <div class="invalid-feedback">
                            {{ $errors->first('certificate_files') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.teacher.fields.certificate_files_helper') }}</span>
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

@section('scripts')
<script>
    $(document).ready(function () {
        
        var date_of_birth = document.querySelector('#date_of_birth');
        var start_date_of_employment = document.querySelector('#start_date_of_employment');

        if (date_of_birth) {
            date_of_birth.flatpickr();
        }

        if (start_date_of_employment) {
            start_date_of_employment.flatpickr();
        }
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.teachers.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $teacher->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

<script>
    var uploadedCertificateFilesMap = {}
Dropzone.options.certificateFilesDropzone = {
    url: '{{ route('admin.teachers.storeMedia') }}',
    maxFilesize: 10, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="certificate_files[]" value="' + response.name + '">')
      uploadedCertificateFilesMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedCertificateFilesMap[file.name]
      }
      $('form').find('input[name="certificate_files[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($teacher) && $teacher->certificate_files)
          var files =
            {!! json_encode($teacher->certificate_files) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="certificate_files[]" value="' + file.file_name + '">')
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