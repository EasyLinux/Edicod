//Variables
var win, EditFileWin;

function SetFolderActive(Value)
{  // Fonction appelee lors d'un click de selection
	RadioSelected=Value;
	URL  = '/components/DocFolders/DocFolders.php?'; 
	URL += 'Option=GetFiles&Id='+Value;

	innerHTML = wget(URL);
	document.getElementById('List').innerHTML = innerHTML;
}

function GetFolderActive()
{  // Lire la ligne cochee
	return RadioSelected;
}

function Add()
{
val = prompt('Nom du dossier','Nouveau_dossier');
//seulement si on clique sur ok
if(val)
	{
	URL  = '/components/DocFolders/DocFolders.php?'; 
	URL += 'Option=AddFolder&Id='+GetFolderActive()+"&Val="+urlencode(val);
	Msg = wget(URL);		
	if( Msg.length > 2 )
		status_write(Msg);
	else
		document.location.reload();
	}
}

function Del()
{
if( RadioSelected == -1 )
	{
	alert('Vous devez choisir un dossier !');
	return( false );
	}
if(confirm("Voulez-vous vraiment supprimer ce dossier ?")) 
  {
//		A partir de l'URL retrouver le composant appelé
	URL  = '/components/DocFolders/DocFolders.php?'; 
	URL += 'Option=DelFolder&Id='+GetFolderActive();
	Msg = wget(URL);
	if( Msg.length > 2 )
		status_write(Msg);
	else
		document.location.reload();
	}
}

function Rename()
{
	if( RadioSelected == -1 )
	{
		alert('Vous devez choisir un dossier !');
		return( false );
	}

	URL  = '/components/DocFolders/DocFolders.php?'; 
	URL += 'Option=GetLabel&Id='+GetFolderActive();
	Label = wget(URL);
	NewLabel = prompt('Nom du dossier',Label);

	if(NewLabel)
	{
		URL  = '/components/DocFolders/DocFolders.php?'; 
		URL += 'Option=RenFolder&Id='+GetFolderActive()+"&Val="+urlencode(NewLabel);
		Msg = wget(URL);

		if( Msg.length > 2 )
			status_write(Msg);
		else
			document.location.reload();
	}
}



/************************ 
 * Affichage du fichier *
 ************************/
function Preview(File)
{
	window.open(File, 'Apercu', '');
}

function DFQuit()
{
	document.location="/index.php";
}
