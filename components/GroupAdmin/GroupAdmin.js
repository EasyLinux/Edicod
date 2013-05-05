var DefaultPassword;

function Add()
{  // Affiche le popup et met id=-1
document.getElementById('Popup').style.display = 'block';
document.getElementById('uid').value = -1;
document.getElementById('MD5Pass').value = '" . $_SESSION["Cfg"]["DefaultPassword"] . "';
}

function Lock()
{ // Valide / invalide un utilisateur
uid = GetActive();
// A partir de l'URL retrouver le composant appelé
Call      = ''+document.location;
Options   = Call.split('?')[1];
Option    = Options.split('&')[0];
Component = Option.split('=')[1];
URL  = '/components/' + Component + '/' + Component+ '.php?'; 
if( uid != 0 )
  {
  URL += 'Option=Lock&id='+uid;
  Msg = wget(URL);
  if( Msg == 'ERROR' )
    status_write(\"<font color='red'>Une erreur est apparue</font>\");
  else 
    {
    status_write(Msg);
    document.location.reload();
    }
  }
}

function Edit()
{
uid = GetActive();
if( uid == 0 )
  {
  status_write(\"<font color='red'>Veuillez s&eacute;lectionner une ligne</font>\");
  return;
  }

// Affiche le Popup
document.getElementById('Popup').style.display = 'block';
document.getElementById('uid').value = uid;
// A partir de l'URL retrouver le composant appelé
Call      = ''+document.location;
Options   = Call.split('?')[1];
Option    = Options.split('&')[0];
Component = Option.split('=')[1];
URL  = '/components/' + Component + '/' + Component+ '.php?'; 
URL += 'Option=Read&ID='+uid;
AllDatas = wget(URL);
Datas = AllDatas.split('|');
for(i=0 ; i< Datas.length ; i++)
  {
  Vars = Datas[i].split('=');
  Var = Vars[0];
  Value = urldecode(Vars[1]);
  for( j=0 ; j < Variables.length ; j++ )
    {
    if(Var == Variables[j][0])
      {
      switch( Variables[j][1] )
        {
        case 'text':
        case 'hidden':
        case 'mail':
        case 'phone':
        case 'int':
          document.getElementById(Var).value = Value;
          break;

        case 'select':
          for( k=0 ; k < document.getElementById(Var).length ; k++)
            {
            if( document.getElementById(Var)[k].value == Value )
              document.getElementById(Var).selectedIndex = k;
            }          
          break;

        case 'check':
          if( Value == '1' )
            document.getElementById(Var).checked = true;
          else
            document.getElementById(Var).checked = false;
          break;

        default:
          alert(Var+' = '+Value+ ' - '+Variables[j][1]);
          break;
        } // switch
      } // endif
    } // for j
  } // for i

}

function Abort()
{
document.getElementById('Popup').style.display = 'none';
}

function Delete()
{
uid = GetActive();
// A partir de l'URL retrouver le composant appelé
Call      = ''+document.location;
Options   = Call.split('?')[1];
Optiond   = Options.split('&')[0];
Component = Optiond.split('=')[1];
URL  = '/components/' + Component + '/' + Component+ '.php?'; 
if( uid != 0 )
  {
  URL += 'Option=Delete&id='+uid;
  Msg = wget(URL);
  if( Msg == 'ERROR' )
    status_write(\"<font color='red'>Une erreur est apparue</font>\");
  else 
    {
    status_write('');
    document.location.reload();
    }
  }
}

function Save()
{  // Sauve données
if( Valid('EditUser') != true )
  return;

MyForm = document.getElementById('EditUser');
// A partir de l'URL retrouver le composant appelé
Call      = ''+document.location;
Options   = Call.split('?')[1];
Option    = Options.split('&')[0];
Component = Option.split('=')[1];
URL = '/components/' + Component + '/' + Component+ '.php?Option=Save'; 

// Construire l'URL
string='';
for( i=0 ; i < MyForm.length ; i++)
  { // Parcourir tous les chams
  for( j=0 ; j< Variables.length ; j++)
    { // Pour chaque champs trouve, lire le type
    if( Variables[j][0] == MyForm.elements[i].name )
      {
      switch( Variables[j][1] )
        {  // agir en fonction du type
        case 'text':
        case 'hidden':
        case 'select':
        case 'mail':
        case 'phone':
        case 'int':
          if( MyForm.elements[i].value.length > 0 )
            URL += '&' + MyForm.elements[i].name + '=' + encodeURIComponent(HTMLentities(MyForm.elements[i].value));
          break;

        case 'check':
          if( MyForm.elements[i].checked )
            URL += '&' + MyForm.elements[i].name + '=1';
          else
            URL += '&' + MyForm.elements[i].name + '=0';
          break;

        case 'MD5pwd':  // Le vrai mot de passe (MD5) est passe en hidden
          break;

        default:  // Type non défini
          alert( Variables[j][1] + ' - ' + MyForm.elements[i].name );
          break;

        }  // fin switch
      }  // endif
    } // for j
  } // for i
// appel au serveur
status_write(wget(URL));
// Cacher le popup et recharger les données
document.getElementById('Popup').style.display = 'none';
document.location.reload();
}

function GetProfile()
{
// A partir de l'URL retrouver le composant appelé
Call      = ''+document.location;
Question  = Call.split('?')[1];
Action    = Question.split('&')[0];
Component = Action.split('=')[1];
URL  = '/components/' + Component + '/' + Component+ '.php?'; 
URL += 'Option=GetProfiles';
Response = wget(URL);
Ligne = Response.split('|');
for( i=0 ; i < Ligne.length ; i++)
  {
  Vals = Ligne[i].split('=');
  Child = new Option(Vals[1],Vals[0]);
  Element = document.getElementById('pid');
  Element.appendChild(Child);
  }

status_write('');
}



function Tab()
{
if( document.getElementById('TabT1').className == 'formTabTitleOn')
  {
  document.getElementById('TabT1').className = 'formTabTitleOff';
  document.getElementById('Tab1').className = 'formTabOff';
  document.getElementById('TabT2').className = 'formTabTitleOn';
  document.getElementById('Tab2').className = 'formTabOn';
  }
else
  {
  document.getElementById('TabT1').className = 'formTabTitleOn';
  document.getElementById('Tab1').className = 'formTabOn';
  document.getElementById('TabT2').className = 'formTabTitleOff';
  document.getElementById('Tab2').className = 'formTabOff';
  }

}



