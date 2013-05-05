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

function DelCabinet()
{
	if( RadioSelected == -1 )
	{
		alert('Vous devez choisir un dossier !');
		return( false );
	}
	
	if(confirm("Voulez-vous vraiment supprimer ce dossier ?")) {
//	A partir de l'URL retrouver le composant appelé
	URL  = '/components/Cabinet/Cabinet.php?'; 
	URL += 'Option=DelCabinet&cabid='+GetActive();
	Msg = wget(URL);
	if( Msg.length > 2 )
		status_write(Msg);
	else
		document.location.reload();
	}
}

function RenameCabinet()
{
	if( RadioSelected == -1 )
	{
		alert('Vous devez choisir un dossier !');
		return( false );
	}
	URL  = '/components/Cabinet/Cabinet.php?'; 
	URL += 'Option=GetLabel&cabid='+GetActive();
	Label = wget(URL);
	NewLabel = prompt('Nom du dossier',Label);
	if(NewLabel)
	{
		URL  = '/components/Cabinet/Cabinet.php?'; 
		URL += 'Option=RenCabinet&cabid='+GetActive()+"&Val="+urlencode(NewLabel);
		Msg = wget(URL);
		if( Msg.length > 2 )
			status_write(Msg);
		else
			document.location.reload();
	}
}

function QuitCabinet()
{
	document.location="/index.php";
}

