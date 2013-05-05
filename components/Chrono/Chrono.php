<?php
/**
 * Gestion du chrono
 *
 * @package		Composants
 * @subpackage		Chrono
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
	session_start();
	$Html->add_js_file("/js/prototype.js");
	$Html->add_js_file("/js/effects.js");
	$Html->add_js_file("/js/window.js");
	$Html->add_js_file("/js/ajax.js");
	$Html->add_js_file("/js/php.js");
	//$Html->add_js_file("/js/calpopup.js");
	$Html->add_js_file("/components/Chrono/Chrono.js");
	$Html->add_js_file("/components/EditFile/EditFile.js");
	$Html->add_js_file("/components/FrontPage/FrontPage.js");
	$Html->add_js_file("/components/FrontPage/FrontPageEdit.js");
	$Html->add_js_file("/components/FrontPage/FrontPageEditNote.js");
	
	$Html->add_js_file("/components/EditFile/js/tinymce/jscripts/tiny_mce/tiny_mce.js");

	$Html->add_css("/css/default.css");
	$Html->add_css("/css/lighting.css");

	//NB: ne sont listés que les documents qui sont attribués
	$Sql = "SELECT dc.date_in, dc.did, dc.object, dc.name, dc.path, dc.wfsid, wfd.wfsid, wfd.col  FROM documents AS dc, wf_details as wfd  WHERE dc.wfsid=wfd.wfsid AND col!=0 GROUP BY did ORDER BY did DESC";
	$Db->Query($Sql);
	$Rows = $Db->loadObjectList();
	$RelativePath = $_SESSION["Parameters"]["RelativeDocuments"];

	$HTML = "
<!-- Chrono -->
<div class='main' >
<table border='0' cellspacing='0' cellpadding='0' width='850px'>
  <tr>
    <td class='CadreTopLeft'></td>
    <td class='CadreTop'>Affichage du chrono</td>
    <td class='CadreTopRight'></td>
  </tr>
  </tr>
    <td class='CadreLeft'></td>
    <td class='CadreContent'>&nbsp;<br />
      <div style='border: 1px solid gray; margin-left: 10px'>
        <div style='height: 20px; border-bottom: 1px solid gray;'>
          <div class='fpLineDiv' style='width: 80px'><b>Date</b></div>
          <div class='fpLineDiv' style='width: 80px'><b>Heure</b></div>
          <div class='fpLineDiv' style='width: 80px'><b>N&deg;</b></div>
          <div class='fpLineDiv' style='width: 570px;'><b>Description</b> 
        </div>
        </div>   
        <div style='overflow-y: scroll; height: 300px; width: 815px;'>\n";
	foreach( $Rows as $Row)
	{
		$Date = substr($Row->date_in,8,2) . "/" . substr($Row->date_in,5,2) . "/" . substr($Row->date_in,0,4); // 2010-02-28 15:20:03
		$Time = substr($Row->date_in,11,8);
		$RelativeFileName = $RelativePath . $Row->path ."/". $Row->name;
		$HTML .= "          <a href='#' onClick='DisplayFile(". $Row->did .");' class='fp' >
            <div class='fpLineDiv' style='width: 80px'>$Date</div>
            <div class='fpLineDiv' style='width: 80px'>$Time</div>
            <div class='fpLineDiv' style='width: 80px'>".$Row->did."</div>
            <div class='fpLineDiv' style='width: 490px;'>".$Row->object."</div>
          </a>\n";
	}
	$HTML .= "      </div>
    </div>
    <div class='formButtons2' style='width:815px;'>
      <div class='formButtonsItemR'  >
        <img src='/img/Folders/Door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='ChronoQuit();' />
      </div>
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
<script type='text/javascript'>
var win;
// Fenetre popup
win = new Window('MyPop',{className: \"bluelighting\", closable:false, resizable:false, maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
</script>

<div id='Status' class='Status'></div>
<div id='MyPopup' style='display: none'></div>
<div id='overlay_modal' class='overlay_bluelighting' style='position: absolute; top: 0px; left: 0px; z-index: 5; width: 100%; height: 100%; opacity: 0.6; display: none;'/></div>
<!-- Chrono -->\n";
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
