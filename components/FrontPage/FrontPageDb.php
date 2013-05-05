<?php
/**
 * Gestion de la base pour la page d'accueil.
 *   Ce composant fait partie du Framework de l'application. Il affiche la page d'accueil.
 *
 * @package		Edicod
 * @subpackage		Framework
 * @version		1.2
 * @author              Serge NOEL
 * @todo		Documenter le code
 * @todo  		Permettre la gestion des utilisateurs en copie
 */


/**
 *  Liste les documents qui viennent d'arriver
 *    Onglet 'A affecter'
 * @param	objet		Base de données
 * @param 	string		Chaine utilisateur et groupes de l'utilisateur courant
 * @return      string		objet sur le SELECT de la table
 */
function MakeDispatchList($Db)
{
	$Guids = $_SESSION["User"]["Guids"];
	// Construction de la requete SQL, recherche de tous les documents disponibles a l'utilisateur donné,
	//  à ce niveau, un workflow par défaut (en fonction du répertoire) a été affecté par la tâche de fond Cron/ReadFiles.php
	$Sql  = "SELECT wfd.wfsid, wfd.guid, wfd.col, doc.wfsid, doc.name, doc.did, doc.date_in, doc.date_due ";
	$Sql .= "   FROM wf_details AS wfd, documents AS doc ";
	$Sql .= "   WHERE wfd.wfsid = doc.wfsid ";
	$Sql .= "   AND col=0 AND $Guids;";
	$Db->Query($Sql);
	return( $Db->loadObjectList() );
}

/**
 *  Crée et accède à une table temporaire des documents en attente.
 *    Onglet 'En attente'
 * @param	objet		Base de données
 * @param 	integer		Groupes de l'utilisateur
 * @return      string		objet sur le SELECT de la table
 * @todo        Ajouter clause OR pour document en copie
 *  SELECT * FROM Wfd, Wfs, Doc, Copie
 *    WHERE (wfs <-> Guid) OR (copie <-> uid)
 */
function MakeIncomingList($Db)
{
	$Guids = $_SESSION["User"]["Guids"];
	// Construction de la requete SQL, recherche de tous les documents à traiter par l'utilisateur donné
	//   Explications : le max est présent car un même utilisateur peut à la fois être présent en lecture et attente !!!!!!!!!!!!!!!!!!!!!!!!!!

	$Sql  = "SELECT wfd.wfsid, wfd.guid, MAX(wfd.col) AS ReelCol, wfs.description AS Action, doc.wfsid, doc.name, doc.object, doc.did, doc.date_in, doc.date_due, wf.name ";
	$Sql .= "   FROM wf_details AS wfd, documents AS doc, wf_steps AS wfs, workflow AS wf ";
	$Sql .= "   WHERE wfd.wfsid = doc.wfsid ";
	$Sql .= "   AND wfd.wfsid = wfs.wfsid ";
	$Sql .= "   AND wf.wid = wfs.wid ";
	$Sql .= "   AND $Guids";
	$Sql .= "   GROUP BY did";
	$Sql .= "   HAVING ReelCol=1;";
	$Db->Query($Sql);
	return( $Db->loadObjectList() );
}


/**
 *  Crée et accède à une table temporaire des documents à traiter.
 *    Onglet 'A traiter'
 * @param	objet		Base de données
 * @param 	integer		Groupes de l'utilisateur
 * @return      string		objet sur le SELECT de la table
 */
function MakeWaitingList($Db)
{
	$Guids = $_SESSION["User"]["Guids"];
	$Sql  = "SELECT wfd.wfsid, wfd.guid, MAX(wfd.col) AS ReelCol, wfs.description AS Action, doc.wfsid, doc.object, doc.did, doc.date_due, doc.date_in, wfs.wfsid, wf.name ";
	$Sql .= "   FROM wf_details AS wfd, documents AS doc, wf_steps AS wfs, workflow AS wf ";
	$Sql .= "   WHERE wfd.wfsid = doc.wfsid ";
	$Sql .= "   AND wfd.wfsid = wfs.wfsid ";
	$Sql .= "   AND wf.wid = wfs.wid ";
	$Sql .= "   AND $Guids";
	$Sql .= "   GROUP BY doc.did";
	$Sql .= "   HAVING ReelCol=2 ;";

	$Db->Query($Sql);
	$Reps = $Db->loadObjectList();
	return( $Reps);
}

/**
 *  Crée et accède à une table temporaire des documents historiques.
 *    Onglet 'Historique'
 * @param	objet		Base de données
 * @param	timestamp	date de départ
 * @param 	integer		Groupes de l'utilisateur
 * @return      string		objet sur le SELECT de la table
 */
function MakeHistoryList($Db, $Start)
{
	$Guids = $_SESSION["User"]["Guids"];
	$Sql  = "SELECT wfd.wfsid, wfd.guid, MAX(wfd.col) AS ReelCol, wfs.description AS Action, doc.wfsid, doc.object, doc.did, doc.date_in, doc.date_out, wfs.wfsid, wf.name ";
	$Sql .= "   FROM wf_details AS wfd, documents AS doc, wf_steps AS wfs, workflow AS wf ";
	$Sql .= "   WHERE wfd.wfsid = doc.wfsid ";
	$Sql .= "   AND wfd.wfsid = wfs.wfsid ";
	$Sql .= "   AND doc.date_out >= '$Start' ";
	$Sql .= "   AND wf.wid = wfs.wid ";
	$Sql .= "   AND $Guids";
	$Sql .= "   GROUP BY doc.did";
	$Sql .= "   HAVING ReelCol=3 ;";
	//print $Sql;

	$Db->Query($Sql);
	$Reps = $Db->loadObjectList();
	return( $Reps);
}

function GetDefaultCabinetId($Db) 
{
return $_SESSION["Parameters"]["DefaultCabinet"];
}

function GetDefaultCabinetName($Db)
{
$CabId = $_SESSION["Parameters"]["DefaultCabinet"];

$Sql = "SELECT * FROM cabinet WHERE cabid=$CabId ;";
$Db->Query($Sql);
$Row = $Db->loadObject();

return $Row->label;
}

/**
 * Retourne le groupe/user qui peut changer l'étape
 *
 * @param	objet		Base de données
 * @param	entier		wfsid (id de l'étape en cours)
 * @return      objet		Ligne de la table document
 */
function GetStepActor($Db,$Id)
{
	$Sql = "SELECT * FROM wf_details WHERE wfsid=$Id AND actor=1;";
	$Db->Query($Sql);
	$Rep = $Db->loadObject();
	$Guid = $Rep->guid;
	if( substr($Guid,0,1) == "G" )
	{
		$Gid = substr($Guid,1);
		$Sql = "SELECT * FROM groups WHERE gid=$Gid ;";
		$Db->Query($Sql);
		$Rep = $Db->loadObject();
		$Actor = $Rep->name;
	}
	else
	{
		$Uid = substr($Guid,1);
		$Sql = "SELECT * FROM user WHERE uid=$Uid ;";
		$Db->Query($Sql);
		$Rep = $Db->loadObject();
		$Actor = $Rep->login;
	}
	return( $Actor );
}

/**
 * Retourne un document désigné par son id
 *
 * @param	objet		Base de données
 * @param	entier		Identifiant unique
 * @return      objet		Ligne de la table document
 */
function GetDocument($Db, $Did)
{
	$Sql = "SELECT * FROM documents WHERE did=$Did";
	$Db->Query($Sql);
	// Retourne une seule ligne car did est unique !
	return( $Db->loadObject() );
}

function GetParameter($Db, $id)
{
	$Sql = "SELECT * FROM parameters where id=$id";
	$Db->Query($Sql);
	// Retourne une seule ligne car id est unique !
	return( $Db->loadObject() );
}

function GetContacts($Db, $ConId)
{
	$Html = "";
	$query = "SELECT * FROM contact WHERE valid=1 ORDER BY company, name, given_name";
	$Db->Query($query);
	$Reps = $Db->loadObjectList();
	foreach($Reps as $Rep)
	{
		$Select = "";
		if( $Rep->conid == $ConId )
			$Select = " selected='selected'";
		$Html .= "            <option value='". $Rep->conid ."'$Select>". $Rep->company . " ". $Rep->name ." ". $Rep->given_name ."</option>\n";
	}
	return( $Html );
}

function GetContactValue($Db, $ConId)
{
	$query = "SELECT * FROM contact WHERE conid=$ConId ORDER BY company, name, given_name";
	$Db->Query($query);
	$Rep = $Db->loadObject();

	return($Rep->name." ".$Rep->given_name);
}

function GetActions($Db, $Id, $Indent)
{
	$Html="";
	$query = "SELECT * FROM docAction ORDER BY docAction;";
	$Db->Query($query);
	$Reps = $Db->loadObjectList();
	foreach( $Reps as $Rep)
	{
		$Select = "";
		if( $Rep->daid == $Id )
			$Select = " selected='selected'";
		$Html .= "$Indent<option value='". $Rep->daid ."'$Select>".$Rep->docAction."</option>\n";
	}
	return( $Html );

}


