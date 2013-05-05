var RespondWin;

/*****************************
 * Ouvre le popup de réponse *
 *****************************/
function SaveObjectDoc(did)
{  
//	Sauve l'objet du document automatiquement au clique d'ajout d'une réponse de façon à ce que l'objet [...]
//	[...] à mettre directement le nouvel objet dans la page d'écriture d'une "réponse" 
	MyForm = document.getElementById('EditMail');
	URL = "/components/EditFile/EditFile.php?Option=SaveObject&did="+did; 
	XML ='';
	
//	Construire l'URL
	string='';
	for( i=0 ; i < MyForm.length ; i++)
	{
		if( MyForm.elements[i].id != '-1' )
		{
			switch( MyForm.elements[i].name )
			{
				case 'did':
					if( MyForm.elements[i].value.length > 0 )
						XML += '&' + MyForm.elements[i].name + '=' + MyForm.elements[i].value;
					break;
				case 'object':
					if( MyForm.elements[i].value.length > 0 )
						XML += '&' + MyForm.elements[i].name + '=' + MyForm.elements[i].value;
					break;
			}
		}
	}
//	appel au serveur
	status_write(wpost(URL,XML));
}


function AddRespond(parentWindow, did)
{
	//on sauvegarde l'objet du document au cas ou l'utilisateur ne l'a pas fait avant
	SaveObjectDoc(did);

	URL = '/components/EditFile/EditFile.php?Option=AddRespond&did='+did+'&parentWindowId='+parentWindow.getId();
	CreateRespondWindow(URL, parentWindow);
}

function UpdateRespond(parentWindow, ddid)
{
	URL = '/components/EditFile/EditFile.php?Option=UpdateRespond&ddid='+ddid+'&parentWindowId='+parentWindow.getId();
	CreateRespondWindow(URL, parentWindow);
}

function CreateRespondWindow(URL, parentWindow)
{
	// Fondre le fond
	parentWindow.setOpacity(0.6);

	if( typeof(RespondWin) != 'object' )
	{
		RespondWin = new Window('RespondId',{className: "bluelighting", closable:false, resizable:false,
			maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
	}
	RespondWin.setZIndex(20);
	RespondWin.setOpacity(1);
	// Appeler la page
	RespondWin.setAjaxContent(URL);
	RespondWin.setTitle('Répondre à un courrier');
	RespondWin.setSize(770,580);
	RespondWin.showCenter();
}

/******************************************
 * Ouvre le popup de gestion de documents *
 ******************************************/
function EditFile(id)
{
	//URL = /components/FrontPage/FrontPage.php?Option=EditFile&id=
	URL = Script +'?Option=EditFile&id='+id;

	//val = prompt('URL',URL);

	if( typeof(EditFileWin) != 'object' )
	{
		EditFileWin = new Window('EditFileWin',{className: "bluelighting", closable:false, resizable:false,
			maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
	}
	EditFileWin.setZIndex(10);
	EditFileWin.setOpacity(1);
	// Appeler la page
	EditFileWin.setAjaxContent(URL);
	EditFileWin.setTitle('Gestion courrier');
	EditFileWin.setSize(850,500);
	EditFileWin.showCenter();
	document.getElementById('overlay_modal').style.display = 'block';
}

/*********************************************/
/* Surligne la réponse pointée dans la liste */
/*********************************************/
function divFocus(ddid, isFocused)
{
	var divResp = document.getElementById('div-response-'+ddid);
	var divDraft= document.getElementById('div-draft-'+ddid);
	if(isFocused)
	{
		if(divResp != null)
		{
			divResp.style.width = "363px";
			divResp.style.border = "solid 2px gray";
		}
		else
		{
			divDraft.style.width = "357px";
		}
	}
	else
	{
		if(divResp != null)
		{
			divResp.style.width = "365px";
			divResp.style.border = "solid 1px gray";
		}
		else
		{
			divDraft.style.width = "359px";
		}
	}
}

function DeleteDraft(ddid)
{
	if(confirm('Voulez-vous vraiment supprimer ce brouillon ?')) {
		URLParams = "&Option=DeleteDraft&Ddid="+ddid;
		URL = "/components/EditFile/EditFile.php";
		wpost(URL, URLParams);

		reloadListResponses();
	}
}
