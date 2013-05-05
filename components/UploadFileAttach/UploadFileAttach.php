<?php


/**
 * Fonction appellée par index.php pour afficher le composant
 *
 * @ignore
 */
function ContentInit($Db, $Html)
{
require("inc/Contact.class.php");
$Html->add_css("/css/default.css");
$Html->add_css("/css/lighting.css");
$Html->add_js_file("/js/prototype.js");
$Html->add_js_file("/js/effects.js");
$Html->add_js_file("/js/window.js");
$Html->add_js_file("/js/ajax.js");
$Html->add_js_file("/js/php.js");
$Html->add_js_file("/js/calpopup.js");
$Html->add_js_file("/js/dtree.js");
$Html->add_js_file("/components/UploadFileAttach/UploadFileAttach.js");
$Html->add_js_file("/components/UploadFileAttach/UploadFileAttachAddOn.js");

$Path = $_SESSION["Parameters"]["StorePath"].date("/Y/m/d");
$CabId   = $_SESSION["Parameters"]["DefaultCabinet"];
$Sql = "SELECT * FROM cabinet WHERE cabid=$CabId;";
$Db->Query($Sql);
$Rep = $Db->loadObject();
$CabString = $Rep->label;

$Contact = new Contact();
$ConId = $_SESSION["Parameters"]["DefaultSender"];
$SenderObj = $Contact->GetContactById($Db,$ConId);
$Sender = "(" . $SenderObj->company . ") " . $SenderObj->name . " " . $SenderObj->given_name;

$MaDate = date("Y-m-d H:i:s");
$HTML = "
<!-- AddDocument -->
<div class='main' >
<table border='0' cellspacing='0' cellpadding='0' width='550px'>
  <tr>
    <td class='CadreTopLeft'></td>
    <td class='CadreTop'>Ajouter un document </td>
    <td class='CadreTopRight'></td>
  </tr>
  <tr>
    <td class='CadreLeft'></td>
    <td class='CadreContent'>
      <form name='AddDocument' id='AddDocument' action='/components/UploadFileAttach/Upload.php' method='post' enctype='multipart/form-data'>
       <input type='hidden' name='Up_path'     id='Up_path'     value='$Path' />
       <input type='hidden' name='Up_name'     id='Up_name'     value='' />
       <input type='hidden' name='Up_date_in'  id='Up_date_in'  value='$MaDate' />
       <input type='hidden' name='Up_date_due' id='Up_date_due' value='$MaDate' />
       <input type='hidden' name='Up_date_out' id='Up_date_out' value='$MaDate' />
       <input type='hidden' name='Up_date_del' id='Up_date_del' value='$MaDate' />
       <input type='hidden' name='Up_cabid'    id='Up_cabid'    value='$CabId'  />
       <input type='hidden' name='Up_conid'    id='Up_conid'    value='$ConId' />
       <input type='hidden' name='Up_wfsid'    id='Up_wfsid'    value='-1' />
       <input type='hidden' id='kind' value='upload' /> <!-- Ajout fichier -->
       
       &nbsp;
       <fieldset id='-1'>
         <legend>Fichier</legend>
         <div class='fpPopDiv2' style='width: 480px; height: 30px; margin-left: 10px;margin-top: 10px;'>
           <span class='fpPopDiv1' style='width: 120px'>Fichier</span>
           <span class='fpPopDiv1' style='width: 280px; Display: inline' id='sFileName'>
             <iframe id='UploadTarget' name='UploadTarget' src='/components/UploadFileAttach/Upload.php' style='width: 340px;height: 25px;border: 0px solid #fff;'></iframe></span>
           <span class='fpPopDiv1' style='width: 280px; Display: none' id='sUploadImg'><img src='components/UploadFileAttach/loader2.gif' /></span>
         </div>
         <div class='fpPopDiv2' style='width: 480px; height: 20px; margin-left: 10px;'>
          <span class='fpPopDiv1' style='width: 120px'>Chemin cible</span>
          <span class='fpPopDiv2' style='width: 230px;' id='Up_dPath'>$Path</span>
         </div>
         <div class='fpPopDiv2' style='width: 480px; height: 20px; margin-left: 10px;'>
          <span class='fpPopDiv1' style='width: 120px'>Nom</span>
          <span class='fpPopDiv2' style='width: 350px;' id='Up_dName'></span>
         </div>
       </fieldset>  
       <fieldset>
         <legend>Donn&eacute;es</legend>         
           <div class='fpPopDiv2' style='width: 480px; height: 20px; margin-left: 10px;margin-top: 10px;'>
            <span class='fpPopDiv1' style='width: 120px'>Objet</span>
            <span class='fpPopDiv2' style='width: 310px;'>
		          <input class='fpPopInp2' style='width: 280px;' type='text' name='Up_object' id='Up_object' value='' />                  
		        </span>
           </div>
         <div class='fpPopDiv2' style='width: 480px; height: 20px; margin-left: 10px;margin-top: 10px;'>
           <span class='fpPopDiv1' style='width: 120px'>Classement</span>
           <span class='fpPopDiv2' style='width: 310px;'>
             <img src='/img/FrontPage/cabinet16.png' alt='Stockage papier' title='Stockage papier' class='ImgButton' onClick='DisplayCabinet();' />&nbsp;
             <input class='fpPopInp2' style='width: 254px;' type='text' name='Up_box' id='Up_box' value='$CabString' readonly='readonly' />
           </span>
         </div>
         <div class='fpPopDiv2' style='width: 480px; height: 20px; margin-left: 10px;margin-top: 10px;'>
           <span class='fpPopDiv1' style='width: 120px'>Exp&eacute;diteur</span>
           <span class='fpPopDiv2' style='width: 310px'>
           <img src='/img/FrontPage/User.png' onClick=\"DisplayContacts();\" alt='Choisir expéditeur' title='Choisir expéditeur' class='ImgButton' />
           <input class='fpPopInp2' style='width: 254px' id='Up_Sender' name='Up_Sender' readonly='readonly' value='$Sender' />
         </div>
       </fieldset>
       <fieldset id='-1'>
         <legend>Distribution</legend>
         <div class='fpPopDiv2' style='width: 480px; height: 20px; margin-left: 10px;margin-top: 10px;'>
           <img src='/img/FrontPage/Workflow.png' onClick='ListWorkflows(\"Ariane\", \"wfsid\");' class='ImgButton' />
           <span id='Ariane'></span>
         </div>
       </fieldset>

      </form>
      <div class='formButtons2' style='width:480px;margin-left: 10px;' >
        <span class='formButtonsItemL' >
          <img src='/img/UploadFileAttach/UploadGray.png' class='ImgButton' id='ImgUpload' alt='T&eacute;l&eacute;charger' title='T&eacute;l&eacute;charger' onClick='startMyUpload();' />
        </span>
<!--        <span class='formButtonsItemL' >
          <img src='/img/UploadFileAttach/SaveGray.png' class='ImgButton' id='ImgSave' alt='Sauvegarder' title='Sauvegarder' onClick='SaveUpload();' />
        </span> -->
        <span class='formButtonsItemR' >
          <img src='/img/UploadFileAttach/Door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='document.location=\"index.php?Option=Frontpage\";' />
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
<!-- AddDocument -->\n";
return $HTML;
}


