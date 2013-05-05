#!/usr/bin/php -q
<?php

function Pop3Login($Host,$Port,$User,$Pass,$Ssl=false)
{
if( $Ssl )
  $sSSL = "/ssl/novalidate-cert";
return (imap_open("{".$Host.":"."$Port/pop3$sSSL}INBOX",$User,$Pass));
}

function Pop3Stat($Cnx)       
{
$Check = imap_mailboxmsginfo($Cnx);
return ((array)$Check);
}

function Pop3List($Cnx)
{
$MC = imap_check($Cnx);
$range = "1:".$MC->Nmsgs;
echo $range . "\n";
$response = imap_fetch_overview($Cnx,$range,0);
return($response);
//foreach ($response as $msg) 
//  $result[$msg->msgno]=(array)$msg;
//return($result);
}

function Pop3GetStructure($Cnx, $MsgId)
{
return(imap_fetchstructure($Cnx, $MsgId));
}

function Pop3Retr($Cnx,$MsgId)
{
return(imap_fetchheader($Cnx,$MsgId,FT_PREFETCHTEXT));
}

function Pop3RetrBody($Cnx, $MsgId,$Part)
{
$Text = imap_fetchbody($Cnx, $MsgId, $Part);
$Text = imap_utf8($Text);
$Text = htmlentities($Text,ENT_QUOTES);
$Text = nl2br($Text);
return($Text);
}

function pop3_dele($connection,$message)
{
return(imap_delete($connection,$message));
}

function MailParseHeaders($headers)
{
$headers=preg_replace('/\r\n\s+/m', '',$headers);
preg_match_all('/([^: ]+): (.+?(?:\r\n\s(?:.+?))*)?\r\n/m', $headers, $matches);
foreach ($matches[1] as $key =>$value) 
  $result[$value]=$matches[2][$key];
return($result);
}


function mail_mime_to_array($imap,$mid,$parse_headers=false)
{
    $mail = imap_fetchstructure($imap,$mid);
    $mail = mail_get_parts($imap,$mid,$mail,0);
    if ($parse_headers) $mail[0]["parsed"]=mail_parse_headers($mail[0]["data"]);
    return($mail);
}
function mail_get_parts($imap,$mid,$part,$prefix)
{   
    $attachments=array();
    $attachments[$prefix]=mail_decode_part($imap,$mid,$part,$prefix);
    if (isset($part->parts)) // multipart
    {
        $prefix = ($prefix == "0")?"":"$prefix.";
        foreach ($part->parts as $number=>$subpart)
            $attachments=array_merge($attachments, mail_get_parts($imap,$mid,$subpart,$prefix.($number+1)));
    }
    return $attachments;
}
function mail_decode_part($connection,$message_number,$part,$prefix)
{
    $attachment = array();

    if($part->ifdparameters) {
        foreach($part->dparameters as $object) {
            $attachment[strtolower($object->attribute)]=$object->value;
            if(strtolower($object->attribute) == 'filename') {
                $attachment['is_attachment'] = true;
                $attachment['filename'] = $object->value;
            }
        }
    }

    if($part->ifparameters) {
        foreach($part->parameters as $object) {
            $attachment[strtolower($object->attribute)]=$object->value;
            if(strtolower($object->attribute) == 'name') {
                $attachment['is_attachment'] = true;
                $attachment['name'] = $object->value;
            }
        }
    }

    $attachment['data'] = imap_fetchbody($connection, $message_number, $prefix);
    if($part->encoding == 3) { // 3 = BASE64
        $attachment['data'] = base64_decode($attachment['data']);
    }
    elseif($part->encoding == 4) { // 4 = QUOTED-PRINTABLE
        $attachment['data'] = quoted_printable_decode($attachment['data']);
    }
    return($attachment);
}

function ReplaceImap($txt) 
{
$carimap = array("=C3=A9", "=C3=A8", "=C3=AA", "=C3=AB", "=C3=A7", "=C3=A0", "=20", "=C3=80", "=C3=89");
$carhtml = array("é", "è", "ê", "ë", "ç", "à", "&nbsp;", "À", "É");
$txt = str_replace($carimap, $carhtml, $txt);

return $txt;
}

function Pop3Close($Cnx)
{
imap_close($Cnx);
}




