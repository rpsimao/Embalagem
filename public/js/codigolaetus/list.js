/**
 * Created by rpsimao on 23/06/15.
 */




function deleteLaetusCortante(id, cort, laetus){

    var html = '<div class="text-danger bigger-140" style="padding-bottom: 15px;padding-top: 15px;"><i class="ace-icon fa fa-exclamation-triangle"></i> Tem a certeza que deseja apagar o Código Laetus Nº ' + laetus + ' do Cortante Nº ' + cort +"?</div>";

    bootbox.confirm(html, function(result) {
        if(result) {

             $.ajax({
                 type: 'GET',
                 url: '/codigolaetus/delete',
                 data: {"id": id},
                 dataType: '',
                 error: handleAjaxError,
                 success: function(){

                     $("#lt_tr-"+id).addClass("text-danger rps_strike");
                     $("#lt_edit_row-"+id).html('<span class="label label-danger label-white middle">Removido</span>');

                 }
                    });





        }
    });


}

function handleAjaxError(jqXHR, textStatus, errorThrown) {


    var errorCode   = "Error Code: " + jqXHR.status;

    var errorTxt    = "Error Type: " + errorThrown;
    var errorMsg    = jqXHR.responseText;
    var openModalWithError = '<button id="display-modal-ajax-error" type="button" class="btn btn-white btn-danger btn-xs"><i class="fa fa-terminal"></i> Mostrar erro</button>';

    jQuery.gritter.add({
        title: '<i class="fa fa-exclamation-triangle"></i> Erro',
        text: "<p>"+errorCode+"</p>"+"<p>"+errorTxt+"</p><br>"+'<p style="text-align: right;">'+openModalWithError+"</p>",
        sticky: true,

        class_name: 'gritter-error'
    });


    $("#display-modal-ajax-error").on('click', function() {
        bootbox.dialog({
            title: '<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Descrição do Erro</span>',
            message: errorMsg,
            buttons: {
                cancel: {
                    label: "Fechar",
                    className: "btn-sm"
                }
            }
        });
    });
}