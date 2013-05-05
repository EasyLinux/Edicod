<?php
/**
 * Affiche les listes de documents de la page d'accueil.
 *   Ce composant fait partie du Framework de l'application. Il affiche la page d'accueil.
 *
 * @package		Edicod
 * @subpackage		Framework
 * @version		1.2
 * @author              Serge NOEL
 */

/**
 * Liste les documents à affecter.
 *   Contenu de l'onglet 'A affecter'
 *   Cette liste n'apparait que si l'utilisateur est un 'dispatcheur'
 *
 * @return	string		Code HTML contenant les fichiers
 */
function ListDispatchDocs($Db)
{
	global $NumFiles, $NumFilOk, $NumFilWarn, $NumFilAtt;
	$Or = "";
	$List =  "<!-- Documents a affecter -->
            <div class='fpLineDiv' style='width: 80px'><b>Date arriv&eacute;e</b></div>
            <div class='fpLineDiv' style='width: 308px;'><b>Objet</b></div>
            <div style='overflow-y: scroll; width: 520px;height: 290px'>\n";

	// Recherche de tous les documents entrants disponibles a l'utilisateur donné,
	$Rows = MakeDispatchList($Db);

	$ColorBackgroundLine = "style='background:#AFCBEF;'";
	
	foreach( $Rows as $Row)
	{
		$fdate = Date_US_To_FR($Row->date_in);

		// Calcul du nombre de jours restant
		$Now = mktime(0,0,0);
		$DDue = mktime(0,0,0,substr($Row->date_due,5,2),substr($Row->date_due,8,2),substr($Row->date_due,0,4));
		$Delta = ($DDue - $Now)/86400;
		if( $Delta > $_SESSION['Parameters']['WarningTime'] )
		{
			$Couleur = "<span style='color: Green'>";
			$NumFilOk++;
		}
		elseif( $Delta > $_SESSION['Parameters']['ErrorTime'] )
		{
			$Couleur = "<span style='color: Orange;'>";
			$NumFilWarn++;
		}
		else
		{
			$Couleur = "<span style='color: Red;'>";
			$NumFilAtt++;
		}
		 
		$List .= "              <div class='fpLineDivGeneral' $ColorBackgroundLine> <a class='fp' href='#' onClick='AllocateFile(" . $Row->did . ");'>\n";
		$List .= "                	<div class='fpLineDiv' style='width: 80px'>$fdate</div>\n";
		$List .= "                	<div class='fpLineDiv' style='width: 420px'>$Couleur".utf8_encode($Row->name)."</span></div></a>";
		$List .= "					<div class='cleaner' style='clear:both;'></div>\n";
		$List .= "				</div>";
		//$List .= "			<div class='cleaner' style='clear:both;'></div>";
		$NumFiles++;
		
		if($ColorBackgroundLine == "style='background:#AFCBEF;'") {
			$ColorBackgroundLine = "style='background:#C1D2EF;'";
		}
		else {
			$ColorBackgroundLine = "style='background:#AFCBEF;'";
		}
	}
	$List .= "            </div>\n";
	return $List;
}


/**
 *  Retrouve et affiche la liste des documents entrants.
 *    Onglet 'Courriers entrants'
 *
 * @param	objet		Base de données
 * @param 	integer		Identifiant utilisateur
 * @return      string		Code HTML contenant la liste formattée
 */
