<?php
session_start();

/**
 * Affiche une div avec la liste des notes associées à un document.
 * @param int $parentWindowId
 * @param db $Db
 * @param id $Did
 * @return string
 */
function DisplayListNote($parentWindowId, $Db, $Did)
{
	//echo "parentWindowId = ".$parentWindowId."<br />";
	
    session_start();
    $BaseURL = $_SERVER["DOCUMENT_ROOT"];
    $Notes = GetNotes($Db, $Did);
    if( !empty($Notes) )
      $Att = "<img src='/img/FrontPage/comment.png' alt='Il y a au moins une note' title='Il y a au moins une note' />";
    $Logs = GetLogs($Db, $Did);
    
    $Msg = "
      <!-- Fenetre parente -->
      <input type='hidden' id='parentEditNote' value='".$parentWindowId."' />
      
       <div class='fpPopDiv2' style='width: 400px; height: 360px; margin-left: 10px;'>
         <fieldset>
         <legend>Notes</legend>
         <div style='overflow-y: scroll; height: 295px; width: 380px;margin-left: 10px; margin-top: 5px' id='LesNotes'>
    \n";

    $Msg .= PrintNotes($Notes);
    
    $Msg .= "
         </div>         
        </fieldset>
        <div class='formButtons2' style='width: 400px'>
          <div class='formButtonsItemL'> <!--style='margin-left: 10px'-->";
    
			//si la page est en lecture seule alors on ne peut pas ajouter de notes
    		if($parentWindowId != 'DisplayFileWin') {
    $Msg .= "
            	<img src='/img/FrontPage/AddNote.png' class='ImgButton' alt='Ajouter' title='Ajouter' onClick='AddNote($Did);' />";
			}
    $Msg .= "
          </div>
          
          <div class='formButtonsItemR'> <!--style='margin-left: 20px'-->
            <img src='/img/Folders/Door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='CloseListNote();' />
          </div>
        </div>
       </div>";
    return $Msg;
}

/**
 * Affiche les notes d'un document
 * @param	objet	Objet de résultat notes
 * @return	string	Chaine à afficher (code HTML)
 */
function PrintNotes($Notes)
{
    foreach($Notes as $Note)
    {
        $Border01 = "border-top: 1px solid Gray; border-left: 1px solid Gray; border-right: 1px solid Gray;";
        $Border02 = "border-left: 1px solid Gray; border-right: 1px solid Gray;";
        $Border03 = "border-bottom: 1px solid Gray; border-left: 1px solid Gray; border-right: 1px solid Gray;";

        $Date  = substr($Note->timestamp,8,2)  . "/" . substr($Note->timestamp,5,2)  . "/" .substr($Note->timestamp,0,4);
        $Heure = substr($Note->timestamp,11,2) . ":" . substr($Note->timestamp,14,2) . ":" .substr($Note->timestamp,17,2);
        $User  = $Note->name." ".$Note->given_name;
        $Desc  = $Note->note;

        $Msg .= "      <div style='width: 360px;$Border01' >
            <b>Auteur :</b> $User<br />
          </div>
          <div style='width: 360px;$Border02' >
            <b>Fait le :</b> $Date à $Heure
          </div>
          <div style='width: 360px; background-color: #F3E437; $Border03'><b>Note :</b><br />
            $Desc
          </div>\n";
  /*$Date  = substr($Note->timestamp,8,2)  . "/" . substr($Note->timestamp,5,2)  . "/" .substr($Note->timestamp,0,4);
  $Heure = substr($Note->timestamp,11,2) . ":" . substr($Note->timestamp,14,2) . ":" .substr($Note->timestamp,17,2);
  $User  = $Note->name . " " . $Note->given_name;
  $Desc  = $Note->note;

  $Msg .= "      <div style='height: 18px; width: 790px; $Border01'>
        <span style='display: block; float: left; width: 200px'><b>Auteur :</b> $User</span>
        <span style='display: block; float: left;'><b>Fait le :</b> $Date à $Heure</span>
      </div>
      <div style='width: 790px; background-color: #F3E437; $Border02'><b>Note :</b><br />
        $Desc
      </div>\n";*/
    }
    return $Msg ;
}

/**
 * Ajoute une note à un document
 * @return	string	Chaine à afficher (code HTML)
 */
function AddNote()
{  // 300x200
    $Border = "border: 1px solid Gray;";
    $Html = "
    <form id='AddNote' method='post' action='#'>
      <textarea style='width: 290px; height: 150px; background-color: #F3E437; overflow: auto; $Border' id='TheNote' ></textarea>
    </form>
    <div>
      <span class='formButtonsItem' style='width: 150px;' >
      </span>
      <span class='formButtonsItem' >
        <img src='/img/FrontPage/save.png' class='ImgButton' alt='Enregistrer' title='Enregistrer' onClick='SaveNote();' />
      </span>
      <span class='formButtonsItem' style='width: 50px' >
      </span>
      <span class='formButtonsItem' >
        <img src='/img/FrontPage/cancel.png' class='ImgButton' alt='Abandon' title='Abandon' onClick='AbortNote();' />
      </span>
    </div>\n";

    return $Html;
}

?>
