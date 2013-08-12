<?php # 

// 20050923 Zoran Kovacevic (http://www.kovacevic.nl/blog).
// The plugin is a shameless copy from Rob Antonishen (http://ffaat.pointclark.net/).
// The GMap javascript code is a shameless copy from Mikel Maron (http://brainoff.com/gmaps/rss.html).

// Wishlist
// - generate KML file to provide a fly-over in Google Earth
//   http://www.keyhole.com/kml/kml_doc.html
//   or use the Network Links option ..
// - link to larger google map

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

class serendipity_plugin_geotag extends serendipity_plugin {

    function introspect(&$propbag) {
        $propbag->add('name',        PLUGIN_GEOTAG_GMAP_NAME);
        $propbag->add('description', PLUGIN_GEOTAG_GMAP_NAME_DESC);
        $propbag->add('author',      PLUGIN_EVENT_GEOTAG_AUTHOR);
        $propbag->add('stackable',   false);
        $propbag->add('version',     PLUGIN_EVENT_GEOTAG_VERSION);
        $propbag->add('configuration', array('title','service','key','width','height','latitude','longitude','zoom','type','rss_url','geodata_source','category'));
        $propbag->add('requirements',  array(
            'serendipity' => '0.9',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups',      array('FRONTEND_EXTERNAL_SERVICES'));
    }

    function introspect_config_item($name, &$propbag) {
      global $serendipity;
        switch($name) {
            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GEOTAG_GMAP_TITLE);
                $propbag->add('description', PLUGIN_GEOTAG_GMAP_TITLE_DESC);
                $propbag->add('default',     PLUGIN_GEOTAG_GMAP_TITLE_DEFAULT);
                break;

            case 'service':
                $propbag->add('type',        'select');
                $propbag->add('select_values', array(
                    'google'     => 'Google Maps',
                    'osm'        => 'Openstreetmap',
                ));
                $propbag->add('name',        PLUGIN_GEOTAG_SERVICE);
                $propbag->add('description', PLUGIN_GEOTAG_SERVICE_DESC);
                $propbag->add('default', 'google');

                break;

            case 'key':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GEOTAG_GMAP_KEY);
                $propbag->add('description', PLUGIN_GEOTAG_GMAP_KEY_DESC.' ('.$serendipity['baseURL'].')');
                $propbag->add('default',     'XXXYYYZZZ');
                break;

            case 'width':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GEOTAG_GMAP_WIDTH);
                $propbag->add('description', PLUGIN_GEOTAG_GMAP_WIDTH_DESC);
                $propbag->add('default',     220);
                break;

            case 'height':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GEOTAG_GMAP_HEIGHT);
                $propbag->add('description', PLUGIN_GEOTAG_GMAP_HEIGHT_DESC);
                $propbag->add('default',     150);
                break;

