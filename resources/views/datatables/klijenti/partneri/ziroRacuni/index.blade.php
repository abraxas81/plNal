@extends('datatables.template2')

@section('breadcrumbs')
    {!! Breadcrumbs::render('klijenti.partneri.ziro.index', $klijent,$partner) !!}
    @section('filters')
        <form id="admin_tariffs_internet_filter">
            <div class="splynx-nav-right">
                @include('partials.refreshTable')
                <a class="btn btn-xs btn-primary novi" data-toggle="modal" data-target="#Modal" data-action=""></i> {{$textDodajGumba}}</a>
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
    @include('datatables.klijenti.partneri.ziroRacuni.form')
@endsection

@push('scripts')
@section('js')
    <script type="text/javascript">

        var tableId = "table";

        var url = '{{url("klijenti/".$klijent->id."/partneri/".$partner->id."/ziro/basic-data") }}';

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

        /*function popuniCheckbox(element,vrijednost){
            if(vrijednost){
                element.attr('checked', true).val(vrijednost).next().val(vrijednost);
            } else {
                element.attr('checked', false).val(vrijednost).next().val(vrijednost);
            }
        }*/

    $('#Modal').on('hidden.bs.modal', function() {
        $('form').formValidation('resetForm', true);
    });
    </script>
    @parent
    @endpush
@endsection