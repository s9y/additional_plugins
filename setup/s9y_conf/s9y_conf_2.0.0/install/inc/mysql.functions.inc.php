<?php
/*
mysql.function.inc.php

MySQL functions used by S9Y_Conf installation

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

function db_connect($error_expected = FALSE) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	debug_msg ("ERROR EXPECTED: '".$error_expected."'", 5);
	if (!$error_expected) {
		if (!defined('__GOT_MYSQL__')){
			/* connect to mySQL database */
			$cfunction = (S9YCONF_DB_PERSISTENT) ? 'mysql_pconnect' : 'mysql_connect';
			if(!function_exists($cfunction)) die('MySQL support is not available in this PHP configuration!');
			function str_is_int($str) {
				$var = intval($str);
				return ("$str" == "$var");
			}
			$mysql_port = (str_is_int(S9YCONF_DB_PORT)) ? ':'.S9YCONF_DB_PORT : '';
			$connected = @$cfunction(S9YCONF_DB_HOST.$mysql_port, S9YCONF_DB_USER, S9YCONF_DB_PWD)
			or die("unable to connect to database on '".S9YCONF_DB_HOST."' with user '".S9YCONF_DB_USER."'<br />".
				'('.mysql_errno().') '.mysql_error().'<br />'.
					"Please check your settings in dbconfig.php !<br />");
			mysql_select_db(S9YCONF_DB_NAME) or die("Please first create your database '".S9YCONF_DB_NAME."' and make sure your user has got the correct access rights on it !"); ;
	
		define('S9YCONF_MYSQL_CONNECTION',$connected);
		define('__GOT_MYSQL__', 1);
		}
		debug_msg ("S9YCONF_MYSQL_CONNECTION: ".S9YCONF_MYSQL_CONNECTION,5);
		debug_msg ("__GOT_MYSQL__: ".__GOT_MYSQL__,5);
	}else{
		if (!defined('__GOT_MYSQL__')){
			/* connect to mySQL database */
			debug_msg ("DB PERSISTENT: '".S9YCONF_DB_PERSISTENT."'", 5);
			$cfunction = (S9YCONF_DB_PERSISTENT) ? 'mysql_pconnect' : 'mysql_connect';
			debug_msg ("CFUNCTION: '".$cfunction."'", 5);
			if(!function_exists($cfunction)) die('MySQL support is not available in this PHP configuration!');
			function str_is_int($str) {
				$var = intval($str);
				return ("$str" == "$var");
			}
			debug_msg ("DB PORT: '".S9YCONF_DB_PORT."'", 5);
			$mysql_port = (str_is_int(S9YCONF_DB_PORT)) ? ':'.S9YCONF_DB_PORT : '';
			debug_msg ("MYSQL PORT: '".$mysql_port."'", 5);

			debug_msg ("DB HOST: '".S9YCONF_DB_HOST."'", 5);
			debug_msg ("DB USER: '".S9YCONF_DB_USER."'", 5);
			debug_msg ("DB PWD: '".S9YCONF_DB_PWD."'", 5);
			$connected = @$cfunction(S9YCONF_DB_HOST.$mysql_port, S9YCONF_DB_USER, S9YCONF_DB_PWD);
			debug_msg ("CONNECTED: '".$connected."'", 5);
			if (!is_resource($connected)) {
				return false;
			}

			debug_msg ("DB NAME: '".S9YCONF_DB_NAME."'", 5);
			$dbconnect = mysql_select_db(S9YCONF_DB_NAME);
			debug_msg ("DBCONNECT: '".$dbconnect."'", 5);
			if (!$dbconnect) {
				return false;
			}
	
		define('S9YCONF_MYSQL_CONNECTION',$connected);
		define('__GOT_MYSQL__', 1);
		}
		debug_msg ("S9YCONF_MYSQL_CONNECTION: ".S9YCONF_MYSQL_CONNECTION,5);
		debug_msg ("__GOT_MYSQL__: ".__GOT_MYSQL__,5);
		return true; // Return true as we have connected
	}
} // end function db_connect()

function db_query($query, $error_expected = FALSE, $escape_query = TRUE) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	if ($escape_query) {
		mysql_real_escape_string($query);
	}

	debug_msg ("S9YCONF_MYSQL_CONNECTION: ".S9YCONF_MYSQL_CONNECTION,5);
	debug_msg ("SQL QUERY: ".nl2br($query),4);

	if ($error_expected) {
		$result = mysql_query($query,S9YCONF_MYSQL_CONNECTION);
	}else{
		$result = mysql_query($query,S9YCONF_MYSQL_CONNECTION)
		or die ('ERROR: Query failed<br />'.
				'SQL: '.$query.'<br />'.
				'('.mysql_errno().') '.mysql_error().'<br />');
	}

	return $result;

} // end function db_query($query)


function db_install($created = TRUE) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	// Read SQL from file
	$query = file_get_contents ('s9y_conf_sql.tpl');

	// Replace token with value
	$query = str_replace('{DBPREFIX}', S9YCONF_DB_PREFIX, $query);

	// Split SQL file into seperate statements so we don't get a MySQL error
	$chunk = explode(";\n", $query);

	// Cycle through our SQL statements
	foreach ($chunk as $query) {
		$query = trim($query);	// Remove whitespace from start and end
		if ($query != '') {		// Ensure we don't send a blank query
			$result = db_query($query, FALSE, TRUE);
			debug_msg ("RESULT: ".$result,4);
		}
		if (!$result) {			// When there is an error
			$created = FALSE;		// Set flag
			break;					// and don't do any more queries
		}
	}

	return $created;				// Return flag; TRUE=Success, FALSE=Error
	
} // end function db_install($result = TRUE)
?>