<?php
/**
 * Contact.
 *   Fichier de gestion / connexion contact
 *
 * @version		1.2
 * @package		Edicod
 * @subpackage          Framework
 * @copyright		Copyright (C) 2005 - 2009 Serge NOEL. All rights reserved.
 * @license		GNU/GPL, see LICENSE.txt
 */


function GetContactName($Db, $Conid)
{
$Sql = "SELECT * FROM contact WHERE conid=$Conid;";
$Db->Query($Sql);
$Contact = $Db->loadObject();
return($Contact->name . " " . $Contact->given_name);
}

?>
