<?php
/*
tplfile.php

Create output suitable for download from processing a template

Copyright (C) 2006 Chris Lander

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

Contact:
	Chris Lander		Email: clander@labbs.com

	LABBS Web Services
	54 Stanley Street
	Luton
	Bedfordshire
	United Kingdom
	LU1 5AN
*/

// Read in the config file and check if the program is installed
if (file_exists('config.php')) {
	// Include configuration
	include_once 'config.php';
}else{
	// If no headers are sent, send one
	if (!headers_sent()) {
		header("Location: http://" . $_SERVER['HTTP_HOST']
			. dirname($_SERVER['PHP_SELF'])
			. "/install");
	}else{
		echo '<div class="error">ERROR!</div>';
		echo '<p>The main configuration file does NOT exist!</p>';
		echo '<p>Click ';
		html_link('./install/index.php', $text = 'here', $status = 'Install S9Y_Conf', $target = '');
		echo 'to installS9Y_Conf.</p>';
	}
	exit;
}

// Installed
if(!defined('S9YCONF_INSTALLED')) {
	// If no headers are sent, send one
	if (!headers_sent()) {
		header("Location: http://" . $_SERVER['HTTP_HOST']
			. dirname($_SERVER['PHP_SELF'])
			. "/install");
	}else{
		echo '<div class="error">ERROR!</div>';
		echo '<p>The main configuration file does NOT exist!</p>';
		echo '<p>Click ';
		html_link('./install/index.php', $text = 'here', $status = 'Install S9Y_Conf', $target = '');
		echo 'to installS9Y_Conf.</p>';
	}
	exit;
}

// Include template functions
include_once S9YCONF_INC_PATH.'templates.functions.inc.php';

debug_msg ("FILE: ".__FILE__,3);

$referrer['host'] = '';
if (isset($_SERVER['HTTP_REFERER'])) {
	$referrer = parse_url($_SERVER['HTTP_REFERER']);
}
if ($referrer['host'] != $_SERVER['SERVER_NAME']) {
	header("HTTP/1.0 403 Forbidden");
	echo "<h1>Access Forbidden!</h1>\n\nThe website you came from doesn't have permission to link to the requested object.\n\n<h2>Error 403</h2>\n\n";
	exit();
}

db_connect();

// Read blogid and tplid passed to us
if (isset($_GET['blogid'])) {
	$blogid = $_GET['blogid'];
	if (isset($_GET['tplid'])) {
		$tplid = $_GET['tplid'];
	}else{
		// Write text to standard output
		header("Content-type: text/plain");
		echo "Error in creating template\n";
	}
}else{
	// Write text to standard output
	header("Content-type: text/plain");
	echo "Error in creating template\n";
}

// Set System template variables
$NOW = date('r');
$S9YCONF = S9YCONF_PROGRAM_NAME.' v'.S9YCONF_VERSION;

// Set template variables
$templatevars = db_multirec_read_all_templatevars();


// Set specific Blog template variables
$blogdata = db_read_blogdata($blogid);
$BLOGID = $blogid;
$BLOGNAME = $blogdata['name'];
$BLOGPATH = $blogdata['blog_path'];
$BLOGUSER = $blogdata['user'];
$BLOGURL = $blogdata['url'];


// Set specific template variables
$templatedata = db_read_templates($tplid);
$TEMPLATE_ID = $templatedata['id'];
$TEMPLATE_NAME = $templatedata['name'];
$TEMPLATE_DESCRIPTION = $templatedata['description'];


// Template contents
$template_contents = html_entity_decode($templatedata['template']);

// Expand the template variables recursively
$templatevars = expand_templatevars($templatevars);

// Insert system template variables
$template_contents = str_replace('{NOW}', $NOW, $template_contents);
$template_contents = str_replace('{S9YCONF}', $S9YCONF, $template_contents);
/*
$template_contents = str_replace('{SUDO}', $SUDO, $template_contents);
$template_contents = str_replace('{LIBDIR}', $LIBDIR, $template_contents);
$template_contents = str_replace('{S9YDIR}', $S9YDIR, $template_contents);
$template_contents = str_replace('{WWWGROUP}', $WWWGROUP, $template_contents);
$template_contents = str_replace('{WWWUSER}', $WWWUSER, $template_contents);
*/
foreach ($templatevars as $tplvar) {
	$template_contents = str_replace('{'.$tplvar['name'].'}', html_entity_decode($tplvar['value']), $template_contents);
}

// Insert specific blog template variables
$template_contents = str_replace('{BLOGID}', $BLOGID, $template_contents);
$template_contents = str_replace('{BLOGNAME}', $BLOGNAME, $template_contents);
$template_contents = str_replace('{BLOGPATH}', $BLOGPATH, $template_contents);
$template_contents = str_replace('{BLOGUSER}', $BLOGUSER, $template_contents);
$template_contents = str_replace('{BLOGURL}', $BLOGURL, $template_contents);


// Insert specific template template variables
$template_contents = str_replace('{TPLID}', $TEMPLATE_ID, $template_contents);
$template_contents = str_replace('{TPLNAME}', $TEMPLATE_NAME, $template_contents);
$template_contents = str_replace('{TPLDESC}', $TEMPLATE_DESCRIPTION, $template_contents);

// Remove \r from line endings
$template_contents = str_replace("\r\n", "\n", $template_contents);

// Write text to standard output
header("Content-type: text/plain");
echo $template_contents."\n";

?>