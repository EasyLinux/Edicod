<?php

/**
 * Principe du code issu de phpDig 
 *
 *   Pour indexer un document (texte uniquement), on commence par le stocker dans une variable
 *   chaque mot est traité pour retirer les accents, le mettre en minuscule, ...<br />
 *   Puis pour chaque mot, on compte le nombre d'occurence.<br/>
 *   Ensuite chaque mot est cherché dans la table keywords, s'il n'y est pas, il est ajouté.<br/>
 *   Enfin, on stocke le lien pour chaque mot en référence au document avec le nombre d'occurence dans la table dockeywords.
 *
 * @package		Edicod
 * @subpackage		Framework
 * @version		1.0
 * @copyright		Copyright (C) 2005 - 2009 Serge NOEL. All rights reserved.
 * @license		GNU/GPL, see LICENSE.txt
 *
 */

/**
 * Fonction d'indexation fulltext d'un fichier texte.
 * 
 * @param	object		Objet base de données
 * @param	string		Chemin absolu du fichier à indexer
 * @param	int		identifiant du document lié
 * @param	int		Where, 1->Sujet, 2->Mots clés, 3->Mots du document
 * @return	void		Rien
 * 
 */
function IndexFile($Db, $File, $Did, $Where) 
{
/*
 Déterminer le codage de caractère
$sFileType = exec("file -i $File");
print "file renvoi : $sFileType\n";
$sCharSet=substr($sFileType,strpos($sFileType,"charset="));
$CharSet = substr($sCharSet, strpos($sCharSet,"=")+1);
*/

$FileContent = file_get_contents($File);
IndexWords($Db, $FileContent, $Did, $Where);
unset($FileContent);
}

/**
 * Fonction d'indexation fulltext des mots contenus dans une variable.
 * 
 * @param	object		Objet base de données
 * @param	string		Mots clés
 * @param	int		identifiant du document lié
 * @param	int		Where, 1->Sujet, 2->Mots clés, 3->Mots du document
 * @return	void		Rien
 * 
 */
function IndexWords($Db, $Words, $Did, $Where) 
{
// Charger mots communs dans un tableau
$Sql = "SELECT * FROM CommonWords";
$Db->Query($Sql);
$Reps = $Db->loadObjectList();
$cWords = array();
foreach( $Reps as $Rep)
  $cWord[$Rep->keyword] = $Rep->keyword;


// Les mots sont insensibles à la casse
$Content = strtolower($Words);
unset($Words);
// Supprimer les caractères parasites
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
$Content = strtr($Content,$FR);

// Supprimer les espaces en trop
$Content = preg_replace('/\s\s+/', ' ', $Content);

// Créer un tableau avec les mots à indexer
$Total=0;
for ($Mot = strtok($Content, " "); $Mot !== FALSE; $Mot = strtok(" ")) 
  {
  // On ne prend en compte que les mots de plus de trois caractères et non inclus dans les mots communs
  // Tous les mots
  //if (strlen($Mot) > 3 && !in_array($Mot,$cWord) ) 
  if ( strlen($Mot) > 1 && !in_array($Mot,$cWord) ) 
    {
    if (!isset($ListeMots[$Mot]))
      $ListeMots[$Mot] = 1; 
    else
      { // Ce mot existe déjà, on augmente son quotient
      $ListeMots[$Mot]++;
      }
    $Total++;
    }
  }

$distinct_words = @count($ListeMots);

// Insertion des mots dans la table
$it = 0;
$sqlvalues = "";
while (list($key, $value) = @each($ListeMots)) 
  {
  $key = trim(stripslashes($key));
    
  // Si ce mot clé existe, retrouve son id, sinon l'insère
  $Sql = "SELECT kid FROM keywords WHERE keyword = '".$key."'";
  $Db->Query($Sql);
  $OK = $Db->NumRows();

  if ($OK == 0) 
    { // Nouveau mot clé, l'insère
    $Sql = "INSERT INTO keywords SET keyword='$key';";
    $Db->Query($Sql);
    $Kid = $Db->GetLastId();
    }
  else 
    { // Le mot clé existe
    $oKid = $Db->loadObject();
    $Kid = $oKid->kid;
    }
  $Sql = "INSERT INTO dockeywords SET kid=$Kid, wichparts=$Where, did=$Did, occurs=$value;";
  $Db->Query($Sql);
  } // end while

if (isset($ListeMots))  
  unset($ListeMots);
}

?>
