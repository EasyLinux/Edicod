//Variables



function Preview(File)
{
	window.open(File, 'Apercu', '');
}

function ChronoQuit()
{
	document.location="/index.php";
}

function DisplayFile(id)
{
	URL = '/components/FrontPage/FrontPage.php?Option=DisplayFile&id='+id;
	if( typeof(DisplayFileWin) != 'object' )
	{
		DisplayFileWin = new Window('DisplayFileWin',{className: "bluelighting", closable:false, resizable:false,
			maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
	}
	DisplayFileWin.setZIndex(10);
	DisplayFileWin.setOpacity(1);
	// Appeler la page
	DisplayFileWin.setAjaxContent(URL);
	DisplayFileWin.setTitle('Gestion courrier (lecture seule)');
	DisplayFileWin.setSize(850,540);
	DisplayFileWin.showCenter();
	document.getElementById('overlay_modal').style.display = 'block';
}

/******************* 
 * Quitte le Popup *
 *******************/
function AbortDocument(objWindow)
{
	if(objWindow != null)
	{

		objWindow.hide();
	}
	else
	{
		win.hide();
	}
	document.getElementById('overlay_modal').style.display = 'none';
}


/********************
 * Bascule d'onglet *
 ********************/
function MyTab(Idx)
{
	for( i=1 ; i<6 ; i++)
	{
		Tab  = 'Tab'  + i;
		TabT = 'TabT' + i;
		if( i == Idx )
		{
			document.getElementById(TabT).className = 'formTabTitleOn';
			document.getElementById(Tab ).className = 'formTabOn';
		}
		else
		{
			document.getElementById(TabT).className = 'formTabTitleOff';
			document.getElementById(Tab ).className = 'formTabOff';
		}
	}
}

