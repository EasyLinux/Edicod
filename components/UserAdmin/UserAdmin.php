<?php
/**
 * Gestion de utilisateurs.
 *   Composant de gestion utilisateur, il doit être conçu pour gérer des utilisateurs depuis :
 *      - La base interne de l'application
 *      - Une base Ldap
 *      - Active directory ...
 *
 * @version             1.2
 * @package 		Composants
 * @subpackage		Paramètres
 */
$Empty=0;

/**
 * Initialisation
 * @ignore
 */
function ContentInit($Db, $Html)
{
	$Html->add_js_file("/js/ajax.js");
	$Html->add_js_file("/js/php.js");
	$Html->add_js_file("/js/prototype.js");
	$Html->add_js_file("/js/effects.js");
	$Html->add_js_file("/js/window.js");
	$Html->add_js_file("/js/MD5.js");
	$Html->add_js_file("/components/UserAdmin/UserAdmin.js");

	$ListUser = array(
  "Sql"     => "SELECT * FROM user, profiles WHERE user.uid != 0 AND user.pid=profiles.pid ORDER BY name;",
  "Name"    => "ListUser",
  "Action"  => "#",
  "Method"  => "post",
  "Title"   => "&nbsp;Utilisateurs",
  "Width"   => 655,
  "Height"  => 400,
  "ListW"   => 631,
  "ListH"   => 300,
  "FieldId" => "uid",
  "Init_JS" => "\nGetProfile();\n",
  "Fields"  => array(
	array("&nbsp;Id","uid",40,40),
	array("&nbsp;Actif","valid",45,45),
	array("&nbsp;Login","login",90,90),
	array("&nbsp;Nom","name",140,140),
	array("&nbsp;Pr&eacute;nom","given_name",140,140),
	array("&nbsp;Profil","description",150,130)
	),
  "ButtonsLeft" => array(
	array("/img/UserAdmin/UserAdd.png","Ajouter","Add();",""),
	array("/img/UserAdmin/UserEdit.png","Editer","Edit()",""),
	array("/img/UserAdmin/UserDel.png","Supprimer","Delete();","")
	),
  "ButtonsRight" => array(
	array("/img/UserAdmin/Door.png","Quitter","UserQuit();",""),
	array("/img/UserAdmin/UserLock.png","Valider/Invalider","Lock();","")
	)
	);
	$Content .= "\n<!-- Contenu - ". __FILE__ . " -->
<div class='main'>";
	$Content .= $Html->MakeHtmlList2($Db, $ListUser);
	$Content .= "</div>
<div id='UaPopup' style='display: none'></div>
<div id='overlay_modal' class='overlay_bluelighting' /></div>
<!-- /Contenu -->\n";
	return ($Content);
}


/**
 * Fonction appelée en Ajax : édite un utilisateur
 *
 * @param		int		Identifiant du groupe
 * @param               objet		Base de données
 */