/**
 * Retourne un contact désigné par son id
 *
 * @param	objet		Base de données
 * @param	entier		Identifiant unique
 * @return      objet		Ligne de la table document
 */
function GetContact($Db, $Id)
{
	$query = "SELECT * FROM contact WHERE id=$Id";
	$Db->Query($query);
	return( $Db->loadObject() );
}


/**
 *  Liste les workflows accessibles à un utilisateur donné
 *        Les workflows de dispatch ne sont pas affichés car ils n'ont pas d'utilité
 *
 * @param	objet		Base de données
 * @param 	string		Indentation (pour faciliter la lecture des sources générées)
 * @return      string		options disponible (HTML)
 */
function GetWorkFlows($Db, $Indent,$WfsId)
{
	$Html = "";
	$Wid=0;
	if( $WfsId != -1 )
	{
		$Sql = "SELECT * FROM wf_steps WHERE wfsid=$WfsId ;";
		$Db->Query($Sql);
		$Wid = $Db->loadObject()->wid;
	}
	$Sql = "SELECT * FROM workflow;";
	$Db->Query($Sql);
	$Reps = $Db->loadObjectList();
	foreach($Reps as $Rep)
	{
		$Select="";
		if( $Wid == $Rep->wid )
			$Select = "selected='selected'";
		$Html .= $Indent . "<option value='" . $Rep->wid . "' $Select>" . $Rep->name . "</option>\n";
	}
	return( $Html );
}

/**
 *  Retrouve le workflow lié à une étape
 *
 * @param	objet		Base de données
 * @param 	string		Id de l'étape
 * @return      string		label
 */
function GetWorkFlow($Db, $Id)
{
	$Sql  = "SELECT wf.name, wf.wid, wfs.wid, wfs.wfsid FROM workflow AS wf, wf_steps AS wfs ";
	$Sql .= "     WHERE wfs.wid=wf.wid AND wfs.wfsid=$Id ;";
	$Db->Query($Sql);
	$Rep  = $Db->loadObject();
	return( $Rep->name );
}

/**
 *  Retrouve les étapes du workflow lié à une étape
 *
 * @param	objet		Base de données
 * @param 	string		Id de l'étape
 * @return      objet		Etapes du workflow
 */
function GetWorkFlowList($Db, $Id)
{
	// A partir de l'étape en cours, nous cherchons le workflow correspondant
	$Sql  = "SELECT wf.name, wf.wid, wfs.wid, wfs.wfsid FROM workflow AS wf, wf_steps AS wfs ";
	$Sql .= "     WHERE wfs.wid=wf.wid AND wfs.wfsid=$Id ;";
	$Db->Query($Sql);
	$Rep  = $Db->loadObject();
	$Wid = $Rep->wid;
	// Nous listons toutes les étapes du workflow
	$Sql = "SELECT wfsid, wid, myorder, description FROM wf_steps WHERE wid=$Wid ORDER BY myorder";
	$Db->Query($Sql);
	$Rep  = $Db->loadObjectList();
	return( $Rep );
}

/**
 *  Retrouve le nom d'une étape
 *
 * @param	objet		Base de données
 * @param 	string		Id de l'étape
 * @return      string		label
 */
function GetWorkFlowStepName($Db, $Id)
{
	$Sql  = "SELECT wid, wfsid, description FROM wf_steps";
	$Sql .= "     WHERE wfsid=$Id ;";
	$Db->Query($Sql);
	$Rep  = $Db->loadObject();
	return( $Rep->description );
}

/**
 *  Retrouve l'id de l'étape suivante
 *
 * @param	objet		Base de données
 * @param 	string		Id de l'étape courante
 * @return      string		label
 */
function GetNextWorkFlowStep($Db, $Id)
{
	// A partir de l'étape en cours, nous cherchons le workflow correspondant
	$Sql  = "SELECT wf.name, wf.wid, wfs.wid, wfs.wfsid FROM workflow AS wf, wf_steps AS wfs ";
	$Sql .= "     WHERE wfs.wid=wf.wid AND wfs.wfsid=$Id ;";
	$Db->Query($Sql);
	$Rep  = $Db->loadObject();
	$Wid = $Rep->wid;

	$Sql  = "SELECT wid, wfsid, description FROM wf_steps ";
	$Sql .= "     WHERE wid=$Wid";
	$Sql .= "     ORDER BY myorder;";
	$Db->Query($Sql);
	$Reps  = $Db->loadObjectList();
	$Next == false;
	foreach($Reps as $Rep)
	{
		if( $Next )
			return($Rep->wfsid);
		if( $Rep->wfsid == $Id )
			$Next=true;
	}
	return( -1 );
}

