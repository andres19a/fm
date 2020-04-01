<?php
 if (!@include_once("./incl/auth.inc.php"))
 include_once("../incl/auth.inc.php");
 if (!isset($_GET['sortby'])) $_GET['sortby']	= "filename";
if (!isset($_GET['order'])) $_GET['order']	= "asc";
  

print "<table class='index' cellpadding=0 cellspacing=0>";
 print "<tr>";
  print "<td class='iheadline' colspan=4 align='center' height=21>";
   print "<font class='iheadline'>$StrOldVersion</font>";
  print "</td>";
  print "<td class='iheadline' align='right' height=21>";
    print "<font class='iheadline'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."'><img src='icon/back.gif' border=0 alt='$StrBack'></a></font>";    
   print "</td>";
 print "</tr>";
 print "<tr>";
  print "<td>&nbsp;</td>"; 
  print "<td>&nbsp;</td>";
  print "<td valign='top'>";
 if ($open = @opendir($home_directory.$path))
  {
   for($i=0;($file = readdir($open)) != FALSE; $i++){    
	 	if(strpos($filename,"6") == '1'){
		 	$oldfile = substr($filename,2,strpos($filename,".")-2);		    
	 	}else{
			$oldfile = substr($filename,1,strpos($filename,".")-1);
		}		 
		if(strpos($file,"6") == '1'){
			$comparefile = strtoupper(substr($file, 2, strpos($file,"(")-2));		
		}else{
			$comparefile = strtoupper(substr($file, 1, strpos($file,"(")-1));
		}				
		if (strtoupper(substr($file,0,1)) == strtoupper(substr($filename,0,1)) && strtoupper($comparefile) == strtoupper($oldfile) && strpos($file, '.rep') < 1 && strpos($file, '.mmx') < 1 && strpos($file, '.fmx') < 1) {
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
    print "<td class='bold'>&nbsp;$StrFileNameShort</a></td>";    
    print "<td class='bold' width=60 align='center'>$StrFileSizeShort</a></td>";    
    print "<td class='bold' width=110 align='center'>$StrLastModifiedShort</a></td>";
    if ($AllowView) print "<td class='bold' width=20 align='center'>$StrViewShort</td>";
    if ($AllowEdit) print "<td class='bold' width=20 align='center'>$StrEditShort</td>";
    if ($AllowRename) print "<td class='bold' width=20 align='center'>$StrRenameShort</td>";    
    if ($AllowDownload) print "<td class='bold' width=20 align='center'>$StrDownloadShort</td>";    
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
    print "<td width=110 align='right'>".$file['modified']."</td>";
    if ($AllowView && is_viewable_file($file['filename'])) print "<td width=20><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($file['filename']))."&amp;action=view&amp;size=100'><img src='icon/view.gif' width=20 height=22 alt='$StrViewFile' border=0></a></td>";
    else if ($AllowView) print "<td width=20>&nbsp;</td>";
    if ($AllowEdit && is_editable_file($file['filename'])) print "<td width=20><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($file['filename']))."&amp;action=edit'><img src='icon/edit.gif' width=20 height=22 alt='$StrEditFile' border=0></a></td>";
    else if ($AllowEdit) print "<td width=20>&nbsp;</td>";
    if ($AllowRename) print "<td width=20><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($file['filename']))."&amp;action=rename'><img src='icon/rename.gif' width=20 height=22 alt='$StrRenameFile' border=0></a></td>";    
    $arch=$file['filename'];
    if ($AllowEdit) print "<td width=20><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($file['filename']))."&amp;action=delete'><img src='icon/delete.gif' width=20 height=22 alt='$StrDeleteFile' border=0></a></td>";    
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
     #if ($AllowDownload) print "<td width=110 align='center'>$fecha_descarga</a></td>"; 
    }
    mysql_close($link);
		}
    print "</tr>";    
   print "<tr><td colspan=9>&nbsp;</td></tr>";
  print "</table>";
  print "</td>";
 print "</tr>";
 print "</table>";
 
?>