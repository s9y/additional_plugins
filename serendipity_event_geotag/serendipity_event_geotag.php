<?php # 

// Zoran Kovacevic http://www.kovacevic.nl/blog
// Shameless copy of serendipity_event_entryproperties and serendipity_event_multilingual


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';
include dirname(__FILE__) . '/plugin_version.inc.php';
include dirname(__FILE__) . '/GeoTagDb.class.php';

@define("PLUGIN_EVENT_GEOTAG_DEBUG",FALSE);

class serendipity_event_geotag extends serendipity_event
{
    var $services;
    var $title = PLUGIN_EVENT_GEOTAG_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_GEOTAG_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_GEOTAG_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        PLUGIN_EVENT_GEOTAG_AUTHOR);
        $propbag->add('version',       PLUGIN_EVENT_GEOTAG_VERSION);
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',    array(
            'backend_publish'                                   => true,
            'backend_save'                                      => true,
            'backend_display'                                   => true,
            'backend_delete_entry'                              => true,
        	'css'                                               => true,
            'entry_display'                                     => true,
            'frontend_entryproperties'                          => true,
            'frontend_entryproperties_query'                    => true,
            'frontend_fetchentries'                             => true,
            'frontend_fetchentry'                               => true,
            'frontend_display:rss-2.0:namespace'                => true,
            'frontend_display:rss-2.0:per_entry'                => true,
            'frontend_header'									=> true,
            'external_plugin'                                   => true,
            'xmlrpc_updertEntry'                                => true,
            'xmlrpc_deleteEntry'                                => true,
        ));

        $propbag->add('groups',                 array('BACKEND_EDITOR'));
        $propbag->add('configuration', 
        array('content_geourl_warning', 'content_editor',
        	'api_key','init_latitude','init_longitude','zoom','editor_autofill',
        	'content_geotag_header',
            'hdr_default_lat', 'hdr_default_long',
        	'content_footer',
        	'map_url_desc','map_url','map_link_blank','service', 
        	'content_footer_list',
        	'geo_image', 'geo_image_height','geo_image_width','geo_image_zoom','geo_image_marker_size',
        	'content_footer_single',
        	'article_geo_image','article_geo_image_height','article_geo_image_width','article_geo_image_zoom','article_geo_image_marker_size',
        	'footer_example','article_example'));
        $this->supported_properties = array('geo_long', 'geo_lat');
    }

    function introspect_config_item($name, &$propbag)
    {
	    //  // mid, small, normal
        $markers = array(
            'tiny'   => PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_TINY,
            'small'  => PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_SMALL,
        	'mid'    => PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_MID,
        	'normal' => PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_NORMAL,
        );
        
        
        switch($name) {
            case 'content_geourl_warning':
                $propbag->add('type',        'content');
                if (class_exists('serendipity_event_geourl')) {
                    $propbag->add('default',     '<div class="serendipityAdminMsgError">'. PLUGIN_EVENT_GEOTAG_WARNING_GEOURL_PLUGIN .'</div>');
                }
                break;
            case 'content_editor':
                $propbag->add('type',        'content');
		        $propbag->add('default',     '<h3><br/>' . PLUGIN_EVENT_GEOTAG_HEADER_EDITOR . '</h3>');
                break;
            case 'content_footer':
                $propbag->add('type',        'content');
		        $propbag->add('default',     '<h3><br/>' . PLUGIN_EVENT_GEOTAG_HEADER_FOOTER . '</h3>');
                break;
            case 'content_footer_list':
                $propbag->add('type',        'content');
		        $propbag->add('default',     '<h4><br/>' . PLUGIN_EVENT_GEOTAG_HEADER_FOOTER_LIST . '</h4>');
                break;
            case 'content_footer_single':
                $propbag->add('type',        'content');
		        $propbag->add('default',     '<h4><br/>' . PLUGIN_EVENT_GEOTAG_HEADER_FOOTER_SINGLE . '</h4>');
                break;
            case 'content_geotag_header':
                $propbag->add('type',        'content');
		        $propbag->add('default',     '<h3><br/>' . PLUGIN_EVENT_GEOTAG_HEADER_HDRTAG . '</h3>' . PLUGIN_EVENT_GEOTAG_HEADER_HDRTAG_DESC);
                break;
                
            case 'footer_example':
                $propbag->add('type',        'content');
		        $propbag->add('default',     '<center>Articlelist example:<br/>'. $this->getFooterImage("Test Example", "52.47216", "13.44418", FALSE, TRUE) . '</center>');
                break;
            case 'article_example':
                $propbag->add('type',        'content');
		        $propbag->add('default',     '<center>Single article example:<br/>'. $this->getFooterImage("Test Example", "52.47216", "13.44418", TRUE, TRUE) . '</center>');
                break;
            case 'service':
                $propbag->add('type',        'select');
                $propbag->add('select_values', array(
                    'google'     => 'Google Maps',
                    'osm'        => 'Openstreetmap',
                ));
                $propbag->add('name',        PLUGIN_GEOTAG_SERVICE);
                $propbag->add('description', PLUGIN_EVENT_GEOTAG_SERVICE_DESC);
                $propbag->add('default', 'google');

                break;

            case 'map_url_desc':
                $propbag->add('type',        'content');
		        $propbag->add('default',     PLUGIN_EVENT_GEOTAG_MAP_DESC);
                break;
            case 'map_url':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_GEOTAG_MAP_URL);
		        $propbag->add('default',     'http://www.openstreetmap.org/?mlat=%GEO_LAT%&mlon=%GEO_LONG%&zoom=15&layers=M');
                break;
            case 'api_key':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_GEOTAG_API_KEY);
                $propbag->add('description', PLUGIN_EVENT_GEOTAG_API_KEY_DESC);
				break;
			case 'init_latitude':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_GEOTAG_LAT);
                $propbag->add('description', PLUGIN_EVENT_GEOTAG_LAT_DESC);
				break;
			case 'init_longitude':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_GEOTAG_LONG);
                $propbag->add('description', PLUGIN_EVENT_GEOTAG_LONG_DESC);
				break;
			case 'zoom':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_GEOTAG_ZOOM);
                $propbag->add('description', PLUGIN_EVENT_GEOTAG_ZOOM_DESC);
                $propbag->add('default',     14);
                break;
			case 'editor_autofill':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_GEOTAG_EDITOR_AUTOFILL);
                $propbag->add('description', PLUGIN_EVENT_GEOTAG_EDITOR_AUTOFILL_DESC);
                $propbag->add('default',        false);
                break;
                
            case 'map_link_blank':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_GEOTAG_MAP_LINK_BLANK);
                $propbag->add('description',    PLUGIN_EVENT_GEOTAG_MAP_LINK_BLANK_DESC);
                $propbag->add('default',        false);
                break;

