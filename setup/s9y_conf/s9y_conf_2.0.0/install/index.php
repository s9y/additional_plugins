<?php
/*
index.php

Step by step installation

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

Step 0:	Welcome to install

Step 1:	Check read/write access to configuration file

Step 2:	Get Location for DB configuration file

Step 3:	Check read/write access to DB configuration file

Step 4:	Get DB Type, and DB Parameters

Step 5:	Check read/write access to DB

Step 6:	Review setup before commit

Step 7:	Write main configuration file and DB configuration file

Step 8:	Install DB Tables and default data

Step 9:	Check file permissions and ask user to set them to 0444

Step 10: Check site security
*/

// Setup a minimum set of constants

// Version
if(!defined('S9YCONF_VERSION')) define('S9YCONF_VERSION', '2.0');

// Program Name
if(!defined('S9YCONF_PROGRAM_NAME')) define('S9YCONF_PROGRAM_NAME', 'S9Y_Conf');

// Debug level
if(!defined('S9YCONF_DEBUG_LEVEL')) define('S9YCONF_DEBUG_LEVEL', 0);


// Include functions specific to this installation routine

// General Uncategorised Functions
include_once './inc/functions.inc.php';

// HTML Functions
include_once './inc/html.functions.inc.php';

debug_msg ("FILE: ".__FILE__, 3);

// Ensure these GLOBAL variables exist
$dbcfg_host = '';
$dbcfg_name = '';
$dbcfg_user = '';
$dbcfg_password = '';
$dbcfg_prefix = '';
$dbcfg_port = '';
$dbcfg_persistent = '';
$dbcfg_path = '';
$action = '';

read_httpvars();

debug_msg("Action: ".$action, 5);
debug_msg("DBcfg_host: ".$dbcfg_host, 5);
debug_msg("DBcfg_name: ".$dbcfg_name, 5);
debug_msg("DBcfg_user: ".$dbcfg_user, 5);
debug_msg("DBcfg_password: ".$dbcfg_password, 5);
debug_msg("DBcfg_prefix: ".$dbcfg_prefix, 5);
debug_msg("DBcfg_port: ".$dbcfg_port, 5);
debug_msg("DBcfg_persistent: ".$dbcfg_persistent, 5);
debug_msg("DBcfg_path: ".$dbcfg_path, 5);


// Determine what action to take
switch ($action) {


	case 'step1': // Step 1: Check read/write access to configuration file
		step1();
		break;

	case 'step2': // Step 2: Get location to store DB configuration
		step2();
		break;

	case 'step3': // Step 3: Check read/write access to DB configuration file
		step3();
		break;

	case 'step4': // Step 4: Get DB Type
		step4();
		break;

	case 'step5': // Step 5: Get DB Parameters
		step5();
		break;

	case 'step6': //Step 6: Check read/write access to DB
		step6();
		break;


	case 'step7': // Step 7: Review setup before commit
		step7();
		break;

	case 'step8': // Step 8: Write main configuration file and DB configuration file
		step8();
		break;

	case 'step9': // Step 9: Install DB Tables and default data
		step9();
		break;

	case 'step10': // Step 10: Check site security
		step10();
		break;

	default : // Step 0: Welcome to install
		step0();
		break;

} //end switch

exit();

// Step 0: Welcome to install
function step0() {
	debug_msg ("FUNCTION: ".__FUNCTION__, 3);

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


	// Check if the main configuration file exists and can be read
	if ((file_exists('../config.php')) && (is_readable('../config.php'))) {
		$dbcfg_path = './';
		$dbcfg_type = 'MYSQL';
		$config_contents = file('../config.php');
		foreach ($config_contents as $line_num => $line) {
			// Check for constant declaration of S9YCONF_DBCFG_TYPE
			if (strpos($line, "define('S9YCONF_DBCFG_TYPE") !== FALSE) {
				// Trim the end of the line and remove everything apart from the value we want
				$line = rtrim($line);
				$line = str_replace("if(!defined('S9YCONF_DBCFG_TYPE')) define('S9YCONF_DBCFG_TYPE', '", '', $line);
				$line = str_replace("');", '', $line);
				$dbcfg_type = $line;
				continue;
			}
			// Check for constant declaration of S9YCONF_DBCFG_PATH
			if (strpos($line, "define('S9YCONF_DBCFG_PATH") !== FALSE) {
				// Trim the end of the line and remove everything apart from the value we want
				$line = rtrim($line);
				$line = str_replace("if(!defined('S9YCONF_DBCFG_PATH')) define('S9YCONF_DBCFG_PATH', '", '', $line);
				$line = str_replace("');", '', $line);
				$dbcfg_path = $line;
				continue;
			}
		}
	}
	$final_path = calc_db_path('');
	if ((file_exists($final_path.'dbconfig.php')) && (is_readable($final_path.'dbconfig.php'))) {
		include_once($final_path.'dbconfig.php');
		$dbcfg_host = S9YCONF_DB_HOST;
		$dbcfg_name = S9YCONF_DB_NAME;
		$dbcfg_user = S9YCONF_DB_USER;
		$dbcfg_password = S9YCONF_DB_PWD;
		$dbcfg_prefix = S9YCONF_DB_PREFIX;
		$dbcfg_port = S9YCONF_DB_PORT;
		if(S9YCONF_DB_PERSISTENT) {
			$dbcfg_persistent = 1;
		}else{
			$dbcfg_persistent = 0;
		}
	}

	debug_msg('DBCFG_TYPE: "'.$dbcfg_type.'"', 5);
	debug_msg('DBCFG_PATH: "'.$dbcfg_path.'"', 5);
	debug_msg('DBCFG_HOST: "'.$dbcfg_host.'"', 5);
	debug_msg('DBCFG_NAME: "'.$dbcfg_name.'"', 5);
	debug_msg('DBCFG_USER: "'.$dbcfg_user.'"', 5);
	debug_msg('DBCFG_PASSWORD: "'.$dbcfg_password.'"', 5);
	debug_msg('DBCFG_PREFIX: "'.$dbcfg_prefix.'"', 5);
	debug_msg('DBCFG_PORT: "'.$dbcfg_port.'"', 5);
	debug_msg('DBCFG_PERSISTENT: "'.$dbcfg_persistent.'"', 5);

	steppage(0);
?>
<p><h2>Welcome to <?php echo S9YCONF_PROGRAM_NAME; ?></h2></p>
<p>This program is free software; you can redistribute it and/or modify it under the terms
of the GNU General Public License as published by the Free Software Foundation; either
version 2 of the License, or (at your option) any later version.</p>
<p>This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.</p>
<p>See the GNU General Public License for more details.</p>
<?php
display_gpl_licence();
?>
<p>If you accept this licence, and wish to continue using this application then please click 'I Agree' below.</p>
<!-- 
<p>Welcome to <?php echo S9YCONF_PROGRAM_NAME; ?> installation.</p>
<p>You can use the following steps to automate installation, providing a basic set of
data to get you started on putting <?php echo S9YCONF_PROGRAM_NAME; ?> to use.</p>
 -->
 <p><form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
<button name="action" value="step1" type="submit">I Agree</button>
<?php
	if (isset($dbcfg_type)) {
		echo '<input type="hidden" name="dbcfg_type" value="'.$dbcfg_type.'" />';
	}
	if (isset($dbcfg_host)) {
		echo '<input type="hidden" name="dbcfg_host" value="'.$dbcfg_host.'" />';
	}
	if (isset($dbcfg_name)) {
		echo '<input type="hidden" name="dbcfg_name" value="'.$dbcfg_name.'" />';
	}
	if (isset($dbcfg_user)) {
		echo '<input type="hidden" name="dbcfg_user" value="'.$dbcfg_user.'" />';
	}
	if (isset($dbcfg_password)) {
		echo '<input type="hidden" name="dbcfg_password" value="'.$dbcfg_password.'" />';
	}
	if (isset($dbcfg_prefix)) {
		echo '<input type="hidden" name="dbcfg_prefix" value="'.$dbcfg_prefix.'" />';
	}
	if (isset($dbcfg_port)) {
		echo '<input type="hidden" name="dbcfg_port" value="'.$dbcfg_port.'" />';
	}
	if (isset($dbcfg_persistent)) {
		echo '<input type="hidden" name="dbcfg_persistent" value="'.$dbcfg_persistent.'" />';
	}
	if (isset($dbcfg_path)) {
		echo '<input type="hidden" name="dbcfg_path" value="'.$dbcfg_path.'" />';
	}
?>
</form></p>
</td>
</tr>
</table>
</div>
<?php
	html_footer();

} // end function step0()


