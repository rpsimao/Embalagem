

function addNotice(notice) { 
	$('<div class="notice"></div>')
	.append('<div class="skin"></div>') 
	.append('<a href="#" class="close">close</a>') 
	.append($('<div class="content"></div>').html($(notice))).hide() 
	.appendTo('#growl') 
	.fadeIn(1000);
	}

$('#growl') .find('.close') .live('click', function() {
	$(this)
	.closest('.notice') .animate({
	border: 'none', height: 0, marginBottom: 0, marginTop: '-6px', opacity: 0, paddingBottom: 0, paddingTop: 0, queue: false
	}, 1000, function() { $(this).remove();
	});
	});


function growl(title, text){
					var notice = '<div class="notice">'
							  + '<div class="notice-body">' 
								  + '<img src="/images/infog.png" alt="" />'
								  + '<h3>'+ title +'</h3>'
								  + '<p>'+ text +'</p>'
							  + '</div>'
							  + '<div class="notice-bottom">'
							  + '</div>'
						  + '</div>';
						  
					$( notice ).purr(
						{
							usingTransparentPNG: true
						}
					);
					
}

function growlError(title, text){
	var notice = '<div class="notice">'
			  + '<div class="notice-body">' 
				  + '<img src="/images/error.png" alt="" />'
				  + '<h3>'+ title +'</h3>'
				  + '<p>'+ text +'</p>'
			  + '</div>'
			  + '<div class="notice-bottom">'
			  + '</div>'
		  + '</div>';
		  
	$( notice ).purr(
		{
			usingTransparentPNG: true
		}
	);
	
}	






function closeboxToggle(id)
{
	$("#"+id).slideToggle();

}

function closeboxFadeOut(id)
{
	$("#"+id).fadeOut();

}

( function( $ ) {
	
	$.purr = function ( notice, options )
	{ 

		notice = $( notice );
		

		if ( !options.isSticky )
		{
			notice.addClass( 'not-sticky' );
		};
		

		var cont = document.getElementById( 'purr-container' );
		

		if ( !cont )
		{
			cont = '<div id="purr-container"></div>';
		}
		

		cont = $( cont );
		

		$( 'body' ).append( cont );
			
		notify();

		function notify ()
		{	

			var close = document.createElement( 'a' );
			$( close ).attr(	
				{
					className: 'close',
					href: '#close',
					innerHTML: 'Close'
				}
			)
				.appendTo( notice )
					.click( function ()
						{
							removeNotice();
							
							return false;
						}
					);
			

			notice.appendTo( cont )
				.hide();
				
			if ( jQuery.browser.msie && options.usingTransparentPNG )
			{

				notice.show();
			}
			else
			{

				notice.fadeIn( options.fadeInSpeed );
			}
			

			if ( !options.isSticky )
			{
				var topSpotInt = setInterval( function ()
				{

					if ( notice.prevAll( '.not-sticky' ).length == 0 )
					{ 

						clearInterval( topSpotInt );
						

						setTimeout( function ()
							{
								removeNotice();
							}, options.removeTimer
						);
					}
				}, 200 );	
			}
		}

		function removeNotice ()
		{

			if ( jQuery.browser.msie && options.usingTransparentPNG )
			{
				notice.css( { opacity: 0	} )
					.animate( 
						{ 
							height: '0px' 
						}, 
						{ 
							duration: options.fadeOutSpeed, 
							complete:  function ()
								{
									notice.remove();
								} 
							} 
					);
			}
			else
			{

				notice.animate( 
					{ 
						opacity: '0'
					}, 
					{ 
						duration: options.fadeOutSpeed, 
						complete: function () 
							{
								notice.animate(
									{
										height: '0px'
									},
									{
										duration: options.fadeOutSpeed,
										complete: function ()
											{
												notice.remove();
											}
									}
								);
							}
					} 
				);
			}
		};
	};
	
	$.fn.purr = function ( options )
	{
		options = options || {};
		options.fadeInSpeed = options.fadeInSpeed || 500;
		options.fadeOutSpeed = options.fadeOutSpeed || 500;
		options.removeTimer = options.removeTimer || 4000;
		options.isSticky = options.isSticky || false;
		options.usingTransparentPNG = options.usingTransparentPNG || false;
		
		this.each( function() 
			{
				new $.purr( this, options );
			}
		);
		
		return this;
	};
})( jQuery );
/*
Handle ajax errors
 */

function handleAjaxError(jqXHR, textStatus, errorThrown) {


    var errorCode   = "Error Code: " + jqXHR.status;

    var errorTxt    = "Error Type: " + errorThrown;
    var errorMsg    = jqXHR.responseText;
    var openModalWithError = '<button id="display-modal-ajax-error" type="button" class="btn btn-white btn-danger btn-xs"><i class="fa fa-terminal"></i> Mostrar erro</button>';

    jQuery.gritter.add({
        title: '<i class="fa fa-exclamation-triangle"></i> Erro',
        text: "<p>"+errorCode+"</p>"+"<p>"+errorTxt+"</p><br>"+'<p style="text-align: right;">'+openModalWithError+"</p>",
        sticky: true,

        class_name: 'gritter-error'
    });


    $("#display-modal-ajax-error").on('click', function() {
        bootbox.dialog({
           title: '<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Descrição do Erro</span>',
            message: errorMsg,
            buttons: {
                  cancel: {
                    label: "Fechar",
                    className: "btn-sm"
                }
            }
        });
    });
}

function numbersOnly(params)
{
    for(i=0;i<params.length;i++)
    {

        $("#"+params[i]).keydown(function(event) {

            if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||

                (event.keyCode == 65 && event.ctrlKey === true) ||

                (event.keyCode >= 35 && event.keyCode <= 39)) {

                return;
            } else {

                if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                    event.preventDefault();
                };
            };
        });
    };
}
function generateUUID() {
    var d = new Date().getTime();
    var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = (d + Math.random()*16)%16 | 0;
        d = Math.floor(d/16);
        return (c=='x' ? r : (r&0x3|0x8)).toString(16);
    });
    return uuid;
};