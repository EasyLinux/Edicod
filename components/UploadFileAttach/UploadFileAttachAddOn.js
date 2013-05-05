/***********
 * Cabinet *
 **************************************************************************************************
 * Fonctions liées au rangement physique (armoire)                                                *
 **************************************************************************************************/
function DisplayCabinet()
{
URL = "/components/Cabinet/Cabinet.php?Option=DisplayCabinet";

Kind = document.getElementById('kind').value;
if( Kind == "upload" )
  {
  // Fondre le fond
  document.getElementById('overlay_modal').style.display = 'block';
  }
  
if( typeof(Cabinet) != 'object' )
	{
	Cabinet = new Window('Cabinet',{className: "bluelighting", closable:false, resizable:false,
        		maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
	}
Cabinet.setZIndex(20);
Cabinet.setOpacity(1);
// Appeler la page
Cabinet.setAjaxContent(URL);
Cabinet.setTitle('Choisir un emplacement physique de stockage');
Cabinet.setSize(630,410);
Cabinet.showCenter();
}

function SetActive(Value)
{  // Fonction appelee lors d'un click de selection
	RadioSelected=Value;
}

function GetActive()
{  // Lire la ligne cochee
	return RadioSelected;
}

function AddCabinet()
{
	val = prompt('Nom du dossier','Nouveau_dossier');
	if(val) 
	{
		URL  = '/components/Cabinet/Cabinet.php?'; 
		URL += 'Option=AddCabinet&cabid='+GetActive()+"&Val="+urlencode(val);
		Msg = wget(URL);
		if( Msg.length > 2 )
			status_write(Msg);
		else
			document.location.reload();
	}
}

function QuitCabinet()
{
Cabinet.hide();
document.getElementById('overlay_modal').style.display = 'none';
}

function SelectCabinet()
{
ID = GetActive();
if( ID == -1 )
	return;
document.getElementById('Up_cabid').value = ID;
document.getElementById('Up_box').value = wget("/components/Cabinet/Cabinet.php?Option=GetCabinetString&cabid="+ID);
Cabinet.hide();
document.getElementById('overlay_modal').style.display = 'none';
}


/************
 * /Cabinet *
 **********************************************
 *                                            *
 * Ouvre la fenêtre de selection d'un contact *
 *   et fonctions de contact                  *
 **********************************************/
function DisplayContacts()
{
URL = '/components/Contact/Contact.php?Option=ListContacts';

// Fondre le fond
document.getElementById('overlay_modal').style.display = 'block';
// Fenetre popup
if( typeof(Contacts) != 'object' )
	{
	Contacts = new Window('Contacts',{className: "bluelighting", closable:false, resizable:false,
			maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
	}

Contacts.setZIndex(30);
Contacts.setOpacity(1);
// Appeler la page
Contacts.setAjaxContent(URL);
Contacts.setTitle('Choisir un exp&eacute;diteur');
Contacts.setSize(380,330);
Contacts.showCenter();
}

function SaveSender(ConId, Msg)
{
document.getElementById('Up_conid').value=ConId;
document.getElementById('Up_Sender').value=Msg;
Contacts.hide();
document.getElementById('overlay_modal').style.display = 'none';
}

function AddContact()
{
URL = '/components/Contact/Contact.php?Option=EditContact&conid=-1';

if( typeof(AddContact) != 'object' )
	{
	AddContact = new Window('AddContact',{className: "bluelighting", closable:false, resizable:false,
        		maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
	}
AddContact.setZIndex(10);
AddContact.setOpacity(1);
AddContact.setAjaxContent(URL);
AddContact.setTitle('Ajouter un contact');
AddContact.setSize(420,330);
AddContact.showCenter();
// Fondre le fond
Contacts.setOpacity(0.6);
return false;
}

function AbortContact()
{
Contacts.hide();
document.getElementById('overlay_modal').style.display = 'none';
}

function CloseEditContact()
{
AddContact.hide();
Contacts.setOpacity(1);
}

function SaveContact()
{  // Sauve données
MyForm = document.getElementById('EditContact');

if(		document.getElementById('name').value=="" ||
			document.getElementById('given_name').value=="" ||
			document.getElementById('address1').value=="" ||
			document.getElementById('zip').value=="" ||
			document.getElementById('city').value=="") 
  alert("Certains champs sont vides. Vous devez saisir tous les champs obligatoires. \n(Champs obligatoires: Nom, Prénom, Adresse, CP, Ville");
else
  {
	MyForm = document.getElementById('EditContact');
	URL = '/components/Contact/Contact.php?Option=Save'; 
		
  // Construire l'URL
	string='';
	for( i=0 ; i < MyForm.length ; i++)
		{ // Parcourir tous les champs
		if( MyForm.elements[i].conid != '-1' )
			{
			//alert(MyForm.elements[i].name + '=' +MyForm.elements[i].type);
			switch( MyForm.elements[i].name )
				{
				/*      // Champs à ne pas transférer
        break;
				 */
				case 'conid':
				case 'company':
				case 'name':
				case 'given_name':
				case 'email':
				case 'phone':
				case 'address1':
				case 'address2':
				case 'zip':
				case 'city':
					if( MyForm.elements[i].value.length > 0 )
						URL += '&' + MyForm.elements[i].name + '=' + urlencode(htmlentities(MyForm.elements[i].value));
					break;
				case 'genre':
					if( MyForm.elements[i].checked )
						URL += '&' + MyForm.elements[i].name + '=' + MyForm.elements[i].value;
					break;

				default:
					alert(MyForm.elements[i].name);
				break;
				} // switch
			}  // if
		} // for i
  //	appel au serveur
	status_write(wget(URL));
  //	Cacher le popup et recharger les données
  AddContact.hide();
  Contacts.setOpacity(1);
  Contacts.setAjaxContent('/components/Contact/Contact.php?Option=ListContacts');
	}
}

/************
 * Contacts *
 ************/ 

