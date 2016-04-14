$(function(){$("#tabs").tabs({ fx: { opacity: "toggle"}});});
$(function() {$("input:button, input:submit,a", ".novocortante").button();});
function closePanel(id){$(function() {$( id ).dialog( "close" );});}

function confirm_delete_cortante (id, cortante)
{
$(document).ready(function() {
	
		
		$.ajax({
			type: 'GET',
			url: '/cortantes/delete/',
			data: 'id=' + id,
			dataType: 'html',
			beforeSend: function() {
			var answer = confirm("Confirma a eliminação do Cortante Nº" + cortante +" do sistema?");
			if (!answer)
				{
				$('#exec'+id).attr('checked', false);
				return false;
				}
			},
			success: function(response) {
				$('#'+ id ).css('backgroundColor','#fc7e8a');
				$('#'+ id ).fadeOut('slow', function(){$('#'+ id ).hide();});
				closePanel("#dialog-cortante");
				growl('Info','Cortante Nº' + cortante + ' foi retirado do sistema.');
			},
			ajaxError: function(response) {
				$('#ajax-msg').css('display','block');
				$('#ajax-msg').html('Ocorreu um erro! O cortante Nº'+ cortante + ' não foi eliminado do sistema. Se o problema persistir contacte o Administrador de Sistemas.');
				
				}
		});
});
}