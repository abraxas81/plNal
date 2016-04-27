/**
 * Created by Saša on 6.3.2016..
 */
var datableLanguage =
    {
        "sEmptyTable":      "Nema podataka u tablici",
        "sInfo":            "Prikazano _START_ do _END_ od _TOTAL_ rezultata",
        "sInfoEmpty":       "Prikazano 0 do 0 od 0 rezultata",
        "sInfoFiltered":    "(filtrirano iz _MAX_ ukupnih rezultata)",
        "sInfoPostFix":     "",
        "sInfoThousands":   ",",
        "sLengthMenu":      "Prikaži _MENU_ rezultata po stranici",
        "sLoadingRecords":  "Dohvaćam...",
        "sProcessing":      "Obrađujem...",
        "sSearch":          "Pretraži:",
        "sZeroRecords":     "Ništa nije pronađeno",
        "oPaginate": {
            "sFirst":       "Prva",
            "sPrevious":    "Nazad",
            "sNext":        "Naprijed",
            "sLast":        "Zadnja"
        },
        "oAria": {
            "sSortAscending":  ": aktiviraj za rastući poredak",
            "sSortDescending": ": aktiviraj za padajući poredak"
        }
    }

$.extend($.fn.DataTable.defaults,{autoWidth:false,responsive:true,deferRender:true,stateSave:false,processing:true,serverSide: true,sPaginationType:'full_numbers',lengthMenu:[[10,25,50,-1],[10,25,50,"All"]],iDisplayLength:10,dom:"R<'row'<'col-xs-4'l><'col-xs-4'<'table_title'>><'col-xs-4'f>r>"+"t"+"<'row'<'col-xs-6'i><'col-xs-6'p>>"});
$.fn.select2.defaults.set("language", "hr");
$.fn.select2.defaults.set('allowClear', false);
$.fn.select2.defaults.set('width', 'resolve');
$.fn.select2.defaults.set('theme', 'classic');

/*$(document).on('focus', '.select2', function() {
    $(this).siblings('select').select2('open');
});*/

function showNotify(poruka,tip){
    $.notify({
        // options
        icon: 'glyphicon glyphicon-warning-sign',
        //title: 'Bootstrap notify',
        message: poruka,
        //url: 'https://github.com/mouse0270/bootstrap-notify',
        target: '_blank'
    },{
        // settings
        element: 'body',
        position: null,
        type: tip,
        allow_dismiss: true,
        newest_on_top: true,
        showProgressbar: false,
        placement: {
            from: "bottom",
            align: "right"
        },
        offset: 20,
        spacing: 10,
        z_index: 10031,
        delay: 5000,
        timer: 1000,
        url_target: '_blank',
        mouse_over: null,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
        onShow: null,
        onShown: null,
        onClose: null,
        onClosed: null,
        icon_type: 'class',
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
        '<span data-notify="icon"></span> ' +
        '<span data-notify="title">{1}</span> ' +
        '<span data-notify="message">{2}</span>' +
        '<div class="progress" data-notify="progressbar">' +
        '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
        '</div>' +
        '<a href="{3}" target="{4}" data-notify="url"></a>' +
        '</div>'
    });
}

$('.money').mask('000.000.000.000.000,00', {reverse: true}).on('change',function (){
    $(this).unmask().mask('000.000.000.000.000,00', {reverse: true})
});


