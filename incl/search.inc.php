<?php


//require('include/conexion.php');
require('include/funciones.php');
require('include/pagination.class.php');

$items = 25;

$link = mysql_connect('localhost','fm', 'fm');
mysql_select_db('fm');

if (isset($_GET['page']) and is_numeric($_GET['page'])) {
   	      $page = $_GET['page'];
	      $limit = " LIMIT ".(($page-1)*$items).",$items";
	}
	else {
		$page = 1;
		$limit = " LIMIT $items";
	}

if(isset($_GET['q']) and !eregi('^ *$',$_GET['q']) and $_GET['clase']){
		$q = sql_quote($_GET['q']); //para ejecutar consulta
		$clase = sql_quote($_GET['clase']);
		$busqueda = htmlentities($q); //para mostrar en pantalla
		$sqlStr = "SELECT * FROM estructura WHERE nombre LIKE '%$q%' and clase like '$clase'";
		$sqlStrAux = "SELECT count(*) as total FROM estructura WHERE nombre LIKE '%$q%' and clase like '$clase'";
	}else {
		$sqlStr = "SELECT * FROM estructura";
		$sqlStrAux = "SELECT count(*) as total FROM estructura";
	}


$aux = Mysql_Fetch_Assoc(mysql_query($sqlStrAux,$link));
$query = mysql_query($sqlStr.$limit, $link);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search</title>
<link rel="stylesheet" href="/fm/incl/include/pagination.css" media="screen">
<link rel="stylesheet" href="/fm/incl/include/style.css" media="screen">
<script src="/fm/incl/include/buscador.js" type="text/javascript" language="javascript"></script>
</head>

<body>
      <form action=""index.php?path=&action=search&type=file" onsubmit="return buscar()">
      <label>Buscar</label> <input type="text" id="q" name="q" value="<?php if(isset($q)) echo $busqueda;?>" onKeyUp="return buscar()">
      <select id='clase' onchange="return buscar()">
           <option value ="naf47">naf47</option>
     	   <option value ="Utilitarios Sistema">Utilitarios Sistema</option>
	   <option value ="Armario">Armario</option>
	   <option value ="Orden Sistema" selected="selected">Orden Sistema</option>
	   <option value ="Informatica">Informatica</option>
	   <option value ="naf453">naf453</option>
	   <option value ="Otros Utilitarios">Otros Utilitarios</option>
	   <option value ="%">Todos</option>
      </select><br>
      <input type="submit" value="Buscar" id="boton"><span id="loading"></span>
      <input type='hidden' id='action' value='search'>
      <input type='hidden' id='type' value='file'>
      </form>
      <form action="/fm/index.php"<input type="submit" value="Salir" id="boton2"></form>
      <input type='hidden' id='action' value='search'>
      <input type='hidden' id='type' value='file'>
    </form>
    
    <div id="resultados">
	<p><?php
		if($aux['total'] and isset($busqueda)){
			echo "{$aux['total']} Resultado".($aux['total']>1?'s':'')." que coinciden con tu b&uacute;squeda \"<strong>$busqueda</strong>\".";
		}elseif($aux['total'] and !isset($q)){
				echo "Total de registros: {$aux['total']}";
		}elseif(!$aux['total'] and isset($q)){
				echo" No hay registros que coincidan con tu b&uacute;squeda \"<strong>$busqueda</strong>\"";
		}
	?></p>

	<?php 
		if($aux['total']>0){
			$p = new pagination;
			$p->Items($aux['total']);
			$p->limit($items);
			if(isset($q))
					$p->target("index.php?path=&action=search&type=file&q=".urlencode($q)."&clase=".urlencode($clase));
				else
					$p->target("index.php?path=&action=search&type=file");
			$p->currentPage($page);
			$p->show();
			echo "\t<table class=\"registros\">\n";
			echo "<tr class=\"titulos\"><td>Titulo</td><td>Path</td></tr>\n";
			$r=0;
			while($row = mysql_fetch_assoc($query)){
		echo "\t\t<tr class=\"row$r\"><td><a href=\"/fm/index.php?&&path={$row['url']}\" target=\"_blank\">".htmlentities($row['nombre'])."</a></td><td>".$row['url']."</td></tr>\n";
          if($r%2==0)++$r;else--$r;
        }
			echo "\t</table>\n";
			$p->show();
		}
	?>
    </div>
</body>
</html>

