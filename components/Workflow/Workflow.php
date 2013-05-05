<?php
//include_once("/components/FrontPage/FrontPageDb.php");
//include_once("FrontPageDb.php");
/**
 * Gestion du workflow
 *
 * @package		Composants
 * @subpackage		Workflow
 * @access		public
 * @version		1.2
 * @author              Serge NOEL
 *
 * @todo 		bug : quand il reste une seule étape ne peut la sélectionner, on doit sortir/rentrer pour le faire
 * @todo		ajouter gestion du groupe
 * @todo		interdire suppression si utilisé
 * @todo 		pour pouvoir gérer le type d'action, il faut utiliser col avec un masque binaire à 7, puis le reste (répondre, ...)- FronpageDb
 * @todo		ajout automatique de l'utilisateur/groupe dans l'affichage
 */

/**
 * Fonction appellée par index.php pour afficher le composant
 *
 * @ignore
 */
function ContentInit($Db, $Html)
{
	//$Html->add_css("/css/default.css");
	//$Html->add_css("/css/lighting.css");

	$Html->add_js_file("/js/prototype.js");
	$Html->add_js_file("/js/effects.js");
	$Html->add_js_file("/js/window.js");
	$Html->add_js_file("/js/ajax.js");
	$Html->add_js_file("/js/php.js");
	$Html->add_js_file("/js/calpopup.js");
	$Html->add_js_file("/js/dtree.js");
	$Html->add_js_file("/components/Workflow/Workflow.js");

	$Workflows = array(
  "Sql"     => "SELECT * FROM workflow ORDER BY name;",
  "Name"    => "Workflows",
  "Action"  => "#",
  "Method"  => "post",
  "Title"   => "&nbsp;Parcours du courrier (Workflow)",
  "Width"   => 580,
  "Height"  => 300,
  "ListW"   => 553,
  "ListH"   => 200,
  "FieldId" => "wid",
  "Init_JS" => "",
  "Fields"  => array(
	array("&nbsp;Id","wid",40,40),
	array("&nbsp;Nom","name",180,180),
	array("&nbsp;Description","description",310,290)
	),
  "ButtonsLeft" => array(
	array("/img/Workflow/WorkflowAdd.png","Ajouter","Workflow_Add();"),
	array("/img/Workflow/WorkflowEdit.png","Editer","Workflow_Edit();"),
	array("/img/Workflow/WorkflowDel.png","Supprimer","Workflow_Delete();")
	),
  "ButtonsRight" => array(
	array("/img/Workflow/Door.png","Quitter","Workflow_Quit();")
	)
	);

	$HTML = "
<!-- Workflow -->
<div class='main'>\n";
	$HTML .= $Html->MakeHtmlList2($Db, $Workflows);
	$HTML .= "
<div id='overlay_modal' class='overlay_bluelighting' />
</div>
</div>
<!-- /Workflow -->
\n\n";

	return $HTML;
}

/**
 * Fonction appelée en Ajax : édite un workflow
 *
 * @param		array		Enregistrement de la table Groups
 * @param               objet		Base de données
 */
