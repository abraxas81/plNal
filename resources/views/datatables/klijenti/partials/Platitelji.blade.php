<select id="PlatiteljId" name="PlatiteljId" class="form-control">
        <option value="">Odaberi</option>
    @if(isset($ZiroRacuni))
        @foreach($ZiroRacuni as $ZiroRacun)
            <option value="{{$ZiroRacun->id}}">{{$ZiroRacun->IBAN.' | '.$ZiroRacun->Partneri->Naziv}}</option>
        @endforeach
    @endif
</select>
@section('js')
    <script>
        function setPlatitelj(id) {
            $("#detaljiPlatitelja").attr('data-action', id);
            $("#btnPlatitelj").attr('data-action', id);
        };

        $('#PlatiteljId').select2({"language":"hr",
                                    width:'100%',
                                    "minimumResultsForSearch": "Infinity",
                                    placeholder: 'Odaberi'})
                             .on('change', function () {
                                 setPlatitelj($(this).val());
                             });
    </script>
    @parent
@endsection

