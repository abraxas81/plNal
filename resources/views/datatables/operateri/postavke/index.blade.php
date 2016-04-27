@extends('datatables.template2')

@section('breadcrumbs')

    @section('filters')
        <form id="filteri">
            <div class="splynx-nav-right">
                @include('partials.refreshTable')
                <a class="btn btn-xs btn-primary novi" data-toggle="modal" data-target="#Modal" data-action="postavke">{{$textDodajGumba}}</a>
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
    @include('datatables.operateri.postavke.form')
@endsection


@push('scripts')
@section('js')
    <script type="text/javascript">

        var tableId = "table";

        var url = '{{ url("operateri/postavke/basic-data") }}';

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

    </script>
    @parent
    @endpush
@endsection