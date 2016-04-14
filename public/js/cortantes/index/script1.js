

$(document).ready(function() {

$('#query').bind('keypress', function(e) {
    if(e.keyCode==13){
    	search();
    }
  });
});




$(function() {$("input:button, button").button();});
function alertBox()
{
	
	
	$(function() {
		
		
		var dialog = $('<div></div>')
			.html('<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 50px 0;"></span>Não preencheu correctamente os campos da procura!')
			.dialog({
				autoOpen: false,
				title: '.:ERRO:.',
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

		$('#scr').click(function() {
			dialog.dialog('open');
			
		});
		
	});
	
}
function search(){
	$(function() {
	var myTextField = $('#query');
	var selectField = $('#id');
	var query = myTextField.val();
	var id = selectField.val();
	var delimiter = "";
	


	var split = query.split("x");
	if (split.length > 1)
	{
		var split_array = query.split("x");
		var delimiter = "x";
	}

	var split1 = query.split("*");
	if (split1.length > 1)
	{
		var split_array = query.split("*");
		var delimiter = "*";
	}

	var split2 = query.split("X");
	if (split2.length > 1)
	{
		var split_array = query.split("X");
		var delimiter = "X";
	}
	
	
	

	if (id == 3 && split_array[1] == null)
	{
		growl('Info','Não preencheu correctamente os campos da procura!.');
		return false;
		
	}

	if (id == 4 && split_array[1] == null || id == 4 && split_array[2] == null)
	{
		growl('Info','Não preencheu correctamente os campos da procura!.');
		return false;
		
	}
	
	if (id == "" || query == "")
	{
		growl('Info','Não preencheu correctamente os campos da procura!.');
		return false;
	}
	
	window.location = "/cortantes/search/id/" + id + "/query/" + query + "/delimiter/" + delimiter;

	});
}

