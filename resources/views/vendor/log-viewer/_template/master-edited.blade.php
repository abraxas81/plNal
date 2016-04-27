@extends('app')
<title>Platni Nalozi | Preglednik logova</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.15.35/css/bootstrap-datetimepicker.min.css">
@include('log-viewer::_template.style')
@section('content')
    <div class="splynx_top_nav" style="height: 39px;">
        <div style="float: left">
            <div class="splynx-nav-info">
                @yield('breadcrumbs')
            </div>
        </div>
        @yield('filters')
    </div>
    @yield('demo')

@section('modal')
    <div class="container2">
        
        @include('partials.postavkeOperatera')

        @yield('otherModals')

        @include('partials.auto_logout')

    </div>
@show

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<script>
    Chart.defaults.global.responsive      = true;
    Chart.defaults.global.scaleFontFamily = "'Source Sans Pro'";
    Chart.defaults.global.animationEasing = "easeOutQuart";
</script>

@push('scripts')
<script src="{{ asset('js/app.js') }}"></script>
<script>window.csrfToken = '<?php echo csrf_token(); ?>';</script>
@yield('js')
@yield('rewritableJs')
@endpush

