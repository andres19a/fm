<?php

if (!@include_once("./conf/config.inc.php"))
 include_once("../conf/config.inc.php");

ini_set('magic_quotes_gpc', 1);
ini_set('session.use_trans_sid', 0);

if (isset($session_save_path)) session_save_path($session_save_path);
session_start();
		$link = mysql_connect('localhost', 'fm', 'fm') or die('No existe Servidor - Error:: ' . mysql_error());
    mysql_select_db('fm') or die('No existe Base de Datos');
    $var=$_SESSION['session_username'];
    $query = "select usuario, pass from usuarios where usuario='$var'";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error());    
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{			
    	$username=$line["usuario"];    	 
    	$password=$line["pass"];			  
    }
		mysql_close($link);
if (isset($_SESSION['session_username']) && $_SESSION['session_username'] == $username && isset($_SESSION['session_password']) && $_SESSION['session_password'] == md5($password) || !$phpfm_auth);
else exit("<font color='#CC0000'>Access Denied!</font>");

?>