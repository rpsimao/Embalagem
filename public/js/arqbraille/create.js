/**
 * Created by rpsimao on 23/06/14.
 */
function replaceHref(brailleNum){

    var nome = $("#verify").val();

    $("#criar-selo").fadeIn();
    $("#criar-selo").attr("href", "/arqbraille/renderpdf/id/"+brailleNum+"/nome/" + nome);


}

function setNewJob(){


     if (checkIfObraItsBraille() != false){

            var numobra = $("#create-braille-numobra").val();

            var botao1 = '<a id="for-close-the-modal" href="/braille/braillepdf?obra='+numobra+'" class="btn btn-sm btn-primary" target="_blank"><i class="ace-icon fa fa-check"></i> Criar PDF</a>';
            var botao2 = '<a id="for-close-the-modal" href="/braille/braillepdfdownload?obra='+numobra+'" class="btn btn-sm btn-info"><i class="ace-icon fa fa-download"></i> Download PDF</a>'

            $("#create-braille-submit").html(botao2+botao1);

            $("#msg").fadeIn(function(){

                $("#msg").html('<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="ace-icon fa fa-check"></i>&nbsp;Obra alterada. </div>');

            });

            $("#msg").fadeOut(2500);
            $("#modal-create-braille-obra-error").html("");

}

}




function checkIfObraItsBraille()
{

var exists = $.ajax({

    type: 'GET',
    url: '/ajax/validateJobForBraillePDF',
    data: {'job': $("#create-braille-numobra").val()},
    dataType: 'json',
    error: handleAjaxError,
    async: false
}).responseText;

    var values = $.parseJSON(exists);
    var html ="";


    if(values.optimus == false){

          html+='<p class="text-danger small">* A Obra não existe no Optimus.</p>';
          $("#modal-create-braille-obra-error").html(html);
          return false
    }

    if(values.braille == false){

        html+='<p class="text-danger small">* A Obra não está preparada para Braille.</p>';
        $("#modal-create-braille-obra-error").html(html);
        return false
    }





}




$(function(){
    $("#verify").focus();
    $("#criar-selo").hide();



    $('#create-braille-modal').on('shown.bs.modal', function (e) {


        var braille = $.ajax({
            type: 'GET',
            url: '/ajax/createbraille',
            data: {'id': $("#braille-num-for-pdf").val()},
            dataType: 'json',
            error: handleAjaxError,
            async: false
        }).responseText;


        var values = $.parseJSON(braille);

        $("#create-braille-textarea").text(values.textoOptimus);
        $("#create-braille-numobra").val(values.numobra);
        $("#create-braille-numpecas").text(values.pecas);
        $("#create-braille-texto").text(values.texto);
        $("#create-braille-preco").text(+values.preco);
        $("#create-braille-numlinhas").text(+values.linhas);
        $("#create-braille-imagem").html('<img src="data:image/png;base64,' + values.imagem + '" class="img-thumbnail"/>');

        var botao1 = '<a id="for-close-the-modal" href="/braille/braillepdf/'+values.numobra+'" class="btn btn-sm btn-primary" target="_blank"><i class="ace-icon fa fa-check"></i> Criar PDF</a>';
        var botao2 = '<a id="for-close-the-modal" href="/braille/braillepdfdownload/'+values.numobra+'" class="btn btn-sm btn-info"><i class="ace-icon fa fa-download"></i> Download PDF</a>'

        $("#create-braille-submit").html(botao2+botao1);

        var clientTarget = new ZeroClipboard( $("#target-to-copy"), {
            moviePath: "/assets/zeroclipboard/ZeroClipboard.swf"

        } );

        clientTarget.on("click", function(clientTarget)
        {
                clientTarget.on("complete", function(clientTarget, args) {
                clientTarget.setText( args.text );

                } );
            $('#msg').html('<div class="alert alert-info"><button type="button" class="close" ><i class="ace-icon fa fa-times"></i></button>Texto copiado. </div>');
        } );

    })


    $("#create-braille-textarea").focus(function() {
        var $this = $(this);
        $this.select();

        // Work around Chrome's little problem
        $this.mouseup(function() {
            // Prevent further mouseup intervention
            $this.unbind("mouseup");
            return false;
        });

    });

    $("#for-close-the-modal").on("click", function(){
        $("#create-braille-modal").modal('hide');

    });


    /*Dropzone.autoDiscover = false;

    try {
        var drop = new Dropzone("#braille_dropzone" , {
            //paramName: "file", // The name that will be used to transfer the file
           // maxFilesize: 0.5, // MB

            addRemoveLinks : true,
            dictDefaultMessage :
                '<span class="bigger-150 bolder"><i class="ace-icon fa fa-caret-right red"></i> Drop files</span> to upload <span class="smaller-80 grey">(or click)</span> <br /> <i class="upload-icon ace-icon fa fa-cloud-upload blue fa-3x"></i>'
            ,
            dictResponseError: 'Error while uploading file!',

            //change the previewTemplate to use Bootstrap progress bars
            previewTemplate: "<div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-details\">\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n    <div class=\"dz-size\" data-dz-size></div>\n    <img data-dz-thumbnail />\n  </div>\n  <div class=\"progress progress-small progress-striped active\"><div class=\"progress-bar progress-bar-success\" data-dz-uploadprogress></div></div>\n  <div class=\"dz-success-mark\"><span></span></div>\n  <div class=\"dz-error-mark\"><span></span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n</div>"
        });
    } catch(e) {
        alert('Dropzone.js does not support older browsers!');
    }*/

    Dropzone.options.myAwesomeDropzone = { // The camelized version of the ID of the form element

        // The configuration we've talked about above
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,

        // The setting up of the dropzone
        init: function() {
            var myDropzone = this;

            // First change the button to actually tell Dropzone to process the queue.
            this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
                // Make sure that the form isn't actually being sent.
                e.preventDefault();
                e.stopPropagation();
                myDropzone.processQueue();
            });

            // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
            // of the sending event because uploadMultiple is set to true.
            this.on("sendingmultiple", function() {
                // Gets triggered when the form is actually being sent.
                // Hide the success button or the complete form.
            });
            this.on("successmultiple", function(files, response) {
                // Gets triggered when the files have successfully been sent.
                // Redirect user or notify of success.
            });
            this.on("errormultiple", function(files, response) {
                // Gets triggered when there was an error sending the files.
                // Maybe show form again, and notify user of error
            });
        }

    }


});