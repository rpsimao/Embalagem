/**
 * Created by rpsimao on 03/07/14.
 */
function showPDFLink(link){

    var html= '<a href="/braille/braillepdf/'+link+'" class="btn btn-app btn-sm btn-primary no-radius" target="_blank">';
    html+='<i class="ace-icon fa fa-file-pdf-o bigger-180"></i>';
    html+='Criar PDF';
    html+='</a>';

    $("#create-pdf-createbraille").html(html).removeClass("well");


}