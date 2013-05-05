<?php
/**
 * Affiche un formulaire de login
 *   Ce fichier est appelé avant toute utilisation du programme
 *   il présente l'écran de connexion, valide l'identifiant et renvoi sur index.php en
 *   cas de succès
 * 
 *   Les donnés sont sécurisées par cryptage MD5 lors de l'envoi. <br/>
 *   <br/>
 *   Le fichier /etc/Edicod/<host>.conf est cherché et s'il est trouvé, sert à lire la configuration du serveur
 *   sinon, /etc/Edicod/config.conf est utilisé
 * 
 *
 * @author              Raphael DIAZ / Serge NOEL
 * @version             1.2
 * @package 		Edicod
 * @subpackage          Framework
 * @todo                Changer la gestion des profils par l'utilisation d'un groupe système
 * @todo                Changer la gestion valid (utilisateur) par l'utilisation d'un groupe système
 */

$Empty=0;

/**
 * Partie Html du Login
 *   Affiche la page de connection
 *
 * @param		string		Chaine de message (ligne de statut)
 */
function DisplayForm($Message)
{
print "
<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
<html>
<head>
  <link href='css/courrier.css' type='text/css' rel='StyleSheet'/>
  <link rel='shortcut icon' href='favicon.ico' />
  <meta content='text/html; charset=UTF-8' http-equiv='content-type'/>
  <title>Gestion du courrier</title>
  <script language='JavaScript' src='js/MD5.js' type='text/javascript'></script>
  <script language='JavaScript' src='Login.js' type='text/javascript'></script>
</head>
<body>
<div class='LogAppLogo'>
  <img src='img/edicod-308x157.png' />
</div>

<div class='CenterIE'>
<div class='LoginBox' >  
  <form method='post' action='Login.php' name='login' onSubmit='Send();' >
  <div class='Logo'>
    <img src='img/logo-edicia03.png' alt='Logo Edicia' title='Logo Edicia'/>
  </div>
  <div class='LogLine'>
    <label for='Login' class='Login'>Utilisateur</label><input type='text' name='Login' id='Login' class='Login' />
  </div>
  <div class='LogLine'>
    &nbsp;
  </div>
  <div class='LogLine'>
    <label for='Password' class='Login'>Mot de passe</label><input type='password' name='Password' id='Password' class='Login'/>
  </div>
  <div class='LogLine'>
    &nbsp;
  </div>
  <div class='LogLineButton'>
    <input border='0' src='/img/ok.png' type='image' Value='submit' align='middle' style='float: right; margin-right: 30px; margin-top: 10px' /> 
  </div>
  <input type='hidden' name='Action' value='Valid' />
  <input type='hidden' name='MD5Pass' id='MD5Pass' />
  </form>
</div>
</div>
<div class='Status' id='LogMsg'>$Message
<!--[if lte IE 6]>
<b>Important : </b> Votre navigateur est obsol&egrave;te <a href='IE.html'>(en savoir +)</a>
<![endif]-->
</div>
<script type='text/javascript'>

if(screen.height < 764 || screen.width < 1024)
  document.getElementById('LogMsg').innerHTML = \"<b>ATTENTION:</b> R&eacute;solution d'&eacute;cran trop faible pour l'application\";
</script>
</body>
</html>
";
}

// Fichiers à inclure
$Name = explode(".",$_SERVER["SERVER_NAME"]);
if( file_exists("/etc/Edicod/". $Name[0].".php") )
  {
  print "<!-- ATTENTION: utilise le fichier: /etc/Edicod/" . $Name[0] . ".php -->";
  require("/etc/Edicod/". $Name[0].".php");
  }
else
  {
  print "<!-- ATTENTION: le fichier: /etc/Edicod/" . $Name[0] . ".php est introuvable, utilise /etc/Edicod/config.php -->";
  require ('/etc/Edicod/config.php');	// Inclure uniquement ici
  }
require ('inc/Db.Inc.php') ;
require ('inc/User.Inc.php') ; 

// Permier appel -> affiche le formulaire
if( empty($_POST["Action"]) )
  {
  DisplayForm("");
  die();
  }

session_start();

// Initialiser la Bdd (Utilisateur)
$DbU = new db($Cfg['BdDbE'], $Cfg['BdHost'], $Cfg['BdBase'], $Cfg['BdUser'] , $Cfg['BdPwd']);

// Valider compte/mot de passe
$Me = new user($DbU, $_POST['Login']);

$Valid = $Me->is_Valid($_POST['MD5Pass']);

if ( $Valid == false ) 
  {
  DisplayForm("<b>ERREUR:</b> Identifiant / mot de passe incorrect");
  die();
  }

// Arrivé ici, l'utilisateur est connecté 
$Me->LoadProfileData($DbU) ;
$Me->WriteSession() ;

$_SESSION['Cfg'] = $Cfg;
$DbU->GetParameters();
$DbU->Close();
// Retour à la page d'accueil
header("Location: index.php?option=FrontPage" ); 

?>
