<?php

if (!@include_once("./incl/auth.inc.php"))
 include_once("../incl/auth.inc.php"); 

if ($AllowUpload && isset($_GET['upload']))
{
 print "<table cellspacing=0 cellpadding=0 class='upload'>"; 
 if (!isset($_FILES['userfile']))
  // maximum post size reached
  print $StrUploadFailPost;
 else if($_POST['comentario'] != null)
 {	 		
 #Evaluacion de Archivos			 	
  $compilado = " "; 			
  $nombre	= substr($filename, 0, ($filename-4));
  $extension = substr($filename, ($filename-4), strlen($filename));		
		if (strtoupper($extension) == ".FMB"){
			$compilado = ".fmx";		
		}
		else if (strtoupper($extension) == ".MMB"){
			$compilado = ".mmx";
		}
		else if (strtoupper($extension) == ".RDF"){
			$compilado = ".rep";
		}					
  	$_FILES['userfile']['name'][0] = stripslashes($_FILES['userfile']['name'][0]);
  	$_FILES['userfile']['name'][1] = stripslashes($_FILES['userfile']['name'][1]);  	  	
    $uparchivo = $_FILES['userfile']['name'][0];
		$upcompilado = $_FILES['userfile']['name'][1];    
    $upnombre = substr($uparchivo, 0, ($uparchivo-4));	
    if(strtoupper($filename) == strtoupper($uparchivo) && strtoupper($nombre.$compilado) == strtoupper($upcompilado)){
			#Fuente 
				#Renombrar archivo fuente
				if (@file_exists($home_directory.$path.$nombre.$extension)){				    
				  	$fecha_n = date("d-m-Y");				  	
				  	if(@file_exists($home_directory.$path.$nombre."(".$fecha_n.")".$extension)){
				  		$cont = 2;
				  	  while (@file_exists($home_directory.$path.$nombre."(".$fecha_n.")".$cont.$extension)){
								$cont++;
							}
							@rename($home_directory.$path.$uparchivo, $home_directory.$path.ucfirst($nombre)."(".$fecha_n.")".$cont.$extension);
						}
						else{
							@rename($home_directory.$path.$uparchivo, $home_directory.$path.ucfirst($nombre)."(".$fecha_n.")".$extension);						
						}
				}
				#Subiendo archivo nuevo
				if (@move_uploaded_file($_FILES['userfile']['tmp_name'][0], realpath($home_directory.$path)."/".ucfirst($_FILES['userfile']['name'][0])) && strtoupper($filename) == strtoupper($uparchivo)){			  
   	 			print "<tr><td width='250'>$StrUploading ".ucfirst($_FILES['userfile']['name'][0])."</td><td width='50' align='center'>[<font color='#009900'>$StrUploadSuccess</font>]</td></tr>";    	
   	 			#Cambio de permisos
					$save=$_FILES['userfile']['name'][0];
                      		  	$location=realpath($home_directory.$path);
  			  		chmod("$location/$save", 0777);
  	 			#Bandera de Archivo Subido  	 
					$comentario = $_POST['comentario'];			
					$link = mysql_connect('localhost', 'fm', 'fm') or die('No existe Servidor - Error:: ' . mysql_error());
  				mysql_select_db('fm') or die('No existe Base de Datos');
  				$user=$_SESSION['session_username'];
  				$query = "update movimientos set fecha_entrega = sysdate(), comentarios='$comentario' where usuario = '$user' and archivo = '$filename' and fecha_entrega is null and revisar = 0";
  				$result = mysql_query($query) or die('Query failed: ' . mysql_error()); 
				}  				
    		else if ($_FILES['userfile']['name'][$i])
    			print "<tr><td width='250'>$StrUploading ".ucfirst($_FILES['userfile']['name'][0])."</td><td width='50' align='center'>[<font color='#CC0000'>$StrUploadFail</font>]</td></tr>";    	
			#Compilado
		
			if($compilado == ".rep"){
			  if (substr($path,0,5) == "naf47") {
			      $submodulo=substr($path,6,strlen($path));
			      $modulo=substr($submodulo,0,strpos($submodulo,"/"));
			      if (@move_uploaded_file($_FILES['userfile']['tmp_name'][1], realpath($naf47)."/".$modulo."/bin/".$_FILES['userfile']['name'][1]) ){
			        $save=$_FILES['userfile']['name'][1];
  			      $location=realpath($naf47)."/".$modulo."/bin/";
  			      chmod("$location/$save", 0777);
  	 			     print "<tr><td width='250'>$StrUploading ".ucfirst($_FILES['userfile']['name'][1])."</td><td width='50' align='center'>[<font color='#009900'>$StrUploadSuccess</font>]</td></tr>";    	}
    		    else if ($_FILES['userfile']['name'][$i])
    			    print "<tr><td width='250'>$StrUploading ".ucfirst($_FILES['userfile']['name'][1])."</td><td width='50' align='center'>[<font color='#CC0000'>$StrUploadFail</font>]</td></tr>";    	    	     
			  
			  }
			  else {
  			    if (@move_uploaded_file($_FILES['userfile']['tmp_name'][1], realpath($reports)."/".ucfirst($_FILES['userfile']['name'][1]))){
  			      $save=$_FILES['userfile']['name'][1];
  			      $location=realpath($reports);
  			      chmod("$location/$save", 0777);
  	 			    print "<tr><td width='250'>$StrUploading ".ucfirst($_FILES['userfile']['name'][1])."</td><td width='50' align='center'>[<font color='#009900'>$StrUploadSuccess</font>]</td></tr>";    	}
    		    else if ($_FILES['userfile']['name'][$i])
    			    print "<tr><td width='250'>$StrUploading ".ucfirst($_FILES['userfile']['name'][1])."</td><td width='50' align='center'>[<font color='#CC0000'>$StrUploadFail</font>]</td></tr>";    	    	     
    	  }
      }
      else {
        if (substr($path,0,5) == "naf47") {
			      $submodulo=substr($path,6,strlen($path));
			      $modulo=substr($submodulo,0,strpos($submodulo,"/"));
			      if (@move_uploaded_file($_FILES['userfile']['tmp_name'][1], realpath($naf47)."/".$modulo."/bin/".$_FILES['userfile']['name'][1]) ){
			        $save=$_FILES['userfile']['name'][1];
  			      $location=realpath($naf47)."/".$modulo."/bin/";
  			      chmod("$location/$save", 0777);
  	 			    print "<tr><td width='250'>$StrUploading ".ucfirst($_FILES['userfile']['name'][1])."</td><td width='50' align='center'>[<font color='#009900'>$StrUploadSuccess</font>]</td></tr>";    	}
    		    else if ($_FILES['userfile']['name'][$i])
    			    print "<tr><td width='250'>$StrUploading ".ucfirst($_FILES['userfile']['name'][1])."</td><td width='50' align='center'>[<font color='#CC0000'>$StrUploadFail</font>]</td></tr>";    	    	     
        }
        else{
      	    if (@move_uploaded_file($_FILES['userfile']['tmp_name'][1], realpath($forms)."/".ucfirst($_FILES['userfile']['name'][1]))){
      	      $save=$_FILES['userfile']['name'][1];
  			      $location=realpath($forms);
  			      chmod("$location/$save", 0777);
  	 			    print "<tr><td width='250'>$StrUploading ".ucfirst($_FILES['userfile']['name'][1])."</td><td width='50' align='center'>[<font color='#009900'>$StrUploadSuccess</font>]</td></tr>";    	}
    		    else if ($_FILES['userfile']['name'][$i])
    			    print "<tr><td width='250'>$StrUploading ".ucfirst($_FILES['userfile']['name'][1])."</td><td width='50' align='center'>[<font color='#CC0000'>$StrUploadFail</font>]</td></tr>";
    			  }
      }
   	}
  	else{
  		print "<tr><td width='250'>Usted debe subir el archivo: ".$filename."</td><td width='50' align='center'>[<font color='#CC0000'>$StrUploadFail</font>]</td></tr>";    	
  		$extension = strtoupper(substr($filename, ($filename-4), strlen($filename)));
			if (strtoupper($extension) == ".FMB"){
				$compilado = ".fmx";		
			}
			else if (strtoupper($extension) == ".MMB"){
				$compilado = ".mmx";
			}
			else if (strtoupper($extension) == ".RDF"){
				$compilado = ".rep";
			}
  		print "<tr><td width='250'>Usted debe subir el archivo: ".$nombre.$compilado."</td><td width='50' align='center'>[<font color='#CC0000'>$StrUploadFail</font>]</td></tr>";    	
  	}
 	print "</table>";
 }
 else{
 	print "<tr><td width='500'>El campo Observaciones no puede estar vacio, ingreselo por favor...</td><td width='50' align='center'>[<font color='#CC0000'>$StrUploadFail</font>]</td></tr>";    	
 	print "</table>";
 }
}