/* Le code */
// Début
if( file_exists("/var/run/EdicodPop.pid") )
  die();
touch("/var/run/EdicodPop.pid");
$Dir = dirname(__FILE__);

if( $argc == 1 )
  require_once("/etc/Edicod/config.php");
else
  require_once("/etc/Edicod/".$argv[1].".php");
require_once($Dir . "/../inc/Db.Inc.php");
require_once($Dir . "/../inc/User.Inc.php");
require_once($Dir . "/../inc/lib.inc.php");
require_once($Dir . "/../inc/IndexFile.php");

$Db = new db($Cfg['BdDbE'], $Cfg['BdHost'], $Cfg['BdBase'], $Cfg['BdUser'] , $Cfg['BdPwd']);
$Db->GetParameters();

$Pop = explode(":",$_SESSION["Parameters"]["UsePop"]);
$Ssl = false;
if( $Pop[0] == "pop3s" )
  $Ssl = true;
$Port      = $Pop[2];
$PopServer = $Pop[1];

echo "Dans ReadPop\n";
// Trouver les utilisateurs Pop 
$Sql = "SELECT * FROM user, profiles WHERE user.pid=profiles.pid AND profiles.description='Compte Pop';";
$Db->Query($Sql);
$Users = $Db->loadObjectList();
foreach($Users as $User)
  {  // uid login MD5Pass
  echo "SSL $Ssl : Server $PopServer : Protocol $Port " . $User->uid . " ".$User->login . " ". $User->MD5Pass . "\n";
  $Usr = new user($Db,$User->login);
  $Grps = $Usr->ListUserGroups($Db);
  foreach($Grps as $Grp)
    {
    //print_r($Grp);
    echo "Wfsid " . $Grp->wfsid . " - " . $Grp->inputdirectory ."\n";
    $Cnx = Pop3Login($PopServer,$Port,$User->login,$User->MD5Pass,$Ssl);
    $Stats = Pop3Stat($Cnx);  
    if( $Stats["Nmsgs"] == 0 )
      echo "Aucun message en attente \n";
    else
      {
      $Messages =  Pop3List($Cnx);
      foreach($Messages as $Message)
        {
        echo $Message->subject . "\n";
        //$MsgHeader = Pop3Retr($Cnx,$Message->uid);
        //print_r(MailParseHeaders($MsgHeader));
       
        // Analyse du message
        $Structure = Pop3GetStructure($Cnx, $Message->uid);
        $Parts = $Structure->parts;
        $nbParts = count($Parts);
        echo "Type";
        for($i=0 ; $i< $nbParts ; $i++)
          {
          echo " ". $Parts[$i]->subtype;
          if( $Parts[$i]->subtype == "HTML" )
            {
            print_r($Parts[$i]);
            break;
            }
          }  // For(i)
        echo " Part: $i \n";
          
        //print_r( $Structure );
        $text = Pop3RetrBody($Cnx, $Message->uid, $i);
        echo $text;
        } // foreach Messages
      } // if Msg
    Pop3Close($Cnx);
    } // foreach Groups
  }  // foreach User


//$Usr = new user($Db,"ReadFiles");
/*
//$OutPath    = $_SESSION["Parameters"]["AbsoluteDocuments"] . $_SESSION["Parameters"]["IncomingPath"];
//$RelOutPath = $_SESSION["Parameters"]["IncomingPath"];
$RelOutPath = $_SESSION["Parameters"]["StorePath"];
$OutPath    = $_SESSION["Parameters"]["AbsoluteDocuments"] . $RelOutPath;
$BadPath    = $_SESSION["Parameters"]["AbsoluteDocuments"] . $_SESSION["Parameters"]["BadDocuments"];

$Grps = $Usr->GetGroupList();
foreach($Grps as $Grp)
  {
  $InPath     = $_SESSION["Parameters"]["AbsoluteDocuments"] . $_SESSION["Parameters"]["InputPath"] . $Grp->inputdirectory;
  if( $Grp->inputdirectory != "" ) 	// Répertoire vide signifie pas de scan associé
    RFScan($Db, $Grp->gid, $Grp->wfsid, $InPath, $OutPath, $RelOutPath, $BadPath);
  }
*/
unlink("/var/run/EdicodPop.pid");
?>