function WorkflowEdit($Db, $Rep)
{
	$Wid     = $Rep['wid'];
	$Fid     = $Rep['fid'];
	$Name    = $Rep['name'];
	$Comment = $Rep['description'];
	$Respond = $Rep['respondbefore']; 
	$MyGrps = array();

	$Sql = "SELECT * FROM w_grp WHERE wid=$Wid";
	$Db->Query($Sql);
	$MyGrpss = $Db->loadArrayList();
	foreach($MyGrpss as $TheGrp)
	$MyGrps[]=$TheGrp["gid"];
	$Groupes = "";
	$MemberOf = "";
	$Sql = "SELECT gid,name FROM groups";
	$Db->Query($Sql);
	$Grps = $Db->loadArrayList();
	foreach($Grps as $Grp)
	{
		if( in_array($Grp["gid"],$MyGrps) )
		$MemberOf .= "           <option value='".$Grp["gid"]."'>".$Grp["name"]."</option>\n";
		else
		$Groupes .= "            <option value='".$Grp["gid"]."'>".$Grp["name"]."</option>\n";
	}

  // Dossier virtuel
  if( empty($Fid) )
    $sFolder = "";
  else
    {
    $Parent = $Fid;
    $Msg = '';
    while( $Parent )
      {
      $Sql = "SELECT * FROM folders WHERE fid=$Parent ;";
      $Db->Query($Sql);
      $Rep2 = $Db->loadObject();
      $Parent = $Rep2->parent;
      $Msg = $Rep2->label . "/" . $Msg;
      }
    $sFolder = "/".$Msg;
	  $sFolder = substr($sFolder,0,-1);
	  if( strlen($sFolder) > 30 )
	    {
	    $Begin = substr($sFolder,0,stripos($sFolder,"/",1)+1);
	    $End   = substr($sFolder,strrpos($sFolder,"/",-1));
	    $sFolder = $Begin . "..." . $End;
	    }

    }

	$Html = "
<form method='post' action='#' id='GrpEdit' accept-charset='iso-8859-15'>
  &nbsp;<br />
  <input type='hidden' name='wid' id='wid' value='$Wid' >
  <input type='hidden' name='fid' id='fid' value='$Fid' >
  <div class='formPopupLine' style='width: 98%'>
    <span class='formMargin'>&nbsp;</span>
    <span class='formTabTitleOn' id='TabT1' onClick='MyTab(1);'>&nbsp;Workflow</span>
<!--    <span class='formTabTitleOff' id='TabT2' onClick='MyTab(2);'>&nbsp;Groupes</span> -->
  </div>
  <div class='formTabOn' id='Tab1' style='width: 440px; height: 380px; margin-left: 10px' >
    <div style='width: 98%'>&nbsp;</div>
    <div class='fpPopDiv1' style='width: 120px;'>&nbsp;Nom</div>
    <div class='fpPopDiv2' style='width: 300px'>
      <input type='text' class='fpPopInp2' name='name' id='name' value='$Name' style='width: 180px' />
    </div>
    <div class='fpPopDiv1' style='width: 120px;'>&nbsp;Commentaire</div>
    <div class='fpPopDiv2' style='width: 300px'>
      <input type='text' class='fpPopInp2' name='comment' id='comment' value='$Comment' style='width: 180px' />
    </div>
    <div class='fpPopDiv1' style='width: 120px;'>&nbsp;D&eacute;lai r&eacute;ponse</div>
    <div class='fpPopDiv2' style='width: 300px'>
      <input type='text' class='fpPopInp2' name='RespondBefore' id='RespondBefore' value='$Respond' style='width: 50px' />&nbsp;en jours.
    </div>
    <div class='fpPopDiv1' style='width: 120px;'>&nbsp;Dossier virtuel</div>
    <div class='fpPopDiv2' style='width: 300px'>
      <img src='/img/FrontPage/Folder.png' alt='Stockage disque' title='Stockage disque' class='ImgButton' onClick='DisplayDocFolder();' />
      <span class='fpPopInp2Gray' style='width: 260px; height: 16px' type='text' name='List' id='List'>$sFolder</span>
    </div>
    <div style='border: 1px dashed gray; width: 320px; height: 220px; overflow-y: scroll; float: left;margin-left: 5px'>\n";
	//  background-color: #AFCBEF;

	// Parcourir les etapes
	foreach( $Rep["wf_steps"] as $Step )
	{
		$StepId = $Step["wfsid"];
		$Id = "S".$StepId;
		$Html .= "     <div style='width: 300px; font-weight: bold; font-size: 20px; cursor: pointer;' onclick='Select(\"$Id\");' id='$Id'>
       <img src='/img/Workflow/fleche-bleu.png' />&nbsp;".$Step["description"]."
     </div>\n";
		foreach( $Rep["wf_details"] as $Detail )
		{  // On recherche les détails de l'étape
			if( $Detail["wfsid"] == $StepId )
			{ // Le detail appartient à cette étape
				$Star = "";
				if( $Detail["actor"] == 1 )
				$Star=" (*)";
				$Id = "D".$Detail["wdid"];
				switch( $Detail["col"] )
				{
					case 0:
						$Html .= "     <div style='width: 300px; cursor: pointer;' onclick='Select(\"$Id\");' id='$Id'>
       <img src='/img/Workflow/vide.png' />&nbsp;<img src='/img/Workflow/dispatch.png' />&nbsp;".$Detail["MyDesc"]."$Star
     </div>\n";
						break;
					case 1:
						$Html .= "     <div style='width: 300px; cursor: pointer;' onclick='Select(\"$Id\");' id='$Id'>
       <img src='/img/Workflow/vide.png' />&nbsp;<img src='/img/Workflow/display.png' />&nbsp;".$Detail["MyDesc"]."$Star
     </div>\n";
						break;
					case 2:
						$Html .= "     <div style='width: 300px; cursor: pointer;' onclick='Select(\"$Id\");' id='$Id'>
       <img src='/img/Workflow/vide.png' />&nbsp;<img src='/img/Workflow/valid.png' />&nbsp;".$Detail["MyDesc"]."$Star
     </div>\n";
						break;
					case 3:
						$Html .= "     <div style='width: 300px; cursor: pointer;' onclick='Select(\"$Id\");' id='$Id'>
       <img src='/img/Workflow/vide.png' />&nbsp;<img src='/img/Workflow/classified.png' />&nbsp;".$Detail["MyDesc"]."$Star
     </div>\n";
						break;
				}
			}
		}
	}

	$Html .= "
    </div>
    
    <div style='width: 80px; float: right; border: solid 1px #AFCBEF; margin-right: 5px'>  
      <div class='formButtonsItem'>
        <img src='/img/Workflow/fleche-bleu.png' class='Img' /> 
        <div style='float:right;padding : 10px 0 0 2px;'> <i><b><u>Etape</u></b></i> </div>
        <!--<img src='/img/Workflow/vide32.png' class='Img'  />-->
      </div>
      <div>
        <img src='/img/Workflow/edit_add.png' class='ImgButtonBar' alt='Ajouter une &eacute;tape' title='Ajouter une &eacute;tape' onClick='AddStep();' />
        <img src='/img/Workflow/vide4-16.png' class='Img'  />
        <img src='/img/Workflow/edit_remove.png' class='ImgButtonBar' alt='Supprimer une &eacute;tape' title='Supprimer une &eacute;tape' onClick='DelStep();' />
        <img src='/img/Workflow/vide4-16.png' class='Img'  />
        <img src='/img/Workflow/crayon.png' class='ImgButtonBar' alt='Modifier une &eacute;tape' title='Modifier une &eacute;tape' onClick='ModStep();' />
      </div>
      <div>
        <img src='/img/Workflow/vide8-16.png' class='Img'  />
        <img src='/img/Workflow/up.png' class='ImgButtonBar' alt='Monter' title='Monter' onClick='UpStep();' />
        <img src='/img/Workflow/vide8-16.png' class='Img'  />
        <img src='/img/Workflow/down.png' class='ImgButtonBar' alt='Descendre' title='Descendre' onClick='DownStep();' />
      </div>
    </div>
    
    <div style='width: 70px; float: right;'>
      <div >
        <img src='/img/Workflow/vide32.png' class='Img'  />
      </div>
    </div>
    <div style='width: 80px; float: right; border: solid 1px #AFCBEF; margin-right: 5px'>
      <div class='formButtonsItem' >
        <img src='/img/Workflow/fleche-verte.png' class='Img' />
        <img src='/img/Workflow/step.png' class='Img' />
        <div style='float:right;padding : 2px 0 0 2px;'> <i><b><u>Action</u></b></i> </div>
        <!--<img src='/img/Workflow/vide32-16.png' class='Img'  />-->
      </div>
      <div >
        <img src='/img/Workflow/edit_add.png' class='ImgButtonBar' alt='Ajouter une action' title='Ajouter une action' onClick='AddDetail();' />
        <img src='/img/Workflow/vide4-16.png' class='Img'  />
        <img src='/img/Workflow/edit_remove.png' class='ImgButtonBar' alt='Supprimer une action' title='Supprimer une action' onClick='DelDetail();' />
        <img src='/img/Workflow/vide4-16.png' class='Img'  />
        <img src='/img/Workflow/crayon.png' class='ImgButtonBar' alt='Modifier une action' title='Modifier une action' onClick='ModDetail();' />
      </div>
    </div>
  </div>
<!--  
  <div class='formTabOff' id='Tab2' style='width: 440px; height: 380px; margin-left: 10px;' >
    <div class='formPopupLine' style='width: 98%'>&nbsp;</div>
    <div class='formPopupLine'>
        <span class='formPopupL' style='width: 160px; height: 300px'>Li&eacute; &agrave;<br />
          <select id='memberof' name='memberof' style='width: 155px; height: 280px' size=10 multiple >\n$MemberOf</select>
        </span>
        <span class='formPopupL' style='width: 30px; height: 300px'>
          <img src='/img/Workflow/move.png' />
          <img src='/img/Workflow/back.png' class='ImgButton' onClick='MoveAdd();' />
          <img src='/img/Workflow/move2.png' />
          <img src='/img/Workflow/forward.png' class='ImgButton' onClick='MoveDel();' />
        </span>
        <span class='formPopupL' style='width: 160px; height: 300px'>Groupes<br />
          <select id='groups' name='groups' style='width: 155px; height: 280px' size=10 multiple >\n$Groupes</select>
        </span>
    </div> 
  </div>
-->

  <div class='formButtons2' style='width:440px' >
    <div class='formButtonsItemL' >
      <img src='/img/Workflow/Save.png' class='ImgButtonBar' alt='Sauvegarder' title='Sauvegarder' onClick='Workflow_Save();' />
    </div>
    <div class='formButtonsItemR' >
      <img src='/img/Workflow/Door.png' class='ImgButtonBar' alt='Abandon' title='Abandon' onClick='Workflow_Abort();' />
    </div>
  </div>
</form>
";
	return $Html;
}

function StepEdit($Db,$SId, $Action)
{
	$BeforeId = 1;
	$Description = "";
	if( substr($SId,0,1) != "S" )
	$Id = -1;
	else
	{
		$Id  = intval(substr($SId,1));
		$Sql = "SELECT * FROM wf_steps WHERE wfsid=$Id";
		$Db->Query($Sql);
		$Rep = $Db->loadArray();
		$BeforeId = $Rep["myorder"];
		$Description = $Rep["description"];
	}

	$Html = "
<form method='post' action='#' id='AddStep' accept-charset='iso-8859-15'>
  &nbsp;<br />
  <input type='hidden' name='Id'       id='Id'       value='$Id' />
  <input type='hidden' name='BeforeId' id='BeforeId' value='$BeforeId' />
  <input type='hidden' name='Action'   id='Action'   value='$Action' />
  <div class='fpPopDiv1' style='width: 100px;'>&nbsp;Description</div>
  <div class='fpPopDiv2' style='width: 200px'>
    <input type='text' class='fpPopInp2' name='name' id='Description' value='$Description' style='width: 180px' />
  </div>
  <div class='formButtons'>
    <div class='formButtonsItem' style='width: 48%; margin-left: 10px' >
      <img src='/img/Workflow/Save.png' class='ImgButtonBar' alt='Sauvegarder' title='Sauvegarder' onClick='Step_Save();' />
    </div>
    
    <div class='formButtonsItem' style='width: 48%' >
      <img src='/img/Workflow/cancel.png' class='ImgButtonBar' alt='Abandon' title='Abandon' onClick='Step_Abort();' />
    </div>
  </div>
</form>\n";
	return $Html;
}

