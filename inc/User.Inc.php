<?php
/**
 * Utilisateur.
 *   Fichier de gestion / connexion utilisateur.
 *
 * @version		1.2
 * @package		Edicod
 * @subpackage          Framework
 * @copyright		Copyright (C) 2005 - 2009 Serge NOEL. All rights reserved.
 * @license		GNU/GPL, see LICENSE.txt
 */

$Empty=0;

/**
 * Classe User, gère les opérations utilisateurs et groupes
 * @package		Edicod
 * @subpackage          Framework
 * @param		objet		Pointe sur l'objet de configuration
 * @param               string		login de l'utilisateur (cron est traité à part)
 * @todo                modifier le construct pour retirer le login
 */
class user {
	
// attributs utilisateurs
private $uid ;
private $UserName ;
private $GivenName ;
private $Login ;
private $Password;
private $Email ;
private $Valid ;

// Base
private $Db;

// attributs profile 
private $pid;
private $ProfileName;
private $Rights;

// attribut d'état
private $Loggued ;
private $ErrorString ;
private $ErrorId ;

// Groupes de l'utilisateur
private $Groups=array();

private $Guids="";

  public function __construct ($Db, $login)  
    {
    $this->IDENTIFIE = false  ;
    $this->IDERROR= -1 ;

    $this->Db = $Db;

    if( $login == "cron" )
      return;
						
    $requete  = "SELECT * ";
    $requete .= "FROM user ";
    $requete .= "WHERE login = '$login' AND valid=1 ";
						
    $Db->Query ($requete) ;
			
    if ( $Db->nb_result() != 1 ) 
      {
      $this->IDENTIFIE = false ;
      $this->IDERROR = 0;
      }
    else 
      {
      // Stocker les valeurs de l'utilisateur
      $user = $Db->db_fetch_object ();
      $this->Login      = $user->login ;
      $this->UserName   = $user->name ;
      $this->GivenName  = $user->given_name ;
      $this->Password   = $user->MD5Pass ;
      $this->Email      = $user->email ;
      $this->Valid      = $user->valid ;
      $this->uid        = $user->uid ;
      $this->pid 	= $user->pid ;
      $this->Loggued     = false ;
      }
    }

/**
 * Teste si l'utilisateur est celui qu'il prétend être
 *
 * @param	chaine		Mot de passe crypté (MD5)
 * @return	bool		Vrai si OK
 */
  public function is_Valid ($MD5Pwd) 
    {      if( ($MD5Pwd == $this->Password) && ($this->Valid == 1) )
      $this->Loggued = true;
    return $this->Loggued ;
    }

/**
 * Teste si l'utilisateur est loggué
 * @param 	chaine		Mot de passe crypté (MD5)	
 * @return	bool		Vrai si OK
 * @todo	Supprimer paramètre car obsolète
 */
  public function is_Logged ($MD5Pwd) 
    {  
    return $this->Loggued ;
    }

  /** 
   * Récupère les informations de l'utilisateur
   * @package		Edicod
   * @param		objet		Pointe sur l'objet de bdd
   */
  public function LoadProfileData ($Db) 
    {  // charge les donnees du profil utilisateur
    $tGuids="";
    if ( $this->Loggued === false )
      return false ; 
		
    $requete  = "SELECT * ";
    $requete .= "FROM profiles ";
    $requete .= "WHERE pid=".$this->pid ;
    $Db->Query($requete) ;

    $profile = $Db->db_fetch_object () ;
    $this->ProfileName = $profile->description;
    $this->Rights      = $profile->rights;

    $requete = "SELECT * FROM groups,g_grp WHERE g_grp.gid=groups.gid AND uid=".$this->uid.";";
    $Db->Query($requete) ;
    $this->Groups = $Db->loadObjectList();
    
    // Créer variable Guids
    $this->Guids = "( guid=\"U". $this->uid ."\" OR ";
    foreach($this->Groups as $Group)
      $tGuids .= "guid=\"G". $Group->gid . "\" OR ";
    $tGuids = substr($tGuids,0,-4);
    $this->Guids .=  $tGuids . " )"; 
    }

