$(function() {
    $("input:button, input:submit, a", ".search").button();
    $("a", ".search").click(function() { window.location="/emprova/new"; return false; });
	});


$(function() {
	$("#accordion").accordion({
		collapsible: true,
		active: false
	});
	
});
function search1(){
	var myTextField1 = document.getElementById('data1');
	var myTextField = document.getElementById('lab');
	var lab = myTextField.value;
	var dia = myTextField1.value;
	if (dia != 0 || lab != 0)
	{
	window.location = "/entregas/search/date/" + dia + "/lab/" + lab;
	}
}

function search2(){
	var myTextField1 = document.getElementById('data2');
	var myTextField2 = document.getElementById('data3');
	var dia1 = myTextField1.value;
	var dia2 = myTextField2.value;
	if (dia1 != 0 && dia2 !=0 )
	{
	window.location = "/entregas/search/date1/" + dia1 + "/date2/" + dia2;
	}
}