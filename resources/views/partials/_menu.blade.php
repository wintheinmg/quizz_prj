<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">

            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">HMM</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
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

        {{-- user management --}}
        @can('user_management_access')
            <li
                class="menu-item  {{ request()->is('admin/permissions*') ? 'active open' : '' }} {{ request()->is('admin/roles*') ? 'active open' : '' }} {{ request()->is('admin/users*') ? 'active open' : '' }} {{ request()->is('admin/audit-logs*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Dashboards">User management</div>
                </a>
                <ul class="menu-sub">
                    @can('permission_access')
                        <li
                            class="menu-item  {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.permissions.index') }}" class="menu-link">
                                <div data-i18n="Analytics"> {{ trans('cruds.permission.title') }}</div>
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li
                            class="menu-item {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.roles.index') }}" class="menu-link">
                                <div data-i18n="eCommerce"> {{ trans('cruds.role.title') }}</div>
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li
                            class="menu-item {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.users.index') }}" class="menu-link">
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li
                            class="menu-item {{ request()->is('admin/audit-logs') || request()->is('admin/audit-logs/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.audit-logs.index') }}" class="menu-link">
                                <div data-i18n="eCommerce"> {{ trans('cruds.auditLog.title') }}</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('teacher_management_access')
            <li class="menu-item {{ request()->is("admin/teachers*") ? "active open" : "" }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Dashboards">Teacher management</div>
                </a>
                <ul class="menu-sub">
                    @can('teacher_access')
                        <li class="menu-item">
                            <a href="{{ route("admin.teachers.index") }}" class="menu-link {{ request()->is("admin/teachers") || request()->is("admin/teachers/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.teacher.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('student_management_access')
            <li class="menu-item {{ request()->is("admin/students*") ? "active open" : "" }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Dashboards">Student management</div>
                </a>
                <ul class="menu-sub">
                    @can('student_access')
                        <li class="menu-item">
                            <a href="{{ route("admin.students.index") }}" class="menu-link {{ request()->is("admin/students") || request()->is("admin/students/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.student.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('course_category_access')
            <li class="menu-item">
                <a href="{{ route("admin.course-categories.index") }}" class="menu-link {{ request()->is("admin/course-categories") || request()->is("admin/course-categories/*") ? "active" : "" }}">
                    <i class="fa-fw fas fa-book-open c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.courseCategory.title') }}
                </a>
            </li>
        @endcan
        @can('course_access')
            <li class="menu-item">
                <a href="{{ route("admin.courses.index") }}" class="menu-link {{ request()->is("admin/courses") || request()->is("admin/courses/*") ? "active" : "" }}">
                    <i class="fa-fw fas fa-book-open c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.course.title') }}
                </a>
            </li>
        @endcan
        @can('course_student_access')
            <li class="menu-item">
                <a href="{{ route("admin.course-students.index") }}" class="menu-link {{ request()->is("admin/course-students") || request()->is("admin/course-students/*") ? "active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.courseStudent.title') }}
                </a>
            </li>
        @endcan
        @can('lesson_access')
            <li class="menu-item">
                <a href="{{ route("admin.lessons.index") }}" class="menu-link {{ request()->is("admin/lessons") || request()->is("admin/lessons/*") ? "active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.lesson.title') }}
                </a>
            </li>
        @endcan
        @can('test_access')
            <li class="menu-item">
                <a href="{{ route("admin.tests.index") }}" class="menu-link {{ request()->is("admin/tests") || request()->is("admin/tests/*") ? "active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.test.title') }}
                </a>
            </li>
        @endcan
        @can('question_access')
            <li class="menu-item">
                <a href="{{ route("admin.questions.index") }}" class="menu-link {{ request()->is("admin/questions") || request()->is("admin/questions/*") ? "active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.question.title') }}
                </a>
            </li>
        @endcan
        @can('question_option_access')
            <li class="menu-item">
                <a href="{{ route("admin.question-options.index") }}" class="menu-link {{ request()->is("admin/question-options") || request()->is("admin/question-options/*") ? "active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.questionOption.title') }}
                </a>
            </li>
        @endcan
        @can('test_result_access')
            <li class="menu-item">
                <a href="{{ route("admin.test-results.index") }}" class="menu-link {{ request()->is("admin/test-results") || request()->is("admin/test-results/*") ? "active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.testResult.title') }}
                </a>
            </li>
        @endcan
        @can('test_answer_access')
            <li class="menu-item">
                <a href="{{ route("admin.test-answers.index") }}" class="menu-link {{ request()->is("admin/test-answers") || request()->is("admin/test-answers/*") ? "active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.testAnswer.title') }}
                </a>
            </li>
        @endcan

        
        {{-- user alert --}}
        @can('user_alert_access')
            <li
                class="menu-item  {{ request()->is('admin/user-alerts') || request()->is('admin/user-alerts/*') ? 'active' : '' }}">
                <a href="{{ route('admin.user-alerts.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-bell"></i>
                    <div> {{ trans('cruds.userAlert.title') }}</div>
                </a>
            </li>
        @endcan


        

        

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

        {{-- logout --}}
        <li class="menu-item d-none">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();"
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-key"></i>
                <div> {{ trans('global.logout') }}</div>
            </a>
        </li>

    </ul>
</aside>
