<?php
/**
 * Edite un document.
 *   Ce composant fait partie du Framework de l'application. Il affiche la page d'accueil.
 *
 * @package		Edicod
 * @subpackage		Framework
 * @version		1.2
 * @author              Serge NOEL

 */

/** 
 * Edition d'un fichier.
 *   Cette fonction permet de modifier les paramètres d'un fichier contenu dans la base de données
 *
 * @param	objet		Objet base de données
 * @param	integer		Identifiant du fichier
 * @return      string          Code HTML du Popup
 *
 * @todo	Permettre la suppression d'un document
 * @todo 	Permettre de déplacer le document
 * @todo        Ajouter recherche texte intégral sur mots clés saisis et objet
 */
function EditFile($Db, $Did)
{
    session_start();
    $BaseURL = $_SERVER["DOCUMENT_ROOT"];
    // Recuperer toutes les informations sur le document
    $Row = GetDocument($Db,$Did);
    $Notes = GetNotes($Db, $Did);
    
    if( !empty($Notes) )
    	$Att = "<img src='/img/FrontPage/comment.png' alt='Il y a au moins une note' title='Il y a au moins une note' onClick='DisplayListNote(EditFileWin, $Did);' />";
    
	$Logs = GetLogs($Db, $Did);
    $Keywords = GetKeyWords($Db, $Did);
    $DocFolders = GetDocFolders($Db,$Did);
    $Ariane = GetFilAriane2($Db, $Did, $Row->wfsid);

    $Msg = "
    &nbsp;<br />
    <form name='EditMail' id='EditMail' action='#' method='post'>
      <input type='hidden' name='did' id='did' value='$Did'>
      <div class='formPopupLine' style='width: 830px; height: 20px; margin-left: 10px'>
        <span class='formTabTitleOn'  style='width: 200px' id='TabTEdit1' onClick='MyTab(1, \"TabTEdit\", \"TabEdit\");'>&nbsp;Document</span>
        <span class='formTabTitleOff' style='width: 200px' id='TabTEdit2' onClick='MyTab(2, \"TabTEdit\", \"TabEdit\");'>&nbsp;$Att Réponses &amp; PJ</span>
        <span class='formTabTitleOff' style='width: 200px' id='TabTEdit3' onClick='MyTab(3, \"TabTEdit\", \"TabEdit\");'>&nbsp;Dossiers  &amp; lecteurs</span>
        <span class='formTabTitleOff' style='width: 200px' id='TabTEdit4' onClick='MyTab(4, \"TabTEdit\", \"TabEdit\");'>&nbsp;Journal</span>
      </div>\n";

    /******************************************
     * Informations générales sur le document *
     ******************************************/
    $NameDoc = $Row->name;
    $date_in    = $Row->date_in;
    $date_in_fr = Date_US_To_FR($date_in);
    $date_due    = $Row->date_due;
    $date_due_fr = Date_US_To_FR($date_due);

    // Emplacement physique (Armoire)
    $CabId = $Row->cabid;
    /*condition pour éviter le bug d'affichage dans le dossier virtuel 
      lorsque le document PDF est toujorus pas traiter (toujorus dans à affecter) */
    if($CabId == '' || $CabId == NULL) {
    	$Box = "";
    }else {
    	$Box = GetCabinetString($Db,$CabId);
    }

    // Expéditeur
    $Conid=$Row->conid;
    /*condition pour éviter le bug d'affichage dans le dossier virtuel 
      lorsque le document PDF est toujorus pas traiter (toujorus dans à affecter) */
	if($Conid == '' || $Conid == NULL) {
    	$Sender= "";
    }else {
    	$Sender=GetContactName($Db,$Conid);
    }

    // Chemin sur disque
    $Folder = $Row->path;
    
    // Chemin complet du fichier sur le disque (chemin + nom du fichier)
    $CompletePathDoc = $Folder.'/'.$NameDoc;
    
    // Seul un administrateur peut déplacer un fichier sur le disque
    if( $_SESSION["User"]["Rights"] >= 7 )
    {
        $FolderImg = "onClick='DisplayFolders();'";
        $PathID="path";
    }
    else
    {
        $FolderImg = "onClick='alert(\"Seul un administrateur peut déplacer un fichier sur le disque !\");'";
        $PathID="MyPath";
    }
    // Seul un administrateur peut changer de workflow
    if( $_SESSION["User"]["Rights"] >= 7 )
      	$Workflow = "<img src='/img/FrontPage/Workflow.png' onClick='DisplayWorkflows(\"ArianeEdit\", \"wfsid\");' class='ImgButton' /> ";
    else
      	$Workflow = "<img src='/img/FrontPage/WorkflowGray.png'  class='ImgButton' /> ";

    //on regarde si on est à la dernière étape
    $LastStep = false;
    $AfterWfsId = GetNextWorkflowStep($Db,$Row->wfsid);
    if(IsLastStep($Db,$AfterWfsId)) {
    	$LastStep = true;
    }
      	
    // Seul un administrateur ou le groupe/utilisateur désigné peut changer d'étape
    if( (GetStepRights($Db, $Row->wfsid, $_SESSION["User"]["Guids"])==1) || ($_SESSION["User"]["Rights"] >= 15) )
      	$SaveStep = "<img src='/img/FrontPage/SaveOk.png' class='ImgButton' alt=\"Sauvegarder avec validation d'étape\" title=\"Sauvegarder avec validation d'étape\" onClick='SaveNextStep($LastStep);' />";
    else
      	$SaveStep = "<img src='/img/FrontPage/SaveOkGray.png' class='ImgButton' alt=\"Sauvegarder avec validation d'étape\" title=\"Sauvegarder avec validation d'étape\" />";
      
    if( !empty( $Row->receptid ) )
      	$ImgSrc = "AROn.png";
    else
      	$ImgSrc = "AROff.png";

    $Msg .= "
    <!-- ONGLET 1 : Le document en lui-même -->
      <div class='formTabOn' id='TabEdit1' style='width: 830px; height: 400px; margin-left: 10px' >
        <fieldset id='-1'>\n <legend>Courrier</legend>
           <div>
             <span class='fpPopDiv1' style='width: 150px'>N° Chrono</span>
               <span class='fpPopDiv2'  style='width: 260px; color: Gray'>$Did</span>
             <span class='fpPopDiv1' style='width: 150px'>Date r&eacute;ception</span>
             <span class='fpPopDiv2' style='width: 240px'>
               <img src='/img/FrontPage/calendarGray.png' class='ImgButton' />
               <input class='fpPopInp2Gray' style='width: 80px' type='text' id='date_in_fr' name='date_in_fr' value='$date_in_fr' readonly='readonly' />
             </span>
           </div>
           
           <div>
             <span class='fpPopDiv1' style='width: 150px'>Objet</span>
             <span class='fpPopDiv2'  style='width: 260px'>
               <input class='fpPopInp2' style='width: 250px' type='text' name='object' id='object' value='".$Row->object."'>
             </span>
             <span class='fpPopDiv1' style='width: 150px'>Date limite</span>
             <span class='fpPopDiv2' style='width: 240px'>
               <img src='/img/FrontPage/calendarGray.png' onClick=\"showMyCalendar('date_due_fr', '%d/%m/%Y',CalDateDue);\" alt='Afficher calendrier' title='Afficher calendrier' class='ImgButton' />
               <input class='fpPopInp2Gray' style='width: 80px' type='text' id='date_due_fr' name='date_due_fr' value='$date_due_fr' onChange='SetDate();' readonly='readonly' />
               <input type='hidden' name='date_due' id='date_due' value='$ddate_due' />
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
               <img src='/img/FrontPage/cabinetGray.png' alt='Stockage papier' title='Stockage papier' class='ImgButton' />&nbsp;
               <input class='fpPopInp2Gray' style='width: 200px;' type='text' name='box' id='box' value='$Box' readonly='readonly' />
               <input type='hidden' id='cabid' name='cabid'/>
             </span>
             <span class='fpPopDiv1' style='width: 150px'>Stockage</span>
             <span class='fpPopDiv2' style='width: 240px'>
               <img src='/img/FrontPage/diskGray.png' alt='Stockage disque' title='Stockage disque' class='ImgButton' />
               <input class='fpPopInp2Gray' style='width: 200px;' type='text' name='path' id='path' value='$CompletePathDoc' readonly='readonly' />
             </span>
           </div>

           <div>
             <span class='fpPopDiv1' style='width: 150px'>Accus&eacute; r&eacute;ception</span>
             <span class='fpPopDiv2' style='width: 260px'>
               <img src='/img/FrontPage/$ImgSrc' alt='Accusé de réception' title='Accusé de réception' class='ImgButton' id='RAimg' />
               <input class='fpPopInp2Gray' style='width: 200px;' type='text' name='receptid' id='idreceptnum' value='$ReceptNum' >
             </span>
            <span class='fpPopDiv1' style='width: 150px'>Exp&eacute;diteur</span>
            <span class='fpPopDiv2' style='width: 240px'>
              <img src='/img/FrontPage/User.png' onClick=\"DisplayContacts(EditFileWin, 'conid', 'Sender');\" alt='Choisir expéditeur' title='Choisir expéditeur' class='ImgButton' />
              <input class='fpPopInp2' style='width: 200px' id='Sender' name='Sender' value='$Sender' readonly='readonly' />
              <input type='hidden' name='conid' id='conid' value='$Conid' />
             </span>
           </div>
        </fieldset>

        <br />
        <!-- DISTRIBUTION -->
        <fieldset id='-1'>
           <legend>Distribution</legend>
           $Workflow <span id='ArianeEdit'> $Ariane </span>
           <input type='hidden' id='wfsid' value='".$Row->wfsid."' />
        </fieldset>
          
        <!-- Mots clés -->
        <br />
        <fieldset id='-1'>
           <legend>Mots cl&eacute;s</legend>
           <textarea id='keywords' class='fpComment' style='width: 800px; height: 70px; overflow-x: hidden' onChange='SaveKeyWords();' >". $Keywords ."</textarea>
        </fieldset>
      </div> <!-- ONGLET1 -->\n";

    /***************************************
     * ONGLET 2 : Les liens & les réponses *
     ************************************/
    $Border01 = "border-top: 1px solid Gray; border-left: 1px solid Gray; border-right: 1px solid Gray;";
    $Border02 = "border-left: 1px solid Gray; border-right: 1px solid Gray;";
    $Border03 = "border-bottom: 1px solid Gray; border-left: 1px solid Gray; border-right: 1px solid Gray;";
    $Msg .= "<!-- ONGLET 2  Les notes -->
      <div class='formTabOff' id='TabEdit2' style='width: 830px; height: 400px; margin-left: 10px' >
       <div class='fpPopDiv2' style='width: 400px; height: 360px; margin-left: 10px;'>
         <fieldset>
         <legend>Reponse(s)</legend>
            <div style='background-color:white;overflow-y: scroll; height: 295px; width: 380px; margin-top: 5px' id='div-liste-reponses'>
    \n";

    $Msg .= loadListResponses($Db, $Did);

    $Msg .= "
            </div>
             <div class='formButtonsItem' style='margin-top: 10px; float:left' >
                <img src='/img/FrontPage/Respond.png' class='ImgButton' alt='Répondre' title='Répondre' onClick='AddRespond(EditFileWin, $Did);' />
             </div>
        </fieldset>
       </div>
       <div class='fpPopDiv2' style='width: 400px; height: 360px; margin-left: 10px;' >
        <fieldset>
         <legend>Liens &agrave; d'autres documents</legend>
          <select size='10' name='doclinks' id='doclinks' style='width: 380px; height: 300px'>";

    $Msg .= loadListFileAttach($Db, $Did);
    
    $Msg .= "
          </select>
          
          <input type='hidden' value='' id='did_docattach_selected' name='did_docattach_selected'/>
          <input type='hidden' value='$Did' id='did-attach' name='did-attach'/>
          <img src='/img/FrontPage/AddLinkDoc.png' class='ImgButton' onClick='UploadFileAttach(EditFileWin, $Did);' style='margin-top: 10px' >
          <img src='/img/FrontPage/DelLinkDoc.png' class='ImgButton' onClick='DelReader($Did);' style='margin-top: 10px; margin-left: 20px'>
        </fieldset>
       </div>
      </div>\n";

    /***************************************************
     * ONGLET 3 : Les dossiers virtuels & les lecteurs *
     ***************************************************/
    $Msg .= "<!-- ONGLET 3 : Les dossiers virtuels -->
      <div class='formTabOff' id='TabEdit3' style='width: 830px; height: 400px; margin-left: 10px' id='VirtualsFolders'>
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
    //$Style="border-bottom: 1px dashed gray; border-right: 1px dashed gray";
    $StyleHeader = "border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid gray";
    $StyleHeadC  = "display: block; float: left";
    $BorderContent = "border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;";
    $Msg .= "<!-- ONGLET 4 : Les journaux -->
      <div class='formTabOff' id='TabEdit4' style='width: 830px; height: 400px; margin-left: 10px' >
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
    
    /* ***** Ancienne version, lorsque le nom du fichier n'était pas inclut dans le chemin *****
    $RelativeFileName = $_SESSION["Parameters"]["RelativeDocuments"] . $Row->path ."/". $Row->name;*/
    
    // on recherche si il y'a la présence de la chaine "/Edicod" (qui empèche l'affichage du doc)
    $FindMe = "/Edicod";
    $RelativeFileName = $_SESSION["Parameters"]["RelativeDocuments"].$Row->path."/".$Row->name; 
	
    $Apercu = "Aperçu (" . SizeToHuman($Row->size) . ")";
    $Msg .= "

    <div class='formButtons'>
      <span class='formButtonsItemL' style='margin-left: 10px; margin-top: 10px' >
       <img src='/img/FrontPage/Preview.png' class='ImgButton' alt='$Apercu' title='$Apercu' onClick='Preview(\"$RelativeFileName\");' />
      </span>

      <span class='formButtonsItemL' style='margin-left: 10px; margin-top: 10px' >";
    
		if( !empty($Notes) )        
        	$Msg .= "<img src='/img/FrontPage/notes-ok.png' class='ImgButton' alt='Notes' title='Notes' onClick='DisplayListNote(EditFileWin, $Did);' />";
      	else
      		$Msg .= "<img src='/img/FrontPage/Notes.png' class='ImgButton' alt='Notes' title='Notes' onClick='DisplayListNote(EditFileWin, $Did);' />";
        	
      $Msg .= "
      </span>
      
      <span class='formButtonsItemR' style='margin-top: 10px;margin-right: 10px' >
        <img src='/img/FrontPage/Door.png' class='ImgButton' alt='Abandon' title='Abandon' onClick='AbortDocument(EditFileWin);' />
      </span>
      
      <span class='formButtonsItemR' style='margin-top: 10px;margin-right: 10px' >
       $SaveStep
      </span>
      
      <span class='formButtonsItemR' style='margin-top: 10px;margin-right: 10px' >
       <img src='/img/FrontPage/Save.png' class='ImgButton' alt='Sauvegarder' title='Sauvegarder' onClick='SaveEditDoc();' />
      </span>
      
    </div>
    <input type='hidden' name='name' id='name' value='".$Row->name."' />
    </form>
    <script type='text/javascript'>
    CalDateIn = new CalendarPopup('DivCalDateIn');
    CalDateDue = new CalendarPopup('DivCalDateDue');
    </script>\n";
    $Db->Close();
    return ($Msg);
}

