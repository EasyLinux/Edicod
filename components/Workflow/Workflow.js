/**
 * Gestion du workflow
 * 
 * @package		Composants
 * @subpackage		Paramètres
 * @access		public
 * @version		1.2
 * @author              Serge NOEL
 *
 */
//Workflow
var Workflow, Step, Detail;
var WorkflowScript='/components/Workflow/Workflow.php';
var DivSelected="Vide", RadioSelected;

/**
 * Fonction qui gère l'ajout d'un workflow
 *
 * @todo continuer documentation
 */
function Workflow_Add()
{
	URL = WorkflowScript+'?Option=WorkflowEdit&Id=-1'; 
	DivSelected="Vide";

//	Appeler la page
	Workflow = new Window('Workflow',{className: "bluelighting", closable:false, resizable:false, maximizable: false, minimizable:false, 
		showEffect:Effect.Appear, hideEffect:Effect.Fade});
	Workflow.setAjaxContent(URL);
	Workflow.setTitle('Parcours du courrier (Workflow)');
	Workflow.setSize(470,470);
	Workflow.showCenter();
//	Fondre le fond
	document.getElementById('overlay_modal').style.display = 'block';
}

function Workflow_Abort()
{
	document.getElementById('overlay_modal').style.display = 'none';
	Workflow.hide();
	Workflow.destroy();
	status_write('');
	document.location.reload();
}

function Workflow_Save()
{
	URL = WorkflowScript+'?Option=SaveWorkflow&Wid='+document.getElementById('wid').value; 
	URL += '&Name='+urlencode(htmlentities(document.getElementById('name').value));
	URL += '&Comment='+urlencode(htmlentities(document.getElementById('comment').value));
	URL += '&RespondBefore='+urlencode(htmlentities(document.getElementById('RespondBefore').value));
	URL += '&Fid='+document.getElementById('fid').value;
	NoOut = wget(URL);
	
/*  v2
	Groups="";
	URL = WorkflowScript+'?Option=SaveGroups';
	
//	Sauvegarder la liste des groupes
	var In  = document.getElementById('memberof');
	if(In != null) 
	{
		for( i=0 ; i< In.length ; i++)
		{
			//  Text  = In.options[i].text;
			Value = In.options[i].value;
			Groups += Value + '|';
		}

		GrpXML = "&wid="+document.getElementById('wid').value+"&Groups="+Groups;
		NoOut = wpost(URL,GrpXML);
	}
*/
	document.getElementById('overlay_modal').style.display = 'none';
	Workflow.hide();
	Workflow.destroy();
	status_write('');
	document.location.reload();
}

function Workflow_Delete()
{
	id = GetActive();
	if( id == 0 )
	{
		status_write("<font color='red'>Veuillez s&eacute;lectionner une ligne</font>");
		return;
	}

	URL = WorkflowScript+'?Option=WorkflowDelete&Wid='+id; 
	wget(URL);
	status_write('');
	document.location.reload();
}

function Workflow_Edit()
{
	DivSelected="Vide";
	MemberChange= false;
	id = GetActive();
	if( id == 0 )
	{
		status_write("<font color='red'>Veuillez s&eacute;lectionner une ligne</font>");
		return;
	}

	URL = WorkflowScript+'?Option=WorkflowEdit&Id='+id; 

//	Appeler la page
	Workflow = new Window('Workflow',{className: "bluelighting", closable:false, resizable:false, maximizable: false, minimizable:false, 
		showEffect:Effect.Appear, hideEffect:Effect.Fade});
	Workflow.setAjaxContent(URL);
	Workflow.setTitle('Parcours du courrier (Workflow)');
	Workflow.setSize(470,470);
	Workflow.showCenter();
//	Fondre le fond
	document.getElementById('overlay_modal').style.display = 'block';
	return false;
}

