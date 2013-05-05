<?php
/**
 * Gestion des groupes d'utilisateurs
 *
 * @package		Composants
 * @subpackage		Paramètres
 * @access		public
 * @version		1.2
 * @author              Serge NOEL
 * 
 * @todo    Gérer le répertoire de scan
 * @todo    Gérer la liste des membres
 * @todo		Permettre la saisie d'une adresse
 * @todo    Permettre le choix des workflow par défaut
 */

$Empty=0;

/**
 * Initialisation du composant
 *
 * @ignore
 */
function ContentInit($Db, $Html)
{
$Html->add_js_file("/js/ajax.js");
$Html->add_js_file("/js/php.js");
$Html->add_js_file("/js/prototype.js");
$Html->add_js_file("/js/effects.js");
$Html->add_js_file("/js/window.js");
$Html->add_js_file("/components/Groups/Groups.js");
$GrpScript = str_replace($_SERVER["DOCUMENT_ROOT"],"",__FILE__);

$Groups = array(
  "Sql"     => "SELECT * FROM groups ORDER BY name;",
  "Name"    => "GroupesL",
  "Action"  => "#",
  "Method"  => "post",
  "Title"   => "&nbsp;Groupes",
  "Width"   => 480,
  "Height"  => 300,
  "ListW"   => 453,
  "ListH"   => 200,
  "FieldId" => "gid",
  "Init_JS" => "",
  "Fields"  => array(
                    array("&nbsp;Id","gid",40,40),
                    array("&nbsp;Nom","name",130,130),
                    array("&nbsp;Commentaires","comment",260,240)
                    ),
  "ButtonsLeft" => array(
			               array("/img/Groups/GroupAdd.png","Ajouter","GrpAdd();"),
			               array("/img/Groups/GroupEdit.png","Editer","GrpEdit();"),
			               array("/img/Groups/GroupDel.png","Supprimer","GrpDelete();")
                   		),
  "ButtonsRight" => array(array("/img/Groups/Door.png","Quitter","GrpQuit();"))               
  );


$Content .= "
<!-- Contenu - $GrpScript -->\n<div class=\"main\">\n";
$Content .= $Html->MakeHtmlList2($Db, $Groups);
$Content .= "<div id='GrpPopup' style='display: none'></div>
<div id='GrpPopup2' style='display: none'></div>
<div id='overlay_modal' class='overlay_bluelighting' />
</div>
</div>\n<!-- /Contenu -->\n\n";

return ($Content);
}

/**
 * Fonction appelée en Ajax : édite un groupe
 *
 * @param		array		Enregistrement de la table Groups
 * @param               objet		Base de données
 */
