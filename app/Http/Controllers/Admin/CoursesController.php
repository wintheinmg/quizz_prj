<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
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

        $courses = Course::with(['teachers', 'course_category', 'created_by', 'media'])->where('parent_id', null)->get();

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        abort_if(Gate::denies('course_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teachers = Teacher::pluck('name', 'id');

        $course_categories = CourseCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        // return $course_categories;

        return view('admin.courses.create', compact('course_categories', 'teachers'));
    }

    public function store(StoreCourseRequest $request)
    {
        // dd($request->hasFile('course_photo'));
        $imagepath = "";
        if ($request->hasFile('course_photo')) {
            $randomize = rand(111111, 999999);
            $extension = $request->course_photo->getClientOriginalName();
            $filename = $randomize . $extension;
            $image = $request->course_photo->move('courses/', $filename);
            $imagepath = 'courses/' . $filename;
        }

        if ($request->sub_course1 == null && $request->sub_course_price1 == null) {
            // dd($imagepath);
            $course = Course::create([
                'title' => $request->title,
                'price' => $request->price,
                'description' => $request->description,
                'course_category_id' => $request->course_category_id,
                'image' => $imagepath
            ]);
            $course->teachers()->attach($request->teacher_id);
        } else {
            $course = Course::create([
                'title' => $request->title,
                'price' => $request->price ?? null,
                'description' => $request->description,
                'course_category_id' => $request->course_category_id,
                'image' => $imagepath
            ]);
            for ($i = 1; $i <= $request->sub_course_count; $i++) {
                $subCourse = 'sub_course' . $i;
                $photo = "sub_course_photo" . $i;
                if (isset($request->$subCourse)) {
                    $imagepath = "";
                    if ($request->hasFile($photo)) {
                        $randomize = rand(111111, 999999);
                        $extension = $request->$photo->getClientOriginalName();
                        $filename = $randomize . $extension;
                        $image = $request->$photo->move('courses/', $filename);
                        $imagepath = 'courses/' . $filename;
                    }
                    $sub_course = Course::create([
                        'title' => $request->input('sub_course' . $i),
                        'price' => $request->input('sub_course_price' . $i),
                        'description' => $request->input('sub_course_description' . $i),
                        'course_category_id' => $request->course_category_id,
                        'parent_id' => $course->id,
                        'image' => $imagepath
                    ]);
                    $sub_course->teachers()->attach($request->input('teacher_id' . $i));
                }
            }
        }


        foreach ($request->input('thumbnail', []) as $file) {
            $course->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('thumbnail');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $course->id]);
        }

        return redirect()->route('admin.courses.index');
    }

    public function edit(Course $course)
    {
        abort_if(Gate::denies('course_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teachers = Teacher::pluck('name', 'id');

        $course_categories = CourseCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $course->load('teachers', 'course_category', 'created_by');

        $sub_courses = Course::where('parent_id', $course->id)->get();

        if (isset($course->parent_id)) {
            $parent_title = Course::findOrFail($course->parent_id);
        } else {
            $parent_title = '';
        }

        // return $course;
        return view('admin.courses.edit', compact('course', 'sub_courses', 'course_categories', 'teachers', 'parent_title'));
    }



    public function update(UpdateCourseRequest $request, Course $course)
    {
        // dd($request->all());
        // dd($course->image);
        if ($course->image) {
            if ($request->hasFile('course_photo')) {
                $randomize = rand(111111, 999999);
                $extension = $request->photo->getClientOriginalName();
                $filename = $randomize . '.' . $extension;
                $image = $request->photo->move('courses/', $filename);
                $imagepath = 'courses/' . $filename;
                if ($course->image) {
                    File::delete($course->image);
                }
                $course->update([
                    'image' => $imagepath
                ]);
            }
        }
        $course->update([
            'title' => $request->title,
            'price' => $request->price ?? null,
            'description' => $request->description,
            'course_category_id' => $request->course_category_id,
        ]);

        $course->teachers()->sync($request->teacher_id);
        // return $request->all();


        for ($i = 0; $i < $request->sub_course_count; $i++) {
            $subCourse = 'sub_course' . $i;
            $photo = "sub_course_photo" . $i;
            if (isset($request->$subCourse)) {
                $subcourse = Course::where('id', $request->input('sub_course_id' . $i))->first();
                if ($request->hasFile($photo)) {
                    $randomize = rand(111111, 999999);
                    $extension = $request->$photo->getClientOriginalName();
                    $filename = $randomize . '.' . $extension;
                    $image = $request->$photo->move('courses/', $filename);
                    $imagepath = 'courses/' . $filename;
                    if ($course->image) {
                        File::delete($course->image);
                    }
                    $subcourse->update([
                        'image' => $image
                    ]);
                }
                Course::where('id', $request->input('sub_course_id' . $i))->update([
                    'title' => $request->input('sub_course' . $i),
                    'price' => $request->input('sub_course_price' . $i) ?? null,
                    'description' => $request->input('sub_course_description' . $i),
                    'course_category_id' => $request->course_category_id,
                ]);
                $subcourse->teachers()->sync($request->input('sub_course_teacher_id' . $i));
            }
        }

        if ($request->status && $request->new_sub_course0 != null && $request->new_sub_course_price0 != null) {
            for ($i = 0; $i <= $request->new_sub_course_count; $i++) {
                $new_sub_course =  'new_sub_course' . $i;
                $new_sub_cours_photo = 'new_sub_course_photo' . $i;
                if (isset($request->$new_sub_course)) {
                    $imagepath = "";
                    // dd($request->hasFile($new_sub_cours_photo));
                    if ($request->hasFile($new_sub_cours_photo)) {
                        $randomize = rand(111111, 999999);
                        $extension = $request->$new_sub_cours_photo->getClientOriginalName();
                        $filename = $randomize . '.' . $extension;
                        $image = $request->$new_sub_cours_photo->move('courses/', $filename);
                        $imagepath = 'courses/' . $filename;
                    }
                    $newcourse = Course::create([
                        'title' => $request->input('new_sub_course' . $i),
                        'price' => $request->input('new_sub_course_price' . $i),
                        'description' => $request->input('new_sub_course_description' . $i),
                        'course_category_id' => $request->course_category_id,
                        'parent_id' => $course->id,
                        'image' => $imagepath
                    ]);
                    $newcourse->teachers()->sync($request->input('new_teacher_id' . $i));
                }
            }
        } else {
            for ($i = 1; $i <= $request->new_sub_course_count; $i++) {

                $new_sub_course =  'new_sub_course' . $i;
                $new_sub_cours_photo = 'new_sub_course_photo' . $i;
                // dd(isset($request->$new_sub_course));
                if (isset($request->$new_sub_course)) {
                    $imagepath = "";
                    if ($request->hasFile($new_sub_cours_photo)) {
                        $randomize = rand(111111, 999999);
                        $extension = $request->$new_sub_cours_photo->getClientOriginalName();
                        $filename = $randomize . '.' . $extension;
                        $image = $request->$new_sub_cours_photo->move('courses/', $filename);
                        $imagepath = 'courses/' . $filename;
                    }
                    $newcourse = Course::create([
                        'title' => $request->input('new_sub_course' . $i),
                        'price' => $request->input('new_sub_course_price' . $i),
                        'description' => $request->input('new_sub_course_description' . $i),
                        'course_category_id' => $request->course_category_id,
                        'parent_id' => $course->id,
                        'image' => $imagepath
                    ]);
                    $newcourse->teachers()->sync($request->input('new_teacher_id' . $i));
                }
            }
        }

        return redirect()->route('admin.courses.index');

        if ($request->status) {
            return redirect()->route('admin.courses.show', $request->parent_id);
        } else {
            return redirect()->route('admin.courses.index');
        }
    }

    // public function updateChildCourse(UpdateCourseRequest $request, Course $course) {
    //     $course->update($request->all());

    //     return 
    // }

    public function show(Course $course)
    {
        abort_if(Gate::denies('course_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course->load('teachers', 'course_category', 'created_by');

        $child_courses = Course::with('course_category')->where('parent_id', $course->id)->get();

        // return $child_courses;

        return view('admin.courses.show', compact('course', 'child_courses'));
    }

    public function destroy(Course $course)
    {
        abort_if(Gate::denies('course_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Course::where('parent_id', $course->id)->delete();

        $course->delete();


        return back();
    }

    public function deleteCourse(Request $request)
    {
        $course = Course::find($request->id);
        File::delete($course->image);
        $course->delete();

        return 'delete success';
    }

    public function massDestroy(Request $request)
    {
        Course::where('parent_id', $request->id)->delete();

        Course::where('id', $request->id)->delete();

        return 'delete success';
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

    //add new child course
    public function addNewCourse($id)
    {
        $teachers = Teacher::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $course_categories = CourseCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $parent_course = Course::findOrFail($id);

        // return $id;

        return  view('admin.courses.add_new_course', compact('teachers', 'course_categories', 'parent_course', 'id'));
    }

    //store new child course
    public function storeNewCourse(Request $request)
    {
        // return $request->all();

        for ($i = 1; $i <= $request->sub_course_count; $i++) {
            Course::create([
                'title' => $request->input('sub_course' . $i),
                'price' => $request->input('sub_course_price' . $i),
                'description' => $request->input('sub_course_description' . $i),
                'teacher_id' => $request->input('teacher_id' . $i),
                'course_category_id' => $request->course_category_id,
                'parent_id' => $request->parent_id,
            ]);
        }

        return redirect()->route('admin.courses.show', $request->parent_id);
    }
}