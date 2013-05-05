<?php
/**
 * Ajout d'un document 'à la main'
 * 
 * @package		Composants
 * @subpackage		AddDocument
 * @access		public
 * @version		0.9
 * @author              Serge NOEL
 * @todo		A valider
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
$Html->add_js_file("/js/dtree.js");
$Html->add_js_file("/components/AddDocument/AddDocument.js");

$HTML = "
<!-- AddDocument -->
<div class='main' >
<table border='0' cellspacing='0' cellpadding='0' width='880px'>
  <tr>
    <td class='CadreTopLeft'></td>
    <td class='CadreTop'>Ajouter un document</td>
    <td class='CadreTopRight'></td>
  </tr>
  <tr>
    <td class='CadreLeft'></td>
    <td class='CadreContent'>
      <form name='AddDocument' id='AddDocument' action='/components/AddDocument/AddDocument.php?Option=SaveDocument' method='post' enctype='multipart/form-data'>
        <input type='hidden' name='did' value='-1' />
      
      </form>
      <div class='formButtons2' style='width:840px;' >
        <span class='formButtonsItemL' >
          <img src='/img/Chrono/filesave.png' class='ImgButton' alt='Sauvegarder' title='Sauvegarder' onClick='document.getElementById(\"AddDocument\").submit();' />
        </span>
        <span class='formButtonsItemR' >
          <img src='/img/Chrono/door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='ADQuit();' />
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


/* Partie Ajax */
session_start();
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
  case 'SaveDocument':
    print_r( $_POST );
    break;
    
  default:
    break;
  }
  
?>
