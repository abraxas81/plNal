/**
 * Created by Saša on 4.3.2016..
 */


//dodavanje novog zapisa
$('.novi').on('click', function(){
    OIBValidated = false;
    IbanValidated = false;
    $('#btnPrimatelj').attr('data-action','');
    //ubaciti provjeru ako postoji ovaj element
    $('#vrstaNalogaSelector').show();
    var action = $(this).data('action');
    $('.form-horizontal').trigger("reset").attr("action", action);
    $('#postMethod').val('POST');
});


//datatables dodavanje pretrage po slovima
function alphabetSearch(table, filteri){

    $.fn.dataTable.ext.search.push( function ( settings, searchData ) {
        if ( ! filteri.alphabetSearch ) {
            return true;
        }

        if ( searchData[0].charAt(0) === filteri.alphabetSearch ) {
            return true;
        }
        return false;
    } );

    var alphabet = $('<div class="alphabet"/>').prepend( 'Pretraži: ' );

    $('<span class="clear active badge label-warning"/>')
        .data( 'letter', '' )
        .html( 'Svi' )
        .appendTo( alphabet );

        //riješiti dodavanje lj i NJ
        var alphabetAray = 'ABCĆČDĐEFGHIJKLMNOPRSŠTUVZŽ',
            length = alphabetAray.length;

        function dodavanjeAlfabeta(slovo){
            $('<span/>')
                .data( 'letter', slovo )
                .html( slovo )
                .appendTo( alphabet );
        }

        for (var i = 0; i < length; i++) {
            var letter = alphabetAray.charAt(i);
            dodavanjeAlfabeta(letter);

            if(letter === 'L' || letter === 'N'){
                dodavanjeAlfabeta(letter+='J');
            }
        }

    alphabet.insertBefore(table.table().container() );

    alphabet.on( 'click', 'span', function () {
        alphabet.find( '.active' ).removeClass( 'active badge label-warning');
        $(this).addClass( 'active' ).addClass("badge label-warning");
        filteri.alphabetSearch = $(this).data('letter');
        table.draw();
    } );
}

$('#refresh').on('click', function(){
    filteri.alphabetSearch = "";
    $('.alphabet .clear').trigger('click');
    table.search( '' ).columns().search( '' ).draw();
})

$(document).on('focus','.datum',function(){
    $(this).datetimepicker({
            /*lazyInit: true,*/
            lang: 'hr',
            format: 'd.m.Y',
            timepicker: false,
            minDate: '0',//yesterday is minimum date(for today use 0 or -1970/01/01),
            closeOnDateSelect: true,
            dayOfWeekStart: 1,
            mask: true
        })
        //.on('blur','#inputDatum',function(){
        //    provjeraDatuma($(this).val());
        //});
});
//dohvacanje podataka za edit



