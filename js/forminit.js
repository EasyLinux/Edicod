
function FormInit(ID)
{
// A partir de l'URL retrouver le composant appelé
Call      = ''+document.location;
Options   = Call.split('?')[1];
Option    = Options.split('&')[0];
Component = Option.split('=')[1];
// Appel au serveur 
URL = '/components/' + Component + '/' + Component+ '.php?Option=Init&ID='+ID; 
Options = wget(URL);
// Traiter la reponse 
Ligne = Options.split('|');
for( i=0 ; i < Ligne.length ; i++)
  {  // On a une ligne de la forme <variable>=<valeur>
  Vals = Ligne[i].split('=');
  for( j=0 ; j < Variables.length ; j++)
    { // parcourir les lignes du tableau
    if( Vals[0] == Variables[j][0] )
      { // y plus qu'a afficher
      switch( Variables[j][1] )
        { // traiter l'info en fonction 
        case 'none':
          break;

        case 'text':
        case 'phone':
        case 'mail':
        case 'hidden':
        case 'int':
          document.getElementById(Vals[0]).value = Vals[1];
          break;

        case 'display':
          document.getElementById(Vals[0]).innerHTML = Vals[1];
        break;

        default:
          alert(Variables[j][1]+ ' Non defini');
          break
        }  // switch
        j= Variables.length;
      } // if
    } // for j
  }  // for i
status_write('');
}

