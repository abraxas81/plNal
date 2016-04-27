        <!-- Text input-->
        <div class="form-group">
            <label class="col-lg-5 control-label" for="Naziv">Naziv</label>
            <div class="col-lg-7">
                <input id="name" name="name" type="text" placeholder="Unesite naziv" class="form-control input-sm">
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-lg-5 control-label" for="UserFriendlyNaziv">Duži naziv</label>
            <div class="col-lg-7">
                <input id="display_name" name="display_name" type="text" placeholder="Unesite duži naziv" class="form-control input-sm" required="">
            </div>
        </div>
        <!-- Password input-->
        <div class="form-group">
            <label class="col-lg-5 control-label" for="Opis">Opis</label>
            <div class="col-lg-7">
                <textarea id="description" name="description" class="form-control" rows="5" placeholder="Unesite Opis uloge"></textarea>
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
                            }
                        }
                    });
                </script>
        @parent
        @endpush
        @endsection

