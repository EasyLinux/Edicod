<?php

/**
 * find files matching a pattern
 * using PHP "glob" function and recursion
 *
 * @return array containing all pattern-matched files
 *
 * @param string $dir     - directory to start with
 * @param string $pattern - pattern to glob for
 */
function find($dir, $pattern)
{
    // escape any character in a string that might be used to trick
    // a shell command into executing arbitrary commands
    $dir = escapeshellcmd($dir);
    // get a list of all matching files in the current directory
    $files = glob("$dir/$pattern");
    // find a list of all directories in the current directory
    // directories beginning with a dot are also included
    foreach (glob("$dir/{.[^.]*,*}", GLOB_BRACE|GLOB_ONLYDIR) as $sub_dir){
        $arr   = find($sub_dir, $pattern);  // resursive call
        $files = array_merge($files, $arr); // merge array with files from subdirectory
    }
    // return all found files
    return $files;
}

$Db = mysql_connect('localhost','Edicod','Edicod');
mysql_select_db('Edicod');

$Sql = "SELECT * FROM documents";

$Res = mysql_query($Sql, $Db);

echo "<h2>Dans Adjust</h2>";

while( $Row = mysql_fetch_object($Res) )
  {
  $File = find("/Data/Edicod/Store", $Row->name);
  //$Len = strlen($File[0])-(strlen("/Data/Edicod")+strlen($Row->Name));
  $Dir = substr($File[0],strlen("/Data/Edicod"));
  $Dir = substr($Dir,0,strrpos($Dir,"/"));
  $Sql = "UPDATE documents SET path='$Dir' WHERE did=".$Row->did.";";
  mysql_query($Sql,$Db);
  echo $Row->name . " - $Sql\n<br/>";
  }

//print_r($Rows);
mysql_close($Db);
?>

