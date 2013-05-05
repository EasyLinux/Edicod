var ListNoteWin; // Objet Window de la fenêtre listant les notes
var NewNote; // Objet Window de la fenêtre permetant la saisie d'une nouvelle note

/*********************************************************************/
/* Ouvre la div contenant la liste des notes associées à un document */
/* parentWindow : objet javascript 'window' de la fenêtre parente    */
/* did : identifiant du document                                     */
/*********************************************************************/
function DisplayListNote(parentWindow, did)
{
    URL = '/components/FrontPage/FrontPage.php?Option=DisplayListeNote&id='+did+'&parentWindowId='+parentWindow.getId();

    // Fondre le fond
    parentWindow.setOpacity(0.6);

    if( typeof(ListNoteWin) != 'object' )
    {
        ListNoteWin = new Window('ListNoteId',{className: "bluelighting", closable:false, resizable:false,
                                   maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
    }
    ListNoteWin.setZIndex(40);
    ListNoteWin.setOpacity(1);
    // Appeler la page
    ListNoteWin.setAjaxContent(URL);
    ListNoteWin.setTitle('Notes attachées au document');
    ListNoteWin.setSize(430,390);
    ListNoteWin.showCenter();
}


function CloseListNote()
{
    ListNoteWin.hide();
    var parent = document.getElementById(document.getElementById('parentEditNote').value);
    parent.style.opacity = 1;
    parent.style.filter = 'alpha(opacity=10)';
}

/**************************************************************************************************
 * Ouvre un fenêtre pour ajouter une note                                                         *
 * did : Identifiant du document                                                                  *
 **************************************************************************************************/
function AddNote(did)
{
	/* **** Ancienne version ****
	URL = Script +'?Option=Note&Did='+did;
	
    // Fenetre popup
    if( typeof(NewNote) != 'object' )
      {
      NewNote = new Window('Note',{className: "bluelighting", closable:false, resizable:false, maximizable: false, minimizable:false,
        showEffect:Effect.Appear, hideEffect:Effect.Fade});
      }
    NewNote.setZIndex(60);
    
    innerHTML = wget(URL);
    document.getElementById('Popup3').innerHTML= innerHTML;
    // Appeler la page
    NewNote.setContent('Popup3',true, true);
    NewNote.setTitle('Note');
    NewNote.setSize(300,200);
    win.setOpacity(0.4);
    NewNote.showCenter();
    */
    

	URL = '/components/FrontPage/FrontPage.php?Option=Note&Did='+did;

    if( typeof(NewNote) != 'object' )
    {
    	NewNote = new Window('NewNote',{className: "bluelighting", closable:false, resizable:false,
                               maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
    }
    NewNote.setZIndex(60);
    NewNote.setOpacity(0.4);
    // Appeler la page
    NewNote.setAjaxContent(URL);
    NewNote.setTitle('Note');
    NewNote.setSize(300,200);
    NewNote.showCenter();
    document.getElementById('overlay_modal').style.display = 'block';
}

/**************************************************************************************************
 * Sauvegarde d'une note                                                                          *
 **************************************************************************************************/
function SaveNote()
{
    Did = document.getElementById('did').value;
    NoteTxt = document.getElementById('TheNote').value;
    if( NoteTxt != "" )
    {
        URL = Script +'?Option=SaveNote&Did='+Did+'&Description='+ urlencode( htmlentities(NoteTxt) );
        innerHTML = wget(URL);
        document.getElementById('LesNotes').innerHTML = innerHTML;
    }
    NewNote.hide();
    win.setOpacity(1);
}