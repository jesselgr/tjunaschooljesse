
	$(document).ready(function()
	{
		var $longitude 	= $('#geo_longitude');
		var $latitude 	= $('#geo_latitude');
		
		var longitude 	= $longitude.attr('value');
		var latitude 	= $latitude.attr('value');
		
		var locLatlng 	= new google.maps.LatLng(latitude,longitude);
		
		
		
		geocoder = new google.maps.Geocoder();
		var mapOptions = {
		 	center		: new google.maps.LatLng(latitude,longitude),
		 	zoom		: 12,
		 	mapTypeId	: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById("map_latitude"),
		   mapOptions);
		if(longitude && latitude)  geocoder.geocode( { 'latLng': locLatlng}, handleGMSearch);
		
		$('#GMsearchButton').click(function() 
		{
			var address = $('#address').attr('value');
			geocoder.geocode( { 'address': address}, handleGMSearch);
		})
		
	});

	
	function handleGMSearch(results, status) 
	{
		var infowindow 	= new google.maps.InfoWindow();
		var fields 		= new Array('city','address','postal');
		if (status == google.maps.GeocoderStatus.OK) 
		{
			map.setCenter(results[0].geometry.location);
			
			// set address result
			
			var city 	= '';
			var postal 	= '';
			var street 	= '';
			var number 	= '';
			//wtf google?
			$.each(results[0].address_components, function (i, address_component) 
			{
				switch(address_component.types[0])
				{
					case 'locality':
						city 	= address_component.long_name;
						break;
					case 'postal_code':
						postal 	= address_component.long_name;
						break;
					case 'street_number':
						number = address_component.long_name;
						break;
					case 'route':
						street = address_component.long_name;
						break;
				}
			});
			
			// set marker
			
			$('#geo_address').attr('value', street + ' ' + number);
			$('.display_address').text(street + ' ' + number);
			
			$('#geo_postal').attr('value', postal);
			$('.display_postal').text(postal);
			
			$('#geo_city').attr('value',city);
			$('.display_city').text(city);
			
			var marker = new google.maps.Marker({
			    map: map,
			    animation	: 	google.maps.Animation.DROP,
			    position	: 	results[0].geometry.location
			});
			infowindow.setContent('<p>' + street + ' ' + number + '</p><p> '+ postal + '</p><p>' + city + '</p>');
			infowindow.open(map, marker);
			
		
			
		} else {
			alert("Geocode was not successful for the following reason: " + status);
		}
	};
