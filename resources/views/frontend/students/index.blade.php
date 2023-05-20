@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('student_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.students.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.student.title_singular') }}
                        </a>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                            {{ trans('global.app_csvImport') }}
                        </button>
                        @include('csvImport.modal', ['model' => 'Student', 'route' => 'admin.students.parseCsvImport'])
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.student.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Student">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.student.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.student.fields.date') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.student.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.student.fields.nrc') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.student.fields.address') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.student.fields.phone_no') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.student.fields.email') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.student.fields.acca_student_no') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.student.fields.subject') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.student.fields.exam_session_period') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.student.fields.old_student') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.student.fields.how_knew_acca') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $key => $student)
                                    <tr data-entry-id="{{ $student->id }}">
                                        <td>
                                            {{ $student->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $student->date ?? '' }}
                                        </td>
                                        <td>
                                            {{ $student->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $student->nrc ?? '' }}
                                        </td>
                                        <td>
                                            {{ $student->address ?? '' }}
                                        </td>
                                        <td>
                                            {{ $student->phone_no ?? '' }}
                                        </td>
                                        <td>
                                            {{ $student->email ?? '' }}
                                        </td>
                                        <td>
                                            {{ $student->acca_student_no ?? '' }}
                                        </td>
                                        <td>
                                            {{ $student->subject ?? '' }}
                                        </td>
                                        <td>
                                            {{ $student->exam_session_period ?? '' }}
                                        </td>
                                        <td>
                                            {{ $student->old_student ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\Student::HOW_KNEW_ACCA_SELECT[$student->how_knew_acca] ?? '' }}
                                        </td>
                                        <td>
                                            @can('student_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.students.show', $student->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('student_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.students.edit', $student->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('student_delete')
                                                <form action="{{ route('frontend.students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
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

        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('student_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.students.massDestroy') }}",
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
  let table = $('.datatable-Student:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection