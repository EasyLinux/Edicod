<?php
/**
 * Gestion de la configuration.
 *   Ce composant gère les paramètres stockés dans la base de données applicative.
 *
 * @package		Composants
 * @subpackage		Configure
 * @access		public
 * @version		1.2
 * @author              Serge NOEL
 * @todo		Prévoir un paramètre de type Dir
 * @todo 		Prévoir un paramètre de type Auth
 * @todo                Mettre à jour les paramètres en automatique
 * @todo                Prévoir initialisation sans config initiale
 * @todo		Permettre de gérer les paramètres en arbre (ex: connexion à la base -> User, pwd, host, ...)
 */

$Empty=0;

/**
 * Initialisation du composant
 *
 * @ignore
 */
function ContentInit($Db, $Html)
{
$Html->add_js_file("/js/ajax.js");
$Html->add_js_file("/js/php.js");
$Html->add_js_file("/js/prototype.js");
$Html->add_js_file("/js/effects.js");
$Html->add_js_file("/js/window.js");
$Html->add_js_file("/components/Configure/Configure.js");
$CfgScript = str_replace($_SERVER["DOCUMENT_ROOT"],"",__FILE__);


$Params = array(
  "Sql"     => "SELECT * FROM parameters WHERE type!='hidden' ORDER BY display;",
  "Name"    => "Configure",
  "Action"  => "#",
  "Method"  => "post",
  "Title"   => "&nbsp;Configuration",
  "Width"   => 505,
  "Height"  => 350,
  "ListW"   => 480,
  "ListH"   => 250,
  "FieldId" => "id",
  "Init_JS" => "",
  "Fields"  => array(
                    array("&nbsp;Id","id",40,40),
                    array("&nbsp;Variable","display",250,250),
                    array("&nbsp;Valeur","value",167,145)
                    ),
  "ButtonsLeft" => array(
                    array("/img/Configure/Configure.png","Editer","CfgEdit()")
                    ),
  "ButtonsRight" => array(
                    array("/img/Configure/Door.png","Quitter","CfgQuit()")
                    )
  );

$Content = "
<!-- Contenu - $CfgScript -->\n<div class=\"main\">\n";
$Content .= $Html->MakeHtmlList2($Db, $Params);
$Content .= "
<div style='color: black; font-weight: bold'>$XmlMsg</div>

<div id='CfgPopup' style='display: none'></div>
<div id='overlay_modal' class='overlay_bluelighting' />
</div>
</div>\n<!-- /Contenu -->\n\n";

return ($Content);
}

/**
 * Edition d'un paramètre : fonction appelée via Ajax
 *
 * @param		int		Identifiant du paramètre
 * @param		objet		Ligne de la table 'parameters'
 * @param               objet		Pointeur sur la base
 */
function EditParam($Id,$Obj, $Db)
{
//print_r($Obj);
$name  = $Obj->name;
$value = $Obj->value;
$description = $Obj->description;
$type = $Obj->type;


$HtType = "";
switch( $type )
  {
  case 'text':
  case 'int':
    $HtType = "<input type='text' class='fpPopInp2' name='value' id='value' value='$value' style='width: 180px' />\n";
    break;
  
  case 'bool':
    $HtType = "<input type='checkbox' class='fpPopInp2' name='value' id='value' value='$value' style='width: 180px' />\n";
    break;    
  
  case 'select':
    $Pars = explode("|",$Obj->params);
    $Sql = $Pars[2];
    $Db->Query($Sql);
    $Reps = $Db->loadArrayList();
    $HtType  = "<select class='fpPopInp2' name='value' id='value' style='width: 180px'>\n";
    foreach( $Reps as $Rep )
      {
      if( $value == $Rep[$Pars[0]] )
        $HtType .= "      <option value='".$Rep[$Pars[0]]."' selected='selected'>".$Rep[$Pars[1]]."</option>\n";
      else
        $HtType .= "      <option value='".$Rep[$Pars[0]]."'>".$Rep[$Pars[1]]."</option>\n";
      }
    $HtType .= "    </select>\n";
    break; 

  case 'ListSelect':
    $Pars = explode("|",$Obj->params);
    
    $HtType  = "<select class='fpPopInp2' name='value' id='value' style='width: 180px'>\n";
    foreach( $Pars as $Par )
      {
      $Sels = explode(":",$Par);
      if( $value == $Sels[0] )
        $HtType .= "      <option value='".$Sels[0]."' selected='selected'>".$Sels[1]."</option>\n";
      else
        $HtType .= "      <option value='".$Sels[0]."'>".$Sels[1]."</option>\n";
      }
    $HtType .= "    </select>\n";
    break; 
    
  case 'ReadOnly':
    $HtType = "<input type='text' class='fpPopInp2' name='value' id='value' value='$value' readonly='readonly' style='width: 180px' />\n";
    break;

  }

$Html = "  
<form method='post' action='#' id='CfgEdit' accept-charset='UTF-8'>
  &nbsp;<br />
  <input type='hidden' name='id' id='id' value='$Id' />
  <input type='hidden' id='type' value='$type' />
  <div class='fpPopDiv1' style='width: 100px;'>&nbsp;Nom</div>
  <div class='fpPopDiv2' style='width: 185px'>
    <input type='text' class='fpPopInp2Gray' name='label' id='label' value='$name' style='width: 180px' readonly='readonly'/>
  </div>
  <div class='fpPopDiv1' style='width: 100px;'>&nbsp;Valeur</div>
  <div class='fpPopDiv2' style='width: 185px'>
    $HtType
  </div>
  <fieldset>
    <legend>Description</legend>
    <div class='fpPopDiv2' style='width: 310px; height: 60px; overflow: auto'>
      $description
    </div>
  </fieldset>
  <div class='formButtons2' style='width:330px;'>
    <div class='formButtonsItemL' >
      <img src='/img/Configure/save.png' class='ImgButton' alt='Sauvegarder' title='Sauvegarder' onClick='CfgSave();' />
    </div>
    <div class='formButtonsItemR' >
      <img src='/img/Configure/cancel.png' class='ImgButton' alt='Abandon' title='Abandon' onClick='CfgAbort();' />
    </div>
  </div>
</form>
";
return $Html;

}


