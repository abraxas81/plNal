<div class="form-group">
    <label class="col-lg-5 control-label" for="uloge">Uloge</label>
    <div class="col-lg-7">
        <select id="roles" name="roles[]" class="form-control input-sm" multiple style="width: 100%">
            @foreach($uloge as $uloga)
                <option value="{{$uloga->id}}">{{$uloga->name}}</option>
            @endforeach
        </select>
    </div>
</div>

@section('js')
    <script>
        $('#roles').select2({"language":"hr",theme: "default"});
    </script>
    @parent
@endsection



