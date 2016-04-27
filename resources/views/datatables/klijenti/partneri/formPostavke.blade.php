        <!-- Text input-->
        <input type="hidden" name="TipParametraId" value="{{$Tip}}">
        <div class="form-group">
            <label class="control-label col-lg-5" for="NazivParametra">Naziv Parametra</label>
            <div class="col-xs-7">
                <input id="NazivParametra" name="NazivParametra" type="text" placeholder="Naziv Parametra" class="form-control input-sm">
            </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
            <label class="control-label col-lg-5" for="OpisParametra">Opis Parametra</label>
            <div class="col-xs-7">
                <textarea id="OpisParametra" name="OpisParametra" class="form-control" rows="5" placeholder="Unesite Opis parametra"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-5 control-label" for="Vrijednost">Računi za plačanje</label>
            <div class="col-lg-7">
                <select id="Vrijednost" name="Vrijednost[]" class="form-control input-sm" multiple style="width: 100%">
                    @foreach($klijent->partneri as $partner)
                        @foreach($partner->ZiroRacuni as $ziro)
                            <option value="{{$ziro->id}}">{{$ziro->IBAN.' | '.$partner->Naziv}}</option>
                        @endforeach
                    @endforeach
                </select>
            </div>
        </div>

        @section('js')
            <script>

                $(".postavke").on("click", function() {
                    var url = $(this).data('action');
                    var modal = $('#ModalPostavke');
                    var form = modal.find('form');
                    $.ajax({    //create an ajax request to load_page.php
                        type: "GET",
                        url: url,
                        dataType: "json",
                        success: function (data) {
                            if(data && data !=""){
                                form.find('#postMethod').val('PATCH');
                                form.attr('action', 'postavke/'+data.id)
                                handleResponsePostavke(data,modal);
                            }else{
                                form.find('form#postMethod').val('POST');
                                form.attr('action', 'postavke/');
                            }
                        }
                    });
                });

                function handleResponsePostavke(data,modal){
                    //$(modal).find('form').removeAttr('action');
                    $.each(data, function(key,value){
                        $(modal).find('#' + key).val(value).trigger('change');
                        checkObjectPostavke(modal,value,key);


                    })
                }

                function checkObjectPostavke(modal,object,naziv) {
                    if ($.isPlainObject(object)) {
                        $.each(object, function (key, value) {
                            $(modal).find('#' + key).val(value).trigger('change');
                            //checkObjectPostavke(modal,value);
                        });
                    } else if($.isArray(object)) {
                        var selectedItems = [];
                        $.each(object, function (key, value) {
                            selectedItems.push(value);
                            //checkObjectPostavke(modal,value);
                        });
                        $(modal).find('#' + naziv).val(selectedItems).trigger("change");
                    }
                }

                $('#Vrijednost').select2({"language":"hr",width:'100%',"minimumResultsForSearch": "Infinity"});

            </script>
            @parent
        @endsection


