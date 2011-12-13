<?php
/*
index.php

S9Y_Conf Main Entry Point

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


debug_msg ("FILE: ".__FILE__,3);

db_connect();

html_header("S9Y_Conf Serendipity Blog Configuration Tool");

?>
<div class="textpage">
<h3><?php echo S9YCONF_PROGRAM_NAME.' v'.S9YCONF_VERSION; ?></h3><br />
<p>An application developed to assist with the configuration and management
of Serendipity (S9Y) installations.
</p>
<p>Created by Chris Lander.
</p>
</div>
<?php
html_footer();
?>