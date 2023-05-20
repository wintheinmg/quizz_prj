@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
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
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-6">
                                Question
                            </div>
                            <div class="col-6 text-end">
                                Time Out
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($questions as $question)
                    <div class="card py-3 mb-2">
                        <div class="d-flex px-3 fw-bold">
                            <span class="numberCircle">
                                {{ $firstItem + $loop->index }}
                            </span>
                            <span class="my-auto" style="font-size: 16px; width: fit-content;">
                                {{ $question->question_text }}
                            </span>
                        </div>

                        <div class="radio-row row chooseQuestionOption" data-question="{{ $question->id }}">
                            @foreach ($question->questionOptions as $option)
                                <label class="radio-container">
                                    <span class="ms-3">{{ $option->option_text }}</span>
                                    <input type="radio" data-question-option="{{ $option->id }}"
                                        value="{{ $option->id }}" name="questionOption{{ $question->id }}"
                                        id="questionOption{{ $option->id }}">
                                    <span class="checkmark"></span>
                                </label>
                            @endforeach
                        </div>
                        <hr>
                    </div>
                    @if ($lastItem == $firstItem + $loop->index)
                        <div class="offset-0 offset-lg-11 col-4">
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm float-right"
                                id="testSubmit">Submit</a>
                        </div>
                    @endif
                @endforeach
                <div class="mt-3">
                    <div class="row">
                        <div class="offset-0 offset-lg-10">
                            {{ $questions->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>
    <script>
        $(() => {
            var auth_user_id = {!! Auth::user()->id !!};
            var answerObj = localStorage.getItem('answer');
            var answerArray = JSON.parse(answerObj);
            answerArray.forEach(element => {
                if (element['user_id'] == auth_user_id) {
                    $("input[name=questionOption" + element['question'] + "][value=" + element[
                        'questionOption'] + "]").attr("checked", "checked");
                    // console.log('question =' + element['question'] + ' and questionOption =' + element['questionOption']);
                }
            });

            
            $('#testSubmit').on('click', () => {
                var answerObj = localStorage.getItem('answer');
                var answerArray = JSON.parse(answerObj);
                var test_result_id = {!! $testResult->id !!};
                console.table(test_result_id);
                $.ajax({
                    type: "POST",
                    url: "{{ route('frontend.test-results.store') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        test_result_id: test_result_id,
                        answerArray: answerArray
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: data,
                        })
                        $('.swal2-confirm').on('click',function(){
                            localStorage.setItem('answer', '');
                            location.href = '/user/tests';
                            // location.href = '/user/questions?test_id=' + {!! $test_id !!};
                        })
                    }
                });
            })
        })
        $('.chooseQuestionOption').on('click', function() {
            var user_id = {!! Auth::user()->id !!};
            var question = $(this).data('question');
            var questionOptionName = "input[name=questionOption" + question + "]:checked";
            var questionOption = $(questionOptionName).val();
            var questionOption = $(questionOptionName).data('question-option');
            var list = {
                user_id: user_id,
                question: question,
                questionOption: questionOption,
            };
            var answerObj = localStorage.getItem('answer');
            if (!answerObj) {
                var answerArray = [];
            } else {
                var answerArray = JSON.parse(answerObj);
            }
            if (answerArray.length == 0) {
                answerArray.push(list);
            } else {
                var status = true;
                answerArray.forEach(element => {
                    if (element['question'] == question) {
                        status = false;
                        element['questionOption'] = questionOption;
                    }
                });
                if (status) {
                    answerArray.push(list);
                }
            }
            localStorage.setItem('answer', JSON.stringify(answerArray));
            // console.table(answerArray);
        })
    </script>
@endsection
