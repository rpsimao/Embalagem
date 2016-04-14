$(function() {

    $("#numbraille").focus();


});


function retrieveBrailleTxt()
{

    var brailleNum = $('#numbraille').val();

    if (brailleNum != "") {

        $.ajax({
            type: 'GET',
            url: '/ajax/rettxtbraille',
            data: {'id' : brailleNum},
            error: handleAjaxError,
            dataType: 'json',

            success: function (response) {
                var json = eval(response);

                $('#txtbraille').val(json.txtbraille);
                $('#obs').val(json.obs);

            }
        });
    }

}