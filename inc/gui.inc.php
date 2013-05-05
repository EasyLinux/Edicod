<?php
/**
 * Gestion de l'affichage HTML
 * 
 * @version		1.2
 * @package		Edicod
 * @subpackage           Framework
 * @copyright		Copyright (C) 2005 - 2009 Serge NOEL. All rights reserved.
 * @license		GNU/GPL, see LICENSE.txt
 * @tutorial		Gui.pkg
 *
 *
 * @todo		Cette classe est à revoir en profondeur et à documenter en détail
 *
 */

$Empty=0; 

/**
* Gestion de l'affichage HTML
* 
* @version		1.2
* @package		Edicod
* @subpackage           Framework
*/
class guihtml {

  private $CSS ;
  private $JS ;
  private $ICO ;
  private $CHARSET ;
  private $TITRE ;
  private $JAVASCRIPT;

  private $MAIN ;
  private $BANDEAU ;
  private $MENU ;

  function __construct( $ico, $charset ) 
    {
    $this->CSS     = "" ;       // Feuille de style
    $this->ICO     =  $ico ;      // Icône du site
    $this->CHARSET = $charset ;   // Codage caractère
    $this->MAIN    = "" ;
    $this->BANDEAU = "" ;
    $this->MENU    = "" ;
    $this->JS      = array() ;
    $this->JS_FILE = "";
    }

  /**
   * Affiche la barre d'outils passee en parametre
   * 
   * @param		array	 Description de la barre d'outils
   * @param		string   Espace pour réaliser l'indentation
   */
  function ToolBar ($ToolBars, $Offset)
    {
    // Creer un div de type boutons avec les 
    $Max = count($ToolBars);
    $Size = (100 / $Max)-2;
    if( isset($Toolbar) )
      $Toolbar .= "$Offset<div class='formButtons'>\n";
    else
      $Toolbar = "$Offset<div class='formButtons'>\n";
    for( $i=0 ; $i<$Max ; $i++)
      {
      if( $i == 0  )
        $Toolbar .= "$Offset  <div class='formButtonsItem' style='width: $Size%; margin-left: 10px' >\n";
      else
        $Toolbar .= "$Offset  <div class='formButtonsItem' style='width: $Size%' >\n";
      $Toolbar .= "$Offset    <img src='".$ToolBars[$i][0]."' class='ImgButtonBar' alt='".$ToolBars[$i][1];
      $Toolbar .= "' title='".$ToolBars[$i][1]."' onClick='".$ToolBars[$i][2]."' />\n";
      $Toolbar .= "$Offset  </div>\n";
      if( !empty( $ToolBars[$i][3] ) )
        $this->add_javascript($ToolBars[$i][3]);
      }
    $Toolbar .= "$Offset</div>\n";
    return( $Toolbar);
    }
    
/**
   * Affiche la barre d'outils passee en parametre
   * 
   * @param		array	 Description des boutons à afficher à gauche de type (tableau de array("url/image","NomBouton","FonctionOnClick()")
   * @param		array	 Description de la barre des boutons à afficher à droite
   * @param		int		 Taille de la barre d'outils (en px) 
   * @param		string   Espace pour réaliser l'indentation
   * @return	string	 Code HTML de la barre d'outils
   */
  function ToolBar2($ToolBarsLeft, $ToolBarsRight, $Width, $Offset)
    {
    // Creer un div de type boutons avec les 
    $nbRight = count($ToolBarsRight);
    $nbLeft = count($ToolBarsLeft);
    
    if( isset($Toolbar) )
      $Toolbar .= "$Offset<div class='formButtons2' style='width:".$Width."px'>\n";
    else
      $Toolbar = "$Offset<div class='formButtons2' style='width:".$Width."px'>\n";
	
    // Boutons de gauche
	for($i=0; $i<$nbLeft; $i++)
	{
		$Toolbar .= "$Offset  <div class='formButtonsItemL'>\n";
		$Toolbar .= "$Offset    <img src='".$ToolBarsLeft[$i][0]."' class='ImgButtonBar' alt='".$ToolBarsLeft[$i][1];
	    $Toolbar .= "' title='".$ToolBarsLeft[$i][1]."' onClick='".$ToolBarsLeft[$i][2]."' />\n";
	    $Toolbar .= "$Offset  </div>\n";
	    if( !empty( $ToolBarsLeft[$i][3] ) )
	    	$this->add_javascript($ToolBarsLeft[$i][3]);
	}
    
    	
    // Boutons de droite
	for($i=0; $i<$nbRight; $i++)
	{
		$Toolbar .= "$Offset  <div class='formButtonsItemR'>\n";
		$Toolbar .= "$Offset    <img src='".$ToolBarsRight[$i][0]."' class='ImgButtonBar' alt='".$ToolBarsRight[$i][1];
	    $Toolbar .= "' title='".$ToolBarsRight[$i][1]."' onClick='".$ToolBarsRight[$i][2]."' />\n";
	    $Toolbar .= "$Offset  </div>\n";
	    if( !empty( $ToolBarsRight[$i][3] ) )
	    	$this->add_javascript($ToolBarsRight[$i][3]);
	}  	
   	
    $Toolbar .= "$Offset</div>\n";
    return( $Toolbar);
    }