// Step 1: Check read/write access to configuration file
function step1() {
	debug_msg ("FUNCTION: ".__FUNCTION__, 3);

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

	steppage(1);

	echo '<p>';

	// Look for main configuration file and check if it can be written
	if (file_exists('../config.php')) { // Check if the main configuration file exists
		if ((is_readable('../config.php')) && (is_writable('../config.php'))) { // and readable and writeable
			$config_contents = file('../config.php');
			foreach ($config_contents as $line_num => $line) {
				// Check for constant declaration of S9YCONF_DBCFG_TYPE
				if (strpos($line, "define('S9YCONF_DBCFG_TYPE") !== FALSE) {
					// Trim the end of the line and remove everything apart from the value we want
					$line = rtrim($line);
					$line = str_replace("if(!defined('S9YCONF_DBCFG_TYPE')) define('S9YCONF_DBCFG_TYPE', '", '', $line);
					$line = str_replace("');", '', $line);
					$dbcfg_type = $line;
				}
				// Check for constant declaration of S9YCONF_DBCFG_PATH
				if (strpos($line, "define('S9YCONF_DBCFG_PATH") !== FALSE) {
					// Trim the end of the line and remove everything apart from the value we want
					$line = rtrim($line);
					$line = str_replace("if(!defined('S9YCONF_DBCFG_PATH')) define('S9YCONF_DBCFG_PATH', '", '', $line);
					$line = str_replace("');", '', $line);
					$dbcfg_path = $line;
				}
			}
			echo '<div class="ok">Excellent</div><br />';
			echo 'The main configuration exists and is readable and writeable.<br />';
			$continue = true;
		}elseif ((is_readable('../config.php')) && (!is_writable('../config.php'))) { // Readable but NOT writeable
			echo '<div class="error">ERROR!</div><br />';
			echo 'The main configuration file exists but is NOT writeable!<br />';
			echo '<br />';
			echo 'Please make the main configuration file readable and writeable by the webserver.<br />';
			echo '<br />';
			echo 'You may do this using:<br />';
			echo '<pre>#: chmod 0666 '.realpath('../').'/config.php</pre><br />';
			$continue = false;
		}elseif ((!is_readable('../config.php')) && (is_writable('../config.php'))) { // NOT Readable but writeable
			echo '<div class="error">ERROR!</div><br />';
			echo 'The main configuration file exists but is NOT readable!<br />';
			echo '<br />';
			echo 'Please make the database configuration file readable and writeable by the webserver.<br />';
			echo '<br />';
			echo 'You may do this using:<br />';
			echo '<pre>#: chmod 0666 '.realpath('../').'/config.php</pre><br />';
			$continue = false;
		}else{ // NOT readable and NOT writeable
			echo '<div class="error">ERROR!</div><br />';
			echo 'The main configuration file exists but is NOT readable or writeable!<br />';
			echo '<br />';
			echo 'Please make the main configuration file readable and writeable by the webserver.<br />';
			echo '<br />';
			echo 'You may do this using:<br />';
			echo '<pre>#: chmod 0666 '.realpath('../').'/config.php</pre><br />';
			$continue = false;
		}
	}else{										// When the config.php doesn't exist
		if ((is_readable('../')) && (is_writable('../'))) { // is the directory readable and writeable
			echo '<div class="ok">Excellent</div><br /><br />';
			echo 'The main configuration file does NOT exist, but the '.S9YCONF_PROGRAM_NAME.' directory is readable and writable<br />';
			$continue = true;
		}elseif ((is_readable('../')) && (!is_writable('../'))) { // Readable but NOT writeable
			echo '<div class="error">ERROR!</div><br />';
			echo 'The main configuration file does NOT exist and the directory is NOT writeable!<br />';
			echo '<br />';
			echo 'Please make your '.S9YCONF_PROGRAM_NAME.' directory readable and writeable by the webserver.<br />';
			echo '<br />';
			echo 'You may do this using:<br />';
			echo '<pre>#: chmod 0777 '.realpath('../').'</pre><br />';
			$continue = false;
		}elseif ((!is_readable('../')) && (is_writable('../'))) { // NOT Readable but writeable
			echo '<div class="error">ERROR!</div><br />';
			echo 'The main configuration file does NOT exist and the directory is NOT readable!<br />';
			echo '<br />';
			echo 'Please make your '.S9YCONF_PROGRAM_NAME.' directory readable and writeable by the webserver.<br />';
			echo '<br />';
			echo 'You may do this using:<br />';
			echo '<pre>#: chmod 0777 '.realpath('../').'</pre><br />';
			$continue = false;
		}else{ // NOT readable and NOT writeable
			echo '<div class="error">ERROR!</div><br />';
			echo 'The main configuration file does NOT exist and the '.S9YCONF_PROGRAM_NAME.' directory is NOT readable!<br />';
			echo '<br />';
			echo 'Please make your '.S9YCONF_PROGRAM_NAME.' directory readable and writeable by the webserver.<br />';
			echo '<br />';
			echo 'You may do this using:<br />';
			echo '<pre>#: chmod 0777 '.realpath('../').'</pre><br />';
			$continue = false;
		}
	}
?>
<br />
<p><form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
<?php
	if ($continue) {
		echo '<button name="action" value="step2" type="submit">Continue to Step 2</button>';
	}else{
		echo '<button name="action" value="step1" type="submit">Re-Check</button>';
	}
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<button name="action" value="step0" type="submit">Back</button>';

	if (isset($dbcfg_type)) {
		echo '<input type="hidden" name="dbcfg_type" value="'.$dbcfg_type.'" />';
	}
	if (isset($dbcfg_host)) {
		echo '<input type="hidden" name="dbcfg_host" value="'.$dbcfg_host.'" />';
	}
	if (isset($dbcfg_name)) {
		echo '<input type="hidden" name="dbcfg_name" value="'.$dbcfg_name.'" />';
	}
	if (isset($dbcfg_user)) {
		echo '<input type="hidden" name="dbcfg_user" value="'.$dbcfg_user.'" />';
	}
	if (isset($dbcfg_password)) {
		echo '<input type="hidden" name="dbcfg_password" value="'.$dbcfg_password.'" />';
	}
	if (isset($dbcfg_prefix)) {
		echo '<input type="hidden" name="dbcfg_prefix" value="'.$dbcfg_prefix.'" />';
	}
	if (isset($dbcfg_port)) {
		echo '<input type="hidden" name="dbcfg_port" value="'.$dbcfg_port.'" />';
	}
	if (isset($dbcfg_persistent)) {
		echo '<input type="hidden" name="dbcfg_persistent" value="'.$dbcfg_persistent.'" />';
	}
	if (isset($dbcfg_path)) {
		echo '<input type="hidden" name="dbcfg_path" value="'.$dbcfg_path.'" />';
	}
?>
</form></p>
</td>
</tr>
</table>
</div>
<?php
	html_footer();

} // end function step1()


