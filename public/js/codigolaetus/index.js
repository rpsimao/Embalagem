/**
 * Created by rpsimao on 23/06/15.
 */

$(function(){
    $("#cortante").focus();
});

function getMedidasCortanteLaetus(){

        var cortante = $('#cortante').val();

        $.ajax({
            type: 'GET',
            url: '/ajax/medidascortante',
            data: {'id' : cortante},
            beforeSend: loading,
            error: handleAjaxError,
            dataType: 'html',
            complete: removeLoading,
            success: function(response) {

                var singleValue = response.split("x");
                var temp = new Array();
                temp = response.split("x");
                var howMany = temp.length;

                if (howMany == 4)
                {
                    $('#formato-a').val(singleValue[0]);
                    $('#formato-b').val(singleValue[1]);
                    $('#formato-h').val(singleValue[2]);
                    $('#laboratorio').val(singleValue[3]);
                    $('#produto').focus();
                } else {
                    $('#laboratorio').val(singleValue[1]);
                }

                if ($('#formato-a').val() == 0)
                {
                    $('#formato-a').focus();

                } else {

                    if ($('#laboratorio').val() == "Ver dossier")
                    {
                        $('#laboratorio').val('');
                        $('#laboratorio').focus();
                    } else {
                        $('#laboratorio').focus();
                    }
                }



            }
        });

}
function loading()
{
    var html = '<span id="laetus_loading" style="margin-left: 5px;"><i class="fa fa-refresh fa-spin"></i> A obter dados...</span>';

    $("#laetus_loading").show();
    $("#form-inner-id-1").append(html);



}

function removeLoading(){

        $("#laetus_loading").fadeOut();
        $("#laetus_loading").remove();


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