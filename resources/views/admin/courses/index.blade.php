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
    <div class="custom-header">
        {{ trans('cruds.course.title_singular') }} {{ trans('global.list') }}
        @can('course_create')
        <div class="text-end">
            <a class="btn btn-success" href="{{ route('admin.courses.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.course.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Course', 'route' => 'admin.courses.parseCsvImport'])
        </div>
        @endcan
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Course">
                <thead>
                    <tr class="text-nowrap">
                       <th>
                        {{trans('global.no')}}
                       </th>
                        {{-- <th>
                            {{ trans('cruds.course.fields.teacher') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.course.fields.course_category') }}
                        </th>
                        <th>
                            {{ trans('cruds.course.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.course.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.course.fields.price') }}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.course.fields.thumbnail') }}
                        </th>
                        <th>
                            {{ trans('cruds.course.fields.is_published') }}
                        </th> --}}
                        <th>
                            {{trans('global.action')}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $key => $course)
                        <tr data-entry-id="{{ $course->id }}" class="text-nowrap">

                            {{-- <td>
                                {{ ucwords($course->teacher->name ?? '') }}
                            </td> --}}
                            <td>
                                {{$loop->iteration}}
                            </td>
                            <td>
                                {{ strtoupper($course->course_category->name ?? '') }}
                            </td>
                            <td>
                                {{ ucwords($course->title ?? '') }}
                            </td>
                            <td>
                                {{ ucwords($course->description ?? '') }}
                            </td>
                            <td>
                                {{ $course->price ?? '' }}
                            </td>
                            <td>
                                @can('course_show')

                                    <a class="p-0 glow"
                                        style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                        href="{{ route('admin.courses.show', $course->id) }}">
                                        <i class='bx bx-show'></i>
                                    </a>
                                @endcan

                                @can('course_edit')
                                    <a class="p-0 glow"
                                            style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                            href="{{ route('admin.courses.edit', $course->id) }}">
                                            <i class='bx bx-edit'></i>
                                        </a>
                                @endcan

                                @can('course_delete')
                                    <button
                                        style="width: 26px;height: 36px;display: inline-block;line-height: 36px;border:none;color:grey;background:none;"
                                        class=" p-0 glow delete-btn" data-id={{$course->id}}
                                        >
                                        <i class="bx bx-trash"></i>
                                    </button>
                                    {{-- <form id="orderDelete-{{ $course->id }}"
                                          action="{{ route('admin.courses.destroy', $course->id) }}" method="POST"
                                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden"
                                                style="width: 26px;height: 36px;display: inline-block;line-height: 36px;"
                                                class=" p-0 glow" value="{{ trans('global.delete') }}">
                                            <button
                                                style="width: 26px;height: 36px;display: inline-block;line-height: 36px;border:none;color:grey;background:none;"
                                                class=" p-0 glow delete-btn" data-id={{$course->id}}
                                                onclick="event.preventDefault(); document.getElementById('orderDelete-{{ $course->id }}').submit();">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form> --}}
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
@parent
<script>
    $(document).ready(function() {
        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');
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
                                url : "{{ route('admin.courses.massDestroy') }}",
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
        })
    })



    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('course_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.courses.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 0, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Course:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
