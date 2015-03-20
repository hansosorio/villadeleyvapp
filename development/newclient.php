<?php
	$link = mysql_connect("localhost", "villadel", ")mrlCAooqtMU"); 
	if (!$link) { 
		die('Could not connect: ' . mysql_error()); 
	} 
	$db_selected = mysql_select_db('villadel_bd_villa', $link); 
	if (!$db_selected) { 
		die ('Cant use tarea : ' . mysql_error()); 
	} 

	$datos = array();

	$datos[0] = $_POST['latitud']; 
	$datos[1] = $_POST['longitud']; 
	$datos[2] = $_POST['nombre']; 
	$datos[3] = $_POST['direccion']; 
	$datos[4] = $_POST['horario']; 
	$datos[5] = $_POST['facebook'];
	$datos[6] = $_POST['pagina']; 
	$datos[7] = $_POST['foto']; 
	$datos[8] = $_POST['descripcion'];
	$datos[9] = $_POST['recurso']; 
	$datos[10] = $_POST['tiposobresaliente'];

	$que = "INSERT INTO `villadel_bd_villa`.`T_cliente` (`latitud`, `logitud`, `nombre`, `direccion`, `horario`, `facebook`, `paginaweb`, `foto`, `descripcion`, `recurso`, `tiposobresaliente` )  VALUES ('".$datos[0]."', '".$datos[1]."', '".$datos[2]."','".$datos[3]."','".$datos[4]."','".$datos[5]."','".$datos[6]."','".$datos[7]."','".$datos[8]."','".$datos[9]."','".$datos[10]."') "; 
	$res = mysql_query($que, $link) or die(mysql_error()); 

	mysql_close($link); 

	header('Location: /development/neclient.php'); 

?>