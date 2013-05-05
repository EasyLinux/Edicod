//Contact.js
ContactScript = "/components/Contact/Contact.php";

/* Enregistre un nouveau contact */
function SaveContact()
{  // Sauve données
	MyForm = document.getElementById('EditContact');

	if(		document.getElementById('name').value=="" ||
			document.getElementById('given_name').value=="" ||
			document.getElementById('address1').value=="" ||
			document.getElementById('zip').value=="" ||
			document.getElementById('city').value==""
	) {
		alert("Certains champs sont vides. Vous devez saisir tous les champs obligatoires. \n(Champs obligatoires: Nom, Prénom, Adresse, CP, Ville");
	}
	else {
		MyForm = document.getElementById('EditContact');
		URL = ContactScript+'?Option=Save'; 
		
//		Construire l'URL
		string='';
		for( i=0 ; i < MyForm.length ; i++)
		{ // Parcourir tous les champs
			if( MyForm.elements[i].conid != '-1' )
			{
				//alert(MyForm.elements[i].name + '=' +MyForm.elements[i].type);
				switch( MyForm.elements[i].name )
				{
				/*      // Champs à ne pas transférer
        break;
				 */
				case 'conid':
				case 'company':
				case 'name':
				case 'given_name':
				case 'email':
				case 'phone':
				case 'address1':
				case 'address2':
				case 'zip':
				case 'city':
					if( MyForm.elements[i].value.length > 0 )
						URL += '&' + MyForm.elements[i].name + '=' + urlencode(htmlentities(MyForm.elements[i].value));
					break;
				case 'genre':
					if( MyForm.elements[i].checked )
						URL += '&' + MyForm.elements[i].name + '=' + MyForm.elements[i].value;
					break;

				default:
					alert(MyForm.elements[i].name);
				break;
				}
			}
		} // for i
//		appel au serveur

		status_write(wget(URL));
//		Cacher le popup et recharger les données
		document.getElementById('overlay_modal').style.display = 'none';
		win.hide();

		//document.location.reload();

		if( typeof(Contacts) != 'object' )
			document.location.reload();
		else 
		  {
			//on met à jour automatiquement les cases correspondantes
			//AbortContact();
			document.getElementById('overlay_modal').style.display = 'block';
			DisplayContacts(EditFileWin, 'conid', 'Sender');
		  }
	}
}

/* Ouvre la fenêtre d'ajout d'un contact */
function Add()
{  // Affiche le popup et met id=-1
	URL = ContactScript+'?Option=EditContact&conid=-1';
	win.setAjaxContent(URL);
	win.setTitle('Ajouter un contact');
	win.setSize(420,330);
	win.showCenter();
	// Fondre le fond
	document.getElementById('overlay_modal').style.display = 'block';
	return false;
}

/* Ouvre la fenêtre d'ajout d'un contact */
function AddContact()
{  // Affiche le popup et met id=-1
	URL = ContactScript+'?Option=EditContact&conid=-1';
	win.setAjaxContent(URL);
	win.setTitle('Ajouter un contact');
	win.setSize(420,330);
	win.showCenter();
	// Fondre le fond
	document.getElementById('overlay_modal').style.display = 'block';
	return false;
}

function Lock()
{ // Valide / invalide un utilisateur
	conid = GetActive();
//	A partir de l'URL retrouver le composant appelé
	URL  = ContactScript; 
	if( conid != 0 )
	{
		URL += 'Option=Lock&conid='+conid;
		Msg = wget(URL);
		if( Msg == 'ERROR' )
			status_write("<font color='red'>Une erreur est apparue</font>");
		else 
		{
			status_write(Msg);
			document.location.reload();
		}
	}
}

/* Ouvre la fenêtre d'édition d'un contact */
function Edit()
{
	conid = GetActive();
	if( conid == 0 )
	{
		status_write("<font color='red'>Veuillez s&eacute;lectionner une ligne</font>");
		return;
	}
	URL = ContactScript+'?Option=EditContact&conid='+conid;
	win.setAjaxContent(URL);
	win.setTitle('Editer un contact');
	win.setSize(420,330);
	win.showCenter();
	// Fondre le fond
	document.getElementById('overlay_modal').style.display = 'block';
	return false;
}

