<?php
/*
mysql.function.inc.php

MySQL functions used by S9Y_Conf

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

function db_connect() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

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
} // end function db_connect()

function db_query($query, $error_expected = false, $escape_query = true) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	debug_msg ("QUERY: ".$query,5);
	debug_msg ("ERROR EXPECTED: ".$error_expected,5);
	debug_msg ("ESCAPE STRING: ".$escape_query,5);
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

function db_read_record_bynum($result = '', $record = 0) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	if ($result == '') {
		return '';
	}elseif ($record > mysql_num_rows($result) - 1) {
		return '';
	}
	if (!mysql_data_seek($result, $record)) {
		return '';
	}else{
		return mysql_fetch_assoc($result);
	}
} // end function db_read_record_bynum($result = '', $record = 0)

// +----------------------------------------------+
// ! Functions to read write and delete blog data !
// +----------------------------------------------+

function db_multirec_select_all_blogdata() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$multirec = '';
	$index = 0;

	$query = "SELECT * FROM `".S9YCONF_DB_PREFIX."blogdata` ORDER BY `uid` ASC";
	$result = db_query($query);
	debug_msg ("Query Result: $result",5);

	while($row = mysql_fetch_row($result)) {
				$multirec[$index] = $row;
				$index += 1;
	}

	return $multirec;
} //end function db_multirec_select_all_blogdata()

function db_select_all_blogdata() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$query = "SELECT * FROM `".S9YCONF_DB_PREFIX."blogdata` ORDER BY `uid` ASC";
	$result = db_query($query);
	debug_msg ("Query Result: $result",5);

	return $result;
} //end function db_select_all_blogdata()

function db_select_blogdata($uid) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$uid = mysql_real_escape_string($uid);

	$query = "SELECT * FROM `".S9YCONF_DB_PREFIX."blogdata` WHERE `uid` = '$uid'";
	$result = db_query($query);
	debug_msg ("Query Result: $result",5);

	return $result;

} //end function db_select_blogdata($uid)

function db_read_blogdata($uid) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$uid = mysql_real_escape_string($uid);

	$query = "SELECT * FROM `".S9YCONF_DB_PREFIX."blogdata` WHERE `uid` = '$uid'";
	$result = db_query($query);
	debug_msg ("Query Result: $result",5);

	return mysql_fetch_assoc($result);

} //end function db_read_blogdata($uid)

function db_multirec_read_blogdata($uid) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$multirec = '';
	$index = 0;
	
	$uid = mysql_real_escape_string($uid);

	$query = "SELECT * FROM `".S9YCONF_DB_PREFIX."blogdata` WHERE `uid` = '$uid'";
	$result = db_query($query);
	debug_msg ("Query Result: $result",5);

	while($row = mysql_fetch_assoc($result)) {
				$multirec[$index] = $row;
				$index += 1;
	}

	return $multirec;

} //end function db_multirec_read_blogdata($uid)

function db_multirec_read_all_blogdata() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$multirec = '';
	$index = 0;
	
	$query = "SELECT * FROM `".S9YCONF_DB_PREFIX."blogdata` ORDER BY `uid` ASC";
	$result = db_query($query);
	debug_msg ("Query Result: $result",5);

	while($row = mysql_fetch_assoc($result)) {
				$multirec[$index] = $row;
				$index += 1;
	}

	return $multirec;

} //end function db_multirec_read_all_blogdata()

function db_insert_blogdata($name, $blog_path, $user, $url) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$name = mysql_real_escape_string($name);
	$blog_path = mysql_real_escape_string($blog_path);
	$user = mysql_real_escape_string($user);
	$url = mysql_real_escape_string($url);

	$query = "INSERT INTO `".S9YCONF_DB_PREFIX."blogdata` (`uid`,"
										 								."`name`,"
										 								."`blog_path`,"
										 								."`user`,"
																	 	."`url`)"
											."VALUES ( NULL,"
											."'$name',"
			 								."'$blog_path',"
			 								."'$user',"
											."'$url')";
	
	$result = db_query($query);
	debug_msg ("Query Result: $result",4);

	return $result;

} //end function db_insert_blogdata($name, $blog_path, $user, $url)

function db_update_blogdata($uid, $name, $blog_path, $user, $url) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$uid = mysql_real_escape_string($uid);
	$name = mysql_real_escape_string($name);
	$blog_path = mysql_real_escape_string($blog_path);
	$user = mysql_real_escape_string($user);
	$url = mysql_real_escape_string($url);

	$query = "UPDATE `".S9YCONF_DB_PREFIX."blogdata`  SET `name` = '$name' , "
																		."`blog_path` = '$blog_path', "
																		."`user` = '$user', "
																		."`url` = '$url' "
							."WHERE `uid` = '$uid'";
	
	$result = db_query($query);
	debug_msg ("Query Result: $result",4);

	return $result;

} //end function db_update_blogdata($uid, $name, $blog_path, $user, $url)

function db_delete_blogdata($uid) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$uid = mysql_real_escape_string($uid);

	$query = "DELETE FROM `".S9YCONF_DB_PREFIX."blogdata` WHERE `uid` = '$uid'";
	$result = db_query($query);
	debug_msg ("Query Result: $result",4);

	return $result;

} //end function db_delete_blogdata($uid)


// +--------------------------------------------------+
// ! Functions to read write and delete template data !
// +--------------------------------------------------+

function db_multirec_select_all_templates() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$multirec = '';
	$index = 0;

	$query = "SELECT * FROM `".S9YCONF_DB_PREFIX."templates` ORDER BY `id` ASC";
	$result = db_query($query);
	debug_msg ("Query Result: $result",5);

	while($row = mysql_fetch_row($result)) {
				$multirec[$index] = $row;
				$index += 1;
	}

	return $multirec;
} //end function db_multirec_select_all_templates()

function db_select_all_templates() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$query = "SELECT * FROM `".S9YCONF_DB_PREFIX."templates` ORDER BY `id` ASC";
	$result = db_query($query);
	debug_msg ("Query Result: $result",5);

	return $result;
} //end function db_select_all_templates()

function db_select_templates($id) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$id = mysql_real_escape_string($id);

	$query = "SELECT * FROM `".S9YCONF_DB_PREFIX."templates` WHERE `id` = '$id'";
	$result = db_query($query);
	debug_msg ("Query Result: $result",5);

	return $result;

} //end function db_select_templates($id)

function db_read_templates($id) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$id = mysql_real_escape_string($id);

	$query = "SELECT * FROM `".S9YCONF_DB_PREFIX."templates` WHERE `id` = '$id'";
	$result = db_query($query);
	debug_msg ("Query Result: $result",5);

	return mysql_fetch_assoc($result);

} //end function db_read_templates($id)

function db_multirec_read_templates($id) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$multirec = '';
	$index = 0;
	
	$id = mysql_real_escape_string($id);

	$query = "SELECT * FROM `".S9YCONF_DB_PREFIX."templates` WHERE `id` = '$id'";
	$result = db_query($query);
	debug_msg ("Query Result: $result",5);

	while($row = mysql_fetch_assoc($result)) {
				$multirec[$index] = $row;
				$index += 1;
	}

	return $multirec;

} //end function db_multirec_read_templates($id)

function db_multirec_read_all_templates() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$multirec = '';
	$index = 0;
	
	$query = "SELECT * FROM `".S9YCONF_DB_PREFIX."templates` ORDER BY `id` ASC";
	$result = db_query($query);
	debug_msg ("Query Result: $result",5);

	while($row = mysql_fetch_assoc($result)) {
				$multirec[$index] = $row;
				$index += 1;
	}

	return $multirec;

} //end function db_multirec_read_all_templates()

function db_insert_templates($name, $description, $template) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$name = mysql_real_escape_string($name);
	$description = mysql_real_escape_string($description);
	$template = mysql_real_escape_string($template);

	$query = "INSERT INTO `".S9YCONF_DB_PREFIX."templates` (`id`,"
										 								."`name`,"
										 								."`description`,"
										 								."`template`)"
											."VALUES ( NULL,"
											."'$name',"
			 								."'$description',"
			 								."'$template')";
	
	$result = db_query($query, true);
	debug_msg ("Query Result: $result",4);

	return $result;

} //end function db_insert_templates($name, $description, $template)

function db_update_templates($id, $name, $description, $template) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$id = mysql_real_escape_string($id);
	$name = mysql_real_escape_string($name);
	$description = mysql_real_escape_string($description);
	$template = mysql_real_escape_string($template);

	$query = "UPDATE `".S9YCONF_DB_PREFIX."templates`  SET `name` = '$name' , "
																		."`description` = '$description', "
																		."`template` = '$template' "
							."WHERE `id` = '$id'";
	
	$result = db_query($query, true);
	debug_msg ("Query Result: $result",4);

	return $result;

} //end function db_update_templates($id, $name, $description, $template)

function db_delete_templates($id) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$id = mysql_real_escape_string($id);

	$query = "DELETE FROM `".S9YCONF_DB_PREFIX."templates` WHERE `id` = '$id'";
	$result = db_query($query);
	debug_msg ("Query Result: $result",4);

	return $result;

} //end function db_delete_templates($id)


// +------------------------------------------------------------+
// ! Functions to read write and delete template variables data !
// +------------------------------------------------------------+

function db_multirec_select_all_templatevars() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$multirec = '';
	$index = 0;

	$query = "SELECT * FROM `".S9YCONF_DB_PREFIX."templatevars` ORDER BY `name` ASC";
	$result = db_query($query);
	debug_msg ("Query Result: $result",5);

	while($row = mysql_fetch_row($result)) {
				$multirec[$index] = $row;
				$index += 1;
	}

	return $multirec;
} //end function db_multirec_select_all_templatevars()

function db_select_all_templatevars() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$query = "SELECT * FROM `".S9YCONF_DB_PREFIX."templatevars` ORDER BY `name` ASC";
	$result = db_query($query);
	debug_msg ("Query Result: $result",5);

	return $result;
} //end function db_select_all_templatevars()

function db_select_templatevars($id) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$id = mysql_real_escape_string($id);

	$query = "SELECT * FROM `".S9YCONF_DB_PREFIX."templatevars` WHERE `id` = '$id'";
	$result = db_query($query);
	debug_msg ("Query Result: $result",5);

	return $result;

} //end function db_select_templatevars($id)

function db_read_templatevars($id) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$id = mysql_real_escape_string($id);

	$query = "SELECT * FROM `".S9YCONF_DB_PREFIX."templatevars` WHERE `id` = '$id'";
	$result = db_query($query);
	debug_msg ("Query Result: $result",5);

	return mysql_fetch_assoc($result);

} //end function db_read_templatevars($id)

function db_multirec_read_templatevars($id) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$multirec = '';
	$index = 0;
	
	$id = mysql_real_escape_string($id);

	$query = "SELECT * FROM `".S9YCONF_DB_PREFIX."templatevars` WHERE `id` = '$id'";
	$result = db_query($query);
	debug_msg ("Query Result: $result",5);

	while($row = mysql_fetch_assoc($result)) {
				$multirec[$index] = $row;
				$index += 1;
	}

	return $multirec;

} //end function db_multirec_read_templatevars($uid)

function db_multirec_read_all_templatevars() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$multirec = '';
	$index = 0;
	
	$query = "SELECT * FROM `".S9YCONF_DB_PREFIX."templatevars` ORDER BY `name` ASC";
	$result = db_query($query);
	debug_msg ("Query Result: $result",5);

	while($row = mysql_fetch_assoc($result)) {
				$multirec[$index] = $row;
				$index += 1;
	}

	return $multirec;

} //end function db_multirec_read_all_templatevars()

function db_insert_templatevars($name, $value) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$name = mysql_real_escape_string($name);
	$value = mysql_real_escape_string($value);

	$query = "INSERT INTO `".S9YCONF_DB_PREFIX."templatevars` (`id`,"
										 								."`name`,"
										 								."`value`)"
											."VALUES ( NULL,"
											."'$name',"
			 								."'$value')";
	
	$result = db_query($query, TRUE);
	debug_msg ("Query Result: $result",4);

	return $result;

} //end function db_insert_templatevars($name, $value)

function db_update_templatevars($id, $name, $value) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$id = mysql_real_escape_string($id);
	$name = mysql_real_escape_string($name);
	$value = mysql_real_escape_string($value);

	$query = "UPDATE `".S9YCONF_DB_PREFIX."templatevars`  SET `name` = '$name' , "
																		."`value` = '$value' "
							." WHERE `id` = '$id'";
	
	$result = db_query($query, true);
	debug_msg ("Query Result: $result",4);

	return $result;

} //end function db_update_templatevars($id, $name, $value)

function db_delete_templatevars($id) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$id = mysql_real_escape_string($id);

	$query = "DELETE FROM `".S9YCONF_DB_PREFIX."templatevars` WHERE `id` = '$id'";
	$result = db_query($query);
	debug_msg ("Query Result: $result",4);

	return $result;

} //end function db_delete_templatevars($id)

?>