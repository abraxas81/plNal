@extends('datatables.template2')

@section('breadcrumbs')
    {!! Breadcrumbs::render('klijenti.zbrojniNalog.nalozi.index', $klijent, $zbrojniNalog) !!}
    @section('filters')
        <form>
            <div class="splynx-nav-right">
                @include('partials.refreshTable')
                <a class="btn btn-xs btn-primary novi" data-toggle="modal" data-target="#Modal" data-action="nalozi">{{$textDodajGumba}}</a>
                <a id='tabSelector' class="btn btn-xs btn-primary tabSelector" href="#predlosci" data-toggle="tab" data-action="predlosci" data-textgumba="Dodaj Predložak">Prikaži Predloške</a>
                <a id='naloziTab' class="btn btn-xs btn-primary tabSelector" href="#nalozi" data-toggle="tab" data-action="nalozi" data-textgumba="{{$textDodajGumba}}" style="display:none">Prikaži Naloge</a>
            </div>
        </form>
    @endsection
@endsection
@section('demo')
    <div class="tab-content">
        <div class="tab-pane active" id="nalozi">

            <table id="table" class="display supertable table table-striped table-bordered dataTable no-footer dtr-inline">
                <thead>
                <tr>
                    @foreach($tabelaStupci as $tabelaStupac)
                        <th>{{$tabelaStupac[2]}}</th>
                        <script type="text/javascript">columns.push({!! json_encode($tabelaStupac) !!})</script>
                    @endforeach
                </tr>
                </thead>
            </table>
        </div>
        <div class="tab-pane" id="predlosci">
            <table id="table2" class="display supertable table table-striped table-bordered dataTable no-footer dtr-inline">
                <thead>
                <tr>
                    @foreach($tabelaStupci2 as $tabelaStupac2)
                        <th>{{$tabelaStupac2[2]}}</th>
                        <script type="text/javascript"> columns2.push({!! json_encode($tabelaStupac2) !!})</script>
                    @endforeach
                </tr>
                </thead>
            </table>
        </div>
    </div>
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
        var tableId2 = "table2";

        var url = '{{ url("klijenti/".$klijent->id."/zbrojniNalog/".$zbrojniNalog->id."/nalozi/basic-data") }}';
        var url2 = '{{ url("klijenti/".$klijent->id."/zbrojniNalog/".$zbrojniNalog->id."/predlosci/basic-data") }}';
        var filteri = {
            "alphabetSearch" : '',
            "vrstaNalogaFilter" : '{{$vrstaNalogaF}}'
        }
        var filteri2 = {
            "alphabetSearch" : '',
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
        
        var table2 = $('#'+tableId2).DataTable({
            language : datableLanguage,
            ajax:{
                url : url2,
                data: function (d) {
                    $.each(filteri2, function(key,value){
                        d[key] = value;
                    })
                }
            },
            columns : vidljivost(columns2)
        });

        $('#refresh').on('click', function(){
            table.draw();
        })
        var tableTitle = 'Nalozi';
        //$('#table').closest('div.table_title').html('Nalozi');
        $('.table_title').html(tableTitle);

        alphabetSearch(table2, filteri2);

        $('.tabSelector').on('click', function(){
            var el = $(this);
            //akcija za toogle predlosci nalozi
            var action = el.attr('data-action');
            action === 'predlosci' ? ($('#predlozakSelector').trigger('click'),tableTitle = 'Predlosci'):($('#NalogSelector').trigger('click'),tableTitle = 'Nalozi') ;
            $('.table_title').html(tableTitle);
            $(el.attr('href')).show;
            $('.tabSelector').toggle();
            $('.novi').data('action', el.data('action')).text(el.data('textgumba'));
        })

    </script>
    @parent
    @endpush
@endsection