/* Ouvre la fenêtre de selection d'un contact */
function DisplayContacts(parentWindow, inputConid, inputSender)
{
	URL = '/components/Contact/Contact.php?Option=DisplayContacts&Cid='+document.getElementById(inputConid).value+'&inputConid='+inputConid+'&inputSender='+inputSender+'&parentWindowId='+parentWindow.getId();

	// Fondre le fond
	parentWindow.setOpacity(0.6);
	// Fenetre popup
	if( typeof(Contacts) != 'object' )
	{
		Contacts = new Window('Contacts',{className: "bluelighting", closable:false, resizable:false,
			maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
	}

	Contacts.setZIndex(30);
	Contacts.setOpacity(1);
	// Appeler la page
	Contacts.setAjaxContent(URL);
	Contacts.setTitle('Choisir un exp&eacute;diteur');
	Contacts.setSize(380,330);
	Contacts.showCenter();
}

/* Ferme la fenêtre de selection de contact */
function AbortContact()
{
	var parent = document.getElementById(document.getElementById('parentContacts').value);
	parent.style.opacity = 1;
	parent.style.filter = 'alpha(opacity=10)';
	Contacts.hide();
}

/* Enregistre la selection de contact */
function SaveSender(conid,Sender,inputConid, inputSender)
{
	document.getElementById(inputConid).value = conid;
	document.getElementById(inputSender).value = Sender;
	AbortContact();
}

/* Ferme la fenêtre d'edition d'un contact */
function CloseEditContact()
{
	win.hide();
	document.getElementById('overlay_modal').style.display = 'none';
}

/* Supprime un contact */
function Delete()
{
	conid = GetActive();
//	A partir de l'URL retrouver le composant appelé
	URL  = ContactScript+ '?'; 
	if( conid != 0 )
	{
		URL += 'Option=Delete&conid='+conid;
		Msg = wget(URL);
		if( Msg == 'ERROR' )
			status_write("<font color='red'>Une erreur est apparue</font>");
		else 
		{
			status_write('');
			document.location.reload();
		}
	}
}

function Save()
{  // Sauve données
	if( Valid('EditContact') != true )
		return;

	MyForm = document.getElementById('EditContact');
//	A partir de l'URL retrouver le composant appelé
	URL = ContactScript + '?Option=Save'; 

//	Construire l'URL
	string='';
	for( i=0 ; i < MyForm.length ; i++)
	{ // Parcourir tous les chams
		for( j=0 ; j< Variables.length ; j++)
		{ // Pour chaque champs trouve, lire le type
			if( Variables[j][0] == MyForm.elements[i].name )
			{
				switch( Variables[j][1] )
				{  // agir en fonction du type
				case 'text':
				case 'hidden':
				case 'select':
				case 'mail':
				case 'phone':
				case 'int':
					if( MyForm.elements[i].value.length > 0 )
						URL += '&' + MyForm.elements[i].name + '=' + encodeURIComponent(HTMLentities(MyForm.elements[i].value));
					break;

				case 'check':
					if( MyForm.elements[i].checked )
						URL += '&' + MyForm.elements[i].name + '=1';
					else
						URL += '&' + MyForm.elements[i].name + '=0';
					break;

				case 'MD5pwd':  // Le vrai mot de passe (MD5) est passe en hidden
					break;

				default:  // Type non défini
					alert( Variables[j][1] + ' - ' + MyForm.elements[i].name );
				break;

				}  // fin switch
			}  // endif
		} // for j
	} // for i
//	appel au serveur
	status_write(wget(URL));
//	Cacher le popup et recharger les données
	document.getElementById('overlay_modal').style.display = 'none';
	win.hide();
	document.location.reload();
}

function QuitContact()
{
	document.location="/index.php";
}
