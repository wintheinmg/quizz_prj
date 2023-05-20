@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="custom-header">
            {{ trans('cruds.testResult.title_singular') }} {{ trans('global.list') }}
            @can('test_result_create')
                <div class="text-end">
                    {{-- <a class="btn btn-success" href="{{ route('admin.test-results.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.testResult.title_singular') }}
                    </a>
                    <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                        {{ trans('global.app_csvImport') }}
                    </button> --}}
                    @include('csvImport.modal', [
                        'model' => 'TestResult',
                        'route' => 'admin.test-results.parseCsvImport',
                    ])
                </div>
            @endcan
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-TestResult">
                    <thead>
                        <tr class="text-nowrap">
                            <th width="10">
                                {{ trans('global.no') }}
                            </th>
                            {{-- <th>
                            {{ trans('cruds.testResult.fields.id') }}
                        </th> --}}
                            <th>
                                {{ trans('cruds.testResult.fields.test') }}
                            </th>
                            <th>
                                {{ trans('cruds.testResult.fields.student') }}
                            </th>
                            <th>
                                {{ trans('cruds.testResult.fields.score') }}
                            </th>
                            <th>
                                {{ trans('cruds.testResult.fields.status') }}
                            </th>
                            <th>
                                {{ trans('global.action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($testResults as $key => $testResult)
                            <tr data-entry-id="{{ $testResult->id }}" class="text-nowrap">
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                {{-- <td>
                                {{ $testResult->id ?? '' }}
                            </td> --}}
                                <td>
                                    {{ $testResult->test->title ?? '' }}
                                </td>
                                <td>
                                    {{ $testResult->student->name ?? '' }}
                                </td>
                                <td>
                                    {{ $testResult->score ?? '' }}
                                </td>
                                <td>
                                    @if (!App\Helpers\helper::checkFinishedTest($testResult->id))
                                        @if(\App\Helpers\helper::isTestExpired($testResult->end_time))
                                            <span class="text-danger">Cancel</span>
                                        @else
                                            <span class="text-info">Continue</span>
                                        @endif
                                    @else
                                        @if ($testResult->test->pass_score > $testResult->score)
                                            <span class="text-danger">Fail</span>
                                        @else
                                            <span class="text-success">Pass</span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @can('test_result_show')
                                        <a class="p-0 glow"
                                            style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                            href="{{ route('admin.test-result.show.print', ['test_id' => $testResult->test_id, 'student_id' => $testResult->student->id]) }}">
                                            <i class='bx bxs-printer'></i>
                                        </a>
                                    @endcan
                                    @can('test_result_show')
                                        <a class="p-0 glow"
                                            style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                            href="{{ route('admin.test-result.show.detail', ['test_id' => $testResult->test_id, 'student_id' => $testResult->student->id]) }}">
                                            <i class='bx bx-show
                                            @if ($testResult->is_seen)
                                                text-success
                                            @else
                                                text-danger
                                            @endif'></i>
                                        </a>
                                    @endcan

                                    {{-- @can('test_result_edit')
                                        <a class="p-0 glow"
                                            style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                            href="{{ route('admin.test-results.edit', $testResult->id) }}">
                                            <i class='bx bx-edit'></i>
                                        </a>
                                    @endcan

                                    @can('test_result_delete')
                                        <form id="orderDelete-{{ $testResult->id }}"
                                            action="{{ route('admin.test-results.destroy', $testResult->id) }}" method="POST"
                                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
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
                                    @endcan --}}

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
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('test_result_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.test-results.massDestroy') }}",
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
                // order: [
                //     [1, 'desc']
                // ],
                pageLength: 100,
            });
            let table = $('.datatable-TestResult:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
