<?php
/** 
 * Gestion de base de données 
 *
 * @version		1.2
 * @package		Edicod
 * @subpackage          Framework
 * @copyright		Copyright (C) 2005 - 2009 Serge NOEL. All rights reserved.
 * @license		GNU/GPL, see LICENSE.txt
 * @tutorial		Db.pkg
 *
 * @todo                Ajout d'autres type de connexion via plug-in
 * @todo                Nettoyer le fichier
 */

$Empty=0;

/** 
 * Classe d'accès aux données
 *  	<b>Attention</b> Beaucoup de méthode sont obsolètes et normalement inutilisées
 *      
 *
 * @package		Edicod
 * @subpackage		Framework
 */
class db {

  // choix du moteur de base de donnees.
  private $DBENGINE ;
  private $DEBUG;

  // infomations de connexion a la base
  private $DBHOST ;
  private $DBNAME ;
  private $USER ;
  private $PASSWORD ;
  private $PORT ;

  //parametres de transition de la base.
  private $DBCONNEXION ;
  private $DBQUERY ;
  private $QUERY;
  public  $DBERROR ;
	
	
  function __construct ($BASE_TYPE, $HOST, $BASE, $USER, $PASSWORD) 
    {
    $this->DEBUG    = true;
    $this->DBENGINE = $BASE_TYPE ;
    $this->DBHOST   = $HOST ;
    $this->DBNAME   = $BASE;
    $this->USER     = $USER;
    $this->PASSWORD = $PASSWORD;
		
    switch( $this->DBENGINE )
      {
      case "MYSQL":
        $this->PORT = '3306';
        $this->DBCONNEXION = mysql_connect($this->DBHOST,$this->USER,$this->PASSWORD);
	mysql_select_db($this->DBNAME);
        break;
              	
      case "SQLSERVER":
        $this->PORT = '1433';
        $this->DBCONNEXION = mssql_connect($this->HOST,$this->USER,$this->PASSWORD);
	mssql_select_db($this->DBNAME);
        break;
		
      case "POSTGRESQL":
        $this->PORT = '5432';
        $this->DBCONNEXION = pg_connect("host=".$this->HOST." user=".$this->USER.
                             " password=".$this->PASSWORD." dbname=".$this->DBNAME." port=".$this->PORT);
        break;

      default:
        print "<h1>ERREUR: Type de base inconnu</h1>\n";
        die("Ne peut continuer");
        break;
      }
    }

  /**
   * Exécuter une requête
   *
   * @param	string		Requete SQL
   * @return	void		Rien
   */
   public function Query($Sql)
     {
     switch($this->DBENGINE)
       {
       case "MYSQL":
         $this->QUERY = $Sql; // for debug
         $this->DBQUERY = mysql_query($Sql,$this->DBCONNEXION);
         if( $this->DEBUG && $this->DBQUERY == NULL )
           {
           print "Sql : " . $this->QUERY . "<br />\n";
           $Traces = debug_backtrace();
           foreach( $Traces as $Trace )
             print $Trace["file"] . " : " . $Trace["function"] . "(" . $Trace["line"] . ")<br />";

           print "ERREUR: ". mysql_errno($this->DBCONNEXION) . " " .mysql_error($this->DBCONNEXION) . "<br />$Sql";
           }
         break;

       case "POSTGRESQL":
         $this->DBQUERY = @pg_query($Sql,$this->DBCONNEXION);
         break;
       
       default:
         break;
       }
     }	

  /**
   * Obsolète Exécuter une requête (<b>utiliser Query à la place</b>)
   *
   * @param	string		Requete SQL
   * @return	void		Rien
   */
  public function db_query ($query) 
  {
  if($this->DBENGINE == "MYSQL") 
    {
    print "<h2>Appel de db_query</h2>";
    $Traces = debug_backtrace();
    foreach( $Traces as $Trace )
      print $Trace["file"] . " : " . $Trace["function"] . "(" . $Trace["line"] . ")<br />";
    $this->DBQUERY = mysql_query($query,$this->DBCONNEXION) ;
		
		return $this->DBQUERY ;
		}elseif($this->DBENGINE == "SQLSERVER"){
			
			 $this->DBQUERY = mssql_query($query,$this->DBCONNEXION);
			return mysql_error($this->DBCONNEXION) ;
			
		}elseif ($this->DBENGINE == "POSTGRESQL") {
			
			$this->DBQUERY = @pg_query($query,$this->DBCONNEXION);
			
		}elseif ($this->DBENGINE == "ORACLE") {
			
			// pas encore de code
		}
		
	}

  /**
   *  Retourne le dernier ID attribué
   *
   *  @return	integer		Numéro de l'ID
   */
  function GetLastId()
    {
    return(mysql_insert_id());
    }

  /**
   *  Retourne le nombre de ligne trouvées
   *
   * @return	integer		Nombre de lignes
   */
  function NumRows()
    {
    return(mysql_num_rows($this->DBQUERY));
    }

  /** 
   *  Lire les paramètres 
   *    Cette méthode lit les paramètres contenus dans la table parameters
   *    et défini la variable de session parameters. 
   *    Cette méthode est appelée à l'initialisation de Edicod
   *
   * @param	void	aucun
   * @return	void	aucun
   */
  function GetParameters()
    {
    $Sql = "SELECT name, value FROM parameters;";
    $this->Query($Sql);
    $_SESSION['Parameters'] = array();
    while ($row = mysql_fetch_row( $this->DBQUERY )) 
      $_SESSION['Parameters'][$row[0]] = $row[1];
    mysql_free_result( $this->DBQUERY );  // Libère la mémoire
    }
   