  /**
   * Affiche un tableau
   * 
   * @param		array	 Liste des champs a afficher
   * @param		array    resultat de la requete SQL
   * @param             string   nom du champs de reference
   * @param             int      Largeur du tableau
   * @param             int      Hauteur du tableau (hors entete)
   * @param             string   chaine avec les espaces pour l'indentation
   */
  function DisplayTable($Fields, $Rows, $FieldId, $Width, $Height, $Offset)
    {
    $Display  = "$Offset<div class='formLine1'>\n";
    $Display .= "$Offset  <span class='form_Box'><input type='checkbox' disabled /></span>\n";
    // Entete du tableau
    foreach($Fields as $Field)
      $Display .= "$Offset  <span class='form_Item' style='width: ".$Field[2]."px'>".$Field[0]."</span>\n";
    // Cadre de la liste
    $Display .= "$Offset</div>\n";
    $Display .= "$Offset<div class='formList' style='width: ".$Width."px; height: ".$Height."px' >\n";
    // Lignes du tableau
    foreach( $Rows as $Row )
      { // modifier couleur texte si Valid == 0
      $Display .= "$Offset  <div class='formLine2'>\n";
      $Display .= "$Offset    <span class='formBox' ><input type='radio' id='Chk' name='Chk' onclick=\"SetActive(this.value);\" value='".$Row[$FieldId]."' /></span>\n";
      //$LastItem = count($Params["Field"]);
      // colonnes de la liste
      foreach($Fields as $Item )
        $Display .= "$Offset    <span class='formItem' style='width: ".$Item[3]."px' >&nbsp;".$Row[$Item[1]]."</span>\n";
      $Display .= "$Offset  </div>\n"; 
      }
    $Display .= "$Offset</div>\n";

    $this->add_js_file("/js/getActive.js");
    return($Display);

    }

  /**
   * Affiche le bandeau
   * 
   * @param		string	 Image du logo a afficher
   * @param		string   Titre de la page
   * @param             string   Date à afficher dans le bandeau
   * @param             string   Nom de l'utilisateur en cours
   */
  function MakeBandeau ($logo, $titre, $date,$user) 
    {
    $this->BANDEAU  = "<!-- Bandeau - ". __FILE__ ." -->\n";
    $this->BANDEAU .= "  <div class='bandeau'>\n";
    $this->BANDEAU .= "    <span class='b-logo'><img src=\"".$logo."\"></span>\n";
    $this->BANDEAU .= "    <span class='b-title'>Gestion du courrier<span class='b-title-v' > V: ".$_SESSION['Parameters']['VersionEngine']."</span></span>\n";
    $this->BANDEAU .= "    <span class='b-info'><p class='date'>$date</p><p>$user</p></span>\n";
    $this->BANDEAU .= "  </div>\n";
    $this->BANDEAU .= "<!-- Bandeau -->\n" ;
   }

  /**
   * Affiche un Popup
   * 
   * @param		string	 Image du logo a afficher
   * @param		string   Titre de la page
   * @param             string   Date à afficher dans le bandeau
   * @param             string   Nom de l'utilisateur en cours
   */
  function MakePopup( $Popup )
    {
    $Code  = "\n<!-- Popup - ". __FILE__ . " -->\n";
    $Code .= "<div id='Popup' style='display: none'>\n";
    $Code .= "  <form method='".$Popup["Method"]."' action='".$Popup["Action"]."' id='".$Popup["Name"]."' accept-charset='".$this->CHARSET."'>\n";

    // Si onglets
    if( count($Popup["Tabs"]) > 0 )
      {
      $Code .= "&nbsp;<br />";
      $Code .= $this->Make_TabHeaders($Popup["Tabs"]["Content"]); 
      $Code .= $this->Make_Tabs($Popup["Tabs"]["Content"],$Popup["Tabs"]["Width"],$Popup["Tabs"]["Height"]); 

      // Creer tableau javascript
      $Var = "\n// Variables du formulaire \n";
      $Var .= "Variables = [\n";
      foreach($Popup["Tabs"]["Content"] as $Tab)
        $Var .= $this->Make_Variables($Tab["Fields"]);
      $Var = substr($Var,0,strlen($Var)-2)."];\n";

      }
    else
      { //Pas d'onglets
      $Code .= "    &nbsp;<br />\n";
      foreach($Popup["Fields"] as $Field)
        {
/*$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
        $Code .= "      <div class='formPopupLine'>\n";
        $Code .= "        <span class='formPopupL' style='width: ".$Popup["LabelW"]."px'>".$Field[1]."</span>";
        $Code .= $this->GetHtmlInput($Field);
        $Code .= "      </div>\n";
*/

        if( $Field[3] != 'hidden')
          {
          $Code .= "     <div class='fpPopDiv1' style='width: ".$Popup["LabelW"]."px;'>".$Field[1]."</div>\n";
          $Code .= $this->GetHtmlInput($Field);
          }
        else
          $Code .= $this->GetHtmlInput($Field);
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
        }

      // Creer tableau javascript
      $Var = "\n// Variables du formulaire \n";
      $Var .= "Variables = [\n";
      $Var .= $this->Make_Variables($Popup["Fields"]);
      $Var = substr($Var,0,strlen($Var)-2)."];\n";
      }
    // Boutons d'action du Popup
    $Code .= $this->ToolBar($Popup["Buttons"],"    ");
    $Code .= "  </form>\n";
    $Code .= "</div>\n";
    $Code .= "<!-- Fin Popup -->\n";

    $Code .= "<div id='overlay_modal' class='overlay_bluelighting' style='position: absolute; top: 0px; left: 0px; z-index: 5; width: 100%; height: 100%; ";
    $Code .= "opacity: 0.6; display: none;'/>\n</div>\n";



    // Fonction de validation de formulaire
    $this->add_js_file("/js/prototype.js");
    $this->add_js_file("/js/effects.js");
    $this->add_js_file("/js/window.js");
    $this->add_js_file("/js/valid.js");
    $this->add_js_file("/js/htmlentities.js");
    $this->add_js_file("/js/MD5.js");
    $this->add_javascript($Var);
    return($Code);
    }