/*
 *
 * @todo        lorsque l'on saisi une action, on met à jour la description de l'étape en ajoutant le login
 * @todo        de l'acteur responsable ou le nom de groupe entre parenthèse.
 * @todo		Exemple pour un nom d'étape avec une action ayant pour user ALISON Denis: Etape 1 (da)
 */
function updateNameStep($Db, $Guid, $Actor, $wfsid) {
	$id = substr($Guid,1);
	/*on veut savoir si c'est un group ou un user*/
	$type = substr($Guid,0, 1);
	if($Actor == 1) {
		if($type == 'U') {  // user
			$Sql2 = "SELECT * FROM user WHERE uid=$id ;";
			$Db->Query($Sql2);
			$Row = $Db->loadObject();
			$login = $Row->login;

			$Sql2 = "SELECT * FROM wf_steps WHERE wfsid=$wfsid ;";
			$Db->Query($Sql2);
			$Row = $Db->loadObject();
			$description = $Row->description;

			$new_description = $description." (".$login.")";

			$Sql2 = "UPDATE wf_steps SET description='$new_description' WHERE wfsid=$wfsid;";
			$Db->Query($Sql2);
		}
		else {	// groups
			$Sql2 = "SELECT * FROM groups WHERE gid=$id ;";
			$Db->Query($Sql2);
			$Row = $Db->loadObject();
			$login = $Row->name;

			$Sql2 = "SELECT * FROM wf_steps WHERE wfsid=$wfsid ;";
			$Db->Query($Sql2);
			$Row = $Db->loadObject();
			$description = $Row->description;

			$new_description = $description." (".$login.")";

			$Sql2 = "UPDATE wf_steps SET description='$new_description' WHERE wfsid=$wfsid;";
			$Db->Query($Sql2);
		}
	}
}

/*
 *
 * @todo        Ajouter mise en gris pour Acteur selon cas
 * @todo        Remplir automatiquement description en fonction du choix GUID (Javascript: SetDescription)
 */
function DetailEdit($Db,$SId, $Action)
{
	require ("../../inc/User.Inc.php");
	$Usr = new user($Db,"");
	$Guid="";
	$BeforeId = 1;
	$Description = "";
	$Guid = "";
	if( substr($SId,0,1) != "D" )
	$Id = -1;
	else
	{
		$Id  = intval(substr($SId,1));
		$Sql = "SELECT * FROM wf_details WHERE wdid=$Id";
		$Db->Query($Sql);
		$Rep = $Db->loadArray();
		$BeforeId = $Rep["myorder"];
		$Description = $Rep["description"];
		$Guid = $Rep["guid"];
		if( $Rep["validation"] == 1 )
		$Valid = "checked='checked'";
		if( $Rep["actor"] == 1 )
		$Actor = "checked='checked'";
	}

	$Html = "
<form method='post' action='#' id='AddStep' accept-charset='iso-8859-15'>
  <div style='width: 375px; height: 15px'></div>
<!--    Id: $SId($Id) - BeforeId : $BeforeId - Action : $Action - Guid : $guid - ".$Rep['col']."&nbsp;<br />  -->
  <input type='hidden' name='Id'       id='Id'       value='$Id' />
  <input type='hidden' name='SId'      id='SId'      value='$SId' />
  <input type='hidden' name='BeforeId' id='BeforeId' value='$BeforeId' />
  <input type='hidden' name='Action'   id='Action'   value='$Action' />
  <div style='width: 375px;height: 25px'>
    <div style='width: 140px; float: left'>&nbsp;Description</div>
    <div style='width: 182px; float: left'>
      <input type='text' class='fpPopInp2' name='name' id='Description' value='$Description' style='width: 180px' />
    </div> 
  </div>
  <div style='width: 375px;height: 25px'>
    <div style='width: 140px;float: left'>&nbsp;Groupe/Utilisateur</div>
    <div style='width: 182px;float: left'>
      <select type='select' class='fpPopInp2' name='Guid' id='Guid' style='width: 180px' onChange='SetDescription();'>";
	$Html .= $Usr->GetGuidOption("      ",$Guid);
	$Chk[0] = $Chk[1] = $Chk[2] = $Chk[3] = "";
	$Chk[$Rep['col']] = "checked='checked'";

	$Html .= "      </select>
    </div>
  </div>
  <div style='width: 375px;height: 100px'>
    <fieldset style='width: 360px;'>
      <legend>Type</legend> 
        <table border='0' width='100%'>
          <tr>
            <td><input type='radio' name='Col' value='dispatch' "   .$Chk[0]. " >A affecter</td>
            <td><input type='radio' name='Col' value='input' "      .$Chk[1]. " >Pour information</td>
          </tr>
          <tr>
            <td><input type='radio' name='Col' value='waiting' "    .$Chk[2]. " >A traiter</td>
            <td><input type='radio' name='Col' value='classified' " .$Chk[3]. " >Terminé</td>
          </tr>
        </table>  
    </fieldset> 
    <input type='checkbox' name='Actor' id='actor' $Actor>Acteur responsable
  </div>
  <div style='width: 375px'>
    <div class='formButtonsItem' style='width: 50px; margin-left: 100px' >
      <img src='/img/Workflow/Save.png' class='ImgButtonBar' alt='Sauvegarder' title='Sauvegarder' onClick='Detail_Save();' />
    </div>
    <div class='formButtonsItem' style='width: 50px; margin-left: 100px' >
      <img src='/img/Workflow/cancel.png' class='ImgButtonBar' alt='Abandon' title='Abandon' onClick='Detail_Abort();' />
    </div>
  </div>
</form>\n";
	return $Html;
}

