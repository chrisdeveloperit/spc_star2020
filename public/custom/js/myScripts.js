function page_direct(route, val){
	//window.location.replace("http://127.0.0.1:8000/contacts/" + val);
	
	window.location.replace("https://star2020.net/star2020/" + route + "/" + val);
}

/*function page_direct(route, sessionVarName, val){
	//window.location.replace("http://127.0.0.1:8000/contacts/" + val);
	window.location.replace("https://star2020.spcstardoc.com/" + route + "/?" + sessionVarName + "=" + val);
}*/



/*Params: id (id of record to be deleted), formName(name of form handling delete), route_name(the path of the action). 3/14/2022
The route_name is needed if delete is done from the index method, but for the show method no route_name should be sent. The
difference is likely due to the index method having no passed id, while the show method DOES have a passed id. At a later point in
development I will look into the reason for this further. I am changing the delete buttons on pages reached via the show method,
to send '' for this param.*/
function handleDelete(id, formName, route_name){
	//console.log('deleting' + id);	
	
	var myForm = document.getElementById(formName);
	
	//alert(formName + ' ' + route_name + id);	
	
	myForm.action = route_name + id;
	$('#deleteModal').modal('show');
}

/*This is a test to show child records in a Modal when the parent link is clicked. Params: id (id of record to be shown), formName(name of form showing the record), route_name(the path of the action)*/
function showMyModal(id, formName, route_name){
	
	var myForm = document.getElementById(formName);
	
	//alert(formName + ' ' + route_name + id);	
	
	//myForm.action = route_name + id;
	$('#subModal').modal('show');
}








