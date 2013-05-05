<?php
/**
 * Gestion des contacts.
 * Ce composant gère les contacts utilisés dans l'application
 *
 * @package		Composants
 * @subpackage		Contact
 * @version		1.2
 * @author              Serge NOEL
 * @todo                Prendre en compte les contacts externes (via plug-in)
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
	$Html->add_js_file("/components/Contact/Contact.js");
	$Html->add_js_file("/components/FrontPage/FrontPage.js");

	$ListUser = array(
  "Sql"     => "SELECT * FROM contact ORDER BY company;",
  "Name"    => "ListContact",
  "Action"  => "#",
  "Method"  => "post",
  "Title"   => "&nbsp;Contacts",
  "Width"   => 703,
  "Height"  => 400,
  "ListW"   => 680,
  "ListH"   => 300,
  "FieldId" => "conid",
  "Init_JS" => "",
  "Fields"  => array(
	array("&nbsp;Id","conid",40,40),
	array("&nbsp;Actif","valid",45,45),
	array("&nbsp;Raison sociale","company",140,140),
	array("&nbsp;Nom","name",140,140),
	array("&nbsp;Pr&eacute;nom","given_name",140,140),
	array("&nbsp;Ville","city",149,130)
	),
  "ButtonsLeft" => array(
	array("/img/UserAdmin/UserAdd.png","Ajouter","Add();"),
	array("/img/UserAdmin/UserEdit.png","Editer","Edit()"),
	array("/img/UserAdmin/UserDel.png","Supprimer","Delete();")

	),
  "ButtonsRight" => array(
	array("/img/UserAdmin/Door.png","Quitter","QuitContact();"),
	array("/img/UserAdmin/UserLock.png","Valider/D&eacute;valider","Lock();")
	)
	);

	$Content = "\n<!-- Contenu - ". __FILE__ . " -->\n<div class=\"main\">\n";
	$Content .= $Html->MakeHtmlList2($Db, $ListUser);
	$Content .= "</div>\n
<div id='overlay_modal' class='overlay_bluelighting' /></div>
<!-- Contenu -->\n\n";
	return ($Content);
}


function EditContact($Db, $Contact)
{
	if($Contact["genre"]=='Mr')
		$Checked_Mr = "checked='checked' ";
	else
		$Checked_Mr = "";
		
	if($Contact["genre"]=='Mme')
		$Checked_Mme = "checked='checked' ";
	else
		$Checked_Mme = "";
		
	if($Contact["genre"]=='Mlle')
		$Checked_Mlle = "checked='checked' ";
	else
		$Checked_Mlle = "";
		
	if($Contact["genre"]=='Aucun')
		$Checked_Aucun = "checked='checked' ";
	else
		$Checked_Aucun = "";
	
	$Html = "
<form name='EditContact' id='EditContact' action='#'>
  <div style='margin-left: auto;margin-right:auto;width:350px;'>
  <input name='conid' id='conid' value='". $Contact["conid"]. "' type='hidden'>
  &nbsp;<br />
  
  
  <div class='formPopupLine' style='height: 20px'>
    <span style='margin:0 0 0 12px; width: 40px'><input type='radio' name='genre' value='Mr' id='mr' $Checked_Mr /><label for='mr'>Mr</label></span>
    <span style='margin:0 0 0 30px; width: 40px'><input type='radio' name='genre' value='Mme' id='mme' $Checked_Mme /><label for='mme'>Mme</label></span>
    <span style='margin:0 0 0 30px; width: 40px'><input type='radio' name='genre' value='Mlle' id='mlle' $Checked_Mlle /><label for='mlle'>Mlle</label></span>
    <span style='margin:0 0 0 30px; width: 40px'><input type='radio' name='genre' value='Aucun' id='aucun' $Checked_Aucun /><label for='aucun'>Aucun</label></span>
  </div>
  <div class='fpPopDiv1' style='width: 140px'>Raison sociale</div>
  <div class='fpPopDiv2' style='width: 210px'>
    <input class='fpPopInp2' style='width: 200px' type='text' name='company' id='company' value='".$Contact["company"]."' /></div>
  <div class='fpPopDiv1' style='width: 140px'>Nom</div>
  <div class='fpPopDiv2' style='width: 210px'>
    <input class='fpPopInp2' style='width: 200px' type='text' name='name' id='name' value='".$Contact["name"]."' /></div>
  <div class='fpPopDiv1' style='width: 140px'>Pr&eacute;nom</div>
  <div class='fpPopDiv2' style='width: 210px'>
    <input class='fpPopInp2' style='width: 200px' type='text' name='given_name' id='given_name' value='".$Contact["given_name"]."' /></div>
  <div class='fpPopDiv1' style='width: 140px'>E-mail</div>
  <div class='fpPopDiv2' style='width: 210px'>
    <input class='fpPopInp2' style='width: 200px' type='text' name='email' id='email' value='".$Contact["email"]."' /></div>
  <div class='fpPopDiv1' style='width: 140px'>T&eacute;l&eacute;phone</div>
  <div class='fpPopDiv2' style='width: 210px'>
    <input class='fpPopInp2' style='width: 200px' type='text' name='phone' id='phone' value='".$Contact["phone"]."' /></div>
  <div class='fpPopDiv1' style='width: 140px; height: 25px'>Adresse</div>
  <div class='fpPopDiv2' style='width: 210px; height: 25px'>
    <input class='fpPopInp2' style='width: 200px;' type='text' name='address1' id='address1' value='".$Contact["address1"]."' /></div>
  <div class='fpPopDiv1' style='width: 140px'>&nbsp;</div>
  <div class='fpPopDiv2' style='width: 210px'>
    <input class='fpPopInp2' style='width: 200px' type='text' name='address2' id='address2' value='".$Contact["address2"]."'/></div>
  <div class='fpPopDiv1' style='width: 140px'>CP / Ville</div>
  <div class='fpPopDiv2' style='width: 210px'>
    <input class='fpPopInp2' style='width: 45px' type='text' name='zip' id='zip' value='".$Contact["zip"]."' />
    <input class='fpPopInp2' style='width: 140px; margin-left: 10px' type='text' name='city' id='city' value='".$Contact["city"]."' /></div>
  <div class='formButtons2' style='width:350px;padding:0;'>
    <div class='formButtonsItemL'>
     <img src='/img/UserAdmin/Save.png' class='ImgButton' alt='Sauvegarder' title='Sauvegarder' onClick='SaveContact();' />
    </div>
    <div class='formButtonsItemR'>
      <img src='/img/UserAdmin/Door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='CloseEditContact();' />
    </div>
  </div>
  </div>
</form>\n\n";

	return $Html;
}

function GetContacts($Db)
{
	$Sql = "SELECT * FROM contact ORDER BY name;";
	$Db->Query($Sql);
	return( $Db->loadArrayList() );
}


function DisplayContacts($Db, $ContactID, $parentWindowId, $inputSender, $inputConid)
{
	$Reps = GetContacts($Db);
	$Html="
    <!-- Fenetre parente -->
    <input type='hidden' id='parentContacts' value='".$parentWindowId."' />
    <div class='formLine1'>
      <span class='form_Box' style='width: 150px; cursor: pointer;' > Soci&eacute;t&eacute;</span>
      <span class='form_Item' style='width: 200px; cursor: pointer;' > Nom Pr&eacute;nom</span>
    </div>
    <div class='formList' style='width: 351px; height: 230px' >\n";

	foreach($Reps as $Rep)
	{
		$Html .= "<div class='formLine2'><span class='formBox' style='width: 150px;cursor: pointer;' onClick='SaveSender(".$Rep["conid"].",\"".$Rep["name"]." ".$Rep["given_name"]."\",\"".$inputConid."\", \"".$inputSender."\");'>".$Rep["company"];
		$Html .= "</span><span class='formItem' style='width: 175px;cursor: pointer;' onClick='SaveSender(".$Rep["conid"].",\"".$Rep["name"]." ".$Rep["given_name"]."\",\"".$inputConid."\", \"".$inputSender."\");'>".$Rep["name"]." ".$Rep["given_name"]."</span></div>\n";
	}
	//print_r( $Reps );
	$Html .= "

  </div>
  <div class='formButtons2' style='width: 300px;padding: 0 40px 0 40px;'>
  	<div class='formButtonsItemG'>
      <img src='/img/UserAdmin/UserAdd.png' class='ImgButton' alt='Ajouter' title='Ajouter' onClick='AddContact();' />
    </div>
    
    <div class='formButtonsItemR'>
      <img src='/img/UserAdmin/Door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='AbortContact();' />
    </div>
  </div>

\n\n";

	return $Html;
}

/**
 * Affiche les contacts
 * @param	  object  Base de données
 * @return	string	Chaine à afficher (code HTML)
 */
