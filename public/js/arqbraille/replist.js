/**
 * Created by rpsimao on 02/07/14.
 */

$(function(){

    var rowCount = $('#arqbraille-rep-pecas-tb tr').length;
    var i = 1;

    $('#id-pills-stacked').removeAttr('checked').on('click', function(){
        $("#arqbraille-rep-th").toggle();

        for( i = 1; i <= rowCount; i++){
            $("#arqbraille-rep-td-"+i).toggle();
        }

    });

});



function arqbrailleEdit(id, tr)
{
    var a1 = $("#arqbraille-rep-pecas-id-"+id);
    var a2 = $("#arqbraille-rep-pecas-dt-"+id);
    var a3 = $("#arqbraille-rep-pecas-ox-"+id);
    var a4 = $("#arqbraille-rep-pecas-pt-"+id);
    var a5 = $("#arqbraille-rep-pecas-em-"+id);
    var a6 = $("#arqbraille-rep-pecas-cn-"+id);

    var td1 = $("#arqbraille-rep-td-"+tr);



    a1.html('<input type="text" class="col-xs-5 input-sm" id="n-a1" value="'+a1.text()+'" />');
    a2.html('<input type="text" id="n-a2" value="'+a2.text()+'" />');
    a3.html('<input type="hidden" name="n-a3" value="0" /><input type="checkbox" name="n-a3" id="n-a3" value="1" '+checkIfChecked(a3)+'" />');
    a4.html('<input type="hidden" name="n-a4" value="0" /><input type="checkbox" name="n-a4" id="n-a4" value="1" '+checkIfChecked(a4)+'" />');
    a5.html('<input type="hidden" name="n-a5" value="0" /><input type="checkbox" name="n-a5" id="n-a5" value="1" '+checkIfChecked(a5)+'" />');
    a6.html('<input type="hidden" name="n-a6" value="0" /><input type="checkbox" name="n-a6" id="n-a6" value="1" '+checkIfChecked(a6)+'" />');

    td1.html('<button onclick="arqbrailleRepPecasInsert('+id+')" class="btn btn-xs btn-success btn-white"><i class="ace-icon fa fa-check bigger-120"></i></button>');



}

/**
 *
 * @param id
 */

function arqbrailleRepPecasInsert(id){




    var a3 = ($('#n-a3').is(':checked')) ? 1 : 0;
    var a4 = ($('#n-a4').is(':checked')) ? 1 : 0;
    var a5 = ($('#n-a5').is(':checked')) ? 1 : 0;
    var a6 = ($('#n-a6').is(':checked')) ? 1 : 0;


    $.ajax({
        type: 'GET',
        url: '/ajax/updatearqbraillereppecas',
        data: {"id" : id, "a1" : $("#n-a1").val(), "a2" : $("#n-a2").val(), "a3" : a3, "a4" : a4, "a5" : a5, "a6" : a6 },
        error: handleAjaxError,
        dataType: 'text',

        success: function(response) {

            if(response == 1){

                jQuery.gritter.add({
                    title: 'Peças Braille',
                    text: 'Dados alterados com sucesso.',
                    image: '/imagens/success.png',
                    sticky: false,
                    time: 1000,
                    class_name: 'gritter-success gritter-light'
                });

                loadRepertions();

            } else {

                jQuery.gritter.add({
                    title: 'Erro',
                    text: response,
                    image: '/imagens/error.png',
                    sticky: true,
                    class_name: 'gritter-error gritter-light'
                });
            }

        }
    });

}

function arqbrailleTrash(id)
{

    $.ajax({
        type: 'GET',
        url: '/ajax/removearqbraillereppecas',
        data: {"id" : id },
        error: handleAjaxError,
        dataType: 'text',

        success: function(response) {

            if(response == 1){

                jQuery.gritter.add({
                    title: 'Peças Braille',
                    text: 'Dados removidos com sucesso.',
                    image: '/imagens/success.png',
                    sticky: false,
                    time: 1000,
                    class_name: 'gritter-success gritter-light'
                });

                loadRepertions();

            } else {

                jQuery.gritter.add({
                    title: 'Erro',
                    text: response,
                    image: '/imagens/error.png',
                    sticky: true,
                    class_name: 'gritter-error gritter-light'
                });
            }

        }
    });


}

function checkIfChecked(id)
{

    if(id.text() == "X"){
        return 'checked="checked"';
    }


}


