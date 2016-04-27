        <!-- Text input-->
        <div class="form-group">
            <label class="control-label col-lg-5" for="Naziv">Naziv Partnera</label>
            <div class="col-xs-7">
                <input id="Naziv" name="Naziv" type="text" placeholder="Naziv Partnera" class="form-control input-sm">
            </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
            <label class="control-label col-lg-5" for="Adresa">Adresa Partnera</label>
            <div class="col-xs-7">
                <input id="Adresa" name="Adresa" type="text" placeholder="Adresa Partnera" class="form-control input-sm">
            </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
            <label class="control-label col-lg-5" for="Email">Email Partnera</label>
            <div class="col-xs-7">
                <input id="Email" name="Email" type="text" placeholder="Email Partnera" class="form-control input-sm">
            </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
            <label class="control-label col-lg-5" for="Telefon">Telefon Partnera</label>
            <div class="col-xs-4">
                <input id="Telefon" name="Telefon" type="text" placeholder="Telefon Partnera" class="form-control input-sm">
            </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
            <label class="control-label col-lg-5" for="Mobitel">Mobitel Partnera</label>
            <div class="col-xs-4">
                <input id="Mobitel" name="Mobitel" type="text" placeholder="Mobitel" class="form-control input-sm">
            </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
            <label class="control-label col-lg-5" for="OIB">OIB Partnera</label>
            <div class="col-md-4">
                <input id="OIB" name="OIB" type="text" placeholder="OIB Partnera" class="form-control input-sm" maxlength="11">
            </div>
        </div>

        @section('js')
            <script>
                var formPartneri = $('#frmPartneri');
                var i = 0; var j = 0;

                var datumOd = $('#VaziOd').datetimepicker({
                    minDate: false,
                    onShow : function( ct ) {
                        this.setOptions({
                            maxDate: datumDo.val() ? datumDo.val() : false
                        })
                    },
                    onSelectDate:function(ct,$i){
                        formPartneri.formValidation('revalidateField', 'VaziOd');
                    }
                });
                var datumDo = $('#VaziDo').datetimepicker({
                    onShow : function( ct ) {
                        this.setOptions({
                            minDate: datumOd.val() ? datumOd.val() : false
                        })
                    },
                    onSelectDate:function(ct,$i){
                        formPartneri.formValidation('revalidateField', 'VaziDo');
                    }
                });

                formPartneri.formValidation('destroy')
                        .formValidation({
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
                        },
                        Adresa: {
                            validators: {
                                notEmpty: {}
                            }
                        },
                        Email: {
                            validators: {
                                notEmpty: {},
                                emailAddress: {}
                            }
                        },
                        Telefon: {
                            validators: {
                                notEmpty: {}
                            }
                        },
                        Mobitel: {
                            validators: {
                                notEmpty: {}
                            }
                        },
                        OIB: {
                            trigger:'keyup',
                            enabled: true,
                            validators: {
                                notEmpty: {},
                                id: {
                                    country: 'HR',
                                    message: 'Vrijednost nije ispravni OIB'
                                }
                            },
                            onSuccess: function(e, data) {
                                formPartneri.formValidation('enableFieldValidators', 'OIB', false);
                                if(i == 0){
                                    dohvatiPodatke(data.element.val());
                                }
                                i++;
                            },
                            onError: function(e, data) {
                                formPartneri.formValidation('enableFieldValidators', 'OIB', true);
                                i=0;
                            }
                        },
                        IBAN: {
                            validators: {
                                notEmpty: {},
                                iban: {
                                    message: 'Vrijednost nije ispravni IBAN'
                                }
                            },
                            onSuccess: function(e, data) {
                                formPartneri.formValidation('enableFieldValidators', 'IBAN', false);
                                if (j == 0){
                                    revalidateIban(data.element.val());
                                }
                                j++;
                            },
                            onError: function(e, data) {
                                formPartneri.formValidation('enableFieldValidators', 'IBAN', true);
                                $('#ZiroPrimatelja').val("");
                                $('#btnPrimatelj').attr('data-action',"");
                                j=0;
                            }
                        },
                        VaziOd: {
                            validators: {
                                notEmpty: {},
                                date: {
                                    format: 'DD.MM.YYYY',
                                    message: 'Datum nije u ispravnom formatu'
                                }
                            }
                        },
                        VaziDo: {
                            validators: {
                                notEmpty: {},
                                date: {
                                    format: 'DD.MM.YYYY',
                                    message: 'Datum nije u ispravnom formatu'
                                }
                            }
                        }
                    }
                }).on('keyup','#OIB', function(){
                    formPartneri.formValidation('enableFieldValidators', 'OIB', true); i = 0;
                }).on('keyup','#IBAN', function(){
                    formPartneri.formValidation('enableFieldValidators', 'IBAN', true); j = 0;
                })/*.on('success.form.fv', function(e) {
                    // Prevent form submission
                    var $form = $(e.target),
                            fv = $form.data('formValidation');
                    e.preventDefault();

                    // Use Ajax to submit form data
                    var PrimPlat = $form.find('#hidPart').val();
                    var IBAN = $form.find('#IBAN').val();
                    $.ajax({
                        url: $form.attr('action'),
                        type: 'POST',
                        data: $form.serialize(),
                        dataType: 'json',
                        success: function (data) {
                            PrimPlat == 'btnPlatitelj' ? $('#PlatiteljId'): $('#primatelj_IBAN').val(IBAN);
                            showNotify(data.message, 'success');
                            $('#ModalPartner').modal('hide');
                        },
                        error: function (data) {
                            showNotify(data.message, 'error');
                        },
                    });
                })*/;

                //ovo se mora mijenjati kod uključivanja u druge modale
                var modalPrim = $('#Modal');

                function dohvatiPodatke(val){
                        var url = '{{url('klijenti/'.$klijent->id.'/partneri/dohvatiPartnera')}}'
                        var postMethod = $(modalPrim).find('#postMethod');
                        var form = $(modalPrim).find('form');
                        $.ajax({    //create an ajax request to load_page.php
                            type: "GET",
                            url: url,
                            data: {oib : val},
                            dataType: "json",
                            success: function (data) {
                                if(data && data !=""){
                                    form.formValidation('resetForm', true);
                                    handleResponse(data, modalPrim);
                                    $(modalPrim).on('shown.bs.modal', function () {
                                        $('input:visible:enabled:first', this).focus();
                                    });
                                    postMethod.val('PATCH');
                                    form.attr('action', 'partneri/'+data[0].id);
                                    showNotify('Pronađen je partner sa upisanim OIB-om','success');
                                }else{
                                    postMethod.val('POST');
                                    form.attr('action', 'partneri');
                                    showNotify('Nema partnera sa upisanim OIB-om','warning');
                                }
                            }
                        });
                }

                function handleResponse(data,modal){
                    //$(modal).find('form').removeAttr('action');
                    $.each(data, function(key,value){
                        //ovaj dio koristio sam za select2 popunjavanje multivalue
                        checkObject(modal,value);
                    })
                }
                function checkObject(modal,object) {
                    if ($.isPlainObject(object)) {
                        $.each(object, function (key, value) {
                            $(modal).find('#' + key).val(value);
                            checkObject(modal,value);
                        });
                    }
                }
            </script>
            @parent
        @endsection


