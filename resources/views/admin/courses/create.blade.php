@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.course.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.courses.store") }}" enctype="multipart/form-data" id="form">
            @csrf
            <div class="row">
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="course_category_id">{{ trans('cruds.course.fields.course_category') }}</label>
                        <select class="form-control select2 {{ $errors->has('course_category') ? 'is-invalid' : '' }}" name="course_category_id" id="course_category">
                            @foreach($course_categories as $id => $entry)
                                <option value="{{ $id }}" {{ old('course_category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('course_category'))
                            <div class="invalid-feedback">
                                {{ $errors->first('course_category') }}
                            </div>
                        @endif
                        <span class="help-block course_category_error text-danger">{{ trans('cruds.course.fields.course_category_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="course_photo">{{ trans('cruds.course.fields.course_photo') }}</label>
                       <input type="file" name="course_photo" id="course_photo" class="form-control" accept="image/*">
                        @if($errors->has('course_photo'))
                            <div class="invalid-feedback">
                                {{ $errors->first('course_photo') }}
                            </div>
                        @endif
                        <span class="help-block course_photo_error text-danger">{{ trans('cruds.course.fields.course_photo_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="required" for="title">{{ trans('cruds.course.fields.title') }}</label>
                        <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" >
                        @if($errors->has('title'))
                            <div class="invalid-feedback">
                                {{ $errors->first('title') }}
                            </div>
                        @endif
                        <span class="help-block title_error text-danger">{{ trans('cruds.course.fields.title_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="price">{{ trans('cruds.course.fields.price') }}</label>
                        <input class="parent_price form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', '') }}" step="0.01">
                        @if($errors->has('price'))
                            <div class="invalid-feedback">
                                {{ $errors->first('price') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.course.fields.price_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="required" for="description">{{ trans('cruds.course.fields.description') }}</label>
                        <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" rows="1" id="description" >{{ old('description') }}</textarea>
                        @if($errors->has('description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                        <span class="help-block text-danger descripton_error">{{ trans('cruds.course.fields.description_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="teacher_id">{{ trans('cruds.course.fields.teacher') }}</label>
                        <select class="form-control select2 teacher {{ $errors->has('teacher') ? 'is-invalid' : '' }}" name="teacher_id[]" id="teacher" multiple>
                            <option value="" disabled>{{ trans('global.pleaseSelect') }}</option>
                            @foreach($teachers as $id => $entry)
                                <option value="{{ $id }}">{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('teacher'))
                            <div class="invalid-feedback">
                                {{ $errors->first('teacher') }}
                            </div>
                        @endif
                        <span class="help-block teacher_error text-danger">{{ trans('cruds.course.fields.teacher_helper') }}</span>
                    </div>
                </div>

                <div class="row add_sub_course mt-3">
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary add_sub_course_btn">Add Sub Course</button>
                    </div>
                </div>
            </div>
            
               
                {{-- multi rows  --}}
                <div class="content mt-3 d-none">
                    <input type="hidden" name="sub_course_count" value="1">
                    <div class="row" id="row0">
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="sub-course">{{ trans('cruds.course.fields.sub_course') }}</label>
                                <input type="text" name="sub_course1" class="form-control sub_course" >
                            </div>
                            <span class="help-block fst-italic sub-course0_error"></span>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="sub_course_price">{{ trans('cruds.course.fields.price') }}</label>
                                <input type="text" class="form-control " name="sub_course_price1">
                            </div>
                            <span class="help-block fst-italic sub_course_price1_error"></span>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="sub_course_description1">{{ trans('cruds.course.fields.description') }}</label>
                                <textarea class="form-control ckeditor sub_course_price" name="sub_course_description1" id="" rows="1">{!! old('sub_course_price') !!}</textarea>
                            </div>
                            <span class="help-block fst-italic sub_course_description1_error"></span>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="teacher_id">{{ trans('cruds.course.fields.teacher') }}</label>
                                <select class="form-control select2 {{ $errors->has('teacher') ? 'is-invalid' : '' }}" name="teacher_id1[]" id="teacher1" multiple>
                                    <option value="" disabled>{{ trans('global.pleaseSelect') }}</option>
                                    @foreach($teachers as $id => $entry)
                                        <option value="{{ $id }}" {{ old('teacher_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                        </select>
                            </div>
                            <span class="help-block fst-italic sub_course_description1_error"></span>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                            <div class="d-flex mt-4">
                                <a class="btn px-0 me-1 add-sub-course" id=""><i
                                        class='bx bx-plus text-primary fw-bold fs-4'></i></a>
                                <a class="btn px-0 remove-sub-course" id="0"><i
                                        class='bx bx-minus text-danger fw-bold fs-4'></i></a>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="sub_course_photo1">{{ trans('cruds.course.fields.sub_course_photo') }}</label>
                                <input type="file" name="sub_course_photo1" id="sub_course_photo1" class="form-control" accept="image/*">
                                @if($errors->has('sub_course_photo'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('sub_course_photo') }}
                                    </div>
                                @endif
                                <span class="help-block sub_course_photo_error text-danger">{{ trans('cruds.course.fields.sub_course_photo_helper') }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            <div class="form-group mt-3">
                <button class="btn btn-success mt-2" type="submit" id="save">
                    {{ trans('global.save') }}
                </button>
                <button onclick="location='{{route('admin.courses.index')}}'" class="btn btn-secondary mt-2" type="button" id="cancel">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('.select2').select2();
        })
        
        var btnCount = 1;
        var sub_course_count = 1;
        $(document).on('click', '.add-sub-course', function() {
            ++btnCount
            ++sub_course_count;;
            $('#particular_count').val(btnCount);
            var html = ` <div class="row mt-3" id="row${btnCount}">
                        
                        <input type="hidden" name="sub_course_count" value="${sub_course_count}" />

                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="sub-course">{{ trans('cruds.course.fields.sub_course') }}</label>
                                <input type="text" name="sub_course${btnCount}" class="form-control sub_course" required>
                            </div>
                            <span class="help-block fst-italic sub_course${btnCount}_error"></span>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="sub_course_price">{{ trans('cruds.course.fields.price') }}</label>
                                <input type="text" class="form-control sub_course_price" name="sub_course_price${btnCount}">
                            </div>
                            <span class="help-block fst-italic sub_course_price${btnCount}_error"></span>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="sub_course_description1">{{ trans('cruds.course.fields.description') }}</label>
                                <textarea class="form-control ckeditor sub_course_price" name="sub_course_description${btnCount}" id="" rows="1">{!! old('sub_course_description') !!}</textarea>
                            </div>
                            <span class="help-block fst-italic sub_course_description${btnCount}_error"></span>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="teacher_id">{{ trans('cruds.course.fields.teacher') }}</label>
                                <select class="form-control select2 {{ $errors->has('teacher') ? 'is-invalid' : '' }}" name="teacher_id${btnCount}[]" id="teacher${btnCount}" multiple>
                                    <option value="" disabled>{{ trans('global.pleaseSelect') }}</option>
                                    @foreach($teachers as $id => $entry)
                                        <option value="{{ $id }}" {{ old('teacher_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="help-block fst-italic sub_course_description1_error"></span>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                            <div class="d-flex mt-1">
                                <a class="btn px-0 me-1 add-sub-course" id=""><i
                                        class='bx bx-plus text-primary fw-bold fs-4'></i></a>
                                <a class="btn px-0 remove-sub-course"
                                    id="${btnCount}"><i class='bx bx-minus text-danger fw-bold fs-4'></i></a>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="sub_course_photo${btnCount}">{{ trans('cruds.course.fields.sub_course_photo') }}</label>
                                <input type="file" name="sub_course_photo${btnCount}" id="sub_course_photo${btnCount}" class="form-control" accept="image/*">
                                @if($errors->has('sub_course_photo'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('sub_course_photo') }}
                                    </div>
                                @endif
                                <span class="help-block sub_course_photo_error text-danger">{{ trans('cruds.course.fields.sub_course_photo_helper') }}</span>
                            </div>
                        </div>
                    </div>`;
            $('.content').append(html);
            $('.select2').select2();
        });
        $(document).on('click', '.remove-sub-course', function() {
            let length = $('.sub_course').length;
            if (length > 1) {
                let id = $(this).attr('id');
                let row_id = "#row" + id;
                $(row_id).remove();
            } else {
                $('.content').addClass('d-none');
                $('.add_sub_course').removeClass('d-none');
                $('.parent_price').attr('disabled', false);
                $('.teacher').attr('disabled', false);

            }
        })


        $(document).on('click', '.add_sub_course_btn', function() {
            $('.content').removeClass('d-none');
            $('.add_sub_course').addClass('d-none');
            $('.parent_price').val('');
            $('.parent_price').attr('disabled', true);
            $('.teacher').val('');
            $('.teacher').attr('disabled', true);

        })

        $('#save').on('click', function(e) {
            e.preventDefault();
            formValidation();
        })
        function formValidation() {
            let teacher = $('#teacher').val();
            let course_category = $('#course_category').val();
            let title = $('#title').val();
            let description = $('#description').val();
            
            let arr = [];
      
            if (course_category == '') {
                $('.course_category_error').html('Course category must be filled');
                arr.push('course_category');
            } else {
                $('.course_category_error').html('');
                if (arr.includes("course_category")) {
                    arr.splice(arr.indexOf('course_category'), 1);
                }
            }
            if (title == '') {
                $('.title_error').html('Title must be filled');
                arr.push('title');
            } else {
                $('.title_error').html('');
                if (arr.includes("title")) {
                    arr.splice(arr.indexOf('title'), 1);
                }
            }

            if(arr.length == 0){
                $('#form').submit();
            }
            
            
        }
         
    </script>
@endsection