// HTML HEAD tagging
			case 'hdr_default_lat':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LAT);
                $propbag->add('description', PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LAT_DESC);
                break;
			case 'hdr_default_long':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LONG);
                $propbag->add('description', PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LONG_DESC);
                break;

// Footer article list
            case 'geo_image':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_GEOTAG_SHOW_IMAGE);
                $propbag->add('description',    PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_DESC);
                $propbag->add('default',        false);
                break;
			case 'geo_image_height':
                $propbag->add('type',        'string');
                $propbag->add('name',           PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_HEIGHT);
                $propbag->add('description',    PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_HEIGHT_DESC);
                $propbag->add('default',        20);
                break;
            case 'geo_image_width':
                $propbag->add('type',        'string');
                $propbag->add('name',           PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_WIDTH);
                $propbag->add('description',    PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_WIDTH_DESC);
                $propbag->add('default',        150);
                break;
            case 'geo_image_zoom':
                $propbag->add('type',        'string');
                $propbag->add('name',           PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_ZOOM);
                $propbag->add('description',    PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_ZOOM_DESC);
                $propbag->add('default',        10);
                break;
			case 'geo_image_marker_size':
			    $propbag->add('type',           'select');
			    $propbag->add('name',           PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE);
                $propbag->add('description',    PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_DESC);
                $propbag->add('select_values',  $markers);
                $propbag->add('default',        'tiny');
                break;
                
                
