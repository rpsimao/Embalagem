function createRequestObject(){
	var request_o; //declare the variable to hold the object.
	var browser = navigator.appName; //find the browser name
	if(browser == "Microsoft Internet Explorer"){
		/* Create the object using MSIE's method */
		request_o = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		/* Create the object using other browser's method */
		request_o = new XMLHttpRequest();
	}
	return request_o; //return the object
}

var http = createRequestObject(); 

/* Function called to get the product categories list */


function getEsp()
{
$(document).ready(function() {

       var url = $('#cartolina').val();
       var cleanurl = url.replace('+','%2B');
       
       
       var splitURL = cleanurl.split("/");	
			
		$.ajax({
			type: 'GET',
			url: '/ajax/espessura',
			data: 'num=' + splitURL[0] + "-" + splitURL[1],
			dataType: 'html',
			
			success: function(response) {
				
				$('#espessura').val(response);
			}
		});
	});
}

function getCodInterno(cod){
	
	http.open('get', '/ajax/registos/'+ cod);

	http.onreadystatechange = handleCodigoInterno; 
	http.send(null);
	
}
function handleCodigoInterno(){
	if(http.readyState == 4){ //Finished loading the response
		
		var response = http.responseText;
		
		document.getElementById('registos_dir').innerHTML = response;
	}
}

function getObraInfo(){

	var url = document.getElementById('obra').value;
	
	
	http.open('get', '/ajax/obraoptimus/'+ url);

	http.onreadystatechange = handleObraInfo; 
	http.send(null);
}

function handleObraInfo(){
	if(http.readyState == 4){ //Finished loading the response
		
		var response = http.responseText;
		
		document.getElementById('optimus').innerHTML = response;
	}
}

function provaPrepress(id, obra){

	
	
	var input_box = confirm("Concluir prova da Obra "+obra+"?");
	
	if (input_box==true)
	{ 
		http.open('get', '/ajax/provaprepress/'+ id);

		http.onreadystatechange = handleProvaPrepress; 
		http.send(null);
	} else {
		return false; 
	}
	
	
}

function provaDepTec(id, obra){

var input_box = confirm("Concluir prova da Obra "+obra+"?");
	
	if (input_box==true)
	{ 
		http.open('get', '/ajax/provadeptec/'+ id);

		http.onreadystatechange = handleProvaPrepress; 
		http.send(null);
	} else {
		return false; 
	}
	
}

function handleProvaPrepress(){
	if(http.readyState == 4){ //Finished loading the response
		
		window.location = "/emprova"
		
		
	}
}

function imageRotate(path, degrees, obra){
	
	
	http.open('get', '/ajax/handleimages/path/' + path + "/deg/" + degrees +"/obra/" + obra );

	http.onreadystatechange = handleImageRotate; 
	http.send(null);
}

function handleImageRotate(){
	
	if(http.readyState == 4){ //Finished loading the response

		var response = http.responseText;
		document.getElementById('thumb_ajax').innerHTML = response;
		
		location.reload(true);

		
	}
}

function imageDelete(path, obra){
	
	
var input_box = confirm("ATENÇÃO, tem a certeza que quer apagar a imagem?");
	
	if (input_box==true)
	{ 
		http.open('get', '/ajax/deleteimages/path/' + path + "/obra/" + obra );

		http.onreadystatechange = handleImageDelete; 
		http.send(null);
	} else {
		return false; 
	}
	
	
	
}

function handleImageDelete(){
	
	if(http.readyState == 4){ //Finished loading the response

		var response = http.responseText;
		document.getElementById('thumb_ajax').innerHTML = response;
		
		location.reload(true);
	}
}

function loading(){
	
	$('#loading-animation').fadeIn();
	$('#loading-animation').html('<img src="http://static.fterceiro.pt/assets/public/loading/loading1.gif" /> A carregar dados...');
	
}


function getMedidasCortante(){

	
	$(document).ready(function() {

	       var cortante = $('#cortante').val();
	       
			$.ajax({
				type: 'GET',
				url: '/ajax/medidascortante',
				data: 'id=' + cortante,
				beforeSend: loading(),
				dataType: 'html',
				complete: function(){$('#loading-animation').fadeOut();},
				success: function(response) {
				
				var singleValue = response.split("x");
				var temp = new Array();
				temp = response.split("x");
				var howMany = temp.length;
				
				if (howMany == 4)
					{
					$('#formato-a').val(singleValue[0]);
					$('#formato-b').val(singleValue[1]);
					$('#formato-h').val(singleValue[2]);
					$('#laboratorio').val(singleValue[3]);
					} else {
						$('#laboratorio').val(singleValue[1]);
					}
				
				if ($('#formato-a').val() == 0)
					{
					$('#formato-a').focus();
					
					} else {
						
						if ($('#laboratorio').val() == "Ver dossier")
						{
							$('#laboratorio').val('');
							$('#laboratorio').focus();	
						} else {
							$('#laboratorio').focus();	
						}
					}
				
				
				
				}
			});
			
		});
	
}








