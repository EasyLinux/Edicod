<?php
/**
 * Editer un document
 * 
 * @package		Composants
 * @subpackage		EditFile
 * @access		public
 * @version		0.9
 * @author              Greg PIONNIER
 *
 * @todo		A valider
 */
 
/**
 * Fonction appellée par index.php pour afficher le composant
 * Cette fonction renvoit une chaine HTML qui sera la partie affichée
 *
 * @ignore
 */
function ContentInit($Db, $Html)
{
$Html->add_css("/css/default.css");
$Html->add_css("/css/lighting.css");

$Html->add_js_file("/js/prototype.js");
$Html->add_js_file("/js/effects.js");
$Html->add_js_file("/js/window.js");
$Html->add_js_file("/js/ajax.js");
$Html->add_js_file("/js/php.js");
$Html->add_js_file("/js/calpopup.js");
$Html->add_js_file("/js/dtree.js");
$Html->add_js_file("/components/EditFile/EditFile.js");

$HTML="";
/*
$HTML = "
<!-- EditFile -->
<div class='main' >
<table border='0' cellspacing='0' cellpadding='0' width='880px'>
  <tr>
    <td class='CadreTopLeft'></td>
    <td class='CadreTop'>Editer un document</td>
    <td class='CadreTopRight'></td>
  </tr>
  <tr>
    <td class='CadreLeft'></td>
    <td class='CadreContent'>
      <form name='EditFile' id='EditFile' action='/components/EditFile/EditFile.php?Option=SaveDocument' method='post' enctype='multipart/form-data'>
        <input type='hidden' name='ddid' value='' />
        <fieldset>
          <legend>Document</legend>
          <div>
            <span class='fpPopDiv1' style='width: 120px'><label for='name'>Nom fichier</label></span>
            <span class='fpPopDiv2' style='width: 300px'>
              <input type='file' id='name' /></span>
            <span class='fpPopDiv1' style='width: 120px'><label for='object'>Objet</label></span>
            <span class='fpPopDiv2' style='width: 280px'>
              <input class='fpPopInp2' style='width: 270px' type='text' name='object' />
            </span>
          </div>
          <div>
            <span class='fpPopDiv1' style='width: 120px' ><label for='date_out'>Date envoi</label></span>
            <span class='fpPopDiv2' style='width: 300px;'>
              <img src='/img/AddDocument/Cal.png' onClick=\"showCalendar('date_out', '%d/%m/%Y');\" alt='Afficher calendrier' title='Afficher calendrier' style='float: left; cursor: pointer' />&nbsp;
              <input class='fpPopInp2' type='text' style='margin-left: 10px;' name='date_out' id='date_out' style='width: 80px' />
            </span>
            <span class='fpPopDiv2' style='width: 120px;' >&nbsp;</span>
            <span class='fpPopDiv2' style='width: 280px;' >&nbsp;</span>
          </div>
          <div>
            <!-- Stockage doit signaler un ou plusieurs répertoires virtuels !!!! -->
            <span class='fpPopDiv1' style='width: 120px'>Stockage</span>
            <span class='fpPopDiv2' style='width: 300px'>
              <img src='/img/AddDocument/folder.png' alt='Repertoire' title='Repertoire' style='float: left; cursor: pointer' onClick='DisplayFolders();' />&nbsp;
              <input class='fpPopInp2' style='width: 240px; margin-left: 10px;' type='text' name='folder' value='' id='folder' readonly='readonly' /></span>
            <span class='fpPopDiv1' style='width: 120px'>Emplacement</span>
            <span class='fpPopDiv2' style='width: 280px'>
              <img src='/img/AddDocument/armoire.png' alt='Armoire' title='Armoire' style='float: left; cursor: pointer' onClick='DisplayCabinet();'/>&nbsp;
              <input class='fpPopInp2' style='width: 230px;Find margin-left: 10px;' type='text' name='box' id='box' />
              <input type='hidden' id='boxid' name='boxid' />
            </span>
          </div>
        </fieldset>
      
      <fieldset>
        <legend>Distribution</legend>
          <div class='fpPopDiv1'>R&eacute;f&eacute;rence</div>
          <div class='fpPopDiv2' style='width: 300px'>   
            <img src='/img/AddDocument/dossiers.png' alt='Dossiers' title='Dossiers' style='float: left; cursor: pointer' onClick='DisplayDocFolders();' />&nbsp;
            <input type='text' class='fpPopInp2' style='width: 240px; margin-left: 10px' name='fids' readonly='readonly' />
            <input type='hidden' id='fids' name='fids' />
          </div>
          <div class='fpPopDiv1'></div>
          <div class='fpPopDiv2' style='width: 270px'>
          </div>
        </fieldset>
        <fieldset>
          <legend>Mots cl&eacute;s</legend>
          <textarea name='keywords' class='fpComment' style='width: 800px; height: 120px;'></textarea>
        </fieldset>
      
      </form>
      <div class='formButtons2' style='width:850px'>
        <!--<span class='formButtonsItem' style='width: 19%; margin-left: 10px' >
        </span>
        <span class='formButtonsItem' style='width: 19%; margin-left: 10px' >
        </span>
        <span class='formButtonsItem' style='width: 19%; margin-left: 10px' >
        </span>-->
        <span class='formButtonsItemR'>
          <img src='/img/Chrono/door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='ADQuit();' />
        </span>
        <span class='formButtonsItemR'>
          <img src='/img/Chrono/filesave.png' class='ImgButton' alt='Sauvegarder' title='Sauvegarder' onClick='document.getElementById(\"AddDocument\").submit();' />
        </span>        
      </div>
    </td>
    <td class='CadreRight'></td>
  <tr>
  </tr>
    <td class='CadreBottomLeft'></td>
    <td class='CadreBottom'></td>
    <td class='CadreBottomRight'></td>
  <tr>
  </tr>
</table>
</div>
<div id='overlay_modal' class='overlay_bluelighting' 
     style='position: absolute; top: 0px; left: 0px; z-index: 5; width: 100%; height: 100%; opacity: 0.6; display: none;'>
</div>
<!-- EditFile -->\n"; */
return $HTML;
}

