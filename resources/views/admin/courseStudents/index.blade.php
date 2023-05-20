@extends('layouts.admin')
@section('styles')
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
        <div class="custom-header">
            {{ trans('cruds.courseStudent.title_singular') }} {{ trans('global.list') }}
            {{-- @can('course_student_create')
        <div class="text-end">
            <a class="btn btn-success" href="{{ route('admin.course-students.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.courseStudent.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'CourseStudent', 'route' => 'admin.course-students.parseCsvImport'])
        </div>
        @endcan --}}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-CourseStudent">
                    <thead>
                        <tr class="text-nowrap">
                            <th width="10">
                                {{ trans('global.no') }}
                            </th>
                            {{-- <th>
                            {{ trans('cruds.courseStudent.fields.id') }}
                        </th> --}}
                            <th>
                                {{ trans('cruds.courseStudent.fields.course') }}
                            </th>
                            <th>
                                {{ trans('cruds.courseStudent.fields.student') }}
                            </th>
                            <th>
                                {{ trans('cruds.courseStudent.fields.status') }}
                            </th>
                            <th>
                                {{ trans('cruds.courseStudent.fields.status') }}
                            </th>
                            <th>
                                {{ trans('global.action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courseStudents as $key => $courseStudent)
                            <tr data-entry-id="{{ $courseStudent->id }}" class="text-nowrap">
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                {{-- <td>
                                {{ $courseStudent->id ?? '' }}
                            </td> --}}
                                <td>
                                    {{ $courseStudent->course->title ?? '' }}
                                </td>
                                <td>
                                    {{ $courseStudent->student->name ?? '' }}
                                </td>
                                <td>

                                    @if ($courseStudent->status == 0)
                                        Pending
                                    @else
                                        Joined
                                    @endif
                                </td>

                                <td>
                                    <a href="javascript:void(0)" class="">
                                        <label class="switch switch-success">
                                            <input type="checkbox" name="status" value=""
                                                class="switch-input switchStatus change-status"
                                                data-courseStudentId="{{ $courseStudent->id }}"
                                                id="switchStatus{{ $courseStudent->id }}"
                                                @if ($courseStudent->status == '0') unchecked
                                        @else
                                            checked  disabled @endif>
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on">
                                                    <i class="bx bx-check"></i>
                                                </span>
                                                <span class="switch-off">
                                                    <i class="bx bx-x"></i>
                                                </span>
                                            </span>
                                        </label>
                                    </a>
                                </td>

                                <td>
                                    @can('course_student_show')
                                        <a class="p-0 glow"
                                            style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                            href="{{ route('admin.course-students.show', $courseStudent->id) }}">
                                            <i class='bx bx-show'></i>
                                        </a>
                                    @endcan

                                    @can('course_student_edit')
                                        <a class="p-0 glow"
                                            style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                            href="{{ route('admin.course-students.edit', $courseStudent->id) }}">
                                            <i class='bx bx-edit'></i>
                                        </a>
                                    @endcan

                                    @can('course_student_delete')
                                        <form id="orderDelete-{{ $courseStudent->id }}"
                                            action="{{ route('admin.course-students.destroy', $courseStudent->id) }}"
                                            method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden"
                                                style="width: 26px;height: 36px;display: inline-block;line-height: 36px;"
                                                class=" p-0 glow" value="{{ trans('global.delete') }}">
                                            <button
                                                style="width: 26px;height: 36px;display: inline-block;line-height: 36px;border:none;color:grey;background:none;"
                                                class=" p-0 glow">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    @endcan



                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>
    <script>
        $('.change-status').on('change', function() {
            let courseStudentId = parseInt($(this).attr('id').replace('switchStatus', ''));
            $.ajax({
                type: "POST",
                url: "{{ route('admin.course-students.change-status') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    course_student_id: courseStudentId
                },
                success: function(data) {
                    var switchStatusId = '#switchStatus' + courseStudentId;
                    $(switchStatusId).attr('disabled', 'disabled');
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: `${data}`
                    })
                    $('.swal2-confirm').on('click',function(){
                        location.href = '/admin/course-students';
                    })
                }
            });

            // $('.switch-input').each(function(i,obj){
            //         if($(obj).is(':checked')){

            //             if($(obj).attr('id') != $(e.target).attr('id')){
            //                 $(obj).prop('checked',false);
            //             }
            //         }
            // })

        })
    </script>
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('course_student_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.course-students.massDestroy') }}",
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
            let table = $('.datatable-CourseStudent:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
