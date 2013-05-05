<?php
/**
 * Gestion du menu utilisateur.
 * 
 * @author 		Serge NOEL
 * @version 		1.2
 * @package 		Edicod
 * @subpackage          Framework
 * @tutorial		Menu.pkg
 */

$Empty=0;

/**
 * Gestion du menu utilisateur.
 * Renvoi une chaine de caractères contenant le code HTML du menu
 * 
 * @param		objet	 Objet base de donnees
 * @param		int   	 Droits de l'utilisateur courant
 */
function GetMenu($Db,$Rights)
{
$sMenu = "<!-- MENU - ". __FILE__ ." -->
<div class='menu'>
<table border='0' cellspacing='0' cellpadding='0' width='250px'>
  <tr>
    <td class='CadreTopLeft'></td>
    <td class='CadreTop'>Menu principal</td>
    <td class='CadreTopRight'></td>
  </tr>
    <td class='CadreLeft'></td>
    <td class='CadreContent'>&nbsp;</br>";

$query  = "SELECT * ";
$query .= "FROM menu ";
$query .= "WHERE parent=0 ";
$query .= "AND rights & $Rights ";
$query .= "ORDER BY ordering";
$sMenu .= "\n<!-- SQL ! $query -->\n";
$Db->Query($query);
$Menus = $Db->loadObjectList();
// Parcours les lignes de la table
    foreach($Menus as $Menu)
      {
      if( $Menu->link == "." )
        { // Menus parents (lien avec . )
        $sMenu .= "  <div class='MenuLevel0' >\n";
        $sMenu .= "    <img src='/img/menu/minus.png' id='Fold".$Menu->id_menu."' alt='Ouvrir/Fermer menu' title='Ouvrir/Fermer menu'";
        $sMenu .= "class='ImgButton' onClick='MenuToggle(\"".$Menu->id_menu."\");' />&nbsp;". $Menu->display ."\n" ;
        $sMenu .= "    <div class='MenuLevel1' id='Sub".$Menu->id_menu."'>\n";
        // Afficher le sous menu
        $query  = "SELECT * ";
        $query .= "FROM menu ";
        $query .= "WHERE parent=".$Menu->id_menu." ";
        $query .= "AND rights & $Rights ";
        $query .= "ORDER BY ordering";
        $Db->Query($query);
        $subMenus = $Db->loadObjectList();
        // parcourir les menus enfants
        foreach( $subMenus as $subMenu )
          {
          if( empty($subMenu->icon) )
            $Img = "<img src='/img/empty.png' alt='' style='border: 0px' />";
          else 
            $Img = "<img src='/img/menu/".$subMenu->icon."' alt='' style='border: 0px' />";
          if( substr($subMenu->link,0,1) != '/' )
            $sMenu .= "      <a href='/index.php?option=".$subMenu->link."' style='text-decoration: none; color: black;' >$Img ". $subMenu->display ."</a><br />\n";
          else
            $sMenu .= "      <a href='".$subMenu->link."' style='text-decoration: none; color: black;' >$Img ". $subMenu->display ."</a><br />\n";
          }
        $sMenu .= "    </div>\n";
        $sMenu .= "  </div>\n";
        } // if
      else
        {  // Menus 
        if( $Menu->ordering < 100 || $Menu->ordering > 899) // menu à la racine
          $sMenu .= "  <div class='MenuLevelHome' >\n";
        else
          $sMenu .= "  <div class='MenuLevel1' >\n";
        $sMenu .= "    <img src='/img/menu/".$Menu->icon."' alt='' style='border: 0px' />\n";
        if( substr($Menu->link,0,1) != '/' )
          $sMenu .= "      <a href='/index.php?option=".$Menu->link."' style='text-decoration: none; color: black;' >". $Menu->display ."</a><br />\n";
        else
          $sMenu .= "      <a href='".$Menu->link."' style='text-decoration: none; color: black;' >". $Menu->display ."</a><br />\n";
        $sMenu .= "  </div>\n";
        }
      } // foreach
    $sMenu .= "</td>
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
<!-- MENU -->\n\n";
    // renvoi la chaine construite
    return($sMenu);
    }




?>
