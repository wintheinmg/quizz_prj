@extends('layouts.frontend')
@section('styles')
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <h4>{{ $courses->first()->course->name ?? 'Course List' }}</h4>
                    </div>

                    <div class="row py-2 px-5">
                        @if (count($courses) != 0)
                            @foreach ($courses as $course)

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 px-1 py-2">
                                <div class="card mb-3" style="max-width: 540px;">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-md-4 col-3">
                                            @if ($course->image != null)
                                                <img src="{{ asset($course->image) }}" alt="" class="img-fluid rounded-start"
                                                    srcset="">
                                            @else
                                                <img src="{{ asset('course.png') }}" alt="" class="img-fluid rounded-start"
                                                    srcset="">
                                            @endif
                                        </div>
                                        <div class="col-md-5 col-9">
                                            <div class="p-2">
                                                <h5 class="card-title">{{ $course->title }}</h5>
                                                <small>{{ $course->price ?? '' }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12 d-flex justify-content-end p-1"
                                            id="join{{ $course->id }}">
                                            @if ($course->parent_course)
                                                <a href="{{ route('frontend.courses.subCourses', $course->id) }}"
                                                    class="btn btn-success join-course text-white"><i
                                                        class='bx bx-chevrons-right'></i>
                                                </a>
                                            @else
                                                @if ($course->course_student)
                                                    @if ($course->joined)
                                                        <span class="text-muted text-nowrap">Joined<i
                                                                class="fa-solid fa-check ms-1"></i></span>
                                                    @else
                                                        <span class="text-muted text-nowrap">Pending<i
                                                                class="fa-solid fa-check ms-1"></i></span>
                                                    @endif
                                                @else
                                                    <a class="btn btn-success join-course text-white my-auto"
                                                        data-course="{{ $course->id }}">{{ trans('cruds.course.fields.join') }}
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                                {{-- <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 px-1 py-2">
                                    <div class="card">
                                        <div class="course-card-body p-3">
                                            <div class="row">
                                                <div
                                                    class="col-xl-9 col-lg-8 col-md-8 col-sm-12 d-flex justify-content-center justify-content-lg-start">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="avatar">
                                                            @if ($course->image != null)
                                                                <img src="{{ asset($course->image) }}" alt=""
                                                                    srcset="">
                                                            @else
                                                                <img src="{{ asset('course.png') }}" alt=""
                                                                    srcset="">
                                                            @endif
                                                        </div>

                                                        <div class="card-info me-2">
                                                            <h5 class="card-title mb-0 me-2">{{ $course->title }}
                                                            </h5>
                                                            <small>{{ $course->price ?? '' }}</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 mt-2 justify-content-center justify-content-lg-start"
                                                    id="join{{ $course->id }}">
                                                    @if ($course->parent_course)
                                                        <a href="{{ route('frontend.courses.subCourses', $course->id) }}"
                                                            class="btn btn-success join-course text-white"><i
                                                                class='bx bx-chevrons-right'></i>
                                                        </a>
                                                    @else
                                                        @if ($course->course_student)
                                                            @if ($course->joined)
                                                                <span class="text-muted text-nowrap">Joined<i
                                                                        class="fa-solid fa-check ms-1"></i></span>
                                                            @else
                                                                <span class="text-muted text-nowrap">Pending<i
                                                                        class="fa-solid fa-check ms-1"></i></span>
                                                            @endif
                                                        @else
                                                            <a class="btn btn-success join-course text-white my-auto"
                                                                data-course="{{ $course->id }}">{{ trans('cruds.course.fields.join') }}
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}


                                <div class="mt-3">
                                    <div class="row">
                                        <div class="offset-10">
                                            {{ $courses->links() }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-warning col-12  fs-5 " role="alert">
                                No courses has been addded yet!
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" onclick="history.back()">
                            <i class='bx bx-chevrons-left'></i> {{ trans('global.back_to_list') }}
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).on('click', '.join-course', function() {
            let courseId = $(this).data('course');
            console.log(courseId);
            $.ajax({
                type: "POST",
                url: "{{ route('user.course-student.joinCourseStudent') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    course_id: courseId
                },
                success: function(data) {
                    $('#join' + courseId).html(
                        `<span class="text-muted">Pending<i class="fa-solid fa-check ms-1"></i></span>`
                    );
                }
            });
        })
    </script>
    @parent
@endsection
