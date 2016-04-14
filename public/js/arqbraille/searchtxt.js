/**
 * Created by rpsimao on 19/06/14.
 */

function displayImageArqBrailleTXT(id)
{

    $("#"+id).addClass("click");

    $("#"+id).qtip({


        content: {
            text: "Loading",
            ajax: {
                url: "/arqbraille/thumbtxt/" + id,
            },
            title: {
                text: "Embalagem Preview",
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


};
