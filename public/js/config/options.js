/**
 * Created by rpsimao on 08/04/15.
 */





function edit_utilizadores_braille(id){

    var table = $("#table_utilizadores_braille_config").html();
    var user = $("#utilizadores_braille_config-"+id);
    var buttons = $("#buttons_utilizadores_braille_config-"+id);


    user.html('<input type="text" id="user_to_'+id+'" value="'+user.text()+'"/>');
    var button1 = '<button class="btn btn-success btn-xs" id="new-update-utilizadores_braille-'+id+'"><i class="ace-icon fa fa-check"></i></button>';
    var button2 = '<button class="btn btn-danger btn-xs" id="new-cancel-utilizadores_braille-'+id+'"><i class="ace-icon fa fa-ban"></i></button>';
    buttons.html(button1+"&nbsp;"+button2);

    $("#user_to_"+id).select();


    $("#new-cancel-utilizadores_braille-"+id).click(function(){
        $("#table_utilizadores_braille_config").html(table)
    });


    $("#new-update-utilizadores_braille-"+id).click(function(){

        var name = $("#user_to_"+id).val();


        $.ajax({
            type: 'GET',
            url: '/config/ajaxupdatearqbraillelabsnames',
            data: {'id': id , 'name': name},
            dataType: 'text',
            error: handleAjaxError,
            async: false,

            success: function(response){

                $("#table_utilizadores_braille_config").html(table)


            }
        });



    });





}








function add_utilizadores_braille_config(){

    var uuid = generateUUID();

    var input = '<input type="text" id="new_user_utilizadores_braille_config-'+uuid+'"/>'

    var row = '<tr id="'+uuid+'">';
    row+= '<td>';
    row+= '<i class="ace-icon fa fa-user blue"></i>&nbsp;';
    row+= input;
    row+= '</td>';
    row+= '<td>';
    row+= '<button class="btn btn-success btn-xs" onclick="add_to_db_utilizadores_braille(\''+uuid+'\')"><i class="ace-icon fa fa-check"></i></button>';
    row+= '</td>';
    row+= '</tr>';


    $('#table_utilizadores_braille_config tr:last').after(row);
    $("#new_user_utilizadores_braille_config-"+uuid).focus();

}



function add_to_db_utilizadores_braille(uuid){

    var nome = $("#new_user_utilizadores_braille_config-"+uuid).val();



    var response = $.ajax({
        type: 'GET',
        url: '/config/ajaxnewarqbraillelabsnames',
        data: {'name': nome},
        dataType: 'text',
        error: handleAjaxError,
        async: false
    }).responseText;


    var html='';
    html+='<td><i class="ace-icon fa fa-user blue"></i> <span id="utilizadores_braille_config-'+response+'">'+nome+'&nbsp;<i class="ace-icon fa fa-check green"></i></span></td>';
    html+='<td id="buttons_utilizadores_braille_config-'+response+'">';
    html+='<button class="btn btn-primary btn-xs" onclick="edit_utilizadores_braille('+response+')"><i class="ace-icon fa fa-edit"></i></button>&nbsp;';
    html+='<button class="btn btn-danger btn-xs" onclick="delete_utilizadores_braille('+response+')"><i class="ace-icon fa fa-trash-o"></i></button>';
    html+='</td>';

    $("#"+uuid).html(html);

    var oBG = $("#"+uuid).css('backgroundColor');
    $("#"+uuid).fadeOut().css("background-color", "#e7fde5").fadeIn();
    //$("#"+uuid).css("background-color", oBG).fadeIn(1500);


}




function delete_utilizadores_braille(id){

    var msg = '<p class="text-danger"><b>Atenção!</b><br />Vai eleminar o registo. Esta operação é definitiva.</p>';

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
                            url: '/config/ajaxdeletearqbraillelabsnames',
                            data: {'id': +id },
                            dataType: 'text',
                            error: handleAjaxError,
                            async: false
                        });

                        $("#utilizadores_braille_config_tr-"+id).fadeOut();
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



/**
 * Created by rpsimao on 08/04/15.
 */
