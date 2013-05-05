<?php
/**
 * Installation du programme
 * Ce fichier sert à l'installation d'Edicod, il suffit de le copier sur l'arborescence du nouveau 
 * site et de le nommer index.php
 * 
 * @version			0.5
 * @package			Edicod
 * @subpackage	Framework
 * @copyright		Copyright (C) 2011  Serge NOEL. All rights reserved.
 * @license		GNU/GPL, see LICENSE.txt
 */
 
/*define(INSTALL_SERVER,"http://192.168.197.46");
define(INSTALL_USER,"snoel");
define(INSTALL_PASS,"serge");
define(INSTALL_SVNPATH,"/svn/edicod/branches/"); */
define(INSTALL_SERVER,"svn://192.168.1.10");
define(INSTALL_SVNPATH,"/Edicod/branches/");
define(INSTALL_USER,"snoel");
define(INSTALL_PASS,"1duB015!");

/**
 * Première étape
 *
 */
function Step1()
{
$ErrMsg="";
$ConfOk = true;  // Par principe la configuration est bonne
$NewUrl = $_SERVER["PHP_SELF"]."?Option=Step2";

print "<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
<html>
 <head>
  <title>Installation d'Edicod</title>
 </head>
 <body>
 <h1>Installation d'Edicod</h1>
 <p>Ce programme permet de g&eacute;rer tout votre courrier</p>
 <h2>Pr&eacute;-requis</h2>
 <p>Pour pouvoir &ecirc;tre install&eacute;, ce programme n&eacute;cessite une architecture pr&eacute;cise :</p>
 <form action='#' method='get' name='setup'>
 <table>
  <tr>
    <td width='250px'>Serveur Http : </td>\n";
$HttpSrv = $_SERVER["SERVER_SOFTWARE"]; // Apache/2.2.12 (Ubuntu)
$aSrv = explode("/",$HttpSrv);
if( $aSrv[0] == "Apache" )
  print "    <td width='50px'><font color='green'>OK</font></td><td width='400px'>".$aSrv[0]."</td>\n  </tr>\n";
else
  {
  $ConfOk = false;
  print "    <td width='50px'><font color='red'>Bad</font></td><td width='400px'><font color='red'>".$aSrv[0]."</font></td>\n  </tr>\n";
  $ErrMsg = "  <li>Le serveur doit &ecirc;tre apache.</li>\n";
  }
  
print "  <tr>\n    <td>Version serveur http :</td>\n";
if( substr($aSrv[1],0,1) == "2" )
  print "    <td><font color='green'>OK</font></td><td>".$aSrv[1]."</td>\n  </tr>\n";
else
  {
  $ConfOk = false;
  print "    <td><font color='red'>Bad</font></td><td><font color='red'>".$aSrv[1]."</font></td>\n  </tr>\n";
  $ErrMsg .= "  <li>La version d'Apache doit &ecirc;tre 2.x.x</li>\n";
  }

print "  <tr>\n    <td>Version php :</td>\n";
$aPhpVersion = explode('.',PHP_VERSION);
$PhpVersion = $aPhpVersion[0] . "." . $aPhpVersion[1] . "." . $aPhpVersion[2];
if( $aPhpVersion[0] == 5 )
  print "    <td><font color='green'>OK</font></td><td>$PhpVersion</td>\n  </tr>\n";
else
  {
  $ConfOk = false;
  print "    <td><font color='red'>Bad</font></td><td><font color='red'>$PhpVersion</font></td>\n  </tr>\n";
  $ErrMsg .= "  <li>La version de Php doit &ecirc;tre 5.x.x</li>\n";
  }

print "  <tr>\n    <td>Acces Svn :</td>\n";
if( extension_loaded("svn") )
if( $aPhpVersion[0] == 5 )
  print "    <td><font color='green'>OK</font></td><td>".svn_client_version()."</td>\n  </tr>\n";
else
  {
  $ConfOk = false;
  print "    <td><font color='red'>Bad</font></td><td><font color='red'>Svn n'est pas pris en charge !</font></td>\n  </tr>\n";
  $ErrMsg .= "  <li>Vous n'avez pas de client SVN</li>\n";
  }

print "  <tr>\n    <td>Acces Zip :</td>\n";
if( extension_loaded("zip") )
if( $aPhpVersion[0] == 5 )
  print "    <td><font color='green'>OK</font></td><td>Configur&eacute;</td>\n  </tr>\n";
else
  {
  $ConfOk = false;
  print "    <td><font color='red'>Bad</font></td><td><font color='red'>Zip n'est pas pris en charge !</font></td>\n  </tr>\n";
  $ErrMsg .= "  <li>Vous n'avez pas de client Zip</li>\n";
  }

print "  <tr>\n    <td>Acces messagerie :</td>\n";
if( extension_loaded("imap") )
if( $aPhpVersion[0] == 5 )
  print "    <td><font color='green'>OK</font></td><td>Configur&eacute;</td>\n  </tr>\n";
else
  {
  $ConfOk = false;
  print "    <td><font color='red'>Bad</font></td><td><font color='red'>Imap n'est pas pris en charge !</font></td>\n  </tr>\n";
  $ErrMsg .= "  <li>Vous n'avez pas de client Imap</li>\n";
  }

print "  <tr>\n    <td>Acc&egrave;s au dossier :</td>\n";
if( @mkdir("Test",0775) )
  {
  rmdir("Test");
  print "    <td><font color='green'>OK</font></td><td>Acc&egrave;s en &eacute;criture OK</td>\n  </tr>\n";
  }
else
  {
  $ConfOk = false;
  print "    <td><font color='red'>Bad</font></td><td><font color='red'>pas d'acc&egrave;s en &eacute;criture au dossier</font></td>\n  </tr>\n";
  $ErrMsg .= "<li> Le programme d'installation va cr&eacute;er et installer des fichiers dans le r&eacute;pertoire courant,
  il ne dispose pas de ces droits ; veuillez v&eacute;rifier que le r&eacute;pertoire  <i><b>".$_SERVER["DOCUMENT_ROOT"]."</b></i>  a comme utilisateur <i><b>
  '".$_ENV["APACHE_RUN_USER"]."'.''".$_ENV["APACHE_RUN_GROUP"]."'</b></i> et que les droits sont fix&eacute;s &agrave; <b><i>0777</b></i></li>";
  }
print "  <tr>\n    <td>Acc&egrave;s au dossier /etc:</td>\n";
if( @mkdir("/etc/Edicod/test",0775) )
  {
  rmdir("/etc/Edicod/test");
  print "    <td><font color='green'>OK</font></td><td>Acc&egrave;s en &eacute;criture OK</td>\n  </tr>\n";
  }
else
  {
  $ConfOk = false;
  print "    <td><font color='red'>Bad</font></td><td><font color='red'>pas d'acc&egrave;s en &eacute;criture au dossier /etc/Edicod</font></td>\n  </tr>\n";
  $ErrMsg .= "<li> Le programme d'installation va cr&eacute;er le fichier de configuration dans ce r&eacute;pertoire,
  il ne dispose pas de ces droits ; veuillez v&eacute;rifier que le r&eacute;pertoire  <i><b>/etc/Edicod/</b></i>  a comme utilisateur <i><b>
  '".$_ENV["APACHE_RUN_USER"]."'.''".$_ENV["APACHE_RUN_GROUP"]."'</b></i> et que les droits sont fix&eacute;s &agrave; <b><i>0775</b></i></li>";
  }
/*  
// Lire les versions d'Edicod disponibles
print "  <tr>\n    <td>Versions d'Edicod :</td>";
svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_USERNAME, INSTALL_USER);
svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_PASSWORD, INSTALL_PASS);
$SvnList = svn_ls ( INSTALL_SERVER.INSTALL_SVNPATH, SVN_REVISION_HEAD ,false);
if( empty($SvnList) ) 
  {
  $ConfOk = false;
  print "    <td><font color='red'>Bad</font></td><td><font color='red'>Edicod non disponible</font></td>\n  </tr>\n";
  $ErrMsg .= "<li> Le programme d'installation ne trouve pas de version d'Edicod! Veuillez contacter votre fournisseur</li>";
  }
else
  {
  print "    <td><font color='green'>OK</font></td><td><select id='version' size='1' style='width: 230px'>\n";
  foreach( $SvnList as $SvnLine )
    {
    $Version = $SvnLine["name"];
    $VersionD = $SvnLine["name"] . "." . $SvnLine["created_rev"] . " (". date("d/m/Y H:i", $SvnLine["time_t"]) .")";
    print "       <option value='$Version'>$VersionD</option>\n";
    }
  print "      </select></td>\n";
  }

// Recherche d'une licence valide
$LicenceOk = false;
print "  <tr>\n    <td>Votre licence :</td>\n";
$ComputerId1 = exec("/sbin/ifconfig eth0 | grep HWaddr");
$ComputerId2 = exec("cat /proc/cpuinfo");
$ComputerId = MD5($ComputerId1 . $ComputerId2);
// Lire le fichier des licences sur le serveur
$Authorized =  svn_cat( INSTALL_SERVER."/trunk/Authorized_Computers");
$Available = explode("\n",$Authorized);
foreach($Available as $Licence)
  {
  $Id = explode("|",$Licence);
  if( $Id[0] == $ComputerId )
    {
    $LicenceOk = true;
    $MyVersion = $Id[1];
    }
  }
$LicenceOk = true; //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
if( $LicenceOk )
  print "    <td><font color='green'>OK</font></td><td>&lt;= $MyVersion</td>\n  </tr>\n";
else
  {
  $ConfOk = false;
  print "    <td><font color='red'>Bad</font></td><td><font color='red'>Pas de licence</font></td>\n  </tr>\n";
  $ErrMsg .= "<li> Le programme d'installation ne trouve pas votre licence Edicod! Veuillez contacter votre fournisseur</li>";
  }
*/  
print " </table>\n";


if( $ConfOk )
  print "<br /><input type='submit' value='Etape 2 &gt;' onClick='document.location=\"/setup.php?Option=Step2&Version=\"+document.getElementById(\"version\").value' />\n";
else
  {
  print "<p>Corriger les probl&egrave;mes affich&eacute;s ci-dessous puis r&eacute;essayer</p>\n";
  print "<input type='submit' value='Nouvel essai' onClick='location.reload();return false;' />\n";
  }
print " </form>";
if( !empty($ErrMsg) )
  print "<p><b>NB:</b>\n<ul>$ErrMsg</ul>\n";

print "
<!-- $ComputerId -->
 </body>
</html>";
}