  /**
   * Cree les entetes de tabulation
   * 
   * @param		string	 Image du logo a afficher
   * @param		string   Titre de la page
   * @param             string   Date à afficher dans le bandeau
   * @param             string   Nom de l'utilisateur en cours
   */
   function Make_TabHeaders($TabsContent)
     {
     $Content = "    <div class='formPopupLine'>\n      <span class='formMargin'>&nbsp;</span>\n";
     $i=1;
     // Entete d'onglet
     foreach( $TabsContent as $Tab )
       {
       if ( $i == 1 )
         $Content .= "      <span class='formTabTitleOn' id='TabT$i' onClick='Tab();'>".$Tab["Title"]."</span>\n";
       else
         $Content .= "      <span class='formTabTitleOff' id='TabT$i' onClick='Tab();'>".$Tab["Title"]."</span>\n";
       $i++;
       }
     $Content .= "    </div>\n";
     return( $Content );
     }

  /**
   * Cree les contenus de tabulation
   * 
   * @param		string	 Image du logo a afficher
   * @param		string   Titre de la page
   * @param             string   Date à afficher dans le bandeau
   * @param             string   Nom de l'utilisateur en cours
   */
   function Make_Tabs($TabsContent, $Width, $Height)
     {
     // Contenu des onglets
     $i = 1;
     $Content .= "    <div class='formMargin'>&nbsp;</div>\n";
     foreach( $TabsContent as $Tab )
       {
       if( $i == 1 )
         $Content .= "    <div class='formTabOn' id='Tab$i' style='width: ".$Width."px; height: ".$Height."px' >\n";
       else
         $Content .= "    <div class='formTabOff' id='Tab$i' style='width: ".$Width."px; height: ".$Height."px' >\n";
       // Parcourir les champs à afficher dans l'onglet
       foreach($Tab["Fields"] as $Field)
         {
         $Content .= "      <div class='formPopupLine'>\n";
         $Content .= "        <span class='formPopupL' style='width: ".$Tab["LabelW"]."px'>".$Field[1]."</span>";
         $Content .= $this->GetHtmlInput($Field);
         $Content .= "      </div>\n";
         }
       $Content .= "    </div>\n";
       $i++;
       }
     return( $Content );
     }

  /**
   * Cree les contenus de tabulation
   * 
   * @param		string	 Image du logo a afficher
   * @param		string   Titre de la page
   * @param             string   Date à afficher dans le bandeau
   * @param             string   Nom de l'utilisateur en cours
   */
  function GetHtmlInput($Field)
    {
    $Content = "";
    switch( $Field[3] )
      {
      case none:
        break;

      case 'text':
      case 'mail':
      case 'phone':
      case 'int':
        if( $Field[5] == 1 )
          $Asterisk="<font color='red' style='float: left'>&nbsp;*</font>";
        else 
          $Asterisk="";
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
//        $Content .= "<input type='text' class='formPopupI' name='".$Field[2]."' id='".$Field[2]."' value='".$Field[4]."' style='width: ".$Field[0]."px' />$Asterisk\n";
        $Content .= "<div class='fpPopDiv2' style='width: ".$Field[0] ."px'>\n";
        $Content .= "<input type='text' class='fpPopInp2' name='".$Field[2]."' id='".$Field[2]."' value='".$Field[4]."' style='width: ".$Field[0]."px' />\n";
        $Content .= "</div>";
        break;

      case 'select':
        $Content .= "<select name='".$Field[2]."' id='".$Field[2]."' style='width: ".$Field[0]."px' class='fpPopInp2' ></select>\n";
        break;

      case 'check':
        $Content .= "<input type='checkbox' name='".$Field[2]."' id='".$Field[2]."' class='fpPopInp2' >\n";
        break;

      case 'password':
        if( $Field[5] == 1 )
          $Asterisk="<font color='red'>&nbsp;*</font>";
        else 
          $Asterisk="";
        $Content .= "<input type='password' class='fpPopInp2' name='".$Field[2]."' id='".$Field[2]."' style='width: ".$Field[0]."px' />$Asterisk\n";
        break;

      case 'MD5pwd':
        if( $Field[5] == 1 )
          $Asterisk="<font color='red'>&nbsp;*</font>";
        else 
          $Asterisk="";
        $Content .= "<input type='password' class='fpPopInp2' name='".$Field[2]."' id='".$Field[2]."' 
                      onChange='document.getElementById(\"".$Field[4]."\").value = MD5(this.value);' style='width: ".$Field[0]."px' />$Asterisk\n";
        break;

      case 'double':
        $Content .= "<input type='text' class='fpPopInp2' name='".$Field[4]."' id='".$Field[4]."' style='width: ".$Field[5]."px' />\n";
        $Content .= "          <input type='text' class='fpPopInp2' name='".$Field[7]."' id='".$Field[7]."' style='width: ".$Field[8]."px; margin-left: 10px' />\n";
        break;
    
      case 'display':
        $Content .= "<span id='".$Field[2]."' style='width: ".$Field[8]."px'></span>";
        break;

      case 'hidden':
        $Content .= "    <input type='hidden' name='".$Field[2]."' id='".$Field[2]."' value='".$Field[4]."' >\n";
        break;

      case 'mchk':
        $Content .= "<input type='checkbox' />Utest\n";
        break; 

      default:
        $Msg = "<h2>Champs ".$Field[3]." non défini : ".__FILE__."</h2>";
        die($Msg);
      }
    return( $Content );
    }

