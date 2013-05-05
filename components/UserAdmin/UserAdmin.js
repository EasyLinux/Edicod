//Variables
UaScript = "/components/UserAdmin/UserAdmin.php";

function Add()
{  // Affiche le popup 
	URL = UaScript+'?Option=UsrEdit&Id=-1'; 
	innerHTML = wget(URL);
	document.getElementById('UaPopup').innerHTML = innerHTML;
//	Appeler la page
	win.setContent('UaPopup',true, true);
	win.setTitle('Ajouter un utilisateur');
	win.setSize(420,350);
	win.showCenter();
//	Fondre le fond
	document.getElementById('overlay_modal').style.display = 'block';
	return false;
}

function Delete()
{  // Efface un utilisateur
	uid = GetActive();
	if( uid < 100 )
	{
		alert('Vous ne pouvez pas supprimer cet utilisateur');
		return;
	}
//	A partir de l'URL retrouver le composant appelé
	Call      = ''+document.location;
	Options   = Call.split('?')[1];
	Optiond   = Options.split('&')[0];
	Component = Optiond.split('=')[1];
	URL  = UaScript + '?'; 
	if( uid != 0 )
	{
		URL += 'Option=Delete&id='+uid;
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

function Abort()
{
	document.getElementById('overlay_modal').style.display = 'none';
	win.hide();
}

function Edit()
{
	uid = GetActive();
	if( uid == 0 )
	{
		status_write("<font color='red'>Veuillez s&eacute;lectionner une ligne</font>");
		return;
	}
	URL = UaScript+'?Option=UsrEdit&Id='+uid; 
	innerHTML = wget(URL);
	document.getElementById('UaPopup').innerHTML = innerHTML;
//	Appeler la page
	win.setContent('UaPopup',true, true);
	win.setTitle('Modifier un utilisateur');
	win.setSize(420,350);
	win.showCenter();
//	Fondre le fond
	document.getElementById('overlay_modal').style.display = 'block';
	return false;
}
function GetProfile()
{
	URL = UaScript+'?Option=GetProfiles'; 
	URL += 'Option=GetProfiles';
	Response = wget(URL);

	Ligne = Response.split('|');

	for( i=0 ; i < Ligne.length ; i++)
	{
		Vals = Ligne[i].split('=');
		Child = new Option(Vals[1],Vals[0]);
	}

	status_write('');
}

function MyTab(Idx)
{
	if( document.getElementById('uid').value == -1 )
	{ // on change de tab, mais l'utilisateur n'a pas d'id
		if( document.getElementById('login').value == "" )
		{
			alert('Login ne doit pas etre vide');
			return;
		}
		URL = UaScript +'?Option=GetSaveUid'; 
		XML = 'login='+document.getElementById('login').value;
		Msg = wpost(URL,XML);
		if( Msg.substring(0,6) == "ERREUR" )
		{
			alert('Erreur login en double');
			return;
		}
		document.getElementById('uid').value = Msg;
	}
	for( i=1 ; i<4 ; i++)
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

function Lock()
{ // Valide / invalide un utilisateur
	uid = GetActive();
	if( uid == 0 )
	{
		status_write("<font color='red'>Veuillez s&eacute;lectionner une ligne</font>");
		return;
	}
	URL = UaScript;

	uid = GetActive();
	if( uid != 0 )
	{
		URL += '?Option=Lock&id='+uid;
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

function Save()
{  // Sauve données
	MyForm = document.getElementById('EditUser');
//	A partir de l'URL retrouver le composant appelé
	URL = UaScript +'?Option=Save'; 
	XML ='';

//	Construire l'URL
	for( i=0 ; i < MyForm.length ; i++)
	{ // Parcourir tous les chams
		switch( MyForm.elements[i].name )
		{ // En fonction 
		case 'uid':
			uid = MyForm.elements[i].value;
		case 'login':
		case 'pid':
		case 'password':
		case 'service':
		case 'MD5pass':
		case 'service':
		case 'name':
		case 'given_name':
		case 'email':
		case 'phone':
		case 'num':
		case 'address1':
		case 'address2':
		case 'zip':
		case 'city':
			if( MyForm.elements[i].value.length > 0 )
				XML += '&' + MyForm.elements[i].name + '=' + urlencode(htmlentities(MyForm.elements[i].value));
			break;

		case 'valid':
			if(MyForm.elements[i].checked)
				XML += '&' + MyForm.elements[i].name + '=1';
			else
				XML += '&' + MyForm.elements[i].name + '=0';
			break;
			
		case 'genre':
			if(MyForm.elements[i].checked)
				XML += '&' + MyForm.elements[i].name + '=' + MyForm.elements[i].value;
			break;
		
		case 'memberof':
			break;

		case 'groups':
			break;

		default:
			alert(MyForm.elements[i].name + "=" + MyForm.elements[i].value);
		break;
		}
	} // for i

	URL = UaScript +'?Option=SaveGrps'; 
	GrpXML ='';
	var Groups='';
	var In  = document.getElementById('memberof');
	for( i=0 ; i< In.length ; i++)
	{
		//  Text  = In.options[i].text;
		Value = In.options[i].value;
		Groups += Value + '|';
	}
	GrpXML = "&uid="+uid+"&Groups="+Groups;
	status_write(wpost(URL,GrpXML));

	URL = UaScript +'?Option=Save'; 
//	appel au serveur
	status_write(wpost(URL,XML));
//	Cacher le popup et recharger les données
	document.getElementById('overlay_modal').style.display = 'none';
	win.hide();
	document.location.reload();
}

function MoveAdd()
{
	var In  = document.getElementById('memberof');
	var Out = document.getElementById('groups');
	var Max = Out.length;
	do
	{
		Del = false;
		for( i=0 ; i< Out.length ; i++)
		{
			if( Out.options[i].selected )
			{
				element = document.createElement("option");
				element.text  = Out.options[i].text;
				element.value = Out.options[i].value;
				Where = In.length;
				In.options[Where] = element;
				Out.options[i] = null;
				Del = true;
			}
		}
	}  while (Del);
}

function MoveDel()
{
	var In  = document.getElementById('groups');
	var Out = document.getElementById('memberof');
	var Max = Out.length;
	do
	{
		Del = false;
		for( i=0 ; i< Out.length ; i++)
		{
			if( Out.options[i].selected )
			{
				element = document.createElement("option");
				element.text  = Out.options[i].text;
				element.value = Out.options[i].value;
				Where = In.length;
				In.options[Where] = element;
				Out.options[i] = null;
				Del = true;
			}
		}
	}  while (Del);
}

function UserQuit()
{
	document.location="/index.php";
}

/*
function TriListe(idNomListe,sens)
{	var objListe = document.getElementById(idNomListe);
	if (objListe.options.selectedIndex<0) return false;
	var objLigneADéplacer = new Option(objListe.options[objListe.options.selectedIndex].text, objListe.options[objListe.options.selectedIndex].value);
	var iPositionAvant = objListe.options.selectedIndex;
	var iPositionApres=(sens=="+")?iPositionAvant+1:iPositionAvant-1;
	if ((iPositionApres>=objListe.length)||(iPositionApres<0)) return false;
	var objLigneAChanger = new Option(objListe.options[iPositionApres].text, objListe.options[iPositionApres].value);
	objListe.options[iPositionAvant] = objLigneAChanger;
	objListe.options[iPositionApres] = objLigneADéplacer;
	objListe.options[iPositionApres].selected=true;
	objListe.focus();
}
 */

