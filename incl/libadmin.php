<?php

if (!@include_once("./incl/auth.inc.php"))
 include_once("../incl/auth.inc.php");

include("../conf/config.inc.php");
include("../incl/functions.inc.php");
include("../lang/$language.inc.php");

if (isset($_GET['action']) && $_GET['action'] == "admin")
{
    session_cache_limiter("public, post-check=50");
    header("Cache-Control: private");
   /* $link = mysql_connect('localhost', 'fm', 'fm') or die('No existe Servidor - Error:: ' . mysql_error());
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
    mysql_close($link);*/
    
  $link = mysql_connect('localhost', 'fm', 'fm') or die('No existe Servidor - Error:: ' . mysql_error());
  mysql_select_db('fm') or die('No existe Base de Datos');
  $user=$_SESSION['session_username'];
  $query = "select usuario,DATE_FORMAT(fecha_descarga,'%H:%i %d-%m-%Y') fecha_descarga,archivo,path from movimientos where usuario='$user' and fecha_entrega is null and revisar = 0";
  $result = mysql_query($query) or die('Query failed: ' . mysql_error()); 
	$query2 = "select count(*) cont from movimientos where usuario='$user' and fecha_entrega is null" ;
  $result2 = mysql_query($query2) or die('No existe Base de Datos' . mysql_error());    
  while ($line2 = mysql_fetch_array($result2, MYSQL_ASSOC)) 
		{			
    	$cont=$line2["cont"];
    }
    if ($cont > 0) {
      echo "<br><b>Archivos Pendientes</b>";
      echo "<br><table class='index' width=600 cellpadding=1 cellspacing=0 border=3>\n";
      echo "<tr>";        
			 echo "<td class='iheadline' align='center' height=21><b>Usuario</b></td>";  							 
			 echo "<td class='iheadline' align='center' height=21><b>Fecha de Descarga</b></td>"; 			 
			 echo "<td class='iheadline' align='center' height=21><b>Archivo</b></td>"; 			 
			 echo "<td class='iheadline' align='center' height=21><b>Entregar</b></td>";  			
      echo "</tr>";
    }
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{	
   $usuario=$line["usuario"];
   
   $fecha_descarga=$line["fecha_descarga"]; 
   Global $archivo;
   $archivo=$line["archivo"];
	 $path2=$line["path"];  	 
   
    echo "\t<tr>\n";
   	echo "\t\t<td>$usuario</td>\n";   	
   	echo "\t\t<td>$fecha_descarga</td>\n";
   	echo "\t\t<td>$archivo</td>\n";   	
   	
   	echo "<td align='center' valign='bottom'><a href='$base_url&amp;filename=".htmlentities(rawurlencode($archivo))."&amp;path=".htmlentities(rawurlencode($path2))."&amp;action=upload'><img src='icon/upload.gif' width=20 height=22 alt='$StrMenuUploadFiles' border=0>&nbsp;$StrMenuUploadFiles</a></td>";
   	# echo "\t\t<td><a href=eliminar_cursos.php?curso=$curso>Eliminar</a></td>\n";
   	#echo "\t\t<td><a href=modificar_curso1.php?curso=$curso&nombre=$nombre&horario=$horario&aula=$aula>Modificar</a></td>\n";
   	echo "\t</tr>\n";
   	
    	
  }
  echo "</table>\n";	
    mysql_close($link);
}

/*
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
}*/

?>