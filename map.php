<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASm3CwaK9qtcZEWYa-iQwHaGi3gcosAJc&sensor=false"></script>
<script>

	//object used to organize javascript functionality
	var customApp = new Object();	
	
	/* trigger when page is ready */
	$(document).ready(function (){

		//bind events for the modal
		customApp.buieMap();

	});

	customApp.buieMap = function(options)
		{
			//private object to organize code
			var buieMap = new Object();

			//default options
			var defaults = {
				mapSelector: '#googleMap',
				markerSelector: '.map .key ul li',
				infoBoxContentSelector: '.map .infoBoxContent'
			}

			//buid settings based on defaults and options
			var settings = $.extend({}, defaults, options);

			//setup elements
			var keyItems = $(settings.markerSelector);

			buieMap.setup = function()
				{				
					//create marker object based on dom
					buieMap.setupMarkers();
					//setup the map initially
					buieMap.initiateMap();
					//bind the legend events
					buieMap.bindEvents();					
				}
			buieMap.setupMarkers = function()
				{
					var markers = Array();
					var markersFound = 0;
					keyItems.each(function(index){
						var me = $(this);
						if(me.is('[dataLat]')){
							markers[markersFound] = new Object();
							markers[markersFound].el = me;
							markers[markersFound].lat = me.attr('dataLat');
							markers[markersFound].lng = me.attr('dataLng');
							markers[markersFound].markerTitle = me.attr('dataTitle');
							markers[markersFound].address = me.attr('dataAddress');
							markers[markersFound].image = me.attr('dataImage');
							me.data('marker', markers[markersFound]);
							markersFound++;
						}
					});
					buieMap.markers = markers;
				}
			buieMap.initiateMap = function(options)
				{
					//set initiate defaults
					var defaults = {
						latLng:  {
							lat: buieMap.markers[0].lat,
							lng: buieMap.markers[0].lng
						}, 
						zoom: 14
					}

					//setup the settings based on options
					var settings = $.extend({}, defaults, options);

					var center = new google.maps.LatLng(settings.latLng.lat, settings.latLng.lng);

					//styles found here: http://snazzymaps.com/
					var mapStyles = []
					
					var myOptions = {
					    zoom: settings.zoom,
					    // panControl: false,
					    // scaleControl: false,
					     streetViewControl: false,
					    // zoomControl: false,
					    // mapTypeControl: false,
					    scrollwheel: false,
					    center: center,
					    mapTypeId: google.maps.MapTypeId.SATELLITE,
					    styles: mapStyles
					};			
					
					buieMap.map = new google.maps.Map(document.getElementById('googleMap'), myOptions);

					//add info window
					buieMap.infowindow = new google.maps.InfoWindow(); 

					//create markers
					for (var i = 0; i < buieMap.markers.length; i++) {
						buieMap.setupMarker(buieMap.markers[i]);
					}

					buieMap.showInfoWindow(buieMap.markers[0]);
					buieMap.map.panBy(100, 0);
				}			
			buieMap.setupMarker = function(marker)
				{
					var latLng = new google.maps.LatLng(marker.lat, marker.lng);

					//set the marker options based on the marker
					var locationMarkerOptions = {
						position : latLng,
						map : buieMap.map,
						title : marker.markerTitle
					}

					//if a marker image is set, add it to marker options
					if(marker.image){
						locationMarkerOptions.icon = marker.image
					}

					var locationMarker = new google.maps.Marker(locationMarkerOptions);

					marker.marker =  locationMarker;

					google.maps.event.addListener(locationMarker, 'click', (function() {
						buieMap.infowindow.close();
						buieMap.showInfoWindow(marker);						
					}));

					
				}
			buieMap.showInfoWindow = function(marker)
				{
					var infoBoxContent = $(settings.infoBoxContentSelector).clone(true, true);
					infoBoxContent.css({'display': 'block'});
					infoBoxContent.find('h3').text(marker.markerTitle);
					var encoded_search = encodeURI(marker.address);
					var getDirectionsURL = 'http://maps.google.com/maps?saddr='+encoded_search;
					infoBoxContent.find('a').attr('href', getDirectionsURL);
					buieMap.infowindow.setContent(infoBoxContent.html());
					buieMap.infowindow.open(buieMap.map,marker.marker);
				}		
			buieMap.bindEvents = function()
				{
					keyItems.click(function(){
						var me = $(this);
						var marker = me.data('marker');

						buieMap.infowindow.close();
						buieMap.zoomInclude(marker);
					});
					//buieMap.markers[0].el.trigger('click');
				}
			buieMap.zoomInclude = function(marker)
				{
					//always include the home marker in the bounds
					var homeMarker = buieMap.markers[0].marker;
					var latLngBounds = new google.maps.LatLngBounds();
					latLngBounds.extend(homeMarker.getPosition())
					latLngBounds.extend(marker.marker.getPosition());
					buieMap.map.fitBounds(latLngBounds);

					//account for legend pixels, and show infowindow of marker
					
					buieMap.map.panBy(300, 0);
					var currentBounds = buieMap.map.getBounds();
					latLngBounds.extend(currentBounds.getNorthEast());
					latLngBounds.extend(currentBounds.getSouthWest());
					buieMap.map.fitBounds(latLngBounds);					

					//show infowindow and add that to the bounds of the map
					buieMap.showInfoWindow(marker);
					currentBounds = buieMap.map.getBounds();
					latLngBounds.extend(currentBounds.getNorthEast());
					latLngBounds.extend(currentBounds.getSouthWest());
					buieMap.map.fitBounds(latLngBounds);
				}
			buieMap.geoCode = function(options)
				{
					var defaults = {
						codeingType: 'address', //can be address, latLng
						codeString: false
					}

					//setup the settings based on options
					var settings = $.extend({}, defaults, options);

					var geocoder = new google.maps.Geocoder();

					var results = geocoder.geocode( { 'address': settings.codeString }, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {

							var center = buieMap.getLatLng(results);

						}
					});
				}
			buieMap.setup();
			customApp.buieMapObject = buieMap;		
		}

</script>

<style>
	.map {
			position: relative;

			#googleMap {
				width: 100%;
				height: 359px;
				margin-bottom: 16px;

				@media #{$breakpointPhoneLandscape} {
					margin-bottom: 0;
				}

				img {
					max-width: none;
				}

				h3 {
					font-family: arial;
					font-size: 16px;
					margin-bottom: 10px;
				}

				a {
					color: black;
					text-decoration: underline;
				}
			}

			.key {
				background: image-url('opacity.png');
				position: absolute;
				right: 2%;
				top: 9%;
				height: 83%;
				padding: 15px;

				@media #{$breakpointPhoneLandscape} {
					position: relative;
					top: 0;
					right: 0; 
				}

				h4 {
					margin-bottom: 10px;
				}

				ul {
					margin-left: 43px;
					font-weight: normal;

					li {
						cursor: pointer;
					}
				}
			}

			.infoBoxContent {
				display: none;
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
      <ul>
          <li dataLat="" dataLng='' dataTitle="" dataAddress='' dataImage=''>Wildhorse Meadows</li>
      </ul>
  </div>
</div>