// Step 2: Get Location for DB configuration file
function step2() {
	debug_msg ("FUNCTION: ".__FUNCTION__, 3);

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


	steppage(2);
?>
<p>
<?php
?>
<p><form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
<p>Please enter the path to the location that will be used to store the Data
Base Configuration file.</p>
<p><input type="text" name="dbcfg_path" value="<?php echo $dbcfg_path; ?>" size="30" maxlength="255" /></p>
<p>The default &apos;./&apos; will place the database configuration file in the
<?php echo S9YCONF_PROGRAM_NAME; ?> directory.</p>
<em>This may be a relative path from the <?php echo S9YCONF_PROGRAM_NAME; ?> directory<br />
e.g. &apos;../../php_mysql_includes/&apos;, or &apos;./&apos; to store it in the <?php echo S9YCONF_PROGRAM_NAME; ?> directory</em>.<br /><br />
<button name="action" value="step3" type="submit">Continue to Step 3</button>
&nbsp;&nbsp;&nbsp;&nbsp;
<button name="Reset" type="reset">Reset</button>
&nbsp;&nbsp;&nbsp;&nbsp;
<button name="action" value="step1" type="submit">Back</button>
<?php
	if (isset($dbcfg_type)) {
		echo '<input type="hidden" name="dbcfg_type" value="'.$dbcfg_type.'" />';
	}
	if (isset($dbcfg_host)) {
		echo '<input type="hidden" name="dbcfg_host" value="'.$dbcfg_host.'" />';
	}
	if (isset($dbcfg_name)) {
		echo '<input type="hidden" name="dbcfg_name" value="'.$dbcfg_name.'" />';
	}
	if (isset($dbcfg_user)) {
		echo '<input type="hidden" name="dbcfg_user" value="'.$dbcfg_user.'" />';
	}
	if (isset($dbcfg_password)) {
		echo '<input type="hidden" name="dbcfg_password" value="'.$dbcfg_password.'" />';
	}
	if (isset($dbcfg_prefix)) {
		echo '<input type="hidden" name="dbcfg_prefix" value="'.$dbcfg_prefix.'" />';
	}
	if (isset($dbcfg_port)) {
		echo '<input type="hidden" name="dbcfg_port" value="'.$dbcfg_port.'" />';
	}
	if (isset($dbcfg_persistent)) {
		echo '<input type="hidden" name="dbcfg_persistent" value="'.$dbcfg_persistent.'" />';
	}
?>
</form></p>
</td>
</tr>
</table>
</div>
<?php
	html_footer();

} // end function step2()


// Step 3: Check read/write access to DB configuration file
function step3() {
	debug_msg ("FUNCTION: ".__FUNCTION__, 3);

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

	$final_path = calc_db_path('');

	steppage(3);
?>
<p>
<?php
	if (file_exists($final_path.'dbconfig.php')) { // Check if the database configuration file exists
		if ((is_readable($final_path.'dbconfig.php')) && (is_writable($final_path.'dbconfig.php'))) { // readable and writeable
			echo '<div class="ok">Excellent</div><br />';
			echo 'The database configuration exists and is readable and writeable.<br />';
			include_once($final_path.'dbconfig.php');
			$dbcfg_host = S9YCONF_DB_HOST;
			$dbcfg_name = S9YCONF_DB_NAME;
			$dbcfg_user = S9YCONF_DB_USER;
			$dbcfg_password = S9YCONF_DB_PWD;
			$dbcfg_prefix = S9YCONF_DB_PREFIX;
			$dbcfg_port = S9YCONF_DB_PORT;
			if(defined('S9YCONF_DB_PERSISTENT')) {
				$dbcfg_persistent = 1;
			}else{
				$dbcfg_persistent = 0;
			}
			$continue = true;
		}elseif ((is_readable($final_path.'dbconfig.php')) && (!is_writable($final_path.'dbconfig.php'))) { // Readable but NOT writeable
			echo '<div class="error">ERROR!</div><br />';
			echo 'The database configuration file exists but is NOT writeable!<br />';
			echo '<br />';
			echo 'Please make the database configuration file readable and writeable by the webserver.<br />';
			echo '<br />';
			echo 'You may do this using:<br />';
			echo '<pre>#: chmod 0666 '.$final_path.'dbconfig.php</pre><br />';
		}elseif ((!is_readable($final_path.'dbconfig.php')) && (is_writable($final_path.'dbconfig.php'))) { // NOT readable but writeable
			echo '<div class="error">ERROR!</div><br />';
			echo 'The database configuration file exists but is NOT readable!<br />';
			echo '<br />';
			echo 'Please make the database configuration file readable and writeable by the webserver.<br />';
			echo '<br />';
			echo 'You may do this using:<br />';
			echo '<pre>#: chmod 0666 '.$final_path.'dbconfig.php</pre><br />';
			$continue = false;
		}elseif (is_writable($final_path.'dbconfig.php')) { // Writeable?
			echo '<div class="error">ERROR!</div><br />';
			echo 'The database configuration file exists but is NOT readable!<br />';
			echo '<br />';
			echo 'Please make the database configuration file readable and writeable by the webserver.<br />';
			echo '<br />';
			echo 'You may do this using:<br />';
			echo '<pre>#: chmod 0666 '.$final_path.'dbconfig.php</pre><br />';
			$continue = false;
		}else{ // NOT readable and NOT writeable
			echo '<div class="error">ERROR!</div><br />';
			echo 'The database configuration file exists but is NOT readable or writeable!<br />';
			echo '<br />';
			echo 'Please make the database configuration file readable and writeable by the webserver.<br />';
			echo '<br />';
			echo 'You may do this using:<br />';
			echo '<pre>#: chmod 0666 '.$final_path.'dbconfig.php</pre><br />';
			$continue = false;
		}
	}else{										// When the dbconfig.php doesn't exist
		if (!is_dir($final_path)) { // Does path exist?
			echo '<div class="error">ERROR!</div><br />';
			echo 'The directory does NOT exist!<br />';
			echo '<br />';
			echo 'Please create the directory<pre>'.$final_path.'</pre>';
			echo 'You may do this using:';
			echo '<pre>#: mkdir -m 0777 '.$final_path.'</pre>';
			$continue = false;
		}elseif ((is_readable($final_path)) && (is_writable($final_path))) { // is the directory readable and writeable
			echo '<div class="ok">Excellent</div><br />';
			echo 'The Data Base Configuration file can be written to and read from the directory:<pre>'.$final_path.'</pre>';
			$continue = true;
		}elseif (( is_readable($final_path)) && (!is_writable($final_path))) { // Readable but NOT writeable
			echo '<div class="error">ERROR!</div><br />';
			echo 'The Data Base Configuration file can NOT be written as the webserver does NOT have write access to the directory:<pre>'.$final_path.'</pre>';
			echo 'Please make the directory readable and writeable by the webserver.<br />';
			echo '<br />';
			echo 'You may do this using:';
			echo '<pre>#: chmod 0777 '.$final_path.'</pre>';
			$continue = false;
		}elseif ((!is_readable($final_path)) && (is_writable($final_path))) { // NOT Readable but writeable
			echo '<div class="error">ERROR!</div><br />';
			echo 'The Data Base Configuration file can NOT be read as the webserver does NOT have read access to the directory:<pre>'.$final_path.'</pre>';
			echo 'Please make the directory readable and writeable by the webserver.<br />';
			echo '<br />';
			echo 'You may do this using:';
			echo '<pre>#: chmod 0777 '.$final_path.'</pre>';
			$continue = false;
		}else{ // NOT readable and NOT writeable
			echo '<div class="error">ERROR!</div><br />';
			echo 'The Data Base Configuration file can NOT be read as the webserver does NOT have read access to the directory:<pre>'.$final_path.'</pre>';
			echo 'Please make the directory readable and writeable by the webserver.<br />';
			echo '<br />';
			echo 'You may do this using:';
			echo '<pre>#: chmod 0777 '.$final_path.'</pre>';
			$continue = false;
		}
	}

?>
<br />
<p><form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
<?php
	if ($continue) {
		echo '<button name="action" value="step4" type="submit">Continue to Step 4</button>';
	}else{
		echo '<button name="action" value="step3" type="submit">Re-Check</button>';
	}
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<button name="action" value="step2" type="submit">Back</button>';
?>
<?php
	if (isset($dbcfg_host)) {
		echo '<input type="hidden" name="dbcfg_host" value="'.$dbcfg_host.'" />';
	}
	if (isset($dbcfg_name)) {
		echo '<input type="hidden" name="dbcfg_name" value="'.$dbcfg_name.'" />';
	}
	if (isset($dbcfg_user)) {
		echo '<input type="hidden" name="dbcfg_user" value="'.$dbcfg_user.'" />';
	}
	if (isset($dbcfg_password)) {
		echo '<input type="hidden" name="dbcfg_password" value="'.$dbcfg_password.'" />';
	}
	if (isset($dbcfg_prefix)) {
		echo '<input type="hidden" name="dbcfg_prefix" value="'.$dbcfg_prefix.'" />';
	}
	if (isset($dbcfg_port)) {
		echo '<input type="hidden" name="dbcfg_port" value="'.$dbcfg_port.'" />';
	}
	if (isset($dbcfg_persistent)) {
		echo '<input type="hidden" name="dbcfg_persistent" value="'.$dbcfg_persistent.'" />';
	}
	if (isset($dbcfg_path)) {
		echo '<input type="hidden" name="dbcfg_path" value="'.$dbcfg_path.'" />';
	}
?>
</form></p>
</td>
</tr>
</table>
</div>
<?php
	html_footer();

} // end function step3()


