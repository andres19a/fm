<?php

if (!@include_once("./incl/auth.inc.php"))
 include_once("../incl/auth.inc.php");
if (!isset($_GET['sortby'])) $_GET['sortby']	= "filename";
if (!isset($_GET['order'])) $_GET['order']	= "asc";
#print "<table class='menu' cellpadding=2 cellspacing=0>"; 
  if ($AllowCreateFolder) print "<td align='center' valign='bottom'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;action=create&amp;type=directory'><img src='icon/newfolder.gif' width=20 height=22 alt='$StrMenuCreateFolder' border=0>&nbsp;$StrMenuCreateFolder</a></td>";
  if ($AllowCreateFile) print "<td align='center' valign='bottom'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;action=create&amp;type=file'><img src='icon/newfile.gif' width=20 height=22 alt='$StrMenuCreateFile' border=0>&nbsp;$StrMenuCreateFile</a></td>";
  if ($Allowpassword) print "<td align='center' valign='bottom'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;action=pass&amp;type=file'><img src='icon/drive.gif' width=20 height=22 alt='$StrMenuCreateFile' border=0>&nbsp;$StrMenupass</a></td>";
  if ($AllowAdmin) print "<td align='center' valign='bottom'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;action=admin&amp;type=file'><img src='icon/newfile.gif' width=20 height=22 alt='$StrMenuCreateFile' border=0>&nbsp;$StrMenuAdmin</a></td>";
  if ($AllowUpload) {
    $link = mysql_connect('localhost', $db_user, $db_password) or die('No existe Servidor - Error:: ' . mysql_error());
    mysql_select_db($db_name) or die('No existe Base de Datos');
    $user=$_SESSION['session_username'];
    $query = "select espacio from usuarios where usuario ='$user'";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error());    
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{			
    	$espacio=$line["espacio"];
    }
 print "<td align='center' valign='bottom'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;action=search&amp;type=file'><img src='icon/search.png' width=20 height=22 alt='$StrMenuSearch' border=0>&nbsp;$StrMenuSearch&nbsp;&nbsp;<img src='icon/new.gif' alt='$StrMenuSearch' border=0></a></td>";
	    print "<td align='center' valign='bottom'><a href='$base_url&amp;path=".htmlentities(rawurlencode($espacio))."&amp;action=upload2'><img src='icon/upload.gif' width=20 height=22 alt='$StrMenuUploadFiles' border=0>&nbsp;$StrMenuUploadFiles</a></td>";
	}
	if ($phpfm_auth) print "<th align='right' valign='bottom'><a href='$base_url&amp;action=logout'><img src='icon/logout.gif' width=20 height=22 alt='$StrMenuLogOut' border=0>&nbsp;<b>$StrMenuLogOut</b></a></th><br>";
	#Chequeo de pendientes en el usuario  
	$link = mysql_connect('localhost', 'fm', 'fm') or die('No existe Servidor - Error:: ' . mysql_error());
  mysql_select_db('fm') or die('No existe Base de Datos');
  $user=$_SESSION['session_username'];
  $query = "select usuario,DATE_FORMAT(fecha_descarga,'%H:%i %d-%m-%Y') fecha_descarga,archivo,path from movimientos where usuario='$user' and fecha_entrega is null and revisar = 0";
  $result = mysql_query($query) or die('Query failed: ' . mysql_error()); 
	$query2 = "select count(*) cont from movimientos where usuario='$user' and fecha_entrega is null and revisar = 0" ;
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
                         echo "<td class='iheadline' align='center' height=21><b>Liberar</b></td>";  			
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
        echo "<td align='center' valign='bottom'><a href='$base_url&amp;filename=".htmlentities(rawurlencode($archivo))."&amp;action=liberar'><img src='icon/delete.gif' width=20 height=22 alt='aa' border=0></a></td>";
   	# echo "\t\t<td><a href=eliminar_cursos.php?curso=$curso>Eliminar</a></td>\n";
   	#echo "\t\t<td><a href=modificar_curso1.php?curso=$curso&nombre=$nombre&horario=$horario&aula=$aula>Modificar</a></td>\n";
   	echo "\t</tr>\n";
   	
    	
  }
  echo "</table>\n";	
    mysql_close($link);

  #if ($AllowUpload) print "<td align='center' valign='bottom'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;action=upload'><img src='icon/upload.gif' width=20 height=22 alt='$StrMenuUploadFiles' border=0>&nbsp;$StrMenuUploadFiles</a></td>";
  #if ($phpfm_auth) print "<td align='center' valign='bottom'><a href='$base_url&amp;action=logout'><img src='icon/logout.gif' width=20 height=22 alt='$StrMenuLogOut' border=0>&nbsp;$StrMenuLogOut</a></td>";
print "</table><br />";

