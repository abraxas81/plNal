@extends('app')

@section('content')
    @yield('breadcrumbs')
<div class="tabs">
    <ul class="nav nav-tabs">
        <li class="active tipKlijenta" data-tipklijenta="platitelj"><a data-toggle="tab" href="#demo">Platitelj</a></li>
        <li class="tipKlijenta" data-tipklijenta="primatelj"><a data-toggle="tab" href="#demo">Primatelj</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="demo">
            @yield('demo')
        </div>
    </div>
</div>
@endsection

@section('modal')
<!-- Modal -->
<div id="Modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form class="form-horizontal" action="" method="POST">
        <input id="postMethod" type="hidden" name="_method" value="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ isset($naslovModala) ? $naslovModala : "" }}</h4>
            </div>
            <div class="modal-body">
               @yield('form')
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit" value="Submit">Spremi</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        </form>
    </div>
</div>
@show

@push('scripts')
<script src="{{ asset('js/laravel.js') }}"></script>
<script>window.csrfToken = '<?php echo csrf_token(); ?>';</script>
@yield('js')
@endpush
