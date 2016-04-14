/**
 * Created by rpsimao on 20/06/14.
 */
$(function(){

    var brailleNum = $("#nbraille_num").val();

    $('#modal-form-braille-repetitions').on('shown.bs.modal', function () {

        $("#nbraille_num_rep").val(brailleNum);
        $("#pecas_rep").focus();

        numbersOnly(["pecas_rep", "nbraille_num_rep"]);
    });

    $('<p class="checkbraille"><input type="button" value="Check" onclick="verifyBrailleTxt()" /></p>').insertAfter('#txt');

    $("#obras").addClass("input-xxlarge");

    loadRepertions();

    $("#qtd").ace_spinner({ value: "", min: 0, btn_up_class:'btn-info' , btn_down_class:'btn-info'});
    $("#b1").ace_spinner({  value: "", min: 0, btn_up_class:'btn-info' , btn_down_class:'btn-info'});
    $("#b2").ace_spinner({  value: "", min: 0, btn_up_class:'btn-info' , btn_down_class:'btn-info'});
    $("#b3").ace_spinner({  value: "", min: 0, btn_up_class:'btn-info' , btn_down_class:'btn-info'});
    $("#b4").ace_spinner({  value: "", min: 0, btn_up_class:'btn-info' , btn_down_class:'btn-info'});

    $("#nbraille_mes").ace_spinner({ value: "", min: 1, max: 31,  btn_up_class:'btn-info', btn_down_class:'btn-info'});
    $("#nbraille_ano").ace_spinner({ value: "", min: 13, max: 99, btn_up_class:'btn-info', btn_down_class:'btn-info'});

    $('#form-inner-id-6').append('<button type="button" id="codf3-label" class="btn btn-xs" style="margin-left: 5px"><i class="fa fa-edit"></i></button>')


    var cod = $("#codf3").val();

    var check = cod.slice(0,3);

    if (check == "FT_"){
        $("#codf3-label").hide();
    }

    $("#codf3-label").click( function(){
        var txtAdd = "FT_";
        $("#codf3").val(txtAdd + cod);
    });

    var options = {
        	 resetForm: true,
        	 dataType: "json",
       	 	 beforeSubmit:  validate,
        	 success:       showResponse
            };

    $('#rep-braille-form').ajaxForm(options);


    $('#modal-form-braille-repetitions').on('hidden.bs.modal', function () {

        loadRepertions();
    });


/*$("#rep-ist").click(function()
    {
   var dialog = $('<div id="responseText"></div>')
            .html('<div id="alert"></div> <form id="rep-braille-form" action="/arqbraille/repcreate" method="post"> <table> <tr> <td id="nbraille_num_rep-label"> <label for="nbraille_num_rep" class="required">Braille Nº:</label> </td> <td class="element"> <input type="text" name="nbraille_num_rep" id="nbraille_num_rep" value="" class="rounded-textbox_med" /> </td> </tr> <tr> <td id="pecas_rep-label"> <label for="pecas_rep" class="required">Peças:</label> </td> <td class="element"> <input type="text" name="pecas_rep" id="pecas_rep" value="" class="rounded-textbox_med" /> </td> </tr> <tr> <td class="element"><br /></td> <td class="element"><br /></td> </tr> <tr> <td><input type="checkbox" name="oxidacao_rep" value="1" id="oxidacao_rep" />&nbsp;Oxidação</td> <td><input type="checkbox" name="partidos_rep" value="1" id="partidos_rep" />&nbsp;Partidos</td> </tr> <tr> <td><input type="checkbox" name="esmagados_rep" value="1" id="esmagados_rep" />&nbsp;Esmagados</td> <td><input type="checkbox" name="novo_rep" value="1" id="novo_rep" />&nbsp;Novo Cortante</td> </tr> <tr> <td class="element"></td> <td class="element"> <input type="submit" name="submit" id="submit" value="Enviar" class="skip" /> </td> </tr> </table> </form>')
            .dialog({
                id: 'xpto-dialog',
                autoOpen: true,
                title: 'Repetição Braille Nº' + brailleNum,
                modal: true,
                dialogClass: 'ui-icon-alert',
                draggable: false,
                resizable: false,
                close: function(){location.reload();}
            });



    });*/

    $("#rep-listagem").click(function()
    {

        var brailleNum = $("#nbraille_num").val();
        /*var dialog = $('<div align="center"><p>A criar listagem...</p><img src="http://static.fterceiro.pt/assets/public/images/ajax-loader.gif" /></div>')
            .load('/arqbraille/replist/' + brailleNum)
            .dialog({
                autoOpen: true,
                title: 'Listagem Repetição Braille Nº' + brailleNum,
                modal: true,
                width:'auto',
                buttons: {
                    Fechar: function() {
                        $(this).dialog('close');
                        $(this).dialog('destroy');
                    }
                },
                dialogClass: 'ui-icon-alert',
                draggable: true,
                resizable: true
            });*/

        $('#listagem-modal-table').modal({
            show: true,
            remote: '/arqbraille/replist/' + brailleNum

        });

    });


    $('#id-pills-stacked').removeAttr('checked').on('click', function(){

        //alert("sdfwd");

        $("#arqbraille-rep-th").show();
        $("#arqbraille-rep-th").show();
    });



});


