$(function() {
		
		
		$( "#dialog-cortante" ).dialog({
			autoOpen: false,
			height: 'auto',
			width: 'auto',
			modal: true,
			hide: "blind",
			position : ['center', 50],
			resizable: false,
			draggable: false
		});

		
	});

function populatePanel(id, codigo)
	{
		$.ajax({
			type:     'GET',
			url:      '/ajax/getcortanteforview',
			data:     {'id': id},
            statusCode: {
                500: function () {
                    $("#ajax-msg").html("Erro. Ocorreu um erro no servidor.");
                },
                404: function () {
                    $("#ajax-msg").show();
                    $("#ajax-msg").html("Erro. Página não encontrada.");
                }
            },
            beforeSend: loading(),
			dataType: 'json',
			success: function(response) {
				$("#dialog-cortante").dialog( "open" );
				$("#estante").html(response["estante"]);
				$("#codigo").html(response["codigo"]);
				$("#cortan").html(response["cortante"]);
				$("#value_A").html(response["A"]);
				$("#value_B").html(response["B"]);
				$("#value_H").html(response["H"]);
				$("#value_f").html(response["f"]);
				$("#value_g").html(response["g"]);
				$("#value_pala").html(response["pala"]);
				$("#value_tipo").html(response["tipo"]);
				$("#value_util").html(response["formato_util"]);
				$("#value_otm").html(response["formato_otimizado"]);
				$("#value_entrada").html(response["formato_entrada"]);
				$("#value_esp").html(response["espaco"]);
				$("#value_Braille1").html(response["braille1"]);
				$("#value_Braille2").html(response["braille2"]);
				$("#value_Braille3").html(response["braille3"]);
				$("#value_fto").html(response["formato_std"]);
				$("#value_descasque").html(response["descasque"]);
				$("#value_obs").html(response["obs"]);
				$("#editar_cortante").html('<br /><a class="button" href="/cortantes/edit/'+id+'">Editar</a>');
				$("#apagar_cortante").html('<br /><a class="button" href="#" name="exec'+id+'" id="exec'+id+'" onclick= "Javascript:confirm_delete_cortante('+id+','+codigo+')">Apagar</a>');
                },
            complete: function(){$("#ajax-msg").fadeOut(); }
		  });
	}




function loading()
{
    $("#ajax-msg").show();
    $("#ajax-msg").css("backgroundColor", 'white');
    $("#ajax-msg").html('<table><tr><td><img src="/images/Spinner.gif" alt="spinner"/></td><td>&nbsp;&nbsp;&nbsp;A obter dados. Aguarde...</td></tr></table>');



}
