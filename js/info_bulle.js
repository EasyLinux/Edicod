var tt_posX = 0;
var tt_posY = 0;
var tt_yOffset = 15;
var tt_id;

function tt_getEltById(id)
{
	if (document.layers)
		return document.layers[id];
	else if (document.all)
		return document.all[id];
	else if (document.getElementById)
		return document.getElementById(id);
		
	return null;
}

function tt_over1(msg,classe,duree)
{
	var c = (typeof classe=='undefined' ? 'tt_default' : classe);
	var d = (typeof duree=='undefined' ? 0 : duree);
	tt_id = setTimeout('tt_show("'+msg+'","'+c+'")',d);
}

function tt_over2(msg,duree)
{
	var d = (typeof duree=='undefined' ? 0 : duree);
	tt_id = setTimeout('tt_show("'+msg+'","tt_default")',d);
}

function tt_out()
{
	clearTimeout(tt_id);
	tt_hide();
}
/*
function tt_tooltip1(message,tooltip,classe,duree)
{
	document.write("<span onmouseover=\"tt_over1('" + tooltip + "','" + classe + "'," + duree + ")\" onmouseout='tt_out()'>" + message + "</span>");
}
	*/
function tt_show(texte,classe)
{
	var contenu = texte;
  var finalPosX = tt_posX;
  if (finalPosX<0) finalPosX=0;
  
  tt_getEltById("bulle").className = 'tt_abs ' + (typeof classe == 'undefined' ? 'tt_default' : classe);
  
  if (document.layers)
  {
    tt_getEltById("bulle").document.write(contenu);
   	tt_getEltById("bulle").document.close();
    tt_getEltById("bulle").top = tt_posY + tt_yOffset+"px";
    tt_getEltById("bulle").left= finalPosX+"px";
    tt_getEltById("bulle").visibility="show";
    //alert("1 - X="+finalPosX+" Y="+tt_posY);
  }
  else
  {
   	tt_getEltById("bulle").innerHTML = contenu;
   	//tt_getEltById("bulle").style.margin = tt_posY+"px 0 0 "+finalPosX+"px";
    tt_getEltById("bulle").style.top = tt_posY + tt_yOffset+"px";
    tt_getEltById("bulle").style.left= finalPosX+"px";
    tt_getEltById("bulle").style.visibility="visible";
    //alert("2 - X="+finalPosX+" Y="+tt_posY);
  }
}

/* //Fonctionnel !
function tt_show(texte,classe)
{
	var contenu = texte;
	var finalPosX = tt_posX;
	if (finalPosX<0) finalPosX=0;

	tt_getEltById("bulle").className = 'tt_abs ' + (typeof classe == 'undefined' ? 'tt_default' : classe);

	if (document.layers) {
		tt_getEltById("bulle").document.write(contenu);
		tt_getEltById("bulle").document.close();
		tt_getEltById("bulle").top = tt_posY + tt_yOffset +"px";
		tt_getEltById("bulle").left= finalPosX + "px";
		tt_getEltById("bulle").visibility="show";
	}
	else {
		tt_getEltById("bulle").innerHTML = contenu;
		tt_getEltById("bulle").style.top = tt_posY + tt_yOffset +"px";
		tt_getEltById("bulle").style.left = finalPosX + "px";
		tt_getEltById("bulle").style.visibility="visible";
	}
}*/

function tt_getMousePos(e)
{
 	tt_posX = (document.all ? event.x + document.body.scrollLeft : e.pageX);
 	tt_posY = (document.all ? event.y + document.body.scrollTop : e.pageY);
}

function tt_hide()
{
	if (document.layers)
		tt_getEltById("bulle").visibility="hide";
	else
		tt_getEltById("bulle").style.visibility="hidden";
}

function tt_init(classe)
{
	if (document.layers)
	{
		window.captureEvents(Event.MOUSEMOVE);
		window.onmousemove=tt_getMousePos;
		document.write("<layer name='bulle' class='tt_abs' style='visibility:hide'></layer>");
	}
	else if (document.all || document.getElementById)
	{
		document.write("<div id='bulle' class='tt_abs' style='visibility:hidden'></div>");
		document.onmousemove=tt_getMousePos;
	}
}

tt_init();