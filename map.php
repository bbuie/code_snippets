<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASm3CwaK9qtcZEWYa-iQwHaGi3gcosAJc&sensor=false"></script>
<script>

	//object used to organize javascript functionality
	var customApp = new Object();	
	
	/* trigger when page is ready */
	$(document).ready(function (){

		//bind events for the modal
		customApp.buieMap();

	});

	customApp.buieMap = function(){
		if($('#googleMap').length){
			var geocoder = new google.maps.Geocoder();
			var address = '10 West 100 South #708 Salt Lake City, UT 84101';	
			geocoder.geocode( { 'address': address }, function(results, status) {
		   
				if (status == google.maps.GeocoderStatus.OK) {
					
					//styles found here: http://snazzymaps.com/
					var mapStyles = [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]
					
					var myOptions = {
					    zoom: 14,
					    center: new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()),
					    mapTypeId: google.maps.MapTypeId.ROADMAP,
					    styles: mapStyles
					};
			
					
					var map = new google.maps.Map(document.getElementById('googleMap'), myOptions);
	
					locationMarker = new google.maps.Marker({
						position : new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()),
						map : map,
						title : 'HINT CREATIVE'
					}); 
	
				} else {
					//console.log("We couldn't find the google map location");
				}
			});   
		}
	}

</script>

<style>
	#googleMap {
		width: 100%;
		height: 359px;
		margin-top: 16px;
		margin-bottom: 16px;

		img {
			max-width: none;
		}
	}
</style>

<div class="map">
  <div id="googleMap"></div>
  <div class="infoBoxContent">
    <h3></h3>
    <a href="" target='_blank'>Get Directions</a>
  </div>
  <div class="key">
      <h4>Community Map</h4>
      <ul>
          <li dataLat="40.456640" dataLng='-106.812238' dataTitle="Wildhorse Meadows" dataAddress='Wildhorse Meadows, 1175 Bangtail Way, Steamboat Springs, CO 80487'>Wildhorse Meadows</li>
          <li dataLat="40.458363" dataLng='-106.805090' dataTitle="Steamboat Ski & Resort" dataAddress='Steamboat Springs, CO 80487'>Steamboat Ski & Resort</li>
          <li dataLat="40.484720" dataLng='-107.219883' dataTitle="Yampa Valley Regional Airport" dataAddress='Yampa Valley Regional Airport, 11005 County Road 51A, Hayden, CO 81639'>Yampa Valley Regional Airport</li>
          <li>Downtown</li>
          <li>Howelson Hill</li>
          <li>Old Town Hot Springs</li>
          <li>Strawberry Part Hot Springs</li>
          <li>Hospital</li>
          <li>Bob Adams Airport</li>
          <li>Haymaker Golf Course</li>
          <li>Rollingstone Ranch Golf Club</li>
      </ul>
  </div>
</div>