// Step 4: Get DB Type, and DB Parameters
function step4() {
	debug_msg ("FUNCTION: ".__FUNCTION__, 3);

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


	steppage(4);
?>
<p><form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
<br />
Please enter the Data Base Configuration.<br /><br />
<table>
<tr>
<td class="topright">
Database host:
</td>
<td class="topleft">
<input type="text" name="dbcfg_host" value="<?php echo $dbcfg_host; ?>" size="30" maxlength="255" />
</td>
</tr>
<tr>
<td class="topright">
Database name:
</td>
<td class="topleft">
<input type="text" name="dbcfg_name" value="<?php echo $dbcfg_name; ?>" size="30" maxlength="255" />
</td>
</tr>
<tr>
<td class="topright">
Database user:
</td>
<td class="topleft">
<input type="text" name="dbcfg_user" value="<?php echo $dbcfg_user; ?>" size="30" maxlength="255" /><br />
</td>
</tr>
<tr>
<td class="topright">
Database password:
</td>
<td class="topleft">
<input type="password" name="dbcfg_password" value="<?php echo $dbcfg_password; ?>" size="30" maxlength="255" /><br />
</td>
</tr>
<tr>
<td class="topright">
Database table prefix:
</td>
<td class="topleft">
<input type="text" name="dbcfg_prefix" value="<?php echo $dbcfg_prefix; ?>" size="30" maxlength="255" /><br />
</td>
</tr>
<?php
/*
<tr>
<td class="topright">
Database port:
</td>
<td class="topleft">
<input type="text" name="dbcfg_port" value="<?php echo $dbcfg_port; ?>" size="5" maxlength="5" />
<em>(blank = 3306)</em><br />
</td>
</tr>
<tr>
<td class="topright">
Use persistent connections:
</td>
<td class="topleft">
<input type="radio" name="dbcfg_persistent" value="0" <?php if ($dbcfg_persistent == 1) { echo 'checked="checked"'; } ?> />Yes
<input type="radio" name="dbcfg_persistent" value="1" <?php if ($dbcfg_persistent == 0) { echo 'checked="checked"'; } ?> />No<br /><br />
</td>
</tr>
*/
?>
</table>
<p><button name="action" value="step5" type="submit">Continue to Step 5</button>
&nbsp;&nbsp;&nbsp;&nbsp;
<button name="Reset" type="reset">Reset</button>
&nbsp;&nbsp;&nbsp;&nbsp;
<button name="action" value="step3" type="submit">Back</button>
</p>
<?php
	if (isset($dbcfg_path)) {
		echo '<input type="hidden" name="dbcfg_path" value="'.$dbcfg_path.'" />';
	}
?>
</form></p>
</td>
</tr>
</table>
</div>
<?php
	html_footer();

} // end function step4()


// Step 5: Check read/write access to DB
function step5() {
	debug_msg ("FUNCTION: ".__FUNCTION__, 3);

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

	steppage(5);

	echo '<p>';

	// Include mysql functions
	if ($dbcfg_type  == 'MYSQL') {
		include_once './inc/mysql.functions.inc.php';

		// Set constants required for db_connect

		// DB Host
		define('S9YCONF_DB_HOST'      , $dbcfg_host);

		// DB Name
		define('S9YCONF_DB_NAME'      , $dbcfg_name);

		// DB User
		define('S9YCONF_DB_USER'      , $dbcfg_user);

		// DB Password
		define('S9YCONF_DB_PWD'      , $dbcfg_password);

		// If this is empty the default is port 3306 for MySQL
		define('S9YCONF_DB_PORT'      , $dbcfg_port);

		// For persistent connections, dbcfg_persistent is TRUE
		if ($dbcfg_persistent == 1) {
			define('S9YCONF_DB_PERSISTENT', TRUE);
		}else{
			define('S9YCONF_DB_PERSISTENT', FALSE);
		}

		// Check database connectivity
		$continue = db_connect(true); // Must not die if there is an error!

		// Connected OK?
		if ($continue) { // Connection successful
			echo '<div class="ok">Excellent</div><br />';
			echo 'The database exists and we can conect to it.<br />';
			$continue = true;
		}else{ // Connection failed
			echo '<div class="error">ERROR!</div><br />';
			echo "Can NOT connect to the database!<br />";
			echo '<br />';
			echo 'MySQL returned the error:<br />';
			echo '<pre>('.mysql_errno().') '.mysql_error().'</pre><br />';
			echo '<table>';
			echo '<tr><td class="topright">Database Host:</td><td class="topleft">'.S9YCONF_DB_HOST.'</td></tr>';
			echo '<tr><td class="topright">Database Name:</td><td class="topleft">'.S9YCONF_DB_NAME.'</td></tr>';
			echo '<tr><td class="topright">Database User:</td><td class="topleft">'.S9YCONF_DB_USER.'</td></tr>';
			echo '<tr><td class="topright">Database Password:</td><td class="topleft">'.str_repeat('*',strlen(S9YCONF_DB_PWD)).'</td></tr>';
			echo '</tr></table>';
			$continue = false;
		}
	}
?>
<br />
<p><form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
<?php
	if ($continue) {
		echo '<button name="action" value="step6" type="submit">Continue to Step 6</button>';
	}else{
		echo '<button name="action" value="step5" type="submit">Re-Check</button>';
	}
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<button name="action" value="step4" type="submit">Back</button>';

	if (isset($dbcfg_type)) {
		echo '<input type="hidden" name="dbcfg_type" value="'.$dbcfg_type.'" />';
	}
	if (isset($dbcfg_host)) {
		echo '<input type="hidden" name="dbcfg_host" value="'.$dbcfg_host.'" />';
	}
	if (isset($dbcfg_name)) {
		echo '<input type="hidden" name="dbcfg_name" value="'.$dbcfg_name.'" />';
	}
	if (isset($dbcfg_user)) {
		echo '<input type="hidden" name="dbcfg_user" value="'.$dbcfg_user.'" />';
	}
	if (isset($dbcfg_password)) {
		echo '<input type="hidden" name="dbcfg_password" value="'.$dbcfg_password.'" />';
	}
	if (isset($dbcfg_prefix)) {
		echo '<input type="hidden" name="dbcfg_prefix" value="'.$dbcfg_prefix.'" />';
	}
	if (isset($dbcfg_port)) {
		echo '<input type="hidden" name="dbcfg_port" value="'.$dbcfg_port.'" />';
	}
	if (isset($dbcfg_persistent)) {
		echo '<input type="hidden" name="dbcfg_persistent" value="'.$dbcfg_persistent.'" />';
	}
	if (isset($dbcfg_path)) {
		echo '<input type="hidden" name="dbcfg_path" value="'.$dbcfg_path.'" />';
	}
?>
</form></p>
</td>
</tr>
</table>
</div>
<?php
	html_footer();

} // end function step5()


