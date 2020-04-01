<?php

print "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">";

print "<html>";
 print "<head>";
  print "<title>UNIVERSIDAD GALILEO - INFORMATICA - 2007</title>";
  print "<link rel='stylesheet' href='incl/phpfm.css' type='text/css'>";
 print "</head>";
 print "<body link='#0000FF' alink='#0000FF' vlink='#0000FF' bgcolor='#FFFFFF'>";
#   print "<table class='top' cellpadding=0 cellspacing=0>";
     print "<center>";
		print "<img src=logo.JPG WIDTH=85 HEIGHT=80 >";
    #print "<td align='center'><font class='headline'>  INFORMATICA - </font></td>";
    print "<td align='center'><font class='headline'>   MANEJO DE VERSIONES </font></td><br>";
		#print "<img src=bottom.jpg width=1020 height=26 ><br>";
    print "<hr>";
    
    if (isset($_SESSION['session_username']))
    {
       $link = mysql_connect('localhost', 'fm', 'fm') or die('No existe Servidor - Error:: ' . mysql_error());
       mysql_select_db('fm') or die('No existe Base de Datos');
       $user=$_SESSION['session_username'];
       $query = "select nombre from usuarios where usuario='$user'";
       $result = mysql_query($query) or die('Query failed: ' . mysql_error());    
       while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
    	 	{			
        	$nombre=$line["nombre"];    	 
    	  }
    print "<b>Login:</b> $nombre ";
    print "<br>";
    }
  print "</tr>";
  print "</table><br />";

?>