<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if (isset($description))
    <meta name="description" content="{{ $description }}">
    @else
    <meta name="description" content="Platni nalozi">
    @endif

    <title>Platni nalozi {{ isset($title) ? " | $title" : "" }}</title>

    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrap-theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/datatables.min.css') }}" rel="stylesheet">
    <!--<link href="{{ asset('/css/editor.datatables.min.css') }}" rel="stylesheet">-->
    <link href="{{ asset('/css/jquery.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/splynx.css') }}" rel="stylesheet">
    <style type="text/css">
        #select2Form .form-control-feedback {
            /* To make the feedback icon visible */
            z-index: 100;
        }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 0">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Prikaži Navigaciju</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">Platni nalozi</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    @include('partials.menu')
                </ul>

                @include('partials.navbarRight')

            </div>
        </div>
    </nav>
        @include('partials.leftMenu2')

    <div id="page-wrapper"><br>
        <div id="content">
            <div id="content_admin_dashboard" class="content"><title>Dashboard</title>

            </div>
                @yield('content')
        </div>
    </div>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/select2/i18n/hr.js') }}"></script>
    <script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/datatables/datatables.bootstrap.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/formValidation.min.js') }}"></script>
    <script src="{{ asset('js/formValidator/framework/bootstrap.js') }}"></script>
    <script src="{{ asset('js/formValidator/language/hr_HR.js') }}"></script>
    <script src="{{ asset('js/datetimepicker/datetimepicker.js') }}"></script>
    <script src="{{ asset('js/moment-with-locales.js') }}"></script>
    <script src="{{ asset('js/mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/defaults.js')}}"></script>
    <script src="{{ asset('js/notify.min.js') }}"></script>
    <script src="{{ asset('js/laravel.js')}}"></script>

    @if(Auth::user())
        <script src="{{ asset('js/idile-timer/jquery.userTimeout.js')}}"></script>
        <script>
            $(document).userTimeout({
                logouturl: '{!! route('logout') !!}'
            });
        </script>
    @endif

    @if(Session::has('flash_notification.message') || Session::has('message'))
                <script>
                    @if(Session::has('flash_notification.message'))
                        showNotify("{{Session::get('flash_notification.message')}}","{{Session::get('flash_notification.level')}}");
                    @endif
                </script>
    <?php Session::forget('flash_notification.message')?>
    @endif

    @stack('scripts')


</body>
</html>
