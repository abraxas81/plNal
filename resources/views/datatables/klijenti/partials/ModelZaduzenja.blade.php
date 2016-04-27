<select id="ModelZaduzenjaId" name="ModelZaduzenjaId" class="form-control ModeliOdZa">
    @foreach($ModeliPlacanja as $ModelPlacanja)
        <option value="{{$ModelPlacanja->id}}" data-regex="{{$ModelPlacanja->regex}}" data-placeholder="{{$ModelPlacanja->Struktura}}">{{$ModelPlacanja->Vrijednost}}</option>
    @endforeach
</select>

@section('js')
    <script>$('#ModelZaduzenjaId').select2({"language":"hr"});</script>
    @parent
@endsection

