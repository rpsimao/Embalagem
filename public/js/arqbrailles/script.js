$(function(){
	
$('#obras').focus();
$('#obras').keyup(function(){
		
		var charLength = $(this).val().length;
		if (charLength == 5 )
			{
				getdata($(this).val());
			}
	});
	
	
$('<p class="checkbraille"><input type="button" value="Check" onclick="verifyBrailleTxt()"></input></p>').insertAfter('#txtbraille');


	
});

function loading(){
	
	$('#loading-animation').fadeIn();
	$('#loading-animation').html('<div class="animation-space"><img src="http://static.fterceiro.pt/assets/public/loading/loading1.gif" /> A obter dados do Optimus...</div>');
	
}

function getdata(j_number)
{
	
	$.ajax({
		type: 'GET',
		url: '/arqbraille/ajax',
		data: 'j_number=' + j_number,
		dataType: 'json',
        error: handleAjaxError,
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
			$(".warning").hide();
			$('<p class="warning">' + response +'</p>').insertAfter('#codf3');	
			
		}
		
	});	


}