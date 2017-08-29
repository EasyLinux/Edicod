<?php

$aFiles = scandir('class/');
foreach( $aFiles as $sFile)
{
	if( strpos($sFile,".class") !== false )
	{
		require_once($sFile);
	}
}