/**
 *  Détermine si l'étape en cours est la dernière
 *
 * @param 	string		Id de l'étape courante
 * @return      booléen		vrai si l'étape est la dernière
 */
function IsLastStep($Db,$Id)
{
	// A partir de l'étape en cours, nous cherchons le workflow correspondant
	$Sql  = "SELECT wf.name, wf.wid, wfs.wid, wfs.wfsid FROM workflow AS wf, wf_steps AS wfs ";
	$Sql .= "     WHERE wfs.wid=wf.wid AND wfs.wfsid=$Id ;";
	$Db->Query($Sql);
	$Rep  = $Db->loadObject();
	$Wid = $Rep->wid;

	$Sql  = "SELECT wid, wfsid, description FROM wf_steps ";
	$Sql .= "     WHERE wid=$Wid";
	$Sql .= "     ORDER BY myorder DESC;";
	$Db->Query($Sql);
	$Rep  = $Db->loadObject();
	$WfsId = $Rep->wfsid;

	if( $WfsId == $Id) {
		$Retour=true;
	}
	else {
		$Retour=false;
	}

	return( $Retour );
}

function GetFolders($Db)
{
	$query = "SELECT * FROM folders ORDER BY label";
	$Db->Query($query);
	return( $Db->loadObjectList() );
}

function GetNotes($Db, $Did)
{
	$Sql = "SELECT * FROM docnote, user WHERE user.uid = docnote.uid AND did=$Did;";
	$Db->Query($Sql);
	return( $Db->loadObjectList() );
}

function GetLogs($Db, $Did)
{
	$Sql = "SELECT * FROM doclog, user WHERE user.uid = doclog.uid AND did=$Did ORDER BY timestamp DESC;";
	$Db->Query($Sql);
	return( $Db->loadObjectList() );
}

/**
 * Cette fonction récupère les mots clés saisis dans la fiche suiveuse
 *   <b>NB</b> Seuls les mots clés qui ont été retenu sont réaffichés et dans leur format de stockage
 *   (en minuscule et sans accents)
 *
 * @parameter	objet		Objet base de données
 * @parameter   int		Identifiant document
 * @return      chaine		Liste des mots séparés par un espace
 */
function GetKeyWords($Db, $Did)
{
	$sKeys = "";
	$Sql = "SELECT * FROM dockeywords as dk, keywords as kw WHERE dk.did=$Did AND dk.wichparts=2 AND dk.kid = kw.kid;";
	$Db->Query($Sql);
	$KeyWords = $Db->loadObjectList();
	foreach( $KeyWords as $KeyWord )
		$sKeys .= $KeyWord->keyword." ";
		
	return( $sKeys );
}

function GetDocFolders($Db, $Did)
{
	$Html = "";
	$Sql = "SELECT * FROM docfolders WHERE did=$Did;";
	$Db->Query($Sql);
	$Reps = $Db->loadObjectList();

	$NameDefaultFolder = "Global (par defaut)";

	//si pas de dossier virtuel attribué, on en met un par défaut
	if($Reps == null) {
		//on fait une recherche si le dossier virtuel "par defaut" existe
		$Sql = "SELECT * FROM folders WHERE label='$NameDefaultFolder'";
		$Db->Query($Sql);
		$RowFolder = $Db->loadObject();
		 
		if($RowFolder == null) {
			//si le dossier virtuel n'éxiste pas => on le créé
			$Sql = "INSERT INTO folders SET parent='0', label='$NameDefaultFolder' ;";
			$Db->Query($Sql);
			 
			//on extrait le fid du dossier virtuel "par defaut" qui vient d'être créé
			$Sql = "SELECT * FROM folders WHERE label='$NameDefaultFolder' ;";
			$Db->Query($Sql);
			$RowFolderId = $Db->loadObject();
			$Fid = $RowFolderId->fid;
		}
		else {
			//on extrait le fid du dossier virtuel "par defaut" existant
			$Fid = $RowFolder->fid;
		}
		 
		$Html .= "<option value='$Fid'>/$NameDefaultFolder/</option>\n";
		 
		//on ajoute le dossier virtuel
		$Sql = "INSERT INTO docfolders SET fid='$Fid', did=$Did ;";
		$Db->Query($Sql);
	}
	else {
		foreach( $Reps as $Rep)
		{
			$Parent = $Rep->fid;
			$Msg = '';
			while( $Parent )
			{
				$Sql2 = "SELECT * FROM folders WHERE fid=$Parent ;";
				$Db->Query($Sql2);
				$Rep2 = $Db->loadObject();
				$Parent = $Rep2->parent;
				$Msg = $Rep2->label . "/" . $Msg;
			}
			$Html .= "        <option value='". $Rep->fid ."'>/$Msg</option>\n";
			 
		}
	}

	//echo htmlentities($Html) ;

	return( $Html );
}

