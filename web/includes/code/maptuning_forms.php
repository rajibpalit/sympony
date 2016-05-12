<?

	/*==================================================================*\
	######################################################################
	#                                                                    #
	# Copyright 2005 Arca Solutions, Inc. All Rights Reserved.           #
	#                                                                    #
	# This file may not be redistributed in whole or part.               #
	# eDirectory is licensed on a per-domain basis.                      #
	#                                                                    #
	# ---------------- eDirectory IS NOT FREE SOFTWARE ----------------- #
	#                                                                    #
	# http://www.edirectory.com | http://www.edirectory.com/license.html #
	######################################################################
	\*==================================================================*/

	# ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/code/maptuning_forms.php
	# ----------------------------------------------------------------------------------------------------

    $keyStr = "";
    $googleSettingObj = new GoogleSettings($_SERVER["HTTP_HOST"]);
        
    /* key for demodirectory.com */
    if (DEMO_LIVE_MODE) {
        $googleMapsKey = GOOGLE_MAPS_APP_DEMO;
    } else {
        $googleMapsKey = $googleSettingObj->mapsKey;
    }
    
    if ($googleMapsKey){
       $keyStr = "&key=$googleMapsKey";
    }
    
    $protocol = "http";
    
    if (SSL_ENABLED == "on") {
        if (string_strpos($_SERVER["PHP_SELF"], SITEMGR_ALIAS) !== false && FORCE_SITEMGR_SSL == "on") {
            $protocol = "https";
        } elseif (string_strpos($_SERVER["PHP_SELF"], MEMBERS_ALIAS) !== false && FORCE_MEMBERS_SSL == "on") {
            $protocol = "https";
        }
    }
?>

    <script src="<?=$protocol?>://maps.google.com/maps/api/js?sensor=false<?=$keyStr?>" type="text/javascript"></script>
    <script type="text/javascript">

        var geocoder;
        var map;
        
        function displayMapForm(form, show) {
            var use_lat_long = false;
            $('#map').css('display', '');
            $('#tipsMap').css('display', '');
            if (!show){

                if (document.getElementById('myLatitudeLongitude').value) {
                    use_lat_long = true;
                }

                loadMap(form, use_lat_long);
            }
        }
        
        function setCoordinates(coord) {
            var new_lat;
            var new_long;
            var aux_latlong;

            document.getElementById('myLatitudeLongitude').value = coord;
            if (document.getElementById('maptuning_done')) {
                document.getElementById('maptuning_done').value = "y";
            }
            aux_latlong = document.getElementById('myLatitudeLongitude').value;
            aux_latlong = aux_latlong.replace("(", "").replace(")", "").replace(" ", "").split(',');
            new_lat = aux_latlong[0]; 
            new_long  = aux_latlong[1];
            
            var num_lat = new Number(new_lat);
            var num_long = new Number(new_long);
            
            document.getElementById('latitude').value = num_lat.toFixed(6);
            document.getElementById('longitude').value = num_long.toFixed(6);
        }
        
        function initialize(map_zoom, google_location, latitude, longitude, use_lat_long) {

            geocoder = new google.maps.Geocoder();
            var myOptions = {
              zoom: map_zoom,
              scrollwheel: false,
              mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById("map"), myOptions);
            codeAddress(google_location, latitude, longitude, use_lat_long); 
            
            function codeAddress(google_location, latitude, longitude, use_lat_long) {
                var address = google_location;
                var marker = new google.maps.Marker({
                    map: map, 
                    draggable: true
                });
                
                if (use_lat_long && latitude && longitude){
                    var latlng = new google.maps.LatLng(latitude, longitude);
                    marker.setPosition(latlng);
                    map.setCenter(latlng);
                } else {
                    if (geocoder) {
                        geocoder.geocode( { 'address': address}, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                map.setCenter(results[0].geometry.location);
                                marker.setPosition(results[0].geometry.location);
                                setCoordinates(results[0].geometry.location);
                            }
                        });
                    }
                }
                
                google.maps.event.addListener(marker, 'dragend', function(event) {
                    setCoordinates(event.latLng);                    
                });
                
                google.maps.event.addListener(map, 'zoom_changed', function() {
                    document.getElementById('map_zoom').value = map.getZoom();
                });
                
            }   
        }
        
        function loadMap(form, use_lat_long){
            var address = document.getElementById('address').value;
            var zip = document.getElementById('zip_code').value;
            var location_3 = '';
            var location_4 = '';
            var latitude = document.getElementById('latitude').value; 
            var longitude = document.getElementById('longitude').value; 
            var index;
            var google_location = '';
            var locations = new Array();
            var array_index = 0;
            var callMap = false;
            var valid_coord = true;
            
            if (use_lat_long && latitude && longitude){
                
                if (!isFinite(latitude) || !isFinite(longitude) || latitude < -90 || latitude > 90 || longitude < -180 || longitude > 180){
                    
                    if (!isFinite(latitude) || latitude < -90 || latitude > 90){
                        valid_coord = false;
                    }
                    if (!isFinite(longitude) || longitude < -180 || longitude > 180){
                        valid_coord = false;
                    }
                }
                
                if (valid_coord) {
                   callMap = true; 
                }
                
            } else {
                if (address){
                    locations[array_index] = address;
                    array_index++;
                    callMap = true;
                }

                if (zip){
                    locations[array_index] = zip;
                    array_index++;
                    callMap = true;
                }

                if (document.getElementById('location_4')) {
                    index = form.location_4.selectedIndex;
                    if (document.getElementById('location_4').options[index].value) {
                        location_4 = document.getElementById('location_4').options[index].text;
                        locations[array_index] = location_4;
                        array_index++;
                        callMap = true;
                    }
                } else if (document.getElementById('city')) {
                    location_4 = document.getElementById('city').value;
                    locations[array_index] = location_4;
                    array_index++;
                    callMap = true;
                }
                
                if (document.getElementById('new_location4_field') && document.getElementById('new_location4_field').value) {
                        location_4 = document.getElementById('new_location4_field').value;
                        locations[array_index] = location_4;
                        array_index++;
                        callMap = true;
                }

                if (document.getElementById('location_3')) {
                    index = form.location_3.selectedIndex;
                    if (document.getElementById('location_3').options[index].value) {
                        location_3 = document.getElementById('location_3').options[index].text;
                        locations[array_index] = location_3;
                        array_index++;
                        callMap = true;
                    }
                } else if (document.getElementById('state')) {
                    location_3 = document.getElementById('state').value;
                    locations[array_index] = location_3;
                    array_index++;
                    callMap = true;
                }

                google_location = locations.join(", ");
            }

            if (callMap){
                $("#tableMapTuning").css("display", "");
                initialize(<?=($map_zoom ? $map_zoom : 15)?>, google_location, latitude, longitude, use_lat_long);
            } else {
                if (!latitude && !longitude){
                    $("#tableMapTuning").css("display", "none");
                }
            }
        }

    </script>