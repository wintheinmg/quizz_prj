@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="custom-header">
        {{ trans('cruds.teacher.title_singular') }} {{ trans('global.list') }}
        @can('teacher_create')

                <div class="text-end">
                    <a class="btn btn-success" href="{{ route('admin.teachers.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.teacher.title_singular') }}
                    </a>
                    <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                        {{ trans('global.app_csvImport') }}
                    </button>
                    @include('csvImport.modal', ['model' => 'Teacher', 'route' => 'admin.teachers.parseCsvImport'])
                </div>
            
        @endcan
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Teacher">
                <thead>
                    <tr class="text-nowrap">
                        <th width="10">
                            {{trans('global.no')}}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.teacher.fields.id') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.teacher.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.teacher.fields.date_of_birth') }}
                        </th>
                        <th>
                            {{ trans('cruds.teacher.fields.age') }}
                        </th>
                        <th>
                            {{ trans('cruds.teacher.fields.parent_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.teacher.fields.nation_and_religion') }}
                        </th>
                        <th>
                            {{ trans('cruds.teacher.fields.nrc') }}
                        </th>
                        <th>
                            {{ trans('cruds.teacher.fields.contact_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.teacher.fields.start_date_of_employment') }}
                        </th>
                        <th>
                            {{ trans('cruds.teacher.fields.certificate_files') }}
                        </th>
                        <th>
                            {{trans('global.action')}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $key => $teacher)
                        <tr data-entry-id="{{ $teacher->id }}" class="text-nowrap">
                            <td>
                                {{$loop->iteration}}
                            </td>
                            {{-- <td>
                                {{ $teacher->id ?? '' }}
                            </td> --}}
                            <td>
                                {{ $teacher->name ?? '' }}
                            </td>
                            <td>
                                {{ $teacher->date_of_birth ?? '' }}
                            </td>
                            <td>
                                {{ $teacher->age ?? '' }}
                            </td>
                            <td>
                                {{ $teacher->parent_name ?? '' }}
                            </td>
                            <td>
                                {{ $teacher->nation_and_religion ?? '' }}
                            </td>
                            <td>
                                {{ $teacher->nrc ?? '' }}
                            </td>
                            <td>
                                {{ $teacher->contact_no ?? '' }}
                            </td>
                            <td>
                                {{ $teacher->start_date_of_employment ?? '' }}
                            </td>
                            <td>
                                @foreach($teacher->certificate_files as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                @can('teacher_show')
                                    <a class="p-0 glow"
                                            style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                            href="{{ route('admin.teachers.show', $teacher->id) }}">
                                            <i class='bx bx-show'></i>
                                    </a>
                                @endcan

                                @can('teacher_edit')
                                    <a class="p-0 glow"
                                        style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                        href="{{ route('admin.teachers.edit', $teacher->id) }}">
                                        <i class='bx bx-edit'></i>
                                    </a>
                                @endcan

                                @can('teacher_delete')
                                   
                                    <form id="orderDelete-{{ $teacher->id }}"
                                    action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST"
                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                        style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden"
                                            style="width: 26px;height: 36px;display: inline-block;line-height: 36px;"
                                            class=" p-0 glow" value="{{ trans('global.delete') }}">
                                        <button
                                            style="width: 26px;height: 36px;display: inline-block;line-height: 36px;border:none;color:grey;background:none;"
                                            class=" p-0 glow"
                                            >
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
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('teacher_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.teachers.massDestroy') }}",
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
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Teacher:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection