<?php
/**
 * Formulaire de recherche de document.
 *
 *  wichpart de la table dockeywords désigne:
 *     0 Objet
 *     1 keywords saisis
 *     2 keywords trouvés
 *
 * @package		Composants
 * @subpackage		Find
 * @param		object		Pointe sur l'object base de donnees
 * @param		object		Pointe sur l'object gui.html
 * @version		1.0
 * @author              Serge NOEL
 *
 */

$Empty = 0;

/**
 * Initialisation du composant
 *
 * @ignore
 */
function ContentInit($Db, $Html)
{
	session_start();

	$Script = str_replace($_SERVER["DOCUMENT_ROOT"],"",__FILE__);

	$Html->add_js_file("/js/prototype.js");
	$Html->add_js_file("/js/effects.js");
	$Html->add_js_file("/js/window.js");
	$Html->add_js_file("/js/ajax.js");
	$Html->add_js_file("/js/php.js");
	$Html->add_js_file("/js/calpopup.js");		// Cal
	$Html->add_js_file("/js/dtree.js");

	$Html->add_js_file("/components/FrontPage/FrontPage.js");
	$Html->add_js_file("/components/FrontPage/FrontPageEdit.js");
	$Html->add_js_file("/components/FrontPage/FrontPageEditNote.js");
	$Html->add_js_file("/components/Contact/Contact.js");
	$Html->add_js_file("/components/EditFile/EditFile.js");
	$Html->add_js_file("/components/DocFolders/DocFolders.js");
	$Html->add_js_file("/components/UploadFileAttach/UploadFileAttach.js");
	$Html->add_js_file("/components/Find/Find.js");

	$Html->add_js_file("/components/EditFile/js/tinymce/jscripts/tiny_mce/tiny_mce.js");

	$Html->add_css("/css/lighting.css");
	$Html->add_css("/css/calendar.css");
	$Html->add_css("/css/default.css");

	$Content  = "

<!-- Find : $Script -->
<div class='main'>
 <form name='Find' id='Find' action='#' method='post'>
   <table border='0' cellspacing='0' cellpadding='0' width='720px'> 
    <tr>
      <td class='CadreTopLeft'></td>
      <td class='CadreTop'>Recherche de courrier</td>
      <td class='CadreTopRight'></td>
    </tr>
    <tr>
      <td class='CadreLeft'></td>
      <td class='CadreContent'>&nbsp;<br />

       <fieldset id='-1'> 
        <legend>Recherche par date</legend>
        <div class='fpPopDiv1'>Date</div>
        <div class='fpPopDiv2'>
          de
          <img src='/img/FrontPage/calendar.png' onClick=\"showMyCalendar('startdate', '%d/%m/%Y',CalDate);\" alt='Afficher calendrier' title='Afficher calendrier' class='ImgButtonBar' />
          <input type='text' class='fpPopInp4' id='startdate' style='width: 80px' readonly='readonly' value='".date("d/m/Y")."' />
          &agrave;
          <img src='/img/FrontPage/calendar.png' onClick=\"showMyCalendar('EndDate', '%d/%m/%Y',CalDate);\" alt='Afficher calendrier' title='Afficher calendrier' class='ImgButtonBar' />
          <input type='text' class='fpPopInp4' id='EndDate' style='width: 80px' readonly='readonly' value='".date("d/m/Y")."' />
        </div>
        <div class='fpPopDiv1' >
          <select id='tDate' name='tDate' class='fpPopInp3'>
            <option value='a' selected='selected'>Arriv&eacute;e</option>
            <option value='d'>D&eacute;part</option>
            <option value='l'>Limite</option>
          </select>
        </div>
       </fieldset>
       <fieldset>
        <legend>Param&egrave;tres</legend>
          <div class='fpPopDiv1'>Exp&eacute;diteur</div>
          <div class='fpPopDiv2' style='width: 500px'>
            <img src='/img/FrontPage/User.png' onClick=\"DisplayContacts();\" alt='Choisir expéditeur' title='Choisir expéditeur' class='ImgButton' />
            <input type='text' class='fpPopInp4' style='width: 230px' id='sender' name='sender' readonly='readonly' />
          </div> 
          <div class='fpPopDiv1'>Num&eacute;ro</div>
          <div class='fpPopDiv2' style='width: 400px'>
           <input type='text' class='fpPopInp2' id='numero' />
           <input type='radio' value='Recom' id='numtype' name='numtype' />Recommand&eacute;
           <input type='radio' value='Chrono' id='numtype' name='numtype' checked='checked' />Chrono
          </div>
     </fieldset>

     <fieldset id='-1'>
      <legend>Recherche par mots cl&eacute;s</legend>
      <table>
       <tr>
        <!--<td>Rechercher les mots suivants</td>
        <td style='visibility:hidden;'>dans</td>-->
       </tr>
       <tr>
        <td> 
          <label for='keywords'>Rechercher les mots suivants :</label><input onkeypress='if(event.keyCode==13) SearchFindWhenPressEnter();' name='keywords' id='keywords' class='fpComment' style='width: 500px;height:15px;'></input>
        </td>
        <td style='visibility:hidden;'>
          <input type='checkbox' checked='checked' id='subject' name='subject'>Objet<br />
          <input type='checkbox' checked='checked' id='kws' name='keywords'>Mots clés<br />
          <input type='checkbox' checked='checked' id='autokeys' name='autokeys'>Mots du document
        </td>
       </tr>
      </table>
     </fieldset>\n";

	$Content .= "<fieldset id='-1'>\n <legend>R&eacute;sultats de la recherche</legend>\n";
	$Content .= "<div class='fpContent' style='height: 100px; width: 670px' id='Result' >&nbsp;</div>\n";
	$Content .= "</fieldset>\n";

	$Content .= "<div class='formButtons2' style='width:650px;'>\n";
	$Content .= "  <div class='formButtonsItemL'>\n";
	$Content .= "   <img src='/img/Find/Find.png' class='ImgButton' alt='Recherche' title='Recherche' onClick='SearchFind();' />\n";
	$Content .= "  </div>\n";
	$Content .= "  <div class='formButtonsItemR'>\n";
	$Content .= "   <img src='/img/Find/Door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='FindQuit();' />\n";
	$Content .= "  </div>\n";
	$Content .= "</div>\n";


	$Content .= "      </td>\n";
	$Content .= "      <td class='CadreRight'></td>\n";
	$Content .= "    <tr>\n";
	$Content .= "    </tr>\n";
	$Content .= "      <td class='CadreBottomLeft'></td>\n";
	$Content .= "      <td class='CadreBottom'></td>\n";
	$Content .= "      <td class='CadreBottomRight'></td>\n";
	$Content .= "    <tr>\n";
	$Content .= "  </table>\n</div>\n";
	$Content .= "<div id='overlay_modal' class='overlay_bluelighting' style='position: absolute; top: 0px; left: 0px; z-index: 5; width: 100%; ";
	$Content .= "height: 100%; opacity: 0.6; display: none;'/>\n</div>\n</form>\n";
	$Content .= "<div id='MyPopup' style='display: none'>\nPOPUP\n</div>\n";
	$Content .= "<div id='Status' style='width: 900px;'></div><!-- /FrontPage -->\n\n";
	$Content .= "<div id='DivCalDate' style='z-index: 15; opacity: 1.0; position: absolute; background-color: #BFDBFF' ></div>\n";
	$Content .= "\n
<script type='text/javascript'>

// Fenetre popup
win = new Window('MyPop',{className: \"bluelighting\", closable:false, resizable:false, maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
win.setZIndex(10);
CalDate = new CalendarPopup('DivCalDate');

</script>\n";

	return $Content;
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
	case 'Search':
		// Caractères parasites
		$FR = array( 'à' => 'a', 'á' => 'a', 'â'=>'a', 'ã' => 'a', 'ä'=> 'a',
              'ç' => 'c',
              'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
              'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
              'ñ' => 'n',
              'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
              'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
              'ý' => 'y', 'ÿ' => 'y',
              'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
              '+' => ' ', '-' => ' ', '(' => ' ', ')' => ' ', '{' => ' ', '}' => ' ', '_' => ' ', '°' => ' ', '\'' => ' ', ':' => ' ', '%' => ' ', '.' => ' ', ',' => ' ', ';' => ' ',
              '?' => ' ', '/' => ' ', '\\' => ' ', '!' => ' ', '&' => ' ', '[' => ' ', ']' => ' ', '|' => ' ', '@' => ' ', '=' => ' ', '€' => 'e' ,'*' => ' ', "\n" => ' ', "\r" => ' ',
              '\t' => ' '
              //ÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'
		);
		$And = "";
		$Where = "";
		// Récupérer les données
		if( $_POST['StartDate'] != $_POST['EndDate'] )
		{ // 01/02/2001
			$StartDate = "'". substr($_POST['StartDate'],6,4). "-" .substr($_POST['StartDate'],3,2). "-" .substr($_POST['StartDate'],0,2) . " 00:00:00'";
			$EndDate   = "'". substr($_POST['EndDate'],6,4).   "-" .substr($_POST['EndDate'],3,2).   "-" .substr($_POST['EndDate'],0,2)   . " 23:59:59'";
			switch( $_POST['TypeDate'] )
			{
				case 'a':
					$Where = "(date_in BETWEEN $StartDate AND $EndDate)";
					break;
				case 'd':
					$Where = "(date_out BETWEEN $StartDate AND $EndDate)";
					break;
				case 'l':
					$Where = "(date_due BETWEEN $StartDate AND $EndDate)";
					break;
			}
			$And = " AND ";
		}
		if( !empty($_POST['Sender']) )
		{
			$Where .= "$And sender='".$_POST['Sender']."'";
			$And = " AND ";
		}

		if( !empty($_POST['Num']) )
		{
			if( $_POST['NumType'] == "Chrono" )
			$Where = "did=". intval($_POST['Num']);  // On cherche un seul document le reste des conditions est inutile
			else
			$Where .= "$And recom='" . $_POST['Num'] ."'";
			$And = " AND ";
		}

		if( empty($_POST['Keywords']) )
		$Sql = "SELECT * FROM documents AS doc, wf_steps AS wfs WHERE wfs.wfsid=doc.wfsid AND $Where;";
		else
		{  // Recherche par mots clés
			$Where .= $And ."(";
			$Or="";
			if( $_POST['Subject'] )
			{
				$Where .= "wichparts=1";
				$Or = " OR ";
			}
			if( $_POST['Kws'] )
			{
				$Where .= "$Or wichparts=2";
				$Or = " OR ";
			}
			if( $_POST['Autokeys'] )
			{
				$Where .= "$Or wichparts=3";
				$Or = " OR ";
			}
			$Where .= ") ";
			// Arrange les mots clés
			$Keywords = strtr(strtolower(urldecode($_POST['Keywords'])),$FR);
			$aKeys = explode(" ",$Keywords);
			$Or="";
			$Like="(";
			foreach($aKeys as $Key)
			{
				$Like .= $Or."kw.keyword LIKE '%$Key%'";
				$Or = " OR ";
			}
			$Like .= ")";
			$Sql  = "SELECT *,sum(occurs) as Results, wfs.description as wfsdescription \n";
			$Sql .= "   FROM keywords as kw, dockeywords as dk, documents as d, wf_steps as wfs, workflow as wf \n";
			$Sql .= "   WHERE kw.kid = dk.kid AND dk.did=d.did AND d.wfsid=wfs.wfsid AND wf.wid=wfs.wid AND $Where AND $Like \n";
			$Sql .= "   GROUP BY dk.did \n";
			$Sql .= "   ORDER BY d.date_in DESC;";
		}
		//print $Sql;
		$Db->Query($Sql);
		$Lignes = $Db->loadObjectList(); //couleur de base pour la barre : #C5DEDF (au ieu de #BFDBFF)
		$Out  = "<table width='100%' cellspacing='0' cellpadding='0'>\n";
		$Out .= " <tr>\n";
		$Out .= "<td style='background: #BFDBFF; border-right: 1px solid Gray;' width='90px'><b>Date r&eacute;ception</b></td>";
		$Out .= "<td style='background: #BFDBFF; border-right: 1px solid Gray;' width='90px'><b>Date fin</b></td>";
		$Out .= "<td style='background: #BFDBFF; border-right: 1px solid Gray;' width='90px'><b>Workflow</b></td>\n";
		$Out .= "<td style='background: #BFDBFF; border-right: 1px solid Gray' width='90px'><b>Etat</b></td>";
		$Out .= "<td style='background: #BFDBFF;'><b>Objet</b></td>\n";
		$Out .= " </tr>\n";
		
		$ColorBackgroundLine = "style='background:#AFCBEF;'";
		
		foreach($Lignes as $Ligne)
		{
			$MaDateIn = substr($Ligne->date_in,8,2)."/".substr($Ligne->date_in,5,2)."/".substr($Ligne->date_in,0,4);
			$MaDateOut = substr($Ligne->date_out,8,2)."/".substr($Ligne->date_out,5,2)."/".substr($Ligne->date_out,0,4);
			if($MaDateOut == '//') {
				$MaDateOut = 'En cours';
			}
				
			$Out .= " <tr $ColorBackgroundLine>\n";
			$Out .= "	<td style='border-right: 1px solid Gray'>$MaDateIn</td>";
			$Out .= "	<td style='border-right: 1px solid Gray'>$MaDateOut</td>";
			$Out .= "	<td style='border-right: 1px solid Gray'>$Ligne->name</td>";
			$Out .= "  	<td style='border-right: 1px solid Gray'>".$Ligne->wfsdescription."</td>";
			$Out .= "	<td><a href='#' onClick='DisplayFile(\"".$Ligne->did."\");' style='text-decoration: none;'>".$Ligne->object."</a></td>\n";
			$Out .= " </tr>\n";
				
			if($ColorBackgroundLine == "style='background:#AFCBEF;'") {
				$ColorBackgroundLine = "style='background:#BFDBFF;'";
			}
			else {
				$ColorBackgroundLine = "style='background:#AFCBEF;'";
			}
		}
		$Out .= "</table>";
		print $Out;
		//print_r($Ligne);
		$Db->Close();
		break;

	default:
		//print "Option: $Option";
		break;
}

/*
 SELECT * FROM keywords as kw, dockeywords as dk WHERE kw.kid = dk.kid AND wichparts=3 AND (kw.keyword='description' OR kw.keyword = 'avion') ORDER BY occurs DESC

 SELECT * FROM keywords as kw, dockeywords as dk WHERE kw.kid = dk.kid AND (kw.keyword='description' OR kw.keyword = 'avion') ORDER BY occurs DESC

 SELECT * FROM keywords as kw, dockeywords as dk WHERE kw.kid = dk.kid AND (kw.keyword LIKE 'desc%' OR kw.keyword = 'avion') ORDER BY occurs DESC

 SELECT * FROM keywords as kw, dockeywords as dk, sum(occurs) as Results WHERE kw.kid = dk.kid AND (kw.keyword LIKE 'desc%' OR kw.keyword = 'avion') GROUP BY Results ORDER BY occurs DESC

 SELECT *,sum(occurs) as Results FROM keywords as kw, dockeywords as dk, documents as d WHERE kw.kid = dk.kid AND dk.did=d.did AND (kw.keyword LIKE '%desc%' OR kw.keyword = 'avion') GROUP BY dk.did ORDER BY sum(occurs) DESC

 SELECT * FROM dockeywords as dk WHERE wichparts=3 AND kw.keyword='description' AND kid=12 ORDER BY occurs DESC
 */
?>