/**
 * Affiche une chaine représentant le classement
 *
 * @param		object		Base de données
 * @param		int		Id
 */
function GetCabinetString($Db,$Id)
{
	global $uniqueid;
	$Ret = "";
	$Chemin = array();

	$i=0;
	$Ok = true;
	while( $Ok )
	{
		$Sql = "SELECT * FROM cabinet WHERE cabid=$Id;";
		$Db->Query($Sql);
		$Rep = $Db->loadObject();
		$Id = $Rep->parent;
		$Chemin[$i] = $Rep->label;
		$i++;
		if( $Id == 0 )
		$Ok = false;
	}
	$i--;
	for( $j=$i ; $j> 0 ; $j-- )
		$Ret .= html_entity_decode($Chemin[$j],ENT_QUOTES,"UTF-8") . " -> ";
	$Ret .= html_entity_decode($Chemin[$j],ENT_QUOTES,"UTF-8");
	return $Ret;
}

/**
 * Affiche une chaine représentant l'étape en cours
 *
 * @param		object		Base de données
 * @param		int		WfsId
 * @return
 */
function GetWfStep($Db, $WfsId)
{
	$Sql = "SELECT * FROM wf_steps WHERE wfsid=$WfsId ;";
	$Db->Query($Sql);
	$Rep = $Db->loadObject();
	return( $Rep->description );
}

/**
 *  Liste les étapes accessibles à un utilisateur donné
 *
 * @param	objet		Base de données
 * @param 	string		Indentation (pour faciliter la lecture des sources générées)
 * @return      string		options disponible (HTML)
 */
function GetWfSteps($Db, $Indent,$WfsId)
{
	$Html = "";

	// Cherchons le workflow associé
	$Sql  = "SELECT * FROM wf_steps WHERE wfsid=$WfsId ;";
	$Db->Query($Sql);
	$Wid = $Db->loadObject()->wid;

	$Sql = "SELECT * FROM wf_steps WHERE wid=$Wid ORDER BY myorder;";
	$Db->Query($Sql);
	$Reps = $Db->loadObjectList();
	foreach( $Reps as $Rep)
	{
		$Select = "";
		if( $Rep->wfsid == $WfsId )
			$Select = "selected='selected'";
		$Html .= $Indent . "<option value='". $Rep->wfsid ."' $Select>". $Rep->description ."</option>\n";
	}

	return( $Html );
}

/**
 * Renvoi vrai si l'utilisateur peut modifier l'étape en cours
 *
 * @param		object		Base de données
 * @param		int		WfsId
 * @param
 * @return		int
 */
function GetStepRights($Db, $WfsId, $Guids)
{
	$Sql  = "SELECT * FROM wf_steps, wf_details";
	$Sql .= "      WHERE wf_steps.wfsid = wf_details.wfsid";
	$Sql .= "      AND wf_steps.wfsid = $WfsId";
	$Sql .= "      AND wf_details.actor = 1";
	$Sql .= "      AND $Guids ;";
	$Db->Query($Sql);
	return $Db->NumRows();
}

/**
 * Retourne les réponses à un document.
 * @param db $Db objet de connexion à la base.
 * @param int $did identifiant du document.
 * @return array liste des réponses sous forme de tableau d'objet.
 */
function GetDocResponses(db $Db, $did)
{
	$Sql = "SELECT * FROM docdraft WHERE did = ".$did;
	$Db->Query($Sql);
	return($Db->loadObjectList());
}


/**
 * Retourne les pièces jointes d'un document.
 * @param db $Db objet de connexion à la base.
 * @param int $did identifiant du document.
 * @return array liste des réponses sous forme de tableau d'objet.
 */
function GetDocFileAttach(db $Db, $did)
{
	$Sql = "SELECT * FROM docattach, documents WHERE docattach.did=$did AND docattach.did_docattach=documents.did;";
	$Db->Query($Sql);
	return($Db->loadObjectList());
}
?>
