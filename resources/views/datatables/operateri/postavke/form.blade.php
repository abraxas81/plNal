        <!-- Text input-->
        <div class="form-group">
            <label class="col-lg-5 control-label" for="NazivParametra">Naziv Parametra</label>
            <div class="col-lg-7">
                <input id="NazivParametra" name="NazivParametra" type="text" placeholder="Naziv Parametra" class="form-control input-sm">
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-lg-5 control-label" for="Opis Parametra">Opis Parametra</label>
            <div class="col-lg-7">
                <input id="OpisParametra" name="OpisParametra" type="text" placeholder="Opis Parametra" class="form-control input-sm" required="">
            </div>
        </div>

        <!-- Password input-->
        <div class="form-group">
            <label class="col-lg-5 control-label" for="Vrijednost">Vrijednost</label>
            <div class="col-lg-7">
                <input id="Vrijednost" name="Vrijednost" type="Vrijednost" placeholder="Vrijednost" class="form-control input-sm" required="">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-5 control-label" for="TipParametraId">Tip Parametra</label>
            <div class="col-lg-7">
                <input id="TipParametraId" name="TipParametraId" type="Vrijednost" placeholder="Vrijednost" class="form-control input-sm" required="">
            </div>
        </div>

        @section('js')
            <script>
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
                        NazivParametra: {
                            validators: {
                                notEmpty: {}
                            }
                        },
                        OpisParametra: {
                            validators: {
                                notEmpty: {},
                                emailAddress: {
                                }
                            }
                        },
                        Vrijednost: {
                            validators: {
                                notEmpty: {}
                            }
                        }
                    }
                });
            </script>
            @parent
            @endsection
