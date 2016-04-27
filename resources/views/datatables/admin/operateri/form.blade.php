        <!-- Text input-->
        <div class="form-group">
            <label class="col-lg-5 control-label" for="Naziv Operatera">Naziv Operatera</label>
            <div class="col-lg-7">
                <input id="name" name="name" type="text" placeholder="Naziv Operatera" class="form-control input-sm">
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-lg-5 control-label" for="E-mail">Email</label>
            <div class="col-lg-7">
                <input id="email" name="email" type="text" placeholder="Email" class="form-control input-sm" required="">
            </div>
        </div>

        <!-- Password input-->
        <div class="form-group">
            <label class="col-lg-5 control-label" for="lozinka">Lozinka</label>
            <div class="col-lg-7">
                <input id="password" name="password" type="password" placeholder="lozinka" class="form-control input-sm" required="">
            </div>
        </div>

        <!-- Password input-->
        <div class="form-group">
            <label class="col-lg-5 control-label" for="Ponovi Lozinku">Ponovi Lozinku</label>
            <div class="col-lg-7">
                <input id="ponoviLozinku" name="ponoviLozinku" type="password" placeholder="Ponovi unos lozinke" class="form-control input-sm" required="">
            </div>
        </div>

        @push('scripts')
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
                        name: {
                            validators: {
                                notEmpty: {}
                            }
                        },
                        email: {
                            validators: {
                                notEmpty: {},
                                emailAddress: {
                                }
                            }
                        },
                        password: {
                            enabled: false,
                            validators: {
                                notEmpty: {
                                    message: 'Lozinka se mora upisati'
                                }
                            }
                        },
                        ponoviLozinku: {
                            enabled: false,
                            validators: {
                                notEmpty: {
                                    message: 'Potvrda Lozinka se mora upisati'
                                },
                                identical: {
                                    field: 'password',
                                    message: 'Lozinke se razlikuju'
                                }
                            }
                        }
                    }
                }).on('keyup', '[name="password"]', function() {
                    var isEmpty = $(this).val() == '';
                    $('form')
                            .formValidation('enableFieldValidators', 'password', !isEmpty)
                            .formValidation('enableFieldValidators', 'ponoviLozinku', !isEmpty);

                    // Revalidate the field when user start typing in the password field
                    if ($(this).val().length == 1) {
                        $('form').formValidation('validateField', 'password')
                                .formValidation('validateField', 'ponoviLozinku');
                    }
                });
            </script>
            @parent
            @endpush
            @endsection
