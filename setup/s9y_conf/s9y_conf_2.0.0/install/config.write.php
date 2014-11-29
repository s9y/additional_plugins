<?php
/*
config.write.php

Functions to write main configuration file

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
debug_msg ("FILE: ".__FILE__,3);

function config_write() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	global	$dbcfg_type,
				$dbcfg_host,
				$dbcfg_name,
				$dbcfg_user,
				$dbcfg_password,
				$dbcfg_prefix,
				$dbcfg_port,
				$dbcfg_persistent,
				$dbcfg_path,
				$action;

// Location of the main configuration file
$config_file = '../config.php';

// Contents of the main configuration file
$config_contents = "<?php
/*
config.php

General Configuration
*/

// Debug level
if(!defined('S9YCONF_DEBUG_LEVEL')) define('S9YCONF_DEBUG_LEVEL', 0);

// Installed
if(!defined('S9YCONF_INSTALLED')) define('S9YCONF_INSTALLED', TRUE);

// Version
if(!defined('S9YCONF_VERSION')) define('S9YCONF_VERSION', '2.0');

// Program Name
if(!defined('S9YCONF_PROGRAM_NAME')) define('S9YCONF_PROGRAM_NAME', 'S9Y_Conf');

// path to include files
if(!defined('S9YCONF_INC_PATH')) define('S9YCONF_INC_PATH', './inc/');

// DB Type
if(!defined('S9YCONF_DBTYPE')) define('S9YCONF_DBTYPE', '".$dbcfg_type."');

// path to DB config file
if(!defined('S9YCONF_DBCFG_PATH')) define('S9YCONF_DBCFG_PATH', '".$dbcfg_path."');

// Include functions

// General Uncategorised Functions
include_once S9YCONF_INC_PATH.'functions.inc.php';

// Database Funcctions
include_once S9YCONF_INC_PATH.'db.inc.php';

// HTML Functions
include_once S9YCONF_INC_PATH.'html.functions.inc.php';

// Include DB configuration
include_once S9YCONF_DBCFG_PATH.'dbconfig.php';

debug_msg (\"FILE: \".__FILE__,3);

?>";

	debug_msg(nl2br(htmlentities($config_contents, ENT_COMPAT, LANG_CHARSET)), 5);

	// Open the file for writing
	if (!$file_handle = @fopen($config_file,'wb')) { // Failed to open the file?
		return(1);
	}

	// Write the file
	if (fwrite($file_handle, $config_contents) === FALSE) {
		fclose($file_handle);
		return(2);
	}

	// Close the file
	fclose($file_handle);

	// File written readable?
	if (!is_readable($config_file)) {
		return(4);
	}

	return(0);
}
?>