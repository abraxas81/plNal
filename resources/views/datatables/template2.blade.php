@extends('app')
<script type="text/javascript">var columns = [];var columns2 = [];</script>
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
        <!-- Modal -->
        <div id="Modal" class="modal fade" role="dialog" data-modal-index="1">
            <div class="modal-dialog">
                <form id="{{$formName}}" class="form-horizontal main" action="" method="POST" data-ajax="false">
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
                            @if(isset($predlozak))
                                @if(!$predlozak)
                                    <a id="nalogSelector" class="btn btn-primary btn-sm predNalSel" data-route="" data-method="PATCH" @if(!$predlozak) style="display:none" @endif>Predlozak</a>
                                    <a id="predlozakSelector" class="btn btn-primary btn-sm predNalSel" data-route="predlosci" @if($predlozak) style="display:none" @endif data-method="POST">Nalog</a>
                                @endif
                            @endif
                            <button id="spremi" type="submit" class="btn btn-primary btn-sm">{{$gumbSpremiTxt}}</button>
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{$gumbZatvoriTxt}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @include('partials.postavkeOperatera')

        @yield('otherModals')

        <div id="PostavkeTabele" class="modal fade PostavkeTabele" role="dialog" data-modal-index="1">
            <div class="modal-dialog">
                <form id="frmPostavkeTabele" class="form-horizontal main" action="" method="POST" data-ajax="false">
                    <input id="postMethod" type="hidden" name="_method" value="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Postavke tabele</h4>
                        </div>
                        <div class="modal-body">
                            @include('datatables.operateri.postavke.formTabele');
                        </div>
                        <div class="modal-footer">
                            <button id="spremi" type="submit" class="btn btn-primary btn-sm">{{$gumbSpremiTxt}}</button>
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{$gumbZatvoriTxt}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@show

@endsection

@push('scripts')

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/datatables/jquery.dataTables.editable.js') }}"></script>
<script>window.csrfToken = '<?php echo csrf_token(); ?>';</script>
@yield('js')
@yield('rewritableJs')
@endpush

