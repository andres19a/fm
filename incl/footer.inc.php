<?php

list($seconds, $microseconds) = explode(" ", microtime());
$time_end = $seconds + $microseconds;
$total_time = round($time_end-$time_start, 4);

print "<br /><br />";
print "<table class='bottom' cellpadding=0 cellspacing=0>";
  #print "<tr><td align='center'>Powered by PHP</a></td></tr>";
  print "<tr><td><center><img src=php-power-micro.png ><img src=powered-by-mysql-88x31.png ><img src=opensuse_2.gif><img src=images.jpg><img src=InfoPower.jpg ></center></td>";
  #print "<tr><td><center><img src=istg_poweredby3(81x64).jpg ></center></td></tr>";
  print "<tr><td align='center'><br>Copyright � 2007 Informatica</td></tr>";
  print "<tr><td>&nbsp;</td></tr>";
  print "<tr><td align='center'>";
   print "<a href='http://validator.w3.org/check/referer'><img border='0' src='icon/valid-html401.jpg' alt='Valid HTML 4.01!' height='31' width='88'></a>";
   print "<a href='http://jigsaw.w3.org/css-validator/'><img style='border:0;width:88px;height:31px' src='icon/valid-css.jpg' alt='Valid CSS!'></a>";
  print "</td></tr>";
  print "<tr><td>&nbsp;</td></tr>";
  print "<tr><td align='center'>Pagina - $total_time segundos.</td></tr>";
print "</table>";

print "<br /><br />";

print "</center>";
print "</body>";
print "</html>";

?>