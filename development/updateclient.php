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

	$datos[12] = $_POST['id'];
	$datos[0] = $_POST['latitud']; 
	$datos[1] = $_POST['longitud']; 
	$datos[2] = $_POST['nombre']; 
	$datos[3] = $_POST['direccion']; 
	$datos[4] = $_POST['horario']; 
	$datos[5] = $_POST['facebook'];
	$datos[6] = $_POST['pagina']; 
	$datos[7] = $_POST['foto']; 
	$datos[8] = $_POST['descripcion'];
	$datos[9] = $_POST['tipo'];
	$datos[10] = $_POST['recurso']; 
	$datos[11] = $_POST['tiposobresaliente'];

	$que = "UPDATE `villadel_bd_villa`.`T_cliente` SET latitud = '".$datos[0]."', logitud = '".$datos[1]."', nombre = '".$datos[2]."', direccion = '".$datos[3]."', horario = '".$datos[4]."', facebook = '".$datos[5]."', paginaweb= '".$datos[6]."', foto = '".$datos[7]."', descripcion = '".$datos[8]."', tipo = ".$datos[9].", recurso = '".$datos[10]."', tiposobresaliente = ".$datos[11]." WHERE id = ".$datos['12']; 
	//echo $que;
	//exit(0);
	$res = mysql_query($que, $link) or die(mysql_error()); 

	mysql_close($link); 

	header('Location: /development/listclient.php'); 

?>