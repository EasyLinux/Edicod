<?php

function GetHtml($State)
{
$Html = "
<html>
<head>
  <style type='text/css'>
  body {
    background-color: #BFDBFF;
    font-size: 14px;
    margin: 0px;
  }
  input {
    background-color: #FFFFFF;
    border-color: #999999 #CCCCCC #CCCCCC #999999;
    border-style: solid;
    border-width: 1px;
    color: #333333;
    font-family: Verdana,Arial,sans-serif;
    font-size: 12px;
    }
  </style>
  <script type='text/javascript'>
  function Update(Name)
  {
  document.getElementById('Status').value = 'Ready';
  parent.parent.document.getElementById('Up_name').value = Name;
  parent.parent.document.getElementById('Up_object').value = Name;
  parent.parent.document.getElementById('Up_dName').innerHTML = Name;
  parent.parent.document.getElementById('ImgUpload').src = '/img/UploadFileAttach/Upload.png';
  }
  </script>
  
</head>
<body>
<form enctype='multipart/form-data' action='Upload.php' method='POST' id='SendFile'>
<input type='file' style='width: 200px' name='UserFile' onChange='Update(this.value);' />
<input type='hidden' id='Status' name='Status' value='$State' />
</form>
</body>
</html>
";
return $Html;
}

function Done($Msg, $FileSize, $FileMD5)
{
$Html = "
<html>
<head>
  <style type='text/css'>
  body {
    background-color: #BFDBFF;
    font-size: 14px;
    margin: 0px;
  }
  input {
    background-color: #FFFFFF;
    border-color: #999999 #CCCCCC #CCCCCC #999999;
    border-style: solid;
    border-width: 1px;
    color: #333333;
    font-family: Verdana,Arial,sans-serif;
    font-size: 12px;
    }
  </style>
  <script type='text/javascript'>
  function Finish()
  {
  parent.parent.document.getElementById('Status').value = 'Done';
  parent.parent.document.getElementById('sFileName').style.display  = 'inline';
  parent.parent.document.getElementById('sUploadImg').style.display = 'none';
  parent.parent.document.getElementById('ImgUpload').src = '/img/UploadFileAttach/UploadGray.png';
  parent.parent.InsertData('$Msg', '$FileSize', '$FileMD5');
  }
  </script>
  
</head>
<body onLoad='Finish();'>
OK
</body>
</html>
";
return $Html;
}

require ('../../inc/Db.Inc.php');

if( !isset($_POST["Status"]) )
  $Status = "Waiting";
else
  $Status = $_POST["Status"];
  
switch( $Status )
  {
  case 'Waiting':
    echo GetHtml($Status);
    break;
  
  case 'Ready':
    session_start();
    $Path = $_SESSION["Parameters"]["AbsoluteDocuments"] . $_SESSION["Parameters"]["StorePath"] . date("/Y/m/d");
    
    // Initialise la Bdd
    $Db = new db($_SESSION['Parameters']['SqlEngine'], $_SESSION['Parameters']['SqlSrv'], $_SESSION['Parameters']['SqlBase'], 
                 $_SESSION['Parameters']['SqlUsr'] , $_SESSION['Parameters']['SqlPwd']);

    // Savoir si le fichier est déjà présent dans la base
    $FileSize = $_FILES["UserFile"]["size"];
    $FileMD5  = md5(file_get_contents($_FILES["UserFile"]["tmp_name"]));
    $Sql = "SELECT * FROM documents WHERE size=$FileSize AND md5='$FileMD5';";
    
    $Db->Query($Sql);
    if( $Db->NumRows() > 0 )
      {
      $Rep = $Db->loadObject();
      echo Done($Rep->did, $FileSize, $FileMD5);
      }
    else
      {
      if( !file_exists($Path) )
        mkdir( $Path, 0775, true);
      move_uploaded_file($_FILES["UserFile"]["tmp_name"], $Path . "/" . $_FILES["UserFile"]["name"]);
      sleep(1);
      echo Done("", $FileSize, $FileMD5);
      }
    break;
        
  default:
    break;
  }
  





?>
