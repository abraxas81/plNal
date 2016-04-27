<!-- Text input-->
        @if(isset($vrstaNalogaF))
            <input type="hidden" id="VrstaNalogaId" name="VrstaNalogaId" value="{{$vrstaNalogaF}}">
        @else
            <div class="form-group">
                <label class="control-label col-lg-5" for="VrstaNalogaId">Vrsta Naloga</label>
                <div class="col-lg-7">
                    @include('datatables.klijenti.partials.vrstaNaloga')
                </div>
            </div>
        @endif
        <div class="form-group divPredNal" @if(!$predlozak) style="display: none;" @endif>
            <label class="control-label col-lg-5" for="Naziv">Naziv Predloška</label>
            <div class="col-lg-7">
                <input id="Naziv" name="Naziv" type="text" placeholder="Naziv Predloška" class="form-control input-sm">
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading panel-heading-sm">
                <h1 class="panel-title">
                    <a href="#" disabled id="detaljiPlatitelja" class="detalji" data-action="" data-title="Podaci o platitelju">Platitelj</a>
                    <button id="btnPlatitelj" type="button" class="btn btn-default btn-xs pull-right btnPartneri" title="Dodaj platitelja" data-toggle="modal" data-target="#ModalPartner" data-route="ziro/"><i class="glyphicon glyphicon-user"></i></button>
                </h1>
            </div>
            <div class="panel-body .panel-body-sm">
                <div class="form-group">
                    <label class="control-label col-lg-5" for="PlatiteljId">IBAN platitelja</label>
                    <div class="col-lg-7">
                        @include('datatables.klijenti.partials.Platitelji')
                    </div>
                </div>
                <!-- Select input-->
                <div class="form-group">
                    <label class="control-label col-lg-5" for="ModelOdobrenjaId">Model - Broj Odobrenja</label>
                    <div class="form-inline">
                        <div class="col-lg-7">
                            @include('datatables.klijenti.partials.ModelOdobrenja')
                             - <input id="BrojOdobrenja" name="BrojOdobrenja" type="text" placeholder="Broj Odobrenja" class="form-control input-sm">
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="panel panel-default">
                <div class="panel-heading panel-heading-sm">
                    <h1 class="panel-title">
                        <a href="#" id="detaljiPrimatelja" class="detalji" data-action="" data-title="Podaci o platitelju">Primatelj</a>
                        <button id="btnPrimatelj" type="button" class="btn btn-default btn-xs pull-right btnPartneri" title="Dodaj primatelja" data-toggle="modal" data-target="#ModalPartner" data-action="" data-route="ziro/"/><i class="glyphicon glyphicon-user"></i></button>
                    </h1>
                </div>
                <div class="panel-body">
                <!-- Select input-->
                    <div class="form-group">
                        <label class="control-label col-lg-5" for="ZiroPrimatelja">IBAN primatelja</label>
                        <div class="col-lg-7">
                            @include('datatables.klijenti.partials.Primatelji')
                        </div>
                    </div>
                    <!-- Select input-->
                    <div class="form-group">
                        <label class="control-label col-lg-5" for="ModelZaduzenjaId">Model - Broj Zaduženja</label>
                        <div class="form-inline">
                            <div class="col-lg-7">
                                @include('datatables.klijenti.partials.ModelZaduzenja')
                                - <input id="BrojZaduzenja" name="BrojZaduzenja" type="text" placeholder="BrojZaduzenja" class="form-control input-sm">
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading panel-heading-sm">
                <h1 class="panel-title">Plaćanje</h1>
            </div>
            <div class="panel-body">
                <!-- Text input-->
                <div class="form-group">
                    <label class="control-label col-lg-5" for="Iznos">Iznos - Valuta</label>
                    <div class="form-inline">
                        <div class="col-lg-7">
                            <input id="Iznos" name="Iznos" type="text" placeholder="Iznos" class="form-control input-sm col-xs-2 money">
                            @include('datatables.klijenti.partials.Valute')
                        </div>
                    </div>
                </div>
                <!-- Select input-->
                <div class="form-group">
                    <label class="control-label col-lg-5" for="SifreNamjeneId">Šifra Namjene</label>
                    <div class="col-lg-7">
                        @include('datatables.klijenti.partials.SifreNamjene')
                    </div>
                </div>
                <!-- Text input-->
                <div class="form-group">
                    <label class="control-label col-lg-5" for="Opis">Opis plaćanja</label>
                    <div class="col-lg-7">
                        <textarea id="Opis" name="Opis" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <!-- Text input-->

                    <div class="form-group divPredNal" @if($predlozak) style="display: none;" @endif>
                        <label class="control-label col-lg-5" for="datumizvrsenja">Datum izvršenja</label>
                        <div class="col-lg-7">
                            <input id="datumizvrsenja" name="datumizvrsenja" type="text" placeholder="Datum izvršenja" class="form-control input-sm datum">
                        </div>
                    </div>

            </div>
        </div>

        @section('js')
            <script>

                $('.btnPartneri').on('click', function(e){
                    var el = $(this);
                    var id = el.attr('data-action');
                    var primPlat = el.attr('id');
                    var route = '{{$rutaDohvatPartnera}}';
                    var modal = el.data('target');
                    var form = $(modal).find('form');
                    var postMethod = $(modal).find('#postMethod');
                    primPlat == 'btnPlatitelj' ? $('#hidPart').val('platitelj'): ($('#hidPart').val('primatelj'), $('#IBAN').val($('#primatelj_IBAN').val()).trigger('change'));
                    if(id){
                        postMethod.val('PATCH');
                        $.ajax({
                            url: route+id,
                            dataType: "json",
                            success: function (data) {
                                alert('sasa');
                                handleResponseIn(data, modal);
                                form.attr('action', 'partneri/'+data.PartneriId);
                                $(modal).on('shown.bs.modal', function () {
                                    form.formValidation('resetForm', true);
                                    $('input:visible:enabled:first', this).focus();
                                });
                            }
                        });
                    } else {
                        form.trigger("reset").attr('action', 'partneri');
                        form.formValidation('resetForm', true);
                        $('input:visible:enabled:first', this).focus();
                        postMethod.val('POST');
                    }
                    $(modal).on('hide.bs.modal', function(){
                        //el.removeData('action');
                        $("#btnPrimatelj").removeData('action');
                    })
                })

                function handleResponseIn(data,modal){
                    //$(modal).find('form').removeAttr('action');
                    $.each(data, function(key,value){
                        $.isPlainObject(value)? checkObject(modal,value): $(modal).find('#' + key).val(value).trigger('change');;
                        //ovaj dio koristio sam za select2 popunjavanje multivalue
                        checkObject(modal,value);
                    })
                }

                function checkObject(modal,object) {
                        $.each(object, function (key, value) {
                            $(modal).find('#' + key).val(value).trigger('change');
                            checkObject(modal,value);
                    });
                }

                var DatumIzvrsenja = $('#datumizvrsenja').datetimepicker({
                        mask:'39.19.9999',
                        minDate:0,
                        onSelectDate:function(ct,$i){
                            form.formValidation('revalidateField', 'datumizvrsenja');
                        },
                        onChangeDateTime:function(ct,$i) {
                            form.formValidation('revalidateField', 'datumizvrsenja');
                        }
                }).on('keyup', function(){
                    form.formValidation('revalidateField', 'datumizvrsenja')
                });

                var form = $('#{{$formName}}');

                var IbanValidated = false;

                form.formValidation({
                    framework: 'bootstrap',
                    excluded: ':hidden',
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
                        VrstaNaloga: {
                            validators: {
                                notEmpty: {}
                            }
                        },
                        Naziv: {
                            validators: {
                                notEmpty: {}
                            }
                        },
                        ZiroPrimatelja:{
                            excluded: false ,
                            validators:{
                                notEmpty: {
                                    message: 'IBAN nije unesen u bazu'
                                }
                            }
                        },
                        PlatiteljId: {
                            validators: {
                                notEmpty: {}
                            }
                        },
                        primatelj: {
                            trigger: 'keyup',
                            validators: {
                                notEmpty: {},
                                iban: {
                                    message: 'Vrijednost nije ispravni IBAN'
                                }
                            },
                            onSuccess: function(e, data) {
                                if(!IbanValidated){
                                    revalidateIban(data.element.val());
                                }
                                IbanValidated = true;

                            },
                            onError: function(e, data) {
                                IbanValidated = false;
                                $('#ZiroPrimatelja').val("");
                                $('#btnPrimatelj').attr('data-action',"");
                            }
                        },
                        Iznos: {
                            validators: {
                                notEmpty: {},
                                numeric: {
                                    //message: 'The value is not a number',
                                    // The default separators
                                    thousandsSeparator: '.',
                                    decimalSeparator: ','
                                }
                            }
                        },
                        SifreNamjeneId: {
                            validators: {
                                notEmpty: {}
                            }
                        },
                        Opis: {
                            validators: {
                                notEmpty: {}
                            }
                        },
                        datumizvrsenja: {
                            validators: {
                                notEmpty: {},
                                date: {
                                    format: 'DD.MM.YYYY',
                                    min: new Date(),
                                    message: 'Datum ne zadovolava uvjete provjere'
                                }
                            }
                        }
                    }
                }).on('click','.predNalSel', function() {
                            $('.predNalSel').toggle();
                            var el = $(this); // points to the clicked input button
                            //el.addClass('disabled').attr('disabled',true);
                            changeSelectors(el, form);
                }).on('submit', function(e) {
                    // $(e.target) --> The form instance
                    // $(e.target).data('formValidation')
                    //             --> The FormValidation instance
                    form.formValidation('enableFieldValidators', 'primatelj', !IbanValidated);

                })

                function changeSelectors(el, form){
                    var route = el.attr('data-route');
                    var action = el.attr('data-method');
                    form.attr("action", route).find($('#postMethod')).val(action);
                    $('.divPredNal').toggle();
                    form.data('formValidation').disableSubmitButtons(false);
                }

                function getYesterdaysDate() {
                    var date = new Date();
                    date.setDate(date.getDate()-1);
                    return date.getDate() + '.' + (date.getMonth()+1) + '.' + date.getFullYear();
                }



                function revalidateIban(val){
                    var url = '{{$RutaProvjeraIbana}}'
                    $.ajax({    //create an ajax request to load_page.php
                        type: "GET",
                        url: url,
                        data: {iban : val},
                        dataType: "json",
                        success: function (data) {
                            if(data && data !=""){
                                $('#ZiroPrimatelja').val(data[0].id);
                                $('#ziroId').val(data[0].id);
                                $('#btnPrimatelj').attr('data-action', data[0].id);
                                $('#VaziOd').val(data[0].VaziOd);
                                $('#VaziDo').val(data[0].VaziDo);
                                form.formValidation('revalidateField', 'ZiroPrimatelja');
                                $.notify("Žiro račun je pronađen");
                            }else{
                                $.notify("Nije pronađen ni jedan račun");
                                $('#ZiroPrimatelja').val("");
                                $('#ziroId').val(0);
                                $('#btnPrimatelj').attr('data-action',"");
                                form.formValidation('revalidateField', 'ZiroPrimatelja');
                                $('#ModalPrimatelj form').trigger("reset").attr("action", '#');
                            }
                        }
                    });
                }
            </script>
            @parent
        @endsection


