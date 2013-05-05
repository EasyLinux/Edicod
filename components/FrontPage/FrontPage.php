<?php
/**
 * Affiche la page d'accueil.
 *   Ce composant fait partie du Framework de l'application. Il affiche la page d'accueil.
 *
 * @package		Edicod
 * @subpackage		Framework
 * @version		1.2
 * @author              Serge NOEL
 *
 * @todo   	Version 2.0 lors de l'affichage dossiers virtuels afficher arborescence
 * @todo		Permettre ajout de contact
 */

include_once("FrontPageDb.php");
include_once("FrontPageLists.php");
include_once("FrontPageAllocate.php");
include_once("FrontPageEdit.php");
include_once("FrontPageDisplay.php");
include_once("FrontPageEditNote.php");

$NumFiles   = 0;	// Nombre de fichiers arrivés
$NumFilOk   = 0;	//   Délai normal
$NumFilWarn = 0;  //   Délai court
$NumFilAtt  = 0;  //   Délai urgent
$ToDeal     = 0;	// Nombre de fichiers à traiter
$ToDealOk   = 0;	//   Délai normal
$ToDealWarn = 0;	//   Délai court
$ToDealAtt  = 0; 	//   Délai urgent
$Waiting    = 0;	// Nombre de fichiers en attente
$WaitOk     = 0;	//   Délai normal
$WaitWarn   = 0;	//   Délai court
$WaitAtt    = 0;	//   Délai urgent


/**
 * Fonction appellée par index.php pour afficher le composant
 *
 * @ignore
 */
