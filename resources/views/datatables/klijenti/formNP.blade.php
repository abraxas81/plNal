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
            <a href="#" disabled id="detaljiPlatitelja" class="detalji" data-action="" data-title="Podaci o platitelju" tabIndex="-1">Platitelj</a>
            <button id="btnPlatitelj" type="button" class="btn btn-default btn-xs pull-right btnPartneri" title="Dodaj platitelja" data-toggle="modal" data-target="#ModalPartner" data-route="ziro/" tabIndex="-1"><i class="glyphicon glyphicon-user"></i></button>
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
            <a href="#" id="detaljiPrimatelja" class="detalji" data-action="" data-title="Podaci o platitelju" tabIndex="-1">Primatelj</a>
            <button id="btnPrimatelj" type="button" class="btn btn-default btn-xs pull-right btnPartneri" title="Dodaj primatelja" data-toggle="modal" data-target="#ModalPartner" data-action="" data-route="ziro/" tabIndex="-1"/><i class="glyphicon glyphicon-user"></i></button>
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
            var primPlat;
            $('.novi').on('click', function(e){
                $("#ModelOdobrenjaId").val("51").change();
                $("#ModelZaduzenjaId").val("51").change();
            })
            $('.btnPartneri').on('click', function (e) {
                var el = $(this);
                var id = el.attr('data-action');
                primPlat = el.attr('id');
                var route = '{{$rutaDohvatPartnera}}';
                var modal = el.data('target');
                var form = $(modal).find('form');
                var postMethod = $(modal).find('#postMethod');
                primPlat == 'btnPlatitelj' ? $('#hidPart').val('platitelj') : ($('#hidPart').val('primatelj'), $('#IBAN').val($('#primatelj_IBAN').val()).trigger('change'));
                if (id) {
                    postMethod.val('PATCH');
                    $("#OIB").prop("readonly", true);
                    $("#IBAN").prop("readonly", true);
                    $.ajax({
                        url: route + id,
                        dataType: "json",
                        success: function (data) {
                            form.attr('action', '{{url('klijenti/'.$klijent->id.'/partneri')}}' + '/' + data.PartneriId);
                            form.formValidation('resetForm', true);
                            handleResponsePartner(data, modal);
                            $(modal).on('shown.bs.modal', function () {
                                $('input:visible:enabled:first', this).focus();
                            });
                        }
                    });
                } else {
                    resetirajForme(primPlat);
                }
                function resetirajForme(primPlat) {
                    $('#ziroId').val('');
                    $('#partnerId').val('');
                    form.trigger("reset").attr('action', '{{url('klijenti/'.$klijent->id.'/partneri')}}');
                    $("#OIB").prop("readonly", false);
                    $("#IBAN").prop("readonly", false);
                    form.formValidation('resetForm', true);
                    if (primPlat != 'btnPlatitelj') {
                        form.find('#IBAN').val($('#primatelj_IBAN').val());
                    }
                    $('input:visible:enabled:first', this).focus();
                    postMethod.val('POST');
                }

                $(modal).on('hide.bs.modal', function () {
                    //el.removeData('action');
                    $("#btnPrimatelj").removeData('action');
                })
            })

            function handleResponsePartnerArray(data, modal) {
                $.each(data, function (key, value) {
                    $(modal).find('#' + key).val(value).trigger('change');
                });
            }

            function handleResponsePartner(data, modal) {
                $.each(data, function (key, value) {
                    $.isPlainObject(value) ? checkObjectPartneri(modal, value)
                            : (key == 'id' ? $(modal).find('#ziroId').val(value).trigger('change')
                            : $(modal).find('#' + key).val(value).trigger('change'));
                })
            }

            function checkObjectPartneri(modal, object) {
                $.each(object, function (key, value) {
                    $(modal).find('#' + key).val(value).trigger('change');

                });
            }

            var DatumIzvrsenja = $('#datumizvrsenja').datetimepicker({
                mask: '39.19.9999',
                minDate: 0,
                onSelectDate: function (ct, $i) {
                    form.formValidation('revalidateField', 'datumizvrsenja');
                },
                onChangeDateTime: function (ct, $i) {
                    form.formValidation('revalidateField', 'datumizvrsenja');
                }
            }).on('keyup', function () {
                form.formValidation('revalidateField', 'datumizvrsenja')
            });

            var form = $('#{{$formName}}');

            var IbanValidated = false;
            form.formValidation('destroy')
                    .formValidation({
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
                            ZiroPrimatelja: {
                                excluded: false,
                                validators: {
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
                            BrojOdobrenja: {
                                trigger: 'keyup change',
                                validators: {
                                    notEmpty: {},
                                    regexp: {
                                        regexp :''
                                    },
                                    callback: {
                                        message: 'Kontrolni broj nije točan',
                                        callback: function (value, validator, $field)  {
                                            var selectedValue = $('#ModelOdobrenjaId').children('option:selected').text();
                                            if(selectedValue == '99'){
                                                return true;
                                            }else{
                                                form.formValidation('enableFieldValidators', 'BrojOdobrenja',true);
                                                return validationBrojevaOdobrenja(selectedValue, value);
                                            }
                                        }
                                    }
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
                                onSuccess: function (e, data) {
                                    if (!IbanValidated) {
                                        revalidateIban(data.element.val());
                                    }
                                    IbanValidated = true;

                                },
                                onError: function (e, data) {
                                    IbanValidated = false;
                                    $('#ZiroPrimatelja').val("");
                                    $('#btnPrimatelj').attr('data-action', "");
                                }
                            },
                            BrojZaduzenja: {
                                trigger: 'keyup change',
                                validators: {
                                    notEmpty: {},
                                    regexp: {
                                        regexp :''
                                    },
                                    callback: {
                                        message: 'Kontrolni broj nije točan',
                                        callback: function (value, validator, $field)  {
                                            var selectedValue = $('#ModelZaduzenjaId').children('option:selected').text();
                                            if(selectedValue == '99'){
                                                return true;
                                            }else{
                                                form.formValidation('enableFieldValidators', 'BrojZaduzenja', true);
                                                return validationBrojevaOdobrenja(selectedValue, value);
                                            }
                                        }
                                    }
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
                                        message: 'Datum ne zadovoljava uvjete provjere'
                                    }
                                }
                            }
                        }
                    }).on('click', '.predNalSel', function () {
                $('.predNalSel').toggle();
                var el = $(this); // points to the clicked input button
                //el.addClass('disabled').attr('disabled',true);
                changeSelectors(el, form);
            }).on('change', '#ModelOdobrenjaId', function(){
                var selVal = $(this).children('option:selected').text();
                var placeholders = $(this).children('option:selected').attr('data-placeholder');
                $('#BrojOdobrenja').attr('placeholder', placeholders)
                if(selVal == '99'){
                    form.formValidation('enableFieldValidators', 'BrojOdobrenja', false);
                    $('#BrojOdobrenja').prop('disabled', true);
                }else{
                    var regexp = $(this).children('option:selected').attr('data-regex');
                    //$('#BrojOdobrenja').prop('pattern', regexp);
                    // Update options
                    $('#BrojOdobrenja').prop('disabled', false);
                    form.formValidation('updateOption', 'BrojOdobrenja', 'regexp', 'regexp', regexp)
                    // You might need to revalidate field
                            .formValidation('revalidateField', 'BrojOdobrenja');
                    form.formValidation('enableFieldValidators', 'BrojOdobrenja', true);
                }
            }).on('change', '#ModelZaduzenjaId', function(){
                var selVal = $(this).children('option:selected').text();
                var placeholders = $(this).children('option:selected').attr('data-placeholder');
                $('#BrojZaduzenja').attr('placeholder', placeholders)
                if(selVal == '99'){
                    form.formValidation('enableFieldValidators', 'BrojZaduzenja', false);
                    $('#BrojZaduzenja').prop('disabled', true)
                }else{
                    var regexp = $(this).children('option:selected').attr('data-regex');
                    //$('#BrojZaduzenja').prop('pattern', regexp);
                    // Update options
                    $('#BrojZaduzenja').prop('disabled', false)
                    form.formValidation('updateOption', 'BrojZaduzenja', 'regexp', 'regexp', regexp)
                    // You might need to revalidate field
                            .formValidation('revalidateField', 'BrojZaduzenja');
                    form.formValidation('enableFieldValidators', 'BrojZaduzenja', true);
                }
            }).on('submit', function (e) {
                // $(e.target) --> The form instance
                // $(e.target).data('formValidation')
                //             --> The FormValidation instance
                form.formValidation('enableFieldValidators', 'primatelj', !IbanValidated);
            })
            
            $('#Modal').on('hide.bs.modal', function() {
                form.formValidation('resetForm', true);
            })

            function changeSelectors(el, form) {
                var route = el.attr('data-route');
                var action = el.attr('data-method');
                form.attr("action", route).find($('#postMethod')).val(action);
                $('.divPredNal').toggle();
                form.data('formValidation').disableSubmitButtons(false);
            }

            function getYesterdaysDate() {
                var date = new Date();
                date.setDate(date.getDate() - 1);
                return date.getDate() + '.' + (date.getMonth() + 1) + '.' + date.getFullYear();
            }

            function revalidateIban(val) {
                var url = '{{$RutaProvjeraIbana}}';
                $.ajax({    //create an ajax request to load_page.php
                    type: "GET",
                    url: url,
                    data: {iban: val},
                    dataType: "json",
                    success: function (data) {
                        if (data && data != "") {
                            $('#ZiroPrimatelja').val(data[0].id);
                            $('#ziroId').val(data[0].id);
                            $('#btnPrimatelj').attr('data-action', data[0].id);
                            $('#vaziod').val(data[0].vaziod);
                            $('#vazido').val(data[0].vazido);
                            form.formValidation('revalidateField', 'ZiroPrimatelja');
                            $.notify("Žiro račun je pronađen");
                        } else {
                            $.notify("Nije pronađen ni jedan račun");
                            $('#ZiroPrimatelja').val("");
                            $('#ziroId').val(0);
                            $('#btnPrimatelj').attr('data-action', "");
                            form.formValidation('revalidateField', 'ZiroPrimatelja');
                            $('#ModalPrimatelj form').trigger("reset").attr("action", '#');
                        }
                    }
                });
            }

            function mod11Ini(broj){
                //konverzija broja u string
                var brojS = broj.toString();
                //broj bez zadnje znamenke
                var bbzz = brojS.slice(0, -1).split("").reverse().join("");
                //zadnja znamenka kontrolnog brioja
                var kbu =  brojS.substr(brojS.length - 1);
                var umnozak = 0;
                var ponder = 2;
                for (var x = 0; x < bbzz.length; x++)
                {
                    umnozak += bbzz[x]*ponder;
                    ponder++;
                }
                var kbr;
                var reminder = umnozak%11;
                switch(reminder) {
                    case 0:
                        kbr = 0;
                        break;
                    case 1:
                        kbr = 0;
                        break;
                    default:
                        kbr = 11-reminder;
                }
                if(kbu == kbr){
                    return true;
                }else{
                    return false;
                }
            }

            function iso7064(broj){
                //konverzija broja u string
                var brojS = broj.toString();
                //zadnja znamenka kontrolni uzorak
                var kbu =  brojS.substr(brojS.length - 1);
                var bbzz = brojS.slice(0, -1);
                var umnozak = 0;
                var ponder = 2;
                for (var x = 0; x < bbzz.length; x++)
                {
                    if(bbzz[x]==0 && x == 0){
                        bbzz[x] = 10;
                    }
                    x==0 ? umnozak = (((parseInt(bbzz[x])*ponder)%11+parseInt(bbzz[x+1]))%10)*ponder:
                            x!=bbzz.length-1 ? umnozak = ((umnozak%11+parseInt(bbzz[x+1]))%10)*ponder:
                                    umnozak = (umnozak%11+0)%10;
                }
                var kbr;
                var reminder = umnozak%11;
                switch(reminder) {
                    case 0:
                        kbr = 1;
                        break;
                    case 1:
                        kbr = 0;
                        break;
                    default:
                        kbr = 11-reminder;
                }
                if(kbu == kbr){
                    return true;
                }else{
                    return false;
                }
            }


            function mod11JMBG(broj){
                //konverzija broja u string
                var brojS = broj.toString();
                //obrnutiString
                var breversed = brojS.split("").reverse().join("");
                var umnozak = 0;
                var ponder = 1;
                for (var x = 0; x < breversed.length; x++)
                {
                    umnozak += breversed[x]*ponder;
                    ponder++;
                    if(ponder > 7){ponder = 2}
                }
                var reminder = umnozak%11;
                if(reminder == 0){
                    return true;
                }else{
                    return false;
                }
            }
            function mod11P7(broj){
                //konverzija broja u string
                var brojS = broj.toString();
                //obrnutiString
                var breversed = brojS.split("").reverse().join("");
                //zadnja znamenka kontrolni uzorak
                var kbu =  brojS.substr(brojS.length - 1);
                var umnozak = 0;
                var ponder = 2;
                for (var x = 0; x < breversed.length; x++)
                {
                    if(ponder > 7){ponder = 2}
                    umnozak += breversed[x]*ponder;
                    ponder++;
                }
                var kbr;
                var reminder = umnozak%11;
                switch(reminder) {
                    case 0:
                        kbr = 5;
                        break;
                    case 1:
                        kbr = 0;
                        break;
                    default:
                        kbr = 11-reminder;
                }
                if(kbu == kbr){
                    return true;
                }else{
                    //alert(0);
                    return false;
                }
            }
            function mod10ZB(broj){
                //konverzija broja u string
                var brojS = broj.toString();
                //obrnutiString
                var breversed = brojS.slice(0, -1).split("").reverse().join("");
                //zadnja znamenka kontrolni uzorak
                var kbu =  brojS.substr(brojS.length - 1);
                var umnozak = 0;
                var ponder = 1;
                for (var x = 0; x < breversed.length; x++)
                {
                    if (x % 2 === 0) { ponder = 1; }
                    else { ponder = 2; }
                    umnozak += breversed[x]*ponder;
                }

                var kbr = umnozak%10;
                if(kbu == kbr){
                    return true;
                }else{
                    return false;
                }
            }

            function modul10(broj){
                var brojS = broj.toString();
                //zadnja znamenka kontrolni uzorak
                var kbu =  brojS.substr(brojS.length - 1);
                var bbzz = brojS.slice(0, -1);
                var umnozak = 0;
                var sumaUmnozaka = 0;
                var ponder = 2;
                for (var x = 0; x < bbzz.length; x++)
                {
                    if (x % 2 === 0) { ponder = 1; }
                    else { ponder = 2; }
                    umnozak += bbzz[x]*ponder;
                    //umnozak = umnozak.toString();
                    /*for (var k = 0; k < umnozak.length; k++)
                        sumaUmnozaka += parseInt(umnozak[k]);*/
                }
                var kbr;
                var reminder = umnozak%10;
                switch(reminder) {
                    case 0:
                        kbr = 0;
                    default:
                        kbr = 10-reminder;
                }
                if(kbu == kbr){
                    return true;
                }else{
                    return false;
                }

            }
        function validationBrojevaOdobrenja (selectedValue, value){
            var message = "Kontrolni broj nije točan";
            var message0 = "Kontrolni broj P1 nije točan";
            var message1 = "Kontrolni broj P2 nije točan";
            var message2 = "Kontrolni broj P3 nije točan";
            var match = value.match(/([^-]+)/g);
            if(value.length > 22){
                return {
                    valid: false,
                    message: "Podatak je predugačak"
                };
            }else {
                switch (selectedValue) {
                    case '01':
                        var reolacedValue = value.replace(/\-/g, '');
                        return {
                            valid: mod11Ini(reolacedValue),
                            message: message
                        };
                        break;
                    case '02':
                        if (match && '1' in match) {
                                if (match[2] !== undefined) {
                                    return {
                                        valid: mod11Ini(match[1]) && mod11Ini(match[2]),
                                        message: message
                                    };
                                }
                            return {
                                valid: mod11Ini(match[1]),
                                message: message1
                            };
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '03':
                        if (match) {
                            if (match[0] !== undefined) {
                                if (match[1] !== undefined) {
                                    if (match[2] !== undefined) {
                                        return {
                                            valid: mod11Ini(match[0]) && mod11Ini(match[1]) && mod11Ini(match[2]),
                                            message: message
                                        };
                                    }
                                    return {
                                        valid: mod11Ini(match[0]) && mod11Ini(match[1]),
                                        message: message
                                    };
                                }
                                return {
                                    valid: mod11Ini(match[0]),
                                    message: message0
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '04':
                        if (match) {
                            if (match[0] !== undefined) {
                                if (match[2] !== undefined) {
                                    return {
                                        valid: mod11Ini(match[0]) && mod11Ini(match[2]),
                                        message: message
                                    };
                                }
                                return {
                                    valid: mod11Ini(match[0]),
                                    message: message0
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '05':
                        if (match) {
                            if (match[0] !== undefined) {
                                return {
                                    valid: mod11Ini(match[0]),
                                    message: message0
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '06':
                        if (match && '1' in match) {
                            if (match[1] !== undefined) {
                                if (match[2] !== undefined) {
                                    match[2] = match[2].replace(/^0+/, '');
                                    return {
                                        valid: mod11Ini(match[1].concat(match[2])),
                                        message: message
                                    };
                                }
                                return {
                                    valid: mod11Ini(match[1]),
                                    message: message1
                                };
                            }
                        } else {
                            return {
                                valid: false
                            };
                        }
                        break;
                    case '07':
                        if (match && '1' in match) {
                            if (match[1] !== undefined) {
                                return {
                                    valid: mod11Ini(match[1]),
                                    message: message1
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '08':
                        if (match) {
                            if (match[0] !== undefined) {
                                if (match[1] !== undefined) {
                                    //match[1] = match[1].replace(/^0+/, ''); //smatra se da nema vodećih nula
                                    if (match[2] !== undefined) {
                                        return {
                                            valid: mod11Ini(match[0].concat(match[1])) && mod11Ini(match[2]),
                                            message: message
                                        };
                                    }
                                    return {
                                        valid: mod11Ini(match[0].concat(match[1])),
                                        message: message
                                    };
                                }
                                return {
                                    valid: mod11Ini(match[0]),
                                    message: message0
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '09':
                        if (match) {
                            if (match[0] !== undefined) {
                                if (match[1] !== undefined) {
                                    //match[1] = match[1].replace(/^0+/, ''); //smatra se da nema vodećih nula
                                    return {
                                        valid: mod11Ini(match[0].concat(match[1])),
                                        message: message
                                    };
                                }
                                return {
                                    valid: mod11Ini(match[0]),
                                    message: message0
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '10':
                        if (match) {
                            if (match[0] !== undefined) {
                                if (match[1] !== undefined) {
                                    if (match[2] !== undefined) {
                                        //match[2] = match[2].replace(/^0+/, ''); //smatra se da nema vodećih nula
                                        return {
                                            valid: mod11Ini(match[0]) && mod11Ini(match[1].concat(match[2])),
                                            message: message
                                        };
                                    }
                                    return {
                                        valid: mod11Ini((match[1])),
                                        message: message
                                    };
                                }
                                return {
                                    valid: mod11Ini(match[0]),
                                    message: message0
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '11':
                        if (match) {
                            if (match[0] !== undefined) {
                                if (match[1] !== undefined) {
                                    return {
                                        valid: mod11Ini((match[0])) && mod11Ini((match[1])),
                                        message: message
                                    };
                                }
                                return {
                                    valid: mod11Ini(match[0]),
                                    message: message0
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '12':
                        if (match) {
                            if (match[0] !== undefined) {
                                return {
                                    valid: mod11JMBG(match[0]),
                                    message: message0
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '13':
                        if (match) {
                            if (match[0] !== undefined) {
                                return {
                                    valid: mod11P7(match[0]),
                                    message: message0
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '14':
                        if (match) {
                            if (match[0] !== undefined) {
                                return {
                                    valid: mod10ZB(match[0]),
                                    message: message0
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '15':
                        if (match) {
                            if (match[0] !== undefined) {
                                if (match[1] !== undefined) {
                                    return {
                                        valid: modul10(match[0]) && modul10(match[1]),
                                        message: message
                                    };
                                }
                                return {
                                    valid: modul10(match[0]),
                                    message: message0
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '16':
                        if (match) {
                            if (match[0] !== undefined) {
                                if ('1' in match) {
                                    return {
                                        valid: mod11Ini(match[0]) && mod11Ini(match[1]),
                                        message: message
                                    };
                                }
                                return {
                                    valid: modul11Ini(match[0]),
                                    message: message0
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '17':
                        if (match) {
                            if (match[0] !== undefined) {
                                return {
                                    valid: iso7064(match[0]),
                                    message: message0
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '18':
                        if (match) {
                            if (match[0] !== undefined) {
                                return {
                                    valid: mod11P7(match[0]),
                                    message: message0
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '23':
                        if (match) {
                            if (0 in match) {
                                if ('2' in match) {
                                    var joinedStr = match[1].concat(match[2]);
                                    if (joinedStr.length > 15) {
                                        return {
                                            valid: false,
                                            message: "Prevelika duljina podataka"
                                        };
                                    }
                                    if (3 in match) {
                                        joinedStr = joinedStr.concat(match[3]);
                                        if (joinedStr.length > 15) {
                                            return {
                                                valid: false,
                                                message: "Prevelika duljina podataka"
                                            };
                                        }
                                        return {
                                            valid: mod11Ini(match[0]),
                                            message: message0
                                        };
                                    }
                                    return {
                                        valid: mod11Ini(match[0]),
                                        message: message0
                                    };
                                }
                                return {
                                    valid: mod11Ini(match[0]),
                                    message: message0
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '24':
                        if (match) {
                            if (match[0] !== undefined) {
                                return {
                                    valid: mod11Ini((match[0])),
                                    message: message0
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '25':
                        return {valid: true};
                    case '26':
                        if (match && '1' in match && '2' in match) {
                            if (match[0] !== undefined) {
                                if (match[1] !== undefined) {
                                    if (match[2] !== undefined) {
                                        return {
                                            valid: mod11Ini(match[0]) &&
                                            (match[1].length > 10 ?
                                                    iso7064(match[1]) :
                                                    mod11JMBG(match[1]))
                                            && (match[2].length > 10 ?
                                                    iso7064(match[2]) :
                                                    mod11JMBG(match[2])),
                                            message: message
                                        };
                                    }
                                }
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '27':
                        if (match) {
                            if (match[0] !== undefined) {
                                if (match[1] !== undefined && '1' in match) {
                                    return {
                                        valid: mod11Ini((match[0])) && mod11Ini((match[1])),
                                        message: message
                                    };
                                }
                                return {
                                    valid: false
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '28':
                        if (match) {
                            if (match[0] !== undefined) {
                                if ('1' in match) {
                                    if ('2' in match) {
                                        return {
                                            valid: mod11Ini((match[0])) && mod11Ini((match[1])) && mod11Ini((match[2])),
                                            message: message
                                        };
                                    }
                                }
                                return {
                                    valid: true
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '29':
                        if (match) {
                            if (match[0] !== undefined) {
                                if ('1' in match) {
                                    if ('2' in match) {
                                        return {
                                            valid: mod11Ini((match[0])) && mod11Ini((match[1])) && mod11Ini((match[2])),
                                            message: message0
                                        };
                                    }
                                    return {
                                        valid: true
                                    };
                                }
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '31':
                        if (match) {
                            if (match[0] !== undefined) {
                                return {
                                    valid: iso7064((match[0])),
                                    message: message0
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '33':
                        if (match) {
                            if (match[0] !== undefined) {
                                if ('1' in match) {
                                    return {
                                        valid: iso7064((match[0])) && iso7064((match[1])),
                                        message: message
                                    };
                                }
                                return {
                                    valid: true
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '34':
                        if (match) {
                            if (match[0] !== undefined) {
                                if ('1' in match) {
                                    if ('2' in match) {
                                        return {
                                            valid: iso7064((match[0])) && iso7064((match[1])) && iso7064((match[2])),
                                            message: message
                                        };
                                    }
                                }
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '41':
                        if (match) {
                            if (match[0] !== undefined) {
                                if (match[1] !== undefined) {
                                    return {
                                        valid: mod11JMBG((match[0])) && mod11Ini((match[1])),
                                        message: message
                                    };
                                }
                                return {
                                    valid: mod11JMBG((match[0])),
                                    message: message
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '42':
                        if (match) {
                            if (match[0] !== undefined) {
                                if (match[1] !== undefined) {
                                    if (match[2] !== undefined) {
                                        return {
                                            valid: mod11JMBG(match[0].concat(match[1]).concat(match[2])),
                                            message: message
                                        };
                                    }
                                    return {
                                        valid: mod11JMBG(match[0].concat(match[1])),
                                        message: message
                                    };
                                }
                                return {
                                    valid: mod11JMBG((match[0])),
                                    message: message0
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '43':
                        if (match && '1' in match) {
                            if (match[1] !== undefined) {
                                return {
                                    valid: mod11Ini((match[1])),
                                    message: message1
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '55':
                        if (match) {
                            if (match[0] !== undefined) {
                                return {
                                    valid: mod11Ini((match[0])),
                                    message: message0
                                };
                            }
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '62':
                        if (match && '2' in match) {
                            return {
                                valid: mod11Ini(match[0]) && iso7064(match[1]) && mod11Ini((match[2])),
                                message: message
                            };

                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '63':
                        if (match && '2' in match) {
                            return {
                                valid: mod11Ini((match[0])) && iso7064((match[1])) && mod11Ini((match[2])),
                                message: message
                            };
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '64':
                        if (match && '2' in match) {
                            return {
                                valid: mod11Ini(match[0]) && iso7064(match[1]) && (match[2].length == 11 ? iso7064(match[2]) : true),
                                message: message
                            };
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '65':
                        if (match && '2' in match) {
                            return {
                                valid: mod11Ini((match[0])) && mod11Ini((match[1])) && iso7064((match[2])),
                                message: message0
                            };
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '67':
                        if (match && '0' in match) {
                            return {
                                valid: iso7064((match[0])),
                                message: message0
                            };
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '68':
                        if (match && '1' in match) {
                            return {
                                valid: mod11Ini((match[0])) && iso7064((match[1])),
                                message: message
                            };
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '69':
                        if (match && '1' in match) {
                            return {
                                valid: mod11Ini((match[0])) && iso7064((match[1])),
                                message: message
                            };
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    case '83':
                        if (match) {
                        } else {
                            return {
                                valid: true
                            };
                        }
                        break;
                    default:
                        return {
                            valid: true
                        };
                }
            }
        }
    </script>
    @parent
@endsection