function ListIncomingDocs($Db, $Uid) /* onglet pour information */
{
	global $ToDeal, $ToDealOk, $ToDealWarn, $ToDealAtt;
	$List = "";

	$Reps = array();
	$Reps = MakeIncomingList($Db);
	/*echo "<pre>";
	print_r($Reps);
	echo "</pre>";*/
	
	$Now = time();
	$UnJour = 24*60*60;

	$List .= "      <div class='fpLineDiv' style='width: 80px'><b>Date entr&eacute;e</b></div>
	  <div class='fpLineDiv' style='width: 80px;'><b>Workflow</b></div>
      <div class='fpLineDiv' style='width: 120px;'><b>Etape</b></div>
      <div class='fpLineDiv' style='width: 200px;'><b>Objet</b></div>
      <div style='overflow-y: scroll; width: 520px;height: 290px'>\n";
	
	$ColorBackgroundLine = "style='background:#AFCBEF;'";

	foreach($Reps as $Rep)
	{
		$ldate = substr($Rep->date_in,8,2) . "/" . substr($Rep->date_in,5,2) . "/" . substr($Rep->date_in,0,4);
		$ddate = substr($Rep->date_due,8,2) . "/" . substr($Rep->date_due,5,2) . "/" . substr($Rep->date_due,0,4);
		$DueDate = strtotime($Rep->date_due);
		$LeftDays = $DueDate - $Now;
		$Resp = GetStepActor($Db,$Rep->wfsid);

		$Couleur = "<span style='color: Green;'>";
		if( $LeftDays > ($_SESSION['Parameters']['WarningTime'] * $UnJour) )
		{
			$Couleur = "<span style='color: Green;'>";
			$ToDealOk++;
		}
		elseif ( $LeftDays > $_SESSION['Parameters']['ErrorTime'])
		{
			$Couleur = "<span style='color: Orange;'>";
			$ToDealWarn++;
		}
		else
		{
			$Couleur = "<span style='color: Red'>";
			$ToDealAtt++;
		}

		$List .= "          <div class='fpLineDivGeneral' $ColorBackgroundLine> <a class='fp' href='#' onClick='EditFile(\"".$Rep->did."\");'>$Couleur";
		$List .= "            <div class='fpLineDiv' style='width: 80px'>$ldate</div>\n";
		$List .= "            <div class='fpLineDiv' style='width: 80px'>$Rep->name</div>\n";
		$List .= "            <div class='fpLineDiv' style='width: 120px'>".$Rep->Action." (".$Resp.")</div>\n";
		$List .= "            <div class='fpLineDiv' style='width: 200px;overflow-y : hidden'>".$Rep->object."</div></span></a>";
		$List .= "			  <div class='cleaner' style='clear:both;'></div>";
		$List .= "			</div>";
		//$List .= "			<div class='cleaner' style='clear:both;'></div>";

		$ToDeal++;
		
		if($ColorBackgroundLine == "style='background:#AFCBEF;'") {
			$ColorBackgroundLine = "style='background:#C1D2EF;'";
		}
		else {
			$ColorBackgroundLine = "style='background:#AFCBEF;'";
		}
	}
	$List .= "      </div>\n";
	return $List;
}


/**
 *  Retrouve la liste des documents en attente de traitement.
 *
 * @param	objet		Base de données
 * @param 	integer		Identifiant utilisateur
 * @return      string		Code HTML contenant la liste formattée
 */
function ListWaitingDocs($Db, $Uid) /*onglet a traiter */
{
	global $Waiting, $WaitOk, $WaitAtt, $WaitWarn;

	// Construction de la requete SQL, recherche de tous les documents à traiter par l'utilisateur donné
	$Reps = array();
	$Reps = MakeWaitingList($Db);

	$List = "";
	$Now = time();
	$UnJour = 24*60*60;

	$List .= "        
		<div class='fpLineDiv' style='width: 80px'><b>Date entr&eacute;e</b></div>
		<div class='fpLineDiv' style='width: 80px'><b>Date limite</b></div>
		<div class='fpLineDiv' style='width: 120px;'><b>Workflow</b></div>
        <div class='fpLineDiv' style='width: 200px'><b>Objet</b></div>
        <div style='overflow-y: scroll; width: 520px;height: 290px'>\n";

	$ColorBackgroundLine = "style='background:#AFCBEF;'";
	
	foreach($Reps as $Rep)
	{
		$DueDate = strtotime($Rep->date_due);
		$ldate = substr($Rep->date_due,8,2) . "/" . substr($Rep->date_due,5,2) . "/" . substr($Rep->date_due,0,4);
		$LeftDays = $DueDate - $Now;
		$ldateIn = substr($Rep->date_in,8,2) . "/" . substr($Rep->date_in,5,2) . "/" . substr($Rep->date_in,0,4);
		$Resp = GetStepActor($Db,$Rep->wfsid);

		if( $LeftDays > ($_SESSION['Parameters']['WarningTime'] * $UnJour) )
		{
			$Couleur = "<span style='color: Green;'>";
			$WaitOk++;
		}
		elseif( $LeftDays > $_SESSION['Parameters']['ErrorTime'] )
		{
			$Couleur = "<span style='color: Orange;'>";
			$WaitWarn++;
		}
		else
		{
			$Couleur = "<span style='color: Red;'>";
			$WaitAtt++;
		}

		$List .= "      <div class='fpLineDivGeneral' $ColorBackgroundLine> <a class='fp' href='#' onClick='EditFile(\"".$Rep->did."\");'>$Couleur";
		$List .= "           <div class='fpLineDiv' style='width: 80px'>$ldateIn</div>\n";
		$List .= "           <div class='fpLineDiv' style='width: 80px'>$ldate</div>\n";
		$List .= "           <div class='fpLineDiv' style='width: 120px'>$Rep->name</div>\n";
		$List .= "           <div class='fpLineDiv' style='width: 200px;overflow-y : hidden'>".$Rep->object."</div></span></a>"; 
		$List .= "			<div class='cleaner' style='clear:both;'></div>";
		$List .= "		</div>";
		//$List .= "		<div class='cleaner' style='clear:both;'></div>";
		$Waiting++;
		
		if($ColorBackgroundLine == "style='background:#AFCBEF;'") {
			$ColorBackgroundLine = "style='background:#C1D2EF;'";
		}
		else {
			$ColorBackgroundLine = "style='background:#AFCBEF;'";
		}
	}
	$List .= "        </div>\n";
	return $List;
}