// Step 6: Review setup before commit
function step6() {
	debug_msg ("FUNCTION: ".__FUNCTION__, 3);

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


	$final_path = calc_db_path('');

	steppage(6);
?>
The main configuration file will be written to<pre>
<?php echo realpath('../').'/config.php'; ?>
</pre>
The database configuration file will be written to<pre>
<?php echo $final_path.'dbconfig.php'; ?>
</pre>
The database parameters are:<br />
<table>
<tr>
<td class="topright">Database host:</td>
<td class="topleft"><i><?php echo $dbcfg_host; ?></i></td>
</tr>
<tr>
<td class="topright">Database name:</td>
<td class="topleft"><i><?php echo $dbcfg_name; ?></i></td>
</tr>
<tr>
<td class="topright">Database user:</td>
<td class="topleft"><i><?php echo $dbcfg_user; ?></i></td>
</tr>
<tr>
<td class="topright">
Database password:
</td>
<td class="topleft"><i><?php echo str_repeat ( "*", strlen($dbcfg_password)); ?></i></td>
</tr>
<tr>
<td class="topright">Database table prefix:</td>
<td class="topleft"><i><?php echo $dbcfg_prefix; ?></i></td>
</tr>
<?php
/*
<tr>
<td class="topright">Database port:</td>
<td class="topleft"><i><?php echo $dbcfg_port; ?></i><em>(blank = 3306)</em></td>
</tr>
<tr>
<td class="topright">Use persistent connections:</td>
<td class="topleft">
<i>
<?php if ($dbcfg_persistent == 1) { echo 'Yes"'; } ?>
<?php if ($dbcfg_persistent == 0) { echo 'No'; } ?>
</i>
</td>
</tr>
*/
?>
</table>
<p><form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
<p><button name="action" value="step7" type="submit">Continue to Step 7</button>
&nbsp;&nbsp;&nbsp;&nbsp;
<button name="action" value="step5" type="submit">Back</button>
</p>
<?php
	if (isset($dbcfg_type)) {
		echo '<input type="hidden" name="dbcfg_type" value="'.$dbcfg_type.'" />';
	}
	if (isset($dbcfg_host)) {
		echo '<input type="hidden" name="dbcfg_host" value="'.$dbcfg_host.'" />';
	}
	if (isset($dbcfg_name)) {
		echo '<input type="hidden" name="dbcfg_name" value="'.$dbcfg_name.'" />';
	}
	if (isset($dbcfg_user)) {
		echo '<input type="hidden" name="dbcfg_user" value="'.$dbcfg_user.'" />';
	}
	if (isset($dbcfg_password)) {
		echo '<input type="hidden" name="dbcfg_password" value="'.$dbcfg_password.'" />';
	}
	if (isset($dbcfg_prefix)) {
		echo '<input type="hidden" name="dbcfg_prefix" value="'.$dbcfg_prefix.'" />';
	}
	if (isset($dbcfg_port)) {
		echo '<input type="hidden" name="dbcfg_port" value="'.$dbcfg_port.'" />';
	}
	if (isset($dbcfg_persistent)) {
		echo '<input type="hidden" name="dbcfg_persistent" value="'.$dbcfg_persistent.'" />';
	}
	if (isset($dbcfg_path)) {
		echo '<input type="hidden" name="dbcfg_path" value="'.$dbcfg_path.'" />';
	}
?>
</form></p>
<?php
	html_footer();

} // end function step6()


// Step 7:	Write main configuration file and DB configuration file
function step7() {
	debug_msg ("FUNCTION: ".__FUNCTION__, 3);

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

	$final_path = calc_db_path('');

	steppage(7);

	include_once('./config.write.php');
	$config_result = config_write();

	debug_msg('CONFIG RESULT:'.$config_result, 5);
	switch ($config_result) {

		case '0': // Write to main configuration file succeeded
			echo '<div class="ok">Excellent</div>';
			echo '<p>The main configuration file has been written.</p>';
			break;

		case '1': // Unable to open main configuration file
			echo '<div class="error">ERROR!</div>';
			echo '<p>Unable to write to the main configuration file!</p>';
			echo 'Please make the main configuration file readable and writeable by the webserver.<br />';
			echo '<br />';
			echo 'You may do this using:<br />';
			echo '<pre>#: chmod 0666 '.realpath('../').'/config.php</pre>together with<pre>#: chmod 0777 '.realpath('../').'</pre>Which will ensure that the file WILL be readable and writeable by the webserver.<br /><br />';
			break;

		case '2': // Write to main configuration file failed
			echo '<div class="error">ERROR!</div>';
			echo '<p>Unable to write to the main configuration file!</p>';
			echo 'Please make the main configuration file readable and writeable by the webserver.<br />';
			echo '<br />';
			echo 'You may do this using:<br />';
			echo '<pre>#: chmod 0666 '.realpath('../').'/config.php</pre>together with<pre>#: chmod 0777 '.realpath('../').'</pre>Which will ensure that the file WILL be readable and writeable by the webserver.<br /><br />';
			break;

		case '4': // Main configuration file created NOT readable
			echo '<div class="error">ERROR!</div>';
			echo '<p>The main configuration file has been written, BUT it cannot be read by the webserver!</p>';
			echo 'Please make the main configuration file readable and writeable by the webserver.<br />';
			echo '<br />';
			echo 'You may do this using:<br />';
			echo '<pre>#: chmod 0666 '.realpath('../').'/config.php</pre>';
			break;

	}

	include_once('./dbconfig.write.php');
	$dbconfig_result = dbconfig_write();

	debug_msg('DBCONFIG RESULT:'.$dbconfig_result, 5);
	switch ($dbconfig_result) {

		case '0': // Write to main configuration file succeeded
			echo '<div class="ok">Excellent</div>';
			echo '<p>The database configuration file has been written.</p>';
			break;

		case '1': // Unable to open main configuration file
			echo '<div class="error">ERROR!</div>';
			echo '<p>Unable to write to the database configuration file!</p>';
			echo 'Please make the database configuration file readable and writeable by the webserver.<br />';
			echo '<br />';
			echo 'You may do this using:<br />';
			echo '<pre>#: chmod 0666 '.$final_path.'dbconfig.php</pre>together with<pre>#: mkdir -m 0777 '.$final_path.'</pre>Which will ensure that the file WILL be readable and writeable by the webserver.';
			break;

		case '2': // Write to main configuration file failed
			echo '<div class="error">ERROR!</div>';
			echo '<p>Unable to write to the database configuration file!</p>';
			echo 'Please make the database configuration file readable and writeable by the webserver.<br />';
			echo '<br />';
			echo 'You may do this using:<br />';
			echo '<pre>#: chmod 0666 '.$final_path.'dbconfig.php</pre>together with<pre>#: mkdir -m 0777 '.$final_path.'</pre>Which will ensure that the file WILL be readable and writeable by the webserver.';
			break;

		case '4': // Database configuration file created NOT readable
			echo '<div class="error">ERROR!</div>';
			echo '<p>The database configuration file has been written, BUT it cannot be read by the webserver!</p>';
			echo 'Please make the database configuration file readable and writeable by the webserver.<br />';
			echo '<br />';
			echo 'You may do this using:<br />';
			echo '<pre>#: chmod 0666 '.$final_path.'dbconfig.php</pre>together with<pre>#: mkdir -m 0777 '.$final_path.'</pre>Which will ensure that the file WILL be readable and writeable by the webserver.';
			break;

	}

	if (($dbconfig_result != 0) || ($dbconfig_result != 0)) {
		$continue = FALSE;
	}else{
		$continue = TRUE;
	}
?>
<p><form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
<p>
<?php
	if ($continue) {
		echo '<button name="action" value="step8" type="submit">Continue to Step 8</button>';
	}else{
		echo '<button name="action" value="step7" type="submit">Re-Check</button>';
	}
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<button name="action" value="step6" type="submit">Back</button></p>';

	if (isset($dbcfg_type)) {
		echo '<input type="hidden" name="dbcfg_type" value="'.$dbcfg_type.'" />';
	}
	if (isset($dbcfg_host)) {
		echo '<input type="hidden" name="dbcfg_host" value="'.$dbcfg_host.'" />';
	}
	if (isset($dbcfg_name)) {
		echo '<input type="hidden" name="dbcfg_name" value="'.$dbcfg_name.'" />';
	}
	if (isset($dbcfg_user)) {
		echo '<input type="hidden" name="dbcfg_user" value="'.$dbcfg_user.'" />';
	}
	if (isset($dbcfg_password)) {
		echo '<input type="hidden" name="dbcfg_password" value="'.$dbcfg_password.'" />';
	}
	if (isset($dbcfg_prefix)) {
		echo '<input type="hidden" name="dbcfg_prefix" value="'.$dbcfg_prefix.'" />';
	}
	if (isset($dbcfg_port)) {
		echo '<input type="hidden" name="dbcfg_port" value="'.$dbcfg_port.'" />';
	}
	if (isset($dbcfg_persistent)) {
		echo '<input type="hidden" name="dbcfg_persistent" value="'.$dbcfg_persistent.'" />';
	}
	if (isset($dbcfg_path)) {
		echo '<input type="hidden" name="dbcfg_path" value="'.$dbcfg_path.'" />';
	}
?>
</form></p>
<?php
	html_footer();

} // end function step7()