function ContentInit($Db, guihtml $Html)
{
	// Nous avons besoin de variables globalesGetWorkFlowStepName
	global $NumFiles, $ToDeal, $Waiting, $WaitOk, $WaitWarn, $WaitAtt, $ToDealOk, $ToDealWarn, $ToDealAtt;
	global $NumFilOk, $NumFilWarn, $NumFilAtt;

	$Script = str_replace($_SERVER["DOCUMENT_ROOT"],"",__FILE__);

	$Html->add_js_file("/js/prototype.js");
	$Html->add_js_file("/js/effects.js");
	$Html->add_js_file("/js/window.js");
	$Html->add_js_file("/js/ajax.js");
	$Html->add_js_file("/js/php.js");
	$Html->add_js_file("/js/calpopup.js");		// Cal
	$Html->add_js_file("/js/dtree.js");
	$Html->add_js_file("/js/info_bulle.js");

	$Html->add_js_file("/components/FrontPage/FrontPage.js");
	$Html->add_js_file("/components/FrontPage/FrontPageEdit.js");
	$Html->add_js_file("/components/FrontPage/FrontPageEditNote.js");
	$Html->add_js_file("/components/Contact/Contact.js");
	$Html->add_js_file("/components/EditFile/EditFile.js");
	$Html->add_js_file("/components/DocFolders/DocFolders.js");
	$Html->add_js_file("/components/UploadFileAttach/UploadFileAttach.js");
	// Chargement, de manière globale à l'application, du fichier js de TinyMCE (courrier départ)
	$Html->add_js_file("/components/EditFile/js/tinymce/jscripts/tiny_mce/tiny_mce.js");

	$Html->add_css("/css/lighting.css");
	$Html->add_css("/css/calendar.css");
	$Html->add_css("/css/default.css");
	$Html->add_css("/css/info_bulle.css");

	$Content = "
<!-- FrontPage : $Script -->

<div class='main'>
  <table border='0' cellspacing='0' cellpadding='0' width='710px'>
    <tr>
      <td class='CadreTopLeft'></td>
      <td class='CadreTop'>Votre r&eacute;sum&eacute;</td>
      <td class='CadreTopRight'></td>
    </tr>
    <tr>
      <td class='CadreLeft'></td>
      <td class='CadreContent'>
        &nbsp;</br><div class='fpTabAll'>\n";

	$MaxTab   = 5;
	$TabInit  = 2;
	/***************
	 * Tabulations *
	 ***************/
	$Content .= "        <!-- Tabulations -->\n";
	if( $_SESSION['User']['Rights'] >= 7 )
	{ // Afficher 'Courriers entrants' et l'afficher par défaut
		$TabInit = 1;
		$Content .= "        <div class='fpTabTitleOff' id='TabHeadFP1' onClick='TabOn(1);' >A affecter</div>\n";
	}
	$Content .= "        <div class='fpTabTitleOff' id='TabHeadFP3' onClick='TabOn(3);' >Pour Information</div>\n";
	$Content .= "        <div class='fpTabTitleOff' id='TabHeadFP2' onClick='TabOn(2);' >A Traiter</div>\n";
	$Content .= "        <div class='fpTabTitleOff' id='TabHeadFP4' onClick='TabOn(4);' >Mon historique</div>\n";
	$Content .= "        <!-- Tabulations -->\n";

	if( $_SESSION['User']['Rights'] >= 7 )
	{ // L'utilisateur est un 'dispatcheur'
		/**************************************************************
		* Afficher Tab 'Courriers entrants' et l'afficher par défaut *
		**************************************************************/
		$Content .= "        <div class='fpTab' id='TabContentFP1'>
          <div class='fpImg'>
            &nbsp;<img src='/img/FrontPage/inbox.png' alt='A Affecter' title='A affecter'/>
          </div>
          <div class='fpTitle'>&nbsp;</div>
          <div class='fpContent'>\n";
		$Content .= ListDispatchDocs($Db);
		$Content .= "          </div>
        </div>\n";
	}

	/***************************
	 * Contenu des tabulations *
	 ***************************/
	// En attente
	$Content .= "        <div class='fpTab' id='TabContentFP2'>
          <div class='fpImg'>
            &nbsp;<img src='/img/FrontPage/to_decide.png' alt='Pour information' title='Pour information'/>
          </div>
          <div class='fpTitle'>&nbsp;</div>
          <div class='fpContent'>\n";
	$Content .= ListWaitingDocs($Db,$_SESSION['User']["uid"]);

	$Content .= "          </div>
        </div>\n";

	// A traiter
	$Content .= "        <div class='fpTab' id='TabContentFP3' >
          <div class='fpImg'>
            &nbsp;<img src='/img/FrontPage/my_documents.png' alt='A traiter' title='A Traiter'/>
          </div>
          <div class='fpTitle'>&nbsp;</div>
          <div class='fpContent'>\n";
	$Content .= ListIncomingDocs($Db,$_SESSION['User']["uid"]);
	$Content .= "          </div>
        </div>\n";

	// Mon historique
	$Content .= "        <div class='fpTab' id='TabContentFP4' >
          <div class='fpImg'>
            &nbsp;<img src='/img/FrontPage/Historique.png' alt='Mon historique' title='Mon historique'/>
          </div>
          <div class='fpTitle'>&nbsp;</div>
          <div class='fpContent'>\n";
	$Content .= ListHistoryDocs($Db,$_SESSION['User']["uid"]);

	$Content .= "          </div>
        </div>\n";

	/****************
	 * Ligne d'Etat *
	 ****************/
	if( $_SESSION['User']['Rights'] >= 7 )
	{ // L'utilisateur est un 'dispatcheur'
		// Afficher le nombre de fichiers à affecter
		$Status = "      <div class='fpFoot'>&nbsp;$NumFiles fichier(s) &agrave; affecter (<span style='color: Green;'>$NumFilOk</span>/";
		$Status .= "<span style='color: Orange;'>$NumFilWarn</span>/<span style='color: Red;'>$NumFilAtt</span>)&nbsp;</div>\n";
	}
	// Nombre de fichier(s) en attente de traitement
	$Status .= "      <div class='fpFoot'>&nbsp;$ToDeal fichier(s) pour information (<span style='color: Green;'>$ToDealOk</span>/";
	$Status .= "<span style='color: Orange;'>$ToDealWarn</span>/<span style='color: Red;'>$ToDealAtt</span>)&nbsp;</div>\n";
	// $ToDealOk, $ToDealWarn, $ToDeal
	$Status .= "      <div class='fpFoot'>&nbsp;$Waiting fichier(s) &agrave; traiter (<span style='color: Green;'>$WaitOk</span>/";
	$Status .= "<span style='color: Orange;'>$WaitWarn</span>/<span style='color: Red;'>$WaitAtt</span>)&nbsp;</div>\n";

	/*******************
	 * Code Javascript *
	 *******************/
	$Content .= "\n
<script type='text/javascript'>
TabInit = $TabInit;
MaxTab  = $MaxTab;

// Fenetre popup
win = new Window('MyPop',{className: \"bluelighting\", closable:false, resizable:false, maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
win.setZIndex(10);
MceInit();

TabOn($TabInit);
</script>\n\n";

	$Content .= "      <div class='fpStatus'>$Status\n";
	$Content .= "      </div>\n";
	$Content .= "      </td>\n";
	$Content .= "      <td class='CadreRight'></td>\n";
	$Content .= "    <tr>\n";
	$Content .= "    </tr>\n";
	$Content .= "      <td class='CadreBottomLeft'></td>\n";
	$Content .= "      <td class='CadreBottom'></td>\n";
	$Content .= "      <td class='CadreBottomRight'></td>\n";
	$Content .= "    <tr>\n";
	$Content .= "  </table>\n</div>\n";
	$Content .= "<div id='overlay_modal' class='overlay_bluelighting' style='position: absolute; top: 0px; left: 0px; z-index: 5; width: 100%; ";
	$Content .= "height: 100%; opacity: 0.6; display: none;'/>\n</div>\n";
	$Content .= "<div id='MyPopup' style='display: none'>\nPOPUP\n</div>\n";
	$Content .= "<div id='Popup2' style='display: none'>\nPOPUP\n</div>\n";
	$Content .= "<div id='Popup3' style='display: none'>\nPOPUP\n</div>\n";
	$Content .= "<div id='DivCalDateIn' style='z-index: 15; opacity: 1.0; position: absolute; background-color: #BFDBFF' ></div>\n";
	$Content .= "<div id='DivCalDateDue' style='z-index: 15; opacity: 1.0; position: absolute; background-color: #BFDBFF' ></div>\n";
	$Content .= "<div id='Status' class='Status'></div><!-- /FrontPage -->\n\n";

	return $Content;
}




/**
 * Fonction récursive d'analyse de répertoire
 * @todo Documenter

 function MyScan($Path,$Root)
 {
 $Ret = "";

 $Dir = opendir($Path);
 while ( ($File = readdir($Dir)) !== false)
 {
 if( !($File == "." || $File == "..") )
 {
 if( is_dir("$Path/$File") )
 {
 $RelPath = str_replace($Root,"","$Path/$File");
 $Ret .= "      <option value='$RelPath'>$RelPath/</option>\n";
 $Ret .= MyScan("$Path/$File",$Root);
 }
 }
 }
 closedir($Dir);
 return $Ret;
 }
 */

/**
 * Affiche les entrées de journal d'un document
 * @param	objet	Objet de résultat de logs
 * @return	string	Chaine à afficher (code HTML)
 */
function PrintLogs($Logs)
{
	$Style="display: block; float: left; border-bottom: 1px dashed gray; border-right: 1px dashed gray";
	$StyleHeader = "border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid gray";
	$StyleHeadC  = "display: block; float: left";
	$BorderContent = "border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;";
	$Html = "
<script language='text/javascript'>
alert('A retirer : Frontpage.php - PrintLogs ');
<div id='Tableau'>
 <div style='width: 790px; height: 15px; $StyleHeader' >
  <span style='width: 85px; border-right: 1px solid gray; font-weight: bold; $StyleHeadC'>&nbsp;Date</span>
  <span style='width: 65px; border-right: 1px solid gray; font-weight: bold; $StyleHeadC'>&nbsp;Heure</span>
  <span style='width: 145px; border-right: 1px solid gray; font-weight: bold; $StyleHeadC'>&nbsp;Qui</span>
  <span style='width: 465px; font-weight: bold; $StyleHeadC'>&nbsp;Acc&egrave;s</span>
 </div>
 <div style='width: 790px; height: 220px; overflow-y: scroll; $BorderContent'>\n";
	foreach($Logs as $Log)
	{
		$Date  = substr($Log->timestamp,8,2) . "/" . substr($Log->timestamp,5,2) . "/" .substr($Log->timestamp,0,4);
		$Heure = substr($Log->timestamp,11,2) . ":" . substr($Log->timestamp,14,2) . ":" .substr($Log->timestamp,17,2);
		$User  = $Log->name . " " . $Log->given_name;
		$Desc  = $Log->description;
		$Html .= "  <div >\n   <span style='width: 85px; $Style'>&nbsp;$Date</span>\n   <span style='width: 65px; $Style'>&nbsp;$Heure</span>
   <span style='width: 145px; $Style'>&nbsp;$User</span>\n   <span style='width: 465px; $Style'>&nbsp;$Desc</span>\n  </div>\n";
	}
	$Html .= " </div>
</div>
<div>
  <span class='formButtonsItem' style='width: 750px;' >
  </span>
  <span class='formButtonsItem' >
    <img src='/img/FrontPage/cancel.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='AbortLogs();' />
  </span>
</div>\n";
	return( $Html );
}

/**
 * Lier deux documents.
 * @param int $did1 Identifiant du premier document.
 * @param int $did2 Identifiant du deuxieme document.
 */
function addLink($did1, $did2)
{
	$Db = new db($_SESSION['Parameters']['SqlEngine'], $_SESSION['Parameters']['SqlSrv'], $_SESSION['Parameters']['SqlBase'],
	$_SESSION['Parameters']['SqlUsr'] , $_SESSION['Parameters']['SqlPwd']);
	$Sql = "INSERT INTO doclink SET did1=".$did1."did1=".$did2;
	$Db->Query($Sql);
	$Db->Close();
}

/**
 * Supprimer le lien entre deux documents.
 * @param int $did1
 * @param int $did2
 */
function deleteLink($did1, $did2)
{
	$Db = new db($_SESSION['Parameters']['SqlEngine'], $_SESSION['Parameters']['SqlSrv'], $_SESSION['Parameters']['SqlBase'],
	$_SESSION['Parameters']['SqlUsr'] , $_SESSION['Parameters']['SqlPwd']);
	$Sql = "DELETE FROM doclink WHERE did1=".$did1."did2=".$did2;
	$Db->Query($Sql);
	$Db->Close();
}

/**
 * Retourne le fil d'ariane
 */
function GetFilAriane2($Db, $Did, $Actual)
{
	// A partir de l'étape en cours, nous cherchons le workflow correspondant
	$Sql  = "SELECT * ";
	$Sql .= "FROM workflow AS wf, wf_steps AS wfs ";
	$Sql .= "WHERE wfs.wid=wf.wid AND wfs.wfsid=$Actual ;";
	$Db->Query($Sql);
	$Rep  = $Db->loadObject();
	$Wid = $Rep->wid;
	$CurrentOrder = $Rep->myorder;
	
	$Ariane = "<span style='font-weight: bold; color: Gray'>".GetWorkflow($Db,$Actual)."</span><br />";
	
	$Sql = "SELECT * FROM wf_steps WHERE wid=$Wid ORDER BY myorder ASC";
	$Db->Query($Sql);
	$Reps = $Db->loadObjectList();
	
	foreach($Reps as $Rep)
	{
		$Sql2  = "SELECT * ";
		$Sql2 .= "FROM wf_details ";
		$Sql2 .= "WHERE wfsid=$Rep->wfsid AND actor=1 ;";
		$Db->Query($Sql2);
		$Rows = $Db->loadObjectList();
		foreach($Rows as $Row) {
			$guid = substr($Row->guid,1);
			$typeUserGroup = substr($Row->guid,0,1);
			
			//echo $Row->guid." ";
			//echo $typeUserGroup;
			
			if($typeUserGroup == "U") {
				$Sql3  = "SELECT * ";
				$Sql3 .= "FROM user ";
				$Sql3 .= "WHERE uid=$guid ;";
				$Db->Query($Sql3);
				$ligne  = $Db->loadObject();
				$login = "(".$ligne->login.")";
			}
			else {
				$Sql3  = "SELECT * ";
				$Sql3 .= "FROM groups ";
				$Sql3 .= "WHERE gid=$guid ;";
				$Db->Query($Sql3);
				$ligne  = $Db->loadObject();
				$login = "(".$ligne->name.")";
			}
			//echo $login." ,";
		}
		
		if($Rep->myorder == $CurrentOrder) {
			$Ariane .= "<span style='color: Green'>".$Rep->description.$login."</span> -&gt; ";
		}
		else if($Rep->myorder < $CurrentOrder) {	
			//$MyDate = substr($Rep->timestamp,8,2)."/".substr($Rep->timestamp,5,2)."/".substr($Rep->timestamp,0,4);
			$Ariane .= "<b><s>".$Rep->description.$login."</s></b> -&gt; ";
		}
		else {
			$Ariane .= $Rep->description.$login." -&gt; ";
		}
		
		$login = "";
	}
	
	return substr($Ariane,0,-7);
	//return $Ariane;
}

function GetFilAriane($Db, $Did, $Actual)
{
	// A partir de l'étape en cours, nous cherchons le workflow correspondant
	$Sql  = "SELECT *";
	$Sql .= "FROM workflow AS wf, wf_steps AS wfs ";
	$Sql .= "WHERE wfs.wid=wf.wid AND wfs.wfsid=$Actual ;";
	$Db->Query($Sql);
	$Rep  = $Db->loadObject();
	$Wid = $Rep->wid;
	$CurrentOrder = $Rep->myorder;
	
	// Nous listons toutes les étapes du workflow
	$Sql = "SELECT * FROM wf_steps WHERE wid=$Wid ORDER BY myorder ASC";

	$Sql = "SELECT *";
	$Sql .= "FROM doclog as dl, wf_steps as wfs ";
	$Sql .= "WHERE did=$Did AND action > 0 AND dl.action=wfs.wfsid ";
	$Sql .= "ORDER BY timestamp;";
	$Db->Query($Sql);
	$Reps = $Db->loadObjectList();
	$Ariane = "<span style='font-weight: bold; color: Gray'>".GetWorkflow($Db,$Actual)."</span><br />";

	// Toutes les étapes passées ont une date
	foreach($Reps as $Rep)
	{
		$MyDate = substr($Rep->timestamp,8,2)."/".substr($Rep->timestamp,5,2)."/".substr($Rep->timestamp,0,4);
		if($Rep->wfsid == $Actual){
			//$Ariane .= "<span style='color: Green'>".$Rep->description."</span> -&gt; ";
		}
		else  {
			$Ariane .= "<b>".$Rep->description."</b> ($MyDate) -&gt; ";
		}
	}
	
	// Regardons l'étape actuelle
	$Sql = "SELECT * FROM wf_steps WHERE wfsid=$Actual ";
	$Db->Query($Sql);
	$Rep  = $Db->loadObject();
	$Ariane .= "<span style='color: Green'>".$Rep->description."</span> -&gt; ";
	
	// Regardons maintenant les étapes futures
	// Nous listons toutes les étapes du workflow
	$Sql = "SELECT * ";
	$Sql .= "FROM wf_steps ";
	$Sql .= "WHERE wid=$Wid AND myorder>$CurrentOrder ";
	$Sql .= "ORDER BY myorder ASC;";
	$Db->Query($Sql);
	$Reps = $Db->loadObjectList();

	//$Done=true;
	foreach($Reps as $Rep)
	{
		//if($Rep->wfsid == $Actual) {
		//	$Done = false;
		//}
		//elseif( !$Done ) {
			$Ariane .= $Rep->description . " -&gt; ";
			
		//}
	}
	return substr($Ariane,0,-7);
}

/**
 * Retourne la date de classement
 */
function GetDateDone($Db, $Did, $Actual)
{
	$Sql = "SELECT * FROM doclog as dl, wf_steps as wfs WHERE did=$Did AND action=$Actual;";
	$Db->Query($Sql);
	$Rep = $Db->loadObject();
	$MyDate = substr($Rep->timestamp,8,2)."/".substr($Rep->timestamp,5,2)."/".substr($Rep->timestamp,0,4);
	return ($MyDate);
}

/* Coeur du module,
 * dispatch selon besoin,
 * Partie Ajax
 * @todo  lors de l'édition loguer qui modifie l'étape !!!!
 * @todo  Changement d'étape semi-automatique
 */
@session_start();
if( isset($_GET["Option"]) )
$Option = $_GET['Option'];
else
if( isset($_POST["Option"]) )
$Option = $_POST['Option'];
$BaseURL = $_SERVER["DOCUMENT_ROOT"];
require_once("$BaseURL/inc/Db.Inc.php");
require_once("$BaseURL/inc/lib.inc.php");
require_once("$BaseURL/inc/Contact.Inc.php");
require_once("$BaseURL/inc/IndexFile.php");


$Db = new db($_SESSION['Parameters']['SqlEngine'], $_SESSION['Parameters']['SqlSrv'], $_SESSION['Parameters']['SqlBase'],
$_SESSION['Parameters']['SqlUsr'] , $_SESSION['Parameters']['SqlPwd']);

switch( $Option )
{
	case 'AllocateFile':
		// On clique sur un document à allouer
		$Did = $_GET["Did"];
		$Sql = "INSERT INTO doclog SET did=$Did, description='Consultation du document', uid=".$_SESSION['User']['uid'].";";
		$Db->Query($Sql);
		print AllocateFile($Db, $Did);
		break;

	case 'EditFile':
		// Edition des propriétés d'un document
		$ID = $_GET["id"];
		print EditFile($Db, $ID);
		break;

	case 'DisplayFile':
		// Affichage des propriétés d'un document (appelé par DocFolders)
		$ID = $_GET["id"];
		print DisplayFile($Db, $ID);
		break;

	case 'DisplayListeNote':
		$ID = $_GET["id"];
		$parentWindowId = $_GET["parentWindowId"];
		$content = DisplayListNote($parentWindowId, $Db, $ID);
		print $content;
		break;

	case 'AllocateSave':
		// Récupérer les données
		$Sql = "UPDATE documents SET ";
		foreach( array_keys($_POST) as $Key )
		{
			switch ($Key )
			{
				case "did":
					$Did = $_POST[$Key];
					break;

				case "path":
					//$Sql .= "path='/" .substr(urldecode($_POST[$Key]),strlen($_SESSION["Parameters"]["AbsoluteDocuments"]) +1)."', ";
					$Sql .= "$Key='". $_POST[$Key]."', ";
					break;

				case "cabid":

				case "wfsid":
					$Sql .= "$Key=". $_POST[$Key].", ";
					break;
				case "conidAllocate":
					$Sql .= "conid=". $_POST[$Key].", ";
					break;

				default:
					$Sql .= "$Key='".urldecode($_POST[$Key])."', ";
					break;
			}
		}
		
		$Sql = substr($Sql,0,strlen($Sql)-2);
		$Sql .= " WHERE did=$Did ;";
		$WorkFlow = GetWorkflow($Db, $_POST['wfsid']);
		$Db->Query($Sql);
		// Remettre à jour la liste des mots clés correspondant au sujet
		$Sql = "DELETE FROM dockeywords WHERE did=$Did AND wichparts=1;";
		$Db->Query($Sql);
		IndexWords($Db, urldecode($_POST["object"]), $Did, 1);
		$Sql = "INSERT INTO doclog SET did=$Did, description='Document affect&eacute; (Workflow: $WorkFlow)', uid=".$_SESSION['User']['uid'].", action=".$_POST['wfsid']." ;";
		$Db->Query($Sql);
		print "Donn&eacute;es mises &agrave; jour";
		//$Db->Close();

		//récupération du nom du fichier
		$Sql = "SELECT * FROM documents WHERE did=$Did;";
		$Db->Query($Sql);
		$Row = $Db->loadObject();
		$DocName = $Row->name;
		$Db->Close();

		// déplacer le fichier
		$OldName = $_SESSION["Parameters"]["AbsoluteDocuments"] . $_SESSION["Parameters"]["IncomingPath"] ."/".$DocName;
		$NewName = urldecode($_POST["path"])."/".$DocName;

		/* Pour le debug
		 if(file_exists($OldName)) {
		 $fileExist = "Le fichier : ".$OldName. " éxiste !\n";
		 }
		 else {
		 $fileExist = "Le fichier : ".$OldName. " n'éxiste pas !\n";
		 }

		 $monFic = fopen("/Edicod/Input/monFic.txt", "a+");
		 fputs($monFic, "Name : ".$DocName."\r\n");
		 fputs($monFic, "OldName : ".$OldName."\r\n");
		 fputs($monFic, "NewName : ".$NewName."\r\n");
		 fputs($monFic, $fileExist);
		 fclose($monFic);
		 ****************/
		rename($OldName,$NewName);
		 
		/* Pour le debug
		 if(file_exists($NewName)) {
		 $fileExist2 = "Le fichier : ".$NewName. " éxiste !\n";
		 }
		 else {
		 $fileExist2 = "Le fichier : ".$NewName. " n'éxiste pas !\n";
		 }

		 $monFic = fopen("/Edicod/Input/monFic.txt", "a+");
		 fputs($monFic, $fileExist2);
		 fclose($monFic);
		 ****************/

		break;

	case 'EditSave':
		// Récupérer les données
		$Sql = "UPDATE documents SET ";
		foreach( array_keys($_POST) as $Key )
		{
			switch ($Key )
			{
				case 'option':
					break;

				case "did":
					$Did = $_POST[$Key];
					break;

				case "object":
					$Sql .= "$Key='". $_POST[$Key]."', ";
					break;

				default:
					$Sql .= "$Key='".urldecode($_POST[$Key])."', ";
					break;
			}
		}
		$Sql = substr($Sql,0,strlen($Sql)-2);
		$Sql .= " WHERE did=$Did ;";

		echo '<br /><u>SQL : '.$Sql.'</u><br />';

		// Nous allons déterminer ce qui a changé (on a besoin de l'ancien enregistrement)
		$OldSql = "SELECT * FROM documents WHERE did=$Did";
		$Db->Query($OldSql);
		$Before = $Db->loadObject();

		// Effectuons la mise à jour
		$Db->Query($Sql);

		// Générer un message avec les modifications apportées
		$LogMsg = "";
		if( $Before->wfsid != $_POST["wfsid"] )
		{
			$BeforeName = GetWorkFlowStepName($Db,$Before->wfsid);
			$AfterName  = GetWorkFlowStepName($Db,$_POST["wfsid"]);
			$LogMsg = "Changement d''&eacute;tape ($BeforeName -&gt; $AfterName)";
		}
		elseif( !empty($_POST["date_in"]) && ($Before->date_in != $_POST["date_in"]) )
		$LogMsg = "Date d'arrivee";
		else
		$LogMsg = "Document modifi&eacute;";
		$Sql = "INSERT INTO doclog SET did=$Did, description='$LogMsg', uid=".$_SESSION['User']['uid']." ;";
		$Db->Query($Sql);
		print "<br />Donn&eacute;es mises &agrave; jour <br />";
		$Db->Close();

		// déplacer le fichier
		$OldPath = $_SESSION["Parameters"]["AbsoluteDocuments"] . $Before->path;
		$NewPath = $_SESSION["Parameters"]["AbsoluteDocuments"] . urldecode($_POST["path"]);
		if( !empty($NewPath) && ($NewPath != $OldPath) )
		rename( $OldPath, $NewPath );

		break;

	case 'SaveNextStep':
		$Did = $_POST["did"];
		// Nous allons récupérer le WfsId courant
		$OldSql = "SELECT * FROM documents WHERE did=$Did";
		$Db->Query($OldSql);
		$Before = $Db->loadObject();
		$AfterWfsId = GetNextWorkflowStep($Db,$Before->wfsid);

		// Récupérer les données
		$Sql = "UPDATE documents SET ";
		foreach( array_keys($_POST) as $Key )
		{
			switch ($Key )
			{
				case 'option':
					break;

				case "did":
					$Did = $_POST[$Key];
					break;

				default:
					$Sql .= "$Key='".urldecode($_POST[$Key])."', ";
					break;
			}
		}
		//$Sql = substr($Sql,0,strlen($Sql)-2);
		$Sql .= "wfsid=$AfterWfsId";
		
		if(IsLastStep($Db,$AfterWfsId)) {
			$Sql .= ", date_out='".date("Y-m-d")."'";
		}
		
		$Sql .= " WHERE did=$Did ;";
		// Effectuons la mise à jour
		$Db->Query($Sql);

		if( $Before->object != $_POST["object"] )
		{
			// Remettre à jour la liste des mots clés correspondant au sujet
			$Sql = "DELETE FROM dockeywords WHERE did=$Did AND wichparts=1;";
			$Db->Query($Sql);
			IndexWords($Db, urldecode($_POST["object"]), $Did, 1);
		}

		// Générer un message avec les modifications apportées
		$LogMsg = "";
		$BeforeName = GetWorkFlowStepName($Db,$Before->wfsid);
		$AfterName  = GetWorkFlowStepName($Db,$AfterWfsId);
		$LogMsg = "Changement d''&eacute;tape ($BeforeName -&gt; $AfterName)";

		$Sql = "INSERT INTO doclog SET did=$Did, description='$LogMsg', uid=".$_SESSION['User']['uid']." ;";
		$Db->Query($Sql);
		print "<br />Donn&eacute;es mises &agrave; jour <br />";
		$Db->Close();
		
		break;

	case 'Log':
		$Sql = "SELECT * FROM doclog, user WHERE user.uid = doclog.uid AND did=". $_GET["Did"]." ORDER BY timestamp;";
		$Db->Query($Sql);
		$Logs = $Db->loadObjectList();
		print PrintLogs($Logs);
		break;

	case 'Notes':
		$Notes = GetNotes($Db, $_GET["Did"]);
		print PrintNotes($Notes);
		break;

	case 'Note':
		print AddNote();
		break;

	case 'SaveNote':
		$Sql = "INSERT INTO docnote SET uid=".$_SESSION["User"]["uid"]." ,did=". $_GET["Did"]." , note='". addslashes(urldecode($_GET["Description"]))."'; ";
		$Db->Query($Sql);
		$Notes = GetNotes($Db, $_GET["Did"]);
		print PrintNotes($Notes);
		break;

	case 'AddVirtualFolder':
		// !! Il est normal que cette insertion puisse etre en erreur, si doublon
		$Sql = "INSERT INTO docfolders SET fid=".$_GET['Fid'].", did=".$_GET['Did']." ;";
		$Db->Query($Sql);
		echo $Sql;
		break;

	case 'DelVirtualFolder':
		$Sql = "DELETE FROM docfolders WHERE fid=".$_GET['Fid']." AND did=".$_GET['Did']." ;";
		$Db->Query($Sql);
		echo $Sql;
		break;

	case 'GetVirtualFolders':
		echo GetDocFolders($Db,$_GET['Did']);
		break;

	case 'Keywords':
		require_once("$BaseURL/inc/IndexFile.php");
		// Remettre à zéro les mots clés car si suppression, il faut retirer de la liste
		$Sql = "DELETE FROM dockeywords WHERE did=". $_POST["Did"] ." AND wichparts=2;";
		$Db->Query($Sql);
		IndexWords($Db, urldecode($_POST["Keywords"]), $_POST["Did"], 2);
		break;

	case 'GetSteps':
		$String="";
		$Sql = "SELECT * FROM wf_steps WHERE wid=". $_GET["Id"] ." ORDER BY myorder;";
		$Db->Query($Sql);
		$Steps = $Db->loadObjectList();
		foreach( $Steps as $Step )
		$String .= $Step->wfsid . "#" . $Step->description . "|";
		print $String;
		break;

	case 'HaveFolders':
		// Vérifie que des dossiers virtuels existent
		$Sql = "SELECT * FROM docfolders WHERE did=". $_GET["did"].";";
		$Db->Query($Sql);
		if( $Db->NumRows() == 0 )
		print "Aucun dossier virtuel";
		break;

	case 'AddLink':
		addLink($_GET["did1"], $_GET["did2"]);
		break;

	case 'deleteLink':
		deleteLink($_GET["did1"], $_GET["did2"]);
		break;

	case 'ReloadListResponses':
		print loadListResponses($Db, $_GET["did"]);
		break;
	case 'ReloadListFileAttach':
		print loadListFileAttach($Db, $_GET["did"]);
		break;

	default:
		// !!!!!!!!!!!!!!!!!!!!!!!! DEBUG !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		//    print "$Option : Non d&eacute;fini";
		break;
}




?>

