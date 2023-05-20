@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            
            {{-- <div class="col-md-3 offset-10 me-5 pe-0 py-0 mb-0">
                <a class="btn btn-primary d-block w-50 mb-2 hover-white text-white me-0"
                    onclick="printFunction()">Print</a>
            </div> --}}
            <div class="col-md-10" id="print_div">
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
                                @if ($alreadyAnswered)
                                    (<span
                                        class="@if ($pass) text-success @else text-danger @endif">Score
                                        - {{ $testResult->score }}</span>)
                                @endif
                                (<span class="text-primary">Pass Score
                                    - {{ $test->pass_score }}</span>)
                            </div>
                            <div class="col-6 text-end" id="hide_for_print">

                                <div class="form-group d-flex justify-content-end">
                                    <a class="btn btn-default pt-0" href="{{ route('admin.test-results.index') }}">
                                        {{ trans('global.back_to_list') }}
                                    </a>
                                    <span>
                                        |
                                        @if ($alreadyAnswered)
                                            Test End
                                        @else
                                            {{ $test->duration }} ( {{ trans('global.minutes') }} )
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-between">
                                <div class="">
                                    Name : {{ $student->name ?? '' }}
                                </div>
                                <div class="">
                                    Email : {{ $student->email ?? '' }}
                                </div>
                                <div class="">
                                    Phone :
                                    {{ $student->phone_no ?? '' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($questions as $question)
                    <div class="card py-3 mb-2">
                        {{-- <div class="row ps-1 pe-3 my-2 fw-bold">
                            <div class="col-1 d-flex justify-content-center">
                                <div class="avatar">
                                    <div class="avatar-initial bg-label-primary rounded-circle">
                                        <span class="numberCircle avatar-initial bg-label-primary rounded-circle">
                                            {{ $firstItem + $loop->index }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-11 ps-0">
                                <span style="font-size: 16px;">
                                    {{ $question->question_text }}
                                </span>
                            </div>
                        </div> --}}
                        <div class="d-flex px-3 fw-bold">
                            <span class="numberCircle">
                                {{ $firstItem + $loop->index }}
                            </span>
                            <span class="my-auto" style="font-size: 16px; width: fit-content;">
                                {{ $question->question_text }}
                            </span>
                        </div>
                        @php
                            $answer_option_id = App\Helpers\helper::getAnsweredOption($question->id, $testResult->id ?? 0);
                            $correct_option_id = App\Helpers\helper::getCorrectOption($question->id);
                            
                        @endphp
                        <div class="radio-row row chooseQuestionOption" data-question="{{ $question->id }}">
                            @foreach ($question->questionOptions as $option)
                                <label class="radio-container">
                                    <span class="ms-3">{{ $option->option_text }}</span>
                                    <input type="radio" data-question-option="{{ $option->id }}"
                                        value="{{ $option->id }}" name="questionOption{{ $question->id }}"
                                        id="questionOption{{ $option->id }}"
                                        @if ($alreadyAnswered) disabled @endif
                                        @if ($alreadyAnswered && $option->id == $answer_option_id) checked @endif>
                                    <span
                                        class="checkmark 
                                    @if ($alreadyAnswered && $option->id == $correct_option_id && $option->id == $answer_option_id) bg-success 
                                    @elseif ($alreadyAnswered && $option->id == $correct_option_id && $option->id != $answer_option_id) bg-danger @endif"></span>
                                </label>
                            @endforeach
                        </div>
                        <hr>
                    </div>
                    @if ($lastItem == $firstItem + $loop->index && !$alreadyAnswered)
                        <div class="offset-11 col-4">
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm float-right"
                                id="testSubmit">Submit</a>
                        </div>
                    @endif
                @endforeach
                <div class="mt-3">
                    <div class="row">
                        <div class="">
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
        })
        
        function printFunction() {
            var divContents = document.getElementById('print_div').innerHTML;
            var a = window.open('', '', 'height=800, width=500');
            a.document.write("<html><head><title></title>");
            a.document.write(
                `<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" type="text/css" />`
            );
            a.document.write(divContents);
            a.document.find(hide_for_print).attr('hidden', true);
            a.print();
        }
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
        $('#testSubmit').on('click', () => {
            var answerObj = localStorage.getItem('answer');
            var answerArray = JSON.parse(answerObj);
            var user_id = {!! Auth::user()->id !!};
            var test_id = {!! $test->id !!};
            console.log(test_id);
            if (confirm('{{ trans('global.areYouSure') }}')) {
                $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: "{{ route('frontend.test-results.store') }}",
                        data: {
                            test_id: test_id,
                            user_id: user_id,
                            answerArray: answerArray
                        }
                    })
                    .done(function() {
                        localStorage.clear();
                        location.reload();
                    })
            }
        })
    </script>
@endsection
