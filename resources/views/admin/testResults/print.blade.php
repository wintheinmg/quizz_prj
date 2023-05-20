@extends('layouts.admin')
@section('styles')
    <style>
        .custom-header{
            padding: 25px 18px !important;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            
            <div class="col-md-3 offset-10 me-5 pe-0 py-0 mb-0">
                <a class="btn btn-primary d-block w-50 mb-2 hover-white text-white me-0"
                    onclick="printFunction()">Print</a>
            </div>
            <div class="col-md-10" id="print_div">
                {{-- @foreach ($questions as $question) --}}
                    <input type="hidden" id="testTitle" value="{{ $test->title }}">
                    <div class="card">
                        <div class="custom-header">
                            <div class="text-start">
                                Question
                                <span>
                                    @if ($alreadyAnswered)
                                        (<span
                                            class="text-nowrap @if ($pass) text-success @else text-danger @endif">Score
                                            - {{ $testResult->score }}</span>)
                                    @endif
                                    (<span class="text-nowrap text-primary">Pass Score
                                        - {{ $test->pass_score }}</span>)
                                </span>
                            </div>
                            <div class="text-center">
                                    Name : {{ $student->name ?? '' }}
                            </div>
                            <div class="text-end">
                                    Phone :
                                    {{ $student->phone_no ?? '' }}
                            </div>
                        </div>
                        @foreach ($questions as $question)
                        <div class="d-flex px-3 fw-bold">
                            <span class="" style="padding: 0 1% 0 0;">
                                {{ $firstItem + $loop->index }}.
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
                                <label class="radio-container ps-3" style="border-bottom: 0px solid #eee;">
                                    
                                    @if ($alreadyAnswered && $option->id == $correct_option_id && $option->id == $answer_option_id)
                                    <i class="bx bxs-check-circle text-success ps-3"></i>
                                    @elseif ($alreadyAnswered && $option->id == $correct_option_id && $option->id != $answer_option_id)
                                    <i class="bx bxs-check-circle text-danger ps-3"></i>
                                    @elseif ($alreadyAnswered && $option->id != $correct_option_id && $option->id == $answer_option_id)
                                    <i class="bx bxs-x-circle text-primary ps-3"></i>
                                    @else
                                    <i class="bx bx-circle ps-3"></i>
                                    @endif
                                    {{-- <span
                                        class=" 
                                    @if ($alreadyAnswered && $option->id == $correct_option_id && $option->id == $answer_option_id) bg-success
                                    @elseif ($alreadyAnswered && $option->id == $correct_option_id && $option->id != $answer_option_id) bg-danger
                                    @elseif ($alreadyAnswered && $option->id != $correct_option_id && $option->id == $answer_option_id) bg-primary @endif"
                                    style="
                                    position: absolute;
                                    top: 5px;
                                    left: 0;
                                    height: 15px;
                                    width: 15px;
                                    background-color: #bbbbbb;
                                    border-radius: 50%;"></span> --}}
                                    <span class="ms-3">{{ $option->option_text }}</span>
                                    
                                </label>
                            @endforeach
                        </div>
                        <br>
                        @endforeach
                    </div>
                {{-- @endforeach --}}
            </div>
            
            <div class="mt-3">
                <div class="row">
                    <div class="offset-0 offset-lg-1">
                        {{ $questions->links() }}
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
            // var divContents = document.getElementById('print_div').innerHTML;
            // var win = window.open('', '', 'height=800, width=600');
            // win.document.write(`
            //     <html>
            //     <head>
            //         <title>EAS TEST RESULT</title>
            //         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" type="text/css" />
            //     </head>
            //     <style>
            //         .radio-row{
            //             margin-top: 15px;
            //             margin-left: 1.7%;
            //             padding-left: calc(var(--bs-gutter-x) * 0.5);
            //             padding-right: calc(var(--bs-gutter-x) * 0.5);
            //         }
            //         .radio-container{
            //             display: block;
            //             position: relative;
            //             /* padding-left: 5%; */
            //             margin-bottom: 12px;
            //             cursor: pointer;
            //             font-size: 16px;
            //             -webkit-user-select: none;
            //             -moz-user-select: none;
            //             -ms-user-select: none;
            //             user-select: none;
            //         }
            //         .checkmark{
            //             position: absolute;
            //             top: 5px;
            //             left: 0;
            //             height: 15px;
            //             width: 15px;
            //             background-color: #bbbbbb;
            //             border-radius: 50%;
            //         }
            //         .bg-success{
            //             --bs-bg-opacity: 1;
            //             background-color: rgba(var(--bs-success-rgb), var(--bs-bg-opacity)) !important;
            //         }
            //         .bg-danger{
            //             --bs-bg-opacity: 1;
            //             background-color: rgba(var(--bs-danger-rgb), var(--bs-bg-opacity)) !important;
            //         }
            //         .bg-primary{
            //             --bs-bg-opacity: 1;
            //             background-color: #5a8dee !important;
            //         }
            //     </style>
            //     <body>
            //         ${divContents}
            //     </body>
            //     </html>
            // `);
            // win.print();
            var title = $('#testTitle').val();
            var contents = $("#print_div").html();
            var frame1 = $('<iframe />');
            frame1[0].name = "frame1";
            frame1.css({ "position": "absolute", "top": "-1000000px" });
            $("body").append(frame1);
            var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
            frameDoc.document.open();
            //Create a new HTML document.
            frameDoc.document.write('<html><head><title>EAS ' + title + ' Result</title>');
            //Append the internal CSS file.
            frameDoc.document.write(`
                                    <style>
                                        .card{
                                            border: 0px !important;
                                        }
                                        .custom-header {
                                            display: flex !important;
                                            justify-content: space-between !important;
                                            padding: 25px 18px !important;
                                        }
                                    </style>
                                    `);
            // frameDoc.document.write('<link rel="stylesheet" href="https://eas.hmmdemo.net/css/style.css" type="text/css" />');
            // frameDoc.document.write('<link rel="stylesheet" href="/frestui/assets/vendor/fonts/boxicons.css" type="text/css" />');
            frameDoc.document.write('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">');
            frameDoc.document.write('<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.css" rel="stylesheet" />');
            //bootstrap link
            frameDoc.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" type="text/css" />');
            frameDoc.document.write('</head><body>');
            
            //Append the DIV contents.
            frameDoc.document.write(contents);
            frameDoc.document.write('</body></html>');
            var curURL = window.location.href;
            frameDoc.document.close();
            setTimeout(function () {
                window.frames["frame1"].focus();
                history.replaceState(history.state, '', '/');
                window.frames["frame1"].print();
                history.replaceState(history.state, '', curURL);
                frame1.remove();
            }, 200);
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