function GrpEdit($Db, $Rep, $AllUids, $Users)
{
$Name     = $Rep['name'];
$Comment  = $Rep['comment'];
$Path     = $Rep['inputdirectory'];
$Gid      = $Rep['gid'];
$Wfsid    = $Rep['wfsid'];
$WfsidOut = $Rep['wfsidout'];
$Checked  = "";
$CheckMsg = " (Non n'est pas li&eacute;)";
$Display  = "none";
if( !empty($Path) )
  {
  $Checked  = "checked='checked' ";
  $CheckMsg = "(Oui, ce groupe a une banette)";
  $Display  = "inline";
  }

$Uids = array();
foreach($AllUids as $UD)
  $Uids[] = $UD["uid"];
$RootPath = $_SESSION["Parameters"]["AbsoluteDocuments"].$_SESSION["Parameters"]["InputPath"];

if( $Gid != -1  && !empty($Wfsid) )
  {
  $Sql="SELECT wid, wfsid FROM wf_steps WHERE wfsid=$Wfsid;";
  $Db->Query($Sql);
  $Step = $Db->loadObject();
  $Wid = $Step->wid;
  }
if( $Gid != -1  && !empty($WfsidOut) )
  {
  $Sql="SELECT wid, wfsid FROM wf_steps WHERE wfsid=$WfsidOut;";
  $Db->Query($Sql);
  $Step = $Db->loadObject();
  $WidOut = $Step->wid;
  }

$Sql="SELECT * FROM workflow ;";
$Db->Query($Sql);
$Workflows = $Db->loadObjectList();
$Option    = "";
$OptionOud = "";
foreach( $Workflows as $Workflow)
  {
  if( $Workflow->wid == $Wid )
    $Option    .= "\n      <option value='". $Workflow->wid ."' selected='selected'>".$Workflow->name."</option>";
  else
    $Option    .= "\n      <option value='".$Workflow->wid."'>".$Workflow->name."</option>";
  if( $Workflow->wid == $WidOut )
    $OptionOut .= "\n      <option value='". $Workflow->wid ."' selected='selected'>".$Workflow->name."</option>";
  else
    $OptionOut .= "\n      <option value='".$Workflow->wid."'>".$Workflow->name."</option>";
  }

$Html = "  
<form method='post' action='#' id='GrpEdit' accept-charset='iso-8859-15'>
  <div style='margin-left:auto;margin-right:auto;width:440px;'>
  &nbsp;<br />
  <input type='hidden' name='gid' id='gid' value='$Gid' >
  <div class='fpPopDiv1' style='width: 120px;'>&nbsp;Nom</div>
  <div class='fpPopDiv2' style='width: 310px'>
    <input type='text' class='fpPopInp2' name='name' id='name' value='$Name' style='width: 180px' />
  </div>
  <div class='fpPopDiv1' style='width: 120px;'>&nbsp;Commentaire</div>
  <div class='fpPopDiv2' style='width: 310px'>
    <input type='text' class='fpPopInp2' name='comment' id='comment' value='$Comment' style='width: 180px' />
  </div>
    <div class='fpPopDiv1' style='width: 120px;'>&nbsp;Workflow sortie</div>
    <div class='fpPopDiv2' style='width: 310px; Display: inine' id='sWid'>
      <select class='fpPopDiv2' style='width: 210px; height: 22px' id='widOut' name='widOut'>$OptionOut
      </select> 
    </div> 
  <fieldset style='width: 420px;'>
    <legend>Param&egrave;tres en entr&eacute;e</legend>
    <div class='fpPopDiv1' style='width: 110px;'>Banette</div>
    <div class='fpPopDiv2' style='width: 310px'>
      <input type='checkbox' value='' $Checked onChange='ChangeReceipt(this.checked);'  /><span id='Message'> $CheckMsg</span>
    </div> 
    <div class='fpPopDiv1' style='width: 110px;'>Chemin</div>
    <div class='fpPopDiv2' style='width: 310px'>
      <img src='/img/FrontPage/folderopen.png' alt='Ouvrir' title='Ouvrir' class='ImgButton' onClick='GetPath();'/> 
      <input type='text' class='fpPopInp2' name='path' id='path' value='$Path' style='width: 180px' disabled='disabled' />
      <input type='hidden' name='RootPath' id='RootPath' value='$RootPath' />
    </div>
    <div class='fpPopDiv1' style='width: 110px;'>Workflow</div>
    <div class='fpPopDiv2' style='width: 310px; Display: $Display' id='sWid'>
      <select class='fpPopDiv2' style='width: 210px; height: 22px' id='wid' name='wid'>$Option
      </select> 
    </div> 
  </fieldset> 
  <fieldset style='width: 420px; height: 220px;'>
    <legend>Utilisateurs</legend>
    <div class='fpPopDiv2' style='width: 170px; height: 180px; text-align: center'>
      Membres<br />
      <select multiple='multiple' size='10' name='members' id='members' style='width: 160px; height: 170px'>\n";
foreach($Users as $Member)
  {
  if( in_array($Member["uid"],$Uids) )
    $Html .= "        <option value='".$Member["uid"]."'>".$Member["name"]." ".$Member["given_name"]."</option>\n";
  }
$Html .= "      </select>
    </div>
    <div class='fpPopDiv2' style='width: 50px; height: 180px; text-align: center'>
      <br />&nbsp;<br />
      <img src='/img/Groups/left.png' class='ImgButton' onClick='AddMember();' >
      <br />&nbsp;<br />
      <img src='/img/Groups/right.png' class='ImgButton' onClick='DelMember();'>
    </div>
    <div class='fpPopDiv2' style='width: 170px; height: 180px; text-align: center'>
      Non membres<br />
      <select multiple='multiple' size='10' name='users' id='users' style='width: 160px; height: 170px'>\n";
foreach($Users as $User)
  {
  if( !in_array($User["uid"],$Uids) )
    $Html .= "        <option value='".$User["uid"]."'>".$User["name"]." ".$User["given_name"]."</option>\n";
  }

$Html .= "      </select>
    </div> 
  </fieldset>
  <div class='formButtons2' style='width:435px;'>
    <div class='formButtonsItemL'>
      <img src='/img/Groups/Save.png' class='ImgButton' alt='Sauvegarder' title='Sauvegarder' onClick='GrpSave();' />
    </div>
    <div class='formButtonsItemR'>
      <img src='/img/Groups/Door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='GrpAbort();' />
    </div>
  </div>
  </div>
</form>
";
return $Html;
}

function ScanPath($Root, $Path)
{
$CurrentPath = $Root . $Path;
$Html = "
<div style='width: 280px; border 1px solid black'><b>Chemin:</b> $CurrentPath<br />&nbsp;</div>
<form id='MyPath' method='post' action='#'>
 <select name='Path' id='Path' onDblClick='SelectPath(this.value);' size='10' style='width: 240px; height: 80px; margin-left: 30px;'>\n";
$Dir = @opendir($CurrentPath);
if( ! $Dir )
  {
  mkdir($CurrentPath,0775);
  $Dir = opendir($CurrentPath);
  }
if( $Dir )
  {
  while (($File = readdir($Dir)) !== false) 
    {
    if( is_dir($CurrentPath."/".$File) && $File != ".")
      $Html .= "   <option value='$File'>$File</option>\n";
    }
  closedir($Dir);
  }

$Html .= " </select>&nbsp;&nbsp;&nbsp;
<div style='width: 290px;' class='formButtons2'>
	<div class='formButtonsItemL' >
  		<img src='/img/Groups/PathAdd.png' class='ImgButton' alt='Nouveau' title='Nouveau' 
       	onClick='MakePath();' />
	</div>
	<div class='formButtonsItemR'>
  		<img src='/img/Groups/Save.png' class='ImgButton' alt='Sauvegarder' title='Sauvegarder' onClick='SavePath();'/>
  	</div
</div>
</form>
 ";
return( $Html );
}