/**
 * Récupère les fichier du serveur 
 *
 */
function GetSvnFiles($URL)
{

session_start();
if( empty($_SESSION['URL']) )
  {
  $Files = array();
  $_SESSION['URL'] = $URL;
  $_SESSION['Current'] = 0;
  svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_USERNAME, INSTALL_USER);
  svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_PASSWORD, INSTALL_PASS);
  $SvnList = svn_ls ( $URL, SVN_REVISION_HEAD ,true);
  $i=0;
  foreach( $SvnList as $SvnLine )
    {
    if( substr($SvnLine["name"],0,1) != "." )
      {
      if( $SvnLine["type"] == "dir" )
        mkdir($SvnLine["name"],0775);
      else 
        {
        $Files[$i] = $SvnLine["name"];
        $i++;
        }
      }
    }
  $_SESSION['Max'] = count($Files);
  $_SESSION['Current'] = 0;
  $_SESSION['Files'] = $Files;
  print count($Files);
  return;
  }

svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_USERNAME, INSTALL_USER);
svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_PASSWORD, INSTALL_PASS);

$i = $_SESSION['Current'];
$File = $_SESSION['Files'][$i];
$Content = svn_cat($URL . $File );
$i++;
$_SESSION['Current'] = $i;
$Handle = fopen($File, "a+");
fwrite($Handle,$Content);
fclose($Handle);
if( $i > $_SESSION['Max'] )
  print "End";
