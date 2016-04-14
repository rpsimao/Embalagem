/**
 * Created by rpsimao on 19/06/14.
 */
$(function() {

   $("#optimus").focus();

});


function editArqbrailleLabs(id, lab){


    var select = $.ajax({

        type: 'GET',
        url: '/ajax/getcustomersforarqbrailleslabsindex',
        data: {'id': "select-ArqbrailleLabs-"+id, 'lab':lab},
        dataType: 'html',
        error: handleAjaxError,
        async: false
    }).responseText;


    var td1 = $("#lab-"+id);
    var td2 = $("#short-"+id);
    var td3 = $("#but-"+id);
    var table  = $("#arqbraille-labs-table").html();

    $("#arqbraille-labs-aux").html(td3.html());

    var short = '<input type="text" class="input-mini" value='+td2.text()+' id="newshort-'+id+'"/>';

    var buttons = '<div class="hidden-sm hidden-xs btn-group">';
    buttons+='<button class="btn btn-xs btn-success" onclick="updateArqBrailleLabs('+id+')"> <i class="ace-icon fa fa-check bigger-120"></i> </button>';
    buttons+='<button id="new-cancel-'+id+'" class="btn btn-xs btn-danger"> <i class="ace-icon fa fa-times bigger-120"></i> </button> </div> <div class="hidden-md hidden-lg"> <div class="inline pos-rel"> <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto"> <i class="ace-icon fa fa-cog icon-only bigger-110"></i> </button>';
    buttons+='<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close"> <li> <a href="#" class="tooltip-success" data-rel="tooltip" title="" data-original-title="OK"> <span class="green"> <i class="ace-icon fa fa-check bigger-120"></i> </span> </a> </li>';
    buttons+='<li> <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Cancel"> <span class="red"> <i class="ace-icon fa fa-times bigger-120"></i> </span> </a> </li> </ul> </div> </div>';


    td1.html(select);
    td2.html(short);
    td3.html(buttons);


    $("#new-cancel-"+id).click(function(){
        $("#arqbraille-labs-table").html(table)
    });


}

function deleteArqBrailleLabs(id){


    var row = $.ajax({

        type: 'GET',
        url: '/ajax/refreshcustomersforarqbrailleslabsindex',
        data: {'id': id},
        dataType: 'json',
        error: handleAjaxError,
        async: false
    }).responseText;

    var values = $.parseJSON(row);

    var msg = '<p class="text-danger"><b>Atenção!</b><br />Vai eleminar o registo. Esta operação é definitiva.</p>';
    msg+='<br /><p><i class="ice-icon fa fa-check-square blue"></i> Nome OPTIMUS: <b>' + values.optimus +'</b></p>';
    msg+='<p><i class="ice-icon fa fa-check-square blue"></i> Abreviatura: <b>' + values.shortname +'</b></p>';


    bootbox.dialog({
        message: msg,
        title: '<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Alerta</span>',
        buttons: {
            success: {
                label: '<i class="ace-icon fa fa-exclamation-circle"></i> OK',
                className: "btn-danger",
                callback: function(result) {
                    if (result !== null) {

                        $.ajax({

                            type: 'GET',
                            url: '/ajax/deletearqbraillelabs',
                            data: {'id': +id },
                            dataType: 'text',
                            error: handleAjaxError,
                            async: false
                        });

                        $("#"+id).fadeOut();
                    }
                }

            },
            cancel: {
                label: "Cancel",
                className: "btn"
            }
        }
    });
}


function updateArqBrailleLabs(id){


    var value1 =  $("#select-ArqbrailleLabs-"+id).val();
    var value2 =  $("#newshort-"+id).val();

    $.ajax({

        type: 'GET',
        url: '/ajax/updatearqbraillelabs',
        data: {'id': id, 'optimus':value1, 'shortname':value2},
        dataType: 'html',
        error: handleAjaxError,
        async: false,

        success: function() {

            var row = $.ajax({

                type: 'GET',
                url: '/ajax/refreshcustomersforarqbrailleslabsindex',
                data: {'id': id},
                dataType: 'json',
                error: handleAjaxError,
                async: false
            }).responseText;

            var values = $.parseJSON(row);

            $("#lab-"+id).html(values.optimus + ' <i class="ace-icon fa fa-check green"></i>');
            $("#short-"+id).html(values.shortname + ' <i class="ace-icon fa fa-check green"></i>');
            $("#but-"+id).html($("#arqbraille-labs-aux").html());


        }
    })


}
