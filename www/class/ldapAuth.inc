<?php

/**
 * LDAP External Authentication Bridge
 * 
 * This file contains the authentification class for Ldap
 *
 * Copyright (C) 2017 Serge NOEL <serge.noel@net6a.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
 
 class authClass {
 	
 	// Ldap credentials
 	private $BaseDN;
	private $Host;
	private $Protocol;
	private $Anon;
	private $Passwd;
	private $BindDN;
	private $Socket;
	private $Filter = "(&(objectClass=*)(|(cn=$1)(email=$1)))";
	private $Result;
	
	// User datas
	private $User;
	private $uid ;
	private $UserName ;
	private $GivenName ;
	private $Login ;
	private $Password;
	private $Email ;
	private $Valid ;

	// Profile data
	private $pid;
	private $ProfileName;
	private $Rights;

	// Status 
	private $Loggued ;
	private $ErrorString ;
	private $ErrorId ;

	// User's groups
	private $Groups=array();
	private $Guids="";	
 	
 	/**
 	 * Initialize auth plugin
 	 * 
 	 * @parameter   array   $Config   Config datas
 	 * @return      bool/string       true if result OK
 	 *                                Error message if failed 
 	 */
 	public function setConfig($Config)
 	{
 		$this->Host     = $Config['ldap']['host'];
 		$this->BaseDN   = $Config['ldap']['basedn'];
 		$this->Protocol = $Config['ldap']['protocol'];
 		$this->BindDN   = $Config['ldap']['user'];
 		$this->Passwd   = $Config['ldap']['passwd'];
 		$this->Anon     = $Config['ldap']['anon'];
 		
 		$this->Socket = ldap_connect( $this->Host );
 		if( $this->socket === false)
 		{
 			return "ERROR: ldap_connect failed !";
 		}
		// Set initial LDAP values.
		ldap_set_option( $this->socket, LDAP_OPT_PROTOCOL_VERSION, $version );
		ldap_set_option( $this->socket, LDAP_OPT_REFERRALS, 0 );

		if ( $this->Anon == true ) 
		{
			// Set preauth flag to value of socket on anonymous bind.
			$this->Cnx = $this->Socket;
		} else {
				// Set preauth flag using call to ldap_bind on authenticated bind.
				$this->Cnx = ldap_bind( $this->Socket, $this->BindDN, $this->Passwd );
		}
 	  if( $this->Cnx == false )
      return "ERROR: ldap_bind failed !";
		return( true );
 	}
 	
 	/**
 	 * Set user 
 	 */
 	public function setUser($User)
 	{
 		$this->User = $User;
 	}
 	
 	public function getUser()
 	{
 		return $this->User;
 	}
 	
 	/**
 	 * Try to authenticate with credentials
 	 *   username is filled by setUser method
 	 * @param   string    $Pass   Password of User
 	 * @return  bool              true if User/Password is valid
 	 */
 	public function isValid($Pass)
 	{
 		$this->Loggued = false;
 		// !!!!
 		if( $this->User == snoel && $Pass == "Test")
 		{
 			$this->Loggued = true;
 		}
 		return $this->Loggued;
 		// !!!!!
 		
 		$sfilter = str_replace( "$1", $this->User, $this->Filter );
 		echo $sfilter;
 		
		$this->Result = ldap_search( $this->Cnx, $this->BaseDN, $sfilter );
		$icount  = ldap_count_entries( $this->Cnx, $this->Result ); 		
 		
 		if( $iCount === 1 )
 		{
 			$this->Loggued = true;
 		}
 		return $this->Loggued;
 	}

  /** 
   * Get back User datas from backend
   * @package		Edicod
   *
   */
  public function LoadProfileData() 
  {  // charge les donnees du profil utilisateur
    if ( $this->Loggued === false )
      return false ; 
		
    $this->ProfileName = 'Admin';
    $this->Rights      = 'all';

  }
}
 
 /*
	$server = "ldap://ldap.example.com:389";
	$basedn = "ou=people,dc=example,dc=com";
  
	$anonbind = true;
    
	$binddn = "cn=binduser,cn=Users,dc=example,dc=com";
	$bindpass = "";
	$filter = "(&(objectClass=*)(|(cn=$1)(email=$1)))";
	$createuser = true;
	$version = 3;

class classLdap {

  public function __construct()
  {
  	// Get Globals
  }


			// Check if LDAP pre-authentication (or socket creation) was a success.
			if ( $preauth == true ) {
				// Search through basedn based on the filter, and count entries.
				$result = ldap_search( $socket, $basedn, $tfilter );
				$count  = ldap_count_entries( $socket, $result );
				// Ensure count is definitely equal to 1
				if ( $count === 1 ) {
					// Get the entry from the search result, and bind using its DN.
					$data = ldap_get_entries( $socket, $result );
					$auth = ldap_bind( $socket, $data[0]['dn'], $User->password );
					// Check the return value of the bind action.
					if ( $auth === -1 ) {
						// Deny login and send message, An LDAP error occurred.
						die( formatJSEND( "error", "An LDAP error has occurred: " . ldap_error($socket) ) );
					} elseif ( $auth == false ) {
						// Invalid login.
						die( formatJSEND( "error", "Invalid user name or password." ) );
					} elseif ( $auth == true ) {
						// Check if user already exists within users.php.
						if ( $User->CheckDuplicate() ) {
							// Check if we can create a user within users.php.
							if ( $createuser == true ) {
							// Save array back to JSON and set the session username.
							$User->users[] = array( 'username' => $User->username, 'password' => null, 'project' => "" );
							saveJSON( "users.php", $User->users );
							$_SESSION['user'] = $User->username;
							} else {
								// Deny login and send message, the user doesn't exist within users.php.
								die( formatJSEND( "error", "User " . $User->username . " does not exist within Codiad." ) );
							}
						} else {
							// Set the session username.
							$_SESSION['user'] = $User->username;
						}
						// Set the session language, if given, or set it to english as default.
						if ( isset( $_POST['language'] ) ) {
							$_SESSION['lang'] = $_POST['language'];
						} else {
							$_SESSION['lang'] = "en";
						}
						// Set the session theme and project.
						$_SESSION['theme'] = $_POST['theme'];
						$_SESSION['project'] = $_POST['project'];
						// Respond by sending verification tokens on success.
						echo formatJSEND( "success", array( 'username' => $User->username ) );
						header( "Location: " . $_SERVER['PHP_SELF'] . "?action=verify" );
					}
				} elseif ( $count > 1 ) {
					// We returned too many results. Error as such.
					die( formatJSEND( "error", "A server error occurred: LDAP filter result is non-unique. Please ensure this is a unique identifier within its context.
												If the problem persists, please contact the webmaster. If you are the webmaster, please check the LDAP filter used." ) );
				} else {
					// Invalid login.
					die( formatJSEND( "error", "Incorrect user name or password." ) );
				}
			} else {
				// The server is having issues connecting to the LDAP server. Error as such.
				die( formatJSEND( "error", "An error occurred: Cannot connect to LDAP server. Please contact the webmaster. 
											If you are the webmaster, please contact your LDAP server administrator or check if your LDAP server is running." ) );
			}
		}
	}
*/