  /**
   * Affiche une liste et prepare un formulaire 
   *
   * @param		object		Objet bdd
   * @param		array           Paramètres
   */
  function MakeHtmlList($Db, $Params)
    {
    // Retrouver les paramètres
    $query  = $Params["Sql"];
    $Db->Query($query);
    $Rows = $Db->loadArrayList();

    // Debut et titre de la liste
    $Content  = "\n";
    $Content .= "<form name='" . $Params["Name"] . "' action='" . $Params["Action"]."' method='".$Params["Action"]."' accept-charset='".$this->CHARSET."'>\n";
    $Content .= "  <table border='0' cellspacing='0' cellpadding='0' width='".(20+ $Params["Width"])."px'>\n";
    $Content .= "    <tr>\n";
    $Content .= "      <td class='CadreTopLeft'></td>\n";
    $Content .= "      <td class='CadreTop'>".$Params["Title"]."</td>\n";
    $Content .= "      <td class='CadreTopRight'></td>\n";
    $Content .= "    </tr>\n";
    $Content .= "      <td class='CadreLeft'></td>\n";
    $Content .= "      <td class='CadreContent'>&nbsp;</br>\n";
//    $Content .= "        <div class='form' style='height:  ".$Params["Height"]."px' >\n";  

    $Content .= $this->DisplayTable($Params["Fields"],$Rows, $Params["FieldId"], $Params["ListW"],$Params["ListH"],"        ");

    // Boutons d'action de la liste
    $Content .= $this->ToolBar($Params["Buttons"], "        ");

    $Content .= "\n";
    $Content .= "        </div></td>\n";
    $Content .= "      <td class='CadreRight'></td>\n";
    $Content .= "    <tr>\n";
    $Content .= "    </tr>\n";
    $Content .= "      <td class='CadreBottomLeft'></td>\n";
    $Content .= "      <td class='CadreBottom'></td>\n";
    $Content .= "      <td class='CadreBottomRight'></td>\n";
    $Content .= "    <tr>\n";
    $Content .= "    </tr>\n";
    $Content .= "  </table>\n";
    $Content .= "</form>\n";

    if( isset($Params["Popup"]) && count() > 0 )
      {
      $Popup = $this->MakePopup($Params["Popup"]);
      $Content .= $Popup;
      }

    $Content .= "<!-- Initialiser les données -->\n";
    $Content .= "<script type='text/javascript' >\n";
    $Content .= "\n// Fenetre popup\n";
    $Content .= "win = new Window('Pop2',{className: \"bluelighting\",";
    $Content .= "closable:false, resizable:false, maximizable: false, minimizable:false, ";
    $Content .= "showEffect:Effect.Appear, hideEffect:Effect.Fade});\n";
    $Content .= "win.setZIndex(10);\n";
    $Content .= $Params["Init_JS"];
    $Content .= "</script>\n";

    if( isset($ID) ) 
      $this->add_JS_Init($Params, $ID);
    $this->add_css("/css/default.css");
    $this->add_css("/css/lighting.css");

    return($Content);
    }
    
    
/**
   * Affiche une liste et prepare un formulaire 
   *
   * @param		object		Objet bdd
   * @param		array       Liste de paramètres
   * (Sql, Name, Action, Method, Title, Width, Height, ListW, ListH, FieldId, Init_JS, Fields, ButtonsLeft, ButtonsRight)
   */
  function MakeHtmlList2($Db, $Params)
    {
    // Retrouver les paramètres
    $query  = $Params["Sql"];
    $Db->Query($query);
    $Rows = $Db->loadArrayList();

    // Debut et titre de la liste
    $Content  = "\n";
    $Content .= "<form name='" . $Params["Name"] . "' action='" . $Params["Action"]."' method='".$Params["Action"]."' accept-charset='".$this->CHARSET."'>\n";
    $Content .= "  <table border='0' cellspacing='0' cellpadding='0' width='".(20+ $Params["Width"])."px'>\n";
    $Content .= "    <tr>\n";
    $Content .= "      <td class='CadreTopLeft'></td>\n";
    $Content .= "      <td class='CadreTop'>".$Params["Title"]."</td>\n";
    $Content .= "      <td class='CadreTopRight'></td>\n";
    $Content .= "    </tr>\n";
    $Content .= "      <td class='CadreLeft'></td>\n";
    $Content .= "      <td class='CadreContent'>&nbsp;</br>\n";
//    $Content .= "        <div class='form' style='height:  ".$Params["Height"]."px' >\n";  

    $Content .= $this->DisplayTable($Params["Fields"],$Rows, $Params["FieldId"], $Params["ListW"],$Params["ListH"],"        ");

    // Boutons d'action de la liste
    $Content .= $this->ToolBar2($Params["ButtonsLeft"], $Params["ButtonsRight"], $Params["ListW"], "        ");

    $Content .= "\n";
    $Content .= "        </div></td>\n";
    $Content .= "      <td class='CadreRight'></td>\n";
    $Content .= "    <tr>\n";
    $Content .= "    </tr>\n";
    $Content .= "      <td class='CadreBottomLeft'></td>\n";
    $Content .= "      <td class='CadreBottom'></td>\n";
    $Content .= "      <td class='CadreBottomRight'></td>\n";
    $Content .= "    <tr>\n";
    $Content .= "    </tr>\n";
    $Content .= "  </table>\n";
    $Content .= "</form>\n";

    if( isset($Params["Popup"]) && count() > 0 )
      {
      $Popup = $this->MakePopup($Params["Popup"]);
      $Content .= $Popup;
      }

    $Content .= "<!-- Initialiser les données -->\n";
    $Content .= "<script type='text/javascript' >\n";
    $Content .= "\n// Fenetre popup\n";
    $Content .= "win = new Window('Pop2',{className: \"bluelighting\",";
    $Content .= "closable:false, resizable:false, maximizable: false, minimizable:false, ";
    $Content .= "showEffect:Effect.Appear, hideEffect:Effect.Fade});\n";
    $Content .= "win.setZIndex(10);\n";
    $Content .= $Params["Init_JS"];
    $Content .= "</script>\n";

    if( isset($ID) ) 
      $this->add_JS_Init($Params, $ID);
    $this->add_css("/css/default.css");
    $this->add_css("/css/lighting.css");

    return($Content);
    }

