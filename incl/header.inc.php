<?php

list($seconds, $microseconds) = explode(" ", microtime());
$time_start = $seconds + $microseconds;

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-Type: text/html; charset=$StrLanguageCharset");

if (isset($session_save_path)) session_save_path($session_save_path);
ini_set('magic_quotes_gpc', 1);
ini_set('session.use_trans_sid', 0);
error_reporting(E_ALL);
clearstatcache();
session_start();

$base_url = "?".SID."&amp;";

		
    
    
if (isset($_POST['input_username']) && isset($_POST['input_password'])) {
    $link = mysql_connect('localhost', 'fm', 'fm') or die('No existe Servidor - Error:: ' . mysql_error());
    mysql_select_db('fm') or die('No existe Base de Datos');
    $user=$_POST['input_username'];
    $pass=$_POST['input_password'];
    $query = "select usuario, pass from usuarios where usuario='$user'";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error());    
    $query2 = "select count(*) cont from usuarios where usuario='$user' and pass='$pass'" ;
    $result2 = mysql_query($query2) or die('Query failed: ' . mysql_error());    
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{			
    	$username=$line["usuario"];    	 
    	$password=$line["pass"];			  
    }
    while ($line2 = mysql_fetch_array($result2, MYSQL_ASSOC)) 
		{			
    	$cont=$line2["cont"];
    }
    if ($cont == 0) {
      $username='hola';
      $password='oo';
    }
    mysql_close($link);
    if  ($_POST['input_username'] == $username && md5($_POST['input_password']) == md5($password)){
 		
       $_SESSION['session_username'] = $_POST['input_username'];
       $_SESSION['session_password'] = md5($_POST['input_password']);
    
       $link = mysql_connect('localhost', 'fm', 'fm') or die('No existe Servidor - Error:: ' . mysql_error());
       mysql_select_db('fm') or die('No existe Base de Datos');
    $query = "select max(id) maximo from usuarios_log";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error()); 
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{			
    	$maximo = $line["maximo"];			  
    } 		 
    $query = "INSERT INTO usuarios_log VALUES($maximo+1,'$username',sysdate(),1)";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error()); 		 
    mysql_close($link);
    }
}
else if (isset($_GET['action']) && $_GET['action'] == "logout")
{    
  if (isset($_SESSION['session_username']))
   {
    $link = mysql_connect('localhost', 'fm', 'fm') or die('No existe Servidor - Error:: ' . mysql_error());
    mysql_select_db('fm') or die('No existe Base de Datos');
    $var=$_SESSION['session_username'];
    $query = "select max(id) maximo from usuarios_log";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error()); 
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{			
    	$maximo = $line["maximo"];			  
    }      
    $query = "INSERT INTO usuarios_log VALUES($maximo+1,'$var',sysdate(),0)";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error()); 
    mysql_close($link);
    }
    $_SESSION = array();
    session_destroy();
    setcookie(session_name(),"",0,"/");
    
}

?>