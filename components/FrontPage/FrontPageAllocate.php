<?php
/**
 * Alloue un document.
 *   Ce composant fait partie du Framework de l'application. Il affiche la page d'accueil.
 *
 * @package		Edicod
 * @subpackage		Framework
 * @version		1.2
 * @author              Serge NOEL
 */

/**
 * Alloue un document.
 *   Cette fonction est appellé quand le dispatcheur clique sur un des fichiers en attente.
 *
 * @param 	objet		Objet base de données
 * @param	integer		Identifiant du fichier
 *
 * @todo	Permettre la suppression d'un document
 * @todo        Mettre en oeuvre des notes enfants...
 * @todo	Modifier la liaison à un autre courrier
 * @todo        Lier automatiquement documents via accusé de réception
 */
function AllocateFile($Db, $Did)
{
session_start();
$BaseURL = $_SERVER["DOCUMENT_ROOT"];

/*
 Récuperer la chemin de stockage par défaut (Edicod/Store/) pour le mettre dans la zone de texte 
 INUTILE !!!!!!!!!!!
$Param = GetParameter($Db, 6);
$valueAbsDoc = $Param->value;

$Param = GetParameter($Db, 8);
$valueRepStock = $Param->value;
$stockageDisqueDefault = $valueRepStock.$valueAbsDoc;
*/

// Récuperer toutes les informations sur le document
$Row = GetDocument($Db,$Did);
$Notes = GetNotes($Db, $Did);
$Att="";
if( !empty($Notes) )
	$Att = "<img src='/img/FrontPage/comment.png' alt='Il y a au moins une note' title='Il y a au moins une note' onClick='DisplayListNote(AllocateFileWin, $Did);'/>";

$Logs = GetLogs($Db, $Did);
$Keywords = GetKeyWords($Db, $Did);
$DocFolders = GetDocFolders($Db,$Did);
$Ariane = "<span style='color: Green;'>Circuit</span>";
$date_in = $Row->date_in;
$date_in_fr = Date_US_To_FR($date_in);
$date_due = $Row->date_due;
$date_due_fr = Date_US_To_FR($date_due);

$Msg = "
&nbsp;<br />
<form name='DispatchMail' id='DispatchMail' action='#' method='post'>
  <input type='hidden' name='did' id='did' value='$Did'>
  <input type='hidden' id='AbsPath' value='".$_SESSION["Parameters"]["AbsoluteDocuments"]."' />
  <div class='formPopupLine' style='width: 830px; height: 20px; margin-left: 10px'>
    <span class='formTabTitleOn'  style='width: 200px' id='TabTAllocate1' onClick='MyTab(1, \"TabTAllocate\", \"TabAllocate\");'>&nbsp;Document</span>
    <span class='formTabTitleOff' style='width: 200px' id='TabTAllocate2' onClick='MyTab(2, \"TabTAllocate\", \"TabAllocate\");'>&nbsp;$Att Réponses &amp; PJ</span>
    <span class='formTabTitleOff' style='width: 200px' id='TabTAllocate3' onClick='MyTab(3, \"TabTAllocate\", \"TabAllocate\");'>&nbsp;Dossiers  &amp; lecteurs</span>
    <span class='formTabTitleOff' style='width: 200px' id='TabTAllocate4' onClick='MyTab(4, \"TabTAllocate\", \"TabAllocate\");'>&nbsp;Journal</span>
  </div>\n";

/******************************************
 * Informations générales sur le document *
 ******************************************/
$Msg .= "
<!-- ONGLET 1 : Le document en lui-même -->
  <div class='formTabOn' id='TabAllocate1' style='width: 830px; height: 400px; margin-left: 10px' >
    <fieldset id='-1'>\n <legend>Courrier</legend>
      <div>
        <span class='fpPopDiv1' style='width: 150px'>N° Chrono</span>
        <span class='fpPopDiv2' style='width: 260px; color: Gray'>$Did</span>
        <span class='fpPopDiv1' style='width: 150px'>Date r&eacute;ception</span>
        <span class='fpPopDiv2' style='width: 240px'>
          <img src='/img/FrontPage/calendar.png' onClick=\"showMyCalendar('date_in_fr', '%d/%m/%Y',CalDateIn);\" alt='Afficher calendrier' title='Afficher calendrier' class='ImgButton' />
          <input class='fpPopInp2' style='width: 80px' type='text' id='date_in_fr' name='date_in_fr' value='$date_in_fr' onChange='SetDate();' readonly='readonly' />
          <input type='hidden' name='date_in' id='date_in' value='$date_in' />
        </span>
      </div>
      <div>
       <span class='fpPopDiv1' style='width: 150px'>Objet</span>
       <span class='fpPopDiv2'  style='width: 260px'>
         <input class='fpPopInp2' style='width: 250px' type='text' name='object' id='object' value='".$Row->object."' >
       </span>
       <span class='fpPopDiv1' style='width: 150px'>Date limite</span>
       <span class='fpPopDiv2' style='width: 240px'>
          <img src='/img/FrontPage/calendar.png' onClick=\"showMyCalendar('date_due_fr', '%d/%m/%Y',CalDateDue);\" alt='Afficher calendrier' title='Afficher calendrier' class='ImgButton' />
          <input class='fpPopInp2' style='width: 80px' type='text' id='date_due_fr' name='date_due_fr' value='$date_due_fr' onChange='SetDate();' readonly='readonly' />
          <input type='hidden' name='date_due' id='date_due' value='$date_due' />
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
          <img src='/img/FrontPage/cabinet16.png' alt='Stockage papier' title='Stockage papier' class='ImgButton' onClick='DisplayCabinet();' />&nbsp;
          <input class='fpPopInp2' style='width: 200px;' type='text' name='box' id='box' value='".GetCabinetString($Db,$Row->cabid)."' readonly='readonly' />
          <input type='hidden' id='cabid' name='cabid' value='".$defaultCabid."'/>
        </span>
         <span class='fpPopDiv1' style='width: 150px'>Stockage</span>
         <span class='fpPopDiv2' style='width: 240px'>
               <img src='/img/FrontPage/disk.png' alt='Stockage disque' title='Stockage disque' class='ImgButton' onClick='DisplayFolders();' />
               <input class='fpPopInp2Gray' style='width: 200px;' type='text' name='path' id='path' value='".$Row->path."' readonly='readonly' />
         </span>
       </div>

       <div>
         <span class='fpPopDiv1' style='width: 150px'>Accus&eacute; r&eacute;ception</span>
         <span class='fpPopDiv2' style='width: 260px'>
           <img src='/img/FrontPage/AROff.png' alt='Accusé de réception' title='Accusé de réception' class='ImgButton' onClick='Toggle();' id='RAimg' />
           <input class='fpPopInp2Gray' style='width: 200px;' type='text' name='receptid' id='idreceptnum' value='' >
         </span>
        <span class='fpPopDiv1' style='width: 150px'>Exp&eacute;diteur</span>
        <span class='fpPopDiv2' style='width: 240px'>
          <img src='/img/FrontPage/User.png' onClick=\"DisplayContacts(AllocateFileWin, 'conidAllocate', 'SenderAllocate');\" alt='Choisir expéditeur' title='Choisir expéditeur' class='ImgButton' />
          <input class='fpPopInp2' style='width: 200px' id='SenderAllocate' name='SenderAllocate' readonly='readonly' />
          <input type='hidden' id='conidAllocate' name='conidAllocate' />
         </span>
       </div>
    </fieldset>
    <br />
    <!-- DISTRIBUTION -->
    <fieldset id='-1'>
       <legend>Distribution</legend>
         <img src='/img/FrontPage/Workflow.png' onClick='DisplayWorkflows(\"Ariane\", \"wfsid\");' class='ImgButton' />
         <span id='Ariane'>$Ariane</span>
         <input type='hidden' name='wfsid' id='wfsid' value='-1' />
    </fieldset>
    <!-- Mots clés -->
    <br />
      <fieldset id='-1'>
        <legend>Mots cl&eacute;s</legend>
        <textarea id='keywords' class='fpComment' style='width: 800px; height: 70px; overflow-x: hidden' onChange='SaveKeyWords();' ></textarea>
      </fieldset>
    </div> <!-- ONGLET1 -->\n";

/************************************
 * ONGLET 2 : Réponses & Attach. *
 ************************************/
	$Border01 = "border-top: 1px solid Gray; border-left: 1px solid Gray; border-right: 1px solid Gray;";
    $Border02 = "border-left: 1px solid Gray; border-right: 1px solid Gray;";
    $Border03 = "border-bottom: 1px solid Gray; border-left: 1px solid Gray; border-right: 1px solid Gray;";
    $Msg .= "<!-- ONGLET 2  Les notes -->
      <div class='formTabOff' id='TabAllocate2' style='width: 830px; height: 400px; margin-left: 10px' >
       <div class='fpPopDiv2' style='width: 400px; height: 360px; margin-left: 10px;'>
         <fieldset>
         <legend>Reponse(s)</legend>
            <div style='background-color:white;overflow-y: scroll; height: 295px; width: 380px; margin-top: 5px' id='div-liste-reponses'>
    \n";

    $Msg .= loadListResponsesAllocate($Db, $Did);

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

    $Msg .= loadListFileAttachAllocate($Db, $Did);
    
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
  <div class='formTabOff' id='TabAllocate3' style='width: 830px; height: 400px; margin-left: 10px' id='VirtualsFolders'>
    <div class='fpPopDiv2' style='width: 400px; height: 340px; text-align: left; margin-left: 10px'>
      <fieldset>
        <legend>Dossiers virtuels</legend>
      <select size='10' name='docfolders' id='docfolders' style='width: 380px; height: 300px'>
		$DocFolders
      </select>
      <img src='/img/FrontPage/AddFolder.png' class='ImgButton' onClick='DisplayDocFolder();' style='margin-top: 10px' >
      <img src='/img/FrontPage/DelFolder.png' class='ImgButton' onClick='DelDocFolder();' style='margin-top: 10px; margin-left: 20px'>
    </div>
    <div class='fpPopDiv2' style='width: 400px; height: 340px; text-align: center; margin-left: 10px'>
      <fieldset>
        <legend>Copie en lecture &agrave</legend>
      <select size='10' name='docview' id='docview' style='width: 380px; height: 300px'>

      </select>
      <img src='/img/FrontPage/AddReaderGray.png' class='ImgButton' onClick2='DisplayReaders();' style='margin-top: 10px' >
      <img src='/img/FrontPage/DelReaderGray.png' class='ImgButton' onClick2='DelReader();' style='margin-top: 10px; margin-left: 20px'>
      </fieldset>
    </div>
  </div>\n";

/***************************
 * ONGLET 4 : Les journaux *
 ***************************/
$Style="display: block; float: left; border-bottom: 1px dashed gray; border-right: 1px dashed gray";
$StyleHeader = "border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid gray";
$StyleHeadC  = "display: block; float: left";
$BorderContent = "border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;";
$Msg .= "<!-- ONGLET 4 : Les journaux -->
  <div class='formTabOff' id='TabAllocate4' style='width: 830px; height: 400px; margin-left: 10px' >
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
$RelativeFileName = $_SESSION["Parameters"]["RelativeDocuments"].$Row->path."/".$Row->name;
//echo $RelativeFileName;
$Apercu = "Aperçu (" . SizeToHuman($Row->size) . ")";
$Msg .= "
<div class='formButtons'>
      <span class='formButtonsItemL' style='margin-left: 10px; margin-top: 10px' >
       <img src='/img/FrontPage/Preview.png' class='ImgButton' alt='$Apercu' title='$Apercu' onClick='Preview(\"$RelativeFileName\");' />
      </span>

      <span class='formButtonsItemL' style='margin-left: 10px; margin-top: 10px' >";
		if( !empty($Notes) )        
	       	$Msg .= "<img src='/img/FrontPage/notes-ok.png' class='ImgButton' alt='Notes' title='Notes' onClick='DisplayListNote(AllocateFileWin, $Did);' />";
	    else
	    	$Msg .= "<img src='/img/FrontPage/Notes.png' class='ImgButton' alt='Notes' title='Notes' onClick='DisplayListNote(AllocateFileWin, $Did);' />";
	        	
	    $Msg .= "  
      </span>
      
      <span class='formButtonsItemR' style='margin-top: 10px;margin-right: 10px' >
        <img src='/img/FrontPage/Door.png' class='ImgButton' alt='Abandon' title='Abandon' onClick='AbortDocument(AllocateFileWin);' />
      </span>
      
      <span class='formButtonsItemR' style='margin-top: 10px;margin-right: 10px' >
       <img src='/img/FrontPage/SaveOk.png' class='ImgButton' alt=\"Sauvegarder avec validation d'étape\" title=\"Sauvegarder avec validation d'étape\" onClick='SaveAllocateDoc();' />
      </span>
      
    </div>
<input type='hidden' name='name' value='".$Row->name."' />
</form>
<script type='text/javascript'>
CalDateIn = new CalendarPopup('DivCalDateIn');
CalDateDue = new CalendarPopup('DivCalDateDue');
</script>\n\n";

$Db->Close();
return ($Msg);
}