function UploadFileAttachWindow($parentWindowId , $Db, $did)
{
require("../../inc/Contact.class.php");
$Path = $_SESSION["Parameters"]["StorePath"].date("/Y/m/d");
$CabId   = $_SESSION["Parameters"]["DefaultCabinet"];
$Sql = "SELECT * FROM cabinet WHERE cabid=$CabId;";
$Db->Query($Sql);
$Rep = $Db->loadObject();
$CabString = $Rep->label;

$Contact = new Contact();
$ConId = $_SESSION["Parameters"]["DefaultSender"];
$SenderObj = $Contact->GetContactById($Db,$ConId);
$Sender = "(" . $SenderObj->company . ") " . $SenderObj->name . " " . $SenderObj->given_name;

$MaDate = date("Y-m-d H:i:s");
$HTML = "
<!-- AttachDocument -->
<form name='AddDocument' id='AddDocument' action='/components/UploadFileAttach/Upload.php' method='post' enctype='multipart/form-data'>
       <input type='hidden' name='Up_path'     id='Up_path'     value='$Path' />
       <input type='hidden' name='Up_name'     id='Up_name'     value='' />
       <input type='hidden' name='Up_date_in'  id='Up_date_in'  value='$MaDate' />
       <input type='hidden' name='Up_date_due' id='Up_date_due' value='$MaDate' />
       <input type='hidden' name='Up_date_out' id='Up_date_out' value='$MaDate' />
       <input type='hidden' name='Up_date_del' id='Up_date_del' value='$MaDate' />
       <input type='hidden' name='Up_cabid'    id='Up_cabid'    value='$CabId'  />
       <input type='hidden' name='Up_conid'    id='Up_conid'    value='$ConId' />
       <input type='hidden' name='Up_wfsid'    id='Up_wfsid'    value='-1' />
       <input type='hidden' id='kind' value='attach' /> <!-- Fichier lié-->
       
       &nbsp;
       <fieldset id='-1'>
         <legend>Fichier</legend>
         <div class='fpPopDiv2' style='width: 480px; height: 30px; margin-left: 10px;margin-top: 10px;'>
           <span class='fpPopDiv1' style='width: 120px'>Fichier</span>
           <span class='fpPopDiv1' style='width: 280px; Display: inline' id='sFileName'>
             <iframe id='UploadTarget' name='UploadTarget' src='/components/UploadFileAttach/Upload.php' style='width: 340px;height: 25px;border: 0px solid #fff;'></iframe></span>
           <span class='fpPopDiv1' style='width: 280px; Display: none' id='sUploadImg'><img src='components/UploadFileAttach/loader2.gif' /></span>
         </div>
         <div class='fpPopDiv2' style='width: 480px; height: 20px; margin-left: 10px'>
          <span class='fpPopDiv1' style='width: 120px'>Chemin cible</span>
          <span class='fpPopDiv2' style='width: 230px;' id='Up_dPath'>$Path</span>
         </div>
         <div class='fpPopDiv2' style='width: 480px; height: 20px; margin-left: 10px'>
          <span class='fpPopDiv1' style='width: 120px'>Nom</span>
          <span class='fpPopDiv2' style='width: 350px;' id='Up_dName'></span>
         </div>
       </fieldset>  
       <fieldset>
         <legend>Donn&eacute;es</legend>         
           <div class='fpPopDiv2' style='width: 480px; height: 20px; margin-left: 10px;margin-top: 10px;'>
            <span class='fpPopDiv1' style='width: 120px'>Objet</span>
            <span class='fpPopDiv2' style='width: 310px;'>
		          <input class='fpPopInp2' style='width: 280px;' type='text' name='Up_object' id='Up_object' value='' />                  
		        </span>
           </div>
         <div class='fpPopDiv2' style='width: 480px; height: 20px; margin-left: 10px;margin-top: 10px;'>
           <span class='fpPopDiv1' style='width: 120px'>Classement</span>
           <span class='fpPopDiv2' style='width: 310px;'>
             <img src='/img/FrontPage/cabinet16.png' alt='Stockage papier' title='Stockage papier' class='ImgButton' onClick='DisplayCabinet();' />&nbsp;
             <input class='fpPopInp2' style='width: 254px;' type='text' name='Up_box' id='Up_box' value='$CabString' readonly='readonly' />
           </span>
         </div>
         <div class='fpPopDiv2' style='width: 480px; height: 20px; margin-left: 10px;margin-top: 10px;'>
           <span class='fpPopDiv1' style='width: 120px'>Exp&eacute;diteur</span>
           <span class='fpPopDiv2' style='width: 310px'>
           <img src='/img/FrontPage/User.png' onClick=\"DisplayContacts();\" alt='Choisir expéditeur' title='Choisir expéditeur' class='ImgButton' />
           <input class='fpPopInp2' style='width: 254px' id='Up_Sender' name='Up_Sender' readonly='readonly' value='$Sender' />
         </div>
       </fieldset>
       <fieldset id='-1'>
         <legend>Distribution</legend>
         <div class='fpPopDiv2' style='width: 480px; height: 20px; margin-left: 10px;margin-top: 10px;'>
           <img src='/img/FrontPage/Workflow.png' onClick='ListWorkflows(\"Ariane\", \"wfsid\");' class='ImgButton' />
           <span id='Ariane'></span>
         </div>
       </fieldset>

      </form>
      <div class='formButtons2' style='width:480px;margin-left: 10px;' >
        <span class='formButtonsItemL' >
          <img src='/img/UploadFileAttach/UploadGray.png' class='ImgButton' id='ImgUpload' alt='T&eacute;l&eacute;charger' title='T&eacute;l&eacute;charger' onClick='startMyUpload();' />
        </span>
<!--        <span class='formButtonsItemL' >
          <img src='/img/UploadFileAttach/SaveGray.png' class='ImgButton' id='ImgSave' alt='Sauvegarder' title='Sauvegarder' onClick='SaveUpload();' />
        </span> -->
        <span class='formButtonsItemR' >
          <img src='/img/UploadFileAttach/Door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='QuitUpload();' />
        </span>
        
      </div>
<!-- AttachDocument -->\n";
    return $HTML;
}

