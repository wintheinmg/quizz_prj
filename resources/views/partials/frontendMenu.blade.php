<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link">
            <span class="app-brand-logo demo">

            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">EAS LMS</span>
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
        <li class="menu-item {{ request()->is('user/home') ? 'active' : '' }}">
            <a href="{{ route('user.frontend.home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div> {{ trans('global.dashboard') }}</div>

            </a>
        </li>

        <!-- Course -->
        @can('course_access')
            <li class="menu-item {{ request()->is('user/courses') || request()->is('user/courses/*') ? 'active' : '' }}">
                <a href="{{ route('user.courses.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book-reader"></i>
                    <div>
                        {{ trans('cruds.course.title') }}
                    </div>

                </a>
            </li>
        @endcan

        <!-- Test -->
        @can('test_access')
            <li class="menu-item {{ request()->is('user/tests') || request()->is('user/tests/*') ||request()->is('user/questions') || request()->is('user/questions/*') ? 'active' : '' }}">
                <a href="{{ route('user.tests.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-list-ol"></i>
                    <div>
                        {{ trans('cruds.test.title') }}
                    </div>

                </a>
            </li>
        @endcan



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
