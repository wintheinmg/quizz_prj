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
            {{ trans('cruds.test.title_singular') }} {{ trans('global.list') }}
            @can('test_create')
                <div class="text-end">
                    <a class="btn btn-success" href="{{ route('admin.tests.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.test.title_singular') }}
                    </a>
                    <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                        {{ trans('global.app_csvImport') }}
                    </button>
                    @include('csvImport.modal', [
                        'model' => 'Test',
                        'route' => 'admin.tests.parseCsvImport',
                    ])
                </div>
            @endcan
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Test">
                    <thead>
                        <tr class="text-nowrap">
                            <th width="10">
                                {{ trans('global.no') }}
                            </th>
                            {{-- <th>
                            {{ trans('cruds.test.fields.id') }}
                        </th> --}}
                            <th>
                                {{ trans('cruds.test.fields.course') }}
                            </th>
                            <th>
                                {{ trans('cruds.test.fields.title') }}
                            </th>
                            <th>
                                {{ trans('cruds.test.fields.is_published') }}
                            </th>
                            <th>
                                {{ trans('cruds.test.fields.duration') }}
                            </th>
                            <th>
                                {{ trans('cruds.test.fields.pass_score') }}
                            </th>
                            <th>
                                {{ trans('cruds.test.fields.questions') }}
                            </th>
                            <th>
                                {{ trans('cruds.test.fields.description') }}
                            </th>
                            <th>
                                {{ trans('global.action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tests as $key => $test)
                            <tr data-entry-id="{{ $test->id }}" class="text-nowrap">
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                {{-- <td>
                                {{ $test->id ?? '' }}
                            </td> --}}
                                <td>
                                    {{ $test->course->title ?? '' }}
                                </td>
                                <td>
                                    {{ $test->title ?? '' }}
                                </td>
                                <td>
                                    {{-- <span style="display:none">{{ $test->is_published ?? '' }}</span>
                                    <input type="checkbox" disabled="disabled" {{ $test->is_published ? 'checked' : '' }}> --}}
                                    <a href="javascript:void(0)" class="">
                                        <label class="switch switch-success">
                                            <input type="checkbox" name="status" value=""
                                                class="switch-input switchStatus change-status"
                                                data-userId="{{ $test->id }}"
                                                id="switchStatus{{ $test->id }}"
                                                data-isPublished="{{ $test->is_published }}"
                                                data-questionCount="{{ \App\Helpers\helper::getquestionsCount($test->id) }}"
                                                @if ($test->is_published == '0') 
                                                    unchecked
                                                @else
                                                    checked  
                                                @endif>
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
                                <td class="text-nowrap">
                                    {{ $test->duration ?? '' }} {{ trans('global.minutes') }}
                                </td>
                                <td class="text-nowrap">
                                    {{ $test->pass_score ?? '0' }}
                                </td>
                                
                                <td class="text-nowrap">
                                    {{ $test->questions ? count($test->questions) : '0' }}
                                </td>
                                <td>
                                    {{ $test->description ?? '' }}
                                </td>
                                <td>
                                    @can('test_show')
                                        <a class="p-0 glow"
                                            style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                            href="{{ route('admin.tests.show', $test->id) }}">
                                            <i class='bx bx-show'></i>
                                        </a>
                                    @endcan

                                    @can('test_edit')
                                        <a class="p-0 glow"
                                            style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                            href="{{ route('admin.tests.edit', $test->id) }}">
                                            <i class='bx bx-edit'></i>
                                        </a>
                                    @endcan

                                    @can('test_delete')
                                        <form id="orderDelete-{{ $test->id }}"
                                            action="{{ route('admin.tests.destroy', $test->id) }}" method="POST"
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>
    <script>
        $('.change-status').on('change', function() {
            let id = parseInt($(this).attr('id').replace('switchStatus', ''));
            var switchStatusId = '#switchStatus' + id;
            let questionCount = parseInt($(switchStatusId).attr('data-questionCount'));
            let is_published = $(switchStatusId).attr('data-isPublished');
            if(questionCount == 0 && is_published == '0'){
                Swal.fire({
                    title: 'Are you sure? There is no question in this test!',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    customClass: {
                        actions: 'my-actions',
                        cancelButton: 'order-1 right-gap',
                        confirmButton: 'order-2'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        published(id, is_published);
                    } else{
                        location.href = '/admin/tests';
                    }
                })
            } else {
                published(id, is_published);
            }
        })
        function published(id, is_published) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.tests.published') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                    is_published: is_published
                },
                success: function(data) {
                    Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: `${data}`
                        })
                        
                        $('.swal2-confirm').on('click',function(){
                            location.href = '/admin/tests';
                            // $('.check:button').toggle(function(){
                            //     $('input:checkbox').attr('checked','checked');
                            //     $(this).val('uncheck all');
                            // },function(){
                            //     $('input:checkbox').removeAttr('checked');
                            //     $(this).val('check all');        
                            // })
                        })
                }
            });
        }
    </script>
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('test_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.tests.massDestroy') }}",
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
            let table = $('.datatable-Test:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
