<?php

if (!@include_once("./incl/auth.inc.php"))
 include_once("../incl/auth.inc.php");

if ($AllowAdmin && isset($_GET['admin']))
{
print "<table class='index' width=500 cellpadding=0 cellspacing=0>";
   print "<tr>";
    print "<td class='iheadline' height=21>";
     print "<font class='iheadline'><center>$StrAdmin</center></font>";
    print "</td>";
    print "<td class='iheadline' align='right' height=21>";
     print "<font class='iheadline'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."'><img src='icon/back.gif' border=0 alt='$StrBack'></a></font>";
    print "</td>";
   print "</tr>";
   print "<tr>";
    print "<td valign='top' colspan=2>";
     print "<center><br />";
      print "$StrAdminClickLink<br /><br />";
    print "<form action='$base_url&amp;output=admin&amp;admin=true' method='post' enctype='multipart/form-data'>";
       print "<tr><td><center>$StrAdminClickHere</td><td><input type='text' name='txtusuario' size=30 value='%'></center></td></tr>";
    print "<tr><td><center>$StrAdminClickHere2</td><td><input type='text' name='txtarchivo' size=30 value='%'></center></td></tr>"; 
   # print "<tr><td><center>$StrAdminClickHere3</td><td><input type='text' name='txtfechadescarga1' size=12> y <input type='text' name='txtfechadescarga2' size=12></center></td></tr>"; 
   # print "<tr><td><center>$StrAdminClickHere4</td><td><input type='text' name='txtfechaentrega1' size=12> y <input type='text' name='txtfechaentrega2' size=12></center></td></tr>"; 
    print "<tr><td></td><td><br><center><input class='bigbutton' type='submit' value='$StrAdminB'></center><br></td></tr>";   
 print "<br /><br /></center>";
     print "</td>";
   print "</tr>";
  print "</table>"; 

  if (isset($_POST['txtusuario'])) $user=$_POST['txtusuario']; else $user='%';
	if (isset($_POST['txtarchivo'])) $arch=$_POST['txtarchivo']; else $arch='%';
  #if (isset($_POST['txtfechadescarga1'])) $f_descarga1='01-JUN-2007';	else $f_descarga1=$_POST['txtfechadescarga1'];  
  #if (isset($_POST['txtfechadescarga2'])) $f_descarga2='01-JUN-2010';	else $f_descarga2=$_POST['txtfechadescarga2'];  
  #if (isset($_POST['txtfechaentrega1'])) $f_entrega1='01-JUN-2007';	else $f_entrega1=$_POST['txtfechaentrega1'];  
  #if (isset($_POST['txtfechaentrega2'])) $f_entrega2='01-JUN-2010';	else $f_entrega2=$_POST['txtfechaentrega2'];  
	$link = mysql_connect('localhost', 'fm', 'fm') or die('No existe Servidor - Error:: ' . mysql_error());
  mysql_select_db('fm') or die('No existe Base de Datos');
  #$user=$_SESSION['session_username'];
  $query = "select usuario,fecha_descarga fec_des,DATE_FORMAT(fecha_descarga,'%H:%i %d-%m-%Y') fecha_descarga,DATE_FORMAT(fecha_entrega,'%H:%i %d-%m-%Y') fecha_entrega,archivo,revisar,comentarios from movimientos where usuario like '$user' and archivo like '$arch' order by 2 asc";
  $result = mysql_query($query) or die('Query failed: ' . mysql_error()); 
	$query2 = "select count(*) cont from movimientos where usuario like '$user' and archivo like '$arch'" ;
  $result2 = mysql_query($query2) or die('No existe Base de Datos' . mysql_error());    
  while ($line2 = mysql_fetch_array($result2, MYSQL_ASSOC)) 
		{			
    	$cont=$line2["cont"];
    }
    if ($cont > 0) {
      
      echo "<br><table class='index' width=700 cellpadding=1 cellspacing=0 border=3>\n";
      echo "<tr>";        
			 echo "<td class='iheadline' align='center' height=21><b>Usuario</b></td>";  							 
			 echo "<td class='iheadline' align='center' height=21><b>Fecha de Descarga</b></td>"; 			 
			 echo "<td class='iheadline' align='center' height=21><b>Fecha de Entrega</b></td>"; 			 
			 echo "<td class='iheadline' align='center' height=21><b>Archivo</b></td>";  			
			 echo "<td class='iheadline' align='center' height=21><b>Reviso</b></td>";
                         echo "<td class='iheadline' align='center' height=21><b>Comentario</b></td>";  			
      echo "</tr>";
    }
    else 
    {
      echo "<br><b>No existe informacion.</b>";
    }
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{	
   $usuario=$line["usuario"];
   $fecha_descarga=$line["fecha_descarga"]; 
   $fecha_entrega=$line["fecha_entrega"];
	 $archivo=$line["archivo"];  	 
	 $reviso=$line["revisar"];
   $comentario=$line["comentarios"];
	 if ($reviso == 1) $revisar="Si";
	 if ($reviso == 0) $revisar="No";
   
    echo "\t<tr>\n";
   	echo "\t\t<td><center>$usuario</center></td>\n";   	
   	echo "\t\t<td width=110><center>$fecha_descarga</center></td>\n";
   	echo "\t\t<td width=110><center>$fecha_entrega</center></td>\n";
   	echo "\t\t<td>$archivo</td>\n";   	
   	echo "\t\t<td><center>$revisar</center></td>\n";
        echo "\t\t<td>$comentario</td>\n";   	
   	
   	#echo "<td align='center' valign='bottom'><a href='$base_url&amp;filename=".htmlentities(rawurlencode($archivo))."&amp;path=".htmlentities(rawurlencode($path2))."&amp;action=upload'><img src='icon/upload.gif' width=20 height=22 alt='$StrMenuUploadFiles' border=0>&nbsp;$StrMenuUploadFiles</a></td>";
   	# echo "\t\t<td><a href=eliminar_cursos.php?curso=$curso>Eliminar</a></td>\n";
   	#echo "\t\t<td><a href=modificar_curso1.php?curso=$curso&nombre=$nombre&horario=$horario&aula=$aula>Modificar</a></td>\n";
   	echo "\t</tr>\n";
  }
  echo "</table>\n";	
    mysql_close($link);

  #if ($AllowUpload) print "<td align='center' valign='bottom'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;action=upload'><img src='icon/upload.gif' width=20 height=22 alt='$StrMenuUploadFiles' border=0>&nbsp;$StrMenuUploadFiles</a></td>";
  #if ($phpfm_auth) print "<td align='center' valign='bottom'><a href='$base_url&amp;action=logout'><img src='icon/logout.gif' width=20 height=22 alt='$StrMenuLogOut' border=0>&nbsp;$StrMenuLogOut</a></td>";
print "</table><br />";
     
     
     print "<br /><br /></center>";
     print "</td>";
   print "</tr>";
  print "</table>";
}
else if ($AllowAdmin)
{
    print "<table class='index' width=500 cellpadding=0 cellspacing=0>";
    print "<tr>";
    print "<td class='iheadline' height=21>";
    print "<font class='iheadline'><center>$StrAdmin</center></font>";
    print "</td>";
    print "<td class='iheadline' align='right' height=21>";
    print "<font class='iheadline'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."'><img src='icon/back.gif' border=0 alt='$StrBack'></a></font>";
    print "</td>";
    print "</tr>";
    print "<tr>";
    print "<td valign='top' colspan=2>";
    print "<center><br />";
    print "$StrAdminClickLink<br /><br />";
    print "<form action='$base_url&amp;output=admin&amp;admin=true' method='post' enctype='multipart/form-data'>";
    print "<tr><td><center>$StrAdminClickHere</td><td><input type='text' name='txtusuario' size=30 value='%'></center></td></tr>";
    print "<tr><td><center>$StrAdminClickHere2</td><td><input type='text' name='txtarchivo' size=30 value='%'></center></td></tr>"; 
    #print "<tr><td><center>$StrAdminClickHere3</td><td><input type='text' name='txtfechadescarga1' size=12> y <input type='text' name='txtfechadescarga2' size=12></center></td></tr>"; 
    #print "<tr><td><center>$StrAdminClickHere4</td><td><input type='text' name='txtfechaentrega1' size=12> y <input type='text' name='txtfechaentrega2' size=12></center></td></tr>"; 
    print "<tr><td></td><td><br><center><input class='bigbutton' type='submit' value='$StrAdminB'></center><br></td></tr>";   
    #print "<a href='incl/libadmin.php?".SID."&amp;action=admin'>$StradClickHere <i>\"".htmlentities($filename)."\"</i></a>";
    #print "<br><br><a href='incl/libfile.php?".SID."&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($filename))."&amp;action=download1'>$StrDownloadClickHere2 <i>\"".htmlentities($filename)."\"</i></a>";
    
    print "<br /><br /></center>";
    print "</td>";
    print "</tr>";
  print "</table>";
}


?>