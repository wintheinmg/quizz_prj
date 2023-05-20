<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\helper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyQuestionRequest;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestAnswer;
use App\Models\TestResult;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class QuestionsController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('question_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $test_id = $request->test_id;
        $test = Test::find($test_id);
        $auth_user_id = (isset($request->student_id)) ? $request->student_id : Auth::user()->id;

        $testResult = TestResult::where('test_id', $test_id)->where('student_id', $auth_user_id)->first();
        date_default_timezone_set('Asia/Yangon');
        
        $currentTime = Carbon::now()->format('M d, Y H:i:s');
        // dd($currentTime);
        $end_time = helper::getEndTime(Carbon::now(), $test->duration);
        if ($testResult == null) {
            $testResult = TestResult::create([
                'test_id'       => $test_id,
                'student_id'    => $auth_user_id,
                'start_time'    => $currentTime,
                'end_time'      => $end_time,
                'score'         => 0
            ]);
        }
        $alreadyAnswered = helper::checkFinishedTest($testResult->id);
        $pass = true;
        if ($testResult) {
            ($testResult->score < $test->pass_score) ? $pass = false : $pass = true;
        }
        $allQuestions = Question::with(['questionOptions', 'created_by', 'media'])->where('test_id', $test_id)->get();
        $questions = Question::with(['questionOptions', 'created_by', 'media'])->where('test_id', $test_id)->paginate(5)->withQueryString();
        // dd($questions[0]);
        $firstItem = $questions->firstItem();
        $lastItem = $allQuestions ? count($allQuestions) : 0;
        return view('frontend.questions.index', compact('questions', 'firstItem', 'lastItem', 'test', 'test_id', 'alreadyAnswered', 'pass', 'testResult'));
    }

    public function create()
    {
        abort_if(Gate::denies('question_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tests = Test::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.questions.create', compact('tests'));
    }

    public function store(StoreQuestionRequest $request)
    {
        $question = Question::create($request->all());

        if ($request->input('question_image', false)) {
            $question->addMedia(storage_path('tmp/uploads/' . basename($request->input('question_image'))))->toMediaCollection('question_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $question->id]);
        }

        return redirect()->route('frontend.questions.index');
    }

    public function edit(Question $question)
    {
        abort_if(Gate::denies('question_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tests = Test::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $question->load('test', 'created_by');

        return view('frontend.questions.edit', compact('question', 'tests'));
    }

    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $question->update($request->all());

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

        return redirect()->route('frontend.questions.index');
    }

    public function show(Question $question)
    {
        abort_if(Gate::denies('question_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $question->load('test', 'created_by');

        return view('frontend.questions.show', compact('question'));
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
}
