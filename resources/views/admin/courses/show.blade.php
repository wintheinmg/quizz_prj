@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="custom-header">
            {{ trans('global.show') }} {{ trans('cruds.course.title') }}
            <a href="{{ route('admin.add.newCourse', [$course->id]) }}" class="btn btn-success"> Add Course</a>
        </div>

        <div class="card-body">
            <div class="form-group">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                            type="button" role="tab" aria-controls="home" aria-selected="true">Course</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                            type="button" role="tab" aria-controls="profile" aria-selected="false">Sub Courses</button>
                    </li>

                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <table class="table table-bordered table-striped">
                            <tbody>

                                <tr>
                                    <th>
                                        {{ trans('cruds.course.fields.course_category') }}
                                    </th>
                                    <td>
                                        {{ strtoupper($course->course_category->name ?? '') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.course.fields.title') }}
                                    </th>
                                    <td>
                                        {{ ucwords($course->title) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.course.fields.description') }}
                                    </th>
                                    <td>
                                        {{ ucwords($course->description) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.course.fields.teacher') }}
                                    </th>
                                    <td>
                                        {{ ucwords($course->teacher->name ?? '') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.course.fields.price') }}
                                    </th>
                                    <td>
                                        {{ $course->price }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>


                    {{-- courses  --}}
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <table class="table table-striped">
                            <thead>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Teacher Name</th>
                                {{-- <td>&nbsp;</td> --}}
                            </thead>

                            <tbody>
                                @forelse($child_courses as $cc)
                                    <tr>
                                        <td>{{ ucwords($cc->title) }}</td>
                                        <td>{{ ucwords($cc->description) }}</td>
                                        <td>{{ $cc->price }}</td>
                                        <td>
                                            @foreach ($cc->teachers as $teacher)
                                                <span class="badge bg-info rounded-pill">{{ $teacher->name }}</span>
                                            @endforeach
                                        </td>
                                        {{-- <td>
                                        <a class="p-0 glow"
                                        style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                        href="{{ route('admin.courses.edit', $cc->id) }}">
                                        <i class='bx bx-edit'></i>
                                        </a>
                                    </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No courses found !</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>


                <div class="form-group">
                    <a class="btn btn-secondary" href="{{ route('admin.courses.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