function MyTab(Idx)
{
	if( document.getElementById('wid').value == -1 )
	{ // on change de tab, mais le workflow n'a pas d'id
		if( document.getElementById('name').value == "" )
		{
			alert('Le nom ne doit pas etre vide');
			return;
		}
		URL = WorkflowScript +'?Option=GetSaveWid'; 
		XML = 'name='+urlencode(htmlentities(document.getElementById('name').value)); 
		XML += '&comment='+urlencode(htmlentities(document.getElementById('comment').value));
		Msg = wpost(URL,XML);

		if( Msg.substring(0,6) == "ERREUR" )
		{
			alert('Erreur nom en double !');
			return;
		}
		document.getElementById('wid').value = Msg;
	}

	for( i=1 ; i<3 ; i++)
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
	}  
	while (Del);
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
	} while (Del);
}

function Select(ID)
{		
	/* *** RAFRAICHIR LA LISE DES ETAPES DU WORFLOW ***
		URL = WorkflowScript+'?Option=WorkflowEdit&Id='+id; 
		Workflow.setAjaxContent(URL);
		Workflow.setOpacity(1);
		Step.destroy();
		DivSelected="Vide";
	*/
	
	if( DivSelected != "Vide") {
		document.getElementById(DivSelected).style.backgroundColor = "#C1D2EF";
	}

	DivSelected=ID;
	document.getElementById(ID).style.backgroundColor = "#AFCBEF";
	
	//alert('DivSelected = '+DivSelected);
}

function AddStep()
{
	if( document.getElementById('wid').value == -1 )
	{ // on change de tab, mais le workflow n'a pas d'id
		if( document.getElementById('name').value == "" )
		{
			alert('Le nom ne doit pas etre vide');
			return;
		}
		URL = WorkflowScript +'?Option=GetSaveWid'; 
		XML = 'name='+urlencode(htmlentities(document.getElementById('name').value));
		XML += '&comment='+urlencode(htmlentities(document.getElementById('comment').value));
		Msg = wpost(URL,XML);
		if( Msg.substring(0,6) == "ERREUR" )
		{
			alert('Erreur nom en double !');
			return;
		}
		document.getElementById('wid').value = Msg;
	}

	URL = WorkflowScript+'?Option=AddStep&SelectedId='+DivSelected; 
//	Appeler la page
	Step = new Window('Step',{className: "bluelighting", closable:true, resizable:false, maximizable: false, minimizable:false, 
		showEffect:Effect.Appear, hideEffect:Effect.Fade});
	Step.setAjaxContent(URL);
	Step.setTitle('Ajout d\'une &eacute;tape ');
	Step.setSize(340,100);
	Step.showCenter();
//	Fondre le fond
	Workflow.setOpacity(0.6);
	Step.setOpacity(1);
	Step.setZIndex(20);
}

function ModStep()
{
	if( DivSelected == "Vide" || substr(DivSelected,0,1) != "S")
	{
		alert("Aucune Etape n'est sélectionnée !");
		return;
	}
	URL = WorkflowScript+'?Option=ModStep&SelectedId='+DivSelected; 

//	Appeler la page
	Step = new Window('Step',{className: "bluelighting", closable:true, resizable:false, maximizable: false, minimizable:false, 
		showEffect:Effect.Appear, hideEffect:Effect.Fade});
	Step.setAjaxContent(URL); 
//	Détail du parcours
	Step.setTitle('Edition d\'une &eacute;tape ');
	Step.setSize(340,100);
	Step.showCenter();
//	Fondre le fond
	Workflow.setOpacity(0.6);
	Step.setOpacity(1);
	Step.setZIndex(20);
}

function Step_Abort()
{	
	//on désélectionne l'étape en remettant la couleur initiale
	if( DivSelected != "Vide")
		document.getElementById(DivSelected).style.backgroundColor = "#C1D2EF";
	
	Workflow.setOpacity(1);
	Step.destroy();
	DivSelected="Vide";
}

