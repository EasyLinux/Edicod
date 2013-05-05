<?php

define("INSTALL_SERVER","http://EdiRelease.edicia.fr");

function ContentInit($Db, $Html)
{
global $uniqueid;
session_start();
$Html->add_js_file("/js/ajax.js");
$Html->add_js_file("/js/prototype.js");
$Html->add_js_file("/js/effects.js");
$Html->add_js_file("/js/window.js");
$Html->add_js_file("/js/php.js");
$Html->add_js_file("/components/Publish/Publish.js");
$Html->add_css("/css/default.css");
$Html->add_css("/css/lighting.css");

$CurPath = $_SERVER["DOCUMENT_ROOT"];

$Content = "
<!-- Update -->
<div class='main' >
<table border='0' cellspacing='0' cellpadding='0' width='720px'>
  <tr>
    <td class='CadreTopLeft'></td>
    <td class='CadreTop'>Publication des modifications</td>
    <td class='CadreTopRight'></td>
  </tr>
    <td class='CadreLeft'></td>
    <td class='CadreContent'>&nbsp;</br>
    <div class='formPopupLine' style='height: 35px; width: 670px; margin-left: 10px; overflow-y: auto; float: left' id='dVersions'>
      <span class=\"formPopupL\" style=\"width: 200px\">Versions stock&eacute;es</span>
    </div>
    <div class='formPopupLine' style='height: 35px; width: 670px; margin-left: 10px; overflow-y: auto; float: left' id='dVersions'>
      <span class=\"formPopupL\" style=\"width: 200px\">Version &agrave; publier </span>
      <input type='text' name='NewVersion' id='NewVersion' value='' class='fpPopInp2' style='width: 165px; display: none' />&nbsp;&nbsp;
      <input type='button' id='Go' onclick='Go();' value='Envoyer' style='display: none' />
    </div>
    <div class='formPopupLine' style='height: 35px; width: 670px; margin-left: 10px; overflow-y: auto; float: left' >
      <span class=\"formPopupL\" style=\"width: 200px\">Description </span>
      <input type='text' name='Description' id='dDesc' value='' class='fpPopInp2' style='width: 200px; display: none' />
    </div>
    <div class='formPopupLine' style='height: 160px; width: 670px; margin-left: 10px; overflow-y: auto; float: left' >
      <span class=\"formPopupL\" style=\"width: 200px\">Commentaire </span>
      <textarea id='Comment' class='fpPopInp5' style='width: 430px; height: 150px; margin-left: 220px; display: block'></textarea>
    </div>
    <div class='formPopupLine' style='height: 35px; width: 670px; margin-left: 10px; overflow-y: auto; float: left' >
      <span class=\"formPopupL\" style=\"width: 200px\">Chemin </span>
      <span id='Path' style='width: 200px; display: inline' />$CurPath</span>
    </div>
    <div class='formPopupLine' style='height: 35px; width: 670px; margin-left: 10px; overflow-y: auto; float: left' >
      <span class=\"formPopupL\" style=\"width: 200px\">Nombre de r&eacute;pertoires </span>
      <span id='nbPath' style='width: 200px; display: inline' /></span>
    </div>
    <div class='formPopupLine' style='height: 35px; width: 670px; margin-left: 10px; overflow-y: auto; float: left' >
      <span class=\"formPopupL\" style=\"width: 200px\">Copie en cours </span>
      <span id='Copy' style='width: 200px; display: inline' /></span>
    </div>
    <div style='width: 670px; margin-left: 10px; overflow-y: auto; float: left; background-color: #AFCBDF' id='StatusBar' >Etat: Interroge le serveur...</div>
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
<script type='text/javascript'>

setTimeout( 'sendData()', 500);
// Fenetre popup
win = new Window('MyPop',{className: \"bluelighting\", closable:false, resizable:false, maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
win.setZIndex(10);
</script>

<div id='Status' class='Status'></div>
<div id='MyPopup' style='display: none'></div>
<div id='overlay_modal' class='overlay_bluelighting' style='position: absolute; top: 0px; left: 0px; z-index: 5; width: 100%; height: 100%; opacity: 0.6; display: none;'/></div>
<!-- Update -->\n";
return $Content;
}

/***********************************************************
 * PostRequest                                             *
 *   Cette fonction permet de faire de l'Ajax hors domaine *
 *   NB: pour des raisons de sécurité, Javascript ne peut  *
 *       faire d'appel cross-domain                        *
 ***********************************************************/ 
function PostRequest($Url, $Data, $optional_headers = null)
{
$Params = array(
  'http' => array(
     'method' => 'POST',
     'content' => $Data));
  
if ($optional_headers !== null) 
  $Params['http']['header'] = $optional_headers;

$ctx = stream_context_create($Params);
$fp = @fopen($Url, 'rb', false, $ctx);
if (!$fp) 
  throw new Exception("Probl&eagrave;me avec $Url, $php_errormsg");

$answer = @stream_get_contents($fp);
if ($answer === false) 
  throw new Exception("Ne peut lire les donn&eacute;es depuis $Url, $php_errormsg");
return $answer;
}

function MyScanDir($Path)
{
global $Paths, $Idx, $Len;

$Dh = opendir($Path);
if( $Dh == false )
  $Paths[0] == "Erreur";
while( ($File=readdir($Dh)) !== false)
  {
  if( is_dir($Path.$File) && (substr($File,0,1) != "."))
    {
    $Paths[$Idx] = substr($Path.$File,$Len);
    $Idx++;
    MyScanDir($Path.$File."/");
    }
  }
closedir($Dh);
}






session_start();
$Option = $_GET["Option"];
switch( $Option ) 
  {
  case 'GetVersions':
    $Xml  = "<?xml version='1.0' encoding='UTF-8' ?>\n";
    $Xml = "<EdiReleaseQuestion>\n";
    $Xml .= "  <Login>".$_SESSION["User"]["Login"]."</Login>\n";
    $Xml .= "  <Passwd>".$_SESSION["User"]["Passwd"]."</Passwd>\n";
    $Xml .= "  <Function>GetVersions</Function>\n";
    $Xml .= "</EdiReleaseQuestion>\n";
    $RepXml = PostRequest(INSTALL_SERVER."/Releases.php","Xml=".urlencode($Xml));
    $ArbreXml = simplexml_load_string($RepXml);
    if( $ArbreXml->Login == "Bad" || $ArbreXml->Access == "Read")
      if($ArbreXml->Login == "Bad")
        echo "<b>Erreur:</b> <font color='red'>authentification refus&eacute;e sur le serveur</font>";
      else
        echo "<b>Erreur:</b> <font color='red'>droits insuffisants sur le serveur</font>";
    else
      {
      $Html  = "<span class=\"formPopupL\" style=\"width: 200px\">Versions stock&eacute;es</span>";
      $Html .= "<select id=\"Ver\" class=\"fpPopInp2\" style=\"width: 165px\" name=\"Ver\">\n";
      foreach($ArbreXml->Versions->Version as $Version)
        $Html .= "    <option value=\"$Version\">$Version</option>\n";
      $Html .= "  </select>";
      echo $Html;
      }
    break;
    
  case 'NewVersion':
    $Version     = $_POST["Version"];
    $Description = $_POST["Description"];
    $Comment     = $_POST["Comment"];
    $Xml  = "<?xml version='1.0' encoding='UTF-8' ?>\n";
    $Xml = "<EdiReleaseQuestion>\n";
    $Xml .= "  <Login>".$_SESSION["User"]["Login"]."</Login>\n";
    $Xml .= "  <Passwd>".$_SESSION["User"]["Passwd"]."</Passwd>\n";
    $Xml .= "  <Function>CreateRepo</Function>\n";
    $Xml .= "  <Params>\n";
    $Xml .= "    <Version>$Version</Version>\n";
    $Xml .= "    <Description>$Description</Description>\n";
    $Xml .= "    <Comment>$Comment</Comment>\n";
    $Xml .= "  </Params>\n";
    $Xml .= "</EdiReleaseQuestion>\n";
    $RepXml = PostRequest(INSTALL_SERVER."/Releases.php","Xml=".urlencode($Xml));
    $ArbreXml = simplexml_load_string($RepXml);
    echo $ArbreXml->LastId;
    break;
  
  case 'ScanDirs':
    $Path[0] ="";
    $Idx = 1;
    $Len = strlen($_SERVER["DOCUMENT_ROOT"]);
    MyScandir($_SERVER["DOCUMENT_ROOT"]);
    $sPath = "|";
    foreach($Paths as $Path)
      $sPath .= $Path."|";
    echo count($Paths).";".$sPath;
    break;
    
  case 'Copy':
/*****************************************************************************
*  Cette partie est effectuée en plusieurs parts:                            *
*    1 - analyse des fichiers (md5, nom, taille) dans le répertoire courant  *
*        puis envoi au serveur                                               *
*    2 - le serveur répond en listant les fichiers à envoyer                 *
*    3 - renvoi des fichiers en encodage 64                                  *
******************************************************************************/
    // Construction de la requête
    $Path = $_POST['Dir'];
    if( $Path != "" )
      $Path = "/".$Path;
    $Dir = $_SERVER["DOCUMENT_ROOT"].$_POST['Dir'];
    $Xml  = "<?xml version='1.0' encoding='UTF-8' ?>\n";
    $Xml  = "<EdiReleaseQuestion>\n";
    $Xml .= "  <Login>".$_SESSION["User"]["Login"]."</Login>\n";
    $Xml .= "  <Passwd>".$_SESSION["User"]["Passwd"]."</Passwd>\n";
    $Xml .= "  <Function>AskCopy</Function>\n";
    $Xml .= "  <Path>$Path</Path>\n";
    $Xml .= "  <idRelease>".$_POST['idRelease']."</idRelease>\n";
    $Xml .= "  <Files>\n";

    $Dh = opendir($Dir);
    if( substr($Dir,-1) != "/" )
      $Dir .= "/";
    if( $Dh == false )
      echo "Erreur";
    else
      {
      while( ($File=readdir($Dh)) !== false)
        {
        if( is_file($Dir.$File) && (substr($File,0,1) != ".") && !(substr($File,-1) == "~") )
          {  // les renseignements
          $Xml .= "    <File>\n";
          $Xml .= "      <Name>$File</Name>\n";
          $Xml .= "      <Size>".filesize($Dir.$File)."</Size>\n";
          $Xml .= "      <md5>".md5(file_get_contents($Dir.$File))."</md5>\n";
          $Xml .= "    </File>\n";
          }
        }
      }
    closedir($Dh);
    $Xml .= "  </Files>\n";
    $Xml .= "</EdiReleaseQuestion>\n";
    // Envoi au serveur1
    $RepXml = PostRequest(INSTALL_SERVER."/Releases.php","Xml=".urlencode($Xml));
    // traite la réponse
    $ArbreXml = simplexml_load_string($RepXml);
    $Xml  = "<?xml version='1.0' encoding='UTF-8' ?>\n";
    $Xml  = "<EdiReleaseQuestion>\n";
    $Xml .= "  <Login>".$_SESSION["User"]["Login"]."</Login>\n";
    $Xml .= "  <Passwd>".$_SESSION["User"]["Passwd"]."</Passwd>\n";
    $Xml .= "  <Function>CopyFile</Function>\n";
    $Xml .= "  <idPath>".$ArbreXml->idPath."</idPath>\n";
    $Xml .= "  <idRelease>".$_POST['idRelease']."</idRelease>\n";
    $Xml .= "  <Files>\n";
    foreach( $ArbreXml->Files->File as $File )
      {
      $Xml .= "    <File>\n";
      $Xml .= "      <Name>".$File->Name."</Name>\n";
      $Xml .= "      <Size>".$File->Size."</Size>\n";
      $Xml .= "      <md5>".$File->md5."</md5>\n";
      $Xml .= "      <Copy>".$File->Copy."</Copy>\n";
      if( $File->Copy == "Yes" )
        $Xml .= "      <Content>".base64_encode(file_get_contents($Dir.$File->Name))."</Content>\n";
      $Xml .= "    </File>\n";
      }   
    $Xml .= "  </Files>\n";
    $Xml .= "</EdiReleaseQuestion>\n";
    $RepXml = PostRequest(INSTALL_SERVER."/Releases.php","Xml=".urlencode($Xml));
    echo " ok";
    break;
    
    
  default:
  }

?>