            case 'latitude':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GEOTAG_GMAP_LATITUDE);
                $propbag->add('description', PLUGIN_GEOTAG_GMAP_LATITUDE_DESC);
                $propbag->add('default',     0);
                break;

            case 'longitude':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GEOTAG_GMAP_LONGITUDE);
                $propbag->add('description', PLUGIN_GEOTAG_GMAP_LONGITUDE_DESC);
                $propbag->add('default',     0);
                break;

            case 'zoom':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GEOTAG_GMAP_ZOOM);
                $propbag->add('description', PLUGIN_GEOTAG_GMAP_ZOOM_DESC);
                $propbag->add('default',     1);
                break;

            case 'type':
                $propbag->add('type', 		'select');
                $propbag->add('name', PLUGIN_GEOTAG_GMAP_TYPE);
                $propbag->add('description', PLUGIN_GEOTAG_GMAP_TYPE_DESC);
                $propbag->add('default', 'G_HYBRID_MAP');
                $propbag->add('select_values', array(
                    'SATELLITE'=>PLUGIN_GEOTAG_GMAP_SATELLITE,
                    'ROADMAP'=>PLUGIN_GEOTAG_GMAP_MAP,
                    'HYBRID'=>PLUGIN_GEOTAG_GMAP_HYBRID,
                    'TERRAIN'=>PLUGIN_GEOTAG_GMAP_TERRAIN
                ));
                break;

            case 'rss_url':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GEOTAG_GMAP_RSSURL);
                $propbag->add('description', PLUGIN_GEOTAG_GMAP_RSSURL_DESC.' ('.$serendipity['baseURL'].'feeds/index.rss2?all=1)');
                $propbag->add('default',     $serendipity['baseURL'].'rss.php');
                break;

            case 'geodata_source':
                $propbag->add('type',        'select');
                $propbag->add('select_values', array('database'     => PLUGIN_GEOTAG_GMAP_DATABASE,
                                                     'rss'      => 'RSS'));
                $propbag->add('name',        PLUGIN_GEOTAG_GMAP_GEODATA_SOURCE);
                $propbag->add('description', PLUGIN_GEOTAG_GMAP_GEODATA_SOURCE_DESC);
                $propbag->add('default', 'database');

                break;

            case 'category':
                $cat = serendipity_fetchCategories();
                $cat_array = array();
                $cat_array[0] = ALL_CATEGORIES;
                if (is_array($cat)) {
                    foreach ($cat as $c) {
                        $cat_array[$c['categoryid']] = $c['category_name'];
                    }
                }
                $propbag->add('type',        'select');
                $propbag->add('select_values', $cat_array);
                $propbag->add('name',        CATEGORY);
                $propbag->add('description', PLUGIN_GEOTAG_GMAP_CATEGORY_DESC);
                $propbag->add('default', '0');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {
        global $serendipity;

        //get config vars
        $title = $this->get_config('title');
        $service = $this->get_config('service');
        $key = trim($this->get_config('key'));
        $width = $this->get_config('width', 220);
        $height = $this->get_config('height', 150);
        $longitude = $this->get_config('longitude', 0);
        $latitude = $this->get_config('latitude', 0);
        $zoom = $this->get_config('zoom', 1);
        $type = $this->get_config('type');
        $rss_url = $this->get_config('rss_url');
        $geodata_source = $this->get_config('geodata_source', 'rss');
        $category = $this->get_config('category');

        if (!is_numeric($width)) {
            $width = 220;
        } else {
            $width = (int)$width;
        }
        if (!is_numeric($height)) {
            $height = 150;
        } else {
            $height = (int)$height;
        }
        if (!is_numeric($longitude)) {
            $longitude = 0;
        } else {
            $longitude = (float)$longitude;
        }
        if (!is_numeric($latitude)) {
            $latitude = 0;
        } else {
            $latitude = (float)$latitude;
        }
        if (!is_numeric($zoom)) {
            $zoom = 2;
        } else {
            $zoom = min(max((int)$zoom, 0), $service === 'google' ? 21 : 18);
        }

        if ($geodata_source == 'database') {
            if ($category == 0) {
                $cat_query = "";
                $cat_join = "";
            } else {
                $cat_query = "AND categoryid = $category";
                $cat_join = "LEFT JOIN {$serendipity['dbPrefix']}entrycat as c ON (c.entryid = id)";
            }
            $q = "SELECT id, title, e1.value as lng, e2.value as lat, permalink
                FROM {$serendipity['dbPrefix']}entries
                LEFT JOIN {$serendipity['dbPrefix']}entryproperties as e1 ON (e1.entryid = id AND e1.property='geo_long')
                LEFT JOIN {$serendipity['dbPrefix']}entryproperties as e2 ON (e2.entryid = id AND e2.property='geo_lat')
                LEFT JOIN {$serendipity['dbPrefix']}permalinks ON (entry_id = id AND type='entry')
                $cat_join
                WHERE e1.property='geo_long' AND e2.property='geo_lat' $cat_query";
            $tt = serendipity_db_query($q);
            if (!is_array($tt)) {
                $tt = array();
            }
        }

        ?>
        <div id="serendipity_geotag_map" style="width: <?php echo $width ?>px; height: <?php echo $height ?>px"></div>
    <?php


if ($geodata_source != 'database') { ?>
<script type="text/javascript ">
(function () {
    getMarkerOptions = function (item) {
        var title = item.getElementsByTagName("title")[0].childNodes[0].nodeValue,
            link = item.getElementsByTagName("link")[0].childNodes[0].nodeValue,
            lat,
            lng;
        if (navigator.userAgent.toLowerCase().indexOf("msie") < 0) {
            if (item.getElementsByTagNameNS("http://www.w3.org/2003/01/geo/wgs84_pos#", "lat").length > 0) {
                item.getElementsByTagNameNS("http://www.w3.org/2003/01/geo/wgs84_pos#", "lat")[0].normalize();
                // Is there a value for geo:lat
                if (item.getElementsByTagNameNS("http://www.w3.org/2003/01/geo/wgs84_pos#", "lat")[0].hasChildNodes()) {
                    // Then there probably is a geo:long too
                    lat = item.getElementsByTagNameNS("http://www.w3.org/2003/01/geo/wgs84_pos#", "lat")[0].childNodes[0].nodeValue;
                    lng = item.getElementsByTagNameNS("http://www.w3.org/2003/01/geo/wgs84_pos#", "long")[0].childNodes[0].nodeValue;
                }
            }
        } else {
            lat = item.getElementsByTagName("geo:lat")[0].childNodes[0].nodeValue;
            if (lat === undefined) {
                lat = item.getElementsByTagName("icbm:lat")[0].childNodes[0].nodeValue;
            }
            lng = item.getElementsByTagName("geo:long")[0].childNodes[0].nodeValue;
            if (lng === undefined) {
                lng = item.getElementsByTagName("icbm:long")[0].childNodes[0].nodeValue;
            }
        }
        return {
            lat: lat,
            lng: lng,
            title: title,
            url: link
        };
    };
})();
</script>
<?php
}

/***************
 * GOOGLE MAPS *
 **************/

if ($service === 'google') { ?>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=<?php echo $key;?>&sensor=false"></script>
<script type="text/javascript">
//<![CDATA[
(function () {
    var latlng = new google.maps.LatLng(<?php echo $latitude ?>, <?php echo $longitude ?>),
        myOptions = {
            zoom: <?php echo $zoom; ?>,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.<?php echo $type; ?>,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL
            }
        },
        map = new google.maps.Map(document.getElementById("serendipity_geotag_map"), myOptions);

    setMarker = function (item) {
        var marker = new google.maps.Marker(
            {
                position: new google.maps.LatLng(item.lat, item.lng),
                map: map,
                title: item.title,
                icon: new google.maps.MarkerImage('<?php echo $serendipity['baseURL'] ?>plugins/serendipity_event_geotag/marker_r.png'),
                shadow: new google.maps.MarkerImage('<?php echo $serendipity['baseURL'] ?>plugins/serendipity_event_geotag/marker_s.png')
            }
        );
        var infoWindow = new google.maps.InfoWindow(
            {
                content: '<a href="' + item.url + '">' + item.title + '</a>'
            }
        );
        google.maps.event.addListener(marker, 'click', function () {
            infoWindow.open(map, marker);
        });
    };
})();

<?php
    if ($geodata_source == 'database') {
        foreach ($tt as $t) { ?>
setMarker({
    lat: <?php echo $t['lat']; ?>,
    lng: <?php echo $t['lng']; ?>,
    title: '<?php echo $t['title']; ?>',
    url: '<?php echo $t['permalink']; ?>'
});

<?php   }
    } else { ?>

var rss_url = "<?php echo $rss_url; ?>";
if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
} else { // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange = function () {
    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
        var xmlDoc = xmlhttp.responseXML,
            items = xmlDoc.documentElement.getElementsByTagName('item');
        for (var i = 0; i < items.length; i++) {
            var item = items[i];
            try {
                setMarker(getMarkerOptions(item));
            } catch (e) {
                console.log(e);
            }
        }
    }
};
xmlhttp.open('GET', rss_url, true);
xmlhttp.send(null);
<?php
}
?>
//]]>
</script>
        <?php

