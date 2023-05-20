@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="custom-header">
        {{ trans('cruds.auditLog.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-AuditLog">
                <thead>
                    <tr class="text-nowrap">
                        <th width="10">
                            {{trans('global.no')}}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.auditLog.fields.id') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.auditLog.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.auditLog.fields.subject_id') }}
                        </th>
                        <th>
                            {{ trans('cruds.auditLog.fields.subject_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.auditLog.fields.user_id') }}
                        </th>
                        <th>
                            {{ trans('cruds.auditLog.fields.host') }}
                        </th>
                        <th>
                            {{ trans('cruds.auditLog.fields.created_at') }}
                        </th>
                        <th>
                            {{trans('global.action')}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($auditLogs as $key => $auditLog)
                        <tr data-entry-id="{{ $auditLog->id }}" class="text-nowrap">
                            <td>
                                {{$loop->iteration}}
                            </td>
                            {{-- <td>
                                {{ $auditLog->id ?? '' }}
                            </td> --}}
                            <td>
                                {{ $auditLog->description ?? '' }}
                            </td>
                            <td>
                                {{ $auditLog->subject_id ?? '' }}
                            </td>
                            <td>
                                {{ $auditLog->subject_type ?? '' }}
                            </td>
                            <td>
                                {{ $auditLog->user_id ?? '' }}
                            </td>
                            <td>
                                {{ $auditLog->host ?? '' }}
                            </td>
                            <td>
                                {{ $auditLog->created_at ?? '' }}
                            </td>
                            <td>
                                @can('audit_log_show')
                                    
                                    <a class="p-0 glow"
                                    style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                    href="{{ route('admin.audit-logs.show', $auditLog->id) }}">
                                    <i class='bx bx-show'></i>
                            </a>
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
  
  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-AuditLog:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection