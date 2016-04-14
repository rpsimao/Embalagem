$(function() {


    $.ajax({
        type: 'GET',
        url: '/ajax/getcurrentbrailleprice',
        error: handleAjaxError,
        beforeSend: loadingPrice,
        dataType: 'json',

        success: function (response) {
            var json = eval(response);

            $("#braille_male_price").text(json.price);
        }
    });
});

function isInArray(value, array)
{
    return array.indexOf(value) > -1;
}


function loadingPrice()
{
    $('#braille_male_price').html('<i class="ace-icon fa fa-cog fa-spin"></i> A obter dados...');

}


function changePrice()
{


    var promptOptions = {
        title: '<div class="text-primary"></span><i class="fa fa-edit"></i>&nbsp;Insira a sua Password</div>',
        inputType: "password",
        buttons: {
            confirm: {
                label: "OK"
            }

        },
        callback: function(result) {
            if (result !== null) {

                var check = $.ajax({
                    type: 'GET',
                    url: '/ajax/precobrailleallowed',
                    data: {'passwd': result},
                    dataType: 'html',
                    error: handleAjaxError,
                    async: false
                }).responseText;


                var responseCall = eval(check);

                console.log(responseCall.flag);

                if (responseCall.flag == true ){

                    var htmlEl = '<input type="text" id="new_braille_male_price" name="new_braille_male_price" class="input-sm"/>';

                    $("#braille_male_price").html(htmlEl);
                    $("#new_braille_male_price").focus();
                    $("#braille_male_price_button_place").html('<button id="braille_male_price_button1" class="btn btn-minier btn-primary"><i class="fa fa-hand-o-right"></i>&nbsp;Novo Pre&ccedil;o</button>');

                    $("#braille_male_price_button1").click(function(){

                    var passwd = $("#new_braille_male_price").val();
                        $.ajax({
                                type: 'GET',
                                url: '/ajax/updatecurrentbrailleprice',
                                data: {'v' : passwd} ,
                                error: handleAjaxError,
                                dataType: 'text',

                                success: function() {
                                var currentBraillePrice = $.ajax({
                                    type: 'GET',
                                    url: '/ajax/getcurrentbrailleprice',
                                    dataType: 'text',
                                    async: false,
                                    error: handleAjaxError
                                }).responseText;


                                var price = eval(currentBraillePrice);

                                $("#braille_male_price").text(price.price);
                                $("#braille_male_price_button_place").html('<button id="braille_male_price_button" class="btn btn-minier btn-default" onclick="changePrice()"><i class="fa fa-repeat"></i>&nbsp;Alterar</button>');


                                jQuery.gritter.add({
                                    title: 'Braille',
                                    text: 'Pre&ccedil;o do Braille Macho Actualizado.',
                                    image: '/imagens/success.png',
                                    sticky: false,
                                    time: 1000,
                                    class_name: 'gritter-success gritter-light'
                                });


                            }

                        });

                    });

                } else {

                    var msg = '<h4 class="text-danger">Ocorreu um erro:</h4><ul class="list-unstyled spaced"><li><i class="ace-icon fa fa-times bigger-110 red"></i> escreveu mal a password.</li><li><i class="ace-icon fa fa-times bigger-110 red"></i> não tem permissão para aceder este recurso.</li></ul>';

                    bootbox.dialog({
                        message: msg,
                        title: '<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Alerta</span>',
                        buttons: {
                            success: {
                                label: "OK",
                                className: "btn-info",
                                callback: changePrice()

                            }
                        }
                    });

                }


            }
        }
    };

    bootbox.prompt(promptOptions);
}
function handleAjaxError(jqXHR, textStatus, errorThrown) {


    var errorCode   = "Error Code: " + jqXHR.status;
    /**var errorStatus = "Status: " + textStatus;*/
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