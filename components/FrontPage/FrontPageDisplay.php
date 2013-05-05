<?php
/**
 * Affiche un document.
 *   Ce composant fait partie du Framework de l'application. Il affiche la page d'accueil.
 *
 * @package		Edicod
 * @subpackage		Framework
 * @version		1.2
 * @author              Serge NOEL
 */

/** 
 * Affichage d'un fichier.
 *   Cette fonction permet d'afficher les paramètres d'un fichier contenu dans la base de données
 *
 * @param	objet		Objet base de données
 * @param	integer		Identifiant du fichier
 * @return      string          Code HTML du Popup
 *
 */
function DisplayFile($Db, $Did)
{

session_start();
$BaseURL = $_SERVER["DOCUMENT_ROOT"];
// Recuperer toutes les informations sur le document
$Row = GetDocument($Db,$Did);
$Notes = GetNotes($Db, $Did);

if( !empty($Notes) )
	$Att = "<img src='/img/FrontPage/comment.png' alt='Il y a au moins une note' title='Il y a au moins une note' onClick='DisplayListNote(DisplayFileWin, $Did);'/>";

$Logs = GetLogs($Db, $Did);
$Keywords = GetKeyWords($Db, $Did);
$DocFolders = GetDocFolders($Db,$Did);

$Msg = "
&nbsp;<br />
<form name='EditMail' id='EditMail' action='#' method='post'>
  <input type='hidden' name='did' id='did' value='$Did'>
  <div class='formPopupLine' style='width: 830px; height: 20px; margin-left: 10px'>
    <span class='formTabTitleOn'  style='width: 200px' id='TabTDisplay1' onClick='MyTab(1, \"TabTDisplay\", \"TabDisplay\");'>&nbsp;Document</span>
    <span class='formTabTitleOff' style='width: 200px' id='TabTDisplay2' onClick='MyTab(2, \"TabTDisplay\", \"TabDisplay\");'>&nbsp;$Att Réponses &amp; PJ</span>
    <span class='formTabTitleOff' style='width: 200px' id='TabTDisplay3' onClick='MyTab(3, \"TabTDisplay\", \"TabDisplay\");'>&nbsp;Dossiers  &amp; lecteurs</span>
    <span class='formTabTitleOff' style='width: 200px' id='TabTDisplay4' onClick='MyTab(4, \"TabTDisplay\", \"TabDisplay\");'>&nbsp;Journal</span>
  </div>\n";

/******************************************
 * Informations générales sur le document *
 ******************************************/
$NameDoc = $Row->name;
$PathDoc = $Row->path;
$sizeDoc = $Row->size;
$object = $Row->object;
$fidate = Date_US_To_FR($Row->date_in);
$fbdate = Date_US_To_FR($Row->date_due);
$fodate = Date_US_To_FR($Row->date_out);
// Emplacement physique (Armoire)
$CabId = $Row->cabid;
if($CabId == '' || $CabId == NULL) {
   	$Box = "";
}else {
   	$Box = GetCabinetString($Db,$CabId);
}

// Expéditeur
$Sender = GetContactValue($Db,$Row->conid);
// Accusé de réception
if( !empty( $Row->receptid ) )
  $ImgSrc = "AROn.png";
else
  $ImgSrc = "AROff.png";
// Chemin sur disque
//$Folder = $_SESSION["Parameters"]["AbsoluteDocuments"] . $Row->path;
$Folder = $Row->path;
  
$Ariane = GetFilAriane2($Db, $Did, $Row->wfsid);
$DateDone = GetDateDone($Db, $Did, $Row->wfsid);

// Chemin complet du fichier sur le disque (chemin + nom du fichier)
$CompletePathDoc = $Folder.'/'.$NameDoc;

//on regarde si on est à la dernière étape pour afficher dans les réponses: "Enregistré" si dernière étape, [...]
//[...] ou "Brouillon" sinon
$LastStep = false;
$CurrentWfsid = $Row->wfsid;
$Sql = "SELECT * FROM wf_steps WHERE wfsid=$CurrentWfsid ;";
$Db->Query($Sql);
$Row = $Db->loadObject();
$CurrentWid = $Row->wid;
$Sql = "SELECT * FROM wf_steps WHERE wid=$CurrentWid ORDER BY myorder DESC LIMIT 1;";
$Db->Query($Sql);
$Row = $Db->loadObject();
$MaxWfsid = $Row->wfsid;
if($MaxWfsid == $CurrentWfsid) {
	$LastStep = true;
}

/************************* 
 * Fil d'ariane Workflow *
 ************************
// Workflow
$WfsId = $Row->wfsid;
$WfList = GetWorkFlowList($Db,$WfsId);
$Ariane="";
$Bold = "<b>";
$NoBold = "</b>";
foreach( $WfList as $Wfl )
  {
  $Color = "";
  $EndColor = "";
  if( $Wfl->wfsid == $WfsId )
    {
    $Bold = "";
    $NoBold = "";
    $Color = "<span style='color: Green'>";
    $EndColor = "</span>";
    }
  $Ariane .= $Bold . $Color . $Wfl->description . $EndColor . $NoBold;
  $Ariane .= " -&gt; ";
  }
$Ariane = substr($Ariane,0,-7);
*/




$Workflow = "             <input type='text' class='fpPopInp2' style='width: 230px' id='MyWorkflow' readonly='readonly' value='".GetWorkflow($Db,$Row->wfsid)."'>\n";
$WfStep = "             <input type='text' class='fpPopInp2' style='width: 230px' name='MyWfsid' id='MyWfsid' readonly='readonly' value='".GetWfStep($Db,$Row->wfsid)."'>\n";

$Msg .= "
<!-- ONGLET 1 : Le document en lui-même -->
  <div class='formTabOn' id='TabDisplay1' style='width: 830px; height: 435px; margin-left: 10px' >
    <fieldset id='-1'>
      <legend>Courrier</legend>
      <div>
        <span class='fpPopDiv1' style='width: 150px'>N° Chrono</span>
        <span class='fpPopDiv2' style='width: 260px; color: Gray'>$Did</span>
        <span class='fpPopDiv1' style='width: 150px'>Date r&eacute;ception</span>
        <span class='fpPopDiv2' style='width: 240px'>
          <img src='/img/FrontPage/calendarGray.png' class='ImgButton' />
          <input class='fpPopInp2' style='width: 80px' type='text' id='date_in_fr' name='date_in_fr' value='$fidate' readonly='readonly' />
        </span>
      </div>
      <div>
       <span class='fpPopDiv1' style='width: 150px'>Objet</span>
       <span class='fpPopDiv2'  style='width: 260px'>
         <input class='fpPopInp2' style='width: 250px' type='text' name='object' id='object' value='".$object."' readonly='readonly'>
       </span>
       <span class='fpPopDiv1' style='width: 150px'>Date limite</span>
       <span class='fpPopDiv2' style='width: 240px'>
          <img src='/img/FrontPage/calendarGray.png' class='ImgButton' />
          <input class='fpPopInp2' style='width: 80px' type='text' id='idate' name='idate' value='$fbdate' readonly='readonly' />
        </span>
      </div>

      <div>
       <span class='fpPopDiv1' style='width: 410px'></span>
       <span class='fpPopDiv1' style='width: 150px'>Fait le</span>
       <span class='fpPopDiv2' style='width: 240px'>
          <img src='/img/FrontPage/calendarGray.png'  alt='Afficher calendrier' title='Afficher calendrier' class='ImgButton' />
          <input class='fpPopInp2' style='width: 80px' type='text' id='odate' name='odate' value='$fodate' readonly='readonly' />
        </span>
      </div>
     </fieldset>
     <br />
     <!-- ETAT -->
     <fieldset id='-1'>
       <legend>Param&egrave;tres</legend>
       <div>
        <span class='fpPopDiv1' style='width: 150px'>Classement</span>
        <span class='fpPopDiv2' style='width: 260px;'>
          <img src='/img/FrontPage/cabinetGray.png' alt='Armoire' class='ImgButton' />&nbsp;
          <input class='fpPopInp2' style='width: 215px;' type='text' name='box' id='box' readonly='readonly' value='$Box' />
        </span>
         <span class='fpPopDiv1' style='width: 150px'>Stockage</span>
         <span class='fpPopDiv2' style='width: 240px'>
               <img src='/img/FrontPage/diskGray.png' alt='Repertoire' class='ImgButton' />
               <input class='fpPopInp2' style='width: 200px;' type='text' id='path' readonly='readonly' value='$CompletePathDoc' >
         </span>
       </div>
      <div>
         <span class='fpPopDiv1' style='width: 150px'>Acc. r&eacute;cept.</span>
         <span class='fpPopDiv2' style='width: 260px'>
           <img src='/img/FrontPage/$ImgSrc' class='ImgButton' id='RAimg' />
           <input class='fpPopInp2' style='width: 215px;' type='text' name='receptid' id='idreceptnum' value='$ReceptNum' readonly='readonly'>
         </span>
        <span class='fpPopDiv1' style='width: 150px'>Exp&eacute;diteur</span>
        <span class='fpPopDiv2' style='width: 240px'>
          <img src='/img/FrontPage/UserGray.png'  class='ImgButton' />
          <input class='fpPopInp2' style='width: 200px' id='conid' name='conid' value='$Sender' readonly='readonly'>
         </span>
       </div>

    </fieldset>
    <br />
    <!-- DISTRIBUTION -->
    <fieldset id='-1'>
       <legend>Distribution</legend>
         <div>
           <img src='/img/FrontPage/WorkflowGray.png' class='ImgButton' /> $Ariane
         </div>
      </fieldset>
      <!-- Mots clés -->
      <br />
      <fieldset id='-1'>
        <legend>Mots cl&eacute;s</legend>
        <textarea id='keywords' class='fpComment' style='width: 800px; height: 70px; overflow-x: hidden'  readonly='readonly'>". $Keywords ."</textarea>
      </fieldset>
    </div> <!-- ONGLET1 -->\n";

/************************************
 * ONGLET 2 : Les Notes & les liens *
 ************************************/
$Border01 = "border-top: 1px solid Gray; border-left: 1px solid Gray; border-right: 1px solid Gray;";
$Border02 = "border-left: 1px solid Gray; border-right: 1px solid Gray;";
$Border03 = "border-bottom: 1px solid Gray; border-left: 1px solid Gray; border-right: 1px solid Gray;";
$Msg .= "<!-- ONGLET 2  Les notes -->
  <div class='formTabOff' id='TabDisplay2' style='width: 830px; height: 400px; margin-left: 10px' >
   <div class='fpPopDiv2' style='width: 400px; height: 360px; margin-left: 10px;'>
     <fieldset>
     <legend>Reponse(s)</legend>
        <div style='background-color:white;overflow-y: scroll; height: 295px; width: 380px; margin-top: 5px' id='div-liste-reponses'>
\n";

$Msg .= loadListResponsesDisplay($Db, $Did, $LastStep);

$Msg .= "
            </div>
             <div class='formButtonsItem' style='margin-top: 10px; float:left' >
                <img src='/img/FrontPage/RespondGray.png' class='ImgButton' alt='Répondre' title='Répondre' />
             </div>
        </fieldset>
       </div>
       <div class='fpPopDiv2' style='width: 400px; height: 360px; margin-left: 10px;' >
        <fieldset>
         <legend>Liens &agrave; d'autres documents</legend>
          <select size='10' name='doclinks' id='doclinks' style='width: 380px; height: 300px'>";

    $Msg .= loadListFileAttachDisplay($Db, $Did);
    
    $Msg .= "
          </select>
          <img src='/img/FrontPage/AddLinkDocGray.png' class='ImgButton' style='margin-top: 10px' >
          <img src='/img/FrontPage/DelLinkDocGray.png' class='ImgButton' style='margin-top: 10px; margin-left: 20px'>
        </fieldset>
       </div>
      </div>\n";

/***************************************************
 * ONGLET 3 : Les dossiers virtuels & les lecteurs *
 ***************************************************/
$Msg .= "<!-- ONGLET 3 : Les dossiers virtuels -->
  <div class='formTabOff' id='TabDisplay3' style='width: 830px; height: 400px; margin-left: 10px' id='VirtualsFolders'>
    <div class='fpPopDiv2' style='width: 400px; height: 340px; text-align: left; margin-left: 10px'>
      <fieldset>
        <legend>Dossiers virtuels</legend>
      <select size='10' name='docfolders' id='docfolders' style='width: 380px; height: 300px'>
$DocFolders
      </select>
      <img src='/img/FrontPage/AddFolderGray.png' class='ImgButton' style='margin-top: 10px' >
      <img src='/img/FrontPage/DelFolderGray.png' class='ImgButton' style='margin-top: 10px; margin-left: 20px'>
    </div>
    <div class='fpPopDiv2' style='width: 400px; height: 340px; text-align: center; margin-left: 10px'>
      <fieldset>
        <legend>Copie en lecture &agrave</legend>
      <select size='10' name='docview' id='docview' style='width: 380px; height: 300px'>

      </select>
      <img src='/img/FrontPage/AddReaderGray.png' class='ImgButton' style='margin-top: 10px' >
      <img src='/img/FrontPage/DelReaderGray.png' class='ImgButton' style='margin-top: 10px; margin-left: 20px'>
      </fieldset>
    </div>
  </div>\n";

/***************************
 * ONGLET 4 : Les journaux *
 ***************************/
$Style="display: block; float: left; border-bottom: 1px dashed gray; border-right: 1px dashed gray";
//$Style="border-bottom: 1px dashed gray; border-right: 1px dashed gray";
$StyleHeader = "border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid gray";
$StyleHeadC  = "display: block; float: left";
$BorderContent = "border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;";
$Msg .= "<!-- ONGLET 4 : Les journaux -->
  <div class='formTabOff' id='TabDisplay4' style='width: 830px; height: 400px; margin-left: 10px' >
    <div id='Tableau'>
      <div style='width: 790px; height: 15px; $StyleHeader; margin-left:10px; margin-top:10px' >
        <span style='width: 85px; border-right: 1px solid gray; font-weight: bold; $StyleHeadC'>&nbsp;Date</span>
        <span style='width: 65px; border-right: 1px solid gray; font-weight: bold; $StyleHeadC'>&nbsp;Heure</span>
        <span style='width: 145px; border-right: 1px solid gray; font-weight: bold; $StyleHeadC'>&nbsp;Qui</span>
        <span style='width: 465px; font-weight: bold; $StyleHeadC'>&nbsp;Acc&egrave;s</span>
      </div>
     <div style='width: 790px; height: 370px; overflow-y: scroll; $BorderContent margin-left: 10px' id='Logs'>\n";
foreach($Logs as $Log)
  {
  $Date  = substr($Log->timestamp,8,2) . "/" . substr($Log->timestamp,5,2) . "/" .substr($Log->timestamp,0,4);
  $Heure = substr($Log->timestamp,11,2) . ":" . substr($Log->timestamp,14,2) . ":" .substr($Log->timestamp,17,2);
  $User  = $Log->name . " " . $Log->given_name;
  $Desc  = $Log->description;
  $Msg .= "
       <div style='width: 760px;'>
         <span style='width: 85px; $Style'>&nbsp;$Date</span>
         <span style='width: 65px; $Style'>&nbsp;$Heure</span>
         <span style='width: 145px; $Style'>&nbsp;$User</span>
         <span style='width: 460px; $Style'>&nbsp;$Desc</span>
       </div>\n";
  }
$Msg .= "     </div>
    </div>
  </div>\n";

/********************
 * Barre de boutons *
 ********************/

$RelativeFileName = $_SESSION["Parameters"]["RelativeDocuments"]."$PathDoc/$NameDoc";

$Apercu = "Aperçu (".SizeToHuman($sizeDoc).")";
$Msg .= "
<div class='formButtons'>
  <span class='formButtonsItemL' style='margin-left: 10px; margin-top: 10px' >
   <img src='/img/FrontPage/Preview.png' class='ImgButton' alt='$Apercu' title='$Apercu' onClick='Preview(\"$RelativeFileName\");' />
  </span>

  <span class='formButtonsItemL' style='margin-left: 10px; margin-top: 10px' >";
	if( !empty($Notes) )        
       	$Msg .= " <img src='/img/FrontPage/notes-ok.png' class='ImgButton' alt='Notes' title='Notes' onClick='DisplayListNote(DisplayFileWin, $Did);' />";
    else
    	$Msg .= " <img src='/img/FrontPage/Notes.png' class='ImgButton' alt='Notes' title='Notes' onClick='DisplayListNote(DisplayFileWin, $Did);' />";
        	
    $Msg .= "
  </span>
  
  <span class='formButtonsItemR' style='margin-top: 10px' >
    <img src='/img/FrontPage/Door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='AbortDocument(DisplayFileWin);' />
  </span>
</div>

<input type='hidden' name='name' value='".$NameDoc."' />
</form>\n";
$Db->Close();
return ($Msg);
}


