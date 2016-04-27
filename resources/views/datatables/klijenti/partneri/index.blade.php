@extends('datatables.template2')

@section('breadcrumbs')
    {!! Breadcrumbs::render('klijenti.partneri.index', $klijent) !!}
@section('filters')
        <form id="admin_tariffs_internet_filter">
            <div class="splynx-nav-right">
                @include('partials.refreshTable')
                <a class="btn btn-xs btn-primary novi" data-toggle="modal" data-target="#Modal" data-action="partneri">{{$textDodajGumba}}</a>
                <a class="btn btn-sm btn-primary postavke" data-toggle="modal" data-target="#ModalPostavke" data-action="postavke/@if($TipPostavke){{$TipPostavke->id}}@endif" title="Postavke Klijenta"><i class="glyphicon glyphicon-cog"></i></a>
            </div>
        </form>
    @endsection
@endsection

@section('demo')
    <table id="table" class="display supertable table table-striped table-bordered">
        <thead>
        <tr>
            @foreach($tabelaStupci as $tabelaStupac)
                <th>{{$tabelaStupac[2]}}</th>
                <script type="text/javascript"> columns.push({!! json_encode($tabelaStupac) !!})</script>
            @endforeach
        </tr>
        </thead>
    </table>
@endsection

@section('form')
    @include('datatables.klijenti.partneri.form')
@endsection
@section('otherModals')
        <!-- Modal -->
    <div id="ModalPostavke" class="modal fade" role="dialog" data-modal-index="1">
        <div class="modal-dialog">
            <form id="postavke" class="form-horizontal" action="postavke" method="POST">
                <input id="postMethod" type="hidden" name="_method" value="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Postavke</h4>
                    </div>
                    <div class="modal-body">
                         @include('datatables.klijenti.partneri.formPostavke')
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-sm" type="submit" value="Submit">{{$gumbSpremiTxt}}</button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{$gumbZatvoriTxt}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endsection

@push('scripts')
@section('js')
    <script type="text/javascript">
        var tableId = "table";

        var url = '{{ url("klijenti/".$klijent->id."/partneri/basic-data") }}';

        var filteri = {
        }

        var table = $('#'+tableId).DataTable({
            language : datableLanguage,
            ajax:{
                url : url,
                data: function (d) {
                    $.each(filteri, function(key,value){
                        d[key] = value;
                    })
                }
            },
            columns : vidljivost(columns)
        });

        $('.table_title').html('{{$naslovTabele}}');

    $('#Modal').on('hidden.bs.modal', function() {
        $('form').formValidation('resetForm', true);
    });

    </script>
    @parent
    @endpush
@endsection