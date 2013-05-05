var UploadFileAttachWin, Cabinet, Contacts, AddContact, winWorkflows, Editwin;
var CurDid=0, ParentDid, Wid;

function SetFileName(Name)
{
document.getElementById('Up_dName').innerHTML=Name;
document.getElementById('Up_name').value=Name;
}

/* Cache la zone d'upload pour afficher une barre de chargement */
function startMyUpload()
{
// Valider si envoi possible
Conditions = '';
if( document.getElementById('Up_name').value == '' )
  {
  alert("Aucun fichier !");
  return;
  }
if( document.getElementById('Up_object').value == '' )
  {
  Conditions += "Objet est vide !";
  }
if( document.getElementById('Up_wfsid').value == -1 )
  {
  if( Conditions != '' )
    Conditions += '\n';
  Conditions += "Pas de parcours ! (Distribution)";
  }
if( Conditions != '' )
  {
  alert(Conditions);
  return;
  }

Status = window.frames['UploadTarget'].document.getElementById('Status').value;
if( Status == "Waiting" )
  return false;
document.getElementById('sFileName').style.display  = 'none';
document.getElementById('sUploadImg').style.display = 'inline';
window.frames['UploadTarget'].document.getElementById('SendFile').submit();
}

 
function InsertData(Msg, Size, md5)
{

if( Msg != "" )
  {
  if( document.getElementById('kind').value == "upload" )
    {
    alert('Ce courrier existe !\nN° Chrono: '+Msg);
    document.location="/index.php?Option=Frontpage";
    return;
    }
  else
    {
    alert('Ce courrier existe !\nIl sera pris en compte\nN° Chrono: '+Msg);
    Did = Msg;
    pDid = document.getElementById('did').value;
    Sql = "INSERT INTO docattach SET did="+pDid+", did_docattach="+Did;
    Param = "Sql="+urlencode(Sql);
    console.debug(Sql);
    URL = '/components/UploadFileAttach/UploadFileAttach.php?Option=SaveAttach';
    wpost(URL,Param);
    reloadListFileAttach();
    EditWin.setOpacity(1);
    UploadFileAttachWin.hide();
    }  
  }
  
URL = '/components/UploadFileAttach/UploadFileAttach.php?Option=SaveUploadFile';
Sql  = "INSERT INTO documents SET path='"+document.getElementById('Up_path').value+"', ";
Sql += "name='"+htmlentities(document.getElementById('Up_name').value) +"', ";
Sql += "object='"+ htmlentities(document.getElementById('Up_object').value) +"', ";
Sql += "date_in='"+document.getElementById('Up_date_in').value +"', ";
Sql += "date_due='"+document.getElementById('Up_date_in').value +"', ";
Sql += "cabid='"+document.getElementById('Up_cabid').value +"', ";
Sql += "conid='" + document.getElementById('Up_conid').value + "', ";
Sql += "size='" + Size + "', ";
Sql += "md5='" + md5 + "', ";
Sql += "wfsid='" + document.getElementById('Up_wfsid').value + "';";
Param = "Sql=" + urlencode(Sql) + "&name=" + htmlentities(document.getElementById('Up_name').value) + "&Path=" + document.getElementById('Up_path').value;
Param += "&Kind="+document.getElementById('kind').value;
if( document.getElementById('kind').value == "attach" )
  {
  Param += "&pDid="+document.getElementById('did').value;
  EditWin.setOpacity(1);
  Attachs= document.getElementById('doclinks');
  Attachs.options.length = 0;
  UploadFileAttachWin.hide();
  }

Ret = wpost(URL,Param);
reloadListFileAttach();
} 