/**
 * Retourne une chaine de caractères contenant le code de la liste des pièces jointes.
 * @param db $Db
 * @param int $Did
 */
function loadListFileAttach(db $Db, $Did)
{
$Msg="";

$ListDocAttach = GetDocFileAttach($Db, $Did);
foreach($ListDocAttach as $DocAttach)
  {
  $DateAjout  = substr($DocAttach->date_in,8,2)  . "/" . substr($DocAttach->date_in,5,2)  . "/" .substr($DocAttach->date_in,0,4);
  $HeureAjout = substr($DocAttach->date_in,11,2) . ":" . substr($DocAttach->date_in,14,2) . ":" .substr($DocAttach->date_in,17,2);
  $RelativeFileName = "/Documents" . $DocAttach->path. "/" .$DocAttach->name;
        
	$InfoBulle = "<b>Objet :</b> ".$DocAttach->object."<br /><b>Ajouté le :</b> $DateAjout à $HeureAjout <br /><br /><i>Double cliquez sur le lien pour afficher la pièce jointe</i>";
		
  $Msg .= "<option value='".$DocAttach->did_docattach."' onmouseover=\"tt_over1('$InfoBulle', 'tStyle')\" onmouseout='tt_out()' onclick='SetAttach(this.value';) ";
  $Msg .= "ondblclick=\"Preview('$RelativeFileName');\">";
  $Msg .= $DocAttach->object." (".$DocAttach->name.")</option>\n";
  }
return $Msg;
}

/**
 * Retourne une chaine de caractères contenant le code de la liste de réponses.
 * @param db $Db
 * @param int $Did
 */
function loadListResponses(db $Db, $Did)
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
                        
                        <div style='width: 365px;' onclick=\"UpdateRespond(EditFileWin, $Response->ddid)\">
                            <b>Objet :</b> $Object<br />
                        </div>";
            if($Description != "")
            {
                $Msg .=    "<div style='width: 365px;' onclick=\"UpdateRespond(EditFileWin, $Response->ddid)\">
                                <b>Description :</b> $Description<br />
                            </div>";
            }
            $Msg .=    "<div style='width: 365px;' onclick=\"UpdateRespond(EditFileWin, $Response->ddid)\">
                            <b>Créé le :</b> $Date à $Heure
                        </div>";

            $Msg .= "   <div id='div-draft-$Response->ddid' style='padding: 3px;width: 359px; color:white; background-color: #FF0000;' onclick=\"UpdateRespond(EditFileWin, $Response->ddid)\"><b>Brouillon.</b></div>\n
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
