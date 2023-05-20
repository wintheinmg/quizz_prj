<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class StudentRegisterController extends Controller
{
    public function register(Request $request)
    {
        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => 'password',
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
            'how_knew_acca' => $request->how_knew_acca,
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
}