// JavaScript Document
//<![CDATA[
function initialize() {
	
	var featureOpts = [
    {
      stylers: [
        { hue: '#890000' },
        { visibility: 'simplified' },
        { gamma: 0.5 },
        { weight: 0.5 }//,
		//{ lightness:90 }
      ]
    },
    {
      elementType: 'labels',
      stylers: [
        { visibility: 'off' }
      ]
    },
    {
      featureType: 'water',
      stylers: [
        { color: '#890000' }
      ]
    },{
      featureType: 'transit.line',
      elementType: 'geometry',
      stylers: [
        { hue: '#ff0000' },
        { visibility: 'on' },
        { lightness: -70 }
      ]
    }
  ];
        var mapOptions = {
          center: new google.maps.LatLng(5.633332999999999, -73.53333299999997),
          zoom: 16,
//          mapTypeId: google.maps.MapTypeId.ROADMAP,
		  mapTypeId: /*[google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID], //*/MY_MAPTYPE_ID,
		  mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
        };
        map = new google.maps.Map(document.getElementById("map_canvas"),
            mapOptions);
		
		//var transitLayer = new google.maps.TransitLayer();
		//transitLayer.setMap(map);
		
      infoWindow = new google.maps.InfoWindow();

 var styledMapOptions = {
    name: 'Custom Style'
  };
  
		var customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);

  map.mapTypes.set(MY_MAPTYPE_ID, customMapType);

      locationSelect = document.getElementById("locationSelect");
      /*locationSelect.onchange = function() {
        var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
        if (markerNum != "none"){
          google.maps.event.trigger(markers[markerNum], 'click');
        }
      };*/
	  
	  
	  
		  $.ajax({
					type: "POST",
					url: "/module/api.php",
					success:function(response){
						var data_ = $.parseJSON(response);
							
						for(var i in data_) {
							var long = data_[i]['logitud'];
							var lati = data_[i]['latitud'];
							var tit = (data_[i]['nombre'] !== 'undefined') ? data_[i]['nombre'] : "";
							var dir = (data_[i]['direccion'] !== 'undefined') ? data_[i]['direccion'] : "";
							var sit = (data_[i]['uid'] !== 'undefined') ? data_[i]['uid'] : "";
							
							if (long != "" && lati != "") {
								var image = '/media/images/point.png';
								
								try {
									var myLatLng = new google.maps.LatLng(parseFloat(lati), parseFloat(long));
									var beachMarker = new google.maps.Marker({
										position: myLatLng,
										map: map,
										icon: image,
										draggable: true,
										animation: google.maps.Animation.DROP,
										title: tit
									});
	
									/*var infowindow = new google.maps.InfoWindow({
									  content: '<div id="content_info"><div id="title_info"><b>' + tit_info + '</b></div><p>' + dir_info + '</p></div>'
									});*/
									//var infowindow = new google.maps.InfoWindow();
									
									var dataSite = {tit_info:tit, dir_info:dir, sit_info:sit};
									
									var infowindow = createInfoWindow(dataSite);
									
									
									/*google.maps.event.addListener(beachMarker, 'click', function() {
										infowindow.open(map,beachMarker);
									console.log("info window creado!");
									});*/
									
									//var content = '<div id="content_info"><div id="title_info"><b><a href="/sitio/' + dataSite.sit_info +'/">' + dataSite.tit_info + '</a></b></div><p>' + dataSite.dir_info + '</p></div>';
									makeInfoWindowEvent(map, infowindow, beachMarker, myLatLng);
									//makeInfoWindowEvent(map, beachMarker, myLatLng, content);
									markers.push(beachMarker);
								} catch (exception) {
									console.log("Error al crear el markers: " + lati + " " + long);
									console.log(exception.message);
								}
							}
						}
					},
					error: function (request, status, error) {
						console.log("Error al cargar datos de la api." + request.responseText);
					}                  
				});
	  
	  
	  /*var image = 'http://www.bicimapa.com/img/currentPosition.gif';
  var myLatLng = new google.maps.LatLng(5.633332999999999, -73.53333299999997);
  var beachMarker = new google.maps.Marker({
      position: myLatLng,
      map: map_canvas,
      icon: image
  });*/
	  
	  $('#progress').hide();
      }
	google.maps.event.addDomListener(window, 'load', initialize);
