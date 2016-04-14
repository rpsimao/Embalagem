$().ready(function(){
	$.ajaxSetup({
		error:function(x,e){
			if(x.status==0){
			alert('You are offline!!\n Please Check Your Network.');
			}else if(x.status==404){
				displayErrors('<span class="error">Ocorreu um erro.</span><p>O endere&ccedil;o n&atilde;o existe.</p>');
			}else if(x.status==500){
				displayErrors('<span class="error">Ocorreu um erro.</span><p>Erro interno da aplica&ccedil;&atilde;o.</p>');
			}else if(e=='parsererror'){
				alert('Error.\nParsing JSON Request failed.');
			}else if(e=='timeout'){
				alert('Request Time out.');
			}else if(e=='noobra'){
				alert('Request Time out.');	
			}else {
				alert('Unknow Error.\n' + x.responseText);
			}
		}
	});
	
	
});



function digits(id)
{
	$("#"+id).keydown(function(event) {
        if ( event.keyCode == 46 || event.keyCode == 8 ) {
         }
        else {
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
}


function displayErrors(errorMsg)
{
	
$(function() {
		
		var dialog = $('<div></div>')
			.html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>'+errorMsg+'</p>')
			.dialog({
				modal: true,
				buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
				}
			}
		});
	});	
	$dialog.dialog('open');
}



function zoom(id , name)
{    
	$.fancybox( $("#" + id), {
		href : '/cartons/cartelas/images/' + id + '.jpg',
        title : name +' - '+ id
    });

}


function displayClose(id)
{
	$('#'+id).show();
}

function hideClose(id)
{
	$('#'+id).hide();
	
}

function hideProduct(id)
{
	$('#display-'+id).hide();
	$('.leftcol-info').hide();
	
}


function info(id)
{
	$('.leftcol-info').hide();
	$.ajax({
		type: 'GET',
		url: '/ajax/cartelas',
		data: 'cod=' + id,
		dataType: 'json',
		
		success: function(response) {

			$('.leftcol-info').fadeIn(500);

			var json = eval(response);
			$('#leftcol-info-name').html(json.nome);
			$('#leftcol-info-codigo').html(json.codbarras);
			$('#leftcol-info-codigo-image').html("<img src='data:image/png;base64," +json.image+ "' />");
			$('#leftcol-info-obra').html(json.obras);
		}});

	
}


$(function() {

	$("#search").autocomplete({
			source: "/ajax/cartelassearch",
			minLength: 2,
			select: function( event, ui ) {
				$('#products-all').hide();
				$('#search-results').hide();
				$('#search-results').fadeIn(500);
				$('#search-results').append('<div id="display-'+ui.item.value+'"><div class="product" onmouseover="displayClose('+ui.item.value+');" onmouseout="hideClose('+ui.item.value+')";><div class="remove-product" id="'+ui.item.value+'"><a href="#" onclick="hideProduct('+ui.item.value+');"><img src="/images/minus.png" alt="fechar" title="Fechar"/></a></div><p class="product-title">'+ui.item.nome+'<br /><span class="product-code">'+ui.item.value+'</span></p><img src="/cartons/cartelas/thumbs/'+ui.item.value+'.jpg" alt="'+ui.item.nome+'" /><div class="barra-botoes"><button class="button-small" id="button-preview-'+ui.item.nome+'" name="button-preview-'+ui.item.value+'" onclick="zoom(\''+ui.item.value+'\',\''+ui.item.nome+'\')">Zoom</button><button class="button-small" id="button-add-'+ui.item.value+'" name="button-add-'+ui.item.value+'" onclick="addToJob(\''+ui.item.nome+'\',\''+ui.item.value+'\');">Adic.</button><button class="button-small" id="button-info-'+ui.item.value+'" name="button-info-'+ui.item.value+'" onclick="info('+ui.item.value+')">Info</button></div></div></div>');
			}
		});

});

$(function() {

	$("#search-nome").autocomplete({
			source: "/ajax/cartelassearchnome",
			minLength: 2,
			select: function( event, ui ) {
				
			    $('#products-all').hide();
				$('#search-results').hide();
				$('#search-results').fadeIn(500);
				$('#search-results').append('<div id="display-'+ui.item.cod+'"><div class="product" onmouseover="displayClose('+ui.item.cod+');" onmouseout="hideClose('+ui.item.cod+');"><div class="remove-product" id="'+ui.item.cod+'"><a href="#" onclick="hideProduct('+ui.item.cod+');"><img src="/images/minus.png" alt="fechar" title="Fechar"/></a></div><p class="product-title">'+ui.item.value+'<br /><span class="product-code">'+ui.item.cod+'</span></p><img src="/cartons/cartelas/thumbs/'+ui.item.cod+'.jpg" alt="'+ui.item.value+'" /><div class="barra-botoes"><button class="button-small" id="button-preview-'+ui.item.value+'" name="button-preview-'+ui.item.cod+'" onclick="zoom(\''+ui.item.cod+'\',\''+ui.item.value+'\')">Zoom</button><button class="button-small" id="button-add-'+ui.item.cod+'" name="button-add-'+ui.item.cod+'" onclick="addToJob(\''+ui.item.value+'\',\''+ui.item.cod+'\');">Adic.</button><button class="button-small" id="button-info-'+ui.item.cod+'" name="button-info-'+ui.item.cod+'" onclick="info('+ui.item.cod+')">Info</button></div></div></div>');
			}
		});

});


function addToJob(nome, codbarras)
{
	
	$('#addoptimus').append(nome + ' - ' + codbarras + ',');
	/*cleanDataForOptimus('addoptimus');*/
	
}


function checkObraOptimus(nObra)
{
	
	nObra = $('#'+nObra).val();
	
	$.ajax({
		type: 'GET',
		url: '/ajax/checkobraoptimus',
		data: 'obra=' + nObra,
		dataType: 'json',
		
		success: function(response)
					{
						if (response.e == 'noobra')
						{
							$("label#nobra_error").html('Esta Obra n&atilde;o existe no Optimus.');
							$("label#nobra_error").show();
		      				$("input#nobra").focus();
		      				$('#submit_btn').hide();
		      			} else {
		      				$('#submit_btn').show();
		      				$("label#nobra_error").hide();
		      			}	
					}
	
		
	});
}


function cleanDataForOptimus(id)
{
	var post_data = $('#'+id).val();
	
	$.post('/ajax/cleandata', {data: post_data}, function(data)
	{
		$('#'+id).html(data);
		
	});
}



$(function() {
	  
	  $('.error').hide();
	  $(".button").click(function() {
	  $('.error').hide();
	    
	  var nobra = $("input#nobra").val();
			if (nobra == "") {
	      $("label#nobra_error").show();
	      $("input#nobra").focus();
	      return false;
	    }
			var addoptimus = $("textarea#addoptimus").val();
			if (addoptimus == "") {
	      $("label#addoptimus_error").show();
	      $("textarea#addoptimus").focus();
	      return false;
	    }
			
			var dataString = 'nobra='+ nobra + '&addoptimus=' + addoptimus;		
			$.ajax({
	      type: "POST",
	      url: "/ajax/cartelastooptimus",
	      data: dataString,
	      success: function(response) {
	      	
	      	if(response == "OK"){
	      	
	      	$('#rightcol').html("<div id='message'></div>");
	        
	        $('#message').html("<h2>Dados enviados para o Optimus</h2>")
	        .append("<p>Pode-se imprimir a folha de Obra</p>").hide();
	        $('#message').fadeIn(1500);
	       } else{
	       	alert('error');
	       }
	        
	        }
	     });
	    return false;
		});
	});


