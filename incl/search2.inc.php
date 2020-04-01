<?php
//require('config.php');
//require('include/conexion.php');
require('include/funciones.php');
require('include/pagination.class.php');

$items = 25;

$link = mysql_connect('localhost','fm','fm');
mysql_select_db('fm');


if(isset($_GET['page']) and is_numeric($_GET['page'])) {
		$page = $_GET['page'];
		$limit = " LIMIT ".(($page-1)*$items).",$items";	
	}
	else {
	        $page = 1;
		$limit = " LIMIT $items";
	}
$limit = " LIMIT ".(($page-1)*$items).",$items";


if(isset($_GET['q']) and !eregi('^ *$',$_GET['q']) and $_GET['clase']){
		$q = sql_quote($_GET['q']); //para ejecutar consulta
		$clase = sql_quote($_GET['clase']);
		$busqueda = htmlentities($q); //para mostrar en pantalla

		$sqlStr = "SELECT * FROM estructura WHERE nombre LIKE '%$q%' and clase like '$clase'";
		$sqlStrAux = "SELECT count(*) as total FROM estructura WHERE nombre LIKE '%$q%' and clase like '$clase'";
	}else{
		$sqlStr = "SELECT * FROM estructura";
		$sqlStrAux = "SELECT count(*) as total FROM nombre";
	}

$aux = Mysql_Fetch_Assoc(mysql_query($sqlStrAux,$link));
$query = mysql_query($sqlStr.$limit, $link);
?>	<p><?php
		if($aux['total'] and isset($busqueda)){
				echo "{$aux['total']} Resultado".($aux['total']>1?'s':'')." que coinciden con tu b&uacute;squeda \"<strong>$busqueda</strong>\".";
			}elseif($aux['total'] and !isset($q)){
				echo "Total de registros: {$aux['total']}";
			}elseif(!$aux['total'] and isset($q)){
				echo"No hay registros que coincidan con tu b&uacute;squeda \"<strong>$busqueda</strong>\"";
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