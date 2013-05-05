<?php
/**
 * Gestion des groupes. <b>OBSOLETE A SUPPRIMER</b>
 *   Ce fichier est appelé avant toute utilisation du programme
 *   il présente l'écran de connexion, valide l'identifiant et renvoi sur index.php en
 *   cas de succès
 * 
 * @author		Serge NOEL
 * @version             1.2
 * @package 		Composants
 * @subpackage		Paramètres  
 * @todo		Corriger initialisation compte
 */

$Empty=0;

/**
 * @ignore
 */
function ContentInit($Db, $Html)
{
$Html->add_css("css/UserAdmin.css");
$Html->add_js_file("/js/ajax.js");
$Html->add_js_file("/js/urldecode.js");
$Html->add_js_file("/components/GroupAdmin/GroupAdmin.js");
$Html->add_javascript( Javascript() );

// NB: le mot de passe par défaut est défini dans la configuration initiale

$ListUser = array(
  "Sql"     => "SELECT * FROM user, profiles WHERE user.pid=profiles.pid ORDER BY name;",
  "Name"    => "ListUser",
  "Action"  => "#",
  "Method"  => "post",
  "Title"   => "&nbsp;Utilisateurs",
  "Width"   => 655,
  "Height"  => 400,
  "ListW"   => 630,
  "ListH"   => 300,
  "FieldId" => "uid",
  "Init_JS" => "\nGetProfile();\n",
  "Fields"  => array(
                    array("&nbsp;Id","uid",40,40),
                    array("&nbsp;Actif","valid",45,45),
                    array("&nbsp;Login","login",90,90),
                    array("&nbsp;Nom","name",140,140),
                    array("&nbsp;Pr&eacute;nom","given_name",140,140),
                    array("&nbsp;Profil","description",150,130)
                    ),
  "Buttons" => array(
               array("/img/UserAdmin/add_user.png","Ajouter","Add();"),
               array("/img/UserAdmin/identity.png","Editer","Edit()"),
               array("/img/UserAdmin/delete_user.png","Supprimer","Delete();"),
               array("/img/UserAdmin/lock_user.png","Valider/D&eacute;valider","Lock();")),
  "Popup"   => array(
               "Sql"     => "SELECT * FROM user, profiles WHERE user.pid=profiles.pid",
               "Width"   => 420,
               "Height"	 => 300,
               "Left"    => 320,
               "Top"     => 140,
               "Name"    => "EditUser",
               "Action"  => "#",
               "Method"  => "post",
               "Title"   => "&nbsp;",
	       "FieldId" => "uid",
               "Tabs"    =>  array(
                                  "Width"   => 390,
                                  "Height"  => 200,
                                  "Content" => array (
                                                     array(
                                                          "Title"  => "&nbsp;Compte",
                                                          "LabelW" => 130,
                                                          "Fields" => array(
                                                                           array(160,"&nbsp;","uid","hidden","",0),
                                                                           array(160,"Login","login","text","",1),
                                                                           array(160,"Profil","pid","select","GetProfiles","SELECT * FROM profiles "),
                                                                           array(160,"Actif","valid","check","",0),
                                                                           array(160,"Mot de passe","password","MD5pwd","MD5pass",0),
                                                                           array(160,"&nbsp;","MD5pass","hidden","",0)
                                                                           )
                                                          ),
                                                     array(
                                                          "Title"  => "&nbsp;Individu",
                                                          "LabelW" => 130,
                                                          "Fields" => array(
                                                                           array(200,"&nbsp;","","none","",0),
                                                                           array(200,"Nom","name","text","",1),
                                                                           array(200,"Pr&eacute;nom","given_name","text","",0),
                                                                           array(200,"Email","email","mail","",1),
                                                                           array(200,"T&eacute;l&eacute;phone","phone","phone","00.00.00.00.00",0),
                                                                           array(200,"Adresse","num|address1","double","num",20,"int","address1",168,"text"),
                                                                           array(200,"&nbsp;","address2","text","",0),
                                                                           array(160,"CP / Ville","zip|city","double", "zip", 45, "text", "city",143, "text")
                                                                           )
                                                          ),
                                                     )
                                  ),
               "Buttons" => array(
                                 array("/img/UserAdmin/save.png","Sauvegarder","Save();",$Save),
                                 array("/img/UserAdmin/cancel.png","Abandon","Abort();",$Abort)
                                 )
               )

  );

$Content .= "\n<!-- Contenu - ". __FILE__ . " -->\n<div class=\"main\">\n";
$Content .= $Html->MakeHtmlList($Db, $ListUser);
$Content .= "</div>\n<!-- Contenu -->\n\n";
return ($Content);
}