/**
 * Respond sert à générer le code du Popup qui apparaît lors de la réponse à un message.
 *   Cette fonction est appelée depuis les parties de codes (Ajax) qui nécessitent de disposer de la capacité à
 *   créer un courrier.
 *
 * @param	int	    identifiant du document parent
 * @return	string	Chaîne HTML 
 *
 * @todo voir si détermination de template par défaut (ds LDap )
 */

/**
 *  Respond sert à générer le code du Popup qui apparaît lors de la réponse à un message.
 *   Cette fonction est appelée depuis les parties de codes (Ajax) qui nécessitent de disposer de la capacité à
 *   créer un courrier.
 * @param int $parentWindowId identifiant de la fenêtre parente.
 * @param db $Db
 * @param int  $id identifiant du document auquel répondre dans le cas d'une création.
 * identifiant de la réponse dans le cas d'une modification de brouillon.
 * @param bool $update mettre à true pour un modification de brouillon déjà existant.
 * @return string
 */
function Respond($parentWindowId ,$Db, $id, $update)
{
    $Row = null;
    if($update)
    {
        $Sql = "SELECT * FROM docdraft WHERE ddid='$id';";
        $Db->Query($Sql);
        $Row = $Db->loadArray();
    
    	$Object = $Row["objet"];
    }
    else
    { // pas de brouillon -> par défaut
        $Sql = "SELECT name,conid,object FROM documents WHERE did=$id";
        $Db->Query($Sql);
        $DocRow = $Db->loadArray();
        
        $Row["ddid"]=0;
        $Row["did"]=$id;
        $Row["name"]="Re-".$DocRow["name"];
        $Row["path"]="";
        $Row["wfsid"]="";
        $Row["guid"]="";
        $Row["conid"]=$DocRow["conid"];
        
        $Row["objet"]=$DocRow["object"];
        $Object = $Row["objet"];
        
        $Row["recptnum"]="";
        $Row["mid"]=0;
        $Row["content"]="";
        $Row["description"]="";
    }
    if( $Row["receptnum"] == "")
        $ARImg = "AROff.png";
    else
        $ARImg = "AROn.png";

    $HTML = "
    <!-- Fenetre parente -->
    <input type='hidden' id='parentEditFile' value='".$parentWindowId."' />
    <!-- Respond -->
    <form id='Respond' method='post' action='#'>
    <input type='hidden' name='ddid' id='ddid' value='".$Row["ddid"]."' />
    <input type='hidden' name='Rname' id='Rname' value='".$Row["name"]."' />
    <input type='hidden' name='did' id='did' value='".$Row["did"]."' />
    <input type=\"hidden\" name=\"savePdf\" id=\"savePdf\" />
      <fieldset>
        <legend>Coordonnées</legend>
        <div>
          <span class='fpPopDiv1' style='width: 130px'>Exp&eacute;diteur</span>
          <span class='fpPopDiv2' style='width: 230px;'>
            " . GetSenderOptions($Row["guid"]) . "</span>
          <span class='fpPopDiv1' style='width: 130px'>Destinataire</span>
          <span class='fpPopDiv2' style='width: 200px;'>
            <img src='/img/FrontPage/User.png' onClick=\"DisplayContacts(RespondWin,'Rconid', 'RespondTo');\" alt='Choisir expéditeur' title='Choisir expéditeur' class='ImgButton' />
            <input type='text' class='fpPopInp2Gray' style='width: 165px' id='RespondTo' value='' readonly='readonly' />
            <input type='hidden' name='Rconid' id='Rconid' value='".$Row["conid"]."' /></span>
        </div>
        <div>
          <span class='fpPopDiv1' style='width: 130px'>Objet</span>
          <span class='fpPopDiv2' style='width: 230px;'>
            <input type='text' class='fpPopInp2' style='width: 180px' name='RObject' id='RObject' value='".$Object."' /></span>
          <span class='fpPopDiv1' style='width: 130px'>Accus&eacute; r&eacute;ception</span>
          <span class='fpPopDiv2' style='width: 200px'>
            <img src='/img/FrontPage/$ARImg' alt='Accusé de réception' title='Accusé de réception' class='ImgButton' id='RAimg' onClick=\"alert('Accusé réception');\" />
            <input class='fpPopInp2Gray' style='width: 165px;' type='text' name='Rreceptnum' id='Rreceptnum' value='". $Row["recptnum"]. "'/>
          </span>
        </div>
        <div>
        <span class='fpPopDiv1' style='width: 130px'>Description</span>
            <span class='fpPopDiv2' style='width: 230px;'>
            <input type='text' class='fpPopInp2' style='width: 180px' name='description' id='description' value='".$Row["description"]."' /></span>
        </div>
      </fieldset>
      <fieldset>
        <legend>Mod&egrave;le de lettre</legend>
        <span class='fpPopDiv1' style='width: 130px'>Modèle</span>
        <span class='fpPopDiv2' style='width: 230px;'>
          <img src='/img/FrontPage/document.png' onClick=\"alert('Choix');\" alt='Choisir courrier type' title='Choisir courrier type' class='ImgButton' />
          <input type='text' class='fpPopInp2' style='width: 155px' id='RTemplate' value='' readonly='readonly' />
          <input type='hidden' id='mid' name='mid' value='".$Row["mid"]."' /></span>
      </fieldset>
      <fieldset>
        <legend>Contenu</legend>
        <textarea id='content' name='content' style='width: 100%; height: 300px;'>".$Row["content"]."</textarea>
      </fieldset>
    </form>
    <div class='formButtons2' style='width:730px;'>
      <span class='formButtonsItemL' style='margin-left: 20px' >
       <img src='/img/FrontPage/Preview.png' class='ImgButton' alt='Aperçu avant impression.' title='Aperçu avant impression. (Cela ne sauvegardera pas le fichier PDF.)' onClick='ShowDraft();' />
      </span>
      
      <div class='formButtonsItemR'>
        <img src='/img/EditFile/Door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='AbortRespond();' />
      </div>";

	if($parentWindowId == 'EditFileWin') {
		  $HTML .= "
		  <div class='formButtonsItemR'>
	        <img src='/img/EditFile/Save.png' class='ImgButton' alt='Sauvegarder' title='Sauvegarder le brouillon (Cela ne créera pas de fichier PDF)' onClick='SaveDraft();' />
	      </div>";
    }    
    
    if($Row["ddid"] == 0) // Teste si l'utilisateur peut enregistré la réponse (Si un brouillon a été enregistré avant)
    {
        $displaySave = "style=\"display:none;\"";
        $displaySaveGray = "";
    }
    else
    {
        $displaySave = "";
        $displaySaveGray = "style=\"display:none;\"";
    }
    
    /* **** Sauvegarde finale qui n'a pas lieu d'être dans la fenêtre édition de réponses **** 
    $HTML .=  "<div id=\"div-save-resp-ok\" ".$displaySave." class='formButtonsItemR'>
        <img src='/img/EditFile/SaveOk.png' class='ImgButton' alt='Sauvegarder' title='Afficher et enregistrer le courrier (Vous ne pourrez plus le modifier par la suite)' onClick='SaveRespond();' />
      </div>"; *
    
    $HTML .=  "<div id=\"div-save-resp-ok-gray\" ".$displaySaveGray." class='formButtonsItemR'>
        <img src='/img/EditFile/SaveOkGray.png' class='ImgButton' alt='Sauvegarder' title='Afficher et enregistrer le courrier (Vous ne pourrez plus le modifier par la suite)' onClick=\"alert('Vous devez d\'abord enregistrer un brouillon');\" />
      </div>";
    */

    $HTML .= "</div>
    <script type='text/javascript'>
    // Chargement à la demande de TinyMCE
    ChargerTinyMCE('content');
    Sender = document.getElementById('Sender').value;
    document.getElementById('RespondTo').value = Sender;
    </script>
    <!-- Respond -->\n";
    return $HTML;
}

