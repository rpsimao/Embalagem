$(function(){
	
/**$('#Arq-Brailles-Search-By-Lab-Div').hide();*/

$("#arq-braille-search-nav-button").button();

/**$("#arq-braille-search-nav-button").click(function() {

	$('#Arq-Brailles-Search-By-Lab-Div').toggle('blind');
});*/

$("input:button, input:submit, a", ".sessao2").button();
$("input:button, input:submit, a", ".sessao3").button();
$("input:button, input:submit, a", ".sessao4").button();
$("a", ".sessao2").click(function() { window.location="/arqbraille/labs"; return false; });
$("a", ".sessao3").click(function() { window.location="/arqbraille/selo"; return false; });
	
});


function validateInput(field)
{

    $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
        _title: function(title) {
            var $title = this.options.title || '&nbsp;';

            if( ("title_html" in this.options) && this.options.title_html == true ) {
                title.html($title);
            } else { title.text($title);
        }
    }
        }
    ));
	
var inputField = $("#"+field).val();


	if (inputField.length == 0)
		{

           var dialog = $( "#dialog-message" ).removeClass('hide').dialog({
                modal: true,
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> Campo de procura vazio</h4></div>",
                title_html: true,
                position: ["center", 40 ],
                buttons: [
                    {
                        text: "OK",
                        "class" : "btn btn-primary btn-xs",
                        click: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                ]
            });



		/*var dialog = $('<div></div>')
		.html('<p class="errors">Tem de inserir um valor para a procura!</p>')
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
			dialogClass: 'ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable ui-resizable',
			height: 180,
			width: 250
		
		});*/
		
		return false;
		}


}