function DisplayWorkflows($Db, $txtWorkflow, $inputWsid)
{
$Sql = "SELECT * FROM workflow ORDER BY name;";
$Db->Query($Sql);
$Rows = $Db->loadObjectList();
$Html = "
<form action='#' name='Workflows'>
  <select size='10' name='workflow' id='workflow' style='width: 300px; height: 290px; margin-top: 10px; margin-left: 10px'>\n";
foreach($Rows as $Row)
	$Html .= "    <option value='". $Row->wid ."'>". $Row->name ."</option>\n";

$Html .= "  </select>
</forms>
<div class='formButtons'>
  <span class='formButtonsItem' style='margin-left: 20px' >
   <img src='/img/Workflow/Ok.png' class='ImgButtonBar' alt='Choisir' title='Choisir' onClick='SelectWorkflow(\"$txtWorkflow\", \"$inputWsid\");' />
  </span>
  <span class='formButtonsItem' style='margin-left: 220px' >
    <img src='/img/Workflow/Door.png' class='ImgButtonBar' alt='Abandon' title='Abandon' onClick='QuitWorkflow();' />
  </span>
</div>
";
return $Html;
}

function ListWorkflows($Db)
{
$Sql = "SELECT * FROM workflow ORDER BY name;";
$Db->Query($Sql);
$Rows = $Db->loadObjectList();
$Html = "
<form action='#' name='Workflows'>
  <select size='10' name='workflow' id='workflow' onChange='SetWorkflow(this.value);' style='width: 240px; height: 240px; margin-top: 10px; margin-left: 10px'>\n";
foreach($Rows as $Row)
	$Html .= "    <option value='". $Row->wid ."'>". $Row->name ."</option>\n";

$Html .= "  </select>
</forms>
<div class='formButtons'>
  <span class='formButtonsItem' style='margin-left: 20px' >
   <img src='/img/Workflow/Ok.png' class='ImgButtonBar' alt='Choisir' title='Choisir' onClick='GetWorkflow();' />
  </span> 
  <span class='formButtonsItem' style='margin-left: 168px' >
    <img src='/img/Workflow/Door.png' class='ImgButtonBar' alt='Abandon' title='Abandon' onClick='QuitWorkflow();' />
  </span>
</div>
";
return $Html;
}


/* Partie Ajax */
session_start();
$Option = $_GET['Option'];
if( empty($Option) )
$Option = $_POST['Option'];
$BaseURL = $_SERVER["DOCUMENT_ROOT"];
require_once("$BaseURL/inc/Db.Inc.php");
require_once("$BaseURL/inc/lib.inc.php");

$Db = new db($_SESSION['Parameters']['SqlEngine'], $_SESSION['Parameters']['SqlSrv'], $_SESSION['Parameters']['SqlBase'],
$_SESSION['Parameters']['SqlUsr'] , $_SESSION['Parameters']['SqlPwd']);

