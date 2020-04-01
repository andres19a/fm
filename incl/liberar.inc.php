<?php

if (!@include_once("./incl/auth.inc.php"))
 include_once("../incl/auth.inc.php");

if ($Allowliberar)
{
   print "<table class='index' width=500 cellpadding=0 cellspacing=0>";
   print "<tr>";
   print "<td class='iheadline' height=21>";
   print "<font class='iheadline'>&nbsp;Liberar \"".htmlentities($filename)."\"</font>";
   print "</td>";
   print "<td class='iheadline' align='right' height=21>";
   print "<font class='iheadline'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."'><img src='icon/back.gif' border=0 alt='$StrBack'></a></font>";
   print "</td>";
   print "</tr>";
   print "<tr>";
   print "<td valign='top' colspan=2>";
   print "<center><br />";
   print "El archivo esta Liberado.<br /><br />";      
   $link = mysql_connect('localhost', 'fm', 'fm') or die('No existe Servidor - Error :: ' . mysql_error());
   mysql_select_db('fm') or die('No existe Base de Datos');
   $user=$_SESSION['session_username'];
$query = "update movimientos set revisar = 1 where usuario = '$user' and archivo = '$filename' and fecha_entrega is null and revisar = 0";
   $result = mysql_query($query) or die('Query failed: ' . mysql_error());

      if(strpos($filename,"(") == 0)
			{
		#	print "<a href='incl/libfile.php?".SID."&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($filename))."&amp;action=download'>$StrDownloadClickHere <i>\"".htmlentities($filename)."\"</i></a>";
     # print "<br><br><a href='incl/libfile.php?".SID."&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($filename))."&amp;action=download1'>$StrDownloadClickHere2 <i>\"".htmlentities($filename)."\"</i></a>";
      }
			else
      { 
#print "<br><br><a href='incl/libfile.php?".SID."&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($filename))."&amp;action=download1'>$StrDownloadClickHere2 <i>\"".htmlentities($filename)."\"</i></a>";
      }      
     print "<br /><br /></center>";
     print "</td>";
   print "</tr>";
  print "</table>";
}
else
 print "<font color='#CC0000'>$StrAccessDenied</font>";

?>
