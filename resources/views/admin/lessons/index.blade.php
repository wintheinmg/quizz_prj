@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="custom-header">
        {{ trans('cruds.lesson.title_singular') }} {{ trans('global.list') }}
        @can('lesson_create')
                <div class="text-end">
                    <a class="btn btn-success" href="{{ route('admin.lessons.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.lesson.title_singular') }}
                    </a>
                    <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                        {{ trans('global.app_csvImport') }}
                    </button>
                    @include('csvImport.modal', ['model' => 'Lesson', 'route' => 'admin.lessons.parseCsvImport'])
                </div>
        @endcan
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Lesson">
                <thead>
                    <tr class="text-nowrap">
                        <th width="10">
                            {{trans('global.no')}}
                        </th>
                        
                        <th>
                            {{ trans('cruds.lesson.fields.course') }}
                        </th>
                        <th>
                            {{ trans('cruds.lesson.fields.title') }}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.lesson.fields.thumbnail') }}
                        </th>
                        <th>
                            {{ trans('cruds.lesson.fields.short_text') }}
                        </th>
                        <th>
                            {{ trans('cruds.lesson.fields.long_text') }}
                        </th>
                        <th>
                            {{ trans('cruds.lesson.fields.video') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.lesson.fields.position') }}
                        </th>
                        <th>
                            {{ trans('cruds.lesson.fields.is_published') }}
                        </th>
                        <th>
                            {{ trans('cruds.lesson.fields.is_free') }}
                        </th>
                        <th>
                            {{trans('global.action')}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lessons as $key => $lesson)
                        <tr data-entry-id="{{ $lesson->id }}" class="text-nowrap">
                            <td>
                                {{$loop->iteration}}
                            </td>
                            {{-- <td>
                                {{ $lesson->id ?? '' }}
                            </td> --}}
                            <td>
                                {{ $lesson->course->title ?? '' }}
                            </td>
                            <td>
                                {{ $lesson->title ?? '' }}
                            </td>
                            <td>
                                @foreach($lesson->thumbnail as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl('thumb') }}">
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                {{ $lesson->short_text ?? '' }}
                            </td>
                            <td>
                                {{ $lesson->long_text ?? '' }}
                            </td>
                            <td>
                                @if($lesson->video)
                                    <a href="{{ $lesson->video->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $lesson->position ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $lesson->is_published ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $lesson->is_published ? 'checked' : '' }}>
                            </td>
                            <td>
                                <span style="display:none">{{ $lesson->is_free ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $lesson->is_free ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('lesson_show')
                                    <a class="p-0 glow"
                                        style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                        href="{{ route('admin.lessons.show', $lesson->id) }}">
                                        <i class='bx bx-show'></i>
                                    </a>
                                @endcan

                                @can('lesson_edit')
                                    <a class="p-0 glow"
                                        style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                        href="{{ route('admin.lessons.edit', $lesson->id) }}">
                                        <i class='bx bx-edit'></i>
                                    </a>
                                @endcan

                                @can('lesson_delete')
                                <form id="orderDelete-{{ $lesson->id }}"
                                    action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST"
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
@can('lesson_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.lessons.massDestroy') }}",
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
  let table = $('.datatable-Lesson:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection