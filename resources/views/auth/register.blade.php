@extends('layouts.app')
@section('styles')
    <style>
        body {
            min-height: auto;
        }

        .container {
            width: 100% !important;
            padding-right: 0px !important;
            padding-left: 15px !important;
            margin-right: auto !important;
            margin-left: auto !important;
        }

        @media (min-width: 1000px) {
            .container {
                max-width: 100%;
            }
        }

        .form-control:focus {
            border-color: #9577fd !important;
            box-shadow: 0 0 0 0.2rem rgb(149 119 253 / 25%) !important;
        }

        .scrollbar {
            margin-left: 30px;
            float: left;
            height: 300px;
            width: 65px;
            background: #F5F5F5;
            overflow-y: scroll;
            margin-bottom: 25px;
        }

        .scrollbar::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            background-color: #F5F5F5;
        }

        .scrollbar::-webkit-scrollbar {
            width: 6px;
            background-color: #F5F5F5;
        }

        .scrollbar::-webkit-scrollbar-thumb {
            background-color: #9577fd;
        }
        .btn-purple{
            color: #fff;
            background-color: #9577fd;
            border-color: #9577fd;
        }
        .btn-purple:hover,
        .btn-purple:focus{
            color: #fff;
            background-color: #9477fddc;
            border-color: #9577fd;
        }
    </style>