function UsrEdit($Id,$Db)
{
	if( $Id == -1 )
	{
		session_start();
		$Rep = array("uid" => -1,"login" => "","MD5Pass" => "", "pid" => $_SESSION["Parameters"]["DefaultProfile"], "action" => 0,
       "valid" => 1, "name" => "", "given_name" => "", "email" => "", "phone" => "00.00.00.00.00","service" => "",
       "num" => "", "address1" => "", "address2" => "", "city" => "", "zip" => "", "gids" => array($_SESSION["Parameters"]["DefaultGroup"]) );
	}
	else
	{
		$Sql = "SELECT * FROM user WHERE uid=$Id";
		$Db->Query($Sql);
		$Rep = $Db->loadArray();
		$Sql = "SELECT * FROM g_grp WHERE uid=" . $Rep["uid"].";";
		$Db->Query($Sql);
		$Mbs = $Db->loadArrayList();
		$Rep["gids"] = array();
		foreach($Mbs as $Mb)
		{
			$Rep["gids"][]=$Mb["gid"];
		}
	}
	$Sql = "SELECT * FROM profiles";
	$Db->Query($Sql);
	$Pro = $Db->loadArrayList();
	$Profile = "";
	foreach( $Pro as $Pr )
	{
		if( $Rep["pid"] == $Pr["pid"])
		$Profile .= "          <option value='".$Pr["pid"]."' selected='selected'>".$Pr["description"]."</option>\n";
		else
		$Profile .= "          <option value='".$Pr["pid"]."' >".$Pr["description"]."</option>\n";
	}
	if( $Rep["valid"] == 1)
	$Checked = "checked='checked' ";
	
	if($Rep["genre"]=='Mr')
		$Checked_Mr = "checked='checked' ";
	else
		$Checked_Mr = "";
		
	if($Rep["genre"]=='Mme')
		$Checked_Mme = "checked='checked' ";
	else
		$Checked_Mme = "";
		
	if($Rep["genre"]=='Mlle')
		$Checked_Mlle = "checked='checked' ";
	else
		$Checked_Mlle = "";
		
	if($Rep["genre"]=='Aucun' || $Rep["genre"]=='')
		$Checked_Aucun = "checked='checked' ";
	else
		$Checked_Aucun = "";
	
	$Groupes = "";
	$MemberOf = "";
	$Sql = "SELECT gid, name FROM groups";
	$Db->Query($Sql);
	$Grps = $Db->loadArrayList();
	foreach($Grps as $Grp)
	{
		if( in_array($Grp["gid"],$Rep["gids"]) )
		$MemberOf .= "            <option value='".$Grp["gid"]."'>".$Grp["name"]."</option>\n";
		else
		$Groupes .= "            <option value='".$Grp["gid"]."'>".$Grp["name"]."</option>\n";
	}

	$Usr = "
<form method='post' action='#' id='EditUser' accept-charset='iso-8859-15'>
 <input type='hidden' name='uid' id='uid' value='".$Rep["uid"]."' />
&nbsp;<br />
  <div class='formPopupLine' style='width: 370px; height: 20px; margin-left: 10px'>
    <span class='formTabTitleOn' id='TabT1' onClick='MyTab(1);'>&nbsp;Compte</span>
    <span class='formTabTitleOff' id='TabT2' onClick='MyTab(2);'>&nbsp;Individu</span>
    <span class='formTabTitleOff' id='TabT3' onClick='MyTab(3);'>&nbsp;Groupes</span>
  </div>

  <div class='formTabOn' id='Tab1' style='width: 390px; height: 260px; margin-left: 10px' >
    <div class='formPopupLine' style='height: 10px'>&nbsp;</div>
    <div class='formPopupLine' style='height: 25px'>
        <span class='formPopupL' style='width: 130px'>Login</span><div class='fpPopDiv2' style='width: 160px'>
        <input type='text' class='fpPopInp2' name='login' id='login' value='".$Rep["login"]."' style='width: 160px' /></div>
    </div>
    <div class='formPopupLine' style='height: 35px'>
        <span class='formPopupL' style='width: 130px'>Profil</span>
        <select name='pid' id='pid' style='width: 165px' class='fpPopInp2' >
	$Profile
        </select> 
    </div>
    <div class='formPopupLine' style='height: 25px'>
        <span class='formPopupL' style='width: 130px'>Mot de passe</span>
        <input type='password' class='fpPopInp2' name='password' id='password' 
                      onChange='document.getElementById(\"MD5pass\").value = MD5(this.value);' style='width: 160px' />
    </div>
    <div class='formPopupLine' style='height: 25px'>
        <span class='formPopupL' style='width: 130px'>Actif</span>
        <input type='checkbox' name='valid' id='valid' class='fpPopInp2' $Checked> 
    </div>
    <div class='formPopupLine'>
        <span class='formPopupL' style='width: 130px'>&nbsp;</span>    <input type='hidden' name='MD5pass' id='MD5pass' value='' >
    </div>
  </div>
  
  <div class='formTabOff' id='Tab2' style='width: 390px; height: 260px; margin-left: 10px' >
    <div class='formPopupLine' style='height: 10px; width: 385px;'>&nbsp;</div>
    
    <div class='formPopupLine' style='height: 20px'>
        <span style='margin:0 0 0 12px; width: 40px'><input type='radio' name='genre' value='Mr' id='mr' $Checked_Mr /><label for='mr'>Mr</label></span>
        <span style='margin:0 0 0 30px; width: 40px'><input type='radio' name='genre' value='Mme' id='mme' $Checked_Mme /><label for='mme'>Mme</label></span>
        <span style='margin:0 0 0 30px; width: 40px'><input type='radio' name='genre' value='Mlle' id='mlle' $Checked_Mlle /><label for='mlle'>Mlle</label></span>
        <span style='margin:0 0 0 30px; width: 40px'><input type='radio' name='genre' value='Aucun' id='aucun' $Checked_Aucun /><label for='aucun'>Aucun</label></span>
    </div>
    <div class='formPopupLine' style='height: 20px'>
        <span class='formPopupL' style='width: 130px'>Service</span>
        <div class='fpPopDiv2' style='width: 200px'>
          <input type='text' class='fpPopInp2' name='service' id='service' value='".$Rep["service"]."' style='width: 200px' /></div>
    </div>
    <div class='formPopupLine' style='height: 20px'>
        <span class='formPopupL' style='width: 130px'>Nom</span>
        <div class='fpPopDiv2' style='width: 200px'>
          <input type='text' class='fpPopInp2' name='name' id='name' value='".$Rep["name"]."' style='width: 200px' /></div>
    </div> 
    <div class='formPopupLine' style='height: 20px'>
        <span class='formPopupL' style='width: 130px'>Pr&eacute;nom</span>
        <div class='fpPopDiv2' style='width: 200px'>
          <input type='text' class='fpPopInp2' name='given_name' id='given_name' value='".$Rep["given_name"]."' style='width: 200px' /></div>
    </div>
    <div class='formPopupLine' style='height: 20px'>
        <span class='formPopupL' style='width: 130px'>Email</span>
        <div class='fpPopDiv2' style='width: 200px'>
        <input type='text' class='fpPopInp2' name='email' id='email' value='".$Rep["email"]."' style='width: 200px' /></div>
    </div>
    <div class='formPopupLine' style='height: 20px'>
        <span class='formPopupL' style='width: 130px'>T&eacute;l&eacute;phone</span>
        <div class='fpPopDiv2' style='width: 200px'>
          <input type='text' class='fpPopInp2' name='phone' id='phone' value='".$Rep["phone"]."' style='width: 200px' /></div>
    </div>
    <div class='formPopupLine' style='height: 20px'>
        <span class='formPopupL' style='width: 130px'>Adresse</span>
          <input type='text' class='fpPopInp2' name='num' id='num' style='width: 20px' value='".$Rep["num"]."' />
          <input type='text' class='fpPopInp2' name='address1' id='address1' style='width: 168px; margin-left: 5px' value='".$Rep["address1"]."' />
    </div>
    <div class='formPopupLine' style='height: 20px'>
        <span class='formPopupL' style='width: 130px'>&nbsp;</span>
        <input type='text' class='fpPopInp2' name='address2' id='address2' value='".$Rep["address2"]."' style='width: 200px' />
    </div>
    <div class='formPopupLine' style='height: 20px'>
        <span class='formPopupL' style='width: 130px'>CP / Ville</span>
        <input type='text' class='fpPopInp2' name='zip' id='zip' style='width: 45px' value='".$Rep["zip"]."' />
        <input type='text' class='fpPopInp2' name='city' id='city' style='width: 143px; margin-left: 5px' value='".$Rep["city"]."' />
    </div>
  </div>
  
  
  
  <div class='formTabOff' id='Tab3' style='width: 390px; height: 260px; margin-left: 10px' >
    <div class='formPopupLine' style='height: 10px; width: 385px;'>&nbsp;</div>
    <div class='formPopupLine'>
        <span class='formPopupL' style='width: 140px; height: 200px'>Membre de<br />
          <select id='memberof' name='memberof' style='width: 135px; height: 180px' size=10 multiple >\n$MemberOf</select>
        </span>
        <span class='formPopupL' style='width: 30px; height: 200px'>
          <img src='/img/UserAdmin/move.png' />
          <img src='/img/UserAdmin/back.png' class='ImgButton' onClick='MoveAdd();' />
          <img src='/img/UserAdmin/move2.png' />
          <img src='/img/UserAdmin/forward.png' class='ImgButton' onClick='MoveDel();' />
        </span>
        <span class='formPopupL' style='width: 140px; height: 200px'>Groupes<br />
          <select id='groups' name='groups' style='width: 135px; height: 180px' size=10 multiple >\n$Groupes</select>
        </span>
    </div>
  </div>
  
  
  <div class='formButtons2' style='width:390px;margin-left:5px;'>
    <div class='formButtonsItemL' >
        <img src='/img/UserAdmin/Save.png' class='ImgButton' alt='Sauvegarder' title='Sauvegarder' onClick='Save();' /></div>
    <div class='formButtonsItemR' >
        <img src='/img/UserAdmin/Door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='Abort();' /></div>
  </div>
  
</form>";
	$Db->Close();
	return($Usr);
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
	case 'Lock':
		$id = $_GET['id'];
		$query = "SELECT * FROM user WHERE uid=$id";
		// Interroger la base de données
		$Db->Query($query);
		$Rep = $Db->loadObject();
		if( $Rep->valid == 0 )
		{
			$query = "UPDATE user SET valid=1 WHERE uid=$id";
			print "Utilisateur valid&eacute;";
		}
		else
		{
			$query = "UPDATE user SET valid=0 WHERE uid=$id";
			print "Utilisateur invalid&eacute;";
		}
		$Db->Query($query);
		$Db->Close();
		break;

	case 'Delete':
		$id = $_GET['id'];
		// Utilisateur avec
		//         uid=0 -> Automatique
		//         uid=1 -> Administrateur
		if( $id == 0 || $id == 1)
		  break;
		// Interroger la base de données
		$query = "DELETE FROM user WHERE uid=$id";
		$Db->Query($query);
		$Db->Close();
		print "Ok";
		break;

	case 'Read':
		$id = $_GET['ID'];
		// Interroger la base de données
		$query  = "SELECT * FROM user, profiles ";
		$query .= "WHERE user.uid=$id AND ";
		$query .= "user.pid=profiles.pid";
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
		$uid  = $_POST["uid"];
		if( $uid == -1 )
		$Sql = "INSERT INTO user SET ";
		else
		$Sql  = "UPDATE user SET ";
		foreach( array_keys($_POST) as $Key )
		{
			switch( $Key )
			{
				case "Option";
				case "uid":
				case "password":
					break;

				case "valid":
				case "pid":
					$Sql .= "$Key=".$_POST[$Key] . ", ";
					break;

				default:
					$Sql .= "$Key='".urldecode($_POST[$Key])."', ";
					break;
			}
		}
		$Sql = substr($Sql,0,strlen($Sql)-2);
		if( $uid != -1 )
		$Sql .= " WHERE uid=".$_POST["uid"]." ;";
		else
		$Sql .= " ;";

		$Db->Query($Sql);
		print "Donn&eacute;es mises &agrave; jour";
		$Db->Close();
		break;

	case 'SaveGrps':
		$uid = $_POST["uid"];
		$Sql = "DELETE FROM g_grp WHERE uid=$uid ;";
		$Db->Query($Sql);
		$Grps = explode("|",$_POST["Groups"]);
		foreach($Grps as $Grp)
		{
			if( !empty($Grp) )
			{
				$Sql = "INSERT INTO g_grp SET uid=$uid, gid=$Grp ;";
				$Db->Query($Sql);
			}
		}
		break;

	case 'GetProfiles':
		// Interroger la base de données
		$String="";
		$query  = "SELECT * FROM profiles ";
		$Db->Query($query);
		$Reps = $Db->loadObjectList();
		foreach($Reps as $Rep)
		$String .= $Rep->pid."=".$Rep->description."|";
		$Db->Close();
		// Retirer le dernier |
		$String = substr($String,0,strlen($String)-1);
		print $String;
		break;

	case 'UsrEdit':
		$uid = $_GET["Id"];
		print UsrEdit($uid, $Db);
		break;

	case 'GetSaveUid':
		$Sql = "INSERT INTO user SET login='".$_POST["login"]."' ;";

		$Db->Query($Sql);
		print $Db->GetLastId();

		$Db->Close();
		break;

}

?>
