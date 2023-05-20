@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="custom-header">
        {{ trans('cruds.testAnswer.title_singular') }} {{ trans('global.list') }}
        @can('test_answer_create')

                <div class="text-end">
                    <a class="btn btn-success" href="{{ route('admin.test-answers.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.testAnswer.title_singular') }}
                    </a>
                    <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                        {{ trans('global.app_csvImport') }}
                    </button>
                    @include('csvImport.modal', ['model' => 'TestAnswer', 'route' => 'admin.test-answers.parseCsvImport'])
                </div>
            
        @endcan
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-TestAnswer">
                <thead>
                    <tr class="text-nowrap">
                        <th width="10">
                            {{trans('global.no')}}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.testAnswer.fields.id') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.testAnswer.fields.test_result') }}
                        </th>
                        <th>
                            {{ trans('cruds.testAnswer.fields.question') }}
                        </th>
                        <th>
                            {{ trans('cruds.testAnswer.fields.option') }}
                        </th>
                        <th>
                            {{ trans('cruds.testAnswer.fields.is_correct') }}
                        </th>
                        <th>
                            {{trans('global.action')}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($testAnswers as $key => $testAnswer)
                        <tr data-entry-id="{{ $testAnswer->id }}" class="text-nowrap">
                            <td>
                                {{$loop->iteration}}
                            </td>
                            {{-- <td>
                                {{ $testAnswer->id ?? '' }}
                            </td> --}}
                            <td>
                                {{ $testAnswer->test_result->score ?? '' }}
                            </td>
                            <td>
                                {{ $testAnswer->question->question_text ?? '' }}
                            </td>
                            <td>
                                {{ $testAnswer->option->option_text ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $testAnswer->is_correct ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $testAnswer->is_correct ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('test_answer_show')
                                    <a class="p-0 glow"
                                            style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                            href="{{ route('admin.test-answers.show', $testAnswer->id) }}">
                                            <i class='bx bx-show'></i>
                                    </a>
                                @endcan

                                @can('test_answer_edit')
                                    
                                    <a class="p-0 glow"
                                        style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                        href="{{ route('admin.test-answers.edit', $testAnswer->id) }}">
                                        <i class='bx bx-edit'></i>
                                    </a>
                                @endcan

                                @can('test_answer_delete')
                                    
                                    <form id="orderDelete-{{ $testAnswer->id }}"
                                    action="{{ route('admin.test-answers.destroy', $testAnswer->id) }}" method="POST"
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
@can('test_answer_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.test-answers.massDestroy') }}",
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
  let table = $('.datatable-TestAnswer:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection