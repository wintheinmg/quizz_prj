<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@coreui/coreui@3.2/dist/css/coreui.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    @yield('styles')
</head>

<body class="header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden login-page">
    <div class="c-app flex-row align-items-center">
        <div class="container">
            @yield("content")
        </div>
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
    {{-- <script src="{{ asset('frestui/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script> --}}
    <script src="{{ asset('frestui/assets/vendor/libs/moment/moment.js') }}"></script>

    <script src="{{ asset('frestui/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
{{-- 
    <script src="{{ asset('frestui/assets/js/app-calendar.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/fullcalendar/fullcalendar.js') }}"></script> --}}
    <script src="{{ asset('frestui/assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('frestui/assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
    <script src="{{ asset('frestui/assets/js/offcanvas-add-payment.js') }}"></script>
    <script src="{{ asset('frestui/assets/js/offcanvas-send-invoice.js') }}"></script>
    <script src="{{ asset('frestui/assets/js/app-invoice-edit.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('frestui/assets/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    @yield('scripts')
</body>

</html>