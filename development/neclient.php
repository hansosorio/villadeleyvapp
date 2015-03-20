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
<div style="width:100%; height:100%">
	<input type="submit" value="Actualizar coordenadas" onClick="actualizarCoordenadas();"/><br />

	Ingrese los datos del cliente:<br /><br />
	<form method="post" action="/development/newclient.php">
		Nombre: <input type="text" name="nombre" /><br />
		latitud: <input type="text" name="latitud" id="lat" /><br />
		longitud: <input type="text" name="longitud" id="lon" /><br />
		Direccion: <input type="text" name="direccion" /><br />
		Horario: <input type="text" name="horario" /><br />
		Link facebook: <input type="text" name="facebook" /><br />
		Pagina web: <input type="text" name="pagina" /><br />
		Foto: <input type="text" name="foto" /><br />
		Descripcion: <input type="text" name="descripcion" /><br />
        Recurso: <input type="text" name="recurso" /><br />
		Tipo Sobresaliente: <input type="text" name="tiposobresaliente" /><br />
		
		<input type="submit" value="Enviar" name="enviar"/>
	</form>
</div>
</body>
</html>