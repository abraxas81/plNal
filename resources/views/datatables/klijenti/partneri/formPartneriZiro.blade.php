<input type="hidden" id="partnerId" name="partnerId">
<input type="hidden" id="hidPart" name="hidPart">
@include('datatables.klijenti.partneri.form')
<input type="hidden" id="ziroId" name="ziroId">
@include('datatables.klijenti.partneri.ziroRacuni.form')

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
                formPartneri.formValidation('revalidateField', 'vaziod');
            }
        });
        var datumDo = $('#vazido').datetimepicker({
            onShow : function( ct ) {
                this.setOptions({
                    minDate: datumOd.val() ? datumOd.val() : false
                })
            },
            onSelectDate:function(ct,$i){
                formPartneri.formValidation('revalidateField', 'vazido');
            }
        });

        var formPartneri = $('#frmPartneri');

        var OIBValidated = false;
        var IbanValidated = false;
        var primatelj = {};
        var platitelj = {};

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
                            trigger:'keyup',
                            enabled: true,
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
                        },
                        IBAN: {
                            trigger: 'keyup',
                            validators: {
                                notEmpty: {},
                                iban: {
                                    message: 'Vrijednost nije ispravni IBAN'
                                }
                            },
                            onSuccess: function (e, data) {
                                if (!IbanValidated) {
                                    revalidateIbanPartneri(data.element.val());
                                }
                                IbanValidated = true;
                                //formPartneri.formValidation('enableFieldValidators', 'OIB', false);
                            },
                            onError: function (e, data) {
                                //formPartneri.formValidation('enableFieldValidators', 'OIB', true);
                                IbanValidated = false;
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
                }).on('submit', function (){
            $('#OIB').val() ? formPartneri.formValidation('enableFieldValidators', 'OIB', OIBValidated)
                    : formPartneri.formValidation('enableFieldValidators', 'OIB', true);
            $('#IBAN').val() ? formPartneri.formValidation('enableFieldValidators', 'IBAN', OIBValidated)
                    : formPartneri.formValidation('enableFieldValidators', 'IBAN', true);
        }).on('success.form.fv', function(e) {
            // Prevent form submission
            var $form = $(e.target),
                    fv = $form.data('formValidation');
            e.preventDefault();
            if($('#hidPart').val() == 'primatelj'){
                $.each($form.serializeArray(), function(i, obj) { primatelj[obj.name] = obj.value });
                sendPartner($form, primatelj.IBAN);
            } else{
                $.each($form.serializeArray(), function(i, obj) { platitelj[obj.name] = obj.value });
                sendPartner($form,  platitelj.IBAN);
            }
            function sendPartner($form, IBAN){
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    dataType: 'json',
                    success: function (data) {
                        if($('#hidPart').val() == 'primatelj'){
                            $('#primatelj_IBAN').val(IBAN);
                            $('#ZiroPrimatelja').val(data.id);
                            $('#btnPrimatelj').attr('data-action', data.id);
                            form.formValidation('revalidateField', 'ZiroPrimatelja');
                        }
                        if($('#hidPart').val() == 'platitelj'){

                        }
                        showNotify(data.message, 'success');
                        $('#ModalPartner').modal('hide');
                    },
                    error: function (data) {
                        showNotify(data.message, 'error');
                    },
                })
            }
            $('#ModalPartner').modal('hide');
        });

        //ovo se mora mijenjati kod uključivanja u druge modale
        var modalPrim = $('#ModalPartner');

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
                        $(modalPrim).on('shown.bs.modal', function () {
                            $('input:visible:enabled:first', this).focus();
                        });
                        form.formValidation('resetForm', true);
                        postMethod.val('PATCH');
                        form.attr('action', '{{url('klijenti/'.$klijent->id.'/partneri')}}' + '/' +data[0].id);

                        handleResponsePartneriZiro(data, modalPrim,'partner');

                        showNotify('Pronađen je partner sa upisanim OIB-om','success');
                    }else{
                        //form.formValidation('resetForm', true);
                        showNotify('Nema partnera sa upisanim OIB-om','warning');
                        form.find('#OIB').val(val);
                    }
                }
            });
        }

        function revalidateIbanPartneri(val) {
            var url = '{{$RutaProvjeraIbana}}'
            var form = $(modalPrim).find('form');
            var postMethod = form.find('#postMethod');
            $.ajax({    //create an ajax request to load_page.php
                type: "GET",
                url: url,
                data: {iban: val},
                dataType: "json",
                success: function (data) {
                    if (data && data != "") {
                        //form.formValidation('revalidateField', 'ZiroPrimatelja');
                        postMethod.val('PATCH');
                        form.attr('action', '{{url('klijenti/'.$klijent->id.'/partneri')}}' + '/' +data[0].partneri.id);
                        handleResponsePartneriZiro(data, modalPrim,'ziro');
                        $.notify("Žiro račun je pronađen");
                    } else {
                        $.notify("Nije pronađen ni jedan račun");
                        //$('#ModalPrimatelj form').trigger("reset").attr("action", '#');
                        form.find('#IBAN').val(val);
                    }
                }
            });
        }

        var i;

        function handleResponsePartneriZiro(data,modal,kamoId){
            i = 0;
            $.each(data, function(key,value){
                //ovaj dio koristio sam za select2 popunjavanje multivalue
                if(kamoId == 'partner'){
                    checkObject(modal,value);
                } else {
                    checkObjectZiro(modal,value);
                }
            })

        }

        function checkObject(modal,object) {
            $('#ziroId').val('');
            if ($.isPlainObject(object)) {
                $.each(object, function (key, value) {
                    if(key == 'id'){$('#partnerId').val(value)};
                    $(modal).find('#' + key).val(value)
                    checkObject(modal,value);
                });
            }
        }

        function checkObjectZiro(modal,object) {
            if ($.isPlainObject(object)) {
                $.each(object, function (key, value) {
                    (key == 'id' && i == 0) ? $('#ziroId').val(value) : $(modal).find('#' + key).val(value);
                    (key == 'id' && i > 0) ? $('#partnerId').val(value) : $(modal).find('#' + key).val(value);
                    i++;
                    checkObjectZiro(modal,value);
                });
            }
        }
    </script>
    @parent
@overwrite


