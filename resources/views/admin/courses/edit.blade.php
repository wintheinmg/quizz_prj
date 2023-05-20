@extends('layouts.admin')
@section('content')

@section('styles')
<style>
    .swal2-container, .swal2-center, .swal2-backdrop-show {
        z-index: 9999 !important;
    }
</style>
@endsection

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.course.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.courses.update", [$course->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="course_category_id">{{ trans('cruds.course.fields.course_category') }}</label>
                        <select class="form-control select2 {{ $errors->has('course_category') ? 'is-invalid' : '' }}" name="course_category_id" id="course_category_id">
                            @foreach($course_categories as $id => $entry)
                                <option value="{{ $id }}" {{ (old('course_category_id') ? old('course_category_id') : $course->course_category->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('course_category'))
                            <div class="invalid-feedback">
                                {{ $errors->first('course_category') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.course.fields.course_category_helper') }}</span>
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
                        <label class="required" for="title">@if($parent_title != '') {{ trans('cruds.course.fields.sub_course') }} @else {{ trans('cruds.course.fields.title') }} @endif </label>
                        <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $course->title) }}" required>
                        @if($errors->has('title'))
                            <div class="invalid-feedback">
                                {{ $errors->first('title') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="price">{{ trans('cruds.course.fields.price') }}</label>
                        <input class="form-control parent_price {{ $errors->has('price') ? 'is-invalid' : '' }}" @if(count($sub_courses) != 0) disabled @endif type="number" name="price" id="price" value="{{ old('price', $course->price) }}" step="0.01">
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
                        <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" rows="1" name="description" id="description" >{{ old('description', $course->description) }}</textarea>
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
                        <select class="form-control teacher select2 {{ $errors->has('teacher') ? 'is-invalid' : '' }}" name="teacher_id[]" id="teacher_id" @if(count($sub_courses) != 0) disabled @endif multiple>
                            <option value="" disabled>Choose Teacher</option>
                            @foreach($teachers as $id => $entry)
                                <option value="{{ $id }}" {{ ($course->teacher->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('teacher'))
                            <div class="invalid-feedback">
                                {{ $errors->first('teacher') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.course.fields.teacher_helper') }}</span>
                    </div>
                </div>

                @if(count($sub_courses) != 0)
                    <div class="content mt-3">
                            @for($i = 0; $i < count($sub_courses); $i++)
                            <input type="hidden" name="sub_course_count" value="{{count($sub_courses)}}">
                            <input type="hidden" name="sub_course_id{{$i}}" value="{{ $sub_courses[$i]->id }}">
                            <div class="row" id="row0">
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label for="sub-course"> {{ trans('cruds.course.fields.sub_course') }} </label>
                                        <input type="text" name="sub_course{{$i}}" class="form-control sub_course" value="{{ $sub_courses[$i]->title }}">
                                    </div>
                                    <span class="help-block fst-italic sub-course0_error"></span>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label for="sub_course_price"> {{ trans('cruds.course.fields.price') }} </label>
                                        <input type="text" class="form-control " name="sub_course_price{{$i}}" value="{{ $sub_courses[$i]->price }}">
                                    </div>
                                    <span class="help-block fst-italic sub_course_price1_error"></span>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label for="sub_course_description1"> {{ trans('cruds.course.fields.description') }} </label>
                                        <textarea class="form-control ckeditor sub_course_price" name="sub_course_description{{$i}}" id="" rows="1">{{ $sub_courses[$i]->description }}</textarea>
                                    </div>
                                    <span class="help-block fst-italic sub_course_description1_error"></span>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label for="teacher_id"> {{ trans('cruds.course.fields.teacher') }} </label>
                                        <select class=" form-control select2 {{ $errors->has('teacher') ? 'is-invalid' : '' }}" name="sub_course_teacher_id{{$i}}[]" id="teacher{{$i}}" multiple>
                                            @foreach($teachers as $id => $entry)
                                                <option value="{{ $id }}" {{ $sub_courses[$i]->teachers->contains($id) ? 'selected' : '' }}>{{ $entry }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="help-block fst-italic sub_course_description1_error"></span>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                                    <div class="d-flex mt-4">
                                        <a class="btn px-0 me-1 add-sub-course" id=""><i
                                                class='bx bx-plus text-primary fw-bold fs-4'></i></a>
                                        <a class="btn px-0 remove-sub-course" id="0" data-id={{$sub_courses[$i]->id}}><i
                                                class='bx bx-minus text-danger fw-bold fs-4'></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label for="sub_course_photo1">{{ trans('cruds.course.fields.sub_course_photo') }}</label>
                                        <input type="file" name="sub_course_photo{{$i}}" id="sub_course_photo{{$i}}" class="form-control" accept="image/*">
                                        @if($errors->has('sub_course_photo'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('sub_course_photo') }}
                                            </div>
                                        @endif
                                        <span class="help-block sub_course_photo_error text-danger">{{ trans('cruds.course.fields.sub_course_photo_helper') }}</span>
                                    </div>
                                </div>
        
                            </div>
        
                            @endfor
                        </div>
                @else 
                {{-- if no sub courses  --}}
                    <div class="content mt-3 d-none">
                        <input type="hidden" name="new_sub_course_count" value="0">
                        <input type="hidden" name="status" value="sub_course_start">
                        <div class="row" id="row0">
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="sub-course">{{ trans('cruds.course.fields.sub_course') }}</label>
                                    <input type="text" name="new_sub_course0" class="form-control sub_course" >
                                </div>
                                <span class="help-block fst-italic sub-course0_error"></span>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="sub_course_price">{{ trans('cruds.course.fields.price') }}</label>
                                    <input type="text" class="form-control " name="new_sub_course_price0">
                                </div>
                                <span class="help-block fst-italic sub_course_price1_error"></span>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="sub_course_description1">{{ trans('cruds.course.fields.description') }}</label>
                                    <textarea class="form-control ckeditor sub_course_price" name="new_sub_course_description0" id="" rows="1">{!! old('sub_course_price') !!}</textarea>
                                </div>
                                <span class="help-block fst-italic sub_course_description1_error"></span>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="teacher_id">{{ trans('cruds.course.fields.teacher') }}</label>
                                    <select class=" form-control select2 {{ $errors->has('teacher') ? 'is-invalid' : '' }}" name="new_teacher_id0[]" id="teacher0" multiple>
                                        @foreach($teachers as $id => $entry)
                                            <option value="{{ $id }}" {{ old('teacher_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="sub_course_photo0">{{ trans('cruds.course.fields.sub_course_photo') }}</label>
                                <input type="file" name="new_sub_course_photo0" id="sub_course_photo0" class="form-control" accept="image/*">
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

                @endif


            @if(count($sub_courses) == 0)
                <div class="row add_sub_course mt-3">
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary add_sub_course_btn">Add Sub Course</button>
                    </div>
                </div>
            @endif
                
            </div>
            <div class="form-group">
                <button class="btn btn-success mt-2" type="submit">
                    {{ trans('global.save') }}
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
    $(document).ready(function() {
        var btnCount = 0;
        var sub_course_count = 0;
        $(document).on('click', '.add-sub-course', function() {
            ++btnCount
            ++sub_course_count;;
            $('#particular_count').val(btnCount);
            var html = ` <div class="row mt-3" id="row${btnCount}">
                        
                        <input type="hidden" name="new_sub_course_count" value="${sub_course_count}" />

                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                            <div class="form-group">
                                 <label for="sub-course">{{ trans('cruds.course.fields.sub_course') }}</label>
                                <input type="text" name="new_sub_course${btnCount}" class="form-control sub_course" required>
                            </div>
                            <span class="help-block fst-italic sub_course${btnCount}_error"></span>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="sub_course_price">{{ trans('cruds.course.fields.price') }}</label>
                                <input type="text" class="form-control sub_course_price" name="new_sub_course_price${btnCount}">
                            </div>
                            <span class="help-block fst-italic sub_course_price${btnCount}_error"></span>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="sub_course_description1">{{ trans('cruds.course.fields.description') }}</label>
                                <textarea class="form-control ckeditor sub_course_price" name="new_sub_course_description${btnCount}" id="" rows="1">{!! old('sub_course_description') !!}</textarea>
                            </div>
                            <span class="help-block fst-italic sub_course_description${btnCount}_error"></span>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="teacher_id">{{ trans('cruds.course.fields.teacher') }}</label>
                                <select class="form-control select2 {{ $errors->has('teacher') ? 'is-invalid' : '' }}" name="new_teacher_id${btnCount}[]" id="teacher" multiple>
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
                                <input type="file" name="new_sub_course_photo${btnCount}" id="sub_course_photo${btnCount}" class="form-control" accept="image/*">
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
            --btnCount
            --sub_course_count;;

            var id = $(this).data('id') ?? 'no-id';

            if(id == 'no-id') {
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
            } else {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type : 'post',
                                url : "{{ route('admin.delete.course') }}",
                                data : {
                                    id : id,
                                    _token : "{{csrf_token()}}",
                                },
                                success : function(res) {
                                    location.reload();
                                }
                            })
                        }
                    })
                
            }
        })

        $(document).on('click', '.add_sub_course_btn', function() {
            $('.content').removeClass('d-none');
            $('.add_sub_course').addClass('d-none');
            $('.parent_price').val('');
            $('.parent_price').attr('disabled', true);
            $('.teacher').html('');
            $('.teacher').attr('disabled', true);

        })
    })
















    var uploadedThumbnailMap = {}
Dropzone.options.thumbnailDropzone = {
    url: '{{ route('admin.courses.storeMedia') }}',
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