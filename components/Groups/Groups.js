// Variables
GrpScript = "/components/Groups/Groups.php";
var GroupWin, PathWin;
var MemberChange= false;

function GrpAdd()
{
MemberChange= false;
URL = GrpScript+'?Option=GrpEdit&Id=-1'; 

// Appeler la page
GroupWin = new Window('Groupes',{className: "bluelighting", closable:false, resizable:false, maximizable: false, minimizable:false, 
      showEffect:Effect.Appear, hideEffect:Effect.Fade});
GroupWin.setAjaxContent(URL);
GroupWin.setTitle('Edition groupe');
GroupWin.setSize(450,510);
GroupWin.showCenter();
// Fondre le fond
document.getElementById('overlay_modal').style.display = 'block';
}

function GrpAbort()
{
document.getElementById('overlay_modal').style.display = 'none';
GroupWin.hide();
GroupWin.destroy();
}

function GrpSave()
{
gid = document.getElementById("gid").value;
wid = document.getElementById("wid").value;
if( document.getElementById('name').value == "")
  {
  alert("Pas de nom de groupe !");
  return;
  }
URL  = GrpScript + '?Option=GrpSave&gid='+gid+'&wid='+wid+'&name='+urlencode(htmlentities(document.getElementById('name').value));
URL += '&comment='+urlencode(htmlentities(document.getElementById('comment').value));
URL += '&path='+urlencode(htmlentities(document.getElementById('path').value));
URL += '&widOut='+urlencode(htmlentities(document.getElementById('widOut').value));
gid = wget(URL);

if( MemberChange )
  {
  URL = GrpScript +'?Option=SaveMembers'; 
  GrpXML ='';
  var Users='';
  var In  = document.getElementById('members');
  for( i=0 ; i< In.length ; i++)
    {
    Value = In.options[i].value;
    Users += Value + '|';
    }
    
  GrpXML = "&gid="+gid+"&Users="+Users;
  status_write(wpost(URL,GrpXML));
  }
document.getElementById('overlay_modal').style.display = 'none';
GroupWin.hide();
GroupWin.destroy();
document.location.reload();
}

function GrpEdit()
{
MemberChange= false;
id = GetActive();
if( id == 0 )
  {
  status_write("<font color='red'>Veuillez s&eacute;lectionner une ligne</font>");
  return;
  }

URL = GrpScript+'?Option=GrpEdit&Id='+id; 

// Appeler la page
GroupWin = new Window('Groupes',{className: "bluelighting", closable:false, resizable:false, maximizable: false, minimizable:false, 
      showEffect:Effect.Appear, hideEffect:Effect.Fade});
GroupWin.setAjaxContent(URL);
GroupWin.setTitle('Edition groupe');
GroupWin.setSize(450,510);
GroupWin.showCenter();
// Fondre le fond
document.getElementById('overlay_modal').style.display = 'block';
return false;
}

function AddMember()
{
Base = document.getElementById('members');
var In  = document.getElementById('members');
var Out = document.getElementById('users');
var Max = Out.length;
MemberChange= true;
do
  {
  Del = false;
  for( i=0 ; i< Out.length ; i++)
    {
    if( Out.options[i].selected )
      {
      element = document.createElement("option");
      element.text  = Out.options[i].text;
      element.value = Out.options[i].value;
      Where = In.length;
      In.options[Where] = element;
      Out.options[i] = null;
      Del = true;
      }
    }
  }  while (Del)
}

function DelMember()
{
var In  = document.getElementById('users');
var Out = document.getElementById('members');
var Max = Out.length;
MemberChange= true;

do
  {
  Del = false;
  for( i=0 ; i< Out.length ; i++)
    {
    if( Out.options[i].selected )
      {
      element = document.createElement("option");
      element.text  = Out.options[i].text;
      element.value = Out.options[i].value;
      Where = In.length;
      In.options[Where] = element;
      Out.options[i] = null;
      Del = true;
      }
    }
  }  while (Del)
}

function GetPath()
{
Path = document.getElementById('path').value;
Root = document.getElementById('RootPath').value;
URL = GrpScript+'?Option=ScanPath&Path='+urlencode(Path)+'&Root='+urlencode(Root); 

// Appeler la page
PathWin = new Window('WinPath',{className: "bluelighting", closable:false, resizable:false, maximizable: false, minimizable:false, 
      showEffect:Effect.Appear, hideEffect:Effect.Fade});
PathWin.setAjaxContent(URL);
PathWin.setTitle('Courriers entrants');
PathWin.setSize(300,160);
PathWin.showCenter();
GroupWin.setOpacity(0.4);
// Fondre le fond
document.getElementById('overlay_modal').style.display = 'block';
return false;
}

function SavePath()
{
var Path = document.getElementById('Path');
var MyPath ='';
Max = Path.length;
for(i=0 ; i < Max ; i++ )
  {
  if( Path.options[i].selected )
    {
    MyPath = Path.options[i].text;
    }
  }
document.getElementById('path').value = '/'+MyPath;
PathWin.hide();
PathWin.destroy();
GroupWin.setOpacity(1);
}

function GrpDelete()
{
id = GetActive();
if( id == 0 )
  {
  status_write("<font color='red'>Veuillez s&eacute;lectionner une ligne</font>");
  return;
  }
URL = GrpScript+'?Option=GrpDelete&gid='+id;
status_write(wget(URL));
document.location.reload();
}

function MakePath()
{
NewPath = prompt("Nouveau dossier:");
if( NewPath=="" || NewPath == null )
  return;
URL = GrpScript+'?Option=MakePath&Path='+urlencode(NewPath);
Msg = wget(URL);
if( Msg != "" )
  {
  alert(Msg);
  return;
  }
Path = document.getElementById('path').value;
Root = document.getElementById('RootPath').value;
URL = GrpScript+'?Option=ScanPath&Path='+urlencode(Path)+'&Root='+urlencode(Root); 
PathWin.setAjaxContent(URL);
}

function SelectPath(Value)
{
if( Value != ".." )
  {
  Path = document.getElementById('path').value;
  document.getElementById('path').value = Path + '/' + Value;
  }
Path = document.getElementById('path').value;
Root = document.getElementById('RootPath').value;
URL = GrpScript+'?Option=ScanPath&Path='+urlencode(Path)+'&Root='+urlencode(Root); 
PathWin.setAjaxContent(URL);
}

function GrpQuit()
{
document.location="/index.php";
}

function ChangeReceipt(Active)
{
if( Active )
  {
  document.getElementById('sWid').style.display='inline';
  document.getElementById('Message').innerHTML = "(Oui, ce groupe a une banette)";
  }
else
  {
  document.getElementById('sWid').style.display='none';
  document.getElementById('Message').innerHTML = " (Non n'est pas li&eacute;)";
  document.getElementById('path').value ="";
  }
}
