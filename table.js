function alertDelete(){
	var del = confirm("Er du sikker på at du vil slette prøvene?");
	if(del == true){
		alert("Prøvene er slettet");
	}
	return del;
}

function showConfirm(){
	var r = confirm("Brukeren vill bli slettet permanent");
	if(r == true){
		alert("Brukeren er slettet");
	}
	return r;
}

function showConfirmDeleteDB(){
	var r = confirm("Tabellene vil bli slettet, husk å ta kopi i excel før sletting");
	if(r == true){
		alert("Databasen er slettet");
	}
	return r;
}