/**
 *  Enregistre le fichier qui à été uploadé.
 * @param db $Db
 * @param int $did Identifiant du document auqel le fichier est attaché.
 * @param int $iddocattach Identifiant du fichier.
 * @param string $nom Nom qui sera afficher dans la liste de document joint.
 */
function SaveFileAttach(db $Db, $did, $iddocattach, $nom)
{	
    /*if($nom != "" || $did != "")
    {
        $SqlSelect = "SELECT filepath FROM docattach WHERE iddocattach = ".$iddocattach;
        $Db->Query($SqlSelect);
        $filePath = $Db->loadObject()->filepath;

        $newFilePath = $_SESSION["Parameters"]["AbsoluteDocuments"];

        $SqlUpdate = "UPDATE docattach SET did = $did, nom=$nom, filepath=$newfilepath";
    }
    else
    {
        
    }*/
}

/*
function ListFileAttach($Db, $Did)
{
$Msg="";

$ListDocAttach = GetDocFileAttach($Db, $Did);
foreach($ListDocAttach as $DocAttach)
  {
  $DateAjout  = substr($DocAttach->date_in,8,2)  . "/" . substr($DocAttach->date_in,5,2)  . "/" .substr($DocAttach->date_in,0,4);
  $HeureAjout = substr($DocAttach->date_in,11,2) . ":" . substr($DocAttach->date_in,14,2) . ":" .substr($DocAttach->date_in,17,2);
  $RelativeFileName = "/Documents" . $DocAttach->path. "/" .$DocAttach->name;
        
	$InfoBulle = "<b>Objet :</b> ".$DocAttach->object."<br /><b>Ajouté le :</b> $DateAjout à $HeureAjout <br /><br /><i>Double cliquez sur le lien pour afficher la pièce jointe</i>";
		
  $Msg .= "<option value='".$DocAttach->did_docattach."' onmouseover=\"tt_over1('$InfoBulle', 'tStyle')\" onmouseout='tt_out()' onclick='SetAttach(this.value,$Did);' ";
  $Msg .= "ondblclick=\"Preview('$RelativeFileName');\">";
  $Msg .= $DocAttach->object." (".$DocAttach->name.")</option>\n";
  }
return $Msg;
}
*/



