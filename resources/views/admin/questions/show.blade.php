@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header text-primary fw-bold">
            {{-- {{ trans('global.show') }} {{ trans('cruds.question.title') }} --}}
            {{ $question->test->title }}
        </div>

        <div class="card-body">
            <div class="fs-4">
                {{ $question->question_text }} <span class="text-info fs-6">( {{ $question->points }} - Marks )</span>
            </div>
            @php
                if ($question->question_image) {
                    $src = 'storage/' . $question->question_image->id . '/' . $question->question_image->file_name;
                }
            @endphp
            @if ($question->question_image)
                <img src="{{ asset($src) }}" style="aspect-ratio:1;object-fit:cover;width:180px"
                    id="change-photo{{ $question->id }}" class="rounded" title="" />
            @endif

            <div class="mt-2">
                <ol class="list-group">
                    @foreach ($question->questionOptions as $option)
                        <li class="list-group-item @if ($option->is_correct) text-success fw-bold @endif">
                            {{ chr(64 + $loop->iteration) }} .
                            {{ $option->option_text }}</li>
                    @endforeach
                </ol>
            </div>

            <div class="form-group mt-2">
                <a class="btn btn-default" href="{{ route('admin.questions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
@endsection
