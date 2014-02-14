<script type="text/javascript">
	$(function() { 
	 navigator.geolocation.getCurrentPosition(showpos);

     function showpos(position){
         lat=position.coords.latitude
         lon=position.coords.longitude

	    $(".mapa").goMap({
	    	latitude: lat, 
	        longitude: lon, 
	        zoom: 14,
	        navigationControl: false, 
	        mapTypeControl: false,
	        markers: [{  
	            latitude: lat, 
	            longitude: lon, 
		        html: 'Estou Aqui',
		        icon: '<?php echo BASEURL; ?>/layout/site/img/icon-male-2.png'
	        }] 
	    }); 
     }
     
     $.ajax({
			url: '<?php echo BASEURL; ?>/site/jsonevents',
			type: 'GET',
			dataType:'json',
			async:true,
			success:function(data){
				for(var i = 0, l = data.length; i < l; i++) {
					var marker = data[i];
					console.log(marker);
					
					$.goMap.createMarker({
						latitude: marker.lat,
						longitude: marker.lon,
						html:marker.title,
						icon:marker.icon
					});
				}

				var markers = [];

		 		for (var i in $.goMap.markers) {
		 			var temp = $($.goMap.mapId).data($.goMap.markers[i]);
		 			markers.push(temp);
		 		}

		 		var markerclusterer = new MarkerClusterer($.goMap.map, markers);
			}
	     });
	}); 

	</script>

<div class="mapa">
</div>
