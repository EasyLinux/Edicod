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


$HTML = "
<!-- Manuel -->
<div class='main' >
<table border='0' cellspacing='0' cellpadding='0' width='750px'>
  <tr>
    <td class='CadreTopLeft'></td>
    <td class='CadreTop'>Manuel d'Edicod</td>
    <td class='CadreTopRight'></td>
  </tr>
  <tr>
    <td class='CadreLeft'></td>
    <td class='CadreContent'>
    <iframe style='width: 720px;height: 600px;border: 0px solid #fff;' src='/tutorials/Documentation/index.html'></iframe>
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


// Ajax
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
    
  default :
    break;
}

?>