/**
 * Edition d'un paramètre de type Pop: fonction appelée via Ajax
 *
 * @param		int		Identifiant du paramètre
 * @param		objet		Ligne de la table 'parameters'
 * @param   objet		Pointeur sur la base
 *
function EditPop($Id,$Obj, $Db)
{
//print_r($Obj);
$Checked = "";
$Class = "fpPopInp2Gray";
$RdOnly = "readonly='readonly'";
if( $Obj["value"] == "Oui" )
  {
  $Checked = "checked='checked'";
  $Class = "fpPopInp2";
  $RdOnly = "";
  }
$description = $Obj["description"];
$type = $Obj["type"];

$Html = "  
<form method='post' action='#' id='CfgEdit' accept-charset='UTF-8'>
  &nbsp;<br />
  <input type='hidden' name='id' id='id' value='$Id' />
  <input type='hidden' id='type' value='$type' />
  <div class='fpPopDiv1' style='width: 150px;'>&nbsp;Utiliser bo&icirc;te pop</div>
  <div class='fpPopDiv2' style='width: 25px'>
    <input type='checkbox' class='fpPopInp2' name='Use' id='Use' $Checked onChange='CfgPopToggle(this.checked);' />
  </div>
  <fieldset>
    <legend>Param&egrave;tres</legend>
    <div class='fpPopDiv2' style='width: 310px; height: 95px; overflow: auto'>
      <div class='fpPopDiv1' style='width: 120px;'>&nbsp;Serveur</div>
      <div class='fpPopDiv2' style='width: 100px'>
        <input type='text' class='$Class' name='Srv' id='Srv' value='".$Obj["Srv"]["value"]."' $RdOnly/>
      </div>
      <div class='fpPopDiv1' style='width: 220px;'>$description</div>
<!--      <div class='fpPopDiv1' style='width: 120px;'>&nbsp;Utilisateur</div>
      <div class='fpPopDiv2' style='width: 100px'>
        <input type='text' class='$Class' name='Usr' id='Usr' value='".$Obj["Usr"]["value"]."' $RdOnly/>
      </div>
      <div class='fpPopDiv1' style='width: 120px;'>&nbsp;Mot de passe</div>
      <div class='fpPopDiv2' style='width: 100px'>
        <input type='text' class='$Class' name='Pwd' id='Pwd' value='".$Obj["Pwd"]["value"]."' $RdOnly/>
      </div> -->
    </div>
  </fieldset>
  <div class='formButtons2' style='width:330px;'>
    <div class='formButtonsItemL' >
      <img src='/img/Configure/save.png' class='ImgButton' alt='Sauvegarder' title='Sauvegarder' onClick='CfgSavePop();' />
    </div>
    <div class='formButtonsItemR' >
      <img src='/img/Configure/cancel.png' class='ImgButton' alt='Abandon' title='Abandon' onClick='CfgAbort();' />
    </div>
  </div>
</form>
";
return $Html;
}
*/
/* Partie Ajax */
$BaseURL = $_SERVER["DOCUMENT_ROOT"];
if( !class_exists("db") )
  require( "$BaseURL/inc/Db.Inc.php" );
@session_start();
@$Option = $_GET['Option'];

$Db = new db($_SESSION['Parameters']['SqlEngine'], $_SESSION['Parameters']['SqlSrv'], $_SESSION['Parameters']['SqlBase'], 
             $_SESSION['Parameters']['SqlUsr'] , $_SESSION['Parameters']['SqlPwd']);

