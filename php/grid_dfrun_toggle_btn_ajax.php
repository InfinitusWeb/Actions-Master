<?php
session_start();
if($_POST)
{
	foreach ($_POST as $key => $value)
	{
		$_SESSION[$key][$value[0]]=$value[1];
		
	}
}
	
?>