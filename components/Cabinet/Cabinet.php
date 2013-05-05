<?php
/**
 * Gestion du classement
 *
 * @package		Composants
 * @subpackage		Cabinet
 * @access		public
 * @version		1.2
 * @author              Serge NOEL
 */
   $uniqueid = 0;

/**
 * Initialisation du composant
 *
 * @ignore
 */
function ContentInit($Db, guihtml $Html)
{
global $uniqueid;
session_start();
$Html->add_js_file("/js/ajax.js");
$Html->add_js_file("/js/php.js");
$Html->add_js_file("/js/dtree.js");
$Html->add_js_file("/components/Cabinet/Cabinet.js");
$Content = "";

$Path = $_SESSION["Parameters"]["AbsoluteDocuments"] . $_SESSION["Parameters"]["StorePath"];

$innerHTML = "
<script type='text/javascript'>
d = new dTree('d');
d.icon.root = '/img/dTree/cabinet.png';
d.icon.node = '/img/dTree/classeur.png';
d.add(0,-1,'Classement',\"SetActive(-1);\");\n";
$innerHTML .= GetCabinets($Db,0);
$innerHTML .= "document.write(d);
</script>";

$JavaScript = "<script type='text/javascript'>
RadioSelected=-1;
RootPath='$Path';
</script>";

$Content = "
<!-- Cabinets -->
$JavaScript
<div class='main' >
<table border='0' cellspacing='0' cellpadding='0' width='650px'>
  <tr>
    <td class='CadreTopLeft'></td>
    <td class='CadreTop'>Gestion du classement</td>
    <td class='CadreTopRight'></td>
  </tr>
    <td class='CadreLeft'></td>
    <td class='CadreContent'>&nbsp;</br>
    <div style='width: 590px; height: 350px; border: 1px solid black; margin-left: 10px; overflow-y: auto'>
$innerHTML
    </div>
    <div class='formButtons2' style='width:590px;'>
      <div class='formButtonsItemL'>
        <img src='/img/Folders/FolderAdd.png' class='ImgButton' alt='Ajouter' title='Ajouter' onClick='AddCabinet();' />
      </div>
      <div class='formButtonsItemL' >
        <img src='/img/Folders/FolderRen.png' class='ImgButton' alt='Renommer' title='Renommer' onClick='RenameCabinet();' />
      </div>
      <div class='formButtonsItemL'>
        <img src='/img/Folders/FolderDel.png' class='ImgButton' alt='Supprimer' title='Supprimer' onClick='DelCabinet();' />
      </div>
      <div class='formButtonsItemR' >
        <img src='/img/Folders/Door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='QuitCabinet();' />
      </div>
    </div></td>
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

<div id='Status' class='Status'></div>
<!-- Cabinets -->\n";
return $Content;
}

function DisplayCabinet($Db)
{
    global $uniqueid;
    $uniqueid=0;
    $Content = "
    <!-- Cabinets -->
    &nbsp;<br />
    <div style='width: 590px; height: 340px; border: 1px solid black; margin-left: 10px; overflow-y: auto' id='CabinetDiv'>
        <script type='text/javascript'>
            RadioSelected=-1;
            d = new dTree('d');
            d.icon.root = '/img/dTree/cabinet.png';
            d.icon.node = '/img/dTree/classeur.png';
            d.add(0,-1,'Classement',\"SetActive(-1);\");" . GetCabinets($Db,0) . "
            document.getElementById('CabinetDiv').innerHTML = d;
        </script>
    </div>
    <div class='formButtonsItemL' style='margin-top: 10px'>
        <img src='/img/Folders/FolderAdd.png' class='ImgButton' alt='Ajouter un emplacement' title='Ajouter un emplacement' onClick='AddCabinet();' style='margin-left: 20px'/>
    </div>
    <div class='formButtonsItemR' >
        <img src='/img/Folders/Ok.png' class='ImgButton' alt='Choisir' title='Choisir' onClick='SelectCabinet();' style='margin-top: 10px;  margin-right: 20px;'/>
        <img src='/img/Folders/Door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='QuitCabinet();' style='margin-top: 10px; margin-right: 30px;' />
    </div>
    <!-- Cabinets -->\n";
    return $Content;
}

/**
 * Analyse le classement (récursif)
 * 
 * @todo		Rendre dynamique avec Javascript !!! 
 * @param		object		Base de données
 * @param		int		Id parent
 */
function GetCabinets($Db,$Parent)
{
    global $uniqueid;
    $Ret = "";

    $Sql = "SELECT * FROM cabinet WHERE parent=$Parent ORDER BY label";
    $Db->Query($Sql);
    $Reps = $Db->loadObjectList();
    foreach( $Reps as $Rep )
    {
        // Est ce une feuille ou une branche ?
        $Ret .= "d.add($Rep->cabid,$Rep->parent,'$Rep->label',\"SetActive(".$Rep->cabid.");\");\n";
        $Sql = "SELECT * FROM cabinet WHERE parent=". $Rep->cabid ." ;";
        $Db->Query($Sql);
        if( $Db->NumRows() > 0 )
        $Ret .= GetCabinets($Db,$Rep->cabid);
    }
    return $Ret;
}

/**
 * Affiche une chaine représentant le classement 
 * 
 * @param		object		Base de données
 * @param		int		Id 
 */
function GetCabinetString($Db,$Id)
{
    global $uniqueid;
    $Ret = "";
    $Chemin = array();

    $i=0;
    $Ok = true;
    while( $Ok )
    {
        $Sql = "SELECT * FROM cabinet WHERE cabid=$Id;";
        $Db->Query($Sql);
        $Rep = $Db->loadObject();
        $Id = $Rep->parent;
        $Chemin[$i] = $Rep->label;
        $i++;
        if( $Id == 0 )
        $Ok = false;
    }
    $i--;
    for( $j=$i ; $j> 0 ; $j-- )
        $Ret .= html_entity_decode($Chemin[$j],ENT_QUOTES,"UTF-8") . " -> ";
    $Ret .= html_entity_decode($Chemin[$j],ENT_QUOTES,"UTF-8");
    return $Ret;
}

/* Partie Ajax */
session_start();
$Option = $_GET['Option'];
$BaseURL = $_SERVER["DOCUMENT_ROOT"];
// Initialise la Bdd
$BaseURL = $_SERVER["DOCUMENT_ROOT"];
require_once("$BaseURL/inc/Db.Inc.php");
require_once("$BaseURL/inc/lib.inc.php");
$Db = new db($_SESSION['Parameters']['SqlEngine'], $_SESSION['Parameters']['SqlSrv'], $_SESSION['Parameters']['SqlBase'], 
             $_SESSION['Parameters']['SqlUsr'] , $_SESSION['Parameters']['SqlPwd']);

switch( $Option )
  {
  case 'AddCabinet':  
    $Parent = $_GET["cabid"];
    if( $Parent == -1 )
      $Parent = 0;
    $Label = htmlentities(urldecode($_GET["Val"]),ENT_QUOTES,"UTF-8");
    $Sql = "INSERT INTO cabinet SET parent=$Parent, label='$Label';";
    $Db->Query($Sql);
    MyLog($Db,$_SESSION['User']['uid'],2,"Ajout de $Label ($Parent) dans le classement");
    break;

  case 'DelCabinet':
    $cabid = $_GET["cabid"];
    // Récupérer label
    $Sql = "SELECT * FROM cabinet WHERE cabid=$cabid;";
    $Db->Query($Sql);
    $Rep = $Db->loadObject();
    $Label = $Rep->label;
    $Parent = $Rep->parent;
    // Il ne doit rien contenir
    $Sql = "SELECT * FROM documents WHERE cabid=$cabid ;";
    $Db->Query($Sql);
    if( $Db->NumRows() > 1 )
      {
      echo "<font color='red'><b>ERREUR :</b> Le dossier n'est pas vide !</font>";
      break;
      }
    // Le dossier ne doit pas être parent
    $Sql = "SELECT * FROM cabinet WHERE parent=$cabid ;";
    $Db->Query($Sql);
    if( $Db->NumRows() > 0 )
      {
      echo "<font color='red'><b>ERREUR :</b> Le dossier a des dossiers enfants !</font>";
      break;
      }
    $Sql = "DELETE FROM cabinet WHERE cabid=$cabid ;";
    $Db->Query($Sql);
    MyLog($Db,$_SESSION['User']['uid'],2,"Suppression de $Label ($Parent) dans le classement");
    break;

  case 'RenCabinet':  
    $cabid = $_GET["cabid"];
    // Récupérer label
    $Sql = "SELECT * FROM cabinet WHERE cabid=$cabid;";
    $Db->Query($Sql);
    $Rep = $Db->loadObject();
    $OldLabel = $Rep->label;
    $Parent = $Rep->parent;
    $Label = htmlentities(urldecode($_GET["Val"]),ENT_QUOTES,"UTF-8");
    $Sql = "UPDATE cabinet SET label='$Label' WHERE cabid=$cabid ;";
    $Db->Query($Sql);
    MyLog($Db,$_SESSION['User']['uid'],2,"Modification de $OldLabel ($Parent) vers $Label dans le classement");
    break;

  case 'GetLabel':  
    $cabid = $_GET["cabid"];
    $Sql = "SELECT * FROM cabinet WHERE cabid=$cabid ;";
    $Db->Query($Sql);
    $Rep = $Db->loadObject();
    echo $Rep->label;
    break;
      
  case 'GetCabinetString':
    echo GetCabinetString($Db,$_GET["cabid"]);
    break;
    
  case 'DisplayCabinet':
    print DisplayCabinet($Db);
    break; 
      
  default:
    echo $Option . "" . $Path;
    echo " ";
    break; 

  }


?>

