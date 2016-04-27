@extends('datatables.template2')

@section('breadcrumbs')
    {!! Breadcrumbs::render('klijenti.nalozi.index', $klijent) !!}


    @section('filters')
        <form>
            <div class="splynx-nav-right">
                @include('datatables.klijenti.partials.vrstaNalogaFilter')
                @include('partials.refreshTable')
                <a class="btn btn-xs btn-primary novi" data-toggle="modal" data-target="#Modal" data-action="nalozi">{{$textDodajGumba}}</a>
            </div>
        </form>
    @endsection
@endsection
@section('demo')
    <table id="table" class="display supertable table table-striped table-bordered dataTable no-footer dtr-inline">
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
    @include('datatables.klijenti.formNP')
@endsection

@section('otherModals')
    <div id="ModalPartner" class="modal fade" role="dialog" data-modal-index="1">
        <div class="modal-dialog">
            <form id="frmPartneri" class="form-horizontal partner" action="" method="POST">
                <input id="postMethod" type="hidden" name="_method" value="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Podaci partnera</h4>
                    </div>
                    <div class="modal-body">
                        @include('datatables.klijenti.partneri.formPartneriZiro')
                    </div>
                    <div class="modal-footer">
                        <button id="submitPartnera"class="btn btn-primary btn-sm" type="submit" value="Submit">{{$gumbSpremiTxt}}</button>
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

        var url = '{{ url("klijenti/".$klijent->id."/nalozi/basic-data") }}';

        var filteri = {
            "vrstaNalogaFilter" : '{{$vrstaNalogaF}}'
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

    </script>
    @parent
    @endpush
@endsection