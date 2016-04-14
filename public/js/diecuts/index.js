/**
 * Created by rpsimao on 12/06/15.
 */

$(function(){

    $("#cortante").focus();

    $("#create_new_diecut").click(function(){

        var newDiecut = $.ajax({
            type: 'GET',
            url: '/diecuts/new',
            dataType: 'html',
            error: handleAjaxError,
            async: false
        }).responseText;


        $("#diecut_top_search").slideUp();
        $("#diecut_search_thumbnail").fadeIn();
        $("#diecuts_results").html(newDiecut);
        $("#estante").focus();

    });

    $("#diecut_topsearch_display").click(function(){

        $("#diecut_top_search").slideDown();
        $("#diecut_search_thumbnail").hide();
        $("#cortante").focus();
    });


    $("#procurarCortante").click(

        function(){



            if(!$("input:radio[name ='opcoes']").is(':checked')){
                $('#opcoes1').attr('checked',true);
            }

            var diecut = $("#cortante");
            var dieoptions = $("input:radio[name ='opcoes']:checked");


            var query = diecut.val();
            var id = dieoptions.val();
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
                displayFormError('diecuts_form_errors','Não preencheu correctamente os campos da procura!.');
                return false;

            }

            if (id == 4 && split_array[1] == null || id == 4 && split_array[2] == null)
            {
                displayFormError('diecuts_form_errors','Não preencheu correctamente os campos da procura!.');
                return false;

            }

            if ( dieoptions.val() == null || query == "")
            {
                displayFormError('diecuts_form_errors','Não preencheu correctamente os campos da procura!.');
                return false;
            }

               var tableDiecut = $.ajax({
                   type: 'GET',
                   url: '/diecuts/search',
                   data: {'id': dieoptions.val(), 'query': diecut.val(), 'delimiter': delimiter},
                   dataType: 'html',
                   error: handleAjaxError,
                   async: false
               }).responseText;


                $('#opcoes1').attr('checked',false);

                $("#diecuts_results").html(tableDiecut);
                $("#diecuts_form_errors").hide();
                $("input:radio[name ='opcoes']").prop('checked', false);
                diecut.val("");


                $("#diecut_top_search").slideUp();
                $("#diecut_search_thumbnail").fadeIn();



        }
    );
});

function displayFormError(id, msg)
{

    $("#"+id).show();
    $("#"+id).html('<div class="help-block col-xs-12 col-sm-reset inline" style="margin-left: 5px;"> <span class="label label-danger arrowed-in">'+msg+'</span> </div>');

}


function dismissDiecutForm(){


    $("#diecuts_results").html("");
    $("#diecut_top_search").slideDown();
    $("#diecut_search_thumbnail").hide();
    $("#cortante").focus();



}


function slideMeUp(id){
    $("#detail-view-"+id).slideUp();
    $('#diecut-'+id).removeClass('highlight_diecut');
    $("#diecut-edit-"+id).html('<i class="ace-icon fa fa-edit bigger-120" style="cursor: pointer;" onclick="populateDiecut(\''+id+'\', \'diecut-'+id+'\')"></i>');


}


function populateDiecut(id, tr){

    var table = $.ajax({
        type:     'GET',
        url:      '/diecuts/getcortanteforview',
        data:     {'id': id},
        error: handleAjaxError,
       // beforeSend: loading(),
        async: false,
        dataType: 'html'}).responseText;


    $("#"+tr).after(table).slideDown();
    $("#"+tr).addClass('highlight_diecut');


    var newHtml = '<i class="fa fa-spinner fa-spin bigger-110"></i>  A editar...';


    $("#diecut-edit-"+id).html(newHtml);


}


 function addDiecutToOptimus(id, diecut){

     var div = $("#diecutsToOptimus-"+id);

     bootbox.prompt({

         locale: "br",
         title: "Insira o Número da Obra:",
         callback: function (result) {


             if (result !== null) {

                 $.ajax({
                     type: 'GET',
                     url: '/diecuts/insertcortantefolhaobra',
                     data: {'j_ucode2': diecut, "j_number": result, "id": id},
                     dataType: 'html',
                     error: handleAjaxError,
                     success: function (response) {
                         var temp = response.split(":");
                         var howMany = temp.length;
                         if (howMany == 2) {

                             div.html('<span class="label label-success arrowed pull-right"><i class="ace-icon fa fa-check"></i> Cortante inserido no Otimus</span>');
                         } else {
                             div.html('<span class="label label-danger arrowed pull-right"><i class="ace-icon fa fa-times"></i> Erro a inserir no Optimus</span>');
                         }
                     }

                 });

             }
          }
     });
}


function removeDiecutFormOptimus(id){

    var div = $("#diecutsToOptimus-"+id);

    bootbox.prompt({

        locale: "br",
        title: "Insira o Número da Obra:",
        callback: function (result) {


            if (result !== null) {

                $.ajax({
                    type: 'GET',
                    url: '/diecuts/removecortantefolhaobra',
                    data: {"j_number": result},
                    dataType: 'html',
                    error: handleAjaxError,
                    success: function (response) {
                        var temp = response.split(":");
                        var howMany = temp.length;
                        if (howMany == 2) {
                            div.html('<span class="label label-info arrowed pull-right"><i class="ace-icon fa fa-check"></i> Cortante removido no Otimus</span>');
                        } else {
                            div.html('<span class="label label-danger arrowed pull-right"><i class="ace-icon fa fa-times"></i> Erro a remover no Optimus</span>');
                        }
                    }

                });

            }
        }
    });
}

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