// Step 8:	Install DB Tables and default data
function step8() {
	debug_msg ("FUNCTION: ".__FUNCTION__, 3);

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

	$final_path = calc_db_path('');

	if(!defined('S9YCONF_DBCFG_PATH')) define('S9YCONF_DBCFG_PATH', $final_path);
//	include_once $final_path.'dbconfig.php';
	include_once '../config.php';

	steppage(8);
?>
<p>Do you really want to install the database tables for <?php echo S9YCONF_PROGRAM_NAME; ?> ?</p>
<p>Installing will overwrite any existing tables with the same names in your database !</p>
<p><form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
<button name="action" value="step9" type="submit">Continue to Step 9</button>
<?php
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<button name="action" value="step7" type="submit">Back</button></p>';

	if (isset($dbcfg_type)) {
		echo '<input type="hidden" name="dbcfg_type" value="'.$dbcfg_type.'" />';
	}
	if (isset($dbcfg_host)) {
		echo '<input type="hidden" name="dbcfg_host" value="'.$dbcfg_host.'" />';
	}
	if (isset($dbcfg_name)) {
		echo '<input type="hidden" name="dbcfg_name" value="'.$dbcfg_name.'" />';
	}
	if (isset($dbcfg_user)) {
		echo '<input type="hidden" name="dbcfg_user" value="'.$dbcfg_user.'" />';
	}
	if (isset($dbcfg_password)) {
		echo '<input type="hidden" name="dbcfg_password" value="'.$dbcfg_password.'" />';
	}
	if (isset($dbcfg_prefix)) {
		echo '<input type="hidden" name="dbcfg_prefix" value="'.$dbcfg_prefix.'" />';
	}
	if (isset($dbcfg_port)) {
		echo '<input type="hidden" name="dbcfg_port" value="'.$dbcfg_port.'" />';
	}
	if (isset($dbcfg_persistent)) {
		echo '<input type="hidden" name="dbcfg_persistent" value="'.$dbcfg_persistent.'" />';
	}
	if (isset($dbcfg_path)) {
		echo '<input type="hidden" name="dbcfg_path" value="'.$dbcfg_path.'" />';
	}
?>
</form></p>
<?php
	html_footer();
} // end function step8()


function step9() {
	debug_msg ("FUNCTION: ".__FUNCTION__, 3);

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

	$final_path = calc_db_path('');

	if(!defined('S9YCONF_DBCFG_PATH')) define('S9YCONF_DBCFG_PATH', $final_path);
//	include_once $final_path.'dbconfig.php';
	include_once '../config.php';

	steppage(9);

	db_connect();

	$dbcreated = db_install();

	$continue = true; // ReSet continue flag
	
	if (!$dbcreated) {
		echo '<div class="error">ERROR!</div>';
		echo '<p>There was an error creating the database tables!</p>';
		echo '<br />';
		echo 'MySQL returned the error:<br />';
		echo '<pre>('.mysql_errno().') '.mysql_error().'</pre><br />';
		echo '<table>';
		echo '<tr><td class="topright">Database Host:</td><td class="topleft">'.S9YCONF_DB_HOST.'</td></tr>';
		echo '<tr><td class="topright">Database Name:</td><td class="topleft">'.S9YCONF_DB_NAME.'</td></tr>';
		echo '<tr><td class="topright">Database User:</td><td class="topleft">'.S9YCONF_DB_USER.'</td></tr>';
		echo '<tr><td class="topright">Database Password:</td><td class="topleft">'.str_repeat('*',strlen(S9YCONF_DB_PWD)).'</td></tr>';
		echo '</tr></table>';
		echo 'Please check the MySQL privileges for this user.<br />';
		$continue = FALSE;
	}else{
		echo '<div class="ok">Excellent</div>';
		echo '<p>The database tables have been created succesfully, and filled with default data.</p>';
	}

	echo '<p><form action="'.$_SERVER['PHP_SELF'].'" method="post">';
	if (!$continue) {
		echo '<button name="action" value="step9" type="submit">Re-Try</button>';
	}else{
		echo '<button name="action" value="step10" type="submit">Continue to Step 10</button></p>';
	}

	echo '&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '<button name="action" value="step8" type="submit">Back</button></p>';

	if (isset($dbcfg_type)) {
		echo '<input type="hidden" name="dbcfg_type" value="'.$dbcfg_type.'" />';
	}
	if (isset($dbcfg_host)) {
		echo '<input type="hidden" name="dbcfg_host" value="'.$dbcfg_host.'" />';
	}
	if (isset($dbcfg_name)) {
		echo '<input type="hidden" name="dbcfg_name" value="'.$dbcfg_name.'" />';
	}
	if (isset($dbcfg_user)) {
		echo '<input type="hidden" name="dbcfg_user" value="'.$dbcfg_user.'" />';
	}
	if (isset($dbcfg_password)) {
		echo '<input type="hidden" name="dbcfg_password" value="'.$dbcfg_password.'" />';
	}
	if (isset($dbcfg_prefix)) {
		echo '<input type="hidden" name="dbcfg_prefix" value="'.$dbcfg_prefix.'" />';
	}
	if (isset($dbcfg_port)) {
		echo '<input type="hidden" name="dbcfg_port" value="'.$dbcfg_port.'" />';
	}
	if (isset($dbcfg_persistent)) {
		echo '<input type="hidden" name="dbcfg_persistent" value="'.$dbcfg_persistent.'" />';
	}
	if (isset($dbcfg_path)) {
		echo '<input type="hidden" name="dbcfg_path" value="'.$dbcfg_path.'" />';
	}
?>
</form></p>
<?php
	html_footer();
} // end function step9()


