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
			data: {'job': job},
            beforeSend: function(){$("#coments").remove();},
            error: handleAjaxError,
			datatype: 'html',
			
				
			success: function(response) {
		
				var json = $.parseJSON(response);
				$("#largura").val(json.x);
				$("#altura").val(json.y);

                var autor = json.person;
                var revision = json.revisao;
                var text = json.comentarios;

                var textofinal = autor + "==" + revision + "==" + text;
				
				if(json.tipo == "autoplatina")
					{
					    $('#cortante-0').attr('checked', 'checked');
                        $("#coments").fadeIn();
                        $('<a href="#" id="coments" onmouseover="showComments(\''+textofinal+'\')"><i class="fa fa-external-link-square"></i>&nbsp; Comentarios Optimus</a>').appendTo("#form-inner-id-6");
					} 
				else if(json.tipo == "cilindrica") 
					{
					    $('#cortante-1').attr('checked', 'checked');
                        $("#coments").fadeIn();
                        $('<a href="#" id="coments" onmouseover="showComments(\''+textofinal+'\')"><i class="fa fa-external-link-square"></i>&nbsp; Comentarios Optimus</a>').appendTo("#form-inner-id-6");
					}
				
				$("#qtd").focus();


			  }
			});
		
		}
});



});

/*
 <span class="label label-sm label-primary arrowed arrowed-right">Smaller</span>
*/

function showComments(txt)
{
	
	
	var linhas = txt.split("==");


    var html = '<ul class="list-unstyled spaced">';

        html+= '<li>';
        html+= '<i class="fa fa-user"></i>&nbsp;:&nbsp;';
        html+= linhas[0]
        html+= '</li>';

        html+= '<li>';
        html+= '<i class="fa fa-calendar"></i>&nbsp;:&nbsp;';
        html+= linhas[1]
        html+= '</li>';

        html+= '<li>';
        html+= '<i class="fa fa-language"></i>&nbsp;:&nbsp;';
        html+= linhas[2]
        html+= '</li>';

        html+= '</ul>';
	
	
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