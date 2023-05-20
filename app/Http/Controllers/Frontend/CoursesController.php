<?php

namespace App\Http\Controllers\Frontend;

use Gate;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCourseRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CoursesController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('course_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::with(['teachers', 'course_category', 'created_by', 'media', 'students'])->whereNotNull('price')->paginate(12);
        $course_categories = CourseCategory::paginate(10);
        // dd($courses[0]['course_category_id']);

        return view('frontend.courses.index', compact('courses', 'course_categories'));
    }

    public function create()
    {
        abort_if(Gate::denies('course_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teachers = Teacher::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $course_categories = CourseCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.courses.create', compact('course_categories', 'teachers'));
    }

    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->all());

        foreach ($request->input('thumbnail', []) as $file) {
            $course->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('thumbnail');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $course->id]);
        }

        return redirect()->route('frontend.courses.index');
    }

    public function edit(Course $course)
    {
        abort_if(Gate::denies('course_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teachers = Teacher::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $course_categories = CourseCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $course->load('teacher', 'course_category', 'created_by');

        return view('frontend.courses.edit', compact('course', 'course_categories', 'teachers'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->all());

        if (count($course->thumbnail) > 0) {
            foreach ($course->thumbnail as $media) {
                if (!in_array($media->file_name, $request->input('thumbnail', []))) {
                    $media->delete();
                }
            }
        }
        $media = $course->thumbnail->pluck('file_name')->toArray();
        foreach ($request->input('thumbnail', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $course->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('thumbnail');
            }
        }

        return redirect()->route('frontend.courses.index');
    }

    public function show(Course $course)
    {
        abort_if(Gate::denies('course_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course->load('teacher', 'course_category', 'created_by');

        return view('frontend.courses.show', compact('course'));
    }

    public function destroy(Course $course)
    {
        abort_if(Gate::denies('course_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course->delete();

        return back();
    }

    public function massDestroy(MassDestroyCourseRequest $request)
    {
        Course::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('course_create') && Gate::denies('course_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Course();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
    public function subCategories($id)
    {
        $courses = Course::with(['students'])->where('course_category_id', $id)->whereNull('parent_id')->paginate(10);
        $courses_info = [];
        $parent_course = 0;
        foreach ($courses as $course) {
            $parent_course = Course::where('parent_id', $course->id)->count();
            ($parent_course == 0) ? $course['parent_course'] = false : $course['parent_course'] = true;
            foreach ($course->students as $student) {
                ($student->user_id == Auth::user()->id) ? $course['course_student'] = true : $course['course_student'] = false;
                ($student->pivot->status == 0) ? $course['joined'] = false : $course['joined'] = true;
            }
        }
        return view('frontend.courses.subCategories', compact('courses'));
    }
    public function subCourses($id)
    {
        $course_categories = Course::with(['students'])->where('parent_id', $id)->paginate(10);

        $parent_course = Course::where('id', $id)->first()->title;
        foreach ($course_categories as $course) {
            foreach ($course->students as $student) {
                ($student->user_id == Auth::user()->id) ? $course['course_student'] = true : $course['course_student'] = false;
                ($student->pivot->status == 0) ? $course['joined'] = false : $course['joined'] = true;
            }
        }
        return view('frontend.courses.subCourses', compact('course_categories', 'parent_course'));
    }
}