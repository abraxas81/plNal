<select id="SifreNamjeneId" class="SifraNamjene" name="SifreNamjeneId" class="form-control">
    @foreach($SifreNamjene as $SifraNamjene)
        <option value="{{$SifraNamjene->id}}">{{$SifraNamjene->Naziv}}</option>
    @endforeach
</select>

@section('js')
    <script>$('#SifreNamjeneId').select2({"language":"hr",width:'100%'});</script>
    @parent
@endsection

