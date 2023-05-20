<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Test;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyQuestionRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Imports\QuestionImport;
use App\Models\QuestionOption;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class QuestionsController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('question_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questions = Question::with(['test', 'created_by', 'media'])->get();

        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        abort_if(Gate::denies('question_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tests = Test::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.questions.create', compact('tests'));
    }

    public function store(StoreQuestionRequest $request)
    {
        // dd($request->all());
        $question = Question::create([
            'question_text' => $request->question_text,
            'points'        => $request->points,
            'test_id'       => $request->test_id
        ]);

        if ($request->input('question_image', false)) {
            $question->addMedia(storage_path('tmp/uploads/' . basename($request->input('question_image'))))->toMediaCollection('question_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $question->id]);
        }

        for ($i = 0; $i < count($request->option_text); $i++) {
            $is_correct_name = "is_correct" . $i;
            $is_correct = 0;
            if (isset($request->$is_correct_name)) {
                $is_correct = 1;
            }
            QuestionOption::create([
                'option_text'   =>  $request->option_text[$i],
                'is_correct'    =>  $is_correct,
                'question_id'   =>  $question->id
            ]);
        }

        return redirect()->route('admin.questions.index');
    }

    public function edit(Question $question)
    {
        abort_if(Gate::denies('question_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tests = Test::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $question->load('test', 'created_by', 'questionOptions');

        return view('admin.questions.edit', compact('question', 'tests'));
    }

    public function update(UpdateQuestionRequest $request, Question $question)
    {
        // dd($request->all());
        $question->update([
            'question_text' =>  $request->question_text,
            'points'        =>  $request->points,
            'test_id'       =>  $request->test_id
        ]);

        if ($request->input('question_image', false)) {
            if (!$question->question_image || $request->input('question_image') !== $question->question_image->file_name) {
                if ($question->question_image) {
                    $question->question_image->delete();
                }
                $question->addMedia(storage_path('tmp/uploads/' . basename($request->input('question_image'))))->toMediaCollection('question_image');
            }
        } elseif ($question->question_image) {
            $question->question_image->delete();
        }

        for ($i = 0; $i <= $request->old_option_count; $i++) {
            $is_correct_name = "is_correct" . $i;
            $option_text_name = "option_text" . $i;
            $option_id_name = "option_id" . $i;
            $is_correct = 0;

            if (isset($request->$option_text_name)) {
                if (isset($request->$is_correct_name)) {
                    $is_correct = 1;
                }
                QuestionOption::where('id', $request->$option_id_name)
                    ->update([
                        'option_text'   =>  $request->$option_text_name,
                        'is_correct'    =>  $is_correct
                    ]);
            }
        }

        if (isset($request->new_option_text)) {
            for ($i = 0; $i < count($request->new_option_text); $i++) {
                $new_is_correct_name = "new_is_correct" . $i;
                $new_is_correct = 0;
                if (isset($request->$new_is_correct_name)) {
                    $new_is_correct = 1;
                }
                QuestionOption::create([
                    'option_text'   =>  $request->new_option_text[$i],
                    'is_correct'    =>  $new_is_correct,
                    'question_id'   =>  $question->id,
                    'created_by_id' =>  Auth::user()->id
                ]);
            }
        }

        return redirect()->route('admin.questions.index');
    }

    public function show(Question $question)
    {
        abort_if(Gate::denies('question_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $question->load('test', 'created_by');

        return view('admin.questions.show', compact('question'));
    }

    public function destroy(Question $question)
    {
        abort_if(Gate::denies('question_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $question->delete();

        return back();
    }

    public function massDestroy(MassDestroyQuestionRequest $request)
    {
        Question::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('question_create') && Gate::denies('question_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Question();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function import(Request $request)
    {
        // dd($request->all());
        Excel::import(new QuestionImport($request->test_id), $request->file('csv_file')->store('files'));

        // return FingerPrint::all();
        return redirect()->back();
    }
}