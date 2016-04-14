	function closeD()
	{
	$(function() { 
		
		
		$( "#dialog-form" ).dialog( "destroy" );
	
	
		});
	}

	function catchCod(cod)
	{
	$(function() { 
		
		var valclip = $("#clip" + cod).html();
		$("#cortante").val(valclip);
		$( "#dialog-form" ).dialog( "open" );
	
		});
	}

	function openD()
	{
	$(function() { 
		
		
		$( "#dialog-form" ).dialog( "open" );
		$("#obra").focus();
	
		});
	}
	
	$(function() {
		
		
		var obra = $( "#obra" ),
			cortante = $( "#cortante" ),
			allFields = $( [] ).add( obra ).add( cortante ),
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



		
		
		$( "#dialog-form" ).dialog({
			autoOpen: false,
			height: 280,
			width: 350,
			modal: true,
			position : ['center', 50],
			resizable: false,
			draggable: false,
			buttons: {
				"Inserir Cortante": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkLength( obra, "obra", 5, 5 );
					bValid = bValid && checkRegexp( obra, /^[0-9]+$/, "Este campo só pode conter Algarismos" );
					bValid = bValid && checkEmpty( cortante, "cortante", 1, 20 );
					

					if ( bValid ) {


						$.ajax({
							type: 'GET',
							url: '/ajax/insertcortantefolhaobra',
							data: 'j_ucode2=' + cortante.val() + "&j_number=" + obra.val(),
							dataType: 'html',
							success: function(response) {
								var temp = new Array();
								temp = response.split(":");
								var howMany = temp.length;
								if (howMany == 2 ) {
									
								//modalWindow('O Cortante foi inserido com sucesso.', 'ui-icon-circle-check', 'SUCESSO');
								growl('Info','O Cortante foi inserido com sucesso.');
							} else {
								$("#dialog-form").dialog( "close" );
								modalWindow('Ocorreu um erro. A obra ainda não existe. Tente de novo.', 'ui-icon-circle-check', 'ERRO');
							}
						  },
						  error: function(req, status, error){growlError('ERRO','Ocorreu um erro. O Cortante não foi inserido <br />' + "<b>"+error+"</b>");}
								
						});
					    $( this ).dialog( "close" );
					    } 
				},
				Cancel: function() {
					$( this ).dialog( "close" );
					
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
				
				
			}
		});

	});