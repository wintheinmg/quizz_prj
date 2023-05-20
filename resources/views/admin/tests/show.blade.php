@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="custom-header">
            {{ trans('global.show') }} {{ trans('cruds.test.title') }}
            <div class="d-flex justify-content-start">
                <a href="{{asset('file/question-import-example.csv')}}" download class="btn btn-primary me-1">
                    <small>{{ trans('global.download_sample') }}</small>
                </a>
                <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans('global.add') }} {{ trans('cruds.question.title') }} {{ trans('global.app_csvImport') }}
                </button>
                @include('csvImport.modal', [
                    'test_id' => $test->id,
                    'route' => 'admin.questions.import',
                ])
            </div>
        </div>

        <div class="card-body">
            <div class="form-group">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.test.fields.id') }}
                            </th>
                            <td>
                                {{ $test->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.test.fields.course') }}
                            </th>
                            <td>
                                {{ $test->course->title ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.test.fields.title') }}
                            </th>
                            <td>
                                {{ $test->title }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.test.fields.description') }}
                            </th>
                            <td>
                                {{ $test->description }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.test.fields.duration') }}
                            </th>
                            <td>
                                {{ $test->duration }} ( {{ trans('global.minutes') }} )
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.test.fields.pass_score') }}
                            </th>
                            <td>
                                {{ $test->pass_score ?? '0' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="fw-bold">
                                {{ trans('cruds.test.fields.questions') }}
                            </th>
                            <td class="fw-bold fs-5">
                                {{ $test->questions ? count($test->questions) : 0 }} 
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.test.fields.is_published') }}
                            </th>
                            <td>
                                <input type="checkbox" disabled="disabled" {{ $test->is_published ? 'checked' : '' }}>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.tests.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