@endsection
@section('content')
    <div class="authentication-wrapper authentication-cover">
        <div class="authentication-inner row m-0 p-0  justify-content-center">
            <!-- Login -->
            <div class="card d-flex col-12 col-lg-5 col-xl-5 align-items-center authentication-bg p-sm-5 p-4 m-0 scrollbar"
                style="background: #fff;height : 100vh !important;overflow-y:scroll;">
                <div class="w-px-400 mx-auto">
                    <!-- Logo -->
                    <div class="px-5 py-3" style="background-color: #9577fd;"></div>
                    <img src="{{ asset('open-book.png') }}" alt="Auth Cover Bg color" class="" width="70"
                        height="70" />
                    <span class="app-brand-text demo h3 mb-0 fw-bolder text-dark">QUIZZ REGISTER FORM</span>
                    <hr style="border: 1px solid #9577fd; background-color: #9577fd;margin: 0;">
                    <!-- /Logo -->
                    <form method="POST" action="{{ route('students.store') }}">
                        {{ csrf_field() }}

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ trans('global.user_name') }} </label>
                            <input type="text" name="name"
                                class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" required
                                placeholder="{{ trans('global.user_name') }}" value="{{ old('name', null) }}">
                            {{-- <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name or username" autofocus /> --}}
                            @if ($errors->has('name'))
                                <div class="small text-danger">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="nrc" class="form-label">{{ trans('global.user_nrc') }} </label>
                            <input type="text" name="nrc"
                                class="form-control{{ $errors->has('nrc') ? ' is-invalid' : '' }}" required
                                placeholder="{{ trans('global.user_nrc') }}" value="{{ old('nrc', null) }}">
                            {{-- <input type="text" class="form-control" id="nrc" nrc="nrc" placeholder="Enter your nrc or usernrc" autofocus /> --}}
                            @if ($errors->has('nrc'))
                                <div class="small text-danger">
                                    {{ $errors->first('nrc') }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">{{ trans('global.user_address') }} </label>
                            {{-- <textarea rows="1" cols="1" class="form-control"  name="address" id="address"></textarea> --}}
                            <input type="text" name="address"
                                class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" required
                                placeholder="{{ trans('global.user_address') }}" value="{{ old('address', null) }}">
                            @if ($errors->has('address'))
                                <div class="small text-danger">
                                    {{ $errors->first('address') }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="phone_no" class="form-label">{{ trans('global.user_phone') }} </label>
                            <input class="form-control {{ $errors->has('phone_no') ? 'is-invalid' : '' }}" type="text"
                                name="phone_no" id="phone_no" value="{{ old('phone_no', '') }}"
                                placeholder="{{ trans('global.user_phone') }}" required>
                            @if ($errors->has('phone_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('phone_no') }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="acca_student_no" class="form-label">{{ trans('global.user_acca_student_no') }}
                            </label>
                            <input type="text" name="acca_student_no"
                                class="form-control{{ $errors->has('acca_student_no') ? ' is-invalid' : '' }}"
                                autofocus placeholder="{{ trans('global.user_acca_student_no') }}"
                                value="{{ old('acca_student_no', null) }}">
                            {{-- <input type="text" class="form-control" id="acca_student_no" acca_student_no="acca_student_no" placeholder="Enter your acca_student_no or useracca_student_no" autofocus /> --}}
                            @if ($errors->has('acca_student_no'))
                                <div class="small text-danger">
                                    {{ $errors->first('acca_student_no') }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">{{ trans('global.user_subject') }} </label>
                            <input type="text" name="subject"
                                class="form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}"
                                placeholder="{{ trans('global.user_subject') }}" value="{{ old('subject', null) }}">
                            {{-- <input type="text" class="form-control" id="subject" subject="subject" placeholder="Enter your subject or usersubject" autofocus /> --}}
                            @if ($errors->has('subject'))
                                <div class="small text-danger">
                                    {{ $errors->first('subject') }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="exam_session_period">{{ trans('global.user_exam_session_period') }}</label>
                            <input class="form-control {{ $errors->has('exam_session_period') ? 'is-invalid' : '' }}"
                                type="text" name="exam_session_period" id="exam_session_period"
                                placeholder="{{ trans('global.user_exam_session_period') }}"
                                value="{{ old('exam_session_period', '') }}">
                            @if ($errors->has('exam_session_period'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('exam_session_period') }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-5">
                                    <label for="old_student">{{ trans('cruds.student.fields.old_student') }}</label>
                                    <input type="radio" class="old_student" name="old_student" id="old_student_yes" value="yes">
                                    <label for="old_student_yes" class="old_student">Yes</label>
                                    <input type="radio" class="old_student" name="old_student" id="old_student_no" value="no">
                                    <label for="old_student_no" class="old_student">No</label>
                                    @if ($errors->has('old_student'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('old_student') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-7">
                                    {{-- <label for="which" class="form-label">{{ trans('global.user_which_subject') }} </label> --}}
                                    <input type="text" name="which" id="if_yes_which" disabled
                                        class="form-control{{ $errors->has('which') ? ' is-invalid' : '' }}"
                                        placeholder="{{ trans('global.user_which_subject') }}" value="{{ old('which', null) }}">
                                    {{-- <input type="text" class="form-control" id="which" which="which" placeholder="Enter your which or userwhich" autofocus /> --}}
                                    @if ($errors->has('which'))
                                        <div class="small text-danger">
                                            {{ $errors->first('which') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>{{ trans('cruds.student.fields.how_did_you_know_eas') }}</label>
                            <select class="form-control {{ $errors->has('how_knew_acca') ? 'is-invalid' : '' }}"
                                name="how_knew_acca" id="how_knew_acca">
                                <option value disabled {{ old('how_knew_acca', null) === null ? 'selected' : '' }}>
                                    {{ trans('global.pleaseSelect') }}</option>
                                @foreach (App\Models\Student::HOW_KNEW_ACCA_SELECT as $key => $label)
                                    <option value="{{ $key }}"
                                        {{ old('how_knew_acca', '') === (string) $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('how_knew_acca'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('how_knew_acca') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="mb-3">
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

                        <div class="mb-3">
                            <label for="email" class="form-label">Email </label>
                            <input type="text" name="email" class="form-control" required
                                placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">
                            {{-- <input type="text" class="form-control" id="email" email="email" placeholder="Enter your email or useremail" autofocus /> --}}
                            @if ($errors->has('email'))
                                <div class="small text-danger">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password </label>
                            <input type="password" name="password" class="form-control" required
                                placeholder="{{ trans('global.login_password') }}" value="{{ old('password', null) }}">
                            {{-- <input type="text" class="form-control" id="password" password="password" placeholder="Enter your password or userpassword" autofocus /> --}}
                            @if ($errors->has('password'))
                                <div class="small text-danger">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password </label>
                            <input type="password" name="password_confirmation"
                                class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                required autofocus placeholder="{{ trans('global.login_password_confirmation') }}"
                                value="{{ old('password_confirmation', null) }}">
                            {{-- <input type="password" name="password_confirmation" class="form-control" required placeholder="{{ trans('global.login_password_confirmation') }}"> --}}
                            @if ($errors->has('password_confirmation'))
                                <div class="small text-danger">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="photo">{{ trans('cruds.student.fields.photo') }}</label>
                            {{-- <input type="file" class="form-control" name="photo" id="photo"> --}}
                            <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                            </div>
                            @if ($errors->has('photo'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('photo') }}
                                </div>
                            @endif
                        </div>

                        <button class="btn btn-purple d-grid w-100" type="submit">Sign up as a student</button>
                        <a href="{{ route('login') }}" class="btn btn-purple d-grid w-100 my-1" id="sign-in">Sign
                            in</a>
                    </form>

                </div>
            </div>
            <!-- /Login -->
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
       $('.old_student').on('click', function() {
            var old_student = $("input[name=old_student]:checked").val();
            if(old_student == "yes"){
                $('#if_yes_which').attr('disabled', false);
            } else{
                $('#if_yes_which').val('');
                $('#if_yes_which').attr('disabled', true);
            }
        })
        if (localStorage.chkbx && localStorage.chkbx != '') {
            $('#remember-me').attr('checked', 'checked');
            $('#email').val(localStorage.email);
            $('#password').val(localStorage.password);
        } else {
            $('#remember-me').removeAttr('checked');
            $('#email').val('');
            $('#password').val('');
        }
        $('#sign-in').on('click', function() {
            if ($('#remember-me').is(':checked')) {
                // save username and password
                localStorage.email = $('#email').val();
                localStorage.password = $('#password').val();
                localStorage.chkbx = $('#remember-me').val();
            } else {
                localStorage.email = '';
                localStorage.password = '';
                localStorage.chkbx = '';
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
                this.hiddenFileInput.removeAttribute('multiple');
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
