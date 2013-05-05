<?php
/**
 * Gestion de
 * 
 * @package		Composants
 * @subpackage		Paramètres
 * @access		public
 * @version		1.2
 * @author              Serge NOEL
 */
 
/**
 * Fonction appellée par index.php pour afficher le composant
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
$Html->add_js_file("/components/TEMPLATE/TEMPLATE.js");

$HTML = "
<!-- TEMPLATE -->
<div class='main' >
<table border='0' cellspacing='0' cellpadding='0' width='650px'>
  <tr>
    <td class='CadreTopLeft'></td>
    <td class='CadreTop'>TITLE</td>
    <td class='CadreTopRight'></td>

  </tr>
    <td class='CadreLeft'></td>
    <td class='CadreContent'>&nbsp;</br>
    <div style='width: 590px; height: 350px; border: 1px solid black; margin-left: 10px; overflow-y: auto'>
    </div>
    <div class='formButtons'>
      <div class='formButtonsItem' style='width: 31%; margin-left: 10px' >
        <img src='/img/Folders/folder_add.png' class='ImgButton' alt='Ajouter' title='Ajouter' onClick='Add();' />
      </div>
      <div class='formButtonsItem' style='width: 31%; margin-left: 10px' >
        <img src='/img/Folders/folder_del.png' class='ImgButton' alt='Supprimer' title='Supprimer' onClick='Del();' />
      </div>
      <div class='formButtonsItem' style='width: 31%; margin-left: 10px' >
        <img src='/img/Folders/folder_ren.png' class='ImgButton' alt='Supprimer' title='Renommer' onClick='Rename();' />
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
<!-- TEMPLATE -->\n";
return $HTML;
}

/* Partie Ajax */
session_start();
$Option = $_GET['Option'];
if( empty($Option) )
  $Option = $_POST['Option'];
$BaseURL = $_SERVER["DOCUMENT_ROOT"];
require_once("$BaseURL/inc/Db.Inc.php");
require_once("$BaseURL/inc/lib.inc.php");

$Db = new db($_SESSION['Parameters']['SqlEngine'], $_SESSION['Parameters']['SqlSvr'], $_SESSION['Parameters']['SqlBase'], 
             $_SESSION['Parameters']['SqlUsr'] , $_SESSION['Parameters']['SqlPwd']);

switch( $Option )
  {
  default:
    break;
  }
  
?>
