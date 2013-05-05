<?php

/*
function sauvegarde_mysql(){
    $date = date("Y_m_d");
    switch($this->format){
        case "bzip2":
            $extension = ".sql.bz2";
            break;
        case "gzip":
            $extension = ".sql.gz";
            break;
        default:
            $this->erreur("Format de compression <b>" . $this->format . "</b> non pris en charge.");
            break;
    }
    $fichier = $this->dossierSauv . $this->nomDb . "_" . $date . $extension;
    exec('mysqldump --user="' . $this->utilisateur . '" --password="' . $this->motDePasse . '" "' . $this->nomDb . '" | ' . $this->format . ' > "' . $fichier . '"');
    $this->response->setVar("message", "Sauvegarde effectuée. Fichier <b>" . $fichier . "</b> sauvegardé");
    $this->response->setVar("dossierSauv ", $this->dossierSauv);
    $this->response->setVar("nomDuFichier", $this->nomDb . "_" . $date . $extension);
}
*/

function BackupMYSQL($Db)
{
if( $_SESSION['Parameters']['SqlEngine'] != "MYSQL" )
  return;
// Récupèrer la liste des tables de la base de données
$Sql = 'SHOW TABLES FROM '.$_SESSION['Parameters']['SqlBase'];
$Db->Query($Sql);

// Boucle sur toutes les tables
$Tables = $Db->loadArrayList();
foreach( $Tables as $Table )
  {
  // Analyse du CREATE TABLE (structure de la table)
  $Sql = 'SHOW COLUMNS FROM '.$Table[0];
  $Db->Query($Sql);
  $Columns = $Db->LoadArrayList();
  print_r($Columns);
  print "<br />";
/*  
  $res = mysql_query($sql) or die(mysql_error().$sql);
  if ($res)
  {
   $backup_file = '../temp/backup_' . $table . '.sql.gz';
   $fp = gzopen($backup_file, 'w');

   $tableau = mysql_fetch_array($res);
   $tableau[1] .= ";\n";
   $insertions = $tableau[1];
   gzwrite($fp, $insertions);

   $req_table = mysql_query('SELECT * FROM '.$table) or die(mysql_error());
   $nbr_champs = mysql_num_fields($req_table);
   while ($ligne = mysql_fetch_array($req_table))
   {
    $insertions = 'INSERT INTO '.$table.' VALUES (';
    for ($i=0; $i<$nbr_champs; $i++)
    {
     $insertions .= '\'' . mysql_real_escape_string($ligne[$i]) . '\', ';
    }
    $insertions = substr($insertions, 0, -2);
    $insertions .= ");\n";
    gzwrite($fp, $insertions);
   }
  } // fin if ($res)
  mysql_free_result($res);
  
  gzclose($fp);
  */
  }
return true;
}

print "Dans Backup<br /><!--";
$BaseURL = $_SERVER["DOCUMENT_ROOT"];
require( "$BaseURL/inc/Db.Inc.php" );
@session_start();
@$Option = $_GET['Option'];

$Db = new db($_SESSION['Parameters']['SqlEngine'], $_SESSION['Parameters']['SqlSrv'], $_SESSION['Parameters']['SqlBase'], 
             $_SESSION['Parameters']['SqlUsr'] , $_SESSION['Parameters']['SqlPwd']);

print_r($_SESSION);
print "-->";
//appel de la fonction
BackupMYSQL($Db);
print "";

?>
