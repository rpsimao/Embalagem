$(function(){



$('#numobra').focus();
$('#numobra').keyup(function(){
	
	var charLength = $(this).val().length;
	if (charLength == 5 )
		{
		
		var job = $(this).val();
		$.ajax({
			type: 'GET',
			url: '/ajax/getsizeofcarton',
			data: {'job' : job},
            error: handleAjaxError,
			datatype: 'html',
			
				
			success: function(response) {

                var json = $.parseJSON(response);

                if (json.code == 404) {

                    $("#braille_index_error_alerts").fadeIn();

                    var html='O nome do cortante não está definido segundo as regras. Corrija no Optimus e volte a tentar.<b> Ex: CA 03383.01 15 UNID</b><br />';

                    html+='<button class="btn btn-sm btn-info" style="margin-right: 10px;" onclick="notPack()">A Obra não é uma embalagem</button>';
                    html+='<button class="btn btn-sm" onclick="closeAlert()">Fechar</button>';


                    $("#errors").html(html);


                } else {

                    $("#femeaLrg").val(json.x);
                    $("#femeaAlt").val(json.y);

                    var autor = json.person;
                    var revision = json.revisao;
                    var text = json.comentarios;

                    var textofinal = autor + "==" + revision + "==" + text;


                    if (json.tipo == "autoplatina") {
                        $('#cortante-0').attr('checked', 'checked');
                        $("#coments").remove();
                        $('<a class="btn btn-white btn-purple btn-sm rps-mtop5" href="#" id="coments" onmouseover="showComments(\'' + textofinal + '\')"><i class="ace-icon fa fa-eye"></i> Comentarios Optimus</a>').appendTo("#form-inner-id-6");
                    }
                    else if (json.tipo == "cilindrica") {
                        $('#cortante-1').attr('checked', 'checked');
                        $("#coments").remove();
                        $('<a class="btn btn-white btn-purple btn-sm rps-mtop5" href="#" id="coments" onmouseover="showComments(\'' + textofinal + '\')"><i class="ace-icon fa fa-eye"></i> Comentarios Optimus</a>').appendTo("#form-inner-id-6");
                    }

                    $("#texto").focus();
                    }
                }
			});
		
		}
});




    /*var options = {
        resetForm: true,
        dataType: "json",
        beforeSubmit:  validate_create_braille_00001,
        success:       showResponse_create_braille_00001
    };
    //$('#create-braille-00001').ajaxForm(options);


    var messages = {
        "ERR_EMPTY_FIELD":'* Este campo não pode estar vazio.',
        "ERR_LENGHT_PASSWD" : '* A palavra passe tem de ter entre 4 e 12 caracteres.',
        "ERR_COD_F3": '* Este campo tem de ter entre 5 e 7 algarismos.',
        "ERR_EMAIL_MALFORMED": '* O endereço de email não é válido',
        "ERR_ONLY_NUMBERS_ALLOWED": "* Este campo só pode conter algarismos.",
        "ERR_COD_OBRA": '* Este campo tem de ter 5 algarismos.'
    }


    $('#create-braille-00001').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            numobra: {
                validators: {
                    notEmpty: {
                        message: messages.ERR_EMPTY_FIELD
                    },
                     regexp: {
                        regexp: /^[0-9]+$/,
                        message: messages.ERR_ONLY_NUMBERS_ALLOWED
                    },
                    stringLength: {
                        min: 5,
                        max: 5,
                        message: messages.ERR_COD_OBRA
                    }
                }
            },
            femeaLrg: {
                validators: {
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: messages.ERR_ONLY_NUMBERS_ALLOWED
                    }
                }
            },
            femeaAlt: {
                validators: {
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: messages.ERR_ONLY_NUMBERS_ALLOWED
                    }
                }
            },
            texto: {
                validators: {
                    notEmpty: {
                        message: messages.ERR_EMPTY_FIELD
                    }
                }

            },
            textoOptimus: {
                validators: {
                    notEmpty: {
                        message: messages.ERR_EMPTY_FIELD
                    }
                }

            }

        }
    });*/


});




$("#textoOptimus").focus(function() {
    var $this = $(this);
    $this.select();

    // Work around Chrome's little problem
    $this.mouseup(function() {
        // Prevent further mouseup intervention
        $this.unbind("mouseup");
        return false;
    });

});


function validate_create_braille_00001(formData, jqForm, options){



}

function showResponse_create_braille_00001(responseText, statusText, xhr, $form){


    alert(responseText);




}


function showComments(txt)
{


	var linhas = txt.split("==");

    var html = '<div style="padding:10px;">';
        html+= '<p><i class="ace-icon fa fa-user"></i>&nbsp;&nbsp;- '+linhas[0];
        html+= '</p>';
        html+= '<p><i class="ace-icon fa fa-calendar"></i>&nbsp;&nbsp;- '+linhas[1];
        html+= '</p>';
        html+= '<p><i class="ace-icon fa fa-file-text-o"></i>&nbsp;&nbsp;- '+linhas[2];
        html+= '</p></div>';


	
$("#coments").qtip({


	    content: {
			text: html,
			
			title: {
				text: "Dados do Optimus",
				button: true
			}
		},
		position: {
			at: 'bottom center',
			my: 'top center',
			viewport: $(window),
			effect: false
		},
		show: {
			event: 'click',
			solo: true
		},
		hide: 'mouseout',
		style: {
			classes: 'qtip-wiki qtip-light qtip-shadow click'
		}
	});



}

function notPack(){

    $("#braille_index_error_alerts").fadeOut();
    $('#numobra').val("");
}

function closeAlert(){
    $("#braille_index_error_alerts").fadeOut();

}