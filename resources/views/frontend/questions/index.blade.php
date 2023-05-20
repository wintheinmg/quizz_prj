@extends('layouts.frontend')
@section('styles')
    <style>
        .swal2-container{
            z-index: 9999 !important;
        }
        /* .modal{
            z-index: 1070 !important;
        } */
    </style>
@endsection
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
                            <div class="col-md-6 col-12">
                                Question
                                <div class="text-nowrap">
                                    <input type="hidden" id="alreadyAnswered" value="{{ $alreadyAnswered }}">
                                    <input type="hidden" id="duration" value="{{ $test->duration }}">
                                    @if ($alreadyAnswered)
                                        (<span
                                            class="@if ($pass) text-success @else text-danger @endif">Score
                                            - {{ $testResult->score }}</span>)
                                    @endif
                                    (<span class="text-primary">Pass Score
                                        - {{ $test->pass_score }}</span>)
                                </div>
                            </div>
                            <div class="col-md-6 col-12">

                                <div class="form-group d-flex justify-content-md-end mt-3">
                                    <a class="btn btn-default pt-0" onclick="history.back()">
                                        {{ trans('global.back_to_list') }}
                                    </a>
                                    |
                                    <span>
                                        <span id="demo" class="text-danger">
                                            @if ($alreadyAnswered)
                                            Test End 
                                            @elseif($testResult->duration == 0)
                                            No Duration
                                            @endif
                                        </span>
                                        @php
                                            $end_time = \Carbon\Carbon::parse($testResult->end_time)->format('M d, Y H:i:s');
                                        @endphp
                                        <input type="hidden" id="end_time" value="{{ $end_time }}">
                                    </span>
                                </div>
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

                        @php
                            if ($question->question_image) {
                                $src = '/storage/' . $question->question_image->id . '/' . $question->question_image->file_name;

                            } else {
                                $src = false;
                            }
                        @endphp
                        {{-- @dd($src) --}}
                       @if ($src)
                            <div class="row d-flex justify-content-start g-3 p-3">
                                <div class="col-md-6 text-center">
                                    <div class="questionbox">
                                        <a href="{{ $src }}" data-gallery="questionimg" class="questionbox-lightbox">
                                            <img src="{{ $src }}" class="img-fluid questionimg"/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                       @endif


                            {{-- @if ($question->question_image)
                                @php
                                    $src = '/storage/' . $question->question_image->id . '/' . $question->question_image->file_name;
                                @endphp

                                    @foreach ($src as $image)
                                                <div class="col-md-6 text-center">
                                                    <div class="questionbox">
                                                        <a href="{{ $image }}" data-gallery="questionimg" class="questionbox-lightbox">
                                                            <img src="{{ $image }}" class="img-fluid questionimg"/>
                                                        </a>
                                                    </div>
                                                </div>
                                    @endforeach
                                
                            @endif --}}

                             {{-- <div class="row d-flex justufy-content-start g-3 p-3">
                                <div class="col-md-4 text-center">
                                    <img src="{{asset('course.png')}}" class="w-50 img-fluid"/>
                                </div>
                                <div class="col-md-4 text-center">
                                    <img src="{{asset('course.png')}}" class="w-50 img-fluid"/>
                                </div>
                                <div class="col-md-4 text-center">
                                    <img src="{{asset('course.png')}}" class="w-50 img-fluid"/>
                                </div>
                            </div> --}}


                        @php
                            $answer_option_id = App\Helpers\helper::getAnsweredOption($question->id, $testResult->id ?? 0);
                            $correct_option_id = App\Helpers\helper::getCorrectOption($question->id);

                        @endphp
                        <div class="radio-row row">
                            @foreach ($question->questionOptions as $option)
                                <label class="radio-container chooseQuestionOption" data-option="{{ $option->id }}" id="questionOption{{ $option->id }}" data-question="{{ $question->id }}">
                                    <span class="ms-3">{{ $option->option_text }}</span>
                                    <input type="radio" data-question-option="{{ $question->id }}"
                                        value="{{ $option->id }}" name="questionOption{{ $question->id }}"
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
                        <div class="offset-0 offset-md-11 col-4">
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm float-right testSubmit">Submit</a>
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
        @if (\App\Helpers\helper::isTestExpired($testResult->end_time) && $testResult->finished == 0 && $test->duration <> 0)
            <div class="modal fade d-flex align-items-center" data-isTestExpired="true" id="staticBackdrop" 
                style="display: flex; align-items: center;"
                data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content align-items-center">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Test Section Expired</h1>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-primary testSubmit">Submit</button>
                    </div>
                </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('scripts')
    @parent
    {{-- <script src="{{ asset('frestui/assets/vendor/libs/jquery/jquery.js') }}"></script> --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>
    
    <script src="/js/countdown.js"></script>
    <script>
        $(() => {
            if($('#staticBackdrop').attr('data-isTestExpired')){
                $('#staticBackdrop').modal('show');
                document.getElementById("demo").innerHTML = "Test End";
            }
            var end_time = $('#end_time').val();
            var alreadyAnswered = $('#alreadyAnswered').val();
            var duration = $('#duration').val();
            console.log(duration);
            if (!alreadyAnswered && duration != 0 && duration != '0') {
                if (document.getElementById("demo").innerHTML != "Test End") {
                    countDown(end_time);
                }
            }
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

        $('.testSubmit').on('click', () => {
            var answerObj = localStorage.getItem('answer');
            if (answerObj) {
                var answerArray = JSON.parse(answerObj);
            } else {
                var answerArray = [];
            }
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

        $('.chooseQuestionOption').on('click', function () {
            var user_id = {!! Auth::user()->id !!};
            var questionOption = $(this).data('option');
            var questionOptionId = "#questionOption" + questionOption;
            var question = $(questionOptionId).data('question');
            console.log(questionOption);
            console.log(question);
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
        })
    </script>
@endsection