function GetSenderOptions($Guid)
{
    $Options =  "  <select name='RespondSender' id='RespondSender' class='fpPopInp2' style='width: 185px;' >\n";
    $cGuid = "U".$_SESSION["User"]["uid"];
    if( $cGuid == $Guid || $Guid == "")
      $Sel = "selected='selected'";
    $Options .= "    <option value='$cGuid' $Sel>".$_SESSION["User"]["UserName"]." ".$_SESSION["User"]["GivenName"]."</option>\n";
    foreach( $_SESSION["User"]["Groups"] as $Group )
      {
      $Sel="";
      $cGuid = "G".$Group->gid;
      if( $cGuid == $Guid )
        $Sel = "selected='selected'";
      $Options .= "    <option value='$cGuid' >".$Group->name."</option>\n";
      }
    $Options .= "  </select> ";
    return($Options);
}


function SaveDraft(db $Db, $ddid, $did, $guid, $conid, $mid, $name, $object, $receptnum, $content, $description, $exist)
{
    $SqlPart  = "guid='".$guid."', conid=".$conid.", name='".urldecode($name)."', mid=" .$mid.", description='".urldecode($description)."'";
    $SqlPart .= ", objet='". urldecode($object)."'";
    
    if($receptnum != "" ) {
      $SqlPart .= ", receptnum='" .urldecode($receptnum) . "'";
    }
    
    $SqlPart .= ", content='".urldecode($content)."'";
    
    if($exist == "false")
    {
      $Sql = "INSERT INTO docdraft SET did=".$did. ", " .$SqlPart .";" ;
      $Db->Query($Sql);
      $ddid = $Db->GetLastId();
    }
    else
    {
      $Sql = "UPDATE docdraft SET $SqlPart WHERE ddid=".$ddid. " ;";
      $Db->Query($Sql);
    }
    
    echo $ddid;
}

