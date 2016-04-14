jQuery(document).ready(function($) {

    $('#obras').focus();
    $('#obras').keyup(function(){

        var charLength = $(this).val().length;
        if (charLength == 5 )
        {
            getdata($(this).val());
        }
    });

    $('<p class="checkbraille"><button type="button" class="btn btn-xs" onclick="verifyBrailleTxt()"><i class="fa fa-search"></i>&nbsp;procurar similares</button></p>').insertAfter('#txtbraille');

    $("#qtd").ace_spinner({ value: "", min: 0, btn_up_class:'btn-info' , btn_down_class:'btn-info'});
    $("#b1").ace_spinner({ value: "", min: 0, btn_up_class:'btn-info' , btn_down_class:'btn-info'});
    $("#b2").ace_spinner({ value: "", min: 0, btn_up_class:'btn-info' , btn_down_class:'btn-info'});
    $("#b3").ace_spinner({ value: "", min: 0, btn_up_class:'btn-info' , btn_down_class:'btn-info'});
    $("#b4").ace_spinner({ value: "", min: 0, btn_up_class:'btn-info' , btn_down_class:'btn-info'});

    $("#nbraille_mes").ace_spinner({ value: "", min: 1, max: 31,  btn_up_class:'btn-info' , btn_down_class:'btn-info'});
    $("#nbraille_ano").ace_spinner({ value: "", min: 13, max: 99,btn_up_class:'btn-info' , btn_down_class:'btn-info'});

    $('#form-inner-id-6').append('<button type="button" id="codf3-label" class="btn btn-xs" style="margin-left: 5px"><i class="fa fa-edit"></i> inserir FT_</button>');

    $("#codf3-label").click( function(){
        var txtAdd = "FT_";
        var cod = $("#codf3").val();
        var chars3 = cod.slice(0,3);

        if(chars3 != "FT_") {

            $("#codf3").val(txtAdd + cod);
        }
    });

});

function checknewbraille()
{

    if ($("#obras").val() == ""){

        displayFormError('#form-inner-id-1');
        $("#obras").focus();
        return false;
    }

    if ($("#nbraille_lab").val() == ""){

        displayFormError('#form-inner-id-2');
        $("#nbraille_lab").focus();
        return false;
    }

    if ($("#nbraille_num").val() == ""){

        displayFormError('#form-inner-id-3');
        $("#nbraille_num").focus();
        return false;
    }

    if ($("#nbraille_mes").val() == ""){

        displayFormError('#form-inner-id-4');
        $("#nbraille_mes").focus();
        return false;
    }

    if ($("#nbraille_ano").val() == ""){

        displayFormError('#form-inner-id-5');
        $("#nbraille_ano").focus();
        return false;
    }

    if ($("#codf3").val() == ""){

        displayFormError('#form-inner-id-6');
        $("#codf3").focus();
        return false;
    }

    if ($("#codcli").val() == ""){

        displayFormError('#form-inner-id-7');
        $("#codcli").focus();
        return false;
    }

    if ($("#produto").val() == ""){

        displayFormError('#form-inner-id-8');
        $("#produto").focus();
        return false;
    }


    if ($("#qtd").val() == ""){

        displayFormError('#form-inner-id-9');
        $("#qtd").focus();
        return false;
    }


}

function displayFormError(id)
{

    var error = $(id).append('<div class="help-block col-xs-12 col-sm-reset inline" style="margin-left: 5px;"> <span class="label label-danger arrowed-in">Não pode estar vazio!</span> </div>');

    return error;

}

function loading(){

    /*$('#loading-animation').fadeIn();
    $('#loading-animation').html('<div class="well well-sm"><img src="http://static.fterceiro.pt/assets/public/loading/loading1.gif" /> A obter dados do Optimus...</div>');*/

    jQuery.gritter.add({
        title: 'Dados',
        text: '<img src="http://static.fterceiro.pt/assets/public/loading/loading1.gif" /> A obter dados do Optimus...',
        sticky: false,
        time: 1000,
        class_name: 'gritter-light'
    });

}

function getdata(j_number)
{

    $.ajax({
        type: 'GET',
        url: '/arqbraille/ajax',
        data: {'j_number' : j_number},
        error: handleAjaxError,
        dataType: 'json',
        beforeSend: loading(),
        complete: function(){$('#loading-animation').fadeOut();},


        success: function(response) {

            var json = eval(response);
            if (json.error == 'error')
            {
                $(".warning").hide();
                $('<p class="warning">A Obra não existe no Optimus.</p>').insertAfter('#obras');
                $("#obras").select();
                $("#obras").focus();
            } else {
                $(".warning").hide();
                $('#nbraille_lab').val(json.cliente);
                $('#nbraille_mes').val(json.mes);
                $('#nbraille_ano').val(json.ano);
                $('#codcli').val(json.codcli);
                $('#produto').val(json.produto);
                $('#nbraille_num').val(json.last);
                $('#codf3').val(json.codf3);
                $("#qtd").focus();

                checkCodF3();

            }
        }
    });

}

function verifyBrailleTxt()
{
    var text = $("#txtbraille").val();

    if (!text)
    {


        var msg = '<h4 class="text-danger">Descrição:</h4><ul class="list-unstyled spaced"><li><i class="ace-icon fa fa-times bigger-110 red"></i> Tem de inserir texto para comparação</li></ul>';

        bootbox.dialog({
            message: msg,
            title: '<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Ocorreu um erro</span>',
            buttons: {
                success: {
                    label: "OK",
                    className: "btn-info"

                }
            }
        });

    } else {

        $.ajax({
            type: 'GET',
            url: '/ajax/txtbraille',
            data: 'txt=' + text,
            error: handleAjaxError,
            dataType: 'html',

            success: function(response) {


                bootbox.dialog({
                    message: response,
                    title: '<span class="text-info"><i class="fa fa-info-circle"></i> Resultados</span>',
                    buttons: {
                        success: {
                            label: "OK",
                            className: "btn-info"

                        }
                    }
                });

            }
        });

    }

}

function checkCodF3()
{


   var codf3 = $("#codf3").val();

    $.ajax({
        type: 'GET',
        url: '/ajax/checkcodf3',
        data: 'codf3=' + codf3,
        error: handleAjaxError,
        dataType: "html",

        success: function(response) {

            $(".label-warning").hide();

            if (response != ""){

                $('<span id="codf3warning" class="label label-warning rps-mtop5"><i class="ace-icon fa fa-exclamation-triangle bigger-120"></i>&nbsp;' + response +'</span>').insertAfter('#codf3');
            }

        }

    });


}