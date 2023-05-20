@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="custom-header">
            {{ trans('cruds.question.title_singular') }} {{ trans('global.list') }}
            @can('question_create')
                <div class="text-end">
                    <a class="btn btn-success" href="{{ route('admin.questions.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.question.title_singular') }}
                    </a>
                </div>
            @endcan
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Question">
                    <thead>
                        <tr class="text-nowrap">
                            <th width="10">
                                {{ trans('global.no') }}
                            </th>
                            {{-- <th>
                            {{ trans('cruds.question.fields.id') }}
                        </th> --}}
                            <th>
                                {{ trans('cruds.question.fields.test') }}
                            </th>
                            <th>
                                {{ trans('cruds.question.fields.question_text') }}
                            </th>
                            <th>
                                {{ trans('cruds.question.fields.question_image') }}
                            </th>
                            <th>
                                {{ trans('cruds.question.fields.points') }}
                            </th>
                            <th>
                                {{ trans('global.action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $key => $question)
                            <tr data-entry-id="{{ $question->id }}" class="text-nowrap">
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                {{-- <td>
                                {{ $question->id ?? '' }}
                            </td> --}}
                                <td>
                                    {{ $question->test->title ?? '' }}
                                </td>
                                <td>
                                    {{ $question->question_text ?? '' }}
                                </td>
                                <td>
                                    @php
                                        if ($question->question_image) {
                                            $src = 'storage/' . $question->question_image->id . '/' . $question->question_image->file_name;
                                        } else {
                                            $src = 'storage/gallery.svg';
                                        }
                                    @endphp
                                    <img src="{{ asset($src) }}" style="aspect-ratio:1;object-fit:cover;width:80px"
                                        id="change-photo{{ $question->id }}" class="rounded" title="" />
                                </td>
                                <td>
                                    {{ $question->points ?? '' }}
                                </td>
                                <td>
                                    @can('question_show')
                                        <a class="p-0 glow"
                                            style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                            href="{{ route('admin.questions.show', $question->id) }}">
                                            <i class='bx bx-show'></i>
                                        </a>
                                    @endcan

                                    @can('question_edit')
                                        <a class="p-0 glow"
                                            style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                            href="{{ route('admin.questions.edit', $question->id) }}">
                                            <i class='bx bx-edit'></i>
                                        </a>
                                    @endcan

                                    @can('question_delete')
                                        <form id="orderDelete-{{ $question->id }}"
                                            action="{{ route('admin.questions.destroy', $question->id) }}" method="POST"
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
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('question_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.questions.massDestroy') }}",
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
            let table = $('.datatable-Question:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