  /**
   * Cree le code HTML de la page 
   *
   * @param		object		Objet bdd
   * @param		array           Paramètres
   */
  function make_page ($titre) 
    {
    $page  = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n";
    $page .= "<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"fr\">\n";
    $page .= "<meta content=\"text/html; charset=".$this->CHARSET."\" http-equiv=\"content-type\">\n";
    $page .= "<head>\n";
    $page .= "  <title>$titre</title>\n" ;
    
    // Inclure les feuilles de style
    $page .= $this->CSS ;

    // Inclure les fichiers de scripts
    $page .= $this->JS_FILE;
    $page .= "  <link rel=\"shortcut icon\" href=\"".$this->ICO."\" />\n";
    $page .= "</head>\n<body>\n" ;
	
    // Afficher javascript inclus
    if ($this->JAVASCRIPT != "")  
      {
      $page .= "<script type='text/javascript'>\n";
      $page .= $this->JAVASCRIPT ."\n" ;
      $page .= "</script>\n";
      }
	
    // Afficher bandeau
    if ($this->BANDEAU != "")  
      $page .= $this->BANDEAU ."\n" ;
	
    // Afficher menu
    if ($this->MENU != "") 
      $page .= $this->MENU ;

    // Contenu
    if ($this->MAIN != "") 
      $page .= $this->MAIN;

    $page .= "<div class='formStatus' id='Status'>&nbsp;</div>\n";
    $page .= "</body>\n</html>\n" ;
    return $page ;	
    }

  /**
   * Cree le code HTML d'un formulaire 
   *
   * @param		object		Objet bdd
   * @param		array           Paramètres
   * @param             int/string      Identifiant de l'enregistrement à afficher
   */
  function Make_HtmlForm($Db, $Params, $ID)
    {
    $Html  = "";
    // Retrouver les paramètres
    $query  = $Params["Sql"];
    $Db->Query($query);
    $Row = $Db->loadArray();
    $Html .= "<form method='".$Params["Method"]."' action='".$Params["Action"]."' id='".$Params["Name"]."' accept-charset='".$this->CHARSET."'>\n";
    $Html .= "  <table border='0' cellspacing='0' cellpadding='0' width='".(20+ $Params["Width"])."px'>\n";
    $Html .= "    <tr>\n";
    $Html .= "      <td class='CadreTopLeft'></td>\n";
    $Html .= "      <td class='CadreTop'>".$Params["Title"]."</td>\n";
    $Html .= "      <td class='CadreTopRight'></td>\n";
    $Html .= "    </tr>\n";
    $Html .= "      <td class='CadreLeft'></td>\n";
    $Html .= "      <td class='CadreContent'>\n";

    foreach($Params["Fields"] as $Field)
      {
      $Html .= "        <div class='formLine'>\n";
      $Html .= "          <span class='formL' style='width: ".$Field[0]."px'>".$Field[1]."</span>";
      $Html .= $this->GetHtmlInput($Field);
      $Html .= "        </div>\n";
      }
    // Boutons d'action de la liste
    $Html .= $this->ToolBar($Params["Buttons"],"      ");
    $Html .= "      </td>\n";
    $Html .= "      <td class='CadreRight'></td>\n";
    $Html .= "    <tr>\n";
    $Html .= "    </tr>\n";
    $Html .= "      <td class='CadreBottomLeft'></td>\n";
    $Html .= "      <td class='CadreBottom'></td>\n";
    $Html .= "      <td class='CadreBottomRight'></td>\n";
    $Html .= "    <tr>\n";
    $Html .= "    </tr>\n";
    $Html .= "  </table>\n";
    $Html .= "</form>\n";    
    $Html .= "<div class='formStatus' id='Status'>&nbsp;</div>\n\n";
    $Html .= "<!-- Initialiser les données -->\n";
    $Html .= "<script type='text/javascript' >\n";
    if( strlen($Params["Init_JS"]) >0 ) 
      $Html .= $Params["Init_JS"];
    $Vars  = "\n// Variables du formulaire\n";
    // Creer tableau
    $Vars .= "Variables = [\n";
    $Vars .= $this->Make_Variables($Params["Fields"]);
    $Vars  = substr($Vars,0,strlen($Vars)-2)."];\n";
    $Html .= $Vars;
    $Html .= "\nFormInit('$ID');\n";
    $Html .= "</script>\n";

    $this->add_JS_Init($Params, $ID);
    $this->add_css("/css/default.css");
    $this->add_css("/css/lighting.css");
    $this->add_js_file("/js/prototype.js");
    $this->add_js_file("/js/effects.js");
    $this->add_js_file("/js/window.js");

    return( $Html );
    }
   
  /**
   * Cree le code JS de la fonction d'initialisation d'un formulaire 
   *
   * @param		array           Paramètres
   * @param             int/string      Identifiant de l'enregistrement à afficher
   */
  function add_JS_Init($Params, $ID)
    {

    $this->add_js_file("/js/forminit.js");
    $this->add_js_file("/js/valid.js");
    $this->add_javascript($Var);
    }

  /**
   * Cree le code JS du tableau des champs  
   *
   * @param		array           Paramètres
   * @param             int/string      Identifiant de l'enregistrement à afficher
   */
  function Make_Variables($Fields)
    {
    $Max = count($Fields);
    for( $i=0 ; $i < $Max ; $i++)
      {
      switch( $Fields[$i][3] )
        {
        case 'double':
          $Var .= "      ['".$Fields[$i][4]."','".$Fields[$i][6]."',0],\n";
          $Var .= "      ['".$Fields[$i][7]."','".$Fields[$i][9]."',0],\n";
          break;
    
        case 'none':
          $break;

        case 'select':
          $Var .= "      ['".$Fields[$i][2]."','".$Fields[$i][3]."',0],\n";
          break;

        default:
          $Var .= "      ['".$Fields[$i][2]."','".$Fields[$i][3]."',".$Fields[$i][5]."],\n";
          break;
        
        }
      }
    return($Var);
    }






