function checkCodF3(){

    var cod = $("#codf3").val();

    var check = cod.slice(0,3);

    var txtAdd = "FT_";

    if (check != txtAdd ){
        $("#codf3").val(txtAdd + cod);
    }

}


function loadRepertions()
{
    var brailleNum = $("#nbraille_num").val();
    var reptt = $('<div align="center"><p>A criar listagem...</p><i class="fa fa-circle-o-notch fa-spin"></i></div>').load('/arqbraille/replist/' + brailleNum);

    $("#braille_rept_div").html(reptt);

    if ($("#for_remove_if_necessary").val() == "Não existem repetições para este Braille.")
    {
        $(".for_remove_empty").remove();
    }

}




function validate(formData, jqForm, options) {

    	 	        var form = jqForm[0];
     	    if (!form.pecas_rep.value) {
       	 	             $("#rep-errors").remove();
        	 	         $("#alert").html('<p class="text-danger" id="rep-errors"><i class="fa fa-exclamation-triangle"></i>&nbsp;Tem de inserir um valor para as peças.</p>');
                         $("#group-pecas").html('<div class="form-group has-error"><label class="col-xs-12 col-sm-3 control-label no-padding-right" for="pecas_rep">Peças:</label><div class="col-xs-12 col-sm-9"><span class="block input-icon input-icon-right"><input type="text" class="form-control" placeholder="insira o nº de peças a repetir" id="pecas_rep" name="pecas_rep"/> <i class="ace-icon fa fa-exclamation-triangle"></i></span></div></div>');
        	 	         $("#pecas_rep").focus();

        	 	     return false;
        	 	    } else {
        	 	       $("#responseText").html('<div align="center"><p>A inserir dados...</p><img src="http://static.fterceiro.pt/assets/public/images/ajax-loader.gif" /></div>');


        	 	    }
     	}
function showResponse(responseText, statusText, xhr, $form)  {

    	 	       /* var divOpen = '<div class="braille-rep-sucess">';
    	 	        var divClose =  '</div>';
    	 	    var txt1 = "Para o braille Nº"+responseText.braille_num + " foram inseridas " + responseText.pecas + " peças para repetição.";
    	 	    var Htmlbreak = "<br />";
    	 	    var txt2 = "Pode fechar a caixa.";

    	 	    $('#responseText').html(divOpen + txt1 + Htmlbreak + Htmlbreak + txt2 + divClose);*/

                $('#modal-form-braille-repetitions').modal('hide');
                jQuery.gritter.add({
                    title: 'Braille',
                    text: 'Dados inseridos com sucesso.',
                    image: '/imagens/success.png',
                    sticky: false,
                    time: 1000,
                    class_name: 'gritter-success gritter-light'
                });

    	 	}