  /** 
   * Récupère les groupes de l'utilisateur
   * @package		Edicod
   * @param		objet		Pointe sur l'objet de bdd
   */
  public function ListUserGroups ($Db) 
    {  // charge les donnees du profil utilisateur
    $requete = "SELECT * FROM groups,g_grp WHERE g_grp.gid=groups.gid AND uid=".$this->uid.";";
    $Db->Query($requete) ;
    return($Db->loadObjectList());
    }

  /** 
   * Récupère la liste des utilisateurs
   *
   * @package		Edicod
   * @return		tableau		Liste des utilisateurs
   */
  public function GetUserList()
    {
    $Sql = "SELECT uid, name, given_name FROM user ORDER BY name, given_name";
    $Res = mysql_query($Sql,$this->Db);
    $array = array();
    while ($row = mysql_fetch_array( $Res, MYSQL_ASSOC )) 
      $array[] = $row;
    mysql_free_result( $Res );  // Libère la mémoire
    return $array;
    }

  /** 
   * Ecrit les données utilisateurs dans la variable de session
   *
   * @package		Edicod
   *
   * @return		void
   */
  public function WriteSession () 
    {
    $_SESSION['IsLoggued']           = $this->Loggued; 
    $_SESSION['User']['Login']       = $this->Login ;
    $_SESSION['User']['Passwd']      = $this->Password;
    $_SESSION['User']['UserName']    = $this->UserName ;
    $_SESSION['User']['GivenName']   = $this->GivenName ;
    $_SESSION['User']['Email']       = $this->Email ;
    $_SESSION['User']['uid']         = $this->uid ;
    $_SESSION['User']['ProfileName'] = $this->ProfileName ;
    $_SESSION['User']['Rights']      = $this->Rights ;
    $_SESSION['User']['IsLoggued']   = $this->Loggued;
    $_SESSION['User']['Guids']       = $this->Guids;
    $_SESSION['User']['Groups']      = $this->Groups;
    }


  public function get_error () 
    {
    return $this->ErrorId ;
    }
 
  /**
   *  Retrouve la liste des groupes
   *
   * @todo a modifier avec prefix pour utiliser des groupes windows ou ...
   * @todo a modifier avec plug-in
   */
  public function GetGroupList()
    {
    $Sql = "SELECT * FROM groups;";
    $this->Db->Query($Sql);
    return($this->Db->LoadObjectList());
    }

  /**
   *  Genere une liste de guid et sélectionne le guid passé en paramètre
   * @todo a modifier avec prefix
   * @todo a modifier avec plug-in
   */
  public function GetGuidOption($Indent,$Guid)
    {
    $Html="";
    $Chk = "";
    $Sql = "SELECT * FROM groups ORDER BY name;";
    $this->Db->Query($Sql);
    $Groups = $this->Db->loadObjectList();
    foreach($Groups as $Group)
      {
      $sGuid = "G". $Group->gid;
      $sName = "G: ". $Group->name;
      if( ($sGuid) == $Guid )
        $Chk = "selected='selected'";
      else
        $Chk="";
      $Html .= $Indent . "<option value='$sGuid' $Chk>$sName</option>\n";
      }
    $Sql = "SELECT * FROM user ORDER BY name+given_name;";
    $this->Db->Query($Sql);
    $Users = $this->Db->loadObjectList();
    foreach($Users as $User)
      {
      $sGuid = "U". $User->uid;
      $sName = "U: ". $User->name . " ". $User->given_name;
      if( ($sGuid) == $Guid )
        $Chk = "selected='selected'";
      else
        $Chk="";
      $Html .= $Indent . "<option value='$sGuid' $Chk>$sName</option>\n";
      }
    return($Html);
    }
    
  /**
   * Retourne les caractéristiques de l'utilisateur dont l'ui est passé en paramètre
   *
   * @param	int	uid  uid de l'utilisateur
   * @return    objet   objet utilisateur
   */
  public function GetUser($uid)
    {
    $Sql = "SELECT * FROM user WHERE uid=$uid;";
    $this->Db->Query($Sql);
    return $this->Db->loadObject();
    }  
}

function GetUser($uid)
{
$Db = new db($_SESSION['Parameters']['SqlEngine'], $_SESSION['Parameters']['SqlSvr'], $_SESSION['Parameters']['SqlBase'], 
             $_SESSION['Parameters']['SqlUsr'] , $_SESSION['Parameters']['SqlPwd']);
$Usr = new user($Db,$uid);
return($Usr->GetUser($uid));
}

?>
