/**
 * Created by rpsimao on 23/06/14.
 */

$(function(){

    var options = {
        resetForm: true,
        dataType: "json",
        beforeSubmit: validate,
        success: showResponse

    };

    var optionsfemea = {
        resetForm: true,
        dataType: "json",
        beforeSubmit: validateFemea,
        success: showResponseFemea

    };

    $('#braille-price-simulation').ajaxForm(options);
    $('#braille-femea-price-simulation').ajaxForm(optionsfemea);

    numbersOnly(["placas", "altura", "largura", "qtd"]);

    $("#placas").focus();

});



function validateFemea(formData, jqForm, options){

    var form = jqForm[0];

    if ( !form.altura.value || !form.largura.value || !form.qtd.value || $("input[name=cortante]").val() == "") {
        $("#validateformtextfemea").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong><i class="ace-icon fa fa-times"></i>&nbsp;Erro!&nbsp;</strong>Todos os campos têm de estar preenchidos.<br></div>');


        return false;

    } else {

        var textCheck = $.ajax({
            type: 'GET',
            url: '/ajax/braillefemeapricesimulationvalidate',
            data: {"altura": form.altura.value, "largura":  form.largura.value, "qtd":  form.qtd.value, "cortante":  $("input[name=cortante]").val()},
            dataType: 'html',
            beforeSend: loadingBrailleSimulationPrice(),
            error: handleAjaxError,
            async: false
        }).responseText;


        var json = $.parseJSON(textCheck);


        var html = '<div class="well"><h4 class="blue smaller lighter"><i class="fa fa-female"></i>&nbsp;Simulação Preço Braille Fêmea</h4>';
        html += '<ul class="list-inline">';
        html += '<li>';
        html += '<span class="text-warning">Preço: </span>&euro;';
        html += json.preco;
        html += '</li>';
        html += '<li>';
        html += '<span class="text-warning">Quantidade: </span>';
        html += json.qtd;
        html += '</li>';
        html += '<li>';
        html += '<span class="text-warning">Linhas: </span>';
        html += json.linhas;
        html += '</li>';
        html += '<li>';
        html += '<span class="text-warning">Caracteres: </span>';
        html += json.caracteres;
        html += '</li>';
        html += '</ul>';
        html += '<br><h4 class="blue smaller lighter"><i class="fa fa-picture-o"></i> Representação Gráfica</h4>';
        html += '<img src="data:image/png;base64,' + json.imagem + '" class="img-thumbnail"/>';
        html += '</div>';

        $("#responseText").html(html);
    }
}


function showResponseFemea(){}




function validate(formData, jqForm, options) {

    var form = jqForm[0];


    if ( !form.placas.value || !form.texto.value) {
        $("#validateformtext").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong><i class="ace-icon fa fa-times"></i>&nbsp;Erro!&nbsp;</strong>Todos os campos têm de estar preenchidos.<br></div>');

        return false;

    } else {

        var textCheck = $.ajax({
            type: 'GET',
            url: '/ajax/braillepricesimulationvalidate',
            data: {"texto": form.texto.value, "placas":  form.placas.value},
            dataType: 'json',
            beforeSend: loadingBrailleSimulationPrice(),
            error: handleAjaxError,
            async: false
        }).responseText;




        if (textCheck == 1){
            $("#responseText").html(validateBraillePriceResponse(textCheck));
            return false;
        }

        var json = $.parseJSON(textCheck);

        var html = '<div class="well"><h4 class="green smaller lighter"><i class="fa fa-male"></i>&nbsp;Simulação Preço Braille Macho</h4>';
            html += '<h4 class="blue smaller lighter"><i class="fa fa-money"></i> Preço</h4>';
            html += "&euro;"+json.preco+"<br>";
            html += '<h4 class="blue smaller lighter" style="margin-top: 10px"><i class="fa fa-picture-o"></i> Representação Gráfica</h4>';
            html += '<img src="data:image/png;base64,' + json.imagem + '" class="img-thumbnail" style="padding-top:15px;"/>';
            html += '<h4 class="blue smaller lighter" style="padding-top: 20px;"><i class="fa fa-paragraph"></i> Texto</h4>';
            html += '<div style="padding: 10px;" class="img-thumbnail">'+form.texto.value+'</div>';
            html += '</div>';

        $("#responseText").html(html);
    }
}



   function loadingBrailleSimulationPrice()
   {
       $("#responseText").html('<div align="center"><p>A calcular preço...</p><img src="http://static.fterceiro.pt/assets/public/images/ajax-loader.gif" /></div>');
   }


function validateBraillePriceResponse(txt)
{
    if(txt == 1){$errorMsg = "Tem de inserir um Enter no fim do texto do Braille.";};
    if(txt == 2){$errorMsg = "Aten&ccedil;&atilde;o tem mais que um Enter no final do texto.";};
    if(txt == 3){$errorMsg = "Aten&ccedil;&atilde;o o texto do Braille em LARGURA n&atilde;o cabe na caixa.";};
    if(txt == 4){$errorMsg = "Aten&ccedil;&atilde;o o texto do Braille em ALTURA n&atilde;o cabe na caixa.";};

    var html = '<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert"> <i class="ace-icon fa fa-times"></i></button>';
        html+= '<p><i class="ace-icon fa fa-times"></i>&nbsp;';
        html+= $errorMsg;
        html+= '</i></p>';
        html+= '</div>';

    return html;

}


function showResponse(responseText, statusText, xhr, $form)  {

    /* var divOpen = '<div class="braille-rep-sucess">';
     var divClose =  '</div>';
     var txt1 = "Para o braille Nº"+responseText.braille_num + " foram inseridas " + responseText.pecas + " peças para repetição.";
     var Htmlbreak = "<br />";
     var txt2 = "Pode fechar a caixa.";

     $('#responseText').html(divOpen + txt1 + Htmlbreak + Htmlbreak + txt2 + divClose);*/
    // $("#responseText").html($errorMsg);


}