function Step_Save()
{
	URL = WorkflowScript+'?Option=SaveStep&Id='+document.getElementById('Id').value; 
	URL += '&Before='+document.getElementById('BeforeId').value;
	URL += '&Description='+urlencode(htmlentities(document.getElementById('Description').value));
	URL += '&Wid='+document.getElementById('wid').value;
	URL += '&Action='+document.getElementById('Action').value;
	NoOut = wget(URL);
	
	URL = WorkflowScript+'?Option=WorkflowEdit&Id='+document.getElementById('wid').value; 
	Workflow.setAjaxContent(URL);
	Workflow.setOpacity(1);
	Step.destroy();
	DivSelected="Vide";
}

function DelStep()
{
	if( DivSelected == "Vide" )
	{
		alert("Aucune étape n'est sélectionnée !");
		return;
	}
	if( substr(DivSelected,0,1) != "S" )
	{
		alert("Vous n'avez pas sélectionné une étape !");
		return;
	}
	if( confirm('Supprimer cette etape ?') )
	{
		URL = WorkflowScript+'?Option=DelStep&SelectedId='+DivSelected; 
		NoOut = wget(URL);
		id = GetActive();
		
		//rafraichir la liste
		URL = WorkflowScript+'?Option=WorkflowEdit&Id='+id; 
		Workflow.setAjaxContent(URL);
		Workflow.setOpacity(1);

		DivSelected="Vide";
	}
}

function UpStep()
{
	if( DivSelected == "Vide" )
	{
		alert("Aucune étape n'est sélectionnée !");
		return;
	}
	if( substr(DivSelected,0,1) != "S" )
	{
		alert("Vous n'avez pas sélectionné une étape !");
		return;
	}
	URL = WorkflowScript+'?Option=UpStep&SelectedId='+DivSelected; 
	NoOut = wget(URL);
	
	//rafraichir la page
	URL = WorkflowScript+'?Option=WorkflowEdit&Id='+id; 
	Workflow.setAjaxContent(URL);
	Workflow.setOpacity(1);
	//Step.destroy();
	DivSelected="Vide";
}

function DownStep()
{
	if( DivSelected == "Vide" )
	{
		alert("Aucune étape n'est sélectionnée !");
		return;
	}
	if( substr(DivSelected,0,1) != "S" )
	{
		alert("Vous n'avez pas sélectionné une étape !");
		return;
	}
	URL = WorkflowScript+'?Option=DownStep&SelectedId='+DivSelected; 
	NoOut = wget(URL);
	
	//rafraifir la page
	URL = WorkflowScript+'?Option=WorkflowEdit&Id='+id; 
	Workflow.setAjaxContent(URL);
	Workflow.setOpacity(1);
	//Step.destroy();
	DivSelected="Vide";
}

function AddDetail()
{
	if( DivSelected == "Vide" )
	{
		alert("Aucune ligne n'est sélectionnée !");
		return;
	}
	if( substr(DivSelected,0,1) != "S" )
	{
		alert("Vous devez selectionner une étape !");
		return;
	}
	
	URL = WorkflowScript+'?Option=AddDetail&SelectedId='+DivSelected; 
//	Appeler la page
	Detail = new Window('Detail',{className: "bluelighting", closable:true, resizable:false, maximizable: false, minimizable:false, 
		showEffect:Effect.Appear, hideEffect:Effect.Fade});
	Detail.setAjaxContent(URL);
	Detail.setTitle('Ajout d\'une action ');
	Detail.setSize(390,220);
	Detail.showCenter();
//	Fondre le fond
	Workflow.setOpacity(0.6);
	Detail.setOpacity(1);
	Detail.setZIndex(20);
}

function ModDetail()
{
	if( DivSelected == "Vide" || substr(DivSelected,0,1) != "D")
	{
		alert("Aucune Action n'est sélectionnée !");
		return;
	}
	URL = WorkflowScript+'?Option=ModDetail&SelectedId='+DivSelected; 

//	Appeler la page
	Detail = new Window('Detail',{className: "bluelighting", closable:true, resizable:false, maximizable: false, minimizable:false, 
		showEffect:Effect.Appear, hideEffect:Effect.Fade});
	Detail.setAjaxContent(URL); 
//	Détail du parcours
	Detail.setTitle('Edition d\'une action');
	Detail.setSize(390,220);
	Detail.showCenter();
//	Fondre le fond
	Workflow.setOpacity(0.6);
	Detail.setOpacity(1);
	Detail.setZIndex(20);
}


