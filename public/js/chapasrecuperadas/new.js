/**
 * Created by rpsimao on 19/06/15.
 */

$(function(){
    $("#obra").focus();

   // var button = '<a style="margin-left: 5px;" id="chapas_recuperadas_novo_cliente" class="btn btn-info btn-xs"><i class="ace-icon fa fa-plus-square bigger-120 icon-only"></i> </a>';
   // $("#form-inner-id-2").append(button);


    var clientes = $.ajax({
        type: 'get',
        url: '/chapasrecuperadas/addclientes',
        dataType: 'html',
        error: handleAjaxError,
        async: false
    }).responseText;

    $("#form-inner-id-2").append(clientes);


    $("#chapas_recuperadas_novo_cliente").click(
        function(){



        });



    $('#dia').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        language: "pt"
    });







});



function setValueClienteChapasRecuperadas(cli)
{

    $("#cliente").val(cli);

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