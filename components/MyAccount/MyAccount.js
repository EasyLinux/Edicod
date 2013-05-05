var win

function ChPwd()
{ // Affiche Popup chgt Mdp
// Appeler la page
win.setContent('MyPopup',true, true);
win.setTitle('Changer votre mot de passe');
win.setSize(310,200);
win.showCenter();
document.getElementById('overlay_modal').style.display = 'block';
}

function Save()
{  // Sauve données
if( !Valid('Account') )
  return;
Account = document.getElementById('Account');
URL = '/components/MyAccount/MyAccount.php?Option=Save'; 
// Construire la requete
string='';
for( i=0 ; i < Account.length ; i++)
  {
  if( Account.elements[i].value.length > 0 )
    URL += '&' + Account.elements[i].name + '=' + encodeURIComponent(HTMLentities(Account.elements[i].value));
  }
// appel au serveur
status_write(wget(URL));
}

function Quit()
{
document.location='/index.php';
}

function DoPwd()
{
Account = document.getElementById('Account');
NewPass = document.getElementById('NewPass1').value;
OldPass = document.getElementById('OldPwd').value;
if( document.getElementById('NewPass1').value != document.getElementById('NewPass2').value )
  {
  alert('Les mots de passe ne concordent pas !');
  return;
  }
if( OldPass.length == 0 )
  {
  alert("Vous devez saisir l'ancien mot de passe");
  return;
  }
if( NewPass.length < 6 )
  {
  alert("Le mot de passe doit faire au minimum 6 caractères");
  return;
  }
MD5_OldPass = MD5(OldPass);
MD5_NewPass = MD5(NewPass);
// A partir de l'URL retrouver le composant appelé
URL  = '/components/MyAccount/MyAccount.php'; 
URL += '?option=Pwd&uid='+Account.uid.value;
URL += '&OldPass='+MD5_OldPass+'&NewPass='+MD5_NewPass;
status_write('');
alert(URL);
alert(wget(URL));
win.hide();
document.getElementById('overlay_modal').style.display = 'none';
}

function Close()
{
win.hide();
document.getElementById('overlay_modal').style.display = 'none';
}