  /**
   * Retourne un objet associatif liè à la dernière requète SQl
   *
   * @param	void	aucun
   * @return	object	objet contenant le résultat
   */	
  function loadObjectList( )
    {
    $array = array();
    while ($row = mysql_fetch_object( $this->DBQUERY )) 
      $array[] = $row;
    mysql_free_result( $this->DBQUERY );  // Libère la mémoire
    return $array;
    }

  /**
   * Retourne un tableau associatif liè à la dernière requète SQl
   * 
   * @param	void	aucun
   * @return	array	tableau contenant le résultat
   */	
  function loadArrayList( )
    {
    $array = array();
    while ($row = mysql_fetch_array( $this->DBQUERY, MYSQL_BOTH )) 
      $array[] = $row;
    mysql_free_result( $this->DBQUERY );  // Libère la mémoire
    return $array;
    }

  /** 
   * Retourne l'enregistrement courant sous forme d'un objet
   *
   * @param	void	aucun
   * @return	objet	Enregistrement trouvé
   */
  function loadObject( )
    {
    $array = mysql_fetch_object( $this->DBQUERY );
    return $array;
    }

  /** 
   * Retourne l'enregistrement courant sous forme d'un tableau associatif
   *
   * @param	void	aucun
   * @return	array	Enregistrement trouvé
   */
  function loadArray( )
    {
    $array = mysql_fetch_array( $this->DBQUERY , MYSQL_BOTH);
    return $array;
    }
	
	/**
	 * fonction donnant le nombre de ligne de résultat de la requête
	 * obsolète
	 **/
	
	public function nb_result()
	{
	
		if($this->DBENGINE == "MYSQL")
		{
           return mysql_num_rows($this->DBQUERY);
		 }
		elseif($this->DBENGINE == "SQLSERVER")
		{
			return @mssql_num_rows($this->DBQUERY);
		}
		elseif($this->DBENGINE == "POSTGRESQL")
		{
			return @pg_num_rows($this->DBQUERY);
		}
		elseif($this->DBENGINE == "ORACLE" ) {
		
			//pas encore de code
			
			
		}
	}
	

   /**
    * Lit la valeur du paramètre 
    *
    * @param	string	Nom du paramètre demandé (de la table <b>parameters</b>)
    * @return	string  Valeur
    */
   public function GetParamValue($Param)
     {
     $Sql = "SELECT value FROM parameters WHERE name='$Param'";
     $this->Query($Sql);
     $Value = mysql_result( $this->DBQUERY ,0, "value");

     return($Value);
     }
	
// fonction de récupération des donnees
  /**
   * Obsolète
   *
   */
	
	public function db_fetch_row () {
		
		if($this->DBENGINE == "MYSQL") {
		
		return @mysql_fetch_row($this->DBQUERY);
		
		
		}elseif($this->DBENGINE == "SQLSERVER")
		{
			return @mssql_fetch_row($this->DBQUERY);
			
		}elseif ($this->DBENGINE == "POSTGRESQL") {
			
			return @pg_fetch_row($this->DBQUERY);
			
			
		}elseif ($this->DBENGINE == "ORACLE") {
			
			
			//pas encore de code
			
			
		}else {
		
			}
		
		
	}
	
	
  /**
   * Obsolète
   *
   */
   public function db_fetch_object () {
		
	   	if($this->DBENGINE == "MYSQL") {
		
		 return mysql_fetch_object($this->DBQUERY);
		
		
		}elseif($this->DBENGINE == "SQLSERVER")
		{
			return @mssql_fetch_object($this->DBQUERY);
			
		}elseif ($this->DBENGINE == "POSTGRESQL") {
			
			return @pg_fetch_object($this->DBQUERY);
			
		}elseif ($this->DBENGINE == "ORACLE") {
			
			
			// pas encore de code
			
			
		}else {
		
			}
		
	}
	
  /**
   * Obsolète
   *
   */
		public function fetch_array ()	{
			
		if($this->DBENGINE == "MYSQL") {
		
		 return @mysql_fetch_array($this->DBQUERY);
		
		}elseif($this->DBENGINE == "SQLSERVER")
		{
			return @mssql_fetch_array($this->DBQUERY);
			
		}elseif ($this->DBENGINE == "POSTGRESQL") {
			
			return @pg_fetch_array($this->DBQUERY);
			
			
		}elseif ($this->DBENGINE == "ORACLE") {
			
			// pas encore de code
			
		}
			
	}
	// compte du nombre de resultat de la requete
  /**
   * Obsolète
   *
   */
	public function db_nb_result ()	{
				
		if($this->DBENGINE == "MYSQL") {
		
		 return mysql_num_rows($this->DBQUERY);
		
		}elseif($this->DBENGINE == "SQLSERVER")	{
			
			return @mssql_num_rows($this->DBQUERY);
			
		}elseif ($this->DBENGINE == "POSTGRESQL") {
			
			return @pg_num_rows($this->DBQUERY);
			
		}elseif ($this->DBENGINE == "ORACLE") {
			
			//pas encore de code
			
		}
		
		
	}
	
	
  /**
  *  Fermeture de la connexion
  *
  * Ferme la connection
  * @param 	void 	aucun
  * @return	void	aucun
  */
  public function Close()
    {
    switch ($this->DBENGINE)
      {
      case  "MYSQL":
        @mysql_close($this->DBCONNEXION);
        break;

      case  "SQLSERVER":
        @mssql_close($this->DBCONNEXION);
        break;

      case  "POSTGRESQL":
        @pg_close($this->DBCONNEXION);
        break;
      
      default:
	break;
      }
    }
} // Fin de l'objet

?>