function ListContacts($Db)
{
$Reps = GetContacts($Db);
$Html = "
    <div class='formLine1'>&nbsp;</div>
    <div class='formLine1'>
      <span class='form_Box' style='width: 150px; cursor: pointer;' >&nbsp;Soci&eacute;t&eacute;</span>
      <span class='form_Item' style='width: 200px; cursor: pointer;' >&nbsp;Nom Pr&eacute;nom</span>
    </div>
    <div class='formList' style='width: 351px; height: 230px' >\n";

foreach($Reps as $Rep)
  {
  $ConId = $Rep["conid"];
  $Msg   = "(".$Rep["company"].") ".$Rep["name"]." ".$Rep["given_name"];
  $Html .= "<div class='formLine2'>";
  $Html .= "<span class='formBox' style='width: 150px;cursor: pointer;' onClick='SaveSender(\"$ConId\",\"$Msg\");' >";
	$Html .= "&nbsp;" . $Rep["company"] . "</span>";
	$Html .= "<span class='formItem' style='width: 175px;cursor: pointer;' onClick='SaveSender(\"$ConId\",\"$Msg\");' >";
	$Html .= "&nbsp;".$Rep["name"]." ".$Rep["given_name"]."</span></div>\n";
	}
$Html .= "
  </div>
  <div class='formButtons2' style='width: 300px;padding: 0 40px 0 40px;'>
  	<div class='formButtonsItemG'>
      <img src='/img/UserAdmin/UserAdd.png' class='ImgButton' alt='Ajouter' title='Ajouter' onClick='AddContact();' />
    </div>
    
    <div class='formButtonsItemR'>
      <img src='/img/UserAdmin/Door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='AbortContact();' />
    </div>
  </div>";

return $Html;
}


