// Variables
CfgScript = "/components/Configure/Configure.php";

function CfgEdit()
{
id = GetActive();
if( id == 0 )
  {
  status_write("<font color='red'>Veuillez s&eacute;lectionner une ligne</font>");
  return;
  }

// Affiche le Popup
document.getElementById('overlay_modal').style.display = 'block';
win.showCenter();
URL = CfgScript+'?Option=EditCfg&ID='+id;
innerHTML = wget(URL);
document.getElementById('CfgPopup').innerHTML= innerHTML;
// Appeler la page
win.setContent('CfgPopup',true, true);
win.setTitle('Editer param&egrave;tre');
win.setSize(350,220);
win.showCenter();
// Fondre le fond
document.getElementById('overlay_modal').style.display = 'block';
return false;
}

function CfgAbort()
{
document.getElementById('overlay_modal').style.display = 'none';
win.hide();
}


function CfgSave()
{
Id  = document.getElementById('id').value;
Val=0;
switch ( document.getElementById('type').value )
  {
  case 'bool':
    if( document.getElementById('value').checked == true )
      Val=1;
    break;

  default:
    Val = document.getElementById('value').value;
    break;
  }

URL = CfgScript+"?Option=SaveCfg&id="+Id+"&value="+Val;
status_write(wget(URL));
// Cacher le popup et recharger les données
document.getElementById('overlay_modal').style.display = 'none';
win.hide();
document.location.reload();
}

function CfgQuit()
{
Msg = wget(CfgScript+"?Option=CfgQuit");
if( Msg != "" )
  alert(Msg);
alert("Edicod doit redémarrer pour prendre en compte les changements");
document.location = "/index.php?option=Logout";
}

function CfgPopToggle(Active)
{
if( Active ) 
  {
  document.getElementById('Srv').className = "fpPopInp2";
  document.getElementById('Srv').readOnly = '';
  document.getElementById('Usr').className = "fpPopInp2";
  document.getElementById('Usr').readOnly = '';
  document.getElementById('Pwd').className = "fpPopInp2";
  document.getElementById('Pwd').readOnly = '';
  }
else
  {
  document.getElementById('Srv').className = "fpPopInp2Gray";
  document.getElementById('Srv').readOnly = 'readonly';
  document.getElementById('Usr').className = "fpPopInp2Gray";
  document.getElementById('Usr').readOnly = 'readonly';
  document.getElementById('Pwd').className = "fpPopInp2Gray";
  document.getElementById('Pwd').readOnly = 'readonly';
  }
}

function CfgSavePop()
{

Params  = "On="   + document.getElementById('Use').checked;
Params += "&Srv=" + document.getElementById('Srv').value;
Params += "&Usr=" + document.getElementById('Usr').value;
Params += "&Pwd=" + urlencode(document.getElementById('Pwd').value);

URL = CfgScript+"?Option=SavePop";
status_write(wpost(URL,Params));
// Cacher le popup et recharger les données
document.getElementById('overlay_modal').style.display = 'none';
win.hide();
document.location.reload();
}

