@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.course.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.store.newCourse") }}" enctype="multipart/form-data" id="form">
            @csrf
            <div class="row">
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="course_category_id">{{ trans('cruds.course.fields.course_category') }}</label>
                        <select class="form-control select2 {{ $errors->has('course_category') ? 'is-invalid' : '' }}" name="course_category_id" id="course_category">
                            @foreach($course_categories as $id => $entry)
                                <option value="{{ $id }}" {{ $parent_course->course_category_id == $id ? 'selected' : 'disabled' }}>{{ $entry }}</option>
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
            </div>    
            <div class="row mt-3">
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="required" for="title">{{ trans('cruds.course.fields.title') }}</label>
                        <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ $parent_course->title }}" readonly >
                        @if($errors->has('title'))
                            <div class="invalid-feedback">
                                {{ $errors->first('title') }}
                            </div>
                        @endif
                        <span class="help-block title_error text-danger">{{ trans('cruds.course.fields.title_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-2 ">
                    <div class="form-group">
                        <label for="price">{{ trans('cruds.course.fields.price') }}</label>
                        <input class="parent_price form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ $parent_course->price }}" step="0.01" readonly>
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
                        <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" rows="1" id="description" readonly>{{ $parent_course->description }}</textarea>
                        @if($errors->has('description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.course.fields.description_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="teacher_id">{{ trans('cruds.course.fields.teacher') }}</label>
                        <select class="form-control select2 {{ $errors->has('teacher') ? 'is-invalid' : '' }}" name="teacher_id" id="teacher" disabled>
                            @foreach($teachers as $id => $entry)
                                <option value="{{ $id }}" {{ $parent_course->teacher_id == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                <input type="hidden" name="parent_id" value="{{ $parent_course->id }}">
            </div>
               
                {{-- multi rows  --}}
            <div class="content mt-3">
                <input type="hidden" name="sub_course_count" value="1">
                <div class="row" id="row1">
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
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="sub_course_description1">{{ trans('cruds.course.fields.description') }}</label>
                            <textarea class="form-control ckeditor sub_course_price" name="sub_course_description1" id="" rows="1">{!! old('sub_course_price') !!}</textarea>
                        </div>
                        <span class="help-block fst-italic sub_course_description1_error"></span>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="teacher_id">{{ trans('cruds.course.fields.teacher') }}</label>
                            <select class="form-control select2 {{ $errors->has('teacher') ? 'is-invalid' : '' }}" name="teacher_id1" id="teacher">
                                @foreach($teachers as $id => $entry)
                                    <option value="{{ $id }}" {{ $parent_course->teacher_id == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
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
        var btnCount = 1;
        var sub_course_count = 1;
        $(document).on('click', '.add-sub-course', function() {
            ++btnCount
            ++sub_course_count;;
            $('#particular_count').val(btnCount);
            var html = ` <div class="row mt-2" id="row${btnCount}">
                        
                        <input type="hidden" name="sub_course_count" value="${sub_course_count}" />

                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                            <div class="form-group">
                                <input type="text" name="sub_course${btnCount}" class="form-control sub_course" required>
                            </div>
                            <span class="help-block fst-italic sub_course${btnCount}_error"></span>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control sub_course_price" name="sub_course_price${btnCount}">
                            </div>
                            <span class="help-block fst-italic sub_course_price${btnCount}_error"></span>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                            <div class="form-group">
                                <textarea class="form-control ckeditor sub_course_price" name="sub_course_description${btnCount}" id="" rows="1">{!! old('sub_course_description') !!}</textarea>
                            </div>
                            <span class="help-block fst-italic sub_course_description${btnCount}_error"></span>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                            <div class="form-group">
                                <select class="form-control select2 {{ $errors->has('teacher') ? 'is-invalid' : '' }}" name="teacher_id${btnCount}" id="teacher">
                                    @foreach($teachers as $id => $entry)
                                        <option value="{{ $id }}" {{ $parent_course->teacher_id == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                    </div>`;
            $('.content').append(html);
        });
        $(document).on('click', '.remove-sub-course', function() {
            let length = $('.sub_course').length;
            if (length > 1) {
                let id = $(this).attr('id');
                let row_id = "#row" + id;
                $(row_id).remove();
            } else {
                alert("You can't delete all particulars!");
            }
        })


        $(document).on('click', '.add_sub_course_btn', function() {
            $('.content').removeClass('d-none');
            $('.add_sub_course').addClass('d-none');
            $('.parent_price').attr('disabled', true);
        })


        $('#save').on('click', function(e) {
            e.preventDefault();
            formValidation();
      
        })
        function formValidation() {
            let teacher = $('#teacher').val();
            let course_category = $('#course_category').val();
            let title = $('#title').val();
        
            let arr = [];
            // if (teacher == '') {
            //     $('.teacher_error').html('Teacher must be filled');
            //     arr.push('teacher');
            // } else {
            //     $('.teacher_error').html('');
            //     if (arr.includes("teacher")) {
            //         arr.splice(arr.indexOf('teacher'), 1);
            //     }
            // }
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
          
            // $('.particular').each((element, value) => {
            //     let particular = $(value).val();
            //     let particular_name = $(value).attr('name');
            //     if (particular == '') {
            //         $('.' + particular_name + '_error').html('Particular must be filled');
            //         arr.push('particular');
            //     } else {
            //         $('.' + particular_name + '_error').html('');
            //         if (arr.includes("particular")) {
            //             arr.splice(arr.indexOf('particular'), 1);
            //         }
            //     }
            // });
            if (arr.length == 0) {
                document.getElementById("form").submit();
            }
        }
        
    </script>
@endsection