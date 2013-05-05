var Ident=0;
var MaxDirs=0;
var CurIdx=0;

/********************************************
* Demander au serveur les versions stockées *
*********************************************/
function sendData()
{
clearTimeout(Tout); // Supprimer le timeOut
Msg = wget('/components/Update/Update.php?Option=GetVersions');
if( Msg.substr(0,3) == '<b>') 
  document.getElementById('StatusBar').innerHTML = Msg; // Erreur
else
  {
  console.debug(Msg);
  document.getElementById('dVersions').innerHTML = Msg;
  document.getElementById('StatusBar').innerHTML = 'Ok';
//  document.getElementById('NewVersion').style.display = 'inline';
//  document.getElementById('Go').style.display = 'inline';
//  document.getElementById('dDesc').style.display = 'inline';
//  Select = document.getElementById('Ver');
//  document.getElementById('NewVersion').value = Select.options[0].value;
  }
}

function Change(Id)
{
document.getElementById('comment').innerHTML = base64_decode(document.getElementById(Id).value);
}

/***********************
* Lance la publication *
************************
function Go()
{
NewVer = document.getElementById('NewVersion').value;
Description = document.getElementById('dDesc').value;
if (confirm('Version a publier : '+NewVer+' ?'+'\\n\\n'+Description) )
  {
  document.getElementById('StatusBar').innerHTML = 'Cr&eacute;ation de la version sur le serveur';
  // Crée un depot
  Ident = wpost('/components/Publish/Publish.php?Option=NewVersion','Version='+NewVer+'&Description='+urlencode(Description));
  document.getElementById('StatusBar').innerHTML = 'Identifiant : '+Ident;
  // Lance la copie
  setTimeout( 'ScanDirs()', 500);
  }
}

/****************************************
* Analyse les répertoires à sauvegarder *
*****************************************
function ScanDirs()
{
document.getElementById('StatusBar').innerHTML = 'Analyse des r&eacute;pertoires &agrave; sauvegarder... ';
ListeDirs = wpost('/components/Publish/Publish.php?Option=ScanDirs');
MesVars = ListeDirs.split(';');
MaxDirs= MesVars[0];
document.getElementById('nbPath').innerHTML = MaxDirs;
Dirs = MesVars[1].split('|');
document.getElementById('StatusBar').innerHTML = 'Analyse des r&eacute;pertoires &agrave; sauvegarder... OK ';
setTimeout( 'CopyDir()', 200);
}

/************************************** 
* Copie un répertoire vers le serveur *
***************************************
function CopyDir()
{
document.getElementById('StatusBar').innerHTML = 'Copie en cours... ';
document.getElementById('Copy').innerHTML = '/'+Dirs[CurIdx];
document.getElementById('nbPath').innerHTML = CurIdx + '/' + MaxDirs;
Msg = wpost('/components/Publish/Publish.php?Option=Copy', 'Dir='+Dirs[CurIdx]+'&idRelease='+Ident);
document.getElementById('Copy').innerHTML = '/'+Dirs[CurIdx] + Msg;

CurIdx++;
if( CurIdx < MaxDirs )
  setTimeout( 'CopyDir()', 20);
else
  {
  document.getElementById('StatusBar').innerHTML = 'Copie termin&eacute;e';
  document.getElementById('nbPath').innerHTML = MaxDirs + ' r&eacute;pertoires copi&eacute;s';
  }
}
*/

