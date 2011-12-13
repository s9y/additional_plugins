<?php
/**
 * serendipity_plugin_flickrbadge - Your last photos from Flickr.com
 *
 * Serendipity plugin implementing a sidebar item which displays your last photos
 * you have added to Flickr.com
 *
 * @author Lars Strojny <lars@strojny.net>
 */
@define('SERENDIPITY_PLUGIN_FLICKRBADGE_VERSION', '0.10');

if (IN_SERENDIPITY != true) die("Don't hack");

if (version_compare(phpversion(), '5.1.0', '>=')) {
	$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
	if (file_exists($probelang)) include $probelang;
	else include 'lang_en.inc.php';

	require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'plugin.inc.php';
}
