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
        {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}
        @can('user_create')
        
            <div class="text-end">
                <a class="btn btn-success" href="{{ route('admin.users.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
                </a>
            </div>
    
        @endcan
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr class="text-nowrap">
                        <th width="10">
                            {{trans('global.no')}}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.user.fields.id') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.user.fields.email_verified_at') }}
                        </th> --}}
                        {{-- <th>
                            {{ trans('cruds.user.fields.approved') }}
                        </th> --}}
                        {{-- <th>
                            {{ trans('cruds.user.fields.verified') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.user.fields.roles') }}
                        </th>
                        <th>
                            {{trans('global.action')}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                    <tr data-entry-id="{{ $user->id }}" class="text-nowrap">
                        <td>
                            {{$loop->iteration}}
                        </td>
                        {{-- <td>
                            {{ $user->id ?? '' }}
                        </td> --}}
                        <td>
                            @php
                                $studentId = count($user->students) > 0 ? $user->students[0]->id : 0;
                            @endphp
                            @if ($studentId != 0)
                                <a href="{{ route('admin.students.show', $studentId) }}">
                                    {{ $user->name ?? '' }}
                                </a>
                            @else
                                {{ $user->name ?? '' }}
                            @endif
                        </td>
                        <td>
                            {{ $user->email ?? '' }}
                        </td>
                        {{-- <td>
                            {{ $user->email_verified_at ?? '' }}
                        </td> --}}
                        {{-- <td>
                            <a href="javascript:void(0)" class="">
                                <label class="switch switch-success">
                                    <input type="checkbox" name="status" value=""
                                        class="switch-input switchStatus change-status"
                                        data-userId="{{ $user->id }}"
                                        id="switchStatus{{ $user->id }}"
                                        @if ($user->approved == '0') 
                                            unchecked
                                        @else
                                            checked  disabled 
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
                        </td> --}}
                        {{-- <td>
                            <span style="display:none">{{ $user->verified ?? '' }}</span>
                            <input type="checkbox" disabled="disabled" {{ $user->verified ? 'checked' : '' }}>
                        </td> --}}
                        <td>
                            @foreach($user->roles as $key => $item)
                            <span class="badge bg-info my-1 rounded-pill ">{{ $item->title }}</span>
                            @endforeach
                        </td>
                        <td>
                            @can('user_show')
                            <a class="p-0 glow"
                                    style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                    href="{{ route('admin.users.show', $user->id) }}">
                                    <i class='bx bx-show'></i>
                            </a>
                            @endcan
 
                            @can('user_edit')
                           
                            <a class="p-0 glow"
                                style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                href="{{ route('admin.users.edit', $user->id) }}">
                                <i class='bx bx-edit'></i>
                            </a>
                            @endcan

                            @can('user_delete')
                            <form id="orderDelete-{{ $user->id }}"
                               action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
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

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>
<script>
    $('.change-status').on('change', function() {
        let userId = parseInt($(this).attr('id').replace('switchStatus', ''));
        $.ajax({
            type: "POST",
            url: "{{ route('admin.users.approved') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                user_id: userId
            },
            success: function(data) {
                var switchStatusId = '#switchStatus' + userId;
                $(switchStatusId).attr('disabled', 'disabled');
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: `${data}`,
                    showConfirmButton: false,
                    timer: 1500
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
        @can('user_delete')
        let deleteButtonTrans = '{{ trans('
        global.datatables.delete ') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.users.massDestroy') }}",
            className: 'btn-danger',
            action: function(e, dt, node, config) {
                var ids = $.map(dt.rows({
                    selected: true
                }).nodes(), function(entry) {
                    return $(entry).data('entry-id')
                });

                if (ids.length === 0) {
                    alert('{{ trans('
                        global.datatables.zero_selected ') }}')

                    return
                }

                if (confirm('{{ trans('
                        global.areYouSure ') }}')) {
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
        let table = $('.datatable-User:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

    })
</script>
@endsection