/*****************
 * OPENSTREETMAP *
 ****************/

        } elseif ($service === 'osm') {
            ?>
<script src="http://openlayers.org/api/OpenLayers.js"></script>
<script type="text/javascript">
(function () {
    createPopup = function (evt) {
        var popup = new OpenLayers.Popup.FramedCloud(
            null,
            this.marker.lonlat,
            null,
            '<a href="' + urls[this.id] + '">' + titles[this.id] + '</a>',
            null,
            true,
            null
        );
        map.addPopup(popup, true);
        OpenLayers.Event.stop(evt);
    };

    setMarkerOsm = function (mOpt, i) {
        var myMarker =  new OpenLayers.Marker(
            new OpenLayers.LonLat(mOpt.lng, mOpt.lat).transform(
                new OpenLayers.Projection("EPSG:4326"),
                map.getProjectionObject()
            ),
            (i === 0) ? icon : icon.clone()
        );
        titles.push(mOpt.title);
        urls.push(mOpt.url);
        myMarker.events.register('mousedown', myMarker, function (evt) {
            var popup = new OpenLayers.Popup.FramedCloud(
                null,
                myMarker.lonlat,
                null,
                "<a href='" + mOpt.url + "'>" + mOpt.title + "</a> ",
                null,
                true,
                null
            );
            map.addPopup(popup);
            OpenLayers.Event.stop(evt);
        });
        markerCollection.addMarker(myMarker);
    };
})();
var map = new OpenLayers.Map("serendipity_geotag_map");
map.addLayer(new OpenLayers.Layer.OSM());
var lonLat = new OpenLayers.LonLat(<?php echo $longitude; ?>, <?php echo $latitude; ?>).transform(
    new OpenLayers.Projection("EPSG:4326"),
    map.getProjectionObject()
);
var zoom = <?php echo $zoom; ?>,
    markerCollection = new OpenLayers.Layer.Markers("Markers");
var attribution = document.getElementsByClassName('olControlAttribution'),
    attr = attribution[0],
    size = new OpenLayers.Size(10, 10),
    offset = new OpenLayers.Pixel(-(size.w / 2), -size.h),
    icon = new OpenLayers.Icon('<?php echo $serendipity['baseURL'] ?>plugins/serendipity_event_geotag/marker_r.png', size, offset),
    titles = [],
    urls = [];
attr.setAttribute('style', 'position: absolute; z-index: 1004; bottom: 0;');
map.addLayer(markerCollection);
map.setCenter(lonLat, zoom);
<?php
    if ($geodata_source === 'database') {
        $counter = 0;
        foreach ($tt as $t) { ?>

titles.push('<?php echo $t['title']; ?>');
urls.push('<?php echo $t['permalink']; ?>');
setMarkerOsm(
    {
        lat: <?php echo $t['lat']; ?>,
        lng: <?php echo $t['lng']; ?>,
        title: '<?php echo $t['title']; ?>',
        url: '<?php echo $t['permalink']; ?>'
    },
    null
);
<?php
            $counter++;
        }
    } else { ?>

var rss_url = "<?php echo $rss_url; ?>",
    popup,
    m;
if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
} else { // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
        var xmlDoc = xmlhttp.responseXML,
            items = xmlDoc.documentElement.getElementsByTagName('item'),
            item;
        for (var i = 0; i < items.length; i++) {
            item = items[i];
            try {
                setMarkerOsm(getMarkerOptions(item), i);
            } catch (e) {
                console.log(e);
            }
        }
    }
};
xmlhttp.open('GET', rss_url, true);
xmlhttp.send(null);
    <?php
    } // END database || RSS
            ?>
</script>
    <?php
        }
    }
}