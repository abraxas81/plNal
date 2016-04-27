<select id="klijentiSelect" name="klijentiSelect" class="form-control">
    <option value="">Odaberi</option>
    @if(isset($klijentiSelect))
        @foreach($klijentiSelect as $klijent)
            <option value="{{$klijent->id}}">{{$klijent->Naziv}}
                @if(Session::get('klijentId') == $klijent->id)
                    {{'selected'}}
                @endif</option>
        @endforeach
    @endif
</select>
@section('js')
    <script>
        $('#klijentiSelect').select2({"language":"hr",
            width:'100%',
            "minimumResultsForSearch": "Infinity",
            placeholder: 'Odaberi'})
                .on('change', function () {
                });
    </script>
    @parent
@endsection