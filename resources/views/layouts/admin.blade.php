<!DOCTYPE html>
<html class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('frestui/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('frestui/assets/vendor/libs/quill/editor.css') }}" />
    <link rel="stylesheet" href="{{ asset('frestui/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('frestui/assets/vendor/css/pages/app-calendar.css') }}" />
    <link rel="stylesheet" href="{{ asset('frestui/assets/vendor/libs/fullcalendar/fullcalendar.css') }}" />
    {{-- fresui --}}
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('frestui/assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('frestui/assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('frestui/assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('frestui/assets/vendor/css/rtl/core.css') }}"/>
    <link rel="stylesheet" href="{{ asset('frestui/assets/vendor/css/rtl/theme-default.css') }}"/>
    <link rel="stylesheet" href="{{ asset('frestui/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('frestui/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('frestui/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('frestui/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('frestui/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('frestui/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('frestui/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('frestui/assets/vendor/css/pages/app-invoice.css') }}" />
    {{-- custom --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('styles')

</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('partials.menu')
            {{-- nav and search --}}
            <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
                <div class="container-fluid">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <!-- <div class="navbar-nav align-items-center">
                            <div class="nav-item navbar-search-wrapper mb-0">
                                <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);">
                                    <i class="bx bx-search-alt bx-sm"></i>
                                    <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
                                </a>
                            </div>
                        </div> -->
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Language -->
                            {{-- <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <i class="fi fi-us fis rounded-circle fs-3 me-1"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-language="en">
                                            <i class="fi fi-us fis rounded-circle fs-4 me-1"></i>
                                            <span class="align-middle">English</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-language="fr">
                                            <i class="fi fi-fr fis rounded-circle fs-4 me-1"></i>
                                            <span class="align-middle">French</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-language="de">
                                            <i class="fi fi-de fis rounded-circle fs-4 me-1"></i>
                                            <span class="align-middle">German</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-language="pt">
                                            <i class="fi fi-pt fis rounded-circle fs-4 me-1"></i>
                                            <span class="align-middle">Portuguese</span>
                                        </a>
                                    </li>
                                </ul>
                            </li> --}}
                            <!--/ Language -->

                            <!-- Style Switcher -->
                            <li class="nav-item me-2 me-xl-0">
                                <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                                    <i class="bx bx-sm"></i>
                                </a>
                            </li>
                            <!--/ Style Switcher -->

                            <!-- Quick links  -->
                            <!-- <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                    <i class="bx bx-grid-alt bx-sm"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end py-0">
                                    <div class="dropdown-menu-header border-bottom">
                                        <div class="dropdown-header d-flex align-items-center py-3">
                                            <h5 class="text-body mb-0 me-auto">Shortcuts</h5>
                                            <a href="javascript:void(0)" class="dropdown-shortcuts-add text-body"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Add shortcuts"><i class="bx bx-sm bx-plus-circle"></i></a>
                                        </div>
                                    </div>
                                    <div class="dropdown-shortcuts-list scrollable-container">
                                        <div class="row row-bordered overflow-visible g-0">
                                            <div class="dropdown-shortcuts-item col">
                                                <span
                                                    class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                                    <i class="bx bx-calendar fs-4"></i>
                                                </span>
                                                <a href="app-calendar.html" class="stretched-link">Calendar</a>
                                                <small class="text-muted mb-0">Appointments</small>
                                            </div>
                                            <div class="dropdown-shortcuts-item col">
                                                <span
                                                    class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                                    <i class="bx bx-food-menu fs-4"></i>
                                                </span>
                                                <a href="app-invoice-list.html" class="stretched-link">Invoice App</a>
                                                <small class="text-muted mb-0">Manage Accounts</small>
                                            </div>
                                        </div>
                                        <div class="row row-bordered overflow-visible g-0">
                                            <div class="dropdown-shortcuts-item col">
                                                <span
                                                    class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                                    <i class="bx bx-user fs-4"></i>
                                                </span>
                                                <a href="app-user-list.html" class="stretched-link">User App</a>
                                                <small class="text-muted mb-0">Manage Users</small>
                                            </div>
                                            <div class="dropdown-shortcuts-item col">
                                                <span
                                                    class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                                    <i class="bx bx-check-shield fs-4"></i>
                                                </span>
                                                <a href="app-access-roles.html" class="stretched-link">Role
                                                    Management</a>
                                                <small class="text-muted mb-0">Permission</small>
                                            </div>
                                        </div>
                                        <div class="row row-bordered overflow-visible g-0">
                                            <div class="dropdown-shortcuts-item col">
                                                <span
                                                    class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                                    <i class="bx bx-pie-chart-alt-2 fs-4"></i>
                                                </span>
                                                <a href="index.html" class="stretched-link">Dashboard</a>
                                                <small class="text-muted mb-0">User Profile</small>
                                            </div>
                                            <div class="dropdown-shortcuts-item col">
                                                <span
                                                    class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                                    <i class="bx bx-cog fs-4"></i>
                                                </span>
                                                <a href="pages-account-settings-account.html"
                                                    class="stretched-link">Setting</a>
                                                <small class="text-muted mb-0">Account Settings</small>
                                            </div>
                                        </div>
                                        <div class="row row-bordered overflow-visible g-0">
                                            <div class="dropdown-shortcuts-item col">
                                                <span
                                                    class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                                    <i class="bx bx-help-circle fs-4"></i>
                                                </span>
                                                <a href="pages-help-center-landing.html" class="stretched-link">Help
                                                    Center</a>
                                                <small class="text-muted mb-0">FAQs & Articles</small>
                                            </div>
                                            <div class="dropdown-shortcuts-item col">
                                                <span
                                                    class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                                    <i class="bx bx-window-open fs-4"></i>
                                                </span>
                                                <a href="modal-examples.html" class="stretched-link">Modals</a>
                                                <small class="text-muted mb-0">Useful Popups</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li> -->
                            <!-- Quick links -->

                            <!-- Notification -->
                            {{-- <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                    <i class="bx bx-bell bx-sm"></i>
                                    <span class="badge bg-danger rounded-pill badge-notifications">5</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end py-0">
                                    <li class="dropdown-menu-header border-bottom">
                                        <div class="dropdown-header d-flex align-items-center py-3">
                                            <h5 class="text-body mb-0 me-auto">Notification</h5>
                                            <a href="javascript:void(0)" class="dropdown-notifications-all text-body"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Mark all as read"><i class="bx fs-4 bx-envelope-open"></i></a>
                                        </div>
                                    </li>
                                    <li class="dropdown-notifications-list scrollable-container">
                                        <ul class="list-group list-group-flush">
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <img src="{{ asset('frestui/assets/img/avatars/user.png') }}" alt
                                                                class="w-px-40 h-auto rounded-circle" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Congratulation Lettie 🎉</h6>
                                                        <p class="mb-0">Won the monthly best seller gold badge</p>
                                                        <small class="text-muted">1h ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-archive"><span
                                                                class="bx bx-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <span
                                                                class="avatar-initial rounded-circle bg-label-danger">CF</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Charles Franklin</h6>
                                                        <p class="mb-0">Accepted your connection</p>
                                                        <small class="text-muted">12hr ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-archive"><span
                                                                class="bx bx-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <img src="../../assets/img/avatars/2.png" alt
                                                                class="w-px-40 h-auto rounded-circle" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">New Message ✉️</h6>
                                                        <p class="mb-0">You have new message from Natalie</p>
                                                        <small class="text-muted">1h ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-archive"><span
                                                                class="bx bx-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <span
                                                                class="avatar-initial rounded-circle bg-label-success"><i
                                                                    class="bx bx-cart"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Whoo! You have new order 🛒</h6>
                                                        <p class="mb-0">ACME Inc. made new order $1,154</p>
                                                        <small class="text-muted">1 day ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-archive"><span
                                                                class="bx bx-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <img src="../../assets/img/avatars/9.png" alt
                                                                class="w-px-40 h-auto rounded-circle" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Application has been approved 🚀</h6>
                                                        <p class="mb-0">Your ABC project application has been
                                                            approved.</p>
                                                        <small class="text-muted">2 days ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-archive"><span
                                                                class="bx bx-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <span
                                                                class="avatar-initial rounded-circle bg-label-success"><i
                                                                    class="bx bx-pie-chart-alt"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Monthly report is generated</h6>
                                                        <p class="mb-0">July monthly financial report is generated
                                                        </p>
                                                        <small class="text-muted">3 days ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-archive"><span
                                                                class="bx bx-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <img src="../../assets/img/avatars/5.png" alt
                                                                class="w-px-40 h-auto rounded-circle" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Send connection request</h6>
                                                        <p class="mb-0">Peter sent you connection request</p>
                                                        <small class="text-muted">4 days ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-archive"><span
                                                                class="bx bx-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <img src="../../assets/img/avatars/6.png" alt
                                                                class="w-px-40 h-auto rounded-circle" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">New message from Jane</h6>
                                                        <p class="mb-0">Your have new message from Jane</p>
                                                        <small class="text-muted">5 days ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-archive"><span
                                                                class="bx bx-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <span
                                                                class="avatar-initial rounded-circle bg-label-warning"><i
                                                                    class="bx bx-error"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">CPU is running high</h6>
                                                        <p class="mb-0">CPU Utilization Percent is currently at
                                                            88.63%,</p>
                                                        <small class="text-muted">5 days ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-archive"><span
                                                                class="bx bx-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-menu-footer border-top">
                                        <a href="javascript:void(0);"
                                            class="dropdown-item d-flex justify-content-center p-3">
                                            View all notifications
                                        </a>
                                    </li>
                                </ul>
                            </li> --}}
                            <!--/ Notification -->

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('frestui/assets/img/avatars/user.png') }}" alt class="rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    {{-- <li>
                                        <a class="dropdown-item" href="pages-account-settings-account.html">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ asset('frestui/assets/img/avatars/user.png') }}" alt
                                                            class="rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block lh-1">Admin</span>
                                                    <small>Admin</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="pages-profile-user.html">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="pages-account-settings-account.html">
                                            <i class="bx bx-cog me-2"></i>
                                            <span class="align-middle">Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="pages-account-settings-billing.html">
                                            <span class="d-flex align-items-center align-middle">
                                                <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                                                <span class="flex-grow-1 align-middle">Billing</span>
                                                <span
                                                    class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="pages-help-center-landing.html">
                                            <i class="bx bx-support me-2"></i>
                                            <span class="align-middle">Help</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="pages-faq.html">
                                            <i class="bx bx-help-circle me-2"></i>
                                            <span class="align-middle">FAQ</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="pages-pricing.html">
                                            <i class="bx bx-dollar me-2"></i>
                                            <span class="align-middle">Pricing</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li> --}}
                                    <li>
                                        <a class="dropdown-item"
                                            onclick="event.preventDefault(); document.getElementById('logoutform').submit();"
                                            href="#">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>

                    <!-- Search Small Screens -->
                    <div class="navbar-search-wrapper search-input-wrapper d-none">
                        <div class="d-flex">
                            <input type="text" class="form-control search-input container-fluid border-0"
                                id="searchInput" placeholder="Search..." aria-label="Search..." />
                            {{-- <i class="bx bx-x bx-sm search-toggler cursor-pointer closeSearch"></i> --}}
                        </div>

                    </div>

                </div>
            </nav>
            <div class="layout-page">
                <div class="content-wrapper mt-5" style="position: relative;">
                    <div class="shadow ms-3 rounded d-none" id="searchFilter">

                    </div>
                    <div class="container-xxl flex-grow-1 container-p-y" id="forBlur">

                        @yield('content')
                    </div>

                </div>
            </div>
            {{-- main --}}

        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="bg-blur d-none closeSearch"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
        <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
    <!-- Helpers -->
    <script src="{{ asset('frestui/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('frestui/assets/js/config.js') }}"></script>
    <script src="{{ asset('frestui/assets/js/config.js') }}"></script>

    <!-- Core JS -->
    <script src="{{ asset('frestui/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('frestui/assets/vendor/libs/hammer/hammer.js') }}"></script>

    <script src="{{ asset('frestui/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

    <script src="{{ asset('frestui/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('frestui/assets/js/forms-pickers.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('frestui/assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/datatables-responsive/datatables.responsive.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/datatables-buttons/datatables-buttons.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/jszip/jszip.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/pdfmake/pdfmake.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/datatables-buttons/buttons.html5.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/datatables-buttons/buttons.print.js') }}"></script>
    <!-- Flat Picker -->
    <script src="{{ asset('frestui/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/moment/moment.js') }}"></script>

    <script src="{{ asset('frestui/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>

    <script src="{{ asset('frestui/assets/js/app-calendar.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/fullcalendar/fullcalendar.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
    <script src="{{ asset('frestui/assets/js/offcanvas-add-payment.js') }}"></script>
    <script src="{{ asset('frestui/assets/js/offcanvas-send-invoice.js') }}"></script>
    <script src="{{ asset('frestui/assets/js/app-invoice-edit.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('frestui/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('frestui/assets/js/cards-statistics.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#searchInput").on("keyup", () => {
                $.ajax({
                    url: "/api/search?search=" + $("#searchInput").val(),
                    method: "GET",
                    success: (data) => {
                        console.log(data);
                        let datas = data.results;
                        let htmls = "";
                        if (datas.length > 0) {

                            datas.forEach((data) => {
                                htmls += `
                                <a class="text-decoration-none" href="${data.url}">
                                    <p class="fw-bold text-dark">${data.model}</p>
                                    <p class="text-black-50">Name : ${data[data.fields[0]]}</p>
                                </a>
                                `;
                            });
                        } else {
                            htmls = `<p class="fw-bold text-dark">There is no data!!!</p>`;
                        }
                        $("#searchFilter").html(htmls);
                    }
                })
                if ($("#searchInput").val()) {
                    $("#searchFilter").removeClass('d-none');
                    $(".bg-blur").removeClass('d-none');
                }
                console.log($("#searchInput").val());
            })

            $('.closeSearch').on("click", () => {
                $(".bg-blur").addClass('d-none');
                $("#searchFilter").addClass('d-none');
            })

            $(".notifications-menu").on('click', function() {
                if (!$(this).hasClass('open')) {
                    $('.notifications-menu .label-warning').hide();
                    $.get('/admin/user-alerts/read');
                }
            });
        });
    </script>
    <script>
        $(() => {
                        
            $('.select-all').click(function () {
                let $select2 = $(this).parent().siblings('.select2')
                $select2.find('option').prop('selected', 'selected')
                $select2.trigger('change')
            })
            $('.deselect-all').click(function () {
                let $select2 = $(this).parent().siblings('.select2')
                $select2.find('option').prop('selected', '')
                $select2.trigger('change')
            })
            $('.select2').select2();
            //csv modal
            let csvModal = new bootstrap.Modal(document.getElementById('csvImportModal'));
            $("button[data-toggle='modal']").on('click', () => {
                csvModal.show();
            })

            $("button[data-dismiss='modal']").on('click', () => {
                csvModal.hide();
            })
        });
    </script>
    @yield('scripts')
</body>

</html>