switch( $Option )
{
	case 'WorkflowEdit':

		$Id = $_GET['Id'];
		if( $Id != -1 )
		{
			$Sql = "SELECT * FROM workflow WHERE wid=$Id ;";
			$Db->Query($Sql);
			$Rep = $Db->loadArray();
			$Sql = "SELECT * FROM wf_steps WHERE wid=$Id ORDER BY myorder;";
			$Db->Query($Sql);
			$Rep["wf_steps"] = $Db->loadArrayList();
			$Sql =  "SELECT *,wf_details.description AS MyDesc FROM wf_details,wf_steps ";
			$Sql .= "WHERE wf_details.wfsid=wf_steps.wfsid AND wf_steps.wid=$Id ORDER BY wf_details.myorder;";
			$Db->Query($Sql);
			$Rep["wf_details"] = $Db->loadArrayList();
		}
		else
		  $Rep = array("wid"=>-1,"name"=>"","description"=>"","wf_steps"=>array(),"wf_details"=>array(), "Fid" => 0 );
		echo WorkflowEdit($Db, $Rep);
		$Db->Close();
		break;

	case 'SaveWorkflow':
		if( $_GET["Wid"] == "-1" )
		  {
		  $Sql  = "INSERT INTO workflow SET name='". urldecode($_GET["Name"]) ."', description='". urldecode($_GET["Comment"]) ;
		  $Sql .= "', respondbefore=".intval(urldecode($_GET["RespondBefore"])).", fid=". $_GET["Fid"] ." ;";
		  }
		else
		  {
		  $Sql  = "UPDATE workflow SET name='". urldecode($_GET["Name"]) ."', description='". urldecode($_GET["Comment"]);
		  $Sql .= "', respondbefore=".intval(urldecode($_GET["RespondBefore"])).", fid=". $_GET["Fid"] ."  WHERE wid=". $_GET["Wid"] .";";
		  }
		$Db->Query($Sql);
		echo $Db->GetLastId();
		break;

	case 'GetSaveWid':
		//enregistrement du workflow
			
		//TEST SI NOM EXISTE DEJA
		//initialisation variable
		$NameExist = false;
			
		$Sql = "SELECT name from workflow;";
		$Db->Query($Sql);
		$Rows = $Db->loadObjectList();
		foreach($Rows as $Row) {
			if($_POST["name"] == $Row->name) {
				$NameExist = true;
			}
		}
			
		if($NameExist == false) {
			$Sql = "INSERT INTO workflow SET name='".urldecode($_POST["name"])."', description='".urldecode($_POST["comment"])."' ;";
			$Db->Query($Sql);
		}
		else {
			echo 'Le nom de workflow éxiste déjà !';
		}
			
		//$Sql = "INSERT INTO workflow SET name='".urldecode($_POST["name"])."', description='".urldecode($_POST["comment"])."' ;";
		//$Db->Query($Sql);
		print $Db->GetLastId();

		$Db->Close();
		break;

	case 'WorkflowDelete':
		$Id = $_GET['Wid'];
		$Sql = "DELETE FROM workflow WHERE wid=$Id;";
		$Db->Query($Sql);
		$Sql = "DELETE FROM wf_steps WHERE wid=$Id;";
		$Db->Query($Sql);
		$Sql = "DELETE FROM wf_details WHERE wid=$Id;";
		$Db->Query($Sql);
		$Db->Close();
		break;

	case 'AddStep':
		print StepEdit($Db,$_GET["SelectedId"],"Add");
		break;

	case 'ModStep':
		print StepEdit($Db,$_GET["SelectedId"],"Mod");
		break;

	case 'SaveStep':  // /components/Workflow/Workflow.php?Option=SaveStep&Id=-1&Before=0&Description=coucou&Wid=3
		if( $_GET["Action"] == "Add" )
		{  // Ajout d'une etape
			/* *** ANCIENNE VERSION ***
			//Il faut ré-organiser les données
			$Sql = "UPDATE wf_steps SET myorder=myorder+1 WHERE myorder > ".($_GET["Before"]-1)." AND wid=".$_GET["Wid"].";";
			$Db->Query($Sql);
			$Sql = "INSERT INTO wf_steps SET wid=".$_GET["Wid"].", description='".urldecode($_GET["Description"])."', myorder=($OrderMaxStep+1); ";
			*/

			//Recherche du numéro d'ordre maximum d'une étape
			$Sql = "SELECT * FROM wf_steps WHERE wid=".$_GET["Wid"]." ORDER BY myorder DESC LIMIT 1;";
			$Db->Query($Sql);
			$Row = $Db->loadObject();
			$OrderMaxStep = $Row->myorder;

			$Sql = "INSERT INTO wf_steps SET wid=".$_GET["Wid"].", description='".urldecode($_GET["Description"])."', myorder=($OrderMaxStep+1); ";
		}
		else
		$Sql = "UPDATE wf_steps SET description='".urldecode($_GET["Description"])."' WHERE wfsid=".$_GET["Id"]." ;"; // OK
		$Db->Query($Sql);
		$Db->Close();
		break;

	case 'DelStep':  // /components/Workflow/Workflow.php?Option=DelStep&SelectedId=S3
		$Wfsid = substr($_GET["SelectedId"],1);
		$Sql = "DELETE FROM wf_details WHERE wfsid=$Wfsid;";
		$Db->Query($Sql);
		$Sql = "DELETE FROM wf_steps WHERE wfsid=$Wfsid ;";
		$Db->Query($Sql);
		$Db->Close();
		break;

	case 'UpStep':
		/* ***** ANCIENNE VERSION *****
		 // Lire le num d'ordre de l'enregistrement considéré
		 $Wfsid = substr($_GET["SelectedId"],1);
		 $Sql = "SELECT * FROM wf_steps WHERE wfsid=$Wfsid";
		 $Db->Query($Sql);
		 $Rep = $Db->loadArray();
		 $OldOrder = $Rep["myorder"];
		 if( $OldOrder==1 )
		 break;
		 $NewOrder = $OldOrder -1;
		 //print "On passe de $OldOrder a $NewOrder - Id : $Wfsid \n";
		 $Sql = "UPDATE wf_steps SET myorder=myorder+1 WHERE myorder >= $NewOrder AND wid=".$Rep["wid"].";";
		 //print "$Sql";
		 $Db->Query($Sql);
		 $Sql = "UPDATE wf_steps SET myorder=$NewOrder WHERE wfsid=$Wfsid;";
		 //print "$Sql";
		 $Db->Query($Sql);
		 */
			
		//lire le num d'ordre de l'enregistrement considéré
		$Wfsid = substr($_GET["SelectedId"],1);

		$Sql = "SELECT * FROM wf_steps WHERE wfsid=$Wfsid";
		$Db->Query($Sql);
		$Row = $Db->loadObject();
		$OrderLineSelected = $Row->myorder;
		$WidLineSelected = $Row->wid;
		if($OrderLineSelected == 1)
		break;

		$Sql = "SELECT * FROM wf_steps WHERE myorder=($OrderLineSelected-1) AND wid=$WidLineSelected;";
		$Db->Query($Sql);
		$Row = $Db->loadObject();
		$IdLineDown = $Row->wfsid;

		//on remonte la ligne (order -1)
		$Sql = "UPDATE wf_steps SET myorder=($OrderLineSelected-1) WHERE wfsid=$Wfsid;";
		$Db->Query($Sql);
			
		//on descend la ligne (order +1)
		$Sql = "UPDATE wf_steps SET myorder=($OrderLineSelected) WHERE wfsid=$IdLineDown;";
		$Db->Query($Sql);

		break;

	case 'DownStep':
		/* ***** ANCIENNE VERSION *****
		 // Lire le num d'ordre de l'enregistrement considéré
		 $Wfsid = substr($_GET["SelectedId"],1);
		 $Sql = "SELECT * FROM wf_steps WHERE wfsid=$Wfsid";
		 $Db->Query($Sql);
		 $Rep = $Db->loadArray();
		 $OldOrder = $Rep["myorder"];
		 // Savoir si la valeur courante est la valeur maximale
		 $Sql = "SELECT MAX(myorder) AS Max, wid, myorder FROM wf_steps WHERE wid=".$Rep["wid"].";";
		 $Db->Query($Sql);
		 $Max = $Db->loadArray();
		 if( $OldOrder==$Max["Max"] )
		 break;

		 $NewOrder = $OldOrder +1;
		 // print "On passe wfd de $OldOrder a $NewOrder - Id : $Wfdsid \n";
		 $Sql = "UPDATE wf_steps SET myorder=myorder-1 WHERE myorder > $OldOrder AND wid=".$Rep["wid"].";";
		 // print "$Sql";
		 $Db->Query($Sql);
		 $Sql = "UPDATE wf_steps SET myorder=$NewOrder WHERE wfsid=$Wfsid;";
		 // print "$Sql";
		 $Db->Query($Sql);
		 break;
		 */
			
		//lire le num d'ordre de l'enregistrement considéré
		$Wfsid = substr($_GET["SelectedId"],1);

		$Sql = "SELECT * FROM wf_steps WHERE wfsid=$Wfsid";
		$Db->Query($Sql);
		$Row = $Db->loadObject();
		$OrderLineSelected = $Row->myorder;
		$WidLineSelected = $Row->wid;

		//récupération de l'ordre maximum
		$Sql = "SELECT * FROM wf_steps WHERE wid=$WidLineSelected ORDER BY myorder DESC LIMIT 1;";
		$Db->Query($Sql);
		$Row = $Db->loadObject();
		$OrderMax = $Row->myorder;

		if($OrderLineSelected == $OrderMax)
		break;

		$Sql = "SELECT * FROM wf_steps WHERE myorder=($OrderLineSelected+1) AND wid=$WidLineSelected;";
		$Db->Query($Sql);
		$Row = $Db->loadObject();
		$IdLineDown = $Row->wfsid;

		//on decsend la ligne (order +1)
		$Sql = "UPDATE wf_steps SET myorder=($OrderLineSelected+1) WHERE wfsid=$Wfsid;";
		$Db->Query($Sql);
			
		//on remonte la ligne (order -1)
		$Sql = "UPDATE wf_steps SET myorder=($OrderLineSelected) WHERE wfsid=$IdLineDown;";
		$Db->Query($Sql);

	case 'AddDetail':
		print DetailEdit($Db,$_GET["SelectedId"],"Add");
		break;

	case 'ModDetail':
		print DetailEdit($Db,$_GET["SelectedId"],"Mod");
		break;

	case 'DelDetail':  // /components/Workflow/Workflow.php?Option=DelDetail&SelectedId=D3
		$Wdid = substr($_GET["SelectedId"],1);
		$Sql = "DELETE FROM wf_details WHERE wdid=$Wdid;";
		$Db->Query($Sql);
		$Db->Close();
		break;

	case 'SaveDetail':
		// /components/Workflow/Workflow.php?Option=SaveDetail&SId=S5&Before=1&Description=hjkhk&Wid=1&Action=Add&Guid=T1&Col=0&Actor=0
		if( substr($_GET["SId"],0,1) == "S" )
		{
			/* ***ANCIENNE VERSION ***
			 $wfsid = substr($_GET["SId"],1);
			 $SqlOrder = "UPDATE wf_details SET myorder=myorder+1 WHERE wfsid=$wfsid;";
			 $Db->Query($SqlOrder);
			 $Sql = "INSERT INTO wf_details SET description='". urldecode($_GET["Description"]) ;
			 $Sql .= "', wfsid=$wfsid, myorder=1, guid='". $_GET["Guid"] ."', col=".$_GET['Col'].",actor=".$_GET['Actor']." ;";
			 */

			//Recherche du numéro d'ordre maximum d'une action
			$wfsid = substr($_GET["SId"],1);
			$Sql = "SELECT * FROM wf_details WHERE wfsid=$wfsid ORDER BY myorder DESC LIMIT 1;";
			$Db->Query($Sql);
			$Row = $Db->loadObject();
			$OrderMaxDetail = $Row->myorder;

			$Sql = "INSERT INTO wf_details SET description='". urldecode($_GET["Description"]) ;
			$Sql .= "', wfsid=$wfsid, myorder=($OrderMaxDetail+1), guid='". $_GET["Guid"] ."', col=".$_GET['Col'].",actor=".$_GET['Actor']." ;";

			//updateNameStep($Db, $_GET["Guid"],$_GET['Actor'], $wfsid);
		}
		else
		{
			$wdid= substr($_GET["SId"],1);
			$Sql = "UPDATE wf_details SET description='". urldecode($_GET["Description"]) ;
			$Sql .= "', guid='". $_GET["Guid"] ."', col=".$_GET['Col'].",actor=".$_GET['Actor']." WHERE wdid=$wdid;";

			/*$Sql2 = "SELECT * FROM wf_details WHERE wdid=$wdid ;";
			 $Db->Query($Sql2);
			 $Row = $Db->loadObject();
			 $wfsid = $Row->wfsid;
			 updateNameStep($Db, $_GET["Guid"], $_GET['Actor'], $wfsid);*/
		}
		$Db->Query($Sql);
		break;

	case 'SaveGroups':
		$wid = $_POST["wid"];
		$Sql = "DELETE FROM w_grp WHERE wid=$wid ;";
		$Db->Query($Sql);
		$Grps = explode("|",$_POST["Groups"]);
		foreach($Grps as $Grp)
		{
			if( !empty($Grp) )
			{
				$Sql = "INSERT INTO w_grp SET wid=$wid, gid=$Grp ;";
				$Db->Query($Sql);
			}
		}
		break;

	case 'DisplayWorkflows':
		print DisplayWorkflows($Db, $_GET["txtWorkflow"], $_GET["inputWsid"]);
		break;

	case 'ListWorkflows':
		print ListWorkflows($Db);
		break;

	case 'ArianeStart':
		$Ariane = "<b>Circuit</b> (". date("d/m/Y") .") -&gt; ";
		$First = true;
		$Sql = "SELECT * FROM wf_steps WHERE wid=".$_POST["wid"]." ORDER BY myorder;";
		$Db->Query($Sql);
		$Rows = $Db->loadObjectList();
		foreach($Rows as $Row)
		{
			$Sql2 = "SELECT * FROM wf_details WHERE wfsid=$Row->wfsid AND actor=1;";
			$Db->Query($Sql2);
			$Rep = $Db->loadObject();
			$Guid = $Rep->guid;
			if( substr($Guid,0,1) == "G" )
			{
				$Gid = substr($Guid,1);
				if($Gid=="" || $Gid =="NULL") {
					$Actor = "";
				}
				else {
					$Sql3 = "SELECT * FROM groups WHERE gid=$Gid ;";
					$Db->Query($Sql3);
					$Rep = $Db->loadObject();
					$Actor = '('.$Rep->name.')';
				}
			}
			else
			{
				$Uid = substr($Guid,1);
				if($Uid=="" || $Uid =="NULL") {
					$Actor = "";
				}
				else {
					$Sql3 = "SELECT * FROM user WHERE uid=$Uid ;";
					$Db->Query($Sql3);
					$Rep = $Db->loadObject();
					$Actor = '('.$Rep->login.')';
				}
			}

			if( $First )
			{
				$First = false;
				$Ariane .= "<span style='color: Green'>". $Row->description.$Actor."</span> -&gt; ";
			}
			else {
				$Ariane .= $Row->description.$Actor." -&gt; ";
			}
		}
		echo substr($Ariane,0,-6);
		break;

	case 'GetFirstWfsid':
		$Sql = "SELECT * FROM wf_steps WHERE wid=".$_POST["wid"]." ORDER BY myorder;";
		$Db->Query($Sql);
		$Row = $Db->loadObject();
		echo $Row->wfsid;
		break;

	case 'GetDateDue':
		$Sql = "SELECT * FROM workflow WHERE wid=".$_POST["wid"]." ;";
		$Db->Query($Sql);
		$Row = $Db->loadObject();
		echo $Row->respondbefore;
		break;

	default:
		//print "ERREUR: $Option";
		break;
}

?>