/**
 *  Retrouve la liste des documents traités.
 *
 * @param	objet		Base de données
 * @param 	integer		Identifiant utilisateur
 * @return      string		Code HTML contenant la liste formattée
 */
function ListHistoryDocs($Db, $Uid) /* onglet historique */
{

	// Construction de la requete SQL, recherche de tous les documents à traiter par l'utilisateur donné
	$Reps = array();
	$startTime = date("Y-m-d",mktime() - $_SESSION['Parameters']['MaxHistory']*3600*24);

	$Reps = MakeHistoryList($Db, $startTime);

	$List = "        <div class='fpLineDiv' style='width: 80px'><b>Date entr&eacute;e</b></div>
		<div class='fpLineDiv' style='width: 80px;'><b>Workflow</b></div>
        <div class='fpLineDiv' style='width: 120px'><b>Date fin</b></div>
        <div class='fpLineDiv' style='width: 200px'><b>Objet</b></div>
        <div style='overflow-y: scroll; width: 520px;height: 290px'>\n";

	$ColorBackgroundLine = "style='background:#AFCBEF;'";
	
	foreach($Reps as $Rep)
	{
		//$DueIn = strtotime($Rep->date_in);
		$ldateIn = substr($Rep->date_in,8,2) . "/" . substr($Rep->date_in,5,2) . "/" . substr($Rep->date_in,0,4);
		
		$ldateOut = substr($Rep->date_out,8,2) . "/" . substr($Rep->date_out,5,2) . "/" . substr($Rep->date_out,0,4);

		$List .= "			<div class='fpLineDivGeneral' $ColorBackgroundLine> <a class='fp' href='#' onClick='DisplayFile(\"".$Rep->did."\");'>";
		$List .= "              <div class='fpLineDiv' style='width: 80px'>$ldateIn</div>\n";
		$List .= "           	<div class='fpLineDiv' style='width: 80px'>$Rep->name</div>\n";
		//$List .= "            <div class='fpLineDiv' style='width: 180px'>".$Rep->Action."</div>\n";
		$List .= "              <div class='fpLineDiv' style='width: 120px'>$ldateOut</div>\n";
		$List .= "              <div class='fpLineDiv' style='width: 200px;overflow-y : hidden'>".$Rep->object."</div></a>";
		$List .= "			<div class='cleaner' style='clear:both;'></div>";
		$List .= "			</div>";
		//$List .= "			<div class='cleaner' style='clear:both;'></div>";
	
		if($ColorBackgroundLine == "style='background:#AFCBEF;'") {
			$ColorBackgroundLine = "style='background:#C1D2EF;'";
		}
		else {
			$ColorBackgroundLine = "style='background:#AFCBEF;'";
		}
	}
	$List .= "        </div>\n";
	return $List;
}


?>