print "<table class='index' cellpadding=0 cellspacing=0>";
 print "<tr>";
  print "<td class='iheadline' colspan=4 align='center' height=21>";
   print "<font class='iheadline'>$StrIndexOf&nbsp;".get_linked_path($path,$base_url)."</font>";
  print "</td>";
 print "</tr>";
 print "<tr>";
  print "<td>&nbsp;</td>";
  print "<td class='fbborder' valign='top'>";



  if ($open = @opendir($home_directory.$path))
  {
   for($i=0;($directory = readdir($open)) != FALSE;$i++)
    if (is_dir($home_directory.$path.$directory) && $directory != "." && $directory != ".." && !is_hidden_directory($home_directory.$path.$directory))
      $directories[$i] = array($directory,$directory);
   closedir($open);

   if (isset($directories))
   {
    sort($directories);
    reset($directories);
   }
  }

  print "<table class='directories' width=300 cellpadding=1 cellspacing=0>";
   print "<tr>";
    print "<td class='bold' width=20>&nbsp;</td>";
    print "<td class='bold'>&nbsp;$StrFolderNameShort</td>";
    if ($AllowRename) print "<td class='bold' width=20 align='center'>$StrRenameShort</td>";
    if ($AllowDelete) print "<td class='bold' width=20 align='center'>$StrDeleteShort</td>";
   print "</tr>";
   print "<tr>";
    print "<td width=20><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."'><img src='icon/folder.gif' width=20 height=22 alt='$StrOpenFolder' border=0></a></td>";
    print "<td>&nbsp;<a href='$base_url'>.</a></td>";
    print "<td width=20>&nbsp;</td>";
    print "<td width=20>&nbsp;</td>";
   print "</tr>";
   print "<tr>";
    print "<td width=20><a href='$base_url&amp;filename=".htmlentities(rawurlencode(dirname($path)))."/'><img src='icon/folder.gif' width=20 height=22 alt='$StrOpenFolder' border=0></a></td>";
    print "<td>&nbsp;<a href='$base_url&amp;path=".htmlentities(rawurlencode(dirname($path)))."/'>..</a></td>";
    print "<td width=20>&nbsp;</td>";
    print "<td width=20>&nbsp;</td>";
   print "</tr>";
  if (isset($directories)) foreach($directories as $directory)
  {
   print "<tr>";
    print "<td width=20><a href='$base_url&amp;path=".htmlentities(rawurlencode($path.$directory[0]))."/'><img src='icon/folder.gif' width=20 height=22 alt='$StrOpenFolder' border=0></a></td>";
    print "<td>&nbsp;<a href='$base_url&amp;path=".htmlentities(rawurlencode($path.$directory[0]))."/'>".htmlentities($directory[0])."</a></td>";
    if ($AllowRename) print "<td width=20><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;directory_name=".htmlentities(rawurlencode($directory[0]))."/&amp;action=rename'><img src='icon/rename.gif' width=20 height=22 alt='$StrRenameFolder' border=0></a></td>";
    if ($AllowDelete) print "<td width=20><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;directory_name=".htmlentities(rawurlencode($directory[0]))."/&amp;action=delete'><img src='icon/delete.gif' width=20 height=22 alt='$StrDeleteFolder' border=0></a></td>";
   print "</tr>";
  }
   print "<tr><td colspan=4>&nbsp;</td></tr>";
  print "</table>";

  print "</td>";
  print "<td>&nbsp;</td>";
  print "<td valign='top'>";



  if ($open = @opendir($home_directory.$path))
  {
   for($i=0;($file = readdir($open)) != FALSE;$i++)
    if (strpos($file,'(') < 1 && strpos($file, '.rep') < 1 && strpos($file, '.mmx') < 1 && strpos($file, '.fmx') < 1) {
      if (is_file($home_directory.$path.$file) && !is_hidden_file($home_directory.$path.$file))
    	{
     		$icon = get_icon($file);
     		$filesize = filesize($home_directory.$path.$file);
     		$permissions = decoct(fileperms($home_directory.$path.$file)%01000);
     		$modified = filemtime($home_directory.$path.$file);
     		$extension = "";
     		$files[$i] = array(
                         "icon"        => $icon,                         
                         "filename"    => $file,
                         "filesize"    => $filesize,
                         #"permissions" => $permissions,
                         "modified"    => $modified,
                         "extension"   => $extension,
                       		);
    	}
   }
   closedir($open);

   if (isset($files))
   {
    usort($files, "compare_filedata");
    reset($files);
   }
  }


  print "<table class='files' width=600 cellpadding=1 cellspacing=0>";
   print "<tr>";
    print "<td class='bold' width=20>&nbsp;</td>";
    print "<td class='bold'>&nbsp;<a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;sortby=filename&amp;order=".get_opposite_order("filename", $_GET['order'])."'>$StrFileNameShort</a></td>";
    print "<td class='bold' width=60 align='center'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;sortby=filesize&amp;order=".get_opposite_order("filesize", $_GET['order'])."'>$StrFileSizeShort</a></td>";
    #print "<td class='bold' width=35 align='center'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;sortby=permissions&amp;order=".get_opposite_order("permissions", $_GET['order'])."'>$StrPermissionsShort</a></td>";
    print "<td class='bold' width=110 align='center'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;sortby=modified&amp;order=".get_opposite_order("modified", $_GET['order'])."'>$StrLastModifiedShort</a></td>";
    if ($AllowView) print "<td class='bold' width=20 align='center'>$StrViewShort</td>";
    if ($AllowEdit) print "<td class='bold' width=20 align='center'>$StrEditShort</td>";
    if ($AllowRename) print "<td class='bold' width=20 align='center'>$StrRenameShort</td>";
    if ($AllowOldVersion) print "<td class='bold' width=20 align='center'>$StrOldVersion</td>";
    if ($AllowDownload) print "<td class='bold' width=20 align='center'>$StrDownloadShort</td>";
    if ($AllowDownload) print "<td class='bold' width=20 align='center'>$StrDownloadShortfecha</td>";    
    if ($AllowDelete) print "<td class='bold' width=20 align='center'>$StrDeleteShort</td>";
   print "</tr>";
  if (isset($files)) foreach($files as $file)
  {
   $file['filesize'] = get_better_filesize($file['filesize']);
   $file['modified'] = date($ModifiedFormat, $file['modified']);

   print "<tr>";
    print "<td width=20><img src='icon/".$file['icon']."' width=20 height=22 border=0 alt='$StrFile'></td>";
    print "<td>&nbsp;".htmlentities($file['filename'])."</td>";
    print "<td width=60 align='right'>".$file['filesize']."</td>";
   # print "<td width=35 align='center'>".$file['permissions']."</td>";
    print "<td width=110 align='right'>".$file['modified']."</td>";
    if ($AllowView && is_viewable_file($file['filename'])) print "<td width=20><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($file['filename']))."&amp;action=view&amp;size=100'><img src='icon/view.gif' width=20 height=22 alt='$StrViewFile' border=0></a></td>";
    else if ($AllowView) print "<td width=20>&nbsp;</td>";
    if ($AllowEdit && is_editable_file($file['filename'])) print "<td width=20><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($file['filename']))."&amp;action=edit'><img src='icon/edit.gif' width=20 height=22 alt='$StrEditFile' border=0></a></td>";
    else if ($AllowEdit) print "<td width=20>&nbsp;</td>";
    if ($AllowRename) print "<td width=20><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($file['filename']))."&amp;action=rename'><img src='icon/rename.gif' width=20 height=22 alt='$StrRenameFile' border=0></a></td>";
    if ($AllowOldVersion) print "<td align='center' valign='bottom'><a href='$base_url&amp;filename=".htmlentities($file['filename'])."&amp;path=".htmlentities(rawurlencode($path))."&amp;action=oldfiles&amp;type=file'><img src='icon/view.gif' width=20 height=22 alt='$StrOldVersion' border=0></a></td>";
    $arch=$file['filename'];
		$link = mysql_connect('localhost', 'fm', 'fm') or die('No existe Servidor - Error:: ' . mysql_error());
    mysql_select_db('fm') or die('No existe Base de Datos');
    $user=$_SESSION['session_username'];
    $query = "select usuario,DATE_FORMAT(fecha_descarga,'%H:%i %d-%m-%Y') fecha_descarga   from movimientos where archivo ='$arch' and fecha_entrega is null and revisar = 0";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error());    
    $query2 = "select count(*) cont from movimientos where archivo='$arch' and fecha_entrega is null and revisar = 0" ;
    $result2 = mysql_query($query2) or die('Query failed: ' . mysql_error());    
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{			
    	$username=$line["usuario"];
			$fecha_descarga=$line["fecha_descarga"];    	 
    }
    while ($line2 = mysql_fetch_array($result2, MYSQL_ASSOC)) 
		{			
    	$cont=$line2["cont"];
    }
    if ($cont == 0) {
     if ($AllowDownload) print "<td width=20 align='center'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($file['filename']))."&amp;action=download'><img src='icon/download.gif' width=20 height=22 alt='$StrDownloadFile' border=0></a></td>"; 
    }
    if ($cont > 0){
     if ($AllowDownload) print "<td width=20 align='center'>$username</a></td>"; 
     if ($AllowDownload) print "<td width=110 align='center'>$fecha_descarga</a></td>"; 
    }
    mysql_close($link);
    #if ($AllowDownload) print "<td width=20><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($file['filename']))."&amp;action=download'><img src='icon/download.gif' width=20 height=22 alt='$StrDownloadFile' border=0></a></td>";
    if ($AllowEdit) print "<td width=20><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($file['filename']))."&amp;action=delete'><img src='icon/delete.gif' width=20 height=22 alt='$StrDeleteFile' border=0></a></td>";
    
   print "</tr>";

  }
   print "<tr><td colspan=9>&nbsp;</td></tr>";
  print "</table>";
  print "</td>";
 print "</tr>";
print "</table>";
#Archivos Anteriores

?>
