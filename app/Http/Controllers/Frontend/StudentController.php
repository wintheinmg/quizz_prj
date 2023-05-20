<?php

namespace App\Http\Controllers\Frontend;

use Gate;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyStudentRequest;
use App\Http\Requests\StudentRegisterRequest;
use Illuminate\Support\Facades\Hash;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class StudentController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('student_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $students = Student::with(['created_by'])->get();

        return view('frontend.students.index', compact('students'));
    }

    public function create()
    {
        abort_if(Gate::denies('student_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.students.create');
    }

    public function store(StudentRegisterRequest $request)
    {
        // dd($request->all());
        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'approved' => 0,
            'verified' => 1
        ];
        $user = User::create($user);
        $user->roles()->attach(3);

        $student_user = [
            'user_id' => $user->id,
            'date' => Carbon::now()->format('Y-m-d'),
            'name' => $request->name,
            'nrc' => $request->nrc,
            'address' => $request->address,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'acca_student_no' => $request->acca_student_no,
            'subject' => $request->subject,
            'exam_session_period' => $request->exam_session_period,
            'old_student' => $request->old_student,
            'which' => $request->which,
            'how_knew_acca' => $request->how_knew_acca,
            'why_choose' => $request->why_choose,
            'photo' => $request->photo
        ];
        $student = Student::create($student_user);
        $student->courses()->attach($request->course_id);
        if ($request->input('photo', false)) {
            $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $student->id]);
        }

        return redirect()->route('login')->with('success', 'User Registration Successfully!');
    }

    public function edit(Student $student)
    {
        abort_if(Gate::denies('student_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student->load('created_by');

        return view('frontend.students.edit', compact('student'));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->all());

        return redirect()->route('frontend.students.index');
    }

    public function show(Student $student)
    {
        abort_if(Gate::denies('student_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student->load('created_by');

        return view('frontend.students.show', compact('student'));
    }

    public function destroy(Student $student)
    {
        abort_if(Gate::denies('student_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student->delete();

        return back();
    }

    public function massDestroy(MassDestroyStudentRequest $request)
    {
        Student::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}