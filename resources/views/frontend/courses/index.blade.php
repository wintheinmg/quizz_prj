@extends('layouts.frontend')
@section('styles')
    <style>
        .course-card-body {
            flex: 1 1 auto !important;
            padding: 1.375rem 1.375rem !important;
            height: 100px !important;
            min-height: 100px !important;
            max-height: 100px !important;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('course_create')
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            {{-- <a class="btn btn-success" href="{{ route('frontend.courses.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.course.title_singular') }}
                        </a>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                            {{ trans('global.app_csvImport') }}
                        </button> --}}
                            @include('csvImport.modal', [
                                'model' => 'Course',
                                'route' => 'admin.courses.parseCsvImport',
                            ])
                        </div>
                    </div>
                @endcan

                <div class="card">
                    <div class="card-header">
                        <h4>{{ trans('cruds.course.title') }} {{ trans('global.list') }}</h4>
                    </div>

                    <div class="row py-2 px-5">
                        @if (count($course_categories) != 0)
                            @foreach ($course_categories as $course_category)
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 px-1 py-2">
                                    <div class="card mb-3" style="max-width: 540px;">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-md-4 col-4">
                                                <img src="{{ asset('course.png') }}" class="img-fluid rounded-start"
                                                    alt="...">
                                            </div>
                                            <div class="col-md-5 col-5">
                                                <h5 class="card-title p-2">{{ $course_category->name }}</h5>
                                            </div>
                                            <div class="col-md-3 col-3">
                                                <a href="{{ route('frontend.courses.subCategories', $course_category->id) }}"
                                                    class="btn btn-success btn-sm join-course text-white my-auto"><i
                                                        class='bx bx-chevrons-right'></i>
                                                </a>
                                            </div>
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

                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    {{-- <script>
        $(document).on('click', '.join-course', function() {
            let courseId = $(this).data('course');
            // console.log(courseId);
            $.ajax({
                type: "POST",
                url: "{{ route('user.course-student.joinCourseStudent') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    course_id: courseId,
                    user_id: {{ Auth::user()->id }}
                },
                success: function(data) {
                    $('#join' + courseId).html(
                        `<span class="text-muted">Pending<i class="fa-solid fa-check ms-1"></i></span>`
                    );
                }
            });
        })
    </script> --}}
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('course_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('frontend.courses.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            let table = $('.datatable-Course:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