$(document).on('ready', function(){
    //resetiranje obrasca
    $('#Modal').on('hidden.bs.modal', function() {
        $(this).find('form').formValidation('resetForm', true);
        //ne radi ovo ne znam zašto
        $('#PlatiteljId').select2("val", "");
        //iskljućivanje prikaza izbora kod novih predložaka naloga
        //$('#vrstaNalogaSelector').hide();
    });
//fokus na prvi element modala -> možda ima bolje riješenje za zatvaranje sa esc
    $('#Modal').on('shown.bs.modal', function () {
        $('input:visible:enabled:first', this).focus();
    })

    $(".supertable tbody").on("click",".edit", function() {
        OIBValidated = true;
        IbanValidated = true;
        var url = $(this).data('action');
        var url2 = $(this).data('action2');
        $(this).data('primatelj') ? setPrimatelj($(this).data('primatelj')) :false;
        $(this).data('platitelj') ? setPlatitelj($(this).data('platitelj')) :false;
        $('.main').trigger("reset").attr("action", url);
            if(url2 === 'predlosci'){
                $('#predlozakSelector').attr('data-route', url2).attr('data-method','POST');
                $('#nalogSelector').attr('data-route', url).attr('data-method','PATCH');
            } else {
                $('#nalogSelector').attr('data-route', url2).attr('data-method','POST');
                $('#predlozakSelector').attr('data-route', url).attr('data-method','PATCH');
            }
        $('#postMethod').val('PATCH');
        
        $.ajax({    //create an ajax request to load_page.php
            type: "GET",
            url: url,
            dataType: "json",
            //data: {notUpisano:true},
            success: function (data) {
                handleResponse(data);
            }
        });
    });

    function setPlatitelj(id) {
        $("#detaljiPlatitelja").attr('data-action', id);
        $("#btnPlatitelj").attr('data-action', id);        
    };

    function setPrimatelj(id) {
        $("#detaljiPrimatelja").attr('data-action', id);
        $("#btnPrimatelj").attr('data-action', id);        
    }

    function handleResponse(data){
        $.each(data, function(key,value){
            if($.isArray(value)) {
                var selectedItems = [];
                $.each(value, function (i, e) {
                    selectedItems.push(e.id);
                });
                $('#' + key).val(selectedItems).trigger("change");
            } else if($.isPlainObject(value)){
                $.each(value, function (i, e) {
                    $('#'+key+"_"+i).val(e).trigger('change');
                });
            } else {
                //console.log(key +' : '+value);
                $('#'+key).val(value).trigger('change');
            }
        })

    }
    $('#postavkeOperatera').on("click", function(){
        var url = $(this).data('action');
        var form = $('#operateri');
        var modal = $('#PostavkeOperatera')
        $.ajax({  //create an ajax request to load_page.php
            type: "GET",
            url: url,
            data:{osobniPodaci: true},
            dataType: "json",
            success: function (data) {
                handleResponseOperater(data, form, modal);
            }
        });
        
    })

    function handleResponseOperater(data, form, modal){

        $.each(data, function(key,value){
                modal.find($('#'+key)).val(value).trigger('change');
        })

    }
    
    $('.check').on('change', function () {
        var element = $(this);
        if (element.val() == 1) {
            element.prop('checked', true).val(1).next().val(1);
        } else {
            element.prop('checked', false).val(0).next().val(0);
        }
        element = undefined;
    })


    $(document).on("click",".detalji", function(){
        var el = $(this);
        //clicked = el.data('clicked');
        //var _data = $(this).data('id');
        //if(clicked == 0){
        $.ajax({
            url: $(this).data('action'),
            data : { tabela : true },
            dataType: 'html',
            success: function(html) {
                el.popover({
                    title: $(this).data('title'),
                    content: html,
                    placement: 'top',
                    html: true,
                    trigger: 'hover'
                }).popover('show');
                //el.data('clicked',1);
            }
        });

    /*}else{
        setTimeout(function() {$('.popover:visible').popover('destroy')},10);
        el.data('clicked',0);
    }*/
});
    $("#table tbody").on("click",".datoteka", function() {
        $.ajax({
            url: $(this).data('action'),
            dataType: 'json',
            success: function (data) {
                alert('Uspješno');
            }
        });
    });

});

function vidljivost(d){
    var tempTableColumns = [];
    $.each(columns, function(key) {
        tempTableColumns.push({"targets" : d[key][3], "data": d[key][0], "name": d[key][1], "visible": d[key][4] , "searchable": d[key][5], "orderable": d[key][6]});
    })
    return tempTableColumns;
}

$('.btn[data-toggle=modal]').on('click', function(){
    var $btn = $(this);
    var currentDialog = $btn.closest('.modal-dialog'),
        targetDialog = $($btn.attr('data-target'));;
    if (!currentDialog.length)
        return;
    targetDialog.data('previous-dialog', currentDialog);
    currentDialog.addClass('aside');
    var stackedDialogCount = $('.modal.in .modal-dialog.aside').length;
    if (stackedDialogCount <= 5){
        currentDialog.addClass('aside-' + stackedDialogCount);
    }
});

$('.modal').on('hide.bs.modal', function(){
    var $dialog = $(this);
    var previousDialog = $dialog.data('previous-dialog');
    if (previousDialog){
        previousDialog.removeClass('aside');
        $dialog.data('previous-dialog', undefined);
    }
});

$('li .first-menu').on('click', function(){
    $('.collapse').collapse('hide');
})