function DeleteDraft(db $Db, $ddid)
{
    $Sql = "DELETE FROM docdraft WHERE ddid=".$ddid;
    $Db->Query($Sql);
}

/* Partie Ajax */
session_start();

require_once 'inc/ResponsePdf.class.php';
$Option = $_GET['Option'];
if( empty($Option) )
  $Option = $_POST['Option'];
$BaseURL = $_SERVER["DOCUMENT_ROOT"];
require_once("$BaseURL/inc/Db.Inc.php");
require_once("$BaseURL/inc/lib.inc.php");

$Db = new db($_SESSION['Parameters']['SqlEngine'], $_SESSION['Parameters']['SqlSrv'], $_SESSION['Parameters']['SqlBase'], 
             $_SESSION['Parameters']['SqlUsr'] , $_SESSION['Parameters']['SqlPwd']);

switch( $Option )
{  
	
	case 'SaveObject':
		//	Sauve l'objet du document automatiquement au clique d'ajout d'une réponse de façon à ce que l'objet [...]
		//	[...] à mettre directement le nouvel objet dans la page d'écriture d'une "réponse" 
		$Sql = "UPDATE documents SET ";
		foreach( array_keys($_POST) as $Key )
		{
			switch ($Key )
			{
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
		
		$Db->Query($Sql);
		
		break;
	
    case 'AddRespond':
        $HTML = Respond($_GET['parentWindowId'], $Db, $_GET['did'], false);
        print $HTML;
        break;

    case 'UpdateRespond':
        $HTML = Respond($_GET['parentWindowId'], $Db, $_GET['ddid'], true);
        print $HTML;
        break;

    case 'DeleteDraft':
        DeleteDraft($Db, $_POST["Ddid"]);
        break;

    case 'SaveDraft':
        SaveDraft($Db, $_POST["Ddid"], $_POST["Did"], $_POST["Guid"], $_POST["Conid"], $_POST["Mid"], $_POST["DocName"], $_POST["RObject"], $_POST["Rreceptnum"], $_POST["Content"], $_POST["Description"], $_POST["exist"]);
        break;
        
    case 'SaveFinalRespond':
        ResponsePdf::SaveFinalRespond($Db, $_POST);
        break;
        
    default:
    break;
}

?>
