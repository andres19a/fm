<?php

if (!@include_once("./incl/auth.inc.php"))
 include_once("../incl/auth.inc.php");

if ($AllowDownload)
{
  print "<table class='index' width=500 cellpadding=0 cellspacing=0>";
   print "<tr>";
    print "<td class='iheadline' height=21>";
     print "<font class='iheadline'>&nbsp;$StrDownload \"".htmlentities($filename)."\"</font>";
    print "</td>";
    print "<td class='iheadline' align='right' height=21>";
     print "<font class='iheadline'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."'><img src='icon/back.gif' border=0 alt='$StrBack'></a></font>";
    print "</td>";
   print "</tr>";
   print "<tr>";
    print "<td valign='top' colspan=2>";
     print "<center><br />";
      print "$StrDownloadClickLink<br /><br />";      
      if(strpos($filename,"(") == 0)
			{
			print "<a href='incl/libfile.php?".SID."&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($filename))."&amp;action=download'>$StrDownloadClickHere <i>\"".htmlentities($filename)."\"</i></a>";
      print "<br><br><a href='incl/libfile.php?".SID."&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($filename))."&amp;action=download1'>$StrDownloadClickHere2 <i>\"".htmlentities($filename)."\"</i></a>";
      }
			else
      { 
      print "<br><br><a href='incl/libfile.php?".SID."&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($filename))."&amp;action=download1'>$StrDownloadClickHere2 <i>\"".htmlentities($filename)."\"</i></a>";
      }      
     print "<br /><br /></center>";
     print "</td>";
   print "</tr>";
  print "</table>";
}
else
 print "<font color='#CC0000'>$StrAccessDenied</font>";

?>