<?php

if (IN_serendipity !== true) {
	die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));
include_once dirname(__FILE__) . '/plugin_version.inc.php';

class serendipity_event_static_osm extends serendipity_event
{
	function introspect(&$propbag)
	{
		$propbag->add('name', PLUGIN_EVENT_STATIC_OSM_NAME);
		$propbag->add('description', PLUGIN_EVENT_STATIC_OSM_DESCRIPTION);
		$propbag->add('copyright', 'GPL');
		$propbag->add('configuration', ['compress_gpx']);
		$propbag->add('event_hooks', [
			'frontend_header' => true,
			'backend_image_add' => true
		]);
		$propbag->add('author', PLUGIN_EVENT_OSM_AUTHOR);
		$propbag->add('version', PLUGIN_EVENT_OSM_VERSION);
		$propbag->add('requirements', [
			'php' => '7.0.0',
			'serendipity' => '2.3'
		]);
		$propbag->add('stackable', false);
		$propbag->add('groups', ['FRONTEND_ENTRY_RELATED']);
		$this->dependencies = [
			'serendipity_event_geo_osm' => 'keep'
		];
	}

	function generate_content(&$title)
	{
		$title = PLUGIN_EVENT_STATIC_OSM_NAME;
	}

	function event_hook($event, &$bag, &$eventData, $addData = null)
	{
		if ($event === 'frontend_header') {
			echo '    <link rel="stylesheet" href="' . $this->getFile('ressources/ol.css', 'serendipityHTTPPath') . '" type="text/css" />' . PHP_EOL;
			echo '    <link rel="stylesheet" href="' . $this->getFile('ressources/osm.css', 'serendipityHTTPPath') . '" type="text/css" />' . PHP_EOL;
			echo '    <script src="' . $this->getFile('ressources/ol.js', 'serendipityHTTPPath') . '"></script>' . PHP_EOL;
			echo '    <script src="' . $this->getFile('ressources/osm.js', 'serendipityHTTPPath') . '"></script>' . PHP_EOL;
		} else if ($event === 'backend_image_add') {
			$fileName = $eventData;
			if (str_ends_with(strtolower($fileName), '.gpx') && $this->get_config('compress_gpx', true) === true) {
				$gpx = new SimpleXMLElement($fileName, dataIsURL: true);
				$tmpGpx = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" standalone="yes" ?><gpx version="1.1" creator="surrim.org" xmlns="http://www.topografix.com/GPX/1/1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.topografix.com/GPX/1/1 http://www.topografix.com/GPX/1/1/gpx.xsd"></gpx>');
				foreach (($gpx->trk ?? []) as $trk) {
					$tmpTrk = $tmpGpx->addChild('trk');
					foreach (($trk->trkseg ?? []) as $trkseg) {
						$tmpTrkseg = $tmpTrk->addChild('trkseg');
						foreach (($trkseg->trkpt ?? []) as $trkpt) {
							$tmpTrkpt = $tmpTrkseg->addChild('trkpt');
							$tmpTrkpt->addAttribute('lat', $trkpt['lat']);
							$tmpTrkpt->addAttribute('lon', $trkpt['lon']);
							if ($trkpt->ele != '') {
								$tmpTrkpt->addChild('ele', $trkpt->ele);
							}
						}
					}
				}
				$tmpGpx->asXML($fileName);
				clearstatcache(true, $fileName);

				$fileId = $addData['image_id'];
				$fileSize = filesize($fileName);
				serendipity_updateImageInDatabase(['size' => $fileSize], $fileId);
			}
		}
	}

	function introspect_config_item($name, &$propbag)
	{
		switch($name) {
			case 'compress_gpx':
				$propbag->add('type',        'boolean');
				$propbag->add('name',        PLUGIN_EVENT_STATIC_OSM_COMPRESS_GPX);
				$propbag->add('description', PLUGIN_EVENT_STATIC_OSM_COMPRESS_GPX_DESCRIPTION);
				$propbag->add('default',     true);
				break;
			default:
				return false;
		}
		return true;
	}
}
