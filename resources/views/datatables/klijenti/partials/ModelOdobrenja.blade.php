<select id="ModelOdobrenjaId" name="ModelOdobrenjaId" class="form-control ModeliOdZa">
    @foreach($ModeliPlacanja as $ModelPlacanja)
        <option value="{{$ModelPlacanja->id}}" data-regex="{{$ModelPlacanja->regex}}" data-placeholder="{{$ModelPlacanja->Struktura}}">{{$ModelPlacanja->Vrijednost}}</option>
    @endforeach
</select>

@section('js')
    <script>$('#ModelOdobrenjaId').select2({"placeholder": "Odaberi model zaduženja", "language": "hr"});</script>
    @parent
@endsection