else
  print $i;
return ;

}


/**
 * Deuxième étape :
 *      Télécharge et décompresse les fichiers de l'application
 *      Paramètre l'accès à la base de donnée
 * Le programme passe ensuite à l'étape 3
 */
function Step2($Version)
{
$SVN = urlencode(INSTALL_SERVER.INSTALL_SVNPATH."$Version/");
print "<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
<html>
 <head>
  <title>Installation d'Edicod (Etape 2)</title>
 </head>
 <body>
  <h2>Installation d'Edicod (Etape 2)</h2>
  Analyse des fichiers ... <span id='Done'></span><br/><br />
  <div id='Next' style='{display: none}'>
  Fichiers copi&eacute;s : <span id='Current'></span> / <span id='FileNumber'></span><br /></div>
  <script type='text/javascript'>
  setTimeout( DoIt, 500);
  
  function DoIt()
   {
   alert('DoIt');
   clearTimeout();
   }
   
  function getXhr()
   {
	 var xhr = null; 
	 if(window.XMLHttpRequest) // Firefox et autres
		xhr = new XMLHttpRequest(); 
	 else if(window.ActiveXObject){ // Internet Explorer 
		try {
			xhr = new ActiveXObject(\"Msxml2.XMLHTTP\");
		} catch (e) {
			xhr = new ActiveXObject(\"Microsoft.XMLHTTP\");
		}
	 }
	else 
	 { 
		alert(\"Votre navigateur ne supporte pas les objets XMLHTTPRequest...\"); 
		xhr = false; 
	 } 
	return xhr;
  }

  function wget(get)
  { 
	var xhr_object=getXhr();
	xhr_object.open('GET', get, false);
	xhr_object.setRequestHeader('Content-type','text/html ; charset=utf-8');
	xhr_object.send(null);
	if(xhr_object.readyState == 4) 
		return (xhr_object.responseText);    
  }


  // Premier appel à GetSvn
  URL = 'setup.php?Option=GetSvn&URL=$SVN';
  alert(URL);
  //Msg = wget(URL);
  document.getElementById('Done').innerHTML = 'OK';
  document.getElementById('Next').style.display = '';
  document.getElementById('FileNumber').innerHTML = Msg;
  document.getElementById('Current').innerHTML = '0';
  OK = false;
  while( OK )
    {
//    Msg = wget(URL);
    if( Msg == 'End' )
      OK = false;
//    document.getElementById('Current').innerHTML = Msg;
    }
  </script> 
 </body>
</html>";




/*





$SVN = INSTALL_SERVER."/svn/edicod/branches/$Version/";
svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_USERNAME, INSTALL_USER);
svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_PASSWORD, INSTALL_PASS);

ini_set('output_buffering','Off');

// zlib.output_compression = Off  

ob_start();
print "Recuperation du programme...";
ob_flush();

  svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_USERNAME, INSTALL_USER);
  svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_PASSWORD, INSTALL_PASS);
  $_SESSION['SvnList'] = svn_ls ( $SVN, SVN_REVISION_HEAD ,true);
  print "Nbre lignes : ". count($_SESSION['SvnList'])."<br />";


ob_start();
$NewUrl = $_SERVER["PHP_SELF"]."?Option=Step3";
print "<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
<html>
 <head>
  <title>Installation d'Edicod (Etape 2)</title>
 </head>
 <body>
 <script type='text/javascript'>
 function MySubmit()
 {
  URL = '".$NewUrl."';
  URL += '&Serveur=' + document.getElementById('srv').value;
  URL += '&BddAdmin='+ document.getElementById('usr').value;
  URL += '&BddPwd='  + document.getElementById('pwd').value;
  URL += '&AppBase=' + document.getElementById('base').value;
  URL += '&AppAdmin='+ document.getElementById('eusr').value;
  URL += '&AppPwd='  + document.getElementById('epwd').value;
  document.location = URL;
  
 }
 </script> 

Cr&eacute;ation d'un r&eacute;pertoire temporaire:";
ob_flush();
//mkdir("TempInstall",0775);
print "<font color='green'>OK</font><br />\n";
ob_flush();
print "R&eacute;cup&eacute;ration du programme: "; 

$In  = fopen($URL_SERVER.$ZIP_PATH.$_GET["File"],"rb");
$Out = fopen("TempInstall/".$_GET["File"], "ab");
while( !feof($In) )
  {
  $Buffer = fread($In,8192);
  fwrite($Out,$Buffer);
  //echo ".";
  //ob_flush();
  }
fclose($In);
fclose($Out);
echo "<font color='green'> OK</font> <br />";
ob_flush();

// Décompression du fichier
echo "D&eacute;compression de l'archive ";
$Zip = zip_open("TempInstall/".$_GET["File"]);
if ($Zip) 
  {
  while( $ZipEntry = zip_read($Zip) ) 
    {
    $File   = zip_entry_name($ZipEntry);
    if( substr($File,-1,1) == "/" )
      mkdir($File,0775); // Répertoire
    else
      {
      $Handle = fopen($File, "w+");
      if (zip_entry_open($Zip, $ZipEntry, "r")) 
        {
        $Buffer = zip_entry_read($ZipEntry, zip_entry_filesize($ZipEntry));
        zip_entry_close($ZipEntry);
        }
      fwrite($Handle, $Buffer);
      fclose($Handle);
      }
    }
    zip_close($Zip);
  }
  
echo "<font color='green'> OK</font> <br />
Suppression du r&eacute;pertoire temporaire:";
ob_flush();
//unlink("TempInstall/".$_GET["File"]);
//rmdir("TempInstall");
print "<font color='green'>OK</font><br />\n";
ob_flush();

print "
 <form name='setup' method='get' action='#'>
 <table>
 <tr>
  <td>Serveur de base de donnees</td><td><input type='text' id='srv' name='srv' value='localhost' /></td>
 </tr>
 <tr>
  <td>Compte administrateur de la Bdd</td><td><input type='text' id='usr' name='usr' value='root' /></td>
 </tr>
 <tr>
  <td>Mdp administrateur de la Bdd</td><td><input type='password' id='pwd' name='pwd' /></td>
 </tr>
 <tr>
  <td>base edicod</td><td><input type='text' id='base' name='base' value='Edicod' /></td>
 </tr>
 <tr>
  <td>login base edicod</td><td><input type='text' id='eusr' name='eusr' value='Edicod' /></td>
 </tr>
 <tr>
  <td>pwd base edicod</td><td><input type='text' id='epwd' name='epwd' value='Edicod' /></td>
 </tr>
</table>
<input type='submit' value='Etape 3' onClick='MySubmit(); return false;' />
</form>\n";
ob_flush();
print "
 </body>
 </html>"; 
ob_end_flush();
*/
}

/**
 * Troisième étape :
 *      Crée l'utilisateur et la base de donnée de l'application
 *      Crée les tables dans la base
 *      Initialise les valeurs par défaut
 * Le programme passe ensuite à l'étape 4
 */
function Step3()
{ // http://newedicod/setup.php?Option=Step3&Serveur=localhost&BddAdmin=root&BddPwd=qvqp91ll&AppBase=Edicod&AppAdmin=Edicod&AppPwd=Edicod
global $URL_SERVER, $ZIP_PATH;

print "<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
<html>
 <head>
  <title>Installation d'Edicod</title>
 </head>
 <body>
 <h1>Installation d'Edicod</h1>
 <p>Ce programme permet de g&eacute;rer tout votre courrier</p>
 <h2>Pr&eacute;-requis</h2>
 <p>Pour pouvoir &ecirc;tre install&eacute;, ce programme n&eacute;cessite une architecture pr&eacute;cise :</p>
 <p>Le fichier /etc/Edicod/". $Name[0].".php contiendra les informations de configuration</p>
 \n";
 print "</body>\n</html>\n";
 die();
 
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

/*
$NewUrl = $_SERVER["PHP_SELF"]."?Option=Step4";
$Db = mysql_connect($GET["Serveur"],$_GET["BddAdmin"],$_GET["BddPwd"]);
$Sql  = "CREATE USER '".$_GET["AppAdmin"]."'@'".$GET["Serveur"]."' IDENTIFIED BY '".$_GET["AppPwd"]."';";
$Res = mysql_query($Sql,$Db);
if( $Db == NULL )
  print "ERREUR: ". mysql_errno($Db) . " " .mysql_error($Db) . "<br />$Sql";
$Sql  = "GRANT USAGE ON * . * TO '".$_GET["AppAdmin"]."'@'".$GET["Serveur"]."' IDENTIFIED BY '".$_GET["AppPwd"]."' 
         WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;";
$Res = mysql_query($Sql,$Db);
if( $Db == NULL )
  print "ERREUR: ". mysql_errno($Db) . " " .mysql_error($Db) . "<br />$Sql";
$Sql  = "CREATE DATABASE IF NOT EXISTS `".$GET["AppBase"]."` ;";
$Res = mysql_query($Sql,$Db);
if( $Db == NULL )
  print "ERREUR: ". mysql_errno($Db) . " " .mysql_error($Db) . "<br />$Sql";
$Sql  = "GRANT ALL PRIVILEGES ON `".$GET["AppBase"]."` . * TO '".$_GET["AppAdmin"]."'@'".$GET["Serveur"]."';";
$Res = mysql_query($Sql,$Db);
if( $Db == NULL )
  print "ERREUR: ". mysql_errno($Db) . " " .mysql_error($Db) . "<br />$Sql";
// $Sql = file_get content, puis exécution
*/
}


if( empty($_GET) )
  { // Première étape
  Step1();
  die();
  }


switch( $_GET["Option"] )
  {
  case "Step1":
    Step1();
    break;
    
  case "Step2":
    Step3();
    break;
    
  case "GetSvn":
    GetSvnFiles($_GET['URL']);
    break;

//    svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_USERNAME, 'snoel');
//    svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_PASSWORD, 'serge');
//    $SvnList = svn_ls ( "http://192.168.197.46/svn/edicod/branches/", SVN_REVISION_HEAD ,false);
//    foreach( $SvnList as $SvnLine )
//      {
//      print_r($SvnLine);
//      print "<br/><br/>";
//      }
    
//    svn_checkout("http://192.168.197.46/svn/edicod/trunk/Edicod/",$_SERVER["DOCUMENT_ROOT"]);
    //print_r(svn_blame ( "http://192.168.197.46/svn/edicod/trunk/Edicod/index.php" ));
    break;  
}  
  
?>

