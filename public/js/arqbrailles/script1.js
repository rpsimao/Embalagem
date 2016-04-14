$(function(){
	
$('#obras').focus();
$('#obras').keyup(function(){
		
		var charLength = $(this).val().length;
		if (charLength == 5 )
			{
				getdata($(this).val());
			}
	});
	
	
$('<p class="checkbraille"><input type="button" value="Check" onclick="verifyBrailleTxt()"></input></p>').insertAfter('#txt');


	
});




function getdata(j_number)
{
	
	$.ajax({
		type: 'GET',
		url: '/arqbraille/ajax',
		data: 'j_number=' + j_number,
        error: handleAjaxError,
		dataType: 'json',
		
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
		    				$('#codf3').val(json.codf3);
		    				
		    				
		    				$("#qtd").focus();
		    				
		    			}
		}
	});

}

function verifyBrailleTxt()
{
	var text = $("#txt").val();
	
	if (!text)
		{
		var dialog = $('<div></div>')
		.html('<p>Tem de inserir texto para comparação!</p>')
		.dialog({
			autoOpen: true,
			title: 'Erro',
			modal: true,
			buttons: {
						Ok: function() {
										$(this).dialog('close');
										$(this).dialog('destroy'); 
										}
					  },
			dialogClass: 'ui-icon-alert',
			draggable: false,
			resizable: false
			
									  	
		});
		} else {
	
	$.ajax({
		type: 'GET',
		url: '/ajax/txtbraille',
		data: 'txt=' + text,
        error: handleAjaxError,
		dataType: 'html',
		
		success: function(response) {
			
			var dialog = $('<div></div>')
			.html(response)
			.dialog({
				autoOpen: true,
				title: 'Brailles',
				modal: true,
				buttons: {
							Ok: function() {
											$(this).dialog('close');
											$(this).dialog('destroy'); 
											}
						  },
				dialogClass: 'ui-icon-alert',
				height: 400,
				width: 500
										  	
			});


		}
	});
	
		}	
	
}
