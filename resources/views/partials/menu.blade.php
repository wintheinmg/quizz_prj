<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo  text-center d-flex justify-content-center">
        <a href="/" class="app-brand-link ">
            <div class=" w-100 " style="display: flex;
                flex-direction: row;
                align-items: center;">
                {{-- <img src="{{ asset('eas-logo.jpg') }}" class="me-0 rounded-circle" alt="" srcset=""
                style="width: 49px; "> --}}
                <span class="app-brand-text demo menu-text fw-bold ms-1" style="font-size: 20px; " id="logoText">QUIZZ SAMPLE</span>
            </div>

        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle" onclick="clearText()"></i>
            <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <!-- Dashboards -->
        <li class="menu-item {{ request()->is('admin') ? 'active' : '' }}">
            <a href="{{ route('admin.home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div> {{ trans('global.dashboard') }}</div>

            </a>
        </li>

        {{-- User Management --}}
        @can('user_management_access')
            <li
                class="menu-item {{ request()->is('admin/permissions*') ? 'active open' : '' }} {{ request()->is('admin/roles*') ? 'active open' : '' }} {{ request()->is('admin/users*') ? 'active open' : '' }} {{ request()->is('admin/audit-logs*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Dashboards">User management</div>
                </a>
                <ul class="menu-sub">
                    @can('permission_access')
                        <li class="menu-item">
                            <a href="{{ route('admin.permissions.index') }}"
                                class="menu-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="menu-item">
                            <a href="{{ route('admin.roles.index') }}"
                                class="menu-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="menu-item">
                            <a href="{{ route('admin.users.index') }}"
                                class="menu-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li class="menu-item">
                            <a href="{{ route('admin.audit-logs.index') }}"
                                class="menu-link {{ request()->is('admin/audit-logs') || request()->is('admin/audit-logs/*') ? 'active' : '' }}">
                                {{ trans('cruds.auditLog.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        {{-- Teacher Management --}}
        @can('teacher_management_access')
            <li class="menu-item {{ request()->is('admin/teachers*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Dashboards">Teacher management</div>
                </a>
                <ul class="menu-sub">
                    @can('teacher_access')
                        <li class="menu-item">
                            <a href="{{ route('admin.teachers.index') }}"
                                class="menu-link {{ request()->is('admin/teachers') || request()->is('admin/teachers/*') ? 'active' : '' }}">
                                {{ trans('cruds.teacher.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        {{-- Student Management --}}
        @can('student_management_access')
            @php
                $unApprovedUserCount = \App\Helpers\helper::getUnApprovedUserCount();
            @endphp
            <li class="menu-item {{ request()->is('admin/students*') ? 'active open' : '' }} {{ $unApprovedUserCount > 0 ? 'open' : '' }}" >
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Dashboards">Student management</div>
                </a>
                <ul class="menu-sub">
                    @can('student_access')
                        <li class="menu-item" style="position: relative;
                                            cursor: pointer;">
                            <a href="{{ route('admin.students.index') }}"
                                class="menu-link {{ request()->is('admin/students') || request()->is('admin/students/*') ? 'active' : '' }}">
                                {{ trans('cruds.student.title') }}
                            </a>
                            @if($unApprovedUserCount > 0)
                                <span class="badge bg-primary rounded-pill" style="
                                position: absolute;
                                top: 13%;
                                left: 49%;"> {{ $unApprovedUserCount }} </span>
                            @endif
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        {{-- Course Sategory --}}
        @can('course_category_access')
            <li
                class="menu-item {{ request()->is('admin/course-categories') || request()->is('admin/course-categories/*') ? 'active' : '' }}">
                <a href="{{ route('admin.course-categories.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-sitemap"></i>
                    <div> {{ trans('cruds.courseCategory.title') }}</div>
                </a>
            </li>
        @endcan

        {{-- Course --}}
        @can('course_access')
            <li class="menu-item {{ request()->is('admin/courses') || request()->is('admin/courses/*') ? 'active' : '' }}">
                <a href="{{ route('admin.courses.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book-open"></i>
                    <div> {{ trans('cruds.course.title') }}</div>
                </a>
            </li>
        @endcan

        {{-- Course Student --}}
        @can('course_student_access')
            @php
                $joinCourseCount = \App\Helpers\helper::getJoinCourseCount();
            @endphp
            <li
                class="menu-item {{ request()->is('admin/course-students') || request()->is('admin/course-students/*') ? 'active' : '' }}"
                style="position: relative;
                cursor: pointer;">
                <a href="{{ route('admin.course-students.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-user-detail"></i>
                    <div> {{ trans('cruds.courseStudent.title') }}</div>
                    @if($joinCourseCount > 0)
                        <span class="badge bg-primary rounded-pill" style="
                        position: absolute;
                        top: 13%;
                        left: 69%;"> {{ $joinCourseCount }} </span>
                        @endif
                </a>
            </li>
        @endcan

        {{-- Lesson --}}
        @can('lesson_access')
            <li class="menu-item {{ request()->is('admin/lessons') || request()->is('admin/lessons/*') ? 'active' : '' }}">
                <a href="{{ route('admin.lessons.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book"></i>
                    <div> {{ trans('cruds.lesson.title') }}</div>
                </a>
            </li>
        @endcan

        {{-- Test --}}
        @can('test_access')
            <li class="menu-item {{ request()->is('admin/tests') || request()->is('admin/tests/*') ? 'active' : '' }}">
                <a href="{{ route('admin.tests.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-list-ol"></i>
                    <div> {{ trans('cruds.test.title') }}</div>
                </a>
            </li>
        @endcan

        {{-- Question --}}
        @can('question_access')
            <li
                class="menu-item {{ request()->is('admin/questions') || request()->is('admin/questions/*') ? 'active' : '' }}">
                <a href="{{ route('admin.questions.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-notepad"></i>
                    <div> {{ trans('cruds.question.title') }}</div>
                </a>
            </li>
        @endcan

        {{-- Question Option --}}
        {{-- @can('question_option_access')
        <li class="menu-item {{ request()->is("admin/question-options") || request()->is("admin/question-options/*") ? "active" : "" }}">
            <a href="{{ route("admin.question-options.index") }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-note"></i>
                <div> {{ trans('cruds.questionOption.title') }}</div>
            </a>
        </li>
        @endcan --}}

        {{-- Test Result --}}
        @can('test_result_access')
            @php
                $unseenFinishedTestResultCount = \App\Helpers\helper::getUnseenFinishedTestResultCount();
            @endphp
            <li
                class="menu-item {{ request()->is('admin/test-results') || request()->is('admin/test-results/*') ? 'active' : '' }}"
                style="position: relative;
                cursor: pointer;">
                <a href="{{ route('admin.test-results.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-list-check"></i>
                    <div> {{ trans('cruds.testResult.title') }}</div>
                    @if($unseenFinishedTestResultCount > 0)
                        <span class="badge bg-primary rounded-pill" style="
                        position: absolute;
                        top: 15%;
                        left: 61%;"> {{ $unseenFinishedTestResultCount }} </span>
                    @endif
                </a>
            </li>
        @endcan

        {{-- Test Answer --}}
        {{-- @can('test_answer_access')
            <li
                class="menu-item {{ request()->is('admin/test-answers') || request()->is('admin/test-answers/*') ? 'active' : '' }}">
                <a href="{{ route('admin.test-answers.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-check-square"></i>
                    <div> {{ trans('cruds.testAnswer.title') }}</div>
                </a>
            </li>
        @endcan --}}

        {{-- profile password --}}
        @if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li
                    class="menu-item  {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}">
                    <a href="{{ route('profile.password.edit') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-key"></i>
                        <div> {{ trans('global.change_password') }}</div>
                    </a>
                </li>
            @endcan
        @endif
    </ul>
</aside>

<script>
    function clearText(){
        $('#logoText').toggle(); 
    }
</script>
