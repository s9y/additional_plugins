<?php
/*	html.functions.inc.php

	Functions to provide HTML output

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


/*
Site navigation presented vertically
*/
function html_verticalnavigation($nav = '') {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

if ($nav !== ''){
	// Start the table
	echo '<table class="vnav">';

	foreach ($nav as $item) {
		echo '<tr><td class="vnav">';
		html_link($item[0], $item[1], $item[2], $item[3]);
		echo '</td></tr>';	}

	// Finish off the table
	echo '</table>';
}

} //End function html_verticalnavigation()


/*
Site navigation presented horizontally
*/
function html_horizontalnavigation($nav = '') {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

if ($nav !== ''){
	// Start the table
	echo '<table class="hnav"><tr>';

	foreach ($nav as $item) {
		echo '<td class="hnav">';
		html_link($item[0], $item[1], $item[2], $item[3]);
		echo '</td>';
	}

	// Finish off the table
	echo '</tr></table>';
}

} //End function html_horizontalnavigation()


/*
Function to create an HTML link
*/
function html_link($href, $text = '', $status = '', $target = ''){
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	// Start the link
	echo '<a href=\''.$href.'\' ' ;

	// Add a target if one supplied
	if ($target != ''){
		echo 'target="'.$target.'" ';
	}

	// Add javascipt for page status if any supplied
	if ($status != ''){
		echo 'onmouseover="window.status=\''.$status.'\';return true" ';
		echo 'onmouseout="window.status=\'\';return true" ';
	}

	// Close the opening tag
	echo '>';

	if ($text == ''){
		echo $href;
	}else{	
		echo $text;
	}

	// Finish off the link
	echo '</a>';
} // end function html_link($href, $text = $href, $status = '', $target = '')


/*

	HTML Page header

*/
function html_header($title = '', $description = '', $keywords = '', $javascript='') {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	header ("Content-Type: text/html; charset=utf-8");
	debug_msg ("      Title: ".$title,4);
	debug_msg ("Description: ".$description,4);
	debug_msg ("   Keywords: ".$keywords,4);
	debug_msg (" JavaScript: ".$javascript,4);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<meta name="generator" content="S9Y_Conf" />
<meta name="author" content="Chris Lander" />
<meta name="copyright" content="LABBS Web Services" />
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<link rel="stylesheet" type="text/css" href="style.css" />
<?php
	if ($javascript != '') {
		echo '<script src="inc/'.$javascript.'" type="text/javascript">'."\n";
		echo '</script>'."\n";
	}
?>
</head>
<body>
<table width="100%">
<tr>
<td class="left">
	<a href="index.php" onmouseover="window.status='S9Y_Conf';return true" onmouseout="window.status='';return true">
		<img src="images/s9y_conf_logo.png" alt="S9y_confs" width="230" border="0" />
	</a></td>
<td class="center">
<a target="_blank" href="http://www.s9y.org/" onmouseover="window.status='Visit The Serendipity website';return true" onmouseout="window.status='';return true">
<img src="images/s9y_logo.png" alt="Serendipity" border="0" /></a>
<br />A tool to assist with the configuration &amp; management of Serendipty Installations
</td>
<td class="right">
	<a target="_blank" href="http://www.labbs.com/" onmouseover="window.status='Vist LABBS Web Services !';return true" onmouseout="window.status='';return true">
		<img src="images/LABBS_COM_LOGO.gif" alt="LABBS Web Services" width="230" border="0" />
	</a>
</td>
</tr>
<?php
	if ((S9YCONF_INSTALLED) && (is_dir('./install'))) {
		echo '<tr><td class="center" colspan="3"><div class="warning">Warning install directory exists</div></td></tr>';
	}
?>
</table>
<hr />
<table width="100%">
<tr>
<td class="topleft">
<?php
	// Create an array of navigation items
	if ((!S9YCONF_INSTALLED) && (is_dir('./install'))) {
		$nav[] = array('install/index.php', '<div class="ok">Install</div>', 'Install', '');
	}

	$nav[] = array('index.php', 'Home', 'Home', '');
	$nav[] = array('templatevars.php', 'Variables', 'Template Variables', '');
	$nav[] = array('template.php', 'Templates', 'Templates', '');
	$nav[] = array('blogdata.php', 'Blogs', 'Blogs', '');
	$nav[] = array('docs.php', 'Documents', 'Documents', '');

//	$nav[] = array('http://'.$_SERVER['SERVER_NAME'].'/phpMyAdmin/', 'phpMyAdmin', 'phpMyAdmin', '');
//	$nav[] = array('http://'.$_SERVER['SERVER_NAME'].'/phpmanual', 'PHP Manual', 'PHP Manual', '');

	html_verticalnavigation($nav);
?>
 </td>
<td class="center">
<?php
} //End function html_header($title = '', $description = '', $keywords = '', $javascript='')


/*

	HTML Page footer

*/
function html_footer() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

?>
</td>
</tr>
</table>
<hr />
<table width="100%">
	<tr>
		<td class="left">
			<a target="_blank" href="http://validator.w3.org/check?uri=http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']; ?>"><img style="border:0;width:88px;height:31px" src="images/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
<!-- 
http://validator.w3.org/check?uri=http%3A%2F%2Fvolvo.labbs.com%2F~clander%2Fs9y_conf%2Fphp%2Finstall%2Finstall.php
 -->
		</td>
		<td class="center">
			<?php echo S9YCONF_PROGRAM_NAME.' v'.S9YCONF_VERSION; ?> &copy; 2006 Chris Lander<br />
			All logos and trademarks in this site are property of their respective owner.<br />
			This application is licenced under the <a href="licence.php" onmouseover="window.status='View licence information';return true" onmouseout="window.status='';return true">GNU General Public Licence</a>
<!-- 
			All the rest &copy; 2006 Chris Lander &amp; <a href="http://www.labbs.com/" target="_blank" onmouseover="window.status='Visit LABBS Web Services !';return true" onmouseout="window.status='';return true">LABBS Web Services</a>
 -->		</td>
		<td class="right">
			<a target="_blank" href="http://jigsaw.w3.org/css-validator/validator?uri=http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']; ?>"><img style="border:0;width:88px;height:31px" src="images/vcss"  alt="Valid CSS!" /></a>
<!-- 
http://jigsaw.w3.org/css-validator/validator?uri=http%3A%2F%2Fvolvo.labbs.com%2F~clander%2Fs9y_conf%2Fphp%2Finstall%2Finstall.php
 -->
		</td>
	</tr>
</table>
</body>
</html>
<?php
} //end function html_footer()

?>
