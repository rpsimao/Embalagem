/**
 * Created by rpsimao on 19/06/15.
 */



function deleteArqChapasRecord(id){


        var html = '<div class="text-danger" style="padding-bottom: 30px;padding-top: 10px;"><i class="ace-icon fa fa-exclamation-triangle bigger-120"></i>&nbsp;Tem a certeza que quer apagar o registo?</div>';


        bootbox.confirm(html, function(result) {
            if(result) {
                window.location.replace("/arquivochapas/deleterecord?id="+id);
            }

        });

}

