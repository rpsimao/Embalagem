function displayImage(id)
{

    var splitId = id.split("-");
    $("#"+id).addClass("click");
    
	$("#"+id).qtip({

	    
	    content: {
			// Set the text to an image HTML string with the correct src URL to the loading image you want to use
			text: '<img src="http://static.fterceiro.pt/assets/public/images/ajax-loader.gif" />',//'<img class="throbber" src="/projects/qtip/images/throbber.gif" alt="Loading..." />',
			ajax: {
				url: "/arqbraille/thumb/" + splitId[0], // Use the rel attribute of each element for the url to load
			},
			title: {
				text: "Embalagem Nº" + splitId[0],//'Wikipedia - ' + $(this).text(), // Give the tooltip a title using each elements text
				button: true
			}
		},
		position: {
			at: 'bottom center', // Position the tooltip above the link
			my: 'top center',
			viewport: $(window), // Keep the tooltip on-screen at all times
			effect: false // Disable positioning animation
		},
		show: {
			event: 'click',
			solo: true // Only show one tooltip at a time
		},
		hide: 'mouseout',
		style: {
			classes: 'qtip-wiki qtip-light qtip-shadow click'
		}
	});

	
}


function displayObraInfo(id)
{
	
	var obraId = id.split("-");

	$("#"+id).qtip({

	    
	    content: {
			// Set the text to an image HTML string with the correct src URL to the loading image you want to use
			text: '<img src="http://static.fterceiro.pt/assets/public/images/ajax-loader.gif" />',//'<img class="throbber" src="/projects/qtip/images/throbber.gif" alt="Loading..." />',
			ajax: {
				url: "/arqbraille/obrainfo/" + obraId[0], // Use the rel attribute of each element for the url to load
			},
			title: {
				text: "Obra Nº" + obraId[0] + " Info",//'Wikipedia - ' + $(this).text(), // Give the tooltip a title using each elements text
				button: true
			}
		},
		position: {
			at: 'bottom center', // Position the tooltip above the link
			my: 'top center',
			viewport: $(window), // Keep the tooltip on-screen at all times
			effect: false // Disable positioning animation
		},
		show: {
			event: 'click',
			solo: true // Only show one tooltip at a time
		},
		hide: 'mouseout',
		style: {
			classes: 'qtip-wiki qtip-light qtip-shadow click'
		}
		
	});


}