#!/usr/bin/php -q
<?php
/**
 *  Insertion des fichiers.
 *    Cette routine est lancée périodiquement pour lister les fichiers présents dans les
 *    répertoires où sont déposés les documents scannés. La date d'entrée est prise en compte
 *    le nom du fichier sert à initialiser l'objet et le groupe de destination est fonction 
 *    du répertoire d'entrée.
 *    Le workflow par défaut est défini
 *
 *  Si un paramètre est passé alors le fichier de configuration est /etc/Edicod/<param>.php
 *
 * @package		Edicod
 * @subpackage		Crontab
 * @version		1.2
 * @copyright		Copyright (C) 2005 - 2009 Serge NOEL. All rights reserved.
 * @license		GNU/GPL, see LICENSE.txt
 *
 *
 */
$Empty=0;

/**
 * Fonction d'analyse de répertoire.
 *   Recherche les fichiers présents dans un répertoire, 
 *   les fichiers trouvés sont insérés à la table documents, avec leur date de création, les mots clés sont issus du fichier pdf
 * 
 * @param	objet		Objet base de données
 * @param	integer		Identifiant du groupe considéré
 * @param	integer		Identifiant de l'étape du workflow
 * @param	string		Chemin à analyser
 * @param	string		Chemin temporaire où déposer le fichier
 * @param	string		Chemin temporaire où déposer le fichier s'il est rejeté
 * @return	void		Rien
 */
function RFScan($Db, $Gid, $Wfsid, $InPath, $OutPath, $RelOutPath, $BadPath)
{
$TmpPath = $_SESSION["Parameters"]["AbsoluteDocuments"]."/Temp";
$Fid     = $_SESSION["Parameters"]["DefaultFolder"];
$CabId   = $_SESSION["Parameters"]["DefaultCabinet"];
$SendId  = $_SESSION["Parameters"]["DefaultSender"];
$Dir = opendir($InPath);
$MyOutPath = $OutPath . date("/Y/m/d");
$MyRelOutPath = $RelOutPath . date("/Y/m/d");
if($Dir)
  {
  while(($File = readdir($Dir)) !== false)
    {
    if( !($File == "." || $File == "..") )
      {
      // Lire les renseignements concernant le fichier
      $FileSize = filesize( $InPath."/".$File );
      $FileMD5  = md5(file_get_contents($InPath."/".$File));
      // Rechercher la date du fichier
      $Date =  date ("Y-m-d", filemtime($InPath."/".$File));
      // Calculer la date limite de traitement (86400 = 60*60*24) - 1 jour
      $ddate = date("Y-m-d",mktime(0,0,0)+86400*$_SESSION['Parameters']['RespondBefore']);

      // Ne pas prendre en compte le document s'il est déjà présent
      $Sql = "SELECT * FROM documents WHERE size=$FileSize AND md5='$FileMD5';";
      $Db->Query($Sql);
      if( $Db->NumRows() == 0 )
        {
        // Prise en compte du document
        $Sql  = "INSERT INTO documents SET name='". mysql_real_escape_string($File) ."', path='$MyRelOutPath', date_in='$Date',";
        $Sql .= " date_due='$ddate', object='". mysql_real_escape_string($File) ."', wfsid=$Wfsid, size=$FileSize, md5='$FileMD5', cabid=$CabId, conid=$SendId;";
        $Db->Query($Sql);
        $Did = $Db->GetLastId();
        // Affectation au Dossier virtuel par defaut
        $SqlDefDoc = "INSERT INTO docfolders SET did=$Did , fid=$Fid";
        if( strpos( $File,".pdf" ) == true)
          {  // Rechercher dans un pdf le texte
          $TxtFile = substr($File,0,strpos($File,".pdf")) . ".txt";
          exec("pdftotext '$InPath/$File' '$TmpPath/$TxtFile'");

          if( file_exists("$TmpPath/$TxtFile") )
            {
            // Si le fichier .pdf a des textes lisibles, il est indexé
            IndexFile($Db, "$TmpPath/$TxtFile",$Did, 3);
            // Le fichier texte n'est plus utile
            //print "$TmpPath/$TxtFile";
            unlink("$TmpPath/$TxtFile");
            }
          //        else
          //          {
          // Cas des documents non indexés
          //          }
        }
        //      else
        //        {
        // Documents non .pdf
        //        }

        // Ajout d'une ligne dans le journal
        $Sql = "INSERT INTO doclog SET did=$Did , description='Ajout du document depuis $InPath', action=0;";
        $Db->Query($Sql);
        // Deplacer le fichier
        if( !file_exists($MyOutPath) )
          mkdir( $MyOutPath, 0775, true);    
        rename("$InPath/$File", "$MyOutPath/$File");
        }
      else
        {
        // Doublon
        $Rep = $Db->LoadObject();
        $Did = $Rep->did;
        $Sql = "INSERT INTO doclog SET did=$Did , action=$Wfsid, description='  Le document $File est d&eacute;j&agrave; pr&eacute;sent dans la base', action=-1;";
        $Db->Query($Sql);
        rename("$InPath/$File", "$BadPath/$File");
        }
      }
    }
  }
  closedir($Dir);
}

// Début
if( file_exists("/var/run/Edicod.pid") )
  die();
touch("/var/run/Edicod.pid");
$Dir = dirname(__FILE__);

if( $argc == 1 )
  require_once("/etc/Edicod/config.php");
else
  require_once("/etc/Edicod/".$argv[1].".php");
require_once($Dir . "/../inc/Db.Inc.php");
require_once($Dir . "/../inc/User.Inc.php");
require_once($Dir . "/../inc/lib.inc.php");
require_once($Dir . "/../inc/IndexFile.php");

$Db = new db($Cfg['BdDbE'], $Cfg['BdHost'], $Cfg['BdBase'], $Cfg['BdUser'] , $Cfg['BdPwd']);
$Db->GetParameters();
$Usr = new user($Db,"ReadFiles");
//$OutPath    = $_SESSION["Parameters"]["AbsoluteDocuments"] . $_SESSION["Parameters"]["IncomingPath"];
//$RelOutPath = $_SESSION["Parameters"]["IncomingPath"];
$RelOutPath = $_SESSION["Parameters"]["StorePath"];
$OutPath    = $_SESSION["Parameters"]["AbsoluteDocuments"] . $RelOutPath;
$BadPath    = $_SESSION["Parameters"]["AbsoluteDocuments"] . $_SESSION["Parameters"]["BadDocuments"];

$Grps = $Usr->GetGroupList();
foreach($Grps as $Grp)
  {
  $InPath     = $_SESSION["Parameters"]["AbsoluteDocuments"] . $_SESSION["Parameters"]["InputPath"] . $Grp->inputdirectory;
  if( $Grp->inputdirectory != "" ) 	// Répertoire vide signifie pas de scan associé
    RFScan($Db, $Grp->gid, $Grp->wfsid, $InPath, $OutPath, $RelOutPath, $BadPath);
  }
unlink("/var/run/Edicod.pid");
?>
