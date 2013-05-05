/**
 * Folder.js
 *
 *   fonctions javascript liées à Folders.php
 *
 * @package		Composants
 * @subpackage		Folders
 * @access		public
 * @version		1.2
 * @author              Serge NOEL
 */

/**
 *  Positionne la variable globale lors de la sélection d'un répertoire
 *
 * @parameter  string	Chemin sélectionné
 */
function SetActive(Value)
{  // Fonction appelee lors d'un click de selection
	RadioSelected=Value;
}

/**
 * Retourne le chemin sélectionné
 *
 * @param	void
 * @return	chaine	valeur en cours de sélection
 */
function GetActive()
{  // Lire la ligne cochee
	return RadioSelected;
}

/**
 *
 * Remplace dans la chaîne str les caractères de from par ceux de to.<br/>
 *  cf fonction php
 *
 * @param	chaine	str: chaine ou le remplacement doit être fait
 * @param	chaine	from: chaine contenant les caractères à chercher
 * @param	chaine 	to: chaine contenant les caractères de remplacement
 * @return	chaine  Nouvelle chaine
 */
function strtr( str, from, to)
{
	var fr='',i=0,j=0,lenStr=0,lenFrom=0,tmpStrictForIn=false, fromTypeStr='',toTypeStr='',istr='';
	var tmpFrom = [];
	var tmpTo = [];
	var ret='';
	var match=false;

	lenStr = str.length;
	lenFrom = from.length;
	fromTypeStr = typeof from === 'string';
	toTypeStr = typeof to === 'string';

	for(i=0 ; i<lenStr ; i++)
	{  // parcourrir tous les caractères de la chaine
		match = false;
		istr = str.charAt(i);
		for( j=0 ; j< lenFrom; j++)
		{
			// Si le caractère fait partie des caractères à modifier
			if( istr == from.charAt(j))
			{
				match = true;
				break;
			}
		}
		if(match)
			ret += to.charAt(j);
		else
			ret += str.charAt(i);
	}
	return ret;
}

/**
 * Ajoute un répertoire dans le chemin courant
 *  . Cette fonction supprime les accents
 *
 * @param	void
 * @return	void
 */
function AddPath()
{
//	Chemin actuel
	if( RadioSelected.length == 0 )
	{
		alert('Vous devez choisir un repertoire racine');
		return( false );
	}
	val = prompt('Nom du repertoire','Nouveau_dossier');
	if(val == null )
		return;
//	supprime les caractères accentués
	val = strtr(val,"âàéèêëùôç'","aaeeeeuoc'");

//	A partir de l'URL retrouver le composant appelé
	URL  = '/components/Folders/Folders.php?';
	URL += 'Option=AddPath&Path='+urlencode(GetActive()+'/'+val);
	Msg = wget(URL);
	if( Msg.length > 2 )
		status_write(Msg);
	else
		document.location.reload();
}

/**
 * Supprime le chemin sélectionné
 *
 * @param	void
 * @return	void
 */
function DelPath()
{
	if( RadioSelected.length == 0 )
	{
		alert('Vous devez choisir un repertoire');
		return( false );
	}
	if( GetActive() == RootPath)
	{
		alert('Vous ne pouvez supprimer ce repertoire !');
		return( false );
	}
//	A partir de l'URL retrouver le composant appelé
	URL  = '/components/Folders/Folders.php?';
	URL += 'Option=DelFolder&Path='+urlencode(GetActive());
	Msg = wget(URL);
	if( Msg.length > 2 )
		status_write(Msg);
	else
		document.location.reload();
}

/**
 * Ferme le popup
 *
 * @param	void
 * @return	void
 */
function QuitPath()
{
	document.location="/index.php";
}

/**
 * Renomme le répertoire
 *
 */
function RenPath()
{
	val = prompt('Nom du repertoire',GetActive());
//	supprime les caractères accentués
	val = strtr(val,"âàéèêëùôç'","aaeeeeuoc'");
	URL  = '/components/Folders/Folders.php?';
	URL += 'Option=RenFolder&OldPath='+urlencode(GetActive())+'&NewPath='+urlencode(val);
	Msg = wget(URL);
	document.location.reload();
}
