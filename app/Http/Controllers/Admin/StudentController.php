<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Http\Requests\MassDestroyStudentRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use App\Models\User;
use App\Notifications\VerifyUserNotification;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('student_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $students = Student::with(['created_by', 'user'])->latest()->get();

        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        abort_if(Gate::denies('student_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.students.create');
    }

    public function store(StoreStudentRequest $request)
    {
        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => 'password',
            'approved' => 1,
            'verified' => 1,
            'verified_at' => Carbon::now()->format(config('panel.date_format') . ' ' . config('panel.time_format')),
            'verification_token' => Str::random(64)
        ];
        $user = User::create($user);
        $user->notify(new VerifyUserNotification($user));
        $user->roles()->attach(3);

        $student_user = [
            'user_id' => $user->id,
            'date' => $request->date,
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
            $student->addMedia(storage_path('/tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $student->id]);
        }
        return redirect()->route('admin.students.index');
    }

    public function edit(Student $student)
    {
        abort_if(Gate::denies('student_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student->load('created_by');

        return view('admin.students.edit', compact('student'));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->all());
        if ($request->input('photo', false)) {
            if (!$student->photo || $request->input('photo') !== $student->photo->file_name) {
                if ($student->photo) {
                    $student->photo->delete();
                }
                $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($student->photo) {
            $student->photo->delete();
        }
        return redirect()->route('admin.students.index');
    }

    public function show(Student $student)
    {
        abort_if(Gate::denies('student_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student->load('created_by');

        return view('admin.students.show', compact('student'));
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
    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('student_create') && Gate::denies('student_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Student();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}