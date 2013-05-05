/**
 * Code javascript lié
 * *
 * @package		Composants
 * @subpackage		Find
 *
 *
 */
//Variables
var FScript = '/components/Find/Find.php';
var win;

/**
 * Cette fonction est appelée lors du click sur l'icône de recherche,
 *   les valeurs saisies sont mises en forme puis envoyées pour traitement Ajax
 *
 * @param	void
 * @return	void
 * @todo 	Fonction de la date 
 */
function SearchFindWhenPressEnter() {
	SearchFind();
}

function SearchFind()
{
	if(document.getElementById('keywords').value != "") {
	MyForm = document.getElementById('Find');
	URL = FScript+'?Option=Search'; 

	StartDate = document.getElementById('startdate').value;
	EndDate = document.getElementById('EndDate').value;
	BeginDate = StartDate.substr(6,4) + StartDate.substr(3,2) + StartDate.substr(0,2);
	EndingDate = EndDate.substr(6,4) + EndDate.substr(3,2) + EndDate.substr(0,2);
	if( parseInt(BeginDate) > parseInt(EndingDate) )
	{
		alert("La date de fin doit être postérieure à la date de départ !");
		return;
	}
	TypeDate = document.getElementById('tDate').value;
	Sender = document.getElementById('sender').value;
	Num = document.getElementById('numero').value;
	Kwds = document.getElementById('keywords').value;
	numType =  document.getElementById('Find').numtype;

	if( numType[0].checked )
		NumType="&NumType=Recom";
	else
		NumType="&NumType=Chrono";


	Data  = "StartDate="+StartDate+"&EndDate="+EndDate+"&TypeDate="+TypeDate+"&Sender="+Sender;
	Data += "&Num="+Num+"&Keywords="+urlencode(Kwds)+NumType;
	if( document.getElementById('subject').checked )
		Data += "&Subject=true";
	else
		Data += "&Subject=false";
	if( document.getElementById('kws').checked )
		Data += "&Kws=true";
	else
		Data += "&Kws=false";
	if( document.getElementById('autokeys').checked )
		Data += "&Autokeys=true";
	else
		Data += "&Autokeys=false";
	if( Kwds && !(document.getElementById('subject').checked || document.getElementById('kws').checked || document.getElementById('autokeys').checked ) )
	{
		alert("Vous avez spécifié des mots clés, mais vous n'avez pas indiqué où les chercher !");
		return;
	}
//	alert(Data);
//	appel au serveur par Ajax (méthode POST)
	HTML = wpost(URL,Data);

//	Afficher le résultat
	document.getElementById('Result').innerHTML = HTML;
	}
	else {
		alert("La zone de recherche est vide, veuillez saisir des mots clés.");
	}
}

/**
 * DisplayFile
 *    Affiche la fiche suiveuse
 *
 * @param	int	l'identifiant du document
 * @return	void
 */
function DisplayFile(id)
{
	/*URL = '/components/FrontPage/FrontPage.php?Option=DisplayFile&id='+id; 
	innerHTML = wget(URL);

	document.getElementById('MyPopup').innerHTML= innerHTML;
//	Appeler la page
	win.setContent('MyPopup',true, true);
	win.setTitle('Gestion courrier (lecture seule)');
	win.setSize(850,540);
	win.showCenter();
	document.getElementById('overlay_modal').style.display = 'block';
	return false;*/
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

/**
 * FindQuit
 *    Quitte l'aide
 *
 * @param	void
 * @return	void
 */
function FindQuit()
{
	document.location="/index.php";
}

/*************************************************************************************************
 * Affiche un calendrier                                                                         *
 *************************************************************************************************/
function showMyCalendar(id, dateFormat,Win) 
{
	Win.setTodayText("Aujourd'hui");
	Win.showCalendar(id);
	Win.select(document.getElementById(id),id,'dd/MM/yyyy');
}

/**************************************************************************************************
 * Fonctions liées au choix du contact                                                            *
 **************************************************************************************************/
function DisplayContacts()
{
	return;
	URL = "/components/Contact/Contact.php?Option=DisplayContacts";

//	Fondre le fond
	win.setOpacity(0.6);
	Contacts = new Window('Contacts',{className: "bluelighting", closable:false, resizable:false, 
		maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});

	Contacts.setZIndex(20);
	Contacts.setOpacity(1);
//	Appeler la page
	Contacts.setAjaxContent(URL);
	Contacts.setTitle('Choisir un exp&eacute;diteur');
	Contacts.setSize(650,410);
	Contacts.showCenter();
}

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

/************************ 
 * Affichage du fichier *
 ************************/
function Preview(File)
{
	window.open(File, 'Apercu', '');
}

