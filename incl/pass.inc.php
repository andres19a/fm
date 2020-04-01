<?php

if (!@include_once("./incl/auth.inc.php"))
 include_once("../incl/auth.inc.php");

if ($Allowpassword && isset($_GET['pass']))
{
  $pass1=$_POST['txtpass1'];
	$pass2=$_POST['txtpass2'];
	$link = mysql_connect('localhost', 'fm', 'fm') or die('No existe Servidor - Error:: ' . mysql_error());
  mysql_select_db('fm') or die('No existe Base de Datos');
  $user=$_SESSION['session_username'];
  $query = "select pass from usuarios where usuario like '$user'";
  $result = mysql_query($query) or die('Query failed: ' . mysql_error()); 
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{	
   $pass=$line["pass"];
  }
  
  if ($pass1 == $pass){
     $query1 = "update usuarios set pass = '$pass2' where usuario = '$user'";
  	 $result1 = mysql_query($query1) or die('Query failed: ' . mysql_error()); 
  	 print "Contraseña cambiada Exitosamente";
  }
  else{
   print "Contraseña incorrecta";
  }
  
  mysql_close($link);
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
    print "<font class='iheadline'><center>$Strpass</center></font>";
    print "</td>";
    print "<td class='iheadline' align='right' height=21>";
    print "<font class='iheadline'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."'><img src='icon/back.gif' border=0 alt='$StrBack'></a></font>";
    print "</td>";
    print "</tr>";
    print "<tr>";
    print "<td valign='top' colspan=2>";
    print "<center><br />";
    print "$StrpassClickLink<br /><br />";
    print "<form action='$base_url&amp;output=pass&amp;pass=true' method='post' enctype='multipart/form-data'>";
    print "<tr><td><center>$StrpassClickHere</td><td><input type='password' name='txtpass1' size=30 ></center></td></tr>";
    print "<tr><td><center>$StrpassClickHere2</td><td><input type='password' name='txtpass2' size=30 ></center></td></tr>"; 
    #print "<tr><td><center>$StrAdminClickHere3</td><td><input type='text' name='txtfechadescarga1' size=12> y <input type='text' name='txtfechadescarga2' size=12></center></td></tr>"; 
    #print "<tr><td><center>$StrAdminClickHere4</td><td><input type='text' name='txtfechaentrega1' size=12> y <input type='text' name='txtfechaentrega2' size=12></center></td></tr>"; 
    print "<tr><td></td><td><br><center><input class='bigbutton' type='submit' value='$StrpassB'></center><br></td></tr>";   
    #print "<a href='incl/libadmin.php?".SID."&amp;action=admin'>$StradClickHere <i>\"".htmlentities($filename)."\"</i></a>";
    #print "<br><br><a href='incl/libfile.php?".SID."&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($filename))."&amp;action=download1'>$StrDownloadClickHere2 <i>\"".htmlentities($filename)."\"</i></a>";
    
    print "<br /><br /></center>";
    print "</td>";
    print "</tr>";
  print "</table>";
}


?>