// Footer single article
            case 'article_geo_image':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_GEOTAG_SHOW_IMAGE);
                $propbag->add('description',    PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_DESC);
                $propbag->add('default',        false);
                break;
			case 'article_geo_image_height':
                $propbag->add('type',        'string');
                $propbag->add('name',           PLUGIN_EVENT_GEOTAG_SHOW_IMAGE);
                $propbag->add('description',    PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_HEIGHT_DESC);
                $propbag->add('default',        150);
                break;
            case 'article_geo_image_width':
                $propbag->add('type',        'string');
                $propbag->add('name',           PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_WIDTH);
                $propbag->add('description',    PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_WIDTH_DESC);
                $propbag->add('default',        200);
                break;
			case 'article_geo_image_zoom':
                $propbag->add('type',        'string');
                $propbag->add('name',           PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_ZOOM);
                $propbag->add('description',    PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_ZOOM_DESC);
                $propbag->add('default',        14);
                break;

			case 'article_geo_image_marker_size':
			    $propbag->add('type',           'select');
			    $propbag->add('name',           PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE);
                $propbag->add('description',    PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_DESC);
                $propbag->add('select_values',  $markers);
                $propbag->add('default',        'small');
                break;
        }
        return true;
    }
    
    /**
     *  Will be called while saving settings
     */
    function cleanup() {
        global $serendipity;
        
        // *Always* clean up the cache after changing configuration 
        $cacheDir = $this->getCacheDirectory();
        if (is_dir($cacheDir) && $handle = opendir($cacheDir)) {
            while (false !== ($file = readdir($handle))) {
                $filename = $cacheDir . '/' . $file;
                if (!is_dir($filename)) {
                    unlink($filename);
                }
            }
            echo '<div class="serendipityAdminMsgSuccess">Footer map cache cleared</div>';
        }
        // Cleanup of GeoURL plugin: ping the geourl service:
        if($this->get_config('hdr_default_lat') && $this->get_config('hdr_default_long')) {
            echo '<div class="serendipityAdminMsgSuccess">';
            // Try to get the URL

            $geourl = "http://geourl.org/ping/?p=" . $serendipity['baseURL'];

            if (function_exists('serendipity_request_url')) {
                $data = serendipity_request_url($geourl);
                if (empty($data)) {
                    printf(REMOTE_FILE_NOT_FOUND, $geourl);
                } else {
                    echo PLUGIN_EVENT_GEOTAG_GEOURL_PINGED;
                }
            } else {
                include_once S9Y_PEAR_PATH . 'HTTP/Request.php';
                $req = new HTTP_Request($geourl);
                if (PEAR::isError($req->sendRequest($geourl))) {
                    printf(REMOTE_FILE_NOT_FOUND, $geourl);
                } else {
                    echo PLUGIN_EVENT_GEOTAG_GEOURL_PINGED;
                }
            }
            echo '</div>';
        }
    }
    
    function generate_content(&$title) {
        $title = $this->title;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        $is_cache = serendipity_db_bool($this->get_config('cache', 'true'));
        if (isset($hooks[$event])) {
            switch($event) {
                // Cached Maps
                case 'external_plugin':
                    $parts = explode('_', $eventData);
                    if (count($parts)!=4) {
                        return false;
                    }
                    $lat = $parts[1];
                    $long =  $parts[2];
                    $isArticle = $parts[3] === 'a';
                    if ($parts[0] == 'fetchGeoTagMap') { // Fetch and cache it
                        $this->fetchCacheMap($lat, $long, $isArticle);
                    }
                    else if ($parts[0] == 'cachedGeoTagMap') { // Load cached version
                        $this->loadCachedMap($lat, $long, $isArticle);
                    }
                    break;
                case 'backend_display':
                    if (isset($eventData['properties']['geo_long'])) {
                        $geo_long = $eventData['properties']['geo_long'];
                    } elseif (isset($serendipity['POST']['properties']['geo_long'])) {
                        $geo_long = $serendipity['POST']['properties']['geo_long'];
                    } else {
                        $geo_long = "";
                    }
                    if (isset($eventData['properties']['geo_lat'])) {
                        $geo_lat = $eventData['properties']['geo_lat'];
                    } elseif (isset($serendipity['POST']['properties']['geo_lat'])) {
                        $geo_lat = $serendipity['POST']['properties']['geo_lat'];
                    } else {
                        $geo_lat = "";
                    }
                    // initialise from config
                    $initZoom = $this->get_config('zoom', 14);
    	            $autofill_editor = serendipity_db_bool($this->get_config('editor_autofill',false));
                    ?>
                    <script type="text/javascript">
                        function paste(event) {
                           if (Math.abs(this.selectionEnd - this.selectionStart) === this.value.length) {
                              const geo = event.clipboardData.getData('text/plain');
                              const found = geo.match(/^\s*(\d+(\.\d+))\s*[,/]\s*(\d+(\.\d+)?)\s*$/);
                              if (found !== null) {
                                 this.value = found[1];
                                 document.getElementById(this.id === "properties_geo_lat" ? "properties_geo_long" : "properties_geo_lat").value = found[3];
                              } else {
                                 this.value = geo;
                              }
                              this.selectionStart = this.value.length;
                              this.selectionEnd = this.value.length;
                              return false;
                           }
                           return true;
                        }
                    </script>
                    <fieldset style="margin: 5px">
                        <legend><?php echo PLUGIN_EVENT_GEOTAG_TITLE; ?></legend>
                            <input class="input_textbox" type="text" name="serendipity[properties][geo_lat]" id="properties_geo_lat" value="<?php echo $geo_lat ?>"  onkeydown="if (event.keyCode == 13) {updateMap(); return false}" onpaste="return paste.call(this, arguments[0])"/>
                            <label title="<?php echo PLUGIN_EVENT_GEOTAG_LAT; ?>" for="properties_geo_lat">&nbsp;<?php echo PLUGIN_EVENT_GEOTAG_LAT; ?>&nbsp;&nbsp;</label>
                            <input class="input_textbox" type="text" name="serendipity[properties][geo_long]" id="properties_geo_long" value="<?php echo $geo_long ?>"  onkeydown="if (event.keyCode == 13) {updateMap(); return false}" onpaste="return paste.call(this, arguments[0])"/>
                            <label title="<?php echo PLUGIN_EVENT_GEOTAG_LONG; ?>" for="properties_geo_long">&nbsp;<?php echo PLUGIN_EVENT_GEOTAG_LONG; ?>&nbsp;&nbsp;</label>
                            <?php if ($this->get_config('api_key') !== ''): ?>
                            <input type="button" onClick="getCurrentPosition(true)" value="<?php echo PLUGIN_GEOTAG_GMAP_GEOCODE_GET_CODE; ?>" />
                            <input type="button" onClick="clearLocation();" value="<?php echo PLUGIN_EVENT_CLEAR_LOCATION; ?>" />
                            <p /><p>
                            <input type="text" id="geoTagAddress" value="<?php echo PLUGIN_GEOTAG_GMAP_GEOCODE_TYPE_ADDRESS; ?>" onkeydown="if (event.keyCode == 13) {geoCode(); return false;}" onClick="clearAdressInput();"/>
                            <input type="button" onClick="geoCode()" value="<?php echo PLUGIN_GEOTAG_GMAP_GEOCODE; ?>" />
                            <?php endif; ?>
                            <span id="geoCodeMsg"> </span></p><?php
					if (($this->get_config('api_key'))!="") {
							?>
							<div id="locationpicker" style="width: 690px; height: 350px"></div>
							<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $this->get_config('api_key') ?>" type="text/javascript"></script>
							<script type="text/javascript">
							//<![CDATA[
								function clearLocation() {
									document.getElementById('properties_geo_lat').value = '#';
									document.getElementById('properties_geo_long').value = '#';
								}
								
                                var map;
								function GLocationPicker(
                                		pickerDivId,
                                		latitudeFieldId,
                                		longitudeFieldId,
                                		initLatitude,
                                		initLongitude,
                                		initZoom
                                		) {


									map = new GMap2(document.getElementById(pickerDivId));
									var initPoint = new GLatLng(initLatitude, initLongitude);
									map.addControl(new GSmallMapControl());
									map.addControl(new GMapTypeControl());
									map.setCenter(initPoint, initZoom);
									map.addOverlay(new GMarker(initPoint));


                                	GEvent.addListener(map, "click", function(overlay, point) {
                                		document.getElementById(latitudeFieldId).value = point.y.toFixed(5);
                                		document.getElementById(longitudeFieldId).value = point.x.toFixed(5);
										map.clearOverlays();
										map.addOverlay(new GMarker(point));
                                	});
                                }

								// References to DOM elements to use
								var pickerDivId = "locationpicker";
								var latitudeFieldId = "properties_geo_lat";
								var longitudeFieldId = "properties_geo_long";

								// Startup parameters
								var initLatitude = document.getElementById(latitudeFieldId).value;
								if (initLatitude == 0) initLatitude = <?php echo $this->get_config('init_latitude',0);?>;
								var initLongitude = document.getElementById(longitudeFieldId).value
								if (initLongitude == 0) initLongitude = <?php echo $this->get_config('init_longitude',0);?>;
								var initZoom = <?php echo $initZoom;?>;

								GLocationPicker(
									pickerDivId,
									latitudeFieldId,
									longitudeFieldId,
									initLatitude,
									initLongitude,
									initZoom
									);
                                function geoCode() {
                                    var address = document.getElementById('geoTagAddress').value;
                                    if (GBrowserIsCompatible()) {


                                    document.getElementById('geoCodeMsg').innerHTML = '<?php echo PLUGIN_GEOTAG_GMAP_GEOCODE_MSG_PROGRESS; ?>';
                                    geocoder = new GClientGeocoder();
                                    if (geocoder) {
                                        geocoder.getLatLng(
                                        address,
                                        function(point) {
                                            if (!point) {
                                            document.getElementById('geoCodeMsg').innerHTML = address + '<?php echo PLUGIN_GEOTAG_GMAP_GEOCODE_NOT_FOUND; ?>';
                                            } else {
                                                map.setCenter(point);
                                                map.clearOverlays();
                                                map.addOverlay(new GMarker(point));
                                                document.getElementById(latitudeFieldId).value = point.lat();
                                                document.getElementById(longitudeFieldId).value = point.lng();
                                                document.getElementById('geoCodeMsg').innerHTML = '<?php echo PLUGIN_GEOTAG_GMAP_GEOCODE_OK; ?>';
                                            }
                                        });
                                    }
                                    }

                                }
                                function updateMap() {
                                    var lat = document.getElementById(latitudeFieldId).value;
                                    var lng = document.getElementById(longitudeFieldId).value;
                                    var point = new GLatLng(lat, lng);
                                    map.setCenter(point);
                                    map.clearOverlays();
                                    map.addOverlay(new GMarker(point));
                                }

                                function getCurrentPosition(forced) {
                                	if (!forced && (document.getElementById(latitudeFieldId).value!="" || document.getElementById(longitudeFieldId).value!="")) {
                                    	return; // Already setup some stuff
                                	}
                                	if (navigator.geolocation) { 
                                	    navigator.geolocation.getCurrentPosition(function(position) {
                                	    	document.getElementById(latitudeFieldId).value = position.coords.latitude;  
                                	    	document.getElementById(longitudeFieldId).value = position.coords.longitude;
                                	    	updateMap();
                                	    }); 
                                	}
                                	else {
                                    	alert('Your browser does not support geo locations');
                                	} 
                                }
                                function clearAdressInput() {
                                	var input = document.getElementById('geoTagAddress').value;
                                	if (input == '<?php echo PLUGIN_GEOTAG_GMAP_GEOCODE_TYPE_ADDRESS; ?>') {
                                		document.getElementById('geoTagAddress').value = '';
                                	}
                                }
    							<?php
                        if ($autofill_editor) {
    							?>
    							// Call it
                                getCurrentPosition(false);
    							<?php
					    } // PHP: if autodetect position 
    							?>
							//]]>
							</script>
							<?php
						} // PHP: apikey !=null
							?>
						</fieldset>
<?php
                    return true;

                case 'backend_publish':
                case 'backend_save':
                    // Don't save when sent via xmlrpc. It is saved later.
                    if (isset($serendipity['POST']) && !isset($serendipity['POST']['properties'])) return true;
                    
                    GeoTagDb::addEntryProperties($eventData['id'], $this->supported_properties, $serendipity['POST']['properties']);
                    return true;
                case 'backend_delete_entry':
                    GeoTagDb::delete($eventData['id'], $this->supported_properties);
                    return true;

                case 'frontend_entryproperties':
                    $q = "SELECT entryid, property, value FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid IN (" . implode(', ', array_keys($addData)) . ")";

                    $properties = serendipity_db_query($q);

                    if (!is_array($properties)) {
                        return true;
                    }

                    foreach($properties AS $idx => $row) {
                        $eventData[$addData[$row['entryid']]]['properties'][$row['property']] = $row['value'];
                    }

                    return true;

                case 'css':
                    if (strpos($eventData, '.serendipity_geotag')) {
                        // class exists in CSS, so a user has customized it and we don't need default
                        return true;
                    }
?>
.serendipity_plugin_geotag img {
    max-width: none !important;
}
<?php
                    return true;

                case 'entry_display':
                	// used for looping (seems unnecessary, since we use the foreach ...)
					if (isset($eventData) && is_array($eventData)) {
    					$i = 0;
                    	foreach($eventData as $event) {
    	                    // Check if geo_lat and geo_long are both set
    	                    $props = $eventData[$i]['properties'];
    						$geotagged = true;
    	                    foreach($this->supported_properties AS $prop_key) {
    	                        if (!isset($props[$prop_key])) {
    	                            $geotagged = false;
    	                        }
    	                    }
    	                    if ($geotagged) {
    		                    if (!isset($eventData[$i]['add_footer'])) $eventData[$i]['add_footer'] = "";
    		                    // If extended is set, it's a single article
    		                    $singleArticle = $addData['extended'];
    		                    $eventData[$i]['add_footer'] .= $this->getFooterImage( $eventData[$i]['title'], $props["geo_lat"], $props["geo_long"],$singleArticle);
    	                    }
    	                    $i++;

                        }
                	}
                    return true;
                case 'frontend_header':
                    if (!$serendipity['GET']['id'] && $serendipity['view'] != 'entry') {
                        $lat = $this->get_config('hdr_default_lat');
                        $long = $this->get_config('hdr_default_long');
                        $this->headerGeoTagging($lat,$long, $GLOBALS['serendipity']['blogTitle']);
                        return true;
                    }
                    // we fetch the internal smarty object to get the current entry body
                    $entry = (array)$eventData['smarty']->tpl_vars['entry']->value;
                    $props = $entry['properties'];
                    $geotagged = true;
                    foreach($this->supported_properties AS $prop_key) {
                        if (!isset($props[$prop_key])) {
                            $geotagged = false;
                        }
                    }
                    if ($geotagged) {
                        // echo "<!-- g: " . print_r($GLOBALS['entry'][0],true) ." -->";
	                    $this->headerGeoTagging($props["geo_lat"], $props["geo_long"], $entry['title']);
                    }
                    else {
                        $long = $this->get_config('hdr_default_lat');
                        $lat = $this->get_config('hdr_default_long');
                        $this->headerGeoTagging($lat,$long, $GLOBALS['serendipity']['blogTitle']);
                    }
                    break;
                    
                case 'frontend_display:rss-2.0:namespace':
                    $eventData['display_dat'] .= ' xmlns:geo="http://www.w3.org/2003/01/geo/wgs84_pos#" ';

                    return true;

                case 'frontend_display:rss-2.0:per_entry':
                    // Check if geo_lat and geo_long are both set
                    $props = &$eventData['properties'];
                    foreach($this->supported_properties AS $prop_key) {
                        if (!isset($props[$prop_key])) {
                            return true;
                        }
                    }
                    $eventData['display_dat'] = '<geo:long>' . $props["geo_long"] . '</geo:long>';
                    $eventData['display_dat'] .= '<geo:lat>' . $props["geo_lat"] . '</geo:lat>';

                    return true;

                case 'xmlrpc_deleteEntry':
                    GeoTagDb::delete($eventData['id'], $this->supported_properties);
                    return true;
                case 'xmlrpc_updertEntry':
                    GeoTagDb::addEntryProperties($eventData['id'], $this->supported_properties, $eventData, false);
                    return true;
                default:
                    return false;
            }
        } else {
            return false;
        }
    }
    
    function getFooterImage($title, $lat, $long, $article=FALSE, $uncached=FALSE) {
        global $serendipity;
        
        $config_pre = $article?'article_':'';
        $use_image= serendipity_db_bool($this->get_config($config_pre.'geo_image',false));
        $use_targetblank = serendipity_db_bool($this->get_config('map_link_blank',false));

        $replace_by = isset($title) ? urlencode($title) : "GeoTag";
        
        if ($use_image) { // Mit Karte
            if ($uncached) {
                $imgLink = $this->createMapImageLink($lat, $long, $article);
            }
            else {
                $cachedFileName = $this->getCacheFilePath($lat, $long, $article);
                if (file_exists($cachedFileName)) {
                    $imgLink = $serendipity['baseURL'] . $serendipity['indexFile'] . '?/'
                        . $this->getPermaPluginPath() . '/cachedGeoTagMap_' . $lat . '_' . $long . '_' . ($article?'a':'l');
                }
                else {
                    // fetchGeoTagMap
                    $imgLink = $serendipity['baseURL'] . $serendipity['indexFile'] . '?/'
                        . $this->getPermaPluginPath() . '/fetchGeoTagMap_' . $lat . '_' . $long . '_' . ($article?'a':'l');
                }
            }
            
            $img_title = PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_TITLE;
            $linkdesc = "<img class=\"serendipity_geotag_img\" title=\"$img_title\" src=\"$imgLink\">";
            $msg = '<div class="serendipity_geotag">%s</div>';
        }
        else {
            $linkdesc = "%GEO_LAT%, %GEO_LONG%";
            $msg = '<div class="serendipity_geotag">' . PLUGIN_EVENT_GEOTAG_FRONTEND_LABEL . ': %s</div>';
        }
        // Write the link
        $link = "<a href=\"" . $this->get_config('map_url') . "\"" . ($use_targetblank?" target=\"_blank\"":"")  .">$linkdesc</a>";
        $link = str_replace("%GEO_LAT%", preg_replace('@[^0-9\.,\-]@i', '', $lat), $link);
        $link = str_replace("%GEO_LONG%", preg_replace('@[^0-9\.,\-]@i', '', $long), $link);
        $link = str_replace("%TITLE%", $replace_by, $link);
        
        return sprintf($msg,$link);
    }
    
    function createMapImageLink($lat, $long, $article) {
        global $serendipity;
        
        $config_pre = $article?'article_':'';
        $use_imageheight   = $this->get_config($config_pre . 'geo_image_height',$article?150:20);
        if (!is_numeric($use_imageheight)) $use_imageheight=$article?150:20; 
        
        $use_imagewidth    = $this->get_config($config_pre.'geo_image_width',$article?200:150);
        if (!is_numeric($use_imagewidth)) $use_imagewidth=$article?200:150;
        
        $use_zoom = $this->get_config($config_pre.'geo_image_zoom', $article?14:10);
        if (!is_numeric($use_zoom)) $use_zoom=$article?14:10; 
        
        
        $markersize        = $this->get_config($config_pre.'geo_image_marker_size','tiny');
        
        //maptype=osmarenderer&
        $osmImgLink = "http://staticmap.openstreetmap.de/staticmap.php?center=%GEO_LAT%,%GEO_LONG%&zoom=$use_zoom&size=".$use_imagewidth."x".$use_imageheight."&markers=%GEO_LAT%,%GEO_LONG%,ol-marker-blue";
        $googleImgLink = "http://maps.google.com/maps/api/staticmap?markers=color:blue|size:$markersize|label:Bl|%GEO_LAT%,%GEO_LONG%&size=".$use_imagewidth."x".$use_imageheight."&sensor=true&zoom=$use_zoom";
        $imgLink = ($service = $this->get_config('service','google')==='google')? $googleImgLink:$osmImgLink; 
        
        $imgLink = str_replace("%GEO_LAT%", preg_replace('@[^0-9\.,\-]@i', '', $lat), $imgLink);
        $imgLink = str_replace("%GEO_LONG%", preg_replace('@[^0-9\.,\-]@i', '', $long), $imgLink);
        
        return $imgLink;
    }
    
    function headerGeoTagging($lat, $long, $title) {
        if (empty($lat) || empty($long)) return;
        $title = (function_exists('serendipity_specialchars') ? serendipity_specialchars($title) : htmlspecialchars($title, ENT_COMPAT, LANG_CHARSET));
        echo '<meta name="geo.placename" content="' . $title . '" />' . "\n";
        echo '<meta name="geo.position" content="'. $lat . ';' . $long . '" />' . "\n";
		echo '<meta name="geo.region" content="" />' . "\n";
        echo '<meta name="ICBM" content="'. $lat . ', ' . $long . '" />' . "\n";
        echo '<meta name="DC.title" content="' . $title . '" />' . "\n";
    }
    
    // ======= MAP CACHING START ========================================================================================
    function log($message) {
        if (!PLUGIN_EVENT_GEOTAG_DEBUG) return;
        $fp = fopen($this->getCacheDirectory() . '.log','a');
        fwrite($fp, $message . "\n");
        fflush($fp);
        fclose($fp);
    }
    function fetchCacheMap($lat, $long, $isArticle) {
        $this->log("lat: $lat long: $long a: $isArticle");
        $url = $this->createMapImageLink($lat, $long, $isArticle);
        $this->log($url);
        $this->saveAndResponseMap($url, $lat, $long, $isArticle);
    }
    
    function loadCachedMap($lat, $long, $isArticle) {
        $filename = $this->getCacheFilePath($lat, $long, $isArticle);
        $this->showMap($filename);
    }

	/**
     * Caches a map and streams it back to the browser. 
     */
    function saveAndResponseMap($url, $lat, $long, $isArticle) {
        global $serendipity;
        $fContent   = null;
        
        if (function_exists('serendipity_request_url')) {
            $fContent = serendipity_request_url($url);
        } else {
            require_once S9Y_PEAR_PATH . 'HTTP/Request.php';
            if (function_exists('serendipity_request_start')) {
                serendipity_request_start();
            }
            $request_pars['allowRedirects'] = TRUE;
            $req = new HTTP_Request($url, $request_pars);

            // if the request leads to an error we don't want to have it: return false
            if (PEAR::isError($req->sendRequest()) || ($req->getResponseCode() != '200')) {
                $fContent = null;
            }
            else {
                // Allow only images!
                $mime = $req->getResponseHeader("content-type");
                $mimeparts = explode('/',$mime);
                if (count($mimeparts)==2 && $mimeparts[0]=='image') {
                    $fContent = $req->getResponseBody();
                }
            }
            
            if (function_exists('serendipity_request_start')) {
                serendipity_request_end();
            }
        }
        
        // if no content was fetched, return false
        if (!isset($fContent)){
            return false;
        }

        $cache_file = $this->cacheMap($lat, $long, $isArticle, $fContent, $req);
        if ($cache_file) {
            $this->showMap($cache_file);
        }

        return true;
    }
    
    function cacheMap($lat, $long, $isArticle, $fContent){

        $cache_file = $this->getCacheFilePath($lat, $long, $isArticle);
        if (file_exists($cache_file)) return $cache_file;
        
        // Save image
        @mkdir($this->getCacheDirectory());
        $fp = @fopen($cache_file, 'wb');
        if (!$fp) {
            if (file_exists($cache_file)) {
                return $cache_file;
            }
            else {
                return false;
            }
        }
        fwrite($fp, $fContent);
        fclose($fp);
        return $cache_file;
    }

    /**
     * Return binary response for an image
     */
    function showMap($filename) {
        if (!file_exists($filename)) {
            header('X-GeoTag: No-Image');
            return false;
        } else {
            header('X-GeoTag: Found');
        }
        $size = @getimagesize($filename);
        $mime_type = $size['mime'];
        $this->avatarConfiguration['mime-type'] = $mime_type;         
        
        // test wether this really is (at least declared as) an image!
        // else deny it.
        $mime_parts  = explode('/', $mime_type);
        if (count($mime_parts)!=2 || $mime_parts[0]!='image') {
            return false;
        }
        
        $fp   = @fopen($filename, "rb");
        if ($fp) {
            $nextcheck = time() + (60*60*24*7); // invalidate 7 days later
            $expires_txt = date("D, d M Y H:i:s T",(int)$nextcheck);
            
            $filemtime = filemtime($filename);
            header("Content-type: $mime_type");
            header("Content-Length: ". filesize($filename));
            header("Date: " . date("D, d M Y H:i:s T"));
            header("Last-Modified: " . date("D, d M Y H:i:s T", $filemtime), true);
            header("Cache-Control: public, max-age=" . ((int)$nextcheck - time()) , true);
            header("Expires: $expires_txt". true);
            header("Pragma:", true);
            fpassthru($fp);
            fclose($fp);
        }
        return true;
    }

    /**
     * Returns the cache directory
     */
    function getCacheDirectory(){
        global $serendipity;
        if ($this->cache_dir === null) {
            $this->cache_dir = $serendipity['serendipityPath'] . PATH_SMARTY_COMPILE . '/serendipity_event_geotag';
        }
        return $this->cache_dir;        
    }
    function getCacheFilePath($lat, $long, $isarticle=FALSE){
        global $serendipity;
        $cache_filename = ($isarticle?'a':'l') . md5($lat . "|" . $long);
        return $this->getCacheDirectory() .'/' .  $cache_filename;;
    }

    function getPermaPluginPath() {
        global $serendipity;

        // Get configured plugin path:         
        $pluginPath = 'plugin';
        if (isset($serendipity['permalinkPluginPath'])){
            $pluginPath = $serendipity['permalinkPluginPath'];
        }
        return $pluginPath;
    }
    // ======= MAP CACHING END ==========================================================================================
}