function Detail_Abort()
{
	//on désélectionne l'action remettant la couleur initiale
	if( DivSelected != "Vide")
		document.getElementById(DivSelected).style.backgroundColor = "#C1D2EF";
	
	Workflow.setOpacity(1);
	Detail.destroy();
	DivSelected="Vide";
	
}

function Detail_Save()
{
	URL = WorkflowScript+'?Option=SaveDetail&SId='+document.getElementById('SId').value; 
	URL += '&Before='+document.getElementById('BeforeId').value;
	URL += '&Description='+urlencode(htmlentities(document.getElementById('Description').value));
	URL += '&Wid='+document.getElementById('wid').value;
	URL += '&Action='+document.getElementById('Action').value;
	URL += '&Guid='+document.getElementById('Guid').value;
	if( document.getElementById('actor').checked )
		URL += '&Actor=1';
	else
		URL += '&Actor=0';
	Colonne = document.getElementById('AddStep').Col;
	iCol=-1;
	for( i=0 ; i<4 ; i++)
	{
		if( Colonne[i].checked == true )
			iCol=i;
	}
	URL += '&Col='+iCol;
	NoOut = wget(URL);
	id = GetActive();
	URL = WorkflowScript+'?Option=WorkflowEdit&Id='+document.getElementById('wid').value; 
	Workflow.setAjaxContent(URL);
	Workflow.setOpacity(1);
	Detail.destroy();
	DivSelected="Vide";
}

function DelDetail()
{
	if( DivSelected == "Vide" || substr(DivSelected,0,1) != "D")
	{
		alert("Aucune Action n'est sélectionnée !");
		return;
	}
	if (confirm('Supprimer cette Action ?') )
	{
		URL = WorkflowScript+'?Option=DelDetail&SelectedId='+DivSelected; 
		NoOut = wget(URL);
		id = GetActive();
		
		//rafraichir la liste
		URL = WorkflowScript+'?Option=WorkflowEdit&Id='+id; 
		Workflow.setAjaxContent(URL);
		Workflow.setOpacity(1);

		DivSelected="Vide";
	}
}

function SetDescription()
{
//	alert(document.getElementById('Guid').value);
}

function Workflow_Quit()
{
	document.location="/index.php";
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

function SetFolderActive(Value)
{  // Fonction appelee lors d'un click de selection
	RadioSelected=Value;
}

function GetFolderActive()
{  // Lire la ligne cochee
	return RadioSelected;
}

function QuitDocFolder()
{
	DocFolders.hide();
	win.setOpacity(1);
}

function SelectDocFolder()
{
	URL  = '/components/DocFolders/DocFolders.php?'; 
	URL += 'Option=GetTreeLabel&Id='+GetFolderActive();

	innerHTML = wget(URL);
	innerHTML = innerHTML.substring(0,innerHTML.length-2);
	if( innerHTML.length > 30 )
	  {
	  Begin = innerHTML.substring(0,innerHTML.indexOf("/",1)+1);
	  End   = innerHTML.substring(innerHTML.lastIndexOf("/"));
	  innerHTML = Begin + "..." + End;
	  }
	document.getElementById('List').innerHTML = innerHTML;
	document.getElementById('fid').value = GetFolderActive();
	DocFolders.hide();
	win.setOpacity(1);
}

function AddDocFolder()
{
val = prompt('Nom du dossier','Nouveau_dossier');
if(val) 
  {
	URL = '/components/DocFolders/DocFolders.php?Option=AddFolder&Id='+GetFolderActive()+"&Val="+urlencode(val);
	wget(URL);
	// Refresh fenetre
	document.getElementById('DocFolders_content').innerHTML='';
	URL = "/components/DocFolders/DocFolders.php?Option=DisplayDocFolders";
	DocFolders.setAjaxContent(URL);
	}
}

