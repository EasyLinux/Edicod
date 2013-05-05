<?php
/**
* Librairies de fonctions diverses
* 
* @version		1.2
* @package		Edicod
* @subpackage           Framework
* @copyright		Copyright (C) 2005-2009 Serge NOEL. All rights reserved.
* @license		GNU/GPL, see LICENSE.txt
* @todo                 Formater et compléter ce fichier
*
*/

/**
 * fonction qui renvoie le nom du mois dont le chiffre est passé en paramètre 
 *
 * @param	int	Numéro du mois de 1 à 12
 * @return      string  Nom du mois 
 */
function MoisFR($nbmois)
{
$Mois = array("janvier", "f&eacute;vrier", "mars", "avril", "mai", "juin",
              "juillet", "ao&ucirc;t", "septembre", "octobre", "novembre", "d&eacute;cembre");

return $Mois[$nbmois-1];
}

/**
 * Renvoi le jour de la semaine en Français
 *   0 correspond à dimanche
 *
 * @param	integer		jour de la semaine de 0 à 6
 * @return	string		Nom du jour
 */
function f_jourfr($nbjour)
{
$Jour = array("dimanche","lundi","mardi","mercredi","jeudi","vendredi","samedi");

return( $Jour[$nbjour]);
}

/**
 * Conversion de date US->FR
 *
 * @param	string		Date au format américain (AAAA-MM-JJ)
 * @return	string		Date au format européen  (JJ/MM/AAAA)
 */
function Date_US_To_Fr($USDate)
{
$FRDate = substr($USDate,8,2) . "/" . substr($USDate,5,2) . "/" .substr($USDate,0,4);
return($FRDate);
}

//fonction assemble un array pour pouvoir générer un select avec htmlgui
function make_array4select( $nb_line, $nb_selected , $objdb) {

	if ($nb_selected='') {
		$nb_selected = $nb_line + 1000 ;
	}
	
	if ($nb_line != 0) { 
		for($i=0 ; $i<$nb_line ; $i++) {
		
			$selecttab[$i] = $objdb->db_fetch_row() ;
			
			if ($i==$nb_selected ) {
				array_push($selecttab[$i],true);
			}
			else {
				array_push($selecttab[$i],false);
			}
		}
		return $selecttab ;
	}
	return false ;
}



function make_array4list ($nbline,$objdb){
	
	if ($nbline != 0) { 
	
	for($i=0 ; $i<$nbline ; $i++) {
		
		$listdir[$i] = $objdb->db_fetch_row() ;
		
		
	}
	return $listdir ;
}else {
	return false ;
}
	

}

/**
 * Fonction qui retire les accents d'une chaine de caractères
 *
 * @param	string		La chaine à traiter
 * @param	string		Encodage caractère (UTF-8 par défaut)
 * @return	string		La chaine corrigée
 */
function RemoveAccents($str, $charset='utf-8')
{
$str = htmlentities($str, ENT_NOQUOTES, $charset);
    
$str = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml)\;#', '\1', $str);
$str = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $str); // pour les ligatures e.g. '&oelig;'
$str = preg_replace('#\&[^;]+\;#', '', $str); // supprime les autres caractères
    
return $str;
}

/**
 * Fonction qui retire les entités HTML d'une chaine de caractères
 *
 * @param	string		La chaine à traiter
 * @return	string		La chaine corrigée
 * @todo	Completer la liste des entites 
 */
function RemoveHtmlEntities($str)
{
$Replace = array( "&eacute;"=>"e", "&egrave;" => "e", "&ecirc;" => "e", "&eacute;"=>"e", "&agrave;"=>"a", "&ccedil;"=>"c",
  "&ndash;"=>"", "&#039;"=>"'", "&ocirc&"=>"o");

return(strtr($str,$Replace));
}


/**
 * Récupère le nombre de jours entre 2 dates
 *
 * @author NANOGROM_OM, AYTAC GUNTAC
 * @param	date	Date début au format FR
 * @param	date 	Date de fin au format FR
 * @return	integer	Nombre de jour
 */
function NbJours($date_debutCP, $date_finCP)
{
  $tDeb = explode("/", $date_debutCP);
  $tFin = explode("/", $date_finCP);

  $diff = mktime(0, 0, 0, $tFin[1], $tFin[0], $tFin[2]) -
          mktime(0, 0, 0, $tDeb[1], $tDeb[0], $tDeb[2]);

  return(($diff / 86400)+1);

}

// SERVANT AU CALCUL DES JOURS OUVRABLES
// Fonction retournant le nombre de jour fériés samedis et
// dimanches entre 2 dates entrées en timestamp
/**
 *  Calcul du nombre de jours ouvrés entre 2 dates
 *
 */
function jour_ferie($timestampStart, $timestampEnd)
{
    // Initialisation de la date de début
    $jour = date("d", $timestampStart);
    $mois = date("m", $timestampStart);
    $annee = date("Y", $timestampStart);
    $nbFerie = 0;
    $nbFerie2 = 0;
    while ($timestampStart <= $timestampEnd)
    {
			// Calul des samedis et dimanches
			$jour_julien = unixtojd($timestampStart);
			$jour_semaine = jddayofweek($jour_julien, 0);
			if($jour_semaine == 0 || $jour_semaine == 6)
			{
			$nbFerie++;//Samedi (6) et dimanche (0)
			}

				/*CECI A ETE RAJOUTE PAR MES SOINS*/

			if($jour_semaine == 1||$jour_semaine == 2||$jour_semaine == 3||$jour_semaine == 4||$jour_semaine == 5)
			{
         // Définition des dates fériées fixes
        if($jour == 01 && $mois == 01) $nbFerie2++; // 1er janvier
        if($jour == 01 && $mois == 05) $nbFerie2++; // 1er mai
        if($jour == 08 && $mois == 05) $nbFerie2++; // 5 mai
        if($jour == 14 && $mois == 07) $nbFerie2++; // 14 juillet
        if($jour == 15 && $mois == 08) $nbFerie2++; // 15 aout
        if($jour == 01 && $mois == 11) $nbFerie2++; // 1 novembre
        if($jour == 11 && $mois == 11) $nbFerie2++; // 11 novembre
        if($jour == 25 && $mois == 12) $nbFerie2++; // 25 décembre

         // Calcul du jour de pâques
         $date_paques = easter_date($annee);
         $jour_paques = date("d", $date_paques);
         $mois_paques = date("m", $date_paques);
         if($jour_paques == $jour && $mois_paques == $mois) $nbFerie2++;
         // Pâques

         // Calcul du jour de l ascension (38 jours après Paques)
         $date_ascension = mktime(date("H", $date_paques),
         date("i", $date_paques),
         date("s", $date_paques),
         date("m", $date_paques),
         date("d", $date_paques) + 39,
         date("Y", $date_paques)
         );
         $jour_ascension = date("d", $date_ascension);
         $mois_ascension = date("m", $date_ascension);
         if($jour_ascension == $jour && $mois_ascension == $mois) $nbFerie2++;
         //Ascension

         // Calcul de Pentecôte (11 jours après Paques)
        $date_pentecote = mktime(date("H", $date_ascension),
         date("i", $date_ascension),
         date("s", $date_ascension),
         date("m", $date_ascension),
         date("d", $date_ascension) + 11,
         date("Y", $date_ascension)
         );
         $jour_pentecote = date("d", $date_pentecote);
         $mois_pentecote = date("m", $date_pentecote);
         if($jour_pentecote == $jour && $mois_pentecote == $mois) $nbFerie2++;
         //Pentecote
			}

			$jour++;
			$timestampStart=mktime(0,0,0,$mois,$jour,$annee);
			$nbJour = ($timestampEnd - $timestampStart / (60*60*24));
         // Incrémentation du nombre de jour ( on avance dans la boucle)
    }
     return $nbFerie+$nbFerie2;
}//Fin de la fonction

/**
 * fonction qui renvoie un nom aléatoire
 *
 * @param	int	Taille du nom à générer 
 * @return      string  Nom
 */
function GetTmpName($size)
{
$Name = "";

for( $i=0 ; $i<$size ; $i++)
  $Name .= chr(rand(97,122));
return $Name;
}


/**
 * Converti une taille de fichier dans un format plus humain.(Ko, Mo, Go, To)
 *
 *
 * @param 	integer  	Taille à convertir
 * @param	integer		Précision (par défaut 2)
 * @return 	chaine		Chaine représentative
 */
function SizeToHuman($bytes, $precision = 2)
{  
$kilobyte = 1024;
$megabyte = $kilobyte * 1024;
$gigabyte = $megabyte * 1024;
$terabyte = $gigabyte * 1024;
   
if (($bytes >= 0) && ($bytes < $kilobyte)) 
  return $bytes . ' B';
elseif (($bytes >= $kilobyte) && ($bytes < $megabyte)) 
  return round($bytes / $kilobyte, $precision) . ' KB';
elseif (($bytes >= $megabyte) && ($bytes < $gigabyte))
  return round($bytes / $megabyte, $precision) . ' MB';
elseif (($bytes >= $gigabyte) && ($bytes < $terabyte))
  return round($bytes / $gigabyte, $precision) . ' GB';
elseif ($bytes >= $terabyte)
  return round($bytes / $terabyte, $precision) . ' TB';
else
  return $bytes . ' B';
}


/*
$date_debutCP = '01/09/2006' ;
$date_finCP = '31/09/2006' ;
$tDeb = explode("/", $date_debutCP);
$tFin = explode("/", $date_finCP);

$timestampEnd = mktime(0, 0, 0, $tFin[1], $tFin[0], $tFin[2]);
$timestampStart = mktime(0, 0, 0, $tDeb[1], $tDeb[0], $tDeb[2]);

$a=NbJours($date_debutCP, $date_finCP);
$b=jour_ferie($timestampStart, $timestampEnd);
$testcp = round( $a - $b , 0);

echo 'Ouvert : '.$testcp.'</br> NBjour : '.$a.'</br> NBferié : '.$b;
*/

/**
 * Créer une entrée dans le journal.
 *
 *    Cette fonction crée une entrée dans le journal hors document
 *    0 - Futur
 *    1 - Dossiers virtuels 
 *    2 - Classement
 *    3 - Dossiers disque dur
 *
 * @todo        prévoir niveau de log
 * @param	objet	Base de données
 * @param	uid	uid de l'utilisateur
 * @param       int     Source de la ligne de log (voir codes ci-haut)
 * @param	chaine	chaine de caractère décrivant l'événement
 * @return      void
 */
function MyLog($Db, $Uid, $Source, $Msg)
{
$Sql = "INSERT INTO doclog SET uid=$Uid, did=0, action=$Source, description='$Msg';";
$Db->Query($Sql);
} 
 
?>
