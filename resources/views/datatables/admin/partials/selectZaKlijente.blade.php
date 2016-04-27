<div class="form-group">
    <label class="col-lg-5 control-label" for="uloge">Klijenti</label>
    <div class="col-lg-7">
        <select id="klijenti" name="klijenti[]" class="form-control input-sm" multiple style="width: 100%">
            @foreach($klijenti as $klijent)
                <option value="{{$klijent->id}}">{{$klijent->Naziv}}</option>
            @endforeach
        </select>
    </div>
</div>

@section('js')
    <script>
        $('#klijenti').select2({"language":"hr"});
    </script>
    @parent
@endsection



