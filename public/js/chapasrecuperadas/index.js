/**
 * Created by rpsimao on 19/06/15.
 */
$(function(){
    $("#obra").focus();

        $('#chapasrecuperadas_search_form').ajaxForm({
            target : '#chapas_recuperadas_filtro',
            clearForm: true,
            resetForm: true
        });
});


function searchClient(client)
{
    $.ajax({
        type: 'GET',
        url: '/ajax/chapasrecuperadascliente',
        data: {'cli' : client},
        dataType: 'json',

        success: function(response) {

            var json = eval(response);
            var total = parseInt(json[0].verniz)+parseInt(json[0].cores);


            var html = '<h3 class="row header smaller lighter blue"><i class="ace-icon fa fa-bar-chart-o"></i> Chapas Recuperadas '+ client +'</h3>';
            html+= '<table class="table table-bordered table-striped table-hover table-condensed table-responsive" id="the-table-producao">';
            html+='<thead>'
            html+='<tr>'
            html+= '<th>Chapas Verniz</th>';
            html+= '<th> Chapas Cores </th>';
            html+= '<th> Total</th>';
            html+= '</tr>';
            html+= '</thead>';
            html+= '<tbody>';
            html+= '<tr>';
            html+= '<td>'+json[0].verniz+'</td>';
            html+= '<td>'+json[0].cores+'</td>';
            html+= '<td>'+total+'</td>';
            html+= '</tr>';
            html+= '</tbody>';
            html+= '</table>';

            $('#chapas_recuperadas_filtro').html(html);

        }});



}

function handleAjaxError(jqXHR, textStatus, errorThrown) {


    var errorCode   = "Error Code: " + jqXHR.status;
    var errorStatus = "Status: " + textStatus;
    var errorTxt    = "Error Type: " + errorThrown;
    var errorMsg    = jqXHR.responseText;
    var openModalWithError = '<button id="display-modal-ajax-error" type="button" class="btn btn-white btn-danger btn-xs"><i class="fa fa-terminal"></i> Mostrar erro</button>';


    jQuery.gritter.add({
        title: '<i class="fa fa-exclamation-triangle"></i> Erro',
        text: "<p>"+errorCode+"</p><p>"+errorStatus+"</p><p>"+errorTxt+"</p><br>"+'<p style="text-align: right;">'+openModalWithError+"</p>",
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


function showRequest(formData, jqForm, options) {
    // formData is an array; here we use $.param to convert it to a string to display it
    // but the form plugin does this for you automatically when it submits the data
    var queryString = $.param(formData);

    // jqForm is a jQuery object encapsulating the form element.  To access the
    // DOM element for the form do this:
    // var formElement = jqForm[0];

    //alert('About to submit: \n\n' + queryString);

    // here we could return false to prevent the form from being submitted;
    // returning anything other than false will allow the form submit to continue
    return true;
}

// post-submit callback
function showResponse(responseText, statusText, xhr, $form)  {
    // for normal html responses, the first argument to the success callback
    // is the XMLHttpRequest object's responseText property

    // if the ajaxSubmit method was passed an Options Object with the dataType
    // property set to 'xml' then the first argument to the success callback
    // is the XMLHttpRequest object's responseXML property

    // if the ajaxSubmit method was passed an Options Object with the dataType
    // property set to 'json' then the first argument to the success callback
    // is the json data object returned by the server

    //alert('status: ' + statusText + '\n\nresponseText: \n' + responseText + '\n\nThe output div should have already been updated with the responseText.');



    //return responseText;
}

function delete_chapa_recuperada(id)
{

    var txt ='<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Tem a certeza?</span>';


    bootbox.confirm(txt, function(result) {
        if(result) {

            $.ajax({
                type: 'GET',
                url: '/chapasrecuperadas/delete',
                data: {'obra' : id},
                dataType: 'html',

                success: function() {

                 var html='<div class="row">';
                    html+='<div class="col-sm-6">';
                    html+=' <div id="diecuts_msg-flash" class="alert alert-block alert-success">';
                    html+=' <button type="button" class="close" data-dismiss="alert">';
                    html+='  <i class="ace-icon fa fa-times"></i>';
                    html+=' </button>';
                    html+='  <p>';
                    html+='  <strong><i class="ace-icon fa fa-check"></i></strong>';
                    html+='&nbsp;Registo apagado sucesso.';
                    html+='  </p>';
                    html+=' </div>';
                    html+=' </div>';
                    html+=' </div>';

                  $("#chapas_recuperadas_flash").html(html);
                  $("#chapas_recuperadas_filtro").html('');

                }});


        }
    });


}