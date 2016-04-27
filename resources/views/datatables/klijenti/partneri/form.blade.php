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
        <!--<div class="form-group">
            <label class="control-label col-lg-5" for="Promjene">Spremi promjene</label>
            <div class="col-md-4">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-primary">Spremi promjene
                    <input id="Promjene" name="Promjene" type="checkbox" class="form-control input-sm">
                    </label>
                </div>
            </div>
        </div>-->

        @section('js')
            <script>
                var formPartneri = $('#frmPartneri');

                var OIBValidated = false;

                formPartneri.formValidation('destroy')
                        .formValidation({
                    framework: 'bootstrap',
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
                                emailAddress: {}
                            }
                        },
                        Telefon: {
                            validators: {
                                regexp: {
                                    regexp: /^(\d{3})\/(\d{3})-(\d{1,4})$/
                                }
                            }
                        },
                        Mobitel: {
                            validators: {
                                regexp: {
                                    regexp: /^(\d{3})\/(\d{3})-(\d{1,4})$/
                                }
                            }
                        },
                        OIB: {
                            trigger: 'keyup',
                            validators: {
                                notEmpty: {},
                                id: {
                                    country: 'HR',
                                    message: 'Vrijednost nije ispravni OIB'
                                }
                            },
                            onSuccess: function (e, data) {
                                if (!OIBValidated) {
                                    dohvatiPodatke(data.element.val());
                                }
                                OIBValidated = true;
                                //formPartneri.formValidation('enableFieldValidators', 'OIB', false);
                            },
                            onError: function (e, data) {
                                //formPartneri.formValidation('enableFieldValidators', 'OIB', true);
                                OIBValidated = false;
                            }
                        }
                    }
                }).on('submit', function(e) {
                    // $(e.target) --> The form instance
                    // $(e.target).data('formValidation')
                    //             --> The FormValidation instance
                    $('#OIB').val() ? formPartneri.formValidation('enableFieldValidators', 'OIB', OIBValidated)
                                    : formPartneri.formValidation('enableFieldValidators', 'OIB', true);
                    //$('#OIB').val() ? alert('true'): alert('false');

                })
                /*.on('success.form.fv', function(e) {
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
                
                $('#Modal').on('hide.bs.modal', function() {
                    formPartneri.formValidation('resetForm', true);
                })

                function handleResponseDohvatPartnera(data,modal){
                    //$(modal).find('form').removeAttr('action');
                    $.each(data, function(key,value){
                        //ovaj dio koristio sam za select2 popunjavanje multivalue
                        checkIfObject(modal,value);
                    })
                }
                function checkIfObject(modal,object) {
                    if ($.isPlainObject(object)) {
                        $.each(object, function (key, value) {
                            $(modal).find('#' + key).val(value);
                            checkIfObject(modal,value);
                        });
                    }
                }
            </script>
            @parent
        @endsection

        @section('rewritableJs')
            <script>

                var modalPrim = $('#Modal');

                function dohvatiPodatke(val){
                    var url = '{{url('klijenti/'.$klijent->id.'/partneri/dohvatiPartnera')}}'
                    var postMethod = $(modalPrim).find('#postMethod');
                    var form = $('#frmPartneri');
                    $.ajax({    //create an ajax request to load_page.php
                        type: "GET",
                        url: url,
                        data: {oib : val},
                        dataType: "json",
                        success: function (data) {
                            if(data && data !=""){
                                $(modalPrim).on('shown.bs.modal', function () {
                                    $('input:visible:enabled:first', this).focus();
                                });
                                form.formValidation('resetForm', true);
                                postMethod.val('PATCH');
                                form.attr('action', 'partneri/'+data[0].id);
                                handleResponseDohvatPartnera(data, form);
                                showNotify('Pronađen je partner sa upisanim OIB-om','success');
                            }else{
                                form.formValidation('resetForm', true);
                                postMethod.val('POST');
                                form.attr('action', 'partneri');
                                showNotify('Nema partnera sa upisanim OIB-om','warning');
                            }
                        }
                    });
                }
            </script>
            @parent
        @endsection


