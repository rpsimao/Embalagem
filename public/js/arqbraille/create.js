/**
 * Created by rpsimao on 23/06/14.
 */
function replaceHref(brailleNum){

    var nome = $("#verify").val();

    $("#criar-selo").fadeIn();
    $("#criar-selo").attr("href", "/arqbraille/renderpdf/id/"+brailleNum+"/nome/" + nome);


}

function setNewJob(){


     if (checkIfObraItsBraille() != false){

            var numobra = $("#create-braille-numobra").val();

            var botao1 = '<a id="for-close-the-modal" href="/braille/braillepdf?obra='+numobra+'" class="btn btn-sm btn-primary" target="_blank"><i class="ace-icon fa fa-check"></i> Criar PDF</a>';
            var botao2 = '<a id="for-close-the-modal" href="/braille/braillepdfdownload?obra='+numobra+'" class="btn btn-sm btn-info"><i class="ace-icon fa fa-download"></i> Download PDF</a>'

            $("#create-braille-submit").html(botao2+botao1);

            $("#msg").fadeIn(function(){

                $("#msg").html('<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="ace-icon fa fa-check"></i>&nbsp;Obra alterada. </div>');

            });

            $("#msg").fadeOut(2500);
            $("#modal-create-braille-obra-error").html("");

}

}




function checkIfObraItsBraille()
{

$.ajax({

    type: 'GET',
    url: '/ajax/validateJobForBraillePDF',
    data: {'job': $("#create-braille-numobra").val()},
    dataType: 'text',
    error: handleAjaxError,
    success: function(data){

        var values = $.parseJSON(data);
        var html ="";


        if(values.optimus == false){

            html+='<p class="text-danger small">* A Obra não existe no Optimus.</p>';
            $("#modal-create-braille-obra-error").html(html);
            return false
        }

        if(values.braille == false){

            html+='<p class="text-danger small">* A Obra não está preparada para Braille.</p>';
            $("#modal-create-braille-obra-error").html(html);
            return false
        }


    }
});







}

$(function(){
    $("#verify").focus();
    $("#criar-selo").hide();



    $('#create-braille-modal').on('shown.bs.modal', function() {


        $.ajax({
            type: 'GET',
            url: '/ajax/createbraille',
            data: {'id': $("#braille-num-for-pdf").val()},
            dataType: 'text',
            error: handleAjaxError,
            success: function(data){

                var valuesJSON = $.parseJSON(data);

                $("#create-braille-textarea").text(valuesJSON.textoOptimus);
                $("#create-braille-numobra").val(valuesJSON.numobra);
                $("#create-braille-numpecas").text(valuesJSON.pecas);
                $("#create-braille-texto").text(valuesJSON.textobraille);
                $("#create-braille-preco").text(valuesJSON.preco);
                $("#create-braille-numlinhas").text(valuesJSON.linhas);
                $("#create-braille-imagem").html('<img src="data:image/png;base64,' + valuesJSON.imagem + '" class="img-thumbnail" />');

                var botao1 = '<a id="for-close-the-modal" href="/braille/braillepdf/'+ valuesJSON.numobra +'" class="btn btn-sm btn-primary" target="_blank"><i class="ace-icon fa fa-check"></i> Criar PDF</a>';
                var botao2 = '<a id="for-close-the-modal" href="/braille/braillepdfdownload/'+ valuesJSON.numobra +'" class="btn btn-sm btn-info"><i class="ace-icon fa fa-download"></i> Download PDF</a>'

                $("#create-braille-submit").html(botao2+botao1);

            }
        });

    });


    $("#create-braille-textarea").focus(function() {
        var $this = $(this);
        $this.select();

        // Work around Chrome's little problem
        $this.mouseup(function() {
            // Prevent further mouseup intervention
            $this.unbind("mouseup");
            return false;
        });

    });

    $("#for-close-the-modal").on("click", function(){
        $("#create-braille-modal").modal('hide');

    });



});