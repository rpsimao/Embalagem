function openR() {
$(function() { 
		
		$( "#dialog-form-remove" ).dialog( "open" );	
		});
}

function closeD() {
	$(function() { 
			
			$( "#dialog-form-remove" ).dialog( "close" );	
			});
	}

	$(function() {
		
		
		var obraRemove = $( "#obra-remove" ),
			
			allFields = $( [] ).add( obraRemove ),
			tips = $( ".validateTips" );

		function updateTips( t ) {
			tips
				.text( t )
				.addClass( "ui-state-highlight" );
			setTimeout(function() {
				tips.removeClass( "ui-state-highlight", 1500 );
			}, 500 );
		}

		function checkLength( o, n, min, max ) {
			if ( o.val().length > max || o.val().length < min ) {
				o.addClass( "ui-state-error" );
				updateTips( "O Nº da Obra tem de conter 5 algarismos." );
				return false;
			} else {
				return true;
			}
		}

		function checkEmpty( o, n, min, max ) {
			if ( o.val().length > max || o.val().length < min ) {
				o.addClass( "ui-state-error" );
				updateTips( "Este campo não pode estar vazio." );
				return false;
			} else {
				return true;
			}
		}

		

		function checkRegexp( o, regexp, n ) {
			if ( !( regexp.test( o.val() ) ) ) {
				o.addClass( "ui-state-error" );
				updateTips( n );
				return false;
			} else {
				return true;
			}
		}

                
		function modalWindow(msg, iconClass, wTitle)
		{

			var $dialog = $('<div></div>')
			.html('<span class="ui-icon ' + iconClass + '" style="float: left; margin: 0 7px 50px 0;"></span>' + msg)
			.dialog({
				autoOpen: true,
				title: wTitle,
				modal: true,
				buttons: {
							Ok: function() {
											$(this).dialog('close');
											$(this).dialog('destroy'); 
											}
						  },
				dialogClass: iconClass,
				draggable: false,
				resizable: false						  	
			});

		}
		
		$( "#dialog-form-remove" ).dialog({
			autoOpen: false,
			height: 280,
			width: 350,
			modal: true,
			position : ['center', 50],
			resizable: false,
			draggable: false,
			buttons: {
				"Remover Cortante": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkLength( obraRemove, "obra-remove", 5, 5 );
					bValid = bValid && checkRegexp( obraRemove, /^[0-9]+$/, "Este campo só pode conter Algarismos" );
					
					

					if ( bValid ) {


						$.ajax({
							type: 'GET',
							url: '/ajax/removecortantefolhaobra',
							data: "j_number=" + obraRemove.val(),
							dataType: 'html',
							success: function(response) {
								var temp = new Array();
								temp = response.split(":");
								var howMany = temp.length;
								if (howMany == 2 ) {
								
								//modalWindow('O Cortante foi inserido com sucesso.', 'ui-icon-circle-check', 'SUCESSO');
								growl('Info','O Cortante foi removido com sucesso.');
							} else {
								$("#dialog-form-remove").dialog( "close" );
								modalWindow('Ocorreu um erro. A obra ainda não existe. Tente de novo.', 'ui-icon-circle-check', 'ERRO');
							}
						  }		
						});
						
						$( this ).dialog( "close" );
} 
				},
				Cancel: function() {
					
					
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
				
				
			}
		});

	});
	
	