/**
 *
 * @ignore
 */
function JavaScript()
{
$JS = "


";
return($JS);
}

/* Partie Ajax */
$Option = $_GET['Option'];
$BaseURL = $_SERVER["DOCUMENT_ROOT"];

switch( $Option )
  {
  case 'Lock':
    $id = $_GET['id'];
    $query = "SELECT * FROM user WHERE uid=$id";
    // Interroger la base de données
    require ("$BaseURL/inc/config/config.php");
    require( "$BaseURL/inc/db.inc.php" );
    $Db = new db($DBENGINE, $HOST, $BASE, $USER , $PASSWORD);
    $Db->db_query($query);
    $Rep = $Db->loadObject();
    if( $Rep->valid == 0 )
      $query = "UPDATE user SET valid=1 WHERE uid=$id";
    else
      $query = "UPDATE user SET valid=0 WHERE uid=$id";
    $Db->db_query($query);
    $Db->Close();
    break;

  case 'Delete':
    $id = $_GET['id'];
    // Interroger la base de données
    require ("$BaseURL/inc/config/config.php");
    require( "$BaseURL/inc/db.inc.php" );
    $Db = new db($DBENGINE, $HOST, $BASE, $USER , $PASSWORD);
    $query = "DELETE FROM user WHERE uid=$id";
    $Db->db_query($query);
    $Db->Close();
    break;

  case 'Read':
    $id = $_GET['ID'];
    // Interroger la base de données
    require ("$BaseURL/inc/config/config.php");
    require( "$BaseURL/inc/db.inc.php" );
    $Db = new db($DBENGINE, $HOST, $BASE, $USER , $PASSWORD);
    $query  = "SELECT * FROM user, profiles ";
    $query .= "WHERE user.uid=$id AND ";
    $query .= "user.pid=profiles.pid";
    $Db->db_query($query);
    $Reps = $Db->loadArray();
    foreach(array_keys($Reps) as $Rep)
      {  // pas la peine de perdre notre temps avec des champs vides
      if(strlen($Reps[$Rep]) > 0 )
        $String .= $Rep."=".urlencode($Reps[$Rep])."|";
      }
    $Db->Close();
    // Retirer le dernier |
    $String = substr($String,0,strlen($String)-1);
    print $String;
    break;

  case 'Save':
    // Récupérer les données
    $uid  = $_GET["uid"];
    if( $uid == -1 )
      $Sql = "INSERT INTO user SET ";
    else
      $Sql  = "UPDATE user SET ";
    foreach( array_keys($_GET) as $Key )
      {
      if( !($Key == "Option" || $Key == "uid") )
        $Sql .= "$Key='".urldecode($_GET[$Key])."', ";
      }
    $Sql = substr($Sql,0,strlen($Sql)-2);
    if( $uid != -1 )
      $Sql .= " WHERE uid=".$_GET["uid"]." ;";

    require ("$BaseURL/inc/config/config.php");
    require( "$BaseURL/inc/db.inc.php" );
    $Db = new db($DBENGINE, $HOST, $BASE, $USER , $PASSWORD);
    $Db->db_query($Sql);
    print "Donn&eacute;es mises &agrave; jour";
    $Db->Close();
    break;

  case 'GetProfiles':
    // Interroger la base de données
    $String="";
    require ("$BaseURL/inc/config/config.php");
    require( "$BaseURL/inc/db.inc.php" );
    $Db = new db($DBENGINE, $HOST, $BASE, $USER , $PASSWORD);
    $query  = "SELECT * FROM profiles ";
    $Db->db_query($query);
    $Reps = $Db->loadObjectList();
    foreach($Reps as $Rep)
      $String .= $Rep->pid."=".$Rep->description."|";
    $Db->Close();
    // Retirer le dernier |
    $String = substr($String,0,strlen($String)-1);
    print $String;
    break;

  }

?>
