@extends('datatables.template2')

@section('breadcrumbs')
    {!! Breadcrumbs::render('klijenti.zbrojniNalog.index', $klijent) !!}
    @section('filters')
        <form>
            <div class="splynx-nav-right">
                @include('datatables.klijenti.partials.vrstaNalogaFilter')
                @include('partials.refreshTable')
                <a class="btn btn-xs btn-primary novi" data-toggle="modal" data-target="#Modal" data-action="zbrojniNalog">{{$textDodajGumba}}</a>
            </div>
        </form>
    @endsection
@endsection

@section('demo')
    <table id="table" class="display supertable table table-striped table-bordered dataTable no-footer dtr-inline">
        <thead>
            @foreach($tabelaStupci as $tabelaStupac)
                <th>{{$tabelaStupac[2]}}</th>
                <script type="text/javascript">columns.push({!! json_encode($tabelaStupac) !!})</script>
            @endforeach
        </thead>
    </table>
@endsection

@section('form')
    @include('datatables.klijenti.zbrojniNalog.form')
@endsection

@push('scripts')
@section('js')
    <script type="text/javascript">
        var tableId = "table";

        var url = '{{ url("klijenti/".$klijent->id."/zbrojniNalog/basic-data") }}';

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

        //alphabetSearch(table, filteri);

        $('form').formValidation({
            framework: 'bootstrap',
            excluded: ':disabled',
            err: {
                container: 'tooltip'
            },
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            locale: 'hr_HR',
            fields: {
                Naziv: {
                    validators: {
                        notEmpty: {}
                    }
                }
            }
        });
    </script>
    @parent
    @endpush
@endsection