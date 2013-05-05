//AJAX
function status_write(txt)
{
	document.getElementById('Status').innerHTML=txt;
}

function getXhr()
{
	var xhr = null; 
	if(window.XMLHttpRequest) // Firefox et autres
		xhr = new XMLHttpRequest();   
	else if(window.ActiveXObject){ // Internet Explorer 
		try {
			xhr = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	else 
	{ 
		status_write("&nbsp;Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
		xhr = false; 
	} 
	return xhr;
}

function ajax_load() //quand ca charge
{ 
	status_write("&nbsp;Chargement en cours ...");
}

function ajax_end(){ // quand ca a fini
	status_write("&nbsp;Chargement termin&eacute;");
}

function wget(get)
{ 
	var xhr_object=getXhr();
	ajax_load();
	xhr_object.open("GET", get, false);
	xhr_object.setRequestHeader("Content-type","text/html ; charset=utf-8");
	xhr_object.send(null);
	ajax_end();
	if(xhr_object.readyState == 4) 
		return (xhr_object.responseText);    
}

function wpost(url, post)
{ 
	var xhr_object=getXhr();
	ajax_load();
	xhr_object.open("POST", url, false);
  xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
	//xhr_object.setRequestHeader("Content-type","text/html ; charset=utf-8");
	xhr_object.send(post);
	ajax_end();
	if(xhr_object.readyState == 4) 
		return (xhr_object.responseText);    
}

