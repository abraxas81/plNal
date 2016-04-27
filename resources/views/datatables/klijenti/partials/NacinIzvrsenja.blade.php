<select id="NacinIzvrsenjaId" name="NacinIzvrsenjaId" class="form-control">
    @foreach($NaciniIzvrsenja as $NacinIzvrsenja)
        <option value="{{$NacinIzvrsenja->id}}">{{$NacinIzvrsenja->Naziv}}</option>
    @endforeach
</select>

@section('js')
    <script>$('#NacinIzvrsenja').select2({"placeholder":"Odaberi NacinIzvrsenja","language":"hr"});</script>
    @parent
@endsection