/**************************
* Gestion liée au workfow *
***************************/
function ListWorkflows()
{
URL = '/components/Workflow/Workflow.php?Option=ListWorkflows';

Kind = document.getElementById('kind').value;
if( Kind == "upload" )
  {
  // Fondre le fond
  document.getElementById('overlay_modal').style.display = 'block';
  }
// Fenetre popup
if( typeof(winWorkflows) != 'object' )
	{
	winWorkflows = new Window('Workflows',{className: "bluelighting", closable:false, resizable:false,
			maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
	}

winWorkflows.setZIndex(30);
winWorkflows.setOpacity(1);
// Appeler la page
winWorkflows.setAjaxContent(URL);
winWorkflows.setTitle('Choisir un workflow');
winWorkflows.setSize(260,310);
winWorkflows.showCenter();
}


function SetWorkflow(sWid)
{
Wid = sWid;
return;
/*
URL = '/components/Workflow/Workflow.php?Option=GetFirstWfsid';
Val = 'wid='+Wid;
WfsId = wpost(URL,Val);
document.getElementById('Up_wfsid').value = WfsId;
URL = '/components/Workflow/Workflow.php?Option=ArianeStart';
document.getElementById('Ariane').innerHTML =  wpost(URL,Val);
URL = '/components/Workflow/Workflow.php?Option=GetDateDue';

winWorkflows.hide();
document.getElementById('overlay_modal').style.display = 'none';
*/
}


function GetWorkflow()
{
URL = '/components/Workflow/Workflow.php?Option=GetFirstWfsid';
Val = 'wid='+Wid;
WfsId = wpost(URL,Val);
document.getElementById('Up_wfsid').value = WfsId;
URL = '/components/Workflow/Workflow.php?Option=ArianeStart';
document.getElementById('Ariane').innerHTML =  wpost(URL,Val);
URL = '/components/Workflow/Workflow.php?Option=GetDateDue';

winWorkflows.hide();
document.getElementById('overlay_modal').style.display = 'none';
}

function QuitWorkflow()
{
Kind = document.getElementById('kind').value;
winWorkflows.hide();
if( Kind == "upload" )
  {
  document.getElementById('overlay_modal').style.display = 'none';
  }
else
  {
  }
}
 
/**************************************************************************************************************************************************************/
/**************************************************
* Fonction appelée dans Frontpage pour ajouter un *
* courrier attaché                                *
***************************************************/
function UploadFileAttach(parentWindow, did)
{
	URL = '/components/UploadFileAttach/UploadFileAttach.php?Option=ShowWindow&did='+did+'&parentWindowId='+parentWindow.getId();
    
    // Fondre le fond
    parentWindow.setOpacity(0.6);
    EditWin = parentWindow;

    if( typeof(UploadFileAttachWin) != 'object' )
    {
    	UploadFileAttachWin = new Window('UploadFileAttachWin',{className: "bluelighting", closable:false, resizable:false,
                                   maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
    }
    UploadFileAttachWin.setZIndex(40);
    UploadFileAttachWin.setOpacity(1);
    // Appeler la page
    UploadFileAttachWin.setAjaxContent(URL);
    UploadFileAttachWin.setTitle('Ajouter un fichier');
    UploadFileAttachWin.setSize(570,400);
    UploadFileAttachWin.showCenter();
}

/* Ferme la popup */
function closeUploadFileAttach()
{
    UploadFileAttachWin.hide();
    var parent = document.getElementById(document.getElementById('parentUploadFileAttach').value);
    parent.style.opacity = 1;
    parent.style.filter = 'alpha(opacity=10)';
    document.getElementById("did_docattach_selected").value = "";
}

/* Cache la zone d'upload pour afficher une barre de chargement */
function startUpload()
{
    var divUpload = document.getElementById('upload-form');
    var divMsgUpload = document.getElementById('loading-upload-msg');
    divUpload.style.visibility = 'hidden';
    divUpload.style.display = 'none';
    divMsgUpload.style.visibility = 'visible';
    divMsgUpload.style.display = 'block';
    
    return true;
}

/* Fonction appelée à la fin de l'upload    */
/* Affiche un message d'erreur ou de succes */
/* et cache la barre de chargement          */
/********************************************/
function stopUpload(success, iddocattach)
{
    var result = '';
    if (success == 1)
    {
        result = '<span style="margin-left:50px;" >Le fichier a été correctement envoyé<\/span><br/><br/>';
    }
    else
    {
        result = '<span style="margin-left:50px;" >Une erreur c\'est produite durant l\'envoi.<\/span><br/><br/>';
    }

    var divUpload = document.getElementById('upload-form');
    var divMsgUpload = document.getElementById('loading-upload-msg');
    var inIddocattach = document.getElementById('iddocattach');

    divUpload.style.visibility = 'visible';
    divUpload.style.display = 'block';
    
    divUpload.innerHTML = result;
    divMsgUpload.style.visibility = 'hidden';
    divMsgUpload.style.display = 'none';
    inIddocattach.value = iddocattach;
    
    reloadListFileAttach();
    return true;
}

function AddFileAttachment()
{
	alert("AddFileAttachment()");
    var URL = "/components/UploadFileAttach/UploadFileAttach.php?Option=SaveFile";
    var nom = document.getElementById("nom").value;
    var iddocattach = document.getElementById("iddocattach");
    var did = document.getElementById("did");
}

function reloadListFileAttach()
{
    var inputDid = document.getElementById('did-attach').value;
    var URLReloadList = "/components/FrontPage/FrontPage.php?Option=ReloadListFileAttach&did="+inputDid;
    var newListResponses = wget(URLReloadList);
    document.getElementById('doclinks').innerHTML = newListResponses;
}


/* 
* Documents attachés *
*********************/
function SetAttach(Did, pDid)
{
CurDid    = Did;
ParentDid = pDid;
}

function DelFileAttach()
{
if(CurDid == 0)
  alert("Aucune pièce jointe sélectionnée !");
else 
  {
	if(confirm('Voulez-vous vraiment supprimer cette pièce jointe ?')) 
	  {
		URLParams = "&Option=DeleteFileAttach&did_docattach="+CurDid+"&did="+ParentDid;
		URL = "/components/UploadFileAttach/UploadFileAttach.php";
		wpost(URL, URLParams);
			
		reloadListFileAttach();
		}
	}
}

function QuitUpload()
{
UploadFileAttachWin.hide();
EditWin.setOpacity(1);
}

function SaveUpload()
{
Did = document.getElementById('did').value;
alert('Save '+Did);
}