// Step 10: Get Location for DB configuration file
function step10() {
	debug_msg ("FUNCTION: ".__FUNCTION__, 3);

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


	$badsecurity = 0; // ReSet bad securoty flag
	$continue = TRUE;

	$final_path = calc_db_path('');

	if(!defined('S9YCONF_DBCFG_PATH')) define('S9YCONF_DBCFG_PATH', $final_path);
	//	include_once $final_path.'dbconfig.php';
	include_once '../config.php';

	steppage(10);

	echo '<h1>Site Security</h1>';

	// Check site security and suggest changes

	// Check DBConfig still exists
	if (file_exists($final_path.'dbconfig.php')) { // Check if the database configuration file exists
		// Check DBConfig readable
		if (!is_readable($final_path.'dbconfig.php')) {
			$badsecurity = $badsecurity | 0x01; // Flag DBConfig NOT Readable
			$continue = FALSE;
		}
/*
dbconfig.php file created as
	rw-,r--,r-- wwwrun:www
on a new installation with no config file
so standard user unable to chown/chmod

		// Check DBConfig writeable
		if (is_writable($final_path.'dbconfig.php')) {
			$badsecurity = $badsecurity | 0x02; // Flag DBConfig Writeable
			$continue = FALSE;
		}
*/
	}else{ // File does NOT exist!
			$badsecurity = $badsecurity | 0x04; // Flag DBConfig does NOT exist!
			$continue = FALSE;
	}

	// Check Main Config still exists
	if (file_exists('../config.php')) { // Check if the main configuration file exists
		// Check Main Config readable
		if (!is_readable('../config.php')) {
			$badsecurity = $badsecurity | 0x08; // Flag main Config NOT Readable
			$continue = FALSE;
		}
/*
config.php file created as
	rw-,r--,r-- wwwrun:www
on a new installation with no config file
so standard user unable to chown/chmod

		// Check Main Config writeable
		if (is_writable('../config.php')) {
			$badsecurity = $badsecurity | 0x10; // Flag main Config Writeable
			$continue = FALSE;
		}
*/
	}else{ // File does NOT exist!
			$badsecurity = $badsecurity | 0x20; // Flag main Config does NOT exist!
			$continue = FALSE;
	}

	// DBconfig directory
	if (is_dir($final_path)) { // Does path exist?
		if (!is_readable($final_path)) { // NOT Readable
			$badsecurity = $badsecurity | 0x40; // Flag DBConfig path NOT Readable
			$continue = FALSE;
		}
		if (is_writable($final_path)) { // Writable
			$badsecurity = $badsecurity | 0x80; // Flag DBConfig path writeable
			$continue = FALSE;
		}
	}else{ // Directory Doesn't exist
			$badsecurity = $badsecurity | 0x100; // Flag DBConfig path does NOT exist!
			$continue = FALSE;
	}

	if (!is_readable('../')) { // NOT Readable
		$badsecurity = $badsecurity | 0x200; // Flag main Config path NOT Readable
		$continue = FALSE;
	}
	if (is_writable('../')) { // Writable
		$badsecurity = $badsecurity | 0x400; // Flag main Config path writeable
		$continue = FALSE;
	}

/*
Bitwise flags held in $badsecurity

														| Bit	|	Value	|	Decimal	|	Hex	|
Flag DBConfig NOT Readable ------------		  1|	2^0	|	   1		0x01
Flag DBConfig Writeable  --------------		  2|	2^1	|	   2		0x02
Flag DBConfig does NOT exist!  --------		  3|	2^2	|	   4		0x04
Flag main Config NOT Readable  --------		  4|	2^3	|	   8		0x08
Flag main Config Writeable  -----------		  5|	2^4	|	  16		0x10
Flag main Config does NOT exist!  -----		  6|	2^5	|	  32		0x20
Flag DBConfig path NOT Readable  ------		  7|	2^6	|	  64		0x40
Flag DBConfig path writeable  ---------		  8|	2^7	|	 128		0x80
Flag DBConfig path does NOT exist!  ---		  9|	2^8	|	 256		0x100
Flag main Config path NOT Readable  ---		 10|	2^9	|	 512		0x200
Flag main Config path writeable  ------		 11|	2^10	|	1024		0x400
*/

	echo '<p><form action="'.$_SERVER['PHP_SELF'].'" method="post">';
	if (!$continue) {
	
		// Check bad security flag
		if (($badsecurity & 0x08) != 0){ // Main config NOT readable
			echo '<div class="error">ERROR!</div>';
			echo '<p>The main configuration file is not readable!</p>';
			echo '<p>Please make it readable by the webserver.</p>';
			echo 'You may be able to do this using:<br />';
			echo '<pre>#: chmod 0444 '.realpath('../').'/config.php</pre>';
			echo '<br />';
		}
		if (($badsecurity & 0x10) != 0){ // Main config writeable
			echo '<div class="warning">Warning</div>';
			echo '<p>Your installation can be made more secure by making the main configuration file read only.</p>';
			echo '<br />';
			echo 'You may do this using:<br />';
			echo '<pre>#: chmod 0444 '.realpath('../').'/config.php</pre>';
			echo '<br />';
		}
		if (($badsecurity & 0x20) != 0){ // Main config does NOT exist!
			echo '<div class="error">ERROR!</div>';
			echo '<p>The main configuration file doesn&apos;t exist!</p>';
			echo '<br />';
			echo 'Please restart the installation<br />';
			echo '<br />';
		}
		if (($badsecurity & 0x01) != 0){ // DBConfig NOT readable
			echo '<div class="error">ERROR!</div>';
			echo '<p>The database configuration file is not readable!</p>';
			echo '<p>Please make it readable by the webserver.</p>';
			echo 'You may be able to do this using:<br />';
			echo '<pre>#: chmod 0444 '.$final_path.'dbconfig.php</pre>';
			echo '<br />';
		}
		if (($badsecurity & 0x02) != 0){ // DBConfig writeable
			echo '<div class="warning">Warning</div>';
			echo '<p>Your installation can be made more secure by making the database configuration file read only.</p>';
			echo '<br />';
			echo 'You may be able to do this using:<br />';
			echo '<pre>#: chmod 0444 '.$final_path.'dbconfig.php</pre>';
			echo '<br />';
		}
		if (($badsecurity & 0x04) != 0){ // DBConfig does NOT exist!
			echo '<div class="error">ERROR!</div>';
			echo '<p>The database configuration file doesn&apos;t exist!</p>';
			echo '<br />';
			echo 'Please restart the installation<br />';
			echo '<br />';
		}
		if (($badsecurity & 0x200) != 0){ // main Config path NOT Readable
			echo '<div class="error">ERROR!</div>';
			echo '<p>The main configuration file is not readable, as the main '.S9YCONF_PROGRAM_NAME.' directory can not be read !</p>';
			echo '<p>Please make it readable by the webserver.</p>';
			echo 'You may be able to do this using:<br />';
			echo '<pre>#: chmod 0555 '.realpath('../').'</pre>';
			echo '<br />';
		}
		if (($badsecurity & 0x400) != 0){ // main Config path writeable
			echo '<div class="warning">Warning</div>';
			echo '<p>The '.S9YCONF_PROGRAM_NAME.' directory is writeable !</p>';
			echo '<p>Please make it readable but NOT writeable by the webserver.</p>';
			echo 'You may be able to do this using:<br />';
			echo '<pre>#: chmod 0555 '.realpath('../').'</pre>';
			echo '<br />';
		}
		if (($badsecurity & 0x40) != 0){ // DBConfig path NOT Readable
			echo '<div class="error">ERROR!</div>';
			echo '<p>The database configuration file is not readable, as the main '.$final_path.' directory can not be read !</p>';
			echo '<p>Please make it readable by the webserver.</p>';
			echo 'You may do this using:<br />';
			echo '<pre>#: be able to chmod 0555 '.$final_path.'</pre>';
			echo '<br />';
		}
		if (($badsecurity & 0x80) != 0){ // DBConfig path writeable
			echo '<div class="warning">Warning</div>';
			echo '<p>The database configuration directory is writeable !</p>';
			echo '<p>Please make it readable but NOT writeable by the webserver.</p>';
			echo 'You may do this using:<br />';
			echo '<pre>#: be able to chmod 0555 '.$final_path.'</pre>';
			echo '<br />';
		}
		if (($badsecurity & 0x100) != 0){ // DBConfig path does NOT exist!
			echo '<div class="error">ERROR!</div>';
			echo '<p>The '.$final_path.' directory doesn&apos;t exist !</p>';
			echo '<br />';
			echo 'Please restart the installation<br />';
			echo '<br />';
		}
	
		echo '<button name="action" value="step10" type="submit">Re-Check</button>';
	}else{
		echo '<div class="ok">Excellent</div>';
		echo '<p>File and directory permissions have been set at acceptable levels.</p>';
		echo '<p>You should new delete this install directory to prevent your configuration or database tables being overwritten accidentally.</p>';
		echo '<br />';
	}

	echo '&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '<button name="action" value="step8" type="submit">Back</button></p>';
	
	if ($continue) {
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';
		html_link('../index.php', $text = 'Start using S9Y_Conf', $status = 'Start using S9Y_Conf', $target = '');
	}
	
	if (isset($dbcfg_type)) {
		echo '<input type="hidden" name="dbcfg_type" value="'.$dbcfg_type.'" />';
	}
	if (isset($dbcfg_host)) {
		echo '<input type="hidden" name="dbcfg_host" value="'.$dbcfg_host.'" />';
	}
	if (isset($dbcfg_name)) {
		echo '<input type="hidden" name="dbcfg_name" value="'.$dbcfg_name.'" />';
	}
	if (isset($dbcfg_user)) {
		echo '<input type="hidden" name="dbcfg_user" value="'.$dbcfg_user.'" />';
	}
	if (isset($dbcfg_password)) {
		echo '<input type="hidden" name="dbcfg_password" value="'.$dbcfg_password.'" />';
	}
	if (isset($dbcfg_prefix)) {
		echo '<input type="hidden" name="dbcfg_prefix" value="'.$dbcfg_prefix.'" />';
	}
	if (isset($dbcfg_port)) {
		echo '<input type="hidden" name="dbcfg_port" value="'.$dbcfg_port.'" />';
	}
	if (isset($dbcfg_persistent)) {
		echo '<input type="hidden" name="dbcfg_persistent" value="'.$dbcfg_persistent.'" />';
	}
	if (isset($dbcfg_path)) {
		echo '<input type="hidden" name="dbcfg_path" value="'.$dbcfg_path.'" />';
	}
?>
</form></p>
<?php
	html_footer();

} // end function step10()