/* Partie Ajax */
session_start();
$BaseURL = $_SERVER["DOCUMENT_ROOT"];
$Option = $_GET['Option'];
if( empty($Option) )
  $Option = $_POST['Option'];
$BaseURL = $_SERVER["DOCUMENT_ROOT"];
require_once("$BaseURL/inc/Db.Inc.php");
require_once("$BaseURL/inc/lib.inc.php");
require_once("$BaseURL/inc/User.Inc.php");

$Db = new db($_SESSION['Parameters']['SqlEngine'], $_SESSION['Parameters']['SqlSvr'], $_SESSION['Parameters']['SqlBase'], 
             $_SESSION['Parameters']['SqlUsr'] , $_SESSION['Parameters']['SqlPwd']);

switch( $Option )
  {
  case 'GrpEdit':

    $Id = $_GET['Id'];
    if( $Id != -1 )
      {
      $Sql  = "SELECT * FROM groups WHERE gid=$Id ;";
      $Db->Query($Sql);
      $Rep = $Db->loadArray();
      $Sql  = "SELECT * FROM g_grp WHERE gid=$Id ;";
      $Db->Query($Sql);
      $Uids = $Db->loadArrayList();
      }
    else
      {
      $Rep = array("gid"=>-1,"wid"=>-1,"name"=>"","action"=>0,"inputdirectory"=>"","comment"=>"");
      $Uids = array();
      }
    $Sql  = "SELECT * FROM user WHERE uid>0 ORDER BY name;";
    $Db->Query($Sql);
    $Users = $Db->loadArrayList();
    print GrpEdit($Db, $Rep, $Uids, $Users);
    $Db->Close();
    break;

  case 'GrpDelete':
    $gid = $_GET['gid'];
    // Interroger la base de données
    $Sql = "DELETE FROM g_grp WHERE gid=$gid";
    $Db->Query($Sql);
    $Sql = "DELETE FROM groups WHERE gid=$gid";
    $Db->Query($Sql);
    $Db->Close();
    break;


  case 'GrpSave':
    // Obtenir la première étape du workflow
    if( !empty( $_GET["path"] ))
      {  // Si path n'est pas vide, alors on a une banette, il faut un workflow par défaut
      $Sql = "SELECT * FROM wf_steps WHERE wid=". $_GET["wid"] . " ORDER BY myorder;";
      $Db->Query($Sql);
      $FirstStep = $Db->loadObject();
      $Wfsid = $FirstStep->wfsid;
      }
    $Sql = "SELECT * FROM wf_steps WHERE wid=". $_GET["widOut"] . " ORDER BY myorder;";
    $Db->Query($Sql);
    $StepOut = $Db->loadObject();
    $WfsIdOut = $StepOut->wfsid;
      
    // Récupérer les données
    $gid  = $_GET["gid"];
    if( $gid == -1 )
      $Sql = "INSERT INTO groups SET ";
    else
      $Sql  = "UPDATE groups SET ";
    $Sql .= "name='".urldecode($_GET["name"]) ."'";
    if( !empty( $Wfsid ) )
      $Sql .= ", wfsid=$Wfsid";
    $Sql .= ", inputdirectory='".urldecode($_GET["path"]) ."'";  
    $Sql .= ", wfsidout=$WfsIdOut";
    if( !empty( $_GET["comment"] ) )
      $Sql .= ", comment='".urldecode($_GET["comment"]) ."'";
    if( $gid != -1 )
      $Sql .= " WHERE gid=$gid ;";
    $Db->Query($Sql);
    if( $gid == -1 )
      $gid = $Db->GetLastId();
    $Db->Close();
    echo $gid;
    break;

  case 'SaveMembers':
    $gid = $_POST["gid"];
    $Sql = "DELETE FROM g_grp WHERE gid=$gid ;";
    $Db->Query($Sql);
    $Uids = explode("|",$_POST["Users"]);
    foreach($Uids as $Uid)
      {
      if( !empty($Uid) )
        {
        $Sql = "INSERT INTO g_grp SET gid=$gid, uid=$Uid ;";
        $Db->Query($Sql);
        }
      }
  
    break;
    
  case 'ScanPath':
    print ScanPath(urldecode($_GET["Root"]), urldecode($_GET["Path"]));
    break;

  case 'SavePath':
    // /components/Groups/Groups.php?Option=SavePath&Path=Informatique
    
    break;
  
  case 'MakePath':
    $NewPath = $_SESSION["Parameters"]["AbsoluteDocuments"].$_SESSION["Parameters"]["InputPath"] . "/" . $_GET["Path"];   
    if( !mkdir($NewPath) )
      echo "ERREUR: ne peut creer le repertoire !";
    break; 
     
  default:
    break;
  }


?>
