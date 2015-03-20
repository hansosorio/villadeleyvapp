<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
	function actualizarCoordenadas() {
		/*var geocoder = new google.maps.Geocoder();
		var address = "villa de leyva";
		geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				var latitude = results[0].geometry.location.lat();
				var longitude = results[0].geometry.location.lng();
				$('#lon').text(longitude);
				$('#lat').text(latitude);
				$('#lon').val(longitude);
				$('#lat').val(latitude);
			} 
		});*/
		initGeolocation();
	}
	
	
	function initGeolocation() {
        if( navigator.geolocation ) {
           // Call getCurrentPosition with success and failure callbacks
           navigator.geolocation.getCurrentPosition( success, fail );
        }
        else {
           alert("Sorry, your browser does not support geolocation services.");
        }
    }
    function success(position) {
        //document.getElementById('lon').value = position.coords.longitude;
        //document.getElementById('lat').value = position.coords.latitude
		$('#lon').val(position.coords.longitude);
		$('#lat').val(position.coords.latitude);
    }
    function fail() {
        alert("Could not obtain location");
    }

</script>
</head>
<body>


<?php


if (!isset($_GET['id']) || $_GET['id'] == NULL) {
	exit(0);
}
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
	$que = "SELECT * FROM `villadel_bd_villa`.`T_cliente` WHERE id = " . $_GET['id']; 
	$res = mysql_query($que, $link) or die(mysql_error()); 

	$rows = array();
	while($r = mysql_fetch_assoc($res)) {
		$rows[] = $r;
		//var_dump($rows);
		//exit(0);
	}
?>

<div style="width:100%; height:100%">
	<input type="submit" value="Actualizar coordenadas" onClick="actualizarCoordenadas();"/><br />
<?php
foreach ($rows as $client) {
	?>
	Ingrese los datos del cliente:<br /><br />
	<form method="post" action="/development/updateclient.php">
    <input type="hidden" name ="id" value="<?php echo $client['id'];?>" />
		Nombre: <input type="text" name="nombre" value="<?php echo $client['nombre'] ?>" /><br />
		latitud: <input type="text" name="latitud" id="lat" value="<?php echo $client['latitud'] ?>" /><br />
		longitud: <input type="text" name="longitud" id="lon" value="<?php echo $client['longitud'] ?>" /><br />
		Direccion: <input type="text" name="direccion" value="<?php echo $client['direccion'] ?>" /><br />
		Horario: <input type="text" name="horario" value="<?php echo $client['horario'] ?>" /><br />
		Link facebook: <input type="text" name="facebook" value="<?php echo $client['facebook'] ?>" /><br />
		Pagina web: <input type="text" name="pagina" value="<?php echo $client['pagina'] ?>" /><br />
		Foto: <input type="text" name="foto" value="<?php echo $client['foto'] ?>" /><br />
		Descripcion: <input type="text" name="descripcion" value="<?php echo $client['descripcion'] ?>" /><br />
        Tipo: <input type="number" name="tipo" value="<?php echo $client['tipo'] ?>" /><br />
        Recurso: <input type="text" name="recurso" value="<?php echo $client['recurso'] ?>" /><br />
		Tipo sobresaliente: <input type="number" name="tiposobresaliente" value="<?php echo $client['tiposobresaliente'] ?>" /><br />
		
		<input type="submit" value="Enviar" name="enviar"/>
	</form>
<?php
}
?>
</div>
</body>
</html>