<?php
/**
 * Gestion du compte utilisateur.
 * 
 * @package		Composants
 * @subpackage		Paramètres
 * @access		public
 * @version		1.2
 * @author              Serge NOEL
 *
 * @todo		Modifier gestion caractères accentués
 */



/**
 * Initialisation du composant
 *
 * @ignore
 */
function ContentInit($Db, $Html)
{
$BaseURL = $_SERVER["DOCUMENT_ROOT"];
require_once("$BaseURL/inc/User.Inc.php");

$Html->add_js_file("/js/ajax.js");
$Html->add_js_file("/js/php.js");
$Html->add_js_file("/js/prototype.js");
$Html->add_js_file("/js/effects.js");
$Html->add_js_file("/js/window.js");
$Html->add_js_file("/js/MD5.js");
$Html->add_js_file("/js/htmlentities.js");
$Html->add_js_file("/components/MyAccount/MyAccount.js");
$Html->add_css("/css/default.css");
$Html->add_css("/css/lighting.css");

$Me = GetUser($_SESSION['User']['uid']);
$Profil = $_SESSION['User']['ProfileName'];

$Content = "
<!-- MyAccount -->

<div class='main' >
<table border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td class='CadreTopLeft'></td>
    <td class='CadreTop'>Mes coordonn&eacute;es</td>
    <td class='CadreTopRight'></td>
  </tr>
    <td class='CadreLeft'></td>
    <td class='CadreContent'>
     <div class='formLine' style='width:400px'>
      <span class='formL' style='width: 160px'>&nbsp;</span><input type='hidden' name='uid' id='uid' value='".$Me->uid."' >
     </div>
     <div class='formLine'>
      <span class='formL' style='width: 160px'>Login</span><span id='login' style='width: px'>".$Me->login."</span>
     </div>
     <div class='formLine'>
      <span class='formL' style='width: 160px'>Profil</span><span id='description' style='width: px'>$Profil</span>
     </div>
     <div class='formLine'>
      <span class='formL' style='width: 160px'>Nom</span>
       <input type='text' class='fpPopInp2' name='name' id='name' value='".$Me->name."' style='width: 160px' />
     </div>
     <div class='formLine'>
      <span class='formL' style='width: 160px'>Pr&eacute;nom</span>
      <input type='text' class='fpPopInp2' name='given_name' id='given_name' value='".$Me->given_name."' style='width: 160px' />
     </div>
     <div class='formLine'>
      <span class='formL' style='width: 160px'>Email</span>
      <input type='text' class='fpPopInp2' name='email' id='email' value='".$Me->email."' style='width: 160px' />
     </div>
     <div class='formLine'>
      <span class='formL' style='width: 160px'>T&eacute;l&eacute;phone</span>
      <input type='text' class='fpPopInp2' name='phone' id='phone' value='".$Me->phone."' style='width: 160px' />
     </div>
     <div class='formLine'>
      <span class='formL' style='width: 160px'>Adresse</span>
      <input type='text' class='fpPopInp2' name='address1' id='address1' style='width: 150px; margin-left: 10px' value='".$Me->address1."' />
     </div>
     <div class='formLine'>
      <span class='formL' style='width: 160px'>&nbsp;</span>
      <input type='text' class='fpPopInp2' name='address2' id='address2' value='".$Me->address2."' style='width: 160px' />
     </div>
     <div class='formLine'>
      <span class='formL' style='width: 160px'>CP / Ville</span>
      <input type='text' class='fpPopInp2' name='zip' id='zip' style='width: 45px' value='".$Me->zip."' />
      <input type='text' class='fpPopInp2' name='city' id='city' style='width: 123px; margin-left: 10px' value='".$Me->city."' />
     </div>
     <div class='formButtons2' style='width:380px;' >
      <div class='formButtonsItemL'>
        <img src='/img/Account/Password.png' class='ImgButton' alt='Mot de passe' title='Mot de passe' onClick='ChPwd();' />
      </div>
      <div class='formButtonsItemR' >
        <img src='/img/Account/Door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='Quit();' />
      </div>
      <div class='formButtonsItemR'  >
        <img src='/img/Account/Ok.png' class='ImgButton' alt='Enregistrer' title='Enregistrer' onClick='Save();' />
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
<script type='text/javascript'>

// Fenetre popup
win = new Window('MyPop',{className: \"bluelighting\", closable:false, resizable:false, maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
win.setZIndex(10);
</script>

<div id='Status' class='Status'></div>
<div id='MyPopup' style='display: none'>
  <div class='formLine'>
    &nbsp;<br />
    <span class='formL' style='width: 130px' >Ancien mdp</span><input type='password' class='formPopupI' id='OldPwd' style='width: 100px' /> 
  </div> 
  <div class='formLine'>
    <span class='formL' style='width: 130px' >Nouveau mdp</span><input type='password' class='formPopupI' id='NewPass1' style='width: 100px' /> 
  </div> 
  <div class='formLine'>
    <span class='formL' style='width: 130px' >Retaper mdp</span><input type='password' class='formPopupI' id='NewPass2' style='width: 100px' /> 
  </div> 
  <div class='formLineButton'>&nbsp;<br />
    <div class='formButtonsItem' style='margin-left: 20px' >
      <img src='/img/Account/Cancel.png' alt='Abandon' title='Abandon' onClick='Close();' class='ImgButton' />
    </div>
    <div class='formButtonsItem' style='width: 50%; text-align: center' >
      <img src='/img/Account/Ok.png' alt='Valider' title='Valider' onClick='DoPwd();' class='ImgButton' />&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
  </div>
</div>
<div id='overlay_modal' class='overlay_bluelighting' style='position: absolute; top: 0px; left: 0px; z-index: 5; width: 100%; height: 100%; opacity: 0.6; display: none;'/></div>
<!-- MyAccount -->\n";
return $Content;

/*




$Account = array(
  "Sql"     => "SELECT * FROM user, profiles WHERE user.pid=profiles.pid AND user.uid=".$_SESSION["User"]["uid"],
  "Ajax"    => "MyAccount.php",
  "Table"   => "user",
  "Name"    => "Account",
  "Action"  => "#",
  "Method"  => "post",
  "Title"   => "Edition de ma fiche utilisateur",
  "Width"   => 420,
  "Height"  => 310,
  "FieldId" => "uid",
//"Init_JS" => "";
  "Fields"  => array(
                    array(160,"&nbsp;","uid","hidden","",0),
                    array(160,"Login","login","display","",0),
                    array(160,"Profil","description","display","",0),
                    array(160,"Nom","name","text","",1),
                    array(160,"Pr&eacute;nom","given_name","text","",0),
                    array(160,"Email","email","mail","",1),
                    array(160,"T&eacute;l&eacute;phone","phone","phone","00.00.00.00.00",0),
                    array(160,"Adresse","num|address1","double", "num", 20, "int", "address1", 148, "text"),
                    array(160,"&nbsp;","address2","text","",0),
                    array(160,"CP / Ville","zip|city","double", "zip", 45, "text", "city",123, "text")
                    ),
  "Buttons" => array(
               array("/img/Account/Password.png","Mot de passe","ChPwd();"),
               array("/img/Account/Ok.png/img/Account/Ok.png","Enregistrer","Save();"),
               array("/img/Account/Door.png","Quitter","Quit();")
               )
  );


$Content .= "\n<!-- Contenu - ". __FILE__ . " -->\n<div class=\"main\">\n";
$Content .= $Html->Make_HtmlForm($Db, $Account, $User['uid']);

$Content .="

<div id='Popup'>
  <div class='formLine'>
    &nbsp;<br />
    <span class='formL' style='width: 130px' >Ancien mdp</span><input type='password' class='formPopupI' id='OldPwd' style='width: 100px' /> 
  </div> 
  <div class='formLine'>
    <span class='formL' style='width: 130px' >Nouveau mdp</span><input type='password' class='formPopupI' id='NewPass1' style='width: 100px' /> 
  </div> 
  <div class='formLine'>
    <span class='formL' style='width: 130px' >Retaper mdp</span><input type='password' class='formPopupI' id='NewPass2' style='width: 100px' /> 
  </div> 
  <div class='formLineButton'>&nbsp;<br />
    <div class='formButtonsItem' style='width: 50%; text-align: center' >
      <img src='/img/Account/cancel.png' alt='Abandon' title='Abandon' onClick='Close();' class='ImgButton' />
    </div>
    <div class='formButtonsItem' style='width: 50%; text-align: center' >
      <img src='/img/Account/ok.png' alt='Valider' title='Valider' onClick='DoPwd();' class='ImgButton' />&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
  </div>
</div>
<!-- Pour cacher principal -->
<div id='overlay_modal' class='overlay_bluelighting' style='position: absolute; top: 0px; left: 0px; z-index: 5; width: 100%; height: 100%; opacity: 0.6; display: none;'/>
</div>

<script type='text/javascript'>
// Fenetre popup
win = new Window('Pop2',{className: \"bluelighting\", width:270,height:140, closable:false, resizable:false, maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
win.setLocation(140,320);
win.setTitle('Changement mot de passe');
win.setZIndex(10);
win.setContent('Popup',false,true);
</script>

";

$Content .= "</div>\n<!-- Contenu -->\n\n";

return($Content);
*/
}
  	

session_start();

if( empty($_SESSION['IsLoggued']) || $_SESSION['IsLoggued'] == false)
  { // Si session n'est pas défini, alors on est pas loggué
  header("Location: Login.php");
  }

$Option = $_GET["Option"];
$BaseURL = $_SERVER["DOCUMENT_ROOT"];
$BaseURL = $_SERVER["DOCUMENT_ROOT"];
require_once("$BaseURL/inc/Db.Inc.php");
require_once("$BaseURL/inc/lib.inc.php");

$Db = new db($_SESSION['Parameters']['SqlEngine'], $_SESSION['Parameters']['SqlSvr'], $_SESSION['Parameters']['SqlBase'], 
             $_SESSION['Parameters']['SqlUsr'] , $_SESSION['Parameters']['SqlPwd']);

// Partie appelée en Ajax
switch( $Option )
  {
  case 'Pwd':
    // Changement du mot de passe
    $id        = $_GET["uid"];
    $MD5OldPwd = $_GET["OldPass"];
    $MD5NewPwd = $_GET["NewPass"];

    // Interroger la base de données
    $query = "SELECT * FROM user WHERE uid=$uid";
    $Db->Query($query);
    $Result = $Db->loadObject();
print "$query";
    if( $Result->MD5Pass != $MD5OldPwd )
      print "<font color='red'>&nbsp;Ancien mot de passe invalide !</font>";
    else
      {
      $query = "UPDATE user SET MD5Pass='$MD5NewPwd' WHERE uid=$id";
      $Db->Query($query);
      print "&nbsp;Mot de passe chang&eacute;";
      }
    $Db->Close();
    break;

  case 'Save':
    // Récupérer les données
    $uid        = $_GET["uid"];
    $Sql  = "UPDATE user SET ";
    foreach( array_keys($_GET) as $Key )
      {
      if( !($Key == "Option" || $Key == "uid") )
        $Sql .= "$Key='".urldecode($_GET[$Key])."', ";
      }
    $Sql = substr($Sql,0,strlen($Sql)-2);
    $Sql .= " WHERE uid=".$_GET["uid"]." ;";

    $Db->Query($Sql);
    print "Donn&eacute;es mises &agrave; jour";
    $Db->Close();
    break;

  case 'Init':
    // Interroger la base de données
    $uid = $_SESSION["User"]["uid"];
    $String="";
    $query  = "SELECT * FROM user, profiles WHERE user.prid=profiles.pid AND user.uid=$uid";
    $Db->Query($query);
    $Reps = $Db->loadArray();
    foreach(array_keys($Reps) as $Rep)
      $String .= $Rep."=".$Reps[$Rep]."|";
    $Db->Close();
    // Retirer le dernier |
    $String = substr($String,0,strlen($String)-1);
    print $String;
    break;

  }

?>
