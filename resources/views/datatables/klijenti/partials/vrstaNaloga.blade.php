<select id="VrstaNalogaId" name="VrstaNalogaId" class="form-control">
    @foreach($vrsteNaloga as $vrstaNaloga)
        <option value="{{$vrstaNaloga->id}}">{{$vrstaNaloga->Naziv}}</option>
    @endforeach
</select>


    @section('js')
        <script>$("#VrstaNalogaId").select2({"language":"hr"});</script>
    @endsection