switch( $Option )
  {

  case 'EditCfg':
    $id = $_GET['ID'];
    // Interroger la base de données
    $query  = "SELECT * FROM parameters ";
    $query .= "WHERE id=$id";
    $Db->Query($query);
    $Rep = $Db->loadObject();
    switch($Rep->type)
      {
/*      case 'Pop':
        $query  = "SELECT * FROM parameters WHERE name='PopServer';";
        $Db->Query($query);
        $Srv = $Db->loadArray();
        $query  = "SELECT * FROM parameters WHERE name='PopUser';";
        $Db->Query($query);
        $Usr = $Db->loadArray();
        $query  = "SELECT * FROM parameters WHERE name='PopPasswd';";
        $Db->Query($query);
        $Pwd = $Db->loadArray();
      
        $Objet = array("id" => $id,
                       "value" => $Rep->value,
                       "type"  => $Rep->type,
                       "description" => $Rep->description,
                       "Srv" => $Srv, "Usr" => $Usr, "Pwd" => $Pwd);
        echo EditPop($id,$Objet,$Db);
        break;*/
      
      default:
        echo EditParam($id,$Rep,$Db); 
        break;
      }
    $Db->Close();
    break;

  case 'SaveCfg':
    // Récupérer les données
    $id  = $_GET["id"];
    $Sql  = "UPDATE parameters SET value='".$_GET['value']."' WHERE id=$id";
    $Db->Query($Sql);
    echo "Donn&eacute;es mises &agrave; jour";
    $Db->Close(); 
    break;
    
/*  case 'SavePop':
    // Récupérer les données
    $On  = $_POST["On"];
    $Val = "Non";
    if( $On=="true" )
      $Val = "Oui";
    $Sql = "UPDATE parameters SET value='$Val' WHERE name='UsePop';";
    $Db->Query($Sql);
    $Sql = "UPDATE parameters SET value='".$_POST["Srv"]."' WHERE name='PopServer';";
    $Db->Query($Sql);
    $Sql = "UPDATE parameters SET value='".$_POST["Usr"]."' WHERE name='PopUser';";
    $Db->Query($Sql);
    $Sql = "UPDATE parameters SET value='".$_POST["Pwd"]."' WHERE name='PopPasswd';";
    $Db->Query($Sql);    
    echo "Donn&eacute;es mises &agrave; jour";
    $Db->Close(); 
    break; */

  case 'CfgQuit':
    // Vérifier les données saisies
    $Ok = true;
    if( !file_exists($_SESSION['Parameters']['AbsoluteDocuments']) )
      if( !mkdir($_SESSION['Parameters']['AbsoluteDocuments'],0777,true) )
        {
        $Ok = false;
        print "ERREUR: ne peut créer ".$_SESSION['Parameters']['AbsoluteDocuments'];
        }
    if( $Ok && !file_exists($_SESSION['Parameters']['AbsoluteDocuments'].$_SESSION['Parameters']['StorePath']) )
      if( !mkdir($_SESSION['Parameters']['AbsoluteDocuments'].$_SESSION['Parameters']['StorePath'],0777,true) )
        {
        $Ok = false;
        print "ERREUR: ne peut créer ".$_SESSION['Parameters']['AbsoluteDocuments'].$_SESSION['Parameters']['StorePath'];
        }
    if( $Ok && !file_exists($_SESSION['Parameters']['AbsoluteDocuments'].$_SESSION['Parameters']['InputPath']) )
      if( !mkdir($_SESSION['Parameters']['AbsoluteDocuments'].$_SESSION['Parameters']['InputPath'],0777,true) )
        {
        $Ok = false;
        print "ERREUR: ne peut créer ".$_SESSION['Parameters']['AbsoluteDocuments'].$_SESSION['Parameters']['InputPath'];
        }
    if( $Ok && !file_exists($_SESSION['Parameters']['AbsoluteDocuments'].$_SESSION['Parameters']['IncomingPath']) )
      if( !mkdir($_SESSION['Parameters']['AbsoluteDocuments'].$_SESSION['Parameters']['IncomingPath'],0777,true) )
        {
        $Ok = false;
        print "ERREUR: ne peut créer ".$_SESSION['Parameters']['AbsoluteDocuments'].$_SESSION['Parameters']['IncomingPath'];
        }
    if( $Ok && !file_exists($_SESSION['Parameters']['AbsoluteDocuments'].$_SESSION['Parameters']['BadDocuments']) )
      if( !mkdir($_SESSION['Parameters']['AbsoluteDocuments'].$_SESSION['Parameters']['BadDocuments'],0777,true) )
        {
        $Ok = false;
        print "ERREUR: ne peut créer ".$_SESSION['Parameters']['AbsoluteDocuments'].$_SESSION['Parameters']['BadDocuments'];
        }
    if( $Ok && !file_exists($_SESSION['Parameters']['AbsoluteDocuments'].$_SESSION['Parameters']['OutputPath']) )
      if( !mkdir($_SESSION['Parameters']['AbsoluteDocuments'].$_SESSION['Parameters']['OutputPath'],0777,true) )
        {
        $Ok = false;
        print "ERREUR: ne peut créer ".$_SESSION['Parameters']['AbsoluteDocuments'].$_SESSION['Parameters']['OutputPath'];
        }
    break;
    
  }


?>
