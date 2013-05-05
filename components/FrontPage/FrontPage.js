//Variables
Script = '/components/FrontPage/FrontPage.php';
var Logs, win, Notes, Folders, Cabinet, RespondWin, AllocateFileWin;
var Did, DocFolders, Contacts, Workflow;
var RadioSelected, CalDateIn, CalDateDue;


/*************************************
 * Ouvre le popup de dispatch (Ajax) *
 *************************************/
function AllocateFile(Did)
{
	URL = Script +'?Option=AllocateFile&Did='+Did;
	if( typeof(AllocateFileWin) != 'object' )
	{
		AllocateFileWin = new Window('AllocateFileWin',{className: "bluelighting", closable:false, resizable:false,
			maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
	}
	AllocateFileWin.setZIndex(10);
	AllocateFileWin.setOpacity(1);
	// Appeler la page
	AllocateFileWin.setAjaxContent(URL);
	AllocateFileWin.setTitle('Gestion courrier');
	AllocateFileWin.setSize(850,500);
	AllocateFileWin.showCenter();
	document.getElementById('overlay_modal').style.display = 'block';
}

/********************
 * Bascule d'onglet *
 ********************/
function MyTab(Idx, varTab, varTabContent)
{
	var Tab;
	var TabT;
	for( i=1 ; i<5 ; i++)
	{
		TabT = varTab + i;
		Tab  = varTabContent + i;
		if( i == Idx )
		{
			document.getElementById(TabT).className = 'formTabTitleOn';
			document.getElementById(Tab).className = 'formTabOn';
		}
		else
		{
			document.getElementById(TabT).className = 'formTabTitleOff';
			document.getElementById(Tab).className = 'formTabOff';
		}
	}
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
 * Fonctions liées au rangement physique (armoire)                                                *
 **************************************************************************************************/
function DisplayCabinet()
{
	URL = "/components/Cabinet/Cabinet.php?Option=DisplayCabinet";

	// Fondre le fond
	win.setOpacity(0.6);
	if( typeof(Cabinet) != 'object' )
	{
		Cabinet = new Window('Cabinet',{className: "bluelighting", closable:false, resizable:false,
			maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
	}
	Cabinet.setZIndex(20);
	Cabinet.setOpacity(1);
	// Appeler la page
	Cabinet.setAjaxContent(URL);
	Cabinet.setTitle('Choisir un emplacement physique de stockage');
	Cabinet.setSize(630,410);
	Cabinet.showCenter();
}

function QuitCabinet()
{
	if( !document.getElementById('cabid').value )
	{
		alert('Ce champs doit être renseigné !');
		return;
	}
	Cabinet.hide();
	win.setOpacity(1);
}

function AddCabinet()
{
	val = prompt('Nom du dossier','Nouveau_dossier');

	URL  = '/components/Cabinet/Cabinet.php?'; 
	URL += 'Option=AddCabinet&cabid='+GetActive()+"&Val="+urlencode(val);
	Msg = wget(URL);
	if( Msg.length > 2 )
		status_write(Msg);
	else
	{
		URL = "/components/Cabinet/Cabinet.php?Option=DisplayCabinet";
		Cabinet.setAjaxContent(URL);
	}
}

function SelectCabinet()
{
	ID = GetActive();
	if( ID == -1 )
		return;
	document.getElementById('cabid').value = ID;
	document.getElementById('box').value = wget("/components/Cabinet/Cabinet.php?Option=GetCabinetString&cabid="+ID);
	Cabinet.hide();
	win.setOpacity(1);
}

/**************************************************************************************************
 * Fonctions liées au rangement logique (disque dur)                                              *
 **************************************************************************************************/
function DisplayFolders()
{
	URL = "/components/Folders/Folders.php?Option=DisplayFolders";

	// Fondre le fond
	win.setOpacity(0.6);
	if( typeof(Folders) != 'object' )
	{
		Folders = new Window('Folders',{className: "bluelighting", closable:false, resizable:false,
			maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
	}

	Folders.setZIndex(20);
	Folders.setOpacity(1);
	// Appeler la page
	Folders.setAjaxContent(URL);
	Folders.setTitle('Choisir un r&eacute;pertoire');
	Folders.setSize(650,410);
	Folders.showCenter();
}

function AddPath()
{
	if( RadioSelected.length == 0 )
	{
		alert('Vous devez choisir un repertoire racine');
		return( false );
	}
	val = prompt('Nom du repertoire','Nouveau_dossier');
	if(val) {
		// A partir de l'URL retrouver le composant appelé
		URL  = '/components/Folders/Folders.php?';
		URL += 'Option=AddPath&Path='+urlencode(GetActive()+'/'+val);
		Msg = wget(URL);
		if( Msg.length > 2 )
			status_write(Msg);
		else
		{
			URL = "/components/Folders/Folders.php?Option=DisplayFolders";
			Folders.setAjaxContent(URL);
		}
	}
}

function SelectFolder()
{
document.getElementById('path').value = GetActive();
Folders.hide();
win.setOpacity(1);
}

function QuitPath()
{
	if( !document.getElementById('path').value )
	{
		alert('Ce champs doit être renseigné !');
		return;
	}
	Folders.hide();
	win.setOpacity(1);
}

/**************************************************************************************************
 * Fonctions liées au choix du contact                                                            *
 **************************************************************************************************/
function AbortContactWin(parentWin, win)
{
	var obj = document.getElementById(parentWin);
	var old = document.getElementById(win);
	obj.removeChild(old);
}


/**************************************************************************************************
 * Fonction liée au mots clés                                                                     *
 **************************************************************************************************/
function SaveKeyWords()
{
	Did = document.getElementById('did').value;
	URL = Script+'?Option=Keywords';
	XML = 'Did='+Did+'&Keywords='+ urlencode(document.getElementById('keywords').value);
	wpost(URL,XML);
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

	//on recharge la page
	document.location.reload();
}

/**************************************************************************************************
 * Fonction liée aux dossiers virtuels                                                            *
 **************************************************************************************************/
function DisplayDocFolder()
{
	URL = "/components/DocFolders/DocFolders.php?Option=DisplayDocFolders";

//	Fondre le fond
	win.setOpacity(0.6);
	if( typeof(DocFolders) != 'object' )
	{
		DocFolders = new Window('DocFolders',{className: "bluelighting", closable:false, resizable:false, 
			maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
	}
	DocFolders.setZIndex(20);
	DocFolders.setOpacity(1);
//	Appeler la page
	DocFolders.setAjaxContent(URL);
	DocFolders.setTitle('Choisir un r&eacute;pertoire virtuel');
	DocFolders.setSize(650,410);
	DocFolders.showCenter();
}

function QuitDocFolder()
{
	if( document.getElementById('docfolders').length < 1 )
	{
		alert('Vous devez avoir au minimum un dossier virtuel');
		return;
	}

	DocFolders.hide();
	win.setOpacity(1);
}


function SelectDocFolder()
{
	Did = document.getElementById('did').value;
	Fid = GetActive();
	if( Fid == -1 )
		return;
	URL = Script+"?Option=AddVirtualFolder&Fid="+Fid+"&Did="+Did;
	wget(URL);

//	Refresh fenetre
	document.getElementById('docfolders').innerHTML=null;
	URL = Script+"?Option=GetVirtualFolders&Did="+Did;
	document.getElementById('docfolders').innerHTML = wget(URL);
	DocFolders.hide();
	win.setOpacity(1);
}

function DelDocFolder()
{
	var Did = document.getElementById('did').value;
	// Retrouver la ligne
	var Flds = document.getElementById('docfolders');
	var selectedFolder = Flds.options[Flds.selectedIndex];

	var Fid = selectedFolder.value;

	selectedFolder.remove();
	URL = Script+"?Option=DelVirtualFolder&Fid="+Fid+"&Did="+Did;
	wget(URL);
	// Refresh fenetre
	document.getElementById('docfolders').innerHTML=null;
	URL = Script+"?Option=GetVirtualFolders&Did="+Did;
	document.getElementById('docfolders').innerHTML = wget(URL);


}

function AddDocFolder()
{
	Did = document.getElementById('did').value;
//	Retrouver la ligne 
	Flds = document.getElementById('docfolders');
	for( i=0 ; i< Flds.length ; i++)
	{
		if( Flds.options[i].selected )
		{
			Fid = Flds.options[i].value;
			i=Flds.length;
		}
	}
	val = prompt('Nom du dossier','Nouveau_dossier');
	if(val) {
		URL = '/components/DocFolders/DocFolders.php?Option=AddFolder&Id='+GetActive()+"&Val="+urlencode(val);
		wget(URL);
		// Refresh fenetre
		document.getElementById('DocFolders_content').innerHTML='';
		URL = "/components/DocFolders/DocFolders.php?Option=DisplayDocFolders";
		DocFolders.setAjaxContent(URL);
	}
}


/**************************************************************************************************
 * Bascule le champs num REC                                                                      *
 **************************************************************************************************/
function Toggle()
{
	ImgSrc = document.getElementById('RAimg').src;


	if( ImgSrc.indexOf('AROff.png',0) != -1)
	{
		document.getElementById('RAimg').src = ImgSrc.substr(0,ImgSrc.indexOf('AROff.png',0)) + "AROn.png";
		document.getElementById('idreceptnum').className = 'fpPopInp2';
		document.getElementById('idreceptnum').readonly = false;
	}
	else
	{
		document.getElementById('RAimg').src = ImgSrc.substr(0,ImgSrc.indexOf('AROn.png',0)) + "AROff.png";
		document.getElementById('idreceptnum').className = 'fpPopInp2Gray';
		document.getElementById('idreceptnum').readonly = true;
	}
}

/**************************************************************************************************
 * Fonctions liées au workflow                                                                    *
 **************************************************************************************************/
function DisplayWorkflows(txtWorkflow, inputWsid)
{
	URL = "/components/Workflow/Workflow.php?Option=DisplayWorkflows&txtWorkflow="+txtWorkflow+"&inputWsid="+inputWsid;

//	Fondre le fond
	win.setOpacity(0.6);
	if( typeof(Workflow) != 'object')
	{
		Workflow = new Window('Workflow',{className: "bluelighting", closable:false, resizable:false, 
			maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
	}
	Workflow.setZIndex(20);
	Workflow.setOpacity(1);
//	Appeler la page
	Workflow.setAjaxContent(URL);
	Workflow.setTitle('Choisir un workflow');
	Workflow.setSize(330,350);
	Workflow.showCenter();
}

function QuitWorkflow()
{
	if( document.getElementById('wfsid').value == '-1' )
	{
		alert('Vous devez valider un workflow');
		return;
	}

	Workflow.hide();
	win.setOpacity(1);
}

//***************************************************************************************************************************************************************
function SelectWorkflow(txtWorkflow, inputWsid)
{
	URL = "/components/Workflow/Workflow.php?Option=ArianeStart";
	sWF = document.getElementById('workflow');
	for(i=0 ; i< sWF.length ; i++)
	{
		if( sWF.options[i].selected )
		{
			WfText = sWF.options[i].text;
			WfValue = sWF.options[i].value;
		}
	}
	XML = "wid="+WfValue;
	Retour = wpost(URL,XML);
	document.getElementById(txtWorkflow).innerHTML = Retour;
	URL = "/components/Workflow/Workflow.php?Option=GetFirstWfsid";
	Retour = wpost(URL,XML);
	document.getElementById(inputWsid).value = Retour;

	Workflow.hide();
	win.setOpacity(1);
}

/*****************************
 * Sauve le document alloué *
 ****************************/
function SaveAllocateDoc()
{  // Sauve données

	// Vérifie que les champs obligatoires sont présents
	Obligatoire="";
	if( document.getElementById('SenderAllocate').value == '' )
		Obligatoire += "Vous devez renseigner un expéditeur\n";
	if( document.getElementById('path').value.length < 1 )
		Obligatoire += "Vous devez renseigner un chemin de stockage\n";
	if( document.getElementById('wfsid').value == -1 )
		Obligatoire += "Vous devez renseigner un parcours\n";

	URL=Script+'?Option=HaveFolders&did='+document.getElementById('did').value;
	Obligatoire += wget(URL);


	if( Obligatoire.length > 1 )
	{
		alert(Obligatoire);
		return;
	}

	MyForm = document.getElementById('DispatchMail');
	URL = Script+'?Option=AllocateSave';
	XML = "";

	// afficherContenuMyForm(MyForm);

	// Construire l'URL
	string='';
	for( i=0 ; i < MyForm.length ; i++)
	{ // Parcourir tous les champs
		if( MyForm.elements[i].id != '-1' )
		{
			switch( MyForm.elements[i].name )
			{
			case 'cabid':
			case 'object':
			case 'date_in':
			case 'conidAllocate':
			case 'did':
			case 'receptid':
			case 'cabid':
			case 'path':
				if( MyForm.elements[i].value.length > 0 )
					XML += '&' + MyForm.elements[i].name + '=' + MyForm.elements[i].value;
				break;
			case 'wfsid':
				if( MyForm.elements[i].value.length > 0 )
					XML += '&' + MyForm.elements[i].name + '=' + urlencode(htmlentities(MyForm.elements[i].value));
				break;

			case 'name':
				break;

			default:
				//alert(MyForm.elements[i].name + '=' +MyForm.elements[i].type);
				break;
			}
		}
	} // for i

	// appel au serveur par Ajax (méthode POST)
	Message = wpost(URL,XML);
	status_write(Message);
	//Cacher le popup et recharger les données
	document.getElementById('overlay_modal').style.display = 'none';
	win.hide();
	if( Message.substr(0,4) != "Donn" )
		alert("ERREUR\n"+Message);
	document.location.reload();
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


/**************************************************************************************************************************************************************************************************/



/******************* 
 * Quitte le Popup *
 *******************/
function AbortLogs()
{ 
	Logs.hide();
	win.setOpacity(1);
}

/******************* 
 * Quitte le Popup *
 *******************/
function AbortPop()
{ 
	Fold.hide();
	win.setOpacity(1);
	document.getElementById('Popup2').style.display = 'none';
}


/********************
 * Bascule les tabs *
 ********************/
function TabOn(TabNum)
{
	for(i=TabInit ; i < MaxTab ; i++)
	{
		if( TabNum== i )
		{
			document.getElementById('TabHeadFP'+i).className = 'fpTabTitleOn';
			document.getElementById('TabContentFP'+i).style.display = 'block';
		}
		else
		{
			document.getElementById('TabHeadFP'+i).className = 'fpTabTitleOff';
			document.getElementById('TabContentFP'+i).style.display = 'none';
		}
	}
}

function ChangeStatus()
{
	Status = document.getElementById('msid').value;
	if( Status == 1 ) // msid=1 -> Action requise
	{
		document.getElementById('Action').style.display = 'block';
		document.getElementById('DateLim').style.display = 'block';
		document.getElementById('DateLimIn').style.display = 'block';
		document.getElementById('Limite').style.display = 'none';
	}
	else
	{
		document.getElementById('Action').style.display = 'none';
		document.getElementById('DateLim').style.display = 'none';
		document.getElementById('DateLimIn').style.display = 'none';
		document.getElementById('Limite').style.display = 'block';
	}
}

/********************
 * Formate la date  *
 ********************/
function SetiDate()
{ // Transforme la date de '02/10/2009' a '2009-10-02'
	FrDate = document.getElementById('idate').value;
	UsDate = substr(FrDate,6,4)+'-'+substr(FrDate,3,2)+'-'+substr(FrDate,0,2);
	document.getElementById('date_in').value = UsDate;
}

function SetbDate()
{ // Transforme la date de '02/10/2009' a '2009-10-02'
	FrDate = document.getElementById('bdate').value;
	UsDate = substr(FrDate,6,4)+'-'+substr(FrDate,3,2)+'-'+substr(FrDate,0,2);
	document.getElementById('date_due').value = UsDate;
}

function SetoDate()
{ // Transforme la date de '02/10/2009' a '2009-10-02'
	FrDate = document.getElementById('odate').value;
	UsDate = substr(FrDate,6,4)+'-'+substr(FrDate,3,2)+'-'+substr(FrDate,0,2);
	document.getElementById('date_out').value = UsDate;
}

function SaveEditDoc()
{  
//	Sauve données
	MyForm = document.getElementById('EditMail');
	URL = Script+ "?Option=EditSave"; 
	XML ='';

//	afficherContenuMyForm(MyForm);

//	Construire l'URL
	string='';
	for( i=0 ; i < MyForm.length ; i++)
	{ // Parcourir tous les chams
		if( MyForm.elements[i].id != '-1' )
		{
			//alert(MyForm.elements[i].name + '=' +MyForm.elements[i].type);
			switch( MyForm.elements[i].name )
			{
			// Identifiants
			case 'did':
			case 'cabid':
			case 'conid':
			case 'wfsid':
				if( MyForm.elements[i].value.length > 0 )
					XML += '&' + MyForm.elements[i].name + '=' + MyForm.elements[i].value;
				break;

				// Champs textes  
			case 'date_in':
				if (document.getElementById('date_in').value == -1 )
					SetiDate();
				if( MyForm.elements[i].value.length > 0 )
					XML += '&' + MyForm.elements[i].name + '=' + MyForm.elements[i].value;
				break;

			case 'date_due':
				if (document.getElementById('date_due').value == -1 )
					SetbDate();
				if( MyForm.elements[i].value.length > 0 )
					XML += '&' + MyForm.elements[i].name + '=' + MyForm.elements[i].value;
				break;

			case 'date_out':
				if (document.getElementById('date_out').value == -1 )
					SetoDate();
				if( MyForm.elements[i].value.length > 0 )
					XML += '&' + MyForm.elements[i].name + '=' + MyForm.elements[i].value;
				break;

			case 'object':
				if( MyForm.elements[i].value.length > 0 )
					XML += '&' + MyForm.elements[i].name + '=' + MyForm.elements[i].value;
				break;
			case 'receptid':
			case 'path':
				/*if( MyForm.elements[i].value.length > 0 )
					XML += '&' + MyForm.elements[i].name + '=' + urlencode(htmlentities(MyForm.elements[i].value));
				break;*/
			}
		}
	} // for i
//	appel au serveur
	status_write(wpost(URL,XML));
//	alert(wpost(URL,XML));
//	Cacher le popup et recharger les données
	document.getElementById('overlay_modal').style.display = 'none';
	win.hide();
	document.location.reload();
}

function SaveNextStep(LastStep)
{  
	// Sauve données
	MyForm = document.getElementById('EditMail');
	URL = Script+ "?Option=SaveNextStep"; 
	XML ='';

	//Construire l'URL
	string='';
	for( i=0 ; i < MyForm.length ; i++)
	{ // Parcourir tous les chams
		if( MyForm.elements[i].id != '-1' )
		{
			//alert(MyForm.elements[i].name + '=' +MyForm.elements[i].type);
			switch( MyForm.elements[i].name )
			{
			// Identifiants
			case 'did':
				if( MyForm.elements[i].value.length > 0 )
					XML += '&' + MyForm.elements[i].name + '=' + MyForm.elements[i].value;
				break;

				// Champs textes  
			case 'object':
				if( MyForm.elements[i].value.length > 0 )
					XML += '&' + MyForm.elements[i].name + '=' + urlencode(htmlentities(MyForm.elements[i].value));
				break; 

			default:
				//XML += '& |' + MyForm.elements[i].name+ '| ';
				break;
			}
		}
	} // for i

	if(LastStep) {
		if(confirm("ATTENTION : en cliquant sur OK vous terminez directement le traitement de ce courrier.\nAssurez-vous de bien l'avoir imprimé. Vous ne pourrez plus rien modifier par la suite\n\nVoulez-vous vraiment continuer ?")) {
			//appel au serveur
			status_write(wpost(URL,XML));
			//alert(wpost(URL,XML));
			//Cacher le popup et recharger les données
			document.getElementById('overlay_modal').style.display = 'none';
			win.hide();
			document.location.reload();
		}
	}
	else {
		//appel au serveur
		status_write(wpost(URL,XML));
		//alert(wpost(URL,XML));
		//Cacher le popup et recharger les données
		document.getElementById('overlay_modal').style.display = 'none';
		win.hide();
		document.location.reload();
	}
}

/************************ 
 * Affichage du fichier *
 ************************/
function Preview(File)
{
	window.open(File, 'Apercu', '');
}

/********************
 * Ajout d'une note *
 ********************/
function DisplayNotes(did)
{
	Did = did;
//	Fenetre popup
	if( Notes == undefined )
	{
		Notes = new Window('Notes',{className: "bluelighting", closable:false, resizable:false, maximizable: false, minimizable:false, 
			showEffect:Effect.Appear, hideEffect:Effect.Fade});
	}  
	Notes.setZIndex(20);
	URL = Script +'?Option=Notes&Did='+did; 
	innerHTML = wget(URL);
	document.getElementById('Popup2').innerHTML= innerHTML;
//	Appeler la page
	Notes.setContent('Popup2',true, true);
	Notes.setTitle('Afficher les notes');
	Notes.setSize(600,400);
	win.setOpacity(0.4);
	Notes.showCenter();
}

/***********
 * Journal *
 ***********/
function DisplayLogs(did)
{
//	Fenetre popup
	if( typeof(Logs) != 'object' )
	{
		Logs = new Window('Logs',{className: "bluelighting", closable:false, resizable:false, maximizable: false, minimizable:false, 
			showEffect:Effect.Appear, hideEffect:Effect.Fade});
	}
	Logs.setZIndex(20);
	URL = Script +'?Option=Log&Did='+did; 
	innerHTML = wget(URL);
	document.getElementById('Popup2').innerHTML= innerHTML;
//	Appeler la page
	Logs.setContent('Popup2',true, true);
	Logs.setTitle('Afficher le journal des acc&egrave;s');
	Logs.setSize(800,300);
	win.setOpacity(0.4);
	Logs.showCenter();
}

/**********************
 * Ajouter un contact *
 **********************/
function AddIfNewContact()
{
	Id = document.getElementById('sender').value;
	if( Id != -1 )
		return;
//	Fenetre popup
	if( typeof(Logs) != 'Fold' )
		Fold = new Window('Contact',{className: "bluelighting", closable:false, resizable:false, maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
	Fold.setZIndex(20);
	URL = '/components/Contact/Contact.php?Option=EditContact&Id=-1'; 
//	Appeler la page
	Fold.setAjaxContent(URL);
	Fold.setTitle('Ajouter contact');
	Fold.setSize(400,300);
	win.setOpacity(0.6);
	Fold.showCenter();
}

/******************* 
 * Quitte le Popup *
 *******************/
function AbortNotes()
{ 
	Notes.hide();
	win.setOpacity(1);
}

function AbortNote()
{ 
	NewNote.hide();
	win.setOpacity(1);
}




function SetActive(Value)
{  // Fonction appelee lors d'un click de selection
console.debug(Value);
console.debug(document.getElementById('AbsPath').value);
//RadioSelected=Value;
RadioSelected=substr(Value,document.getElementById('AbsPath').value.length);
}

function GetActive()
{  // Lire la ligne cochee
	return RadioSelected;
}

function GetSteps()
{
//	Il faut interroger la base pour avoir les étapes
	URL = Script+ '?Option=GetSteps&Id='+document.getElementById('workflow').value;
	Answer = wget(URL);

//	Commencons par supprimer les anciennes options
	MySelect = document.getElementById('wfsid');
	Max = MySelect.length;
	for(i=Max ; i >= 0 ; i--)
		MySelect.options[i] = null;

//	Il faut analyser la chaine en retour
	while( Answer.length > 1 )
	{
		MyElement = document.createElement("option");
		Line = Answer.substring(0,Answer.indexOf("|"));
		MyElement.value = Line.substring(0,Line.indexOf("#"));
		MyElement.text  = html_entity_decode( Line.substring(Line.indexOf("#")+1),'ENT_QUOTE' );
		MySelect.options[MySelect.length] = MyElement;
		Answer = Answer.substring(Answer.indexOf("|")+1);
	}
}

function MceInit()
{
//	Fonction d'initialisation des paramètres TinyMCE
	tinyMCE.init({
		// Mode de gestion de TinyMCE (pas de chargement par défaut, chargement à la demande)
		mode : 'none',
		// Langue
		language : 'fr',
		// Thème (gestion personnalisée avec les plugins)
		theme : 'advanced',
		// Liste des plugins utilisés
		plugins : 'fullscreen,preview,spellchecker',
		// Gestion de l'affichage des boutons sur plusieurs lignes (4 maxi)
		theme_advanced_buttons1 : 'bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect',
		theme_advanced_buttons2 : 'bullist,numlist,|,outdent,indent,|,undo,redo,|,fullscreen,|,preview,|,spellchecker',
		theme_advanced_buttons3 : '',
		// Positionnement de la barre de boutons
		theme_advanced_toolbar_location : 'top',
		// Positionnement de la barre de status
		theme_advanced_statusbar_location : 'bottom',
		// Skin options
		skin : 'o2k7'
	});
}

//Fonction pour le chargement à la demande de TinyMCE
function ChargerTinyMCE(element)
{
	if( !document.getElementById(element) )
		alert(element + ' Introuvable');
	tinyMCE.execCommand('mceAddControl', false, element);
}


//Fonction utile pour le debug
function afficherContenuMyForm(MyForm) {
	alert('Taille '+MyForm.length);
	for( i=0 ; i < MyForm.length ; i++)
	{ 
		// Parcourir tous les champs
		if( MyForm.elements[i].id != '-1' ) {
			alert('Elément '+i+', type = '+MyForm.elements[i].type+', name = '+MyForm.elements[i].name+', value = '+MyForm.elements[i].value);
		}
	}
}