// Common page elements
function steppage($step) {
	debug_msg ("FUNCTION: ".__FUNCTION__, 3);

	html_header("S9Y_Conf Installation Step ".$step);

	$stepname = array('Start Installation'
								, 'Step 1'
								, 'Step 2'
								, 'Step 3'
								, 'Step 4'
								, 'Step 5'
								, 'Step 6'
								, 'Step 7'
								, 'Step 8'
								, 'Step 9'
								, 'Step 10'
								);

	$numsteps = count($stepname);
?>
<div class="left">
<h1>Installation</h1>
<br />
<table class="top-center">
<tr>
<td class="installsteps">
<table>
<?php
	for ($i = 0; $i <= $numsteps - 1; $i++) {
		debug_msg ('Step: '.$i, 5);
		echo '<tr>';
		if ($i < $step) {
			debug_msg ('Postinstall', 5);
			echo '<td class="postinstall">';
//			html_link($_SERVER['PHP_SELF'].'?action=step'.$i, $text = $stepname[$i], $status = $stepname[$i], $target = '');
			echo $stepname[$i];
		}elseif ($i == $step) {
			debug_msg ('Current', 5);
			echo '<td>';
			echo '<b>'.$stepname[$i].'</b>';
		}else{
			debug_msg ('Preinstall', 5);
			echo '<td class="preinstall">';
			echo $stepname[$i];
		}
		echo '</td></tr>';
	}
?>
</table>
</td>
<td class="installaction">
<?php
} // end function steppage($step)


// Read HTTP variables passed to page
function read_httpvars() {
	debug_msg ("FUNCTION: ".__FUNCTION__, 3);

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


	// read post variable for DB Type if present (default MySQL)
	$dbcfg_type = 'MYSQL';
	if (isset($_POST['dbcfg_type'])) {
		$dbcfg_type = $_POST['dbcfg_type'];
	}
	debug_msg('Postvar dbcfg_type: "'.$dbcfg_type.'"', 5);

	// read post variable for DB Host if present
	$dbcfg_host = 'localhost';
	if (isset($_POST['dbcfg_host'])) {
		$dbcfg_host = $_POST['dbcfg_host'];
	}
	debug_msg('Postvar dbcfg_host: "'.$dbcfg_host.'"', 5);

	// read post variable for DB Name if present
	$dbcfg_name = '';
	if (isset($_POST['dbcfg_name'])) {
		$dbcfg_name = $_POST['dbcfg_name'];
	}
	debug_msg('Postvar dbcfg_name: "'.$dbcfg_name.'"', 5);

	// read post variable for DB User if present
	$dbcfg_user = '';
	if (isset($_POST['dbcfg_user'])) {
		$dbcfg_user = $_POST['dbcfg_user'];
	}
	debug_msg('Postvar dbcfg_user: "'.$dbcfg_user.'"', 5);

	// read post variable for DB Password if present
	$dbcfg_password = '';
	if (isset($_POST['dbcfg_password'])) {
		$dbcfg_password = $_POST['dbcfg_password'];
	}
	debug_msg('Postvar dbcfg_password: "'.$dbcfg_password.'"', 5);

	// read post variable for DB Prefix if present
	$dbcfg_prefix = 's9yconf_';
	if (isset($_POST['dbcfg_prefix'])) {
		$dbcfg_prefix = $_POST['dbcfg_prefix'];
	}
	debug_msg('Postvar dbcfg_prefix: "'.$dbcfg_prefix.'"', 5);

	// read post variable for DB Port if present
	$dbcfg_port = '';
	if (isset($_POST['dbcfg_port'])) {
		$dbcfg_port = $_POST['dbcfg_port'];
	}
	debug_msg('Postvar dbcfg_port: "'.$dbcfg_port.'"', 5);

	// read post variable for DB Persistent if present
	$dbcfg_persistent = '0';
	if (isset($_POST['dbcfg_persistent'])) {
		$dbcfg_persistent = $_POST['dbcfg_persistent'];
	}
	debug_msg('Postvar dbcfg_persistent: "'.$dbcfg_persistent.'"', 5);

	// read post variable for DB configuration path if present
	$dbcfg_path = './';
	if (isset($_POST['dbcfg_path'])) {
		$dbcfg_path = $_POST['dbcfg_path'];
	}
	debug_msg('Postvar dbcfg_path: "'.$dbcfg_path.'"', 5);

	$action = '';
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
	}
	if (isset($_POST['action'])) {
		$action = $_POST['action'];
	}
	debug_msg('Postvar action: "'.$action.'"', 5);

} // read_httpvars()


// Calculate various path related parts from $dbcfg_path
function calc_db_path($final_path = '') {
	debug_msg ("FUNCTION: ".__FUNCTION__, 3);

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

	return $final_path;

} // end function calc_db_path(
?>