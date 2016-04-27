Vrsta Naloga:
<select id="vrstaNalogaFilter" class="vrstaNalogaFilter" type="select" name="selectFilter">
    <option value="0">Svi</option>
    @foreach($vrsteNaloga as $vrstaNaloga)
        <option value="{{$vrstaNaloga->id}}">{{$vrstaNaloga->Naziv}}</option>
    @endforeach
</select>

@section('js')
    <script>
        $("#vrstaNalogaFilter").select2({"language":"hr"}).on('change', function(){
            filteri.vrstaNalogaFilter =$(this).val();
            table.draw();
        });
    </script>
    @parent
@endsection