function DeleteFileAttach(db $Db, $did_docattach, $Did)
{
    $Sql = "DELETE FROM docattach WHERE did_docattach=".$did_docattach." AND did=".$Did;
    $Db->Query($Sql);
}

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
             $_SESSION['Parameters']['SqlUsr'], $_SESSION['Parameters']['SqlPwd']);


switch ($Option)
  {
  case "ShowWindow":
    print UploadFileAttachWindow($_GET["parentWindowId"], $Db, $_GET["did"]);
    break;

  case "SaveFile";
    SaveFileAttach($Db, $_POST["did"], $_POST["iddocattach"], $_POST["nom"]);
    break;
        
  case 'DeleteFileAttach':
    DeleteFileAttach($Db, $_POST["did_docattach"], $_POST["did"]);
    break;

  case 'SaveUploadFile':
    require_once("../../inc/IndexFile.php");
    $Kind  = $_POST["Kind"];
    $Sql = stripslashes(urldecode($_POST["Sql"]));
    $Db->Query($Sql);
    $Did = $Db->GetLastId();
    echo "SQL1: $Sql\n";
    $Fid = $_SESSION["Parameters"]["DefaultFolder"];
    $Sql = "INSERT INTO docfolders SET did=$Did , fid=$Fid";
    $Db->Query($Sql);
    echo "SQL2: $Sql\n";
    $File = urldecode($_POST["name"]);
    $Path = urldecode($_POST["Path"]);

    if( strpos( $File,".pdf" ) == true)
      {  // Rechercher dans un pdf le texte
      $TxtFile = substr($File,0,strpos($File,".pdf")) . ".txt";
      exec("pdftotext '$Path/$File' 'Tmp/$TxtFile'");

      if( file_exists("Tmp/$TxtFile") )
        {
        // Si le fichier .pdf a des textes lisibles, il est indexé
        IndexFile($Db, "$TmpPath/$TxtFile",$Did, 3);
        // Le fichier texte n'est plus utile
        //print "$TmpPath/$TxtFile";
        unlink("$TmpPath/$TxtFile");
        }
      }

    // Ajout d'une ligne dans le journal
    if( $Kind == "upload" )
      $Sql = "INSERT INTO doclog SET did=$Did , description='Ajout du document par upload', action=0;";
    else
      $Sql = "INSERT INTO doclog SET did=$Did , description='Ajout du document li&eacute;', action=0;";
    echo "SQL3: $Sql";
    $Db->Query($Sql);
    if( $Kind == "attach" )
      {
      $pDid  = $_POST["pDid"];
      $Sql = "INSERT INTO docattach SET did=$pDid, did_docattach=$Did;";  // did_docattach
      echo "SQL4: $Sql";
      $Db->Query($Sql);
      }
    break;
  
  case 'SaveAttach':
    $Sql = urldecode($_POST["Sql"]);
    $Db->Query($Sql);
    break;
    
  default :
    break;
}

?>
