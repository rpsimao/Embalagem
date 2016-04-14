
function confirm_exec_product (id, cortante)
{
$(document).ready(function() {
	
		
		$.ajax({
			type: 'GET',
			url: '/ajax/cortantesexecucao',
			data: 'id=' + id,
			dataType: 'html',
			beforeSend: function() {
			var answer = confirm("Confirma a execu&ccedil;&atilde;o do Cortante Nº" + cortante +"?");
			if (!answer)
				{
				$('#exec'+id).attr('checked', false);
				return false;
				}
			},
			success: function(response) {
				
				$('#'+ id ).css('backgroundColor','#fc7e8a');
				$('#'+ id ).fadeOut('slow', function(){$('#'+ id ).hide();});
				growl('Info','Cortante Nº' + cortante + ' foi dado como executado.');
			}
		});
	});
}