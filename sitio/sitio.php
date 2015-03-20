<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sitio: - Villadeleyvapp.com</title>
<link rel="" /> <! -- canonical -->
</head>
<body>

<?php
try {
	if (isset($_GET['id']) && $_GET['id'] !== "" && is_numeric($_GET['id'])){
		$link = mysql_connect("localhost", "villadel", ")mrlCAooqtMU"); 
		if (!$link) { 
			die('Could not connect: ' . mysql_error()); 
		} 
		$db_selected = mysql_select_db('villadel_bd_villa', $link); 
		if (!$db_selected) { 
			die ('Cant use tarea : ' . mysql_error()); 
		} 
	
		$datos = array();
	
		$que = "SELECT * FROM `villadel_bd_villa`.`T_cliente`  WHERE uid LIKE '" . $_GET['id'] ."' "; 
		$res = mysql_query($que, $link) or die(mysql_error()); 
	
		$rows = array();
		while($r = mysql_fetch_assoc($res)) {
			$rows[] = $r;
		}
	
		echo json_encode($rows);
	
		mysql_close($link);
	}
	else {
		//El id no es valido
		
		echo "<div id ='sitio_no_encontrado'>El sitio no se ha encontrado!</div>";
		?>
		<script type="text/javascript">
			var pagina="/";
			function redireccionar() {
				location.href=pagina
			}
			setTimeout ("redireccionar()", 20000); // Redireccionando al home en 20 segundos
		</script>
		<?php	
	}

}
catch(Exception $e) {
	print_r($e);
	?>
		<script type="text/javascript">
			var pagina="/";
			function redireccionar() {
				location.href=pagina
			}
			setTimeout ("redireccionar()", 20000); // Redireccionando al home en 20 segundos
		</script>
		<?php
}
// Agregar datos de seo
// Agregar comentarios
// Agregar mapa del sitio
// Agregar diseño
?>
</body>
</html>