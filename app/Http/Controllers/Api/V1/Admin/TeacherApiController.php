<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Http\Resources\Admin\TeacherResource;
use App\Models\Teacher;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('teacher_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TeacherResource(Teacher::with(['created_by'])->get());
    }

    public function store(StoreTeacherRequest $request)
    {
        $teacher = Teacher::create($request->all());

        foreach ($request->input('certificate_files', []) as $file) {
            $teacher->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('certificate_files');
        }

        return (new TeacherResource($teacher))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Teacher $teacher)
    {
        abort_if(Gate::denies('teacher_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TeacherResource($teacher->load(['created_by']));
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        $teacher->update($request->all());

        if (count($teacher->certificate_files) > 0) {
            foreach ($teacher->certificate_files as $media) {
                if (!in_array($media->file_name, $request->input('certificate_files', []))) {
                    $media->delete();
                }
            }
        }
        $media = $teacher->certificate_files->pluck('file_name')->toArray();
        foreach ($request->input('certificate_files', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $teacher->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('certificate_files');
            }
        }

        return (new TeacherResource($teacher))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Teacher $teacher)
    {
        abort_if(Gate::denies('teacher_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teacher->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
