function f3CodValidator() {
var l = $('#codf3').val();
	
	if (l.length > 7) {
		var msg = 'O C�digo F3 n�o pode ter mais de 7 algarismos.';
		alert(msg);
		$('#codf3').css('backgroundColor','#fc7e8a');
		return false;
	}
	
	if (l.length < 5) {
		var msg = 'O C�digo F3 n�o pode ter menos de 5 algarismos.';
		alert(msg);
		$('#codf3').css('backgroundColor','#fc7e8a');
		return false;
	}
	
	if (l.length == 5 || l.length == 6 || l.length == 7) {
		$('#codf3').css('backgroundColor','white');
	}
}




function confirm_delete_record(codf3, id)
{
input_box=confirm("Tem a certeza que deseja apagar o C�digo F3 "+codf3+"?");
if (input_box==true)
{ 
window.location = "/registos/deleterecord/" + id;
} else {
	return false; 
}

}