/**
 * Retourne une chaine de caractères contenant le code de la liste des pièces jointes.
 * @param db $Db
 * @param int $Did
 */
function loadListFileAttachDisplay(db $Db, $Did)
{
	$ListDocAttach = GetDocFileAttach($Db, $Did);
    foreach($ListDocAttach as $DocAttach)
    {
    	$Sql2 = "SELECT * FROM documents WHERE did=$DocAttach->did_docattach ;";
		$Db->Query($Sql2);
		$ligne = $Db->loadObject();
    	$Msg .= "
    		<option value='$DocAttach->did_docattach'>$ligne->object</option>
    	";
    }
	
	return $Msg;
}

/**
 * Retourne une chaine de caractères contenant le code de la liste de réponses.
 * @param db $Db
 * @param int $Did
 */
function loadListResponsesDisplay( db $Db, $Did, $LastStep)
{
    $Responses = GetDocResponses($Db, $Did);
    foreach($Responses as $Response)
    {
        $Date  = substr($Response->date,8,2)  . "/" . substr($Response->date,5,2)  . "/" .substr($Response->date,0,4);
        $Heure = substr($Response->date,11,2) . ":" . substr($Response->date,14,2) . ":" .substr($Response->date,17,2);
        $Description  = $Response->description;
        $Object = $Response->objet;

        if($Response->path == null)
        {
            $Msg .= "<div id='div-response-$Response->ddid' style='width: 365px;border: solid 1px gray;cursor:pointer;' onmouseover=\"divFocus('$Response->ddid', true);\" onmouseout=\"divFocus('$Response->ddid', false);\">

                        <div style='width: 365px;' onclick=\"UpdateRespond(DisplayFileWin, $Response->ddid)\">
                            <b>Objet :</b> $Object<br />
                        </div>";
            if($Description != "")
            {
                $Msg .=    "<div style='width: 365px;' onclick=\"UpdateRespond(DisplayFileWin, $Response->ddid)\">
                                <b>Description :</b> $Description<br />
                            </div>";
            }
            $Msg .=    "<div style='width: 365px;' onclick=\"UpdateRespond(DisplayFileWin, $Response->ddid)\">
                            <b>Créé le :</b> $Date à $Heure
                        </div>";
            
            if($LastStep) {
            	$StatutReponse = "Enregistré.";
            }
            else {
            	$StatutReponse = "Brouillon.";
            }
            
            $Msg .= "   <div id='div-draft-$Response->ddid' style='padding: 3px;width: 359px; color:white; background-color: #FF0000;' onclick=\"UpdateRespond(DisplayFileWin, $Response->ddid)\"><b>$StatutReponse</b></div>\n
                     </div>";
        }
        else
        {
            $PDFPath = $Response->path."/".$Response->name;
            $Msg .= "
            <a href=\"".$PDFPath."\">
            <div id='div-response-$Response->ddid' style='width: 365px;border: solid 1px gray;cursor:pointer;' onmouseover=\"divFocus('$Response->ddid', true);\" onmouseout=\"divFocus('$Response->ddid', false);\" >
                        <div style='width: 365px;'>
                            <b>Objet :</b> $Object<br />
                        </div>";
            if($Description != "")
            {
                $Msg .=    "<div style='width: 365px;'>
                                <b>Description :</b> $Description<br />
                            </div>";
            }
            $Msg .=    "<div style='width: 365px;'>
                            <b>Enregistré le :</b> $Date à $Heure
                        </div>
                        </div>
            </a>";
        }
    }
    return $Msg;
}


?>
