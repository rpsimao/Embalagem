function search(){
	var id = $("#codf3").val();
	window.location = "/labs/view/id/" + id;
}

function search1(){
	var id1 = $("#codcliente").val();
	window.location = "/labs/view/cc/" + id1;
	}



function confirm_delete_product(codf3, id) {
input_box=confirm("Tem a certeza que deseja apagar o Código F3 " + codf3 + "?");
if (input_box==true)
 { 
	window.location = "/labs/deleterecord/" + id;
 } else {
	return false; 
 }
}

$(function() {
    $("input:button, input:submit, a", ".novoregisto").button();
	$("a", ".novoregisto").click(function() { window.location="/registos/new"; return false; });
	});