@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.student.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.students.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                <div class="col-xl-4 col-lg-4 col-12">
                    <div class="form-group">
                        <label for="date">{{ trans('cruds.student.fields.date') }}</label>
                        <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text"
                            name="date" id="date" placeholder="YYYY-MM-DD" value="{{ old('date') }}">
                        @if ($errors->has('date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('date') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.student.fields.date_helper') }}</span>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-12">
                    <div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.student.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                            id="name" value="{{ old('name', '') }}" required>
                        @if ($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.student.fields.name_helper') }}</span>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-12">
                    <div class="form-group">
                        <label for="nrc">{{ trans('cruds.student.fields.nrc') }}</label>
                        <input class="form-control {{ $errors->has('nrc') ? 'is-invalid' : '' }}" type="text" name="nrc"
                            id="nrc" value="{{ old('nrc', '') }}">
                        @if ($errors->has('nrc'))
                            <div class="invalid-feedback">
                                {{ $errors->first('nrc') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.student.fields.nrc_helper') }}</span>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-12">
                    <div class="form-group">
                        <label class="required" for="address">{{ trans('cruds.student.fields.address') }}</label>
                        <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" rows="1"  name="address" id="address"
                            required>{{ old('address') }}</textarea>
                        @if ($errors->has('address'))
                            <div class="invalid-feedback">
                                {{ $errors->first('address') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.student.fields.address_helper') }}</span>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-12">
                    <div class="form-group">
                        <label class="required" for="phone_no">{{ trans('cruds.student.fields.phone_no') }}</label>
                        <input class="form-control {{ $errors->has('phone_no') ? 'is-invalid' : '' }}" type="text"
                            name="phone_no" id="phone_no" value="{{ old('phone_no', '') }}" required>
                        @if ($errors->has('phone_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('phone_no') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.student.fields.phone_no_helper') }}</span>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-12">
                    <div class="form-group">
                        <label for="email">{{ trans('cruds.student.fields.email') }}</label>
                        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                            name="email" id="email" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.student.fields.email_helper') }}</span>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-12">
                    <div class="form-group">
                        <label for="acca_student_no">{{ trans('cruds.student.fields.acca_student_no') }}</label>
                        <input class="form-control {{ $errors->has('acca_student_no') ? 'is-invalid' : '' }}" type="text"
                            name="acca_student_no" id="acca_student_no" value="{{ old('acca_student_no', '') }}">
                        @if ($errors->has('acca_student_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('acca_student_no') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.student.fields.acca_student_no_helper') }}</span>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-12">
                    <div class="form-group">
                        <label for="subject">{{ trans('cruds.student.fields.subject') }}</label>
                        <input class="form-control {{ $errors->has('subject') ? 'is-invalid' : '' }}" type="text"
                            name="subject" id="subject" value="{{ old('subject', '') }}">
                        @if ($errors->has('subject'))
                            <div class="invalid-feedback">
                                {{ $errors->first('subject') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.student.fields.subject_helper') }}</span>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-12">
                    <div class="form-group">
                        <label for="exam_session_period">{{ trans('cruds.student.fields.exam_session_period') }}</label>
                        <input class="form-control {{ $errors->has('exam_session_period') ? 'is-invalid' : '' }}"
                            type="text" name="exam_session_period" id="exam_session_period"
                            value="{{ old('exam_session_period', '') }}">
                        @if ($errors->has('exam_session_period'))
                            <div class="invalid-feedback">
                                {{ $errors->first('exam_session_period') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.student.fields.exam_session_period_helper') }}</span>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-12">
                    <div class="form-group d-flex flex-column">
                        <label for="old_student">{{ trans('cruds.student.fields.old_student') }}</label>
                        <div class="pt-2">
                            <input class="" type="radio" name="old_student" id="old_student_yes" value="yes">
                            <label for="old_student_yes">Yes</label>
                            <input class="" type="radio" name="old_student" id="old_student_no" value="no">
                            <label for="old_student_no">No</label>
                            @if ($errors->has('old_student'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('old_student') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-12">
                    <label for="which" class="form-label">{{ trans('global.user_which_subject') }} </label>
                    <input type="text" name="which"
                        class="form-control{{ $errors->has('which') ? ' is-invalid' : '' }}"
                        placeholder="{{ trans('global.user_which_subject') }}" value="{{ old('which', null) }}">
                    {{-- <input type="text" class="form-control" id="which" which="which" placeholder="Enter your which or userwhich" autofocus /> --}}
                    @if ($errors->has('which'))
                        <div class="small text-danger">
                            {{ $errors->first('which') }}
                        </div>
                    @endif
                </div>
                <div class="col-xl-4 col-lg-4 col-12">
                    <div class="form-group">
                        <label>{{ trans('cruds.student.fields.how_knew_acca') }}</label>
                        <select class="form-control {{ $errors->has('how_knew_acca') ? 'is-invalid' : '' }}"
                            name="how_knew_acca" id="how_knew_acca">
                            <option value disabled {{ old('how_knew_acca', null) === null ? 'selected' : '' }}>
                                {{ trans('global.pleaseSelect') }}</option>
                            @foreach (App\Models\Student::HOW_KNEW_ACCA_SELECT as $key => $label)
                                <option value="{{ $key }}"
                                    {{ old('how_knew_acca', '') === (string) $key ? 'selected' : '' }}>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('how_knew_acca'))
                            <div class="invalid-feedback">
                                {{ $errors->first('how_knew_acca') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.student.fields.how_knew_acca_helper') }}</span>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-12">
                    <label for="why_choose" class="form-label">{{ trans('global.user_why_choose') }} </label>
                    {{-- <input type="text" name="why_choose"
                        class="form-control{{ $errors->has('why_choose') ? ' is-invalid' : '' }}"
                        placeholder="{{ trans('global.user_why_choose') }}" value="{{ old('why_choose', null) }}"> --}}
                    <textarea rows="1" cols="1" class="form-control"  name="why_choose" id="why_choose"></textarea>
                    @if ($errors->has('why_choose'))
                        <div class="small text-danger">
                            {{ $errors->first('why_choose') }}
                        </div>
                    @endif
                </div>
                <div class="col-xl-12 col-lg-12 col-12">
                    <div class="form-group">
                        <label for="photo">{{ trans('cruds.student.fields.photo') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                        </div>
                        @if ($errors->has('photo'))
                            <div class="invalid-feedback">
                                {{ $errors->first('photo') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.student.fields.photo_helper') }}</span>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-12 pt-4">
                    <div class="form-group">
                        <button class="btn btn-success mt-2" type="submit">
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
        $(() => {
            var date = document.querySelector('#date');

            if (date) {
                date.flatpickr();
            }
        })
        Dropzone.options.photoDropzone = {
            url: '{{ route('admin.students.storeMedia') }}',
            maxFilesize: 2, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2,
                width: 4096,
                height: 4096
            },
            success: function(file, response) {
                $('form').find('input[name="photo"]').remove()
                $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="photo"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($student) && $student->photo)
                    var file = {!! json_encode($student->photo) !!}
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
                    this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function(file, response) {
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
