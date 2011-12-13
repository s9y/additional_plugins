<?php
/*
dbconfig.wirite.php

Function to write database configuration file

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

function dbconfig_write() {
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

	$path_separator = '/';
	if ($dbcfg_path == '') { // If no path entered then default to ./
		$dbcfg_path = './';
		$path_separator = '';
	}
	debug_msg('dbcfg_path after checking blank: "'.$dbcfg_path.'"', 5);

	if ($dbcfg_path[0] == '/') {			// full path will start with /
		$path_modifier = '';					// so we have all the information we need
		$path_separator = '';
	}else{										// must be a relative path or below main directory
		$path_modifier = '../';				// so we need to start from the main directory
	}
	debug_msg('First 2 chars: "'.substr($dbcfg_path, 0, 2).'"', 5);
	debug_msg('First 3 chars: "'.substr($dbcfg_path, 0, 3).'"', 5);

	if ($dbcfg_path[0] == '/') {							// full path
		$final_path = $dbcfg_path;
	}elseif (substr($dbcfg_path, 0, 2) == './') {	// relative path starting with ./
		$final_path = realpath('../').$path_separator.substr($dbcfg_path, 2, strlen($dbcfg_path) - 2);
	}elseif (substr($dbcfg_path, 0, 3) == '../') {	// relative path starting with ../
		$final_path = realpath('../../').$path_separator.substr($dbcfg_path, 3, strlen($dbcfg_path) - 3);
	}else{														// must be a subdirectory of main directory
		$final_path = realpath('../').$path_separator.$dbcfg_path;
	}

	debug_msg('path_modifier: "'.$path_modifier.'"', 5);
	debug_msg('path_separator: "'.$path_separator.'"', 5);
	debug_msg('final_path: "'.$final_path.'"', 5);

	if (substr($dbcfg_path, -1) != '/') {
		$dbcfg_path = $dbcfg_path.'/';
	}
	debug_msg('Final dbcfg_path after end slash: "'.$dbcfg_path.'"', 5);

	// Location of the main configuration file
	$dbconfig_file = $final_path.'dbconfig.php';
	
	// Contents of the main configuration file
	$dbconfig_contents = "<?php
/*
dbconfig.php

Database specific configuration
*/
debug_msg (\"FILE: \".__FILE__,3);


################################################################################
#           mySQL SETTINGS                                                     #
################################################################################
define('S9YCONF_DB_HOST'      , '".$dbcfg_host."'); // MySQL server hostname
define('S9YCONF_DB_NAME'      , '".$dbcfg_name."'); // name of your database
define('S9YCONF_DB_USER'      , '".$dbcfg_user."'); // username
define('S9YCONF_DB_PWD'       , '".$dbcfg_password."'); // password

######## optional settings: ####################################################

// Leaving this empty defaults to port 3306
define('S9YCONF_DB_PORT'      , '".$dbcfg_port."');
// To use persistent connections, change this to TRUE
define('S9YCONF_DB_PERSISTENT', ";

// Set TRUE/FALSE for persistent connections
if ($dbcfg_persistent == '1') {
	$dbconfig_contents = $dbconfig_contents."FALSE";
}else{
	$dbconfig_contents = $dbconfig_contents."TRUE";
}
	$dbconfig_contents = $dbconfig_contents.");

#//in case you need a prefix in front of your tables...
define('S9YCONF_DB_PREFIX'    , '".$dbcfg_prefix."');
#
#//please enter your old prefix here. The update-script
#//going to change all your tables automatically to the
#//new prefix set above.
#define('S9YCONF_DB_PREFIX_OLD', '');
################################################################################

?>";

	debug_msg(nl2br(htmlentities($dbconfig_contents)), 5);

	// Open the file for writing
	if (!$file_handle = @fopen($dbconfig_file,'wb')) { // Failed to open the file?
		return(1);
	}

	if (fwrite($file_handle, $dbconfig_contents) === FALSE) {
		fclose($file_handle);
		return(2);
	}

	// Close the file
	fclose($file_handle);

	// File written readable?
	if (!is_readable($dbconfig_file)) {
		return(4);
	}

	return(0);
}
?>