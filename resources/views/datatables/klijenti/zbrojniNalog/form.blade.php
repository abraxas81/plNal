        <!-- Text input-->
        <div class="form-group">
            <label class="control-label col-lg-5" for="Naziv">Naziv Zbrojnog naloga</label>
            <div class="col-lg-7">
                <input id="Naziv" name="Naziv" type="text" placeholder="Naziv zbrojnog naloga" class="form-control input-sm">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-5" for="NacinIzvrsenja">Način Izvršenja</label>
            <div class="col-lg-7">
                @include('datatables.klijenti.partials.NacinIzvrsenja')
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-5" for="VrstaNalogaId">Vrsta Naloga</label>
            <div class="col-lg-7">
                @include('datatables.klijenti.partials.vrstaNaloga')
            </div>
        </div>

        @section('js')
            <script>
                $('.edit.predlozak').on('click', function(){
                    alert('ok');
                });

                var form = $('#{{$formName}}');

                $('form').formValidation({
                    framework: 'bootstrap',
                    excluded: ':disabled',
                    err: {
                        container: 'tooltip'
                    },
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    locale: 'hr_HR',
                    fields: {
                        Naziv: {
                            validators: {
                                notEmpty: {}
                            }
                        }
                    }
                });

            </script>
            @parent
        @endsection

