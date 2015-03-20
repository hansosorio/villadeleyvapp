<?php
//array(1) { [0]=> array(12) { ["id"]=> string(1) "1" ["latitud"]=> string(1) "1" ["logitud"]=> string(1) "1" ["nombre"]=> string(8) "Anonimus" ["direccion"]=> string(13) "Calle Carrera" ["horario"]=> string(8) "LUN 6 am" ["facebook"]=> string(4) "wwww" ["pagina web"]=> string(4) "wwww" ["foto"]=> string(9) "foto1.jpg" ["descripcion"]=> string(15) "Sin descripcion" ["telefono"]=> string(1) "0" ["tipo"]=> string(1) "0" } }
	$link = mysql_connect("localhost", "villadel", ")mrlCAooqtMU"); 
	if (!$link) { 
		die('Could not connect: ' . mysql_error()); 
	} 
	$db_selected = mysql_select_db('villadel_bd_villa', $link); 
	if (!$db_selected) { 
		die ('Cant use tarea : ' . mysql_error()); 
	} 

	$datos = array();

	//$que = "SELECT `latitud`, `logitud`, `nombre`, `direccion`, `horario`, `facebook`, `pagina web`, `foto`, `descripcion` FROM `villadel_bd_villa`.`T_cliente` "; 
	$que = "SELECT * FROM `villadel_bd_villa`.`T_cliente` "; 
	$res = mysql_query($que, $link) or die(mysql_error()); 

	$rows = array();
	while($r = mysql_fetch_assoc($res)) {
		$rows[] = $r;
		//var_dump($rows);
		//exit(0);
	}
?>
<h1> Lista de Clientes </h1>

<br /><br /><br /><br />

<table width="80%">
<?php
foreach ($rows as $client) {
	echo "<tr>";
	echo "<td>" . $client['id'] . "</td>";
	echo "<td>" . $client['nombre'] . "</td>";
	echo "<td>" . $client['direccion'] . "</td>";
	echo "<td>" . $client['tipo'] . "</td>";
	echo "<td>" . $client['descripcion'] . "</td>";
	echo "<td><a href='/development/upclient.php?id=" . $client['id'] . "' target='_self'> Actualizar </a></td>";
	echo "<td><a href='/development/delclient.php?id=" . $client['descripcion'] . "' target='_self'> Eliminar </a></td>";
	echo "</tr>";
}

?>
</table>
<?php
	//echo json_encode($rows);

	mysql_close($link); 


?>