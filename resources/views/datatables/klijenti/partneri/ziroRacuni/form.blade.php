        <!-- Text input-->
        <input type="hidden" name="PartneriId" value="{{ isset($partner) ? $partner->id : 'Default' }}">
        <div class="form-group">
            <label class="control-label col-lg-5" for="IBAN">IBAN</label>
            <div class="col-xs-7">
                <input id="IBAN" name="IBAN" type="text" placeholder="IBAN" class="form-control input-sm">
            </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
            <label class="control-label col-lg-5" for="vaziod">Važi Od</label>
            <div class="col-xs-4">
                <input id="vaziod" name="vaziod" type="text" placeholder="Važi Od" class="form-control input-sm">
            </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
            <label class="control-label col-lg-5" for="vazido">Važi Do</label>
            <div class="col-xs-4">
                <input id="vazido" name="vazido" type="text" placeholder="Važi Do" class="form-control input-sm">
            </div>
        </div>

       @section('js')
           <script>

           </script>
           @parent
       @endsection

       @section('rewritableJs')
            <script>
                var datumOd = $('#vaziod').datetimepicker({
                    minDate: false,
                    onShow : function( ct ) {
                        this.setOptions({
                            maxDate: datumDo.val() ? datumDo.val() : false
                        })
                    },
                    onSelectDate:function(ct,$i){
                        formZiro.formValidation('revalidateField', 'vaziod');
                    }
                });
                var datumDo = $('#vazido').datetimepicker({
                    onShow : function( ct ) {
                        this.setOptions({
                            minDate: datumOd.val() ? datumOd.val() : false
                        })
                    },
                    onSelectDate:function(ct,$i){
                        formZiro.formValidation('revalidateField', 'vazido');
                    }
                });

                var formZiro = $('#frmZiro').formValidation({
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
                        IBAN: {
                            validators: {
                                notEmpty: {},
                                iban: {
                                    message: 'Vrijednost nije ispravni IBAN'
                                }
                            }
                        },
                        vaziod: {
                            validators: {
                                notEmpty: {},
                                date: {
                                    format: 'DD.MM.YYYY',
                                    message: 'Datum nije u ispravnom formatu'
                                }
                            }
                        },
                        vazido: {
                            validators: {
                                notEmpty: {},
                                date: {
                                    format: 'DD.MM.YYYY',
                                    message: 'Datum nije u ispravnom formatu'
                                }
                            }
                        }
                    }
                });
            </script>
            @parent
       @endsection

