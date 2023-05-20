<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Test;
use App\Models\User;
use App\Models\Student;
use App\Models\Question;
use App\Models\TestResult;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTestResultRequest;
use App\Http\Requests\UpdateTestResultRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyTestResultRequest;

class TestResultsController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('test_result_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $testResults = TestResult::with(['test', 'student', 'created_by'])->latest()->get();

        return view('admin.testResults.index', compact('testResults'));
    }

    public function create()
    {
        abort_if(Gate::denies('test_result_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tests = Test::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.testResults.create', compact('students', 'tests'));
    }

    public function store(StoreTestResultRequest $request)
    {
        $testResult = TestResult::create($request->all());

        return redirect()->route('admin.test-results.index');
    }

    public function edit(TestResult $testResult)
    {
        abort_if(Gate::denies('test_result_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tests = Test::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $testResult->load('test', 'student', 'created_by');

        return view('admin.testResults.edit', compact('students', 'testResult', 'tests'));
    }

    public function update(UpdateTestResultRequest $request, TestResult $testResult)
    {
        $testResult->update($request->all());

        return redirect()->route('admin.test-results.index');
    }

    public function show(TestResult $testResult)
    {
        abort_if(Gate::denies('test_result_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.testResults.show', compact('testResult'));
    }

    public function destroy(TestResult $testResult)
    {
        abort_if(Gate::denies('test_result_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $testResult->delete();

        return back();
    }

    public function massDestroy(MassDestroyTestResultRequest $request)
    {
        TestResult::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function testResultShow(Request $request)
    {
        // dd($request->all());
        $test_id = (int)$request->test_id;
        $test = Test::find($test_id);
        $auth_user_id = (isset($request->student_id)) ? (int)$request->student_id : Auth::user()->id;
        $student = Student::where('user_id', $request->student_id)->first();
        $testResult = TestResult::where('test_id', $test_id)->where('student_id', $auth_user_id)->first();
        // dd($testResult);
        $testResult->is_seen = 1;
        $testResult->save();
        $alreadyAnswered = $testResult ? true : false;
        $pass = true;
        if ($testResult) {
            ($testResult->score < $test->pass_score) ? $pass = false : $pass = true;
        }
        $allQuestions = Question::with(['questionOptions', 'created_by', 'media'])->where('test_id', $test_id)->get();
        $questions = Question::with(['questionOptions', 'created_by', 'media'])->where('test_id', $test_id)->paginate(5)->withQueryString();
        // dd($alreadyAnswered);
        $firstItem = $questions->firstItem();
        $lastItem = $allQuestions ? count($allQuestions) : 0;
        return view('admin.testResults.show', compact('student', 'questions', 'firstItem', 'lastItem', 'test', 'test_id', 'alreadyAnswered', 'pass', 'testResult'));
    }

    public function testResultPrint(Request $request)
    {
        // dd($request->all());
        $test_id = (int)$request->test_id;
        $test = Test::find($test_id);
        $auth_user_id = (isset($request->student_id)) ? (int)$request->student_id : Auth::user()->id;
        $student = Student::where('user_id', $request->student_id)->first();
        $testResult = TestResult::where('test_id', $test_id)->where('student_id', $auth_user_id)->first();
        // dd($testResult);
        $testResult->is_seen = 1;
        $testResult->save();
        $alreadyAnswered = $testResult ? true : false;
        $pass = true;
        if ($testResult) {
            ($testResult->score < $test->pass_score) ? $pass = false : $pass = true;
        }
        $allQuestions = Question::with(['questionOptions', 'created_by', 'media'])->where('test_id', $test_id)->get();
        $questions = Question::with(['questionOptions', 'created_by', 'media'])->where('test_id', $test_id)->paginate(5)->withQueryString();
        // dd($alreadyAnswered);
        $firstItem = $questions->firstItem();
        $lastItem = $allQuestions ? count($allQuestions) : 0;
        return view('admin.testResults.print', compact('student', 'questions', 'firstItem', 'lastItem', 'test', 'test_id', 'alreadyAnswered', 'pass', 'testResult'));
    }
}