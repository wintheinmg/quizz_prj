@extends('layouts.admin')
@section('styles')
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
    <style>
         .swal2-container.swal2-backdrop-show,
        .swal2-container.swal2-noanimation {
            background: rgba(0, 0, 0, .4);
            z-index: 99999;
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.question.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.questions.store') }}" enctype="multipart/form-data" id="myForm">
                @csrf
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-12 col-md-4 col-xs-6 col-sm-6">
                        <div class="form-group">
                            <label for="test_id">{{ trans('cruds.question.fields.test') }}</label>
                            <select class="form-control select2 {{ $errors->has('test') ? 'is-invalid' : '' }}"
                                name="test_id" id="test_id">
                                @foreach ($tests as $id => $entry)
                                    <option value="{{ $id }}" {{ old('test_id') == $id ? 'selected' : '' }}>
                                        {{ $entry }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('test'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('test') }}
                                </div>
                            @endif
                            <span class="error" id="test_id_error"></span>
                            <span class="help-block">{{ trans('cruds.question.fields.test_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-12 col-md-4 col-xs-6 col-sm-6">
                        <div class="form-group">
                            <label class="required"
                                for="question_text">{{ trans('cruds.question.fields.question_text') }}</label>
                            <textarea class="form-control {{ $errors->has('question_text') ? 'is-invalid' : '' }}" type="text"
                                name="question_text" id="question_text" value="{{ old('question_text', '') }}" rows="1" required></textarea>
                            @if ($errors->has('question_text'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('question_text') }}
                                </div>
                            @endif
                            <span class="error" id="question_text_error"></span>
                            <span class="help-block">{{ trans('cruds.question.fields.question_text_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-12 col-md-4 col-xs-6 col-sm-6">
                        <div class="form-group">
                            <label for="points">{{ trans('cruds.question.fields.points') }}</label>
                            <input class="form-control {{ $errors->has('points') ? 'is-invalid' : '' }}" type="number"
                                name="points" id="points" value="{{ old('points', '1') }}" step="1" min="1">
                            @if ($errors->has('points'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('points') }}
                                </div>
                            @endif
                            <span class="error" id="points_error"></span>
                            <span class="help-block">{{ trans('cruds.question.fields.points_helper') }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-xl-4 col-lg-4 col-4 col-md-4 col-xs-4 col-sm-4">
                        <div class="form-group">
                            <label for="question_image">{{ trans('cruds.question.fields.question_image') }}</label>
                            <div class="needsclick dropzone {{ $errors->has('question_image') ? 'is-invalid' : '' }}"
                                id="question_image-dropzone">
                            </div>
                            @if ($errors->has('question_image'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('question_image') }}
                                </div>
                            @endif
                            
                            <span class="help-block">{{ trans('cruds.question.fields.question_image_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                        <div class="content">
                            <div class="row mb-1" id="row0">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6 col-6">
                                    <div class="form-group">
                                        <label class="required"
                                            for="option_text0">{{ trans('cruds.questionOption.title') }}</label>
                                        <input class="form-control option_text {{ $errors->has('option_text0') ? 'is-invalid' : '' }}"
                                            type="text" name="option_text[]" id="option_text0"
                                            value="{{ old('option_text0', '') }}" required>
                                        @if ($errors->has('option_text0'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('option_text0') }}
                                            </div>
                                        @endif
                                        <span class="error" id="option_text0_error"></span>
                                        <span
                                            class="help-block">{{ trans('cruds.questionOption.fields.option_text_helper') }}</span>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3 col-3">
                                    <div class="mt-4">
                                        <label class="switch switch-sm switch-success">
                                            <input type="checkbox" class="switch-input" value="1" name="is_correct0" id="is_correct0">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on">
                                                    <i class="bx bx-check"></i>
                                                </span>
                                                <span class="switch-off">
                                                    <i class="bx bx-x"></i>
                                                </span>
                                            </span>
                                            <span
                                                class="switch-label">{{ trans('cruds.questionOption.fields.is_correct') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-2 col-2">
                                    <div class="d-flex mt-3 justify-content-start">
                                        <a class="btn add-row px-0 me-1" id=""><i
                                                class='bx bx-plus text-primary fw-bold fs-4'></i></a>
                                        <a class="btn remove-row px-0"><i class='bx bx-minus text-danger fw-bold fs-4'
                                                id="0"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-12 pt-4">
                    <div class="form-group">
                        <button class="btn btn-success " type="submit" id="save">
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>
    <script>
        let btnCount = 0;
        let html = "";
        $(document).on('click', '.add-row', function() {
            btnCount++;
            html = `<div class="row" id="row${btnCount}">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6 col-6">
                            <div class="form-group">
                                <input class="form-control option_text {{ $errors->has('option_text') ? 'is-invalid' : '' }}"
                                    type="text" name="option_text[]" id="option_text${btnCount}"
                                    value="{{ old('option_text${btnCount}', '') }}" required>
                                @if ($errors->has('option_text'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('option_text${btnCount}') }}
                                    </div>
                                @endif
                                <span class="error" id="option_text${btnCount}_error"></span>
                                <span
                                    class="help-block">{{ trans('cruds.questionOption.fields.option_text_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3 col-3">
                            <div class="mt-2">
                                <label class="switch switch-sm switch-success">
                                    <input type="checkbox" class="switch-input" value="1" name="is_correct${btnCount}" id="is_correct${btnCount}">
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on">
                                            <i class="bx bx-check"></i>
                                        </span>
                                        <span class="switch-off">
                                            <i class="bx bx-x"></i>
                                        </span>
                                    </span>
                                    <span
                                        class="switch-label">{{ trans('cruds.questionOption.fields.is_correct') }}</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-2 col-2">
                            <div class="d-flex mt-1 justify-content-start">
                                <a class="btn add-row px-0 me-1" id=""><i
                                        class='bx bx-plus text-primary fw-bold fs-4'></i></a>
                                <a class="btn remove-row px-0"><i class='bx bx-minus text-danger fw-bold fs-4'
                                        id="${btnCount}"></i></a>
                            </div>
                        </div>
                    </div>`;
            $('.content').append(html);
        });

        $(document).on('click','.remove-row',(e)=>{
            let id = $(e.target).attr('id');
            let count = $('.option_text').length;
            if(count > 1){
                $('#row' + id).remove();
            }else{
                Swal.fire({
                icon: 'error',
                title: `Oops...`,
                text: `You can't delete all question options!`,
                type: 'warning',
                showClass: {
                    popup: 'animate__animated animate__bounceIn'
                },
                hideClass: {
                    popup: 'animate__animated animate__bounceOut'
                },
                width: '450px',
                allowEnterKey: 'true'
            }).then((result) => {
            })
            }
        });

        $(document).on('click','.switch-input',(e) => {
            $('.switch-input').each(function(i,obj){
                if($(obj).is(':checked')){
                    
                    if($(obj).attr('id') != $(e.target).attr('id')){
                        $(obj).prop('checked',false);
                    }
                }
            })
        });

        $('#save').on('click',(e) => {
            e.preventDefault();
           formValidation();
        })

        var formValidation = () => {
            let test = $('#test_id').find(':selected').val();
            let question_text = $('#question_text').val();
            let points = $('#points').val();
            let arr = [];
            
            if(test == '' || test == null){
                $('#test_id_error').html('Test must be chosen');
                arr.push('text_id');
            }else{
                $('#test_id_error').html('');
                if(arr.includes('test_id')){
                    arr.splice(arr.indexOf('test_id'));
                }
            }

            if(question_text == '' || question_text == null){
                $('#question_text_error').html('Question Text must be filled');
                arr.push('question_text');
            }else{
                $('#question_text_error').html('');
                if(arr.includes('question_text')){
                    arr.splice(arr.indexOf('question_text'));
                }
            }

            if(points == '' || points == null){
                $('#points_error').html('Points must be filled');
                arr.push('points');
            }else if(points<=0){
                $('#points_error').html('Points must be greater than 0');
                arr.push('points');
            }
            else{
                $('#points_error').html('');
                if(arr.includes('points')){
                    arr.splice(arr.indexOf('points'));
                }
            }

            $('.option_text').each((element,value) => {
                let text = $(value).val();
                let text_id = $(value).attr('id');
                if(text == ''){
                    $('#' + text_id + '_error').html('Question Option must be filled');
                    arr.push('text');
                }else{
                    $('#' + text_id + '_error').html('');
                    if(arr.includes('text')){
                        arr.splice(arr.indexOf('text'),1);
                    }
                }
            });

            let count = 0;
            $('.switch-input').each((element,value) => {
               if($(value).is(':checked')){
                    count = 1;
                    return false;
               }
            });

            if(count == 0){
                arr.push('is_correct');
                Swal.fire({
                    icon: 'error',
                    title: `Oops...`,
                    text: `There is no correct answers for this question!`,
                    type: 'warning',
                    showClass: {
                        popup: 'animate__animated animate__bounceIn'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__bounceOut'
                    },
                    width: '450px',
                    allowEnterKey: 'true'
                }).then((result) => {
                    
                })
            }else{
                if(arr.includes('is_correct')){
                    arr.splice(arr.indexOf('is_correct'));
                }
            }

            if(arr.length == 0){
                $('#myForm').submit();
            }
        }
    </script>
    <script>
        Dropzone.options.questionImageDropzone = {
            url: '{{ route('admin.questions.storeMedia') }}',
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
                $('form').find('input[name="question_image"]').remove()
                $('form').append('<input type="hidden" name="question_image" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="question_image"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($question) && $question->question_image)
                    var file = {!! json_encode($question->question_image) !!}
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="question_image" value="' + file.file_name + '">')
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