/* Partie Ajax */
session_start();
$Option = $_GET['Option'];
$BaseURL = $_SERVER["DOCUMENT_ROOT"];
require_once("$BaseURL/inc/Db.Inc.php");
require_once("$BaseURL/inc/lib.inc.php");

$Db = new db($_SESSION['Parameters']['SqlEngine'], $_SESSION['Parameters']['SqlSrv'], $_SESSION['Parameters']['SqlBase'],
$_SESSION['Parameters']['SqlUsr'] , $_SESSION['Parameters']['SqlPwd']);

switch( $Option )
{
	case 'Lock':
		$conid = $_GET['conid'];
		$query = "SELECT * FROM contact WHERE conid=$conid";
		// Interroger la base de données
		$Db->Query($query);
		$Rep = $Db->loadObject();
		if( $Rep->valid == 0 )
		$query = "UPDATE contact SET valid=1 WHERE conid=$conid";
		else
		$query = "UPDATE contact SET valid=0 WHERE conid=$conid";
		$Db->Query($query);
		$Db->Close();
		break;

	case 'Delete':
		$conid = $_GET['conid'];
		// Interroger la base de données
		$query = "DELETE FROM contact WHERE conid=$conid";
		$Db->Query($query);
		$Db->Close();
		break;

	case 'Read':
		$conid = $_GET['conid'];
		// Interroger la base de données
		$query  = "SELECT * FROM contact ";
		$query .= "WHERE conid=$conid ";
		$Db->Query($query);
		$Reps = $Db->loadArray();
		foreach(array_keys($Reps) as $Rep)
		{  // pas la peine de perdre notre temps avec des champs vides
			if(strlen($Reps[$Rep]) > 0 )
			$String .= $Rep."=".urlencode($Reps[$Rep])."|";
		}
		$Db->Close();
		// Retirer le dernier |
		$String = substr($String,0,strlen($String)-1);
		print $String;
		break;

	case 'Save':
		// Récupérer les données
		$conid  = $_GET["conid"];
		if( $conid == -1 )
		$Sql = "INSERT INTO contact SET ";
		else
		$Sql  = "UPDATE contact SET ";
		foreach( array_keys($_GET) as $Key )
		{
			if( !($Key == "Option" || $Key == "conid") )
			$Sql .= "$Key='".htmlentities(urldecode($_GET[$Key]),ENT_QUOTES) . "', ";
		}
		$Sql = substr($Sql,0,strlen($Sql)-2);
		if( $conid != -1 )
		$Sql .= " WHERE conid=".$_GET["conid"]." ;";

		$Db->Query($Sql);
		print "Donn&eacute;es mises &agrave; jour $Sql";
		$Db->Close();
		break;

	case 'EditContact':
		$conid = $_GET['conid'];
		if( $conid == -1 )
		{
			$Contact = array("conid"=>-1, "valid"=>1, "company"=>"", "name"=>"",
                 "given_name"=>"", "email"=>"", "phone"=>"00.00.00.00.00", "num"=>0,
                 "address1"=>"", "address2"=>"", "city"=>"", "zip"=>"", "genre"=>"Aucun");
		}
		else
		{
			$Sql = "SELECT * FROM contact WHERE conid=$conid;";
			$Db->Query($Sql);
			$Contact = $Db->loadArray();
		}
		$Html = EditContact($Db, $Contact);
		print $Html;
		break;

	case 'DisplayContacts':
		$Html= DisplayContacts($Db,$_GET["Cid"] , $_GET["parentWindowId"], $_GET["inputSender"], $_GET["inputConid"]);

		print $Html;
		break;

	case 'ListContacts':
		$Html= ListContacts($Db);
		print $Html;
		break;
}

?>