  /**
  * Méthode make_menu 
   *
   * @param array tableau contenant le texte de la rubrique, son style, ses sous-rubriques et leur style.
   **/
	
  function make_menu ($rubriques ) 
    {
print "<h2> Obsolete ??? </h2>";
    //vérification de la présence du javascript pliage dépliage des menus et de gestion des liens.
    $this->test_js ("js/menu_open_close.js") ;
    $this->test_js ("js/linkpage.js") ;

    $tmpmenu = "  <div class=\"menu\">\n" ;
    for ($i=0; count($rubriques) ; $i++) 
      {
      $tmpmenu .= "  <p onclick=\"menu_open_close(\'menu".$i. "\')\"" ; 
      if ( $rubriques[$i][1] != "") 
        $tmpmenu .= " class=\"".$rubriques[$i][1]."\"" ;
      $tmpmenu .= " >".$rubriques[$i][0]." </p>\n" ;

      $tmpmenu .= "  <div  id=\"menu".$i."\" class=\"menu_open\" >\n" ;
      $tmpmenu .= "    <ul  class=\"".$rubriques[$i][2]."\" >\n" ;
      $tmpmenu .= "      <li onClick=\"linkpage(\'".$rubriques[$i][3][1]."\');" ;
      if ($rubriques[$i][3][2] != "") 
        $tmpmenu .= " class=\"".$rubriques[$i][3][2]."\"" ;
      $tmpmenu .= " > " ;
      $tmpmenu .= $rubriques[$i][3][0]."</li>\n" ;
      $tmpmenu .= "    </ul>\n" ;
      $tmpmenu .= " </div>\n" ;
      }
    $tmpmenu .= "</div>\n" ; 
    $this->MENU = $tmpmenu."<div class=\"menu\">\n" ;
    }



//$onglet est un tableau qui contient Le texte de chacun des onglets
//$contenutab contient les données à afficher.
//remarque les deux tableaux doivent avoir le même nombre d'éléments.

function make_onglet ($onglet, $contenutab) {
	
	//verification de la présence du script pour l'affichage des onglets.
	
	$this->test_js ("js/onglet.js") ;
	
	if (count($onglet) !== count($contenutab)) {
		
		return false ;
		
		}
	
		
		$tmphtmlonglet="<div id=\"listeonglet\"  > ";
		$tmphtmltab="<div id=\"alltab\" > " ;
		
	for ($i=0;$i<count($onglet);$i++) {
		
		if ($i == 0) {
			$tmphtmlonglet.="<div class=\"onglet_selected\" onclick=\"hide(this.id,'tab".$i."')\" id=\"on".$i."\"> &nbsp;".$onglet[$i]."&nbsp;</div>" ;
		}else{
		
		$tmphtmlonglet.="<div class=\"onglet\" onclick=\"hide(this.id,'tab".$i."')\" id=\"on".$i."\"> &nbsp;".$onglet[$i]."&nbsp;</div>" ;
	}
		$tmphtmltab.=" <div class=\"";
		if ($i==0) { 
					$tmphtmltab.="tab\" " ;
					 }else { $tmphtmltab.="hidetab\" " ;
				 }
				 				 
		 $tmphtmltab.="id=\"tab".$i."\" > ".$contenutab[$i]."</div> " ;
		 
		}
		
		$tmphtmlonglet.="</div> ";
		$tmphtmltab.="</div> " ;
	
	return $tmphtmlonglet." ".$tmphtmltab ;
	
	
	}
	
	//test si un javascript est déjà present ou pas.
	function test_js ($nom_script) {


			$js_present=false ;
	
		for ($i=0 ; $i< count($this->JS) ; $i++  ) {
		
			if ($this->JS[$i] === $nom_script ) 
			{ 
			
			$js_present = true ;
			
			}
		
		}
	
		if ( !$js_present ) 
			{ 
				array_push($this->JS, $nom_script ) ; 
			}
		   	
	}
	
	
	
//$onglet est un tableau qui contient Le texte de chacun des onglets
//$contenutab contient les données à afficher.
// $selection est un entier permettant de désigner l'onglet sélectionné 
// attention numérotation commence à 0
//remarque les deux tableaux doivent avoir le même nombre d'éléments.
	
	
	function make_onglet_selected ($onglet, $contenutab, $selection) {
	
	//verification de la présence du script pour l'affichage des onglets.
	
	$this->test_js ("js/onglet.js") ;
	
	
		
	if (count($onglet) !== count($contenutab)) {
		
		return false ;
		
		}
	
		
		$tmphtmlonglet="<div id=\"listeonglet\"  > ";
		$tmphtmltab="<div id=\"alltab\" > " ;
		
	for ($i=0;$i<count($onglet);$i++) {
		
		if ($i == $selection) {
			$tmphtmlonglet.="<div class=\"onglet_selected\" onclick=\"hide(this.id,'tab".$i."')\" id=\"on".$i."\"> &nbsp;".$onglet[$i]."&nbsp;</div>" ;
		}else{
		
		$tmphtmlonglet.="<div class=\"onglet\" onclick=\"hide(this.id,'tab".$i."')\" id=\"on".$i."\"> &nbsp;".$onglet[$i]."&nbsp;</div>" ;
	}
		$tmphtmltab.=" <div class=\"";
		if ($i==$selection) { 
					$tmphtmltab.="tab\" " ;
					 }else { $tmphtmltab.="hidetab\" " ;
				 }
				 				 
		 $tmphtmltab.="id=\"tab".$i."\" > ".$contenutab[$i]."</div> " ;
		 
		}
		
		$tmphtmlonglet.="</div> ";
		$tmphtmltab.="</div> " ;
	
	return $tmphtmlonglet." ".$tmphtmltab ;
	
	
	}
	
	
	
	
	
