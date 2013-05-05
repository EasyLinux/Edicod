// Code Javascript
var Folders, DocFolders, Cabinet;

function SetDate()
{ // Transforme la date de '02/10/2009' a '2009-10-02'
FrDate = document.getElementById('fdate').value;
UsDate = substr(FrDate,6,4)+'-'+substr(FrDate,3,2)+'-'+substr(FrDate,0,2);
document.getElementById('date_in').value = UsDate;
}

function showCalendar(id, dateFormat) 
{
cal = new CalendarPopup();
cal.select(document.getElementById(id),id,'dd/MM/yyyy');
}

function DisplayFolders()
{
URL = "/components/Folders/Folders.php?Option=DisplayFolders";

// Fondre le fond
document.getElementById('overlay_modal').style.display = 'block';
Folders = new Window('Folders',{className: "bluelighting", closable:false, resizable:false, 
                               maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});

Folders.setZIndex(10);
// Appeler la page
Folders.setAjaxContent(URL);
Folders.setTitle('Choisir un r&eacute;pertoire');
Folders.setSize(650,400);
Folders.showCenter();
}

function SetActive(Value)
{  // Fonction appelee lors d'un click de selection
RadioSelected=Value;
}

function GetActive()
{  // Lire la ligne cochee
return RadioSelected;
}

function SelectFolder()
{
document.getElementById('folder').value = GetActive();
Folders.destroy();
document.getElementById('overlay_modal').style.display = 'none';
}

function DisplayCabinet()
{
URL = "/components/Cabinet/Cabinet.php?Option=DisplayCabinet";

// Fondre le fond
document.getElementById('overlay_modal').style.display = 'block';
Cabinet = new Window('Folders',{className: "bluelighting", closable:false, resizable:false, 
                               maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});

Cabinet.setZIndex(10);
// Appeler la page
Cabinet.setAjaxContent(URL);
Cabinet.setTitle('Choisir un emplacement physique de stockage');
Cabinet.setSize(650,400);
Cabinet.showCenter();
}

function SelectCabinet()
{
ID = GetActive();
if( ID == -1 )
  return;
document.getElementById('boxid').value = ID;
document.getElementById('box').value = wget("/components/Cabinet/Cabinet.php?Option=GetCabinetString&Id="+ID);
Cabinet.destroy();
document.getElementById('overlay_modal').style.display = 'none';
}

function DisplayDocFolders()
{
URL = "/components/DocFolders/DocFolders.php?Option=DisplayFolders";

// Fondre le fond
document.getElementById('overlay_modal').style.display = 'block';
DocFolders = new Window('Folders',{className: "bluelighting", closable:false, resizable:false, 
                               maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});

DocFolders.setZIndex(10);
// Appeler la page
DocFolders.setAjaxContent(URL);
DocFolders.setTitle('Choisir un ou plusieurs dossi&eacute;r(s) li&eacute;(s)');
DocFolders.setSize(650,400);
DocFolders.showCenter();
}

function ADQuit()
{
document.location="/index.php";
}

