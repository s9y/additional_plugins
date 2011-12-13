<?php
/*
docs.php

S9Y_Conf On-Line Documentation

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

html_header("S9Y_Conf Documentation");

?>
<div class="textpage">
<h3><?php echo S9YCONF_PROGRAM_NAME.' v'.S9YCONF_VERSION; ?></h3><br />
<h3>Introduction</h3>
<p><?php echo S9YCONF_PROGRAM_NAME; ?> is an application developed to assist with the configuration and management of Serendipity (S9Y) installations.
</p>
<p>Setting up a Serendipity installation can be as simple as copying the distribution files into some webspace, but often involves more tasks such as webserver configuration.
</p>
<p><?php echo S9YCONF_PROGRAM_NAME; ?> is designed to partially automate installation tasks by using templates to create scripts or configuration files, for example an Apache configuration suitable for S9Y. You can modify existing templates or create new ones to suit your own circumstances, easing the task of making multiple installations even over a period of time.
</p>
<p>Other uses are performing upgrades to multiple installations on the same server, where the same tasks need to be performed repetitively.  <?php echo S9YCONF_PROGRAM_NAME; ?> can also be a handy reference to all the blogs you have installed on your server.
</p>
<br />
Created by Chris Lander.
<h3>Getting Started</h3>
<p>When you first open <?php echo S9YCONF_PROGRAM_NAME; ?> you will be redirected to the installation routine.
</p>
<p>Installation is a semi-automatic process that will lead you step by step through creating the configuration files and database tables required.  During the installation if file/directory permissions need to be modified, then you will be notified with an error message which will also provide a solution.
</p>
<p>Tables are created in your database using a prefix on the table names, to allow you to use an existing database while keeping <?php echo S9YCONF_PROGRAM_NAME; ?> separate from your other applications.
</p>
<p>Once the installation has completed any write permissions on the directory can be removed.
</p>
After the installation has been completed you will be able to start using <?php echo S9YCONF_PROGRAM_NAME; ?> to record your Serendipity installations, and create the neccessary configurations for your webserver etc..
<h3>Using <?php echo S9YCONF_PROGRAM_NAME; ?></h3>
<p>The overiding theme of <?php echo S9YCONF_PROGRAM_NAME; ?> is the use of templates to create output relevant to each individual blog installation.  Templates help you to create required configurations for your webserver, and reduce the time it takes to complete a new installation.
</p>
<p>Templates are user defined, so you can customise them to suit your environment, and also can contain user defined variables. There is a small set of templates and variables to get you started.
</p>
<p>Initially you will want to add your blog installation to the Blogs list, and then view a template's output.
</p>
<h3>Navigating</h3>
<p>On the left of each page is a navigation menu with the the three main areas of
<?php echo S9YCONF_PROGRAM_NAME; ?>, which are variables, templates, and blogs.  Clicking any of
these links will take you to a list, where you will be able to add/edit/delete items.
</p>
<h3>Variables</h3>
<p>The variables section is where you will find all the template variables, which are used in
templates, where they are substituted with their content.
</p>
<p>Variables always have a unique name which uses upper case characters, and may contain spaces. You
will also be able to include other variables within a variable, allowing complex variables to be
built from smaller building blocks. Variables can be nested and are expanded in a recursive manner
so a variable can contain another variable that itself contains yet another variable.
</p>
<p>There are variables that are hard coded into the program, the names of which you can not use as
the name for one of your variables.
</p>
<p>The reserved variables are:
</p>
<table border="5">
<tr>
<th>Variable</th>
<th>Description</th>
<th>Example</th>
</tr>
<tr>
<td>{NOW}</td>
<td>replaced with the system time as an <a href="http://www.faqs.org/rfcs/rfc2822" target="_blank">RFC 2822</a> formatted date</td>
<td><?php echo date('r'); ?></td>
</tr>
<tr>
<td>{S9YCONF}</td>
<td>replaced with this programs name and version number</td>
<td><?php echo S9YCONF_PROGRAM_NAME.' v'.S9YCONF_VERSION; ?></td>
</tr>
<tr>
<td>{BLOGID}</td>
<td>replaced with the numeric system id of the blog</td>
<td>12</td>
</tr>
<tr>
<td>{BLOGNAME}</td>
<td>replaced with the blog name entered in the blog data</td>
<td>Test S9Y installation</td>
</tr>
<tr>
<td>{BLOGPATH}</td>
<td>replaced with the blog path entered in the blog data</td>
<td>/home/user1/public_html/blog</td>
</tr>
<tr>
<td>{BLOGUSER}</td>
<td>replaced with the local user entered in the blog data</td>
<td>user1</td>
</tr>
<tr>
<td>{BLOGURL}</td>
<td>replaced with the blog url entered in the blog data</td>
<td>http://myhost.foo.bar/~user1/blog/</td>
</tr>
<tr>
<td>{TPLID}</td>
<td>replaced with the numeric system id of the template</td>
<td>7</td>
</tr>
<tr>
<td>{TPLNAME}</td>
<td>replaced with the template name entered in the template data</td>
<td>Apache</td>
</tr>
<tr>
<td>{TPLDESC}</td>
<td>replaced with the template description entered in the template data</td>
<td>Suggested S9Y Apache configuration</td>
</tr>
</table>
<p>When you use a variables in another variable, or within a template, it MUST
always be enclosed with braces, '{' and '}', so that <?php echo S9YCONF_PROGRAM_NAME; ?> can
recognise where the variables are.
</p>
<h3>Templates</h3>
<p>The templates section is where you will find all the templates, which you can process along with
blog data to create configuration files etc. for your server.
</p>
<p>Each template has a unique name, a description, and content.  The content of a template can
contain any of the variables you have created along with the reserved variables detailed above.
</p>
<p>When you use a variables in a template, or within another variable it MUST
always be enclosed with braces, '{' and '}', so that <?php echo S9YCONF_PROGRAM_NAME; ?> can
recognise where the variables are.
</p>
<h3>Blogs</h3>
<p>The blogs section is where you will find entries for each of the individual blogs you have
entered, which you can process along with a template either one at a time or collectively.
</p>
<p>Each blog entry has a unique name, the system path to it&apos;s location, the system name of the
owner, and a url.
</p>
</div>
<?php
html_footer();
?>