<?php
/**
 * Ce fichier est le point d'entrée du programme. 
 *
 *   <p><b>Etape 1 :</b> si nécessaire, lance Login.php pour connecter l'utilisateur.<br/>
 *   Ensuite, lors de l'appel, l'URL est analysée,
 *   le contrôle est ensuite passé au composant appelé.</p>
 * 
 * @version		1.2
 * @package		Edicod
 * @subpackage		Framework
 * @tutorial		Edicod.pkg
 * @copyright		Copyright (C) 2005 - 2009 Serge NOEL. All rights reserved.
 * @license		GNU/GPL, see LICENSE.txt
 *
 * @todo   Rendre la doc compatible Javascript en modifiant phpDoc
 * @todo   ALTER TABLE nom_base AUTO_INCREMENT = xxx 
 * @todo	 Utilisateurs systeme uid < 100
 * @todo   Groupes systèmes     gid < 100
 * @todo  		Prendre en compte les uid et gid < 100
 * @todo		Mettre des labels au champs de saisie
 */

$Empty=0;

/**
 * @ignore
 */
// Appel des classes
require ('inc/gui.inc.php') ;
require ('inc/Menu.Inc.php') ;
require ('inc/lib.inc.php');
require ('inc/Db.Inc.php');

session_start();

if( empty($_SESSION['IsLoggued']) || $_SESSION['IsLoggued'] == false)
  { // Si session n'est pas défini, alors on est pas loggué
  header("Location: Login.php");
  }

// Que fait on ?
if( isset($_GET["option"]) )
  $Option = $_GET["option"];

// Initialise la Bdd
$Db = new db($_SESSION['Parameters']['SqlEngine'], $_SESSION['Parameters']['SqlSrv'], $_SESSION['Parameters']['SqlBase'], 
             $_SESSION['Parameters']['SqlUsr'] , $_SESSION['Parameters']['SqlPwd']);

/* DEBUT DE LA PAGE */
$Html = new guihtml ( "/favicon.ico", "UTF-8") ;
$Html->add_css("/css/courrier.css");

// Creation du bandeau
$tmdate=date("d "). MoisFR(intval(date("n"))) . date(" Y");
$Html->MakeBandeau ("/img/edicod-157x80.png", "Gestion du courrier" , $tmdate ,$_SESSION['User']['UserName']." ".$_SESSION['User']['GivenName']);

// Gestion du TimeOut
$TimeOut = $_SESSION["Parameters"]["TimeOut"] * 1000;
$Content = "
<script type='text/javascript'>
var Tout;
function Logout()
{
document.location = '/index.php?option=Logout';
}

Tout = setTimeout('Logout()',$TimeOut);
</script>\n";

// Creation du menu en fonction du profil
$sMenu = GetMenu($Db,$_SESSION['User']['Rights']);
$Html->set_menu($sMenu);
$Html->add_js_file( '/js/menu.js' );

$BaseURL = $_SERVER["DOCUMENT_ROOT"];
// Si pas d'option passée on affiche la frontpage
if( empty($Option) )
  $Option = "FrontPage";

if( file_exists($BaseURL . "/components/$Option/$Option.php") )
  { // Donne le controle au composant
  require($BaseURL ."/components/$Option/$Option.php");
  $Content .= ContentInit($Db, $Html);
  }
else
  { // Pour le debug 
  $Content .= "<b>Composant:</b> $Option";
  }
$Html->set_main($Content);

// Crée et affiche la page
echo $Html->make_page("Liste Principale") ;

if( $_SESSION["User"]["Rights"] & 16 )
  {  // Affiche les variables de session pour les développeurs
  echo "<!-- \n";
  print_r($_SESSION);
  echo "\n -->";
  }

$Db->Close();
?>
