<?php
//SELECT * FROM `villadel_bd_villa`.`T_cliente` WHERE tipo = 2[{"id":"342","latitud":"5.629863989710891","logitud":"-73.52110076187263","nombre":"Aparta suite la montana ","direccion":"Calle 12 # 6 - 64","horario":"","facebook":"","paginaweb":"","foto":"","descripcion":"Hotel","telefono":"0","tipo":"2","recurso":"","tiposobresaliente":"0"}]
if (!isset($_POST['categoria']) || $_POST['categoria'] == null ) {
	echo "{}";
	exit(0);
}



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
	$categoria = $_POST['categoria'];
	if ($categoria % 100 == 0) {
		$que = "SELECT * FROM `villadel_bd_villa`.`T_cliente` WHERE tipo >= ". $categoria . " AND tipo < " . ($categoria + 99); 	
	}
	else {
		$que = "SELECT * FROM `villadel_bd_villa`.`T_cliente` WHERE tipo = ". $categoria; 
	}
	$res = mysql_query($que, $link) or die(mysql_error()); 

	$rows = array();
	while($r = mysql_fetch_assoc($res)) {
		$rows[] = $r;
	}

	echo json_encode($rows);



//echo '[{"latitud":"5.62894573615407","logitud":"-73.52563957009886","nombre":"Terminal","direccion":"","horario":"","facebook":"","pagina web":"","foto":"","descripcion":"Terminal "}, {"id":"451","latitud":"5.629863989710891","logitud":"-73.52110076187263","nombre":"Ansamios","direccion":"Carrera 7 # 9 - 46","horario":"","facebook":"","pagina web":"","foto":"","descripcion":"General","telefono":"0","tipo":"0"}]';



	mysql_close($link); 

//	header('Location: /index3.php'); 

?>