	//fonction réalisant un tableau html à partir d'un tableau de données.
	// $tableau  est une variable tableau à deux dimensions contenant les donnée à transformer en html.
	// $style est un tableau contenant deux chaine contenant la classe des lignes paires et impaires.
	// $styletab est le nom de la classe css appliquée à l'ensemble du tableau.
	
	function make_table ($tableau , $style, $styletab ) {
		
		$ligne = count($tableau) ;
		$col = count($tableau[0]);
		
		
		$html_tab = "<table class=\"".$styletab."\" >" ;
		
		
		
		for ($i=0; $i < $ligne ;$i++ ) {
			
			$html_tab .= "<tr class=\"" ;
			
			
			if ( $i%2 == 0 ) {
				
				$html_tab .= $style[0]."\" >" ;
				
				}else {
				
				$html_tab .= $style[1]."\" >" ;
				
			}
			
			for ($j=0; $j < $col ; $j++ ) {
				
				$html_tab .="<td >".$tableau[$i][$j]."</td>" ; 
				
				}
			
			$html_tab .= "</tr>" ;
			
		}
		 
		$html_tab .= "</table>" ;
		
		
		return $html_tab ;
		
		
		
		
	}
	
  function add_javascript ($Code) 
    {
    $this->JAVASCRIPT .= $Code ;
    }
	
  function add_css ($Css) 
    {
    $this->CSS .= "  <link rel=\"stylesheet\" href=\"$Css\" type=\"text/css\" media=\"screen\" >\n" ;
    }
	
  function add_js_file($File)
    {
    $this->JS_FILE .= "  <script language='JavaScript' src='$File' type='text/javascript'></script>\n";
    }


	function set_menu ($menupage) {
		
		$this->MENU = $menupage ;
			
		}
	
	
	
	function set_main ( $corpspage ) {
		
		
		$this->MAIN = $corpspage ;
 		
		
	}
	
	
	
	
	function set_bandeau ( $bandeaupage ) {
		
		
		$this->BANDEAU = $bandeauspage ;
 		
		
	}
	//création d'un tag html select
	// $id est une chaine de caractère contenant id du tag select.
	// $style est une chaine de caractère contenant la classe du style.
	//$options contient un tableau 
	//le tableau $param contient les paramètres du tag select size multiple 
	
	function make_select( $id, $multiple , $size , $options) {
	
	//$id  chaine valeur de l'attribut id du select
	// $multiple booleen permettant de définir les choix multiples
	// $size nombre de ligne d'option apparaissant dans le select
	// $option tableau à deux dimension contennant |la valeur| la valeur affichée| booleen pour savoir si celle-ci est selectionnée.
	
	$tmpselect = "<select id=\"".$id."\"  name=\"".$id."\" ";
	
	if ($multiple) { $tmpselect.= " multiple " ; }
	
	
	if( isset($size)){ $tmpselect.= "size=\"".$size."\"" ; }
	
	$tmpselect .= " >" ;
	for ($i=0; $i<count($options) ; $i++) {
	
	
		
		$tmpselect .= "<option value=\"".$options[$i][0]."\" " ;
		
		if ( $options[$i][2] ) { $tmpselect .= "selected " ; }
		
		$tmpselect .= "> ";
		
		$tmpselect .= $options[$i][1] ;
		
		$tmpselect .= " </option>" ;
		
	
	
		}
	
		
		$tmpselect .= "</select>" ; 
		
	return $tmpselect ;
		
	
		}

	
	//fonction incluant des object dans la page html.
	// la variable $type est une chaine qui définit le type d'objet ex: svg pdf.
	
	function make_object($type, $url,$param,$width,$height ) {
		
		if ($type === "pdf") {
		$tmpobject = "<object data=\"".$url."\" type=\"application/pdf\" width=\"".$width."\" height=\"".$height."\">" ;
		$tmpobject .="</object>" ;
		
		}
		
		if ($type ==="svg") {
			
			$tmpobject = "<object  type=\"image/svg+xml\" data=\"".$url."\" height=\"".$height."\" width=\"".$width."\">" ;
			$tmpobject .= "balise object non-reconnue" ;
			$tmpobject .= "</object>" ;
			
		}
		
		if ($type ==="swf") {
			
			$tmpobject = "<object type=\"application/x-shockwave-flash\" data=\"".$url."\" width=\"".$width."\" height=\"".$height."\">" ;
			$tmpobject .= "balise object non-reconnue" ;
			$tmpobject .= "</object>" ;
			
		}
		
		return $tmpobject ;
		
	}
	
	//fonction permettant de créer une image cliquable. 
	//$imgsrc chemin de l'image
	//$jscript chemin du script à exécuter
	
	function make_img_jslink ($imgsrc, $jscript) {
		
		if( $imgsrc != "" && $jscript != "" ) {
		$tmpimglink =" <img src=\"".$imgsrc."\" onClick=\"".$jscript."\" >" ;
		
		return $tmpimglink ;
		}
		
		return false  ;
		
	}
	
	//fonction permettant de créer une liste où chaque ligne peut être sélectionnée via une case à cocher.
	//Le premier champs du tableau $tabdata sera la valeur renvoyée par la checkbox du formulaire.
	//$style est un tableau qui contient le nom du style des ligne paire et impaire
	// $nomform est le nom du formulaire.
	// $typeform savoir si le formulaire affiche en mode modification ou en mode affichage valeur possible pour $typeform AFF ou MOD .
	// $action renseigne le script php qui sera apppelé pour traiter les données du formulaire
	// $method valeur possible POST ou GET
	// $textsubmit valeur du libellé du bouton submit du formulaire
	