/**
 * Retourne une chaine de caractères contenant le code de la liste des pièces jointes.
 * @param db $Db
 * @param int $Did
 */
function loadListFileAttachAllocate(db $Db, $Did)
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
function loadListResponsesAllocate( db $Db, $Did)
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
            			
            			<!-- Bouton : supprimer le brouillon (effet hover du bouton dans css/default.css)-->
            			<div id='block_delete_draft' style=\"text-align:center;padding : 3px 3px 3px 3px;float:right;z-index:45;width:16px;height:16px;\" onclick=\"DeleteDraft(".$Response->ddid.")\">
                        	<img src='/img/delete.png' class='ImgButton' alt='Supprimer le brouillon' title='Supprimer le brouillon'/>
            			</div>            
            
                        <div style='width: 365px;' onclick=\"UpdateRespond(AllocateFileWin, $Response->ddid)\">
                            <b>Objet :</b> $Object<br />
                        </div>";
            if($Description != "")
            {
                $Msg .=    "<div style='width: 365px;' onclick=\"UpdateRespond(AllocateFileWin, $Response->ddid)\">
                                <b>Description :</b> $Description<br />
                            </div>";
            }
            $Msg .=    "<div style='width: 365px;' onclick=\"UpdateRespond(AllocateFileWin, $Response->ddid)\">
                            <b>Créé le :</b> $Date à $Heure
                        </div>";
            $Msg .= "   <div id='div-draft-$Response->ddid' style='padding: 3px;width: 359px; color:white; background-color: #FF0000;' onclick=\"UpdateRespond(AllocateFileWin, $Response->ddid)\"><b>Brouillon.</b></div>\n
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