else if ($AllowUpload)
{	
 print "<table class='index' width=500 cellpadding=0 cellspacing=0>";
  print "<tr>";
   print "<td class='iheadline' height=21>";
    print "<font class='iheadline'>&nbsp;$StrUploadFilesTo \"/".htmlentities($path)."\"</font>";			  		 		  		 		    
   print "</td>";
   print "<td class='iheadline' align='right' height=21>";
    print "<font class='iheadline'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."'><img src='icon/back.gif' border=0 alt='$StrBack'></a></font>";    
   print "</td>";
  print "</tr>";
  print "<tr>";
   print "<td valign='top' colspan=2>";
    print "<center><br />"; 
		$nombre = substr($filename,0,strpos($filename,"."));   
    print "$StrUploadQuestion"."<b>$nombre:</b><br />";
    print "<form action='$base_url&amp;output=upload&amp;upload=true' method='post' enctype='multipart/form-data'>";
    print "<table class='upload'>";
    print "<tr><td>$StrFirstFile</td><td><input type='file' name='userfile[]' size=30></td></tr>";
    print "<tr><td>$StrSecondFile</td><td><input type='file' name='userfile[]' size=30></td></tr>"; 
		print "<tr><td>Observaciones(Obligatorio):</td><td><input type='text' name='comentario' size=50></td></tr>";					    
    print "</table>";		
    print "<input class='bigbutton' type='submit' value='$StrUpload'>";    
		print "<input type='hidden' name=path value=\"".htmlentities($path)."\">";
    print "<input type='hidden' name=filename value=\"".htmlentities($filename)."\">";            
    print "</form>";
    print "<br /><br /></center>";
   print "</td>";
  print "</tr>";
 print "</table>";
}
else
 print "<font color='#CC0000'>$StrAccessDenied</font>";

?>