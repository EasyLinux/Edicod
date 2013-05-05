<?php
/**
 * Gestion des répertoires
 *
 * @package		Composants
 * @subpackage		Folders
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
function ContentInit($Db, $Html)
{
global $uniqueid;
$uniqueid=0;
session_start();
$Html->add_js_file("/js/ajax.js");
$Html->add_js_file("/js/php.js");
$Html->add_js_file("/js/dtree.js");
$Html->add_js_file("/components/Folders/Folders.js");
$Content = "";

$Path = $_SESSION["Parameters"]["AbsoluteDocuments"] . $_SESSION["Parameters"]["StorePath"];

$innerHTML = "
<script type='text/javascript'>
d = new dTree('d');
d.icon.root = '/img/dTree/disque.png';
d.icon.node = '/img/dTree/dossier.png';
d.add(0,-1,'Racine ($Path)',\"SetActive('$Path');\");\n";
$uniqueid++;
$innerHTML .= MyScan2($Path,0);
$innerHTML .= "document.write(d);
</script>";

$JavaScript = "<script type='text/javascript'>
RadioSelected='';
RootPath='$Path';
</script>";

$Content = "
<!-- Folders -->
$JavaScript
<div class='main' >
<table border='0' cellspacing='0' cellpadding='0' width='650px'>
  <tr>
    <td class='CadreTopLeft'></td>
    <td class='CadreTop'>Dossiers (sur le disque dur)</td>
    <td class='CadreTopRight'></td>
  </tr>
    <td class='CadreLeft'></td>
    <td class='CadreContent'>&nbsp;</br>
    <div style='width: 590px; height: 350px; border: 1px solid black; margin-left: 10px; overflow-y: auto'>
$innerHTML
    </div>
    <div class='formButtons2' style='width: 590px;'>
      <div class='formButtonsItemL' >
        <img src='/img/Folders/FolderAdd.png' class='ImgButton' alt='Ajouter' title='Ajouter' onClick='AddPath();' />
      </div>
      <div class='formButtonsItemL'>
        <img src='/img/Folders/FolderMov.png' class='ImgButton' alt='Déplacer / Renommer' title='Déplacer / Renommer' onClick='RenPath();' />
      </div>
      <div class='formButtonsItemL' >
        <img src='/img/Folders/FolderDel.png' class='ImgButton' alt='Supprimer' title='Supprimer' onClick='DelPath();' />
      </div>
      <div class='formButtonsItemR'>
        <img src='/img/Folders/Door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='QuitPath();' />
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
<!-- Folders -->\n";
return $Content;
}

/**
 * Analyse un répertoire 
 * 
 * @param		string		Chemin à analyser
 * @param		string		Chemin parent 
 */
function MyScan2($Path,$Parent)
{
    global $uniqueid;
    $Ret = "";

    $AbsPath = $_SESSION["Parameters"]["AbsoluteDocuments"] ;
    $RelPath = substr($Path,strlen($AbsPath));
    $Dir = opendir($Path);

    if($Dir)
    {
        while (($File = readdir($Dir)) !== false)
        {
            if(!($File == "." || $File == ".."))
            {
                if( is_dir($Path."/".$File) )
                {
                      $Ret .= "d.add($uniqueid,$Parent,'$File',\"SetActive('$AbsPath"."$RelPath/$File');\");\n";
                      $uniqueid++;
                      $Ret .= MyScan2($Path."/".$File,$uniqueid-1);
                }
            }
        }
    }
    closedir($Dir);
    return $Ret;
}

/**
 * Affichage d'une sélection de répertoire
 *
 */
function DisplayFolders()
{
    global $uniqueid;
    $AbsPath   = $_SESSION["Parameters"]["AbsoluteDocuments"];
    $StorePath = $_SESSION["Parameters"]["StorePath"];
    $Path = $AbsPath . $StorePath;


    $Content = "
    <!-- DisplayFolders -->
    <div id='FolderTree' style='border: 1px solid gray; height: 355px; overflow-y: auto'>
    </div>
    <div class='formButtonsItemL' style='margin-top: 10px'>
      <img src='/img/Folders/FolderAdd.png' class='ImgButton' alt='Ajouter' title='Ajouter' onClick='AddPath();'  style='margin-left: 20px; width: 32px'/>
    </div>
    <div class='formButtonsItemR' style='margin-top: 10px'>
      <img src='/img/Folders/Ok.png' class='ImgButton' alt='Choisir' title='Choisir' onClick='SelectFolder();'  style='width: 32px'/>
      <img src='/img/Folders/Door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='QuitPath();'  style='margin-left: 10px'/>
    </div>
    <script type='text/javascript'>
    RadioSelected='';
    StorePath = '$StorePath';
    RootPath  = '$AbsPath';

    d = new dTree('d');
    d.icon.root = '/img/dTree/disque.png';
    d.icon.node = '/img/dTree/dossier.png';
    d.add(0,-1,'Racine ($Path)',\"SetActive('$Path');\");\n";
    $uniqueid++;
    $Content .= MyScan2($Path,0);
    $Content .= "d.closeAll();
    document.getElementById('FolderTree').innerHTML = d;
    </script>
    <!-- DisplayFolders -->
    ";
    return $Content;
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
  case 'AddPath':
    $Path = urldecode($_GET['Path']);
    if(!@mkdir($Path))
      echo "<font color='red'><b>ERREUR :</b> Ne peut creer le repertoire  : $Path</font>";
    else
      {
      chmod($Path,0775);
      MyLog($Db,$_SESSION['User']['uid'],3,"Ajout dossier $Path sur le disque");
      }
    echo " ";
    break;

  case 'DelFolder':
    $Path = urldecode($_GET['Path']);
    if(!@rmdir($Path))
      echo "<font color='red'><b>ERREUR :</b> Ne peut supprimer le repertoire</font>";
    else
      MyLog($Db,$_SESSION['User']['uid'],3,"Suppression dossier $Path sur le disque");
    echo " ";
    break;
  
  case 'RenFolder':
    $OldPath = urldecode($_GET['OldPath']);
    $NewPath = urldecode($_GET['NewPath']);
    rename($OldPath,$NewPath);
    break;
    
  case 'DisplayFolders':
    $uniqueid=0;
    print DisplayFolders();
    break;
    
  default:
    echo $Option . "" . $Path;
    echo " ";
    break; 
  }
?>

