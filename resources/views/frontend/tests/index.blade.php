@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">

                        <div class="modal fade" id="csvImportModal" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">CSV Import</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <form class="form-horizontal" method="POST"
                                                    action="http://127.0.0.1:8001/admin/courses/parse-csv-import?model=Course"
                                                    enctype="multipart/form-data">
                                                    <input type="hidden" name="_token"
                                                        value="PbMFiVOT7qwIzsPUYdMDkNIAAjUDhMH8jYrv0SSI">

                                                    <div class="form-group">
                                                        <label for="csv_file" class="col-md-4 control-label">CSV file to
                                                            import</label>

                                                        <div class="col-md-6">
                                                            <input id="csv_file" type="file" class="form-control-file"
                                                                name="csv_file" required="">

                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-md-6 col-md-offset-4">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" name="header" checked="">
                                                                    File contains header row? </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-md-8 col-md-offset-4">
                                                            <button type="submit" class="btn btn-primary">
                                                                Parse CSV </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        Test List
                    </div>

                    <div class="row p-3">
                        @foreach ($tests as $test)
                            <div class="col-12 col-lg-6 col-md-6 col-sm-12 my-2 p-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div
                                                class="col-xl-9 col-lg-8 col-md-8 col-sm-12 d-flex justify-content-center justify-content-lg-start">
                                                <div class="d-flex flex-column">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="">
                                                            <span class="dans-avatar"><i
                                                                    class="bx bx-check-circle text-success"></i></span>
                                                        </div>

                                                        <div class="card-info">
                                                            <h5 class="card-title mb-0 me-2">{{ $test->title }}</h5>
                                                            <small class="text-success">{{ $test->course->title }}</small>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted mt-3">{{ $test->course->description }}</small>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 mt-2 d-flex justify-content-end">
                                                {{-- @dd(App\Helpers\helper::checkFinishedTest($test->testResults[0]->id)); --}}
                                                @if (count($test->testResults) == null)
                                                    <a class="btn btn-success join-test text-white my-auto btn-sm" data-course=""
                                                        href="{{ route('user.questions.index', ['test_id' => $test->id]) }}">Join
                                                    </a>
                                                @elseif (!App\Helpers\helper::checkFinishedTest($test->testResults[0]->id))
                                                    <a class="btn btn-success join-test text-white my-auto btn-sm" data-course=""
                                                        href="{{ route('user.questions.index', ['test_id' => $test->id]) }}">Continue
                                                    </a>
                                                @else
                                                    <a class="btn btn-primary join-test text-white my-auto btn-sm" data-course=""
                                                        href="{{ route('user.questions.index', ['test_id' => $test->id]) }}">See
                                                        Results
                                                    </a>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3">
                        <div class="row">
                            <div class="offset-0 offset-lg-10">

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection
