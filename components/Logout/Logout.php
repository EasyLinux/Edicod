<?php
/**
 * Déconnexion de l'application.
 *   Ce composant, déconnecte l'utilisateur et supprime la session en cours.
 *
 * @package		Edicod
 * @subpackage		Framework
 * @version		1.2
 * @author              Serge NOEL
 */

$Empty=0;

/**
 * Initialisation du composant.
 *   Cette fonction est requise dans chaque composant, elle est appellée par index.php lors de la construction de la page.
 *   La fonction renvoi une chaine de caractère contenant le source HTML à afficher.
  *
 * @param		object		Object base de donnees
 * @param		object		Object gui.html
 * @return              string		Code HTML
 */
function ContentInit($Db, $Html)
{
}

/**
 * A déterminer !!!
 *   En auto-appel
 * @todo  		supprimer partout
 */
function JavaScript()
{
}


session_destroy();
header("Location: /index.php" ); 
	
?>
