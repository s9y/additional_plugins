<?
/** Testfile für die Provider Konfiguration
 * @author: Grischa Brockhaus
 */

require_once(dirname(__FILE__) . '/../' . "config.php");

function test($manager, $url) {
	$obj=$manager->provide($url,"object");
	if (!empty($obj)) print_r($obj);
}

$manager = ProviderManager::getInstance();
// Youtube long link
test($manager,"http://www.youtube.com/watch?v=8UVNT4wvIGY");
 // Youtube Kurze URL
test($manager,"http://youtu.be/8UVNT4wvIGY");
// Twitter
test($manager,"https://twitter.com/#!/tagesschau/status/146562892454572032");
// flickr
test($manager,"http://www.flickr.com/photos/gbrockhaus/2052855443/in/set-72157603214268227/");
// vimeo
test($manager,"http://vimeo.com/33510073");