/*function zoom(zoom_) {
        var mapOptions = {
          center: new google.maps.LatLng(5.633332999999999, -73.53333299999997),
          zoom: zoom_,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"),
            mapOptions);
      }*/
	  
   function searchLocations() {
     var address = document.getElementById("addressInput").value;
     var geocoder = new google.maps.Geocoder();
     geocoder.geocode({address: address}, function(results, status) {
       if (status == google.maps.GeocoderStatus.OK) {
        searchLocationsNear(results[0].geometry.location);
       } else {
         alert(address + ' not found');
       }
     });
   }

   function clearLocations() {
     infoWindow.close();
     for (var i = 0; i < markers.length; i++) {
       markers[i].setMap(null);
     }
     markers.length = 0;

     locationSelect.innerHTML = "";
     var option = document.createElement("option");
     option.value = "none";
     option.innerHTML = "See all results:";
     locationSelect.appendChild(option);
   }

   function searchLocationsNear(center) {
     clearLocations();

     var radius = document.getElementById('radiusSelect').value;
     var searchUrl = 'phpsqlsearch_genxml.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;
     downloadUrl(searchUrl, function(data) {
       var xml = parseXml(data);
       var markerNodes = xml.documentElement.getElementsByTagName("marker");
       var bounds = new google.maps.LatLngBounds();
       for (var i = 0; i < markerNodes.length; i++) {
         var name = markerNodes[i].getAttribute("name");
         var address = markerNodes[i].getAttribute("address");
         var distance = parseFloat(markerNodes[i].getAttribute("distance"));
         var latlng = new google.maps.LatLng(
              parseFloat(markerNodes[i].getAttribute("lat")),
              parseFloat(markerNodes[i].getAttribute("lng")));

         createOption(name, distance, i);
         createMarker(latlng, name, address);
         bounds.extend(latlng);
       }
       map.fitBounds(bounds);
       locationSelect.style.visibility = "visible";
       locationSelect.onchange = function() {
         var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
         google.maps.event.trigger(markers[markerNum], 'click');
       };
      });
    }

    function createMarker(latlng, name, address) {
      var html = "<b>" + name + "</b> <br/>" + address;
      var marker = new google.maps.Marker({
        map: map,
        position: latlng
      });
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
      markers.push(marker);
    }

    function createOption(name, distance, num) {
      var option = document.createElement("option");
      option.value = num;
      option.innerHTML = name + "(" + distance.toFixed(1) + ")";
      locationSelect.appendChild(option);
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request.responseText, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function parseXml(str) {
      if (window.ActiveXObject) {
        var doc = new ActiveXObject('Microsoft.XMLDOM');
        doc.loadXML(str);
        return doc;
      } else if (window.DOMParser) {
        return (new DOMParser).parseFromString(str, 'text/xml');
      }
    }

    function doNothing() {}

	function changeFilter(filter) {
		var f =  filter.getAttribute("value");
		console.log(f);
		if (f != ''){
			createFilter(f);
		}
	}

	function createFilter(value) {
		for (var i = 0; i < markers.length; i++) {
	    	markers[i].setMap(null);
			//markers[i].pop();
			markers.splice(i, 1);
	    }
		$.ajax({
                type: "POST",
				data: {categoria : value},
                url: "/module/filter.php",
                success:function(response){
					//console.log(response);
					var data_ = $.parseJSON(response);
						
					for(var i in data_) {
						var long = data_[i]['logitud'];
						var lati = data_[i]['latitud'];
						
						if (long != "" && lati != "") {
							var image = '/media/images/point.png';// '/media/images/hotel.jpg';
							
							try {
								var myLatLng = new google.maps.LatLng(parseFloat(lati), parseFloat(long));
								var beachMarker = new google.maps.Marker({
									position: myLatLng,
									map: map,
									icon: image
								});
								 markers.push(beachMarker);
								//console.log("si se pudo");
							} catch (exception) {
								console.log("Error al crear el markers: " + lati + " " + long);
								console.log(exception.message);
							}
						}
					}
                },
                error: function (request, status, error) {
                    console.log("Error al cargar datos de la api." + request.responseText);
                }                  
            });
	}
	
	
	function makeInfoWindowEvent(map, infowindow, beachMarker, myLatLng) {
		google.maps.event.addListener(beachMarker, 'click', function() {
			infowindow.open(map, beachMarker);
			var bounds = new google.maps.LatLngBounds();
			bounds.extend(myLatLng);
			map.setCenter(bounds.getCenter());
			//map.fitBounds(bounds);
			
/****************************POR REVISAR ZOOM AL CLICK DE UN PUNTO ***************************************************************///////////////////
			//var zoom = (bounds) ? getBoundsZoomLevel(bounds) : 15;
			//map.setZoom(zoom);
		});
	}
	
	/*function makeInfoWindowEvent(map, infowindow, marker, myLatLng, content) {
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.setContent(content);
			infowindow.open(map, marker);
			var bounds = new google.maps.LatLngBounds();
			bounds.extend(myLatLng);
			map.setCenter(bounds.getCenter());
			map.fitBounds(bounds);
			
/****************************POR REVISAR ZOOM AL CLICK DE UN PUNTO ***************************************************************///////////////////
			//var zoom = (bounds) ? getBoundsZoomLevel(bounds) : 15;
			//map.setZoom(zoom);
		/*});
	}*/
	
	function createInfoWindow (dataSite) {
		return new google.maps.InfoWindow({
			content: '<div id="content_info"><div id="title_info"><b><a href="/sitio/' + dataSite.sit_info +'/">' + dataSite.tit_info + '</a></b></div><p>' + dataSite.dir_info + '</p></div>'
		});	
	}
	
	/*function getBoundsZoomLevel(bounds) {
		
		var _mapDiv = $('#map_canvas');

		var mapDim = {
			height: _mapDiv.height(),
			width: _mapDiv.width()
		}

		var WORLD_DIM = { height: 256, width: 256 };
		var ZOOM_MAX = 21;
	
		function latRad(lat) {
			var sin = Math.sin(lat * Math.PI / 180);
			var radX2 = Math.log((1 + sin) / (1 - sin)) / 2;
			return Math.max(Math.min(radX2, Math.PI), -Math.PI) / 2;
		}
	
		function zoom(mapPx, worldPx, fraction) {
			return Math.floor(Math.log(mapPx / worldPx / fraction) / Math.LN2);
		}
		
		var ne = bounds.getNorthEast();
		var sw = bounds.getSouthWest();
	
		var latFraction = (latRad(ne.lat()) - latRad(sw.lat())) / Math.PI;
		
		var lngDiff = ne.lng() - sw.lng();
		var lngFraction = ((lngDiff < 0) ? (lngDiff + 360) : lngDiff) / 360;
		
		var latZoom = zoom(mapDim.height, WORLD_DIM.height, latFraction);
		var lngZoom = zoom(mapDim.width, WORLD_DIM.width, lngFraction);
	
		return Math.min(latZoom, lngZoom, ZOOM_MAX);
	}*/


//google.maps.event.addDomListener(window, 'load', initialize);

    //]]>