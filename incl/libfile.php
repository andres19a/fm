<?php

if (!@include_once("./incl/auth.inc.php"))
 include_once("../incl/auth.inc.php");

include("../conf/config.inc.php");
include("../incl/functions.inc.php");
include("../lang/$language.inc.php");

if (isset($_GET['action']) && $_GET['action'] == "download")
{
    session_cache_limiter("public, post-check=50");
    header("Cache-Control: private");
    $link = mysql_connect('localhost', 'fm', 'fm') or die('No existe Servidor - Error:: ' . mysql_error());
    mysql_select_db('fm') or die('No existe Base de Datos');
    $var=$_SESSION['session_username'];
    $query = "select max(id) maximo from movimientos";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error()); 
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{			
    	$maximo = $line["maximo"];			  
    }
		$archivo= $_GET['filename'];
		$direccion= $_GET['path'];
    $query = "INSERT INTO movimientos VALUES($maximo+1,'$var',sysdate(),null,null,'$archivo','$direccion',0)";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error()); 
    mysql_close($link);
}
if (isset($_GET['action']) && $_GET['action'] == "download1")
{
    session_cache_limiter("public, post-check=50");
    header("Cache-Control: private");
    $link = mysql_connect('localhost', 'fm', 'fm') or die('No existe Servidor - Error:: ' . mysql_error());
    mysql_select_db('fm') or die('No existe Base de Datos');
    $var=$_SESSION['session_username'];
    $query = "select max(id) maximo from movimientos";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error()); 
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{			
    	$maximo = $line["maximo"];			  
    }
		$archivo= $_GET['filename'];
		$direccion= $_GET['path'];
    $query = "INSERT INTO movimientos VALUES($maximo+1,'$var',sysdate(),null,null,'$archivo','$direccion',1)";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error()); 
    mysql_close($link);
}


if (isset($session_save_path)) session_save_path($session_save_path);

if (isset($_GET['path'])) $path = validate_path($_GET['path']);
if (!isset($path)) $path = FALSE;
if ($path == "./" || $path == ".\\" || $path == "/" || $path == "\\") $path = FALSE;

if (isset($_GET['filename'])) $filename = basename(stripslashes($_GET['filename']));

if ($AllowDownload || $AllowView)
{
 if (isset($_GET['filename']) && isset($_GET['action']) && is_file($home_directory.$path.$filename) || is_file("../".$home_directory.$path.$filename))
 {
  if (is_file($home_directory.$path.$filename) && !strstr($home_directory, "./") && !strstr($home_directory, ".\\"))
   $fullpath = $home_directory.$path.$filename;
  else if (is_file("../".$home_directory.$path.$filename))
   $fullpath = "../".$home_directory.$path.$filename;

  if (!$AllowDownload && $AllowView && !is_viewable_file($filename))
  {
   print "<font color='#CC0000'>$StrAccessDenied</font>";
   exit();
  }

  header("Content-Type: ".get_mimetype($filename));
  header("Content-Length: ".filesize($fullpath));
  if ($_GET['action'] == "download");
   header("Content-Disposition: attachment; filename=$filename");

  readfile($fullpath);
  
 }
 else
  print "<font color='#CC0000'>$StrDownloadFail</font>";
}

?>