	function create_sel_list ($tabdata,  $style, $nomform , $typeform, $action, $method, $textsubmit ) {
		
		//<td> <input type=checkbox id=id name=id > </td> <td>
		
		$tmptab="<table > <form id=\"".$nomform."\" name=\"".$nomform."\" accept-charset='".$this->CHARSET."'";
		
		
		$tmptab.= "action=\" ";
		
		$tmptab.=$action ;
		
		$tmptab.= "\" method=\"";
		
		if (strtoupper($method) == "GET" ) {
		$tmptab.="get" ;
		
		}else {
		
		$tmptab.="post" ;
		}
		
		$tmptab.= "\" >";
		
		$tmptab.= " <input type=\"hidden\" id=\"fname\" name=\"fname\" value=\"".$nomform."\" >  ";
		$tmptab.= " <input type=\"hidden\" id=\"nbline\" name=\"nbline\" value=\"".count($tabdata)."\" >  ";
		for ($i=0; $i<count($tabdata) ; $i++) {
			
			if($i%2==0) {
			
				$tmptab.="<tr class=\"".$style[0]."\" >";
			
			}else {
			
			
				$tmptab.="<tr class=\"".$style[1]."\" >";
			
			
			}
			
			for($j=0;$j<count($tabdata[$i]);$j++){
			
			
			if($i%2==0) {
			
			$tmptab.="<td class=".$style[0]." >";
			
			}else {
			
				$tmptab.="<td class=".$style[1]." >";
			
			}
			
			
			
			if ($j==0 ) {
					
					
					if ($typeform=="AFF"){
										$tmptab.="<input type=\"checkbox\"  id=\"".$nomform.$i."\" name=\"".$nomform.$i."\" value=\"".$tabdata[$i][$j]."\" >" ;
					
				
										}else {
											
											$tmptab.=" &nbsp; <input type=\"hidden\"  id=\"".$nomform.$i."\" name=\"".$nomform.$i."\" value=\"".$tabdata[$i][$j]."\" > &nbsp; &nbsp;" ;
											
										}
						}
			
			if ( $j>0 ) {
			
					if($typeform=="AFF"){
						$tmptab.=$tabdata[$i][$j] ;
					}else {
						$tmptab.="<input type=\"input\"  size=\"".strlen($tabdata[$i][$j])."\" id=\"".$nomform.$i."\" name=\"".$nomform.$i."\" value=\"".$tabdata[$i][$j]."\" >" ;
									
			
					}
					
				
			
			$tmptab.="</td>" ;
			
			}
		
		}
		
		
		$tmptab.="</tr>" ;
		
		if ($i==(count($tabdata)-1)) {
		
			if($i+1%2==0) {
			
				$tmptab.="<tr class=\"".$style[0]."\" >";
			
			}else {
			
			
				$tmptab.="<tr class=\"".$style[1]."\" >";
			
			
			}
			
			
			for ($k=0; $k < count($tabdata[0]); $k++) {
				

				if($i+1%2==0) {
			
					$tmptab.="<td class=".$style[0]." >";
			
					}else {
			
					$tmptab.="<td class=".$style[1]." >";
			
					}
					
					if($k==(count($tabdata[0])-1)){
						$tmptab.="&nbsp; <input type=\"submit\" value=\" ".$textsubmit."\" > &nbsp; " ;
					}else {
									
					$tmptab.="&nbsp;" ;
					}
									
					$tmptab.="</td>" ;
				
					}
			
			
			
			
			$tmptab.="</tr>";
			
		
		
		}



		}
	


	
	
	
	$tmptab.="</form> </table> ";
		return $tmptab ;
	
	}//Fin fonction Create_sel_list	
	
	
//fonction permettant de créer une liste où chaque ligne peut être sélectionnée via une case à cocher.
//Le premier champs du tableau $tabdata sera la valeur renvoyée par la checkbox du formulaire.
//$style est un tableau qui contient le nom du style des ligne paire et impaire
// $typelist savoir si la list affiche en mode modification ou en mode affichage valeur possible pour $typelist AFF ou MOD .
//$chkname donne le radical du nom des inputs qui sera complété par un incrément numérique commençant à 0

	function make_sel_list($tabdata,$style,$typelist,$chkname,$colnum) {
		
		if($colnum=='') $colnum=1 ;
		if($colnum==0) $colnum=1 ;
		
		$tmptab="<table >" ;
		
		for ($i=0;$i<(count($tabdata)) ;$i++) {
			
			
			if($i%$colnum==0 && $i!=0){
				$tmptab.="<tr class=\"".$style[($i%2)]."\" >";
			}
					
			for( $j=0 ;$j<count($tabdata[$i]);$j++){
				
				$tmptab.="<td class=\"".$style[($i%2)]."\" >";
				
				if($j==0 ){
					if($typelist == "AFF"){
					$tmptab.="<input type=\"checkbox\" id=\"".$chkname.$i."\" name=\"".$chkname.$i."\" value=\"".$tabdata[$i][$j]."\">" ;
				
					}else{
							$tmptab.=" &nbsp;&nbsp;&nbsp;&nbsp; ";
					}
				}
						
				if( $j>0 && $typelist=="AFF"){
					$tmptab.= $tabdata[$i][$j];
				}
				
				if($j>0 && $typelist=="MOD"){
					
					$tmptab.="<input type=\"text\" id=\"".$chkname.$i.$j."\" name=\"".$chkname.$i.$j."\" value=\"".$tabdata[$i][$j]."\">  " ;
				}	
			
				$tmptab.=" </td>";
				
					
			}
		if(($i%$colnum!=0 || $i!=0)&& ($i==count($tabdata)-1)){	
		$tmptab.="</tr>" ;
		}
			
		}
		
		$tmptab.=" </table>";
		
		return $tmptab ;
		
		
	}//fin fonction create_sel_list_noform 
	
	
	
	
}//fin d'objet htmlgui


?>
