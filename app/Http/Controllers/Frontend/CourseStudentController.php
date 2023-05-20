<?php

namespace App\Http\Controllers\Frontend;

use Gate;
use Carbon\Carbon;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\CourseStudent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\StoreCourseStudentRequest;
use App\Http\Requests\UpdateCourseStudentRequest;
use App\Http\Requests\MassDestroyCourseStudentRequest;

class CourseStudentController extends Controller
{
    use CsvImportTrait;
    //create Course Student
    public function joinCourse(Request $request){
        $student = Student::where('user_id', Auth::user()->id)->first();
        $student->courses()->attach($request->course_id,[
            'created_at'=>Carbon::now()
        ]);

        return "Success";

    }

    public function index()
    {
        abort_if(Gate::denies('course_student_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courseStudents = CourseStudent::with(['course', 'student', 'created_by'])->get();

        return view('frontend.courseStudents.index', compact('courseStudents'));
    }

    public function create()
    {
        abort_if(Gate::denies('course_student_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Student::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.courseStudents.create', compact('courses', 'students'));
    }

    public function store(StoreCourseStudentRequest $request)
    {
        $courseStudent = CourseStudent::create($request->all());

        return redirect()->route('frontend.course-students.index');
    }

    public function edit(CourseStudent $courseStudent)
    {
        abort_if(Gate::denies('course_student_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Student::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $courseStudent->load('course', 'student', 'created_by');

        return view('frontend.courseStudents.edit', compact('courseStudent', 'courses', 'students'));
    }

    public function update(UpdateCourseStudentRequest $request, CourseStudent $courseStudent)
    {
        $courseStudent->update($request->all());

        return redirect()->route('frontend.course-students.index');
    }

    public function show(CourseStudent $courseStudent)
    {
        abort_if(Gate::denies('course_student_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courseStudent->load('course', 'student', 'created_by');

        return view('frontend.courseStudents.show', compact('courseStudent'));
    }

    public function destroy(CourseStudent $courseStudent)
    {
        abort_if(Gate::denies('course_student_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courseStudent->delete();

        return back();
    }

    public function massDestroy(MassDestroyCourseStudentRequest $request)
    {
        CourseStudent::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }


    // private function
    private function getAllData($request){
        return [
            'course_id'=>$request->course_id,
            'student_id'=>$request->student_id
        ];
    }
}
