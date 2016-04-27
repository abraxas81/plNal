<select id="ValuteId" name="ValuteId" class="form-control input-sm col-xs-4">
    @foreach($Valute as $Valuta)
    <option value="{{$Valuta->id}}">{{$Valuta->Alfa}}</option>
    @endforeach
</select>

@section('js')
    <script>$('#ValuteId').select2({"language":"hr","minimumResultsForSearch": "Infinity"});</script>
    @parent
@endsection