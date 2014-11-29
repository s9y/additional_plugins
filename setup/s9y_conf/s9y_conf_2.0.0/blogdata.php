<?php
/*
blogdata.php

S9Y_Conf Blog Data display/edit

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

db_connect();

$action = '';

if (isset($_GET['action'])) {
	$action = $_GET['action'];
}
if (isset($_POST['action'])) {
	$action = $_POST['action'];
}

debug_msg("Action: ".$action,5);

// Determine what action to take
switch ($action) {

	case 'add':
		blogdata_add();
		break;

	case 'edit':
		if (isset($_GET['uid'])) {
			$uid = $_GET['uid'];
			blogdata_edit($uid);
		}
		break;

	case 'view':
		if (isset($_POST['uid'])) {
			$uid = $_POST['uid'];
			if (isset($_POST['tplid'])) {
				$tplid = $_POST['tplid'];
			}
			blogdata_view($uid, $tplid);
		}
		break;

	case 'viewall':
		if (isset($_POST['tplid'])) {
			$tplid = $_POST['tplid'];
		blogdata_view_all($tplid);
		}
		break;

	case 'delete':
		if (isset($_GET['uid'])) {
			$uid = $_GET['uid'];
			blogdata_delete($uid);
		}
		break;

	case 'deleterecord':
		if (isset($_POST['uid'])) {
			$uid = $_POST['uid'];
			blogdata_deleterecord($uid);
		}
		break;

	case 'insert':
		blogdata_insert();
		break;

	case 'update':
		if (isset($_POST['uid'])) {
			$uid = $_POST['uid'];
			blogdata_update($uid);
		}
		break;

	default :
		list_blogs();
		break;

} //end switch

exit(0);


/*
blogdata_delete($uid = '')

Delete a Blog Data record (no recovery)
*/
function blogdata_deleterecord($uid = '') {
	debug_msg ("FUNCTION: ".__FUNCTION__,4);

	db_delete_blogdata($uid);

	// If no headers are sent, send one
	if (!headers_sent()) {
		header("Location: http://" . $_SERVER['HTTP_HOST']
                      . dirname($_SERVER['PHP_SELF'])
                      . "/blogdata.php");
	    exit;
	}
	
	echo "Delete Blog Data";

} // end function blogdata_deleterecord($uid = '')


/*
blogdata_delete($uid = '')

Delete a Blog Data record (last chance)
*/
function blogdata_delete($uid = '') {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	html_header("Delete Blog Data");

	$result = db_read_blogdata($uid);

	$name = $result['name'];
	$blog_path=$result['blog_path'];
	$user = $result['user'];
	$url = $result['url'];

?>
<div align="center">
<h1>Delete Blog</h1>
<br />

<?php
	blogdata_display($uid, $name, $blog_path, $user, $url);
?>
<br />
<br />
Really DELETE this record ?
<br />
<form action="blogdata.php" method="post">
<input type="hidden" name="uid" value="<?php echo $uid; ?>" />
<button name="action" value="deleterecord" type="submit">Yes</button>
<button name="action" value="back" type="submit">No</button>
</form>
</div>
<?php
	html_footer();

} // end function blogdata_delete($uid = '')


/*
blogdata_update($uid = '')

Update a Blog Data record
*/
function blogdata_update($uid = '') {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$name = '';
	$blog_path = '';
	$user = '';
	$url = '';
	
	if ($_POST['name']) {
		$name = trim($_POST['name']);
	}
	if ($_POST['blog_path']) {
		$blog_path = trim($_POST['blog_path']);
	}
	if ($_POST['user']) {
		$user = trim($_POST['user']);
	}
	if ($_POST['url']) {
		$url = trim($_POST['url']);
	}

	// Remove 'http://' from start of URL if it exists
	$pos = strpos(strtolower($url), 'http://');
	if ($pos !== FALSE) {
	    $url = substr($url, 7);
	}

	if ($name == '' || $blog_path == '' || $user == '' || $url == '') {
		html_header("Edit Blog Data");
?>
<div align="center">
<h1>Edit Blog</h1>
<br />
<?php
		if ($name == '') {
			blogdata_form('update', $uid, $name, $blog_path, $user, $url, 'No name entered for this blog');
		}elseif ($blog_path == '') {
			blogdata_form('update', $uid, $name, $blog_path, $user, $url, 'No filesystem path entered for this blog');
		}elseif ($user == '') {
			blogdata_form('update', $uid, $name, $blog_path, $user, $url, 'No system user name entered for this blog');
		}elseif ($url == '') {
			// Add 'http://' to start of URL
			$url = 'http://'.$url;
			blogdata_form('update', $uid, $name, $blog_path, $user, $url, 'No URL entered for this blog');
		}
?>
</div>

<?php
	html_footer();
		exit();
	}

	// Add 'http://' to start of URL
	$url = 'http://'.$url;

	db_update_blogdata($uid, $name, $blog_path, $user, $url);

	// If no headers are sent, send one
	if (!headers_sent()) {
		header("Location: http://" . $_SERVER['HTTP_HOST']
                      . dirname($_SERVER['PHP_SELF'])
                      . "/blogdata.php");
	    exit;
	}
} //end function blogdata_update($uid = '')


/*
blogdata_insert()

Update a Blog Data record
*/
function blogdata_insert() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$name = '';
	$blog_path = '';
	$user = '';
	$url = '';
	
	if ($_POST['name']) {
		$name = trim($_POST['name']);
	}
	if ($_POST['blog_path']) {
		$blog_path = trim($_POST['blog_path']);
	}
	if ($_POST['user']) {
		$user = trim($_POST['user']);
	}
	if ($_POST['url']) {
		$url = trim($_POST['url']);
	}

	// Remove 'http://' from start of URL if it exists
	$pos = strpos(strtolower($url), 'http://');
	if ($pos !== FALSE) {
	    $url = substr($url, 7);
	}

	if ($name == '' || $blog_path == '' || $user == '' || $url == '') {
		html_header("Edit Blog Data");
?>
<div align="center">
<h1>Add Blog</h1>
<br />
<?php
		if ($name == '') {
			blogdata_form('insert', $uid, $name, $blog_path, $user, $url, 'No name entered for this blog');
		}elseif ($blog_path == '') {
			blogdata_form('insert', $uid, $name, $blog_path, $user, $url, 'No filesystem path entered for this blog');
		}elseif ($user == '') {
			blogdata_form('insert', $uid, $name, $blog_path, $user, $url, 'No system user name entered for this blog');
		}elseif ($url == '') {
			// Add 'http://' to start of URL
			$url = 'http://'.$url;
			blogdata_form('insert', $uid, $name, $blog_path, $user, $url, 'No URL entered for this blog');
		}
?>
</div>

<?php
	html_footer();
		exit();
	}

	// Add 'http://' to start of URL
	$url = 'http://'.$url;

	db_insert_blogdata($name, $blog_path, $user, $url);

	// If no headers are sent, send one
	if (!headers_sent()) {
		header("Location: http://" . $_SERVER['HTTP_HOST']
                      . dirname($_SERVER['PHP_SELF'])
                      . "/blogdata.php");
	    exit;
	}
} // end function blogdata_insert($uid = '')


/*
blogdata_add()

Add a Blog Data record
*/
function blogdata_add() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	html_header("Add Blog Data");

	$uid = '';
	$name = '';
	$blog_path='';
	$user = '';
	$url = 'http://';

?>
<div align="center">
<h1>Add Blog</h1>
<br />
<?php
	blogdata_form('insert', NULL, $name, $blog_path, $user, $url);
?>
</div>

<?php
	html_footer();
} // end function blogdata_add()

/*
blogdata_edit()

Edit a Blog Data record
*/
function blogdata_edit($uid) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	html_header("Edit Blog Data");

	$result = db_read_blogdata($uid);

	$name = $result['name'];
	$blog_path=$result['blog_path'];
	$user = $result['user'];
	$url = $result['url'];

?>
<div align="center">
<h1>Edit Blog</h1>
<br />

<?php
	blogdata_form('update', $uid, $name, $blog_path, $user, $url);
?>
</div>
<?php
	html_footer();
} // end function blogdata_edit($uid)


/*
blogdata_form($action = "save")

Forms based data entry for Blog Data
*/
function blogdata_form($action = '', $uid = NULL, $name = '', $blog_path = '', $user = '', $url = '', $message = '') {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

?>
<?php
if ($message != '') {
	echo '<div class="error">'.$message.'<br /></div>';
}
?>
<form action="blogdata.php" method="post">

<!-- <table cellpadding="0" align="center">
 -->
<table class="center">

<tr>

<td class="right">
Name :
</td>
<td class="left">
<input type="text" name="name" value="<?php echo $name; ?>" size="30" maxlength="255" />
</td>

</tr>

<tr>

<td class="right">
Blog Path :
</td>
<td class="left">
<input type="text" name="blog_path" value="<?php echo $blog_path; ?>" size="30" maxlength="255" />
</td>

</tr>

<tr>

<tr>

<td class="right">
Local user :
</td>
<td class="left">
<input type="text" name="user" value="<?php echo $user; ?>" size="30" maxlength="255" />
</td>

</tr>

<tr>

<td class="right">
Blog URL :
</td>
<td class="left">
<input type="text" name="url" value="<?php echo $url; ?>" size="30" maxlength="255" />
</td>

</tr>


<tr>
<td class="right">
</td>
<td class="left">
<button name="action" value="<?php echo $action; ?>" type="submit">Save</button>
<button name="action" value="back" type="submit">Back</button>
<button name="reset" value="Reset" type="reset">Reset</button>
</td>
</tr>
</table>
<?php
if (isset($uid)) {
?>
<input type="hidden" name="uid" value="<?php echo $uid; ?>" />
<?php
}
?>
</form>
<?php
} //end function blogdata_form($action = '', $uid = NULL, $name = '', $blog_path = '', $user = '', $url = '', $message = '')

/*
list_blogs()

List Blog Data records
*/
function list_blogs() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	// Read template data to create selection list
	$result = db_multirec_read_all_templates();
	debug_msg ("Query Result: $result",5);
	$num_records = count($result);
	debug_msg ("Number of records: $num_records",4);
	if ($num_records > 0) {
		$tplselect = '';
		foreach ($result as $row) {
			$tplselect = $tplselect.'<option value="'.$row['id'].'">'.$row['name'].'</option>';
		}
	}


	$result = db_multirec_read_all_blogdata();
	debug_msg ("Query Result: $result",5);

	$num_records = count($result);
	debug_msg ("Number of records: $num_records",4);

	if ($num_records > 0) {
		html_header("List Blogs");
?>
<div align="center">
<h1>Blog Data</h1>
<br />
<div class="left">
<form action="blogdata.php" method="post">
Select a template:&nbsp;
<select name="tplid"><?php echo $tplselect;  ?></select>
<br /><br />
<button name="action" value="viewall" type="submit">Process template with all blogs</button>
</form>
</div>
<br />
<br />
<form action="blogdata.php" method="post">
Select a template:&nbsp;
<select name="tplid"><?php echo $tplselect;  ?></select>
<input type="hidden" name="action" value="view" />
<br /><br />
<table width="100%" cellpadding="0" align="center">
<tr>
<th colspan="3" class="list"></th>		<!-- Edit/Delete -->
<th class="list">Name</th>					<!-- url -->
<th class="list"></th>						<!-- Blog Link -->
<th class="list">Blog URL</th>			<!-- url -->
</tr>
<?php
		for ($i = 0; $i < $num_records; $i++) {
			$row = $result[$i];
			if ($row == '') {
				echo "Cannot seek to row $record:\n";
				continue;
			}
?>
<tr>
<td class="center-list">
&nbsp;
<a href="blogdata.php?action=edit&amp;uid=<?php echo $row['uid']; ?>" onmouseover="window.status='Edit';return true" onmouseout="window.status='';return true"><img src="images/editblog.png" alt="Edit" border="0" /></a>
&nbsp;
</td>
<td class="center-list">
&nbsp;
<a href="blogdata.php?action=delete&amp;uid=<?php echo $row['uid']; ?>" onmouseover="window.status='Delete';return true" onmouseout="window.status='';return true"><img src="images/delblog.png" alt="Delete" border="0" /></a>
&nbsp;
</td>
<td>
<button name="uid" value="<?php echo $row['uid']; ?>" type="submit">View Template</button>
</td>
<td class="left-list">
<?php echo $row['name']; ?>
</td>
<td class="center-list">
&nbsp;
<a href="<?php echo $row['url']; ?>" target="_blank" onmouseover="window.status='View blog';return true" onmouseout="window.status='';return true"><img src="images/viewblog.png" alt="View Blog" border="0" /></a>
&nbsp;
</td>
<td class="left-list">
<?php echo $row['url']; ?>
</td>
</tr>
<?php
		}
?>
</table>
<br />
<table width="100%">
<tr>
<td class="left">
<a href="blogdata.php?action=add" onmouseover="window.status='Add a new blog';return true" onmouseout="window.status='';return true"><img src="images/addblog.png" alt="Add" border="0" /> Add a new blog</a>
</td>
</tr>
</table>
</form>
</div>
<?php
	}
	html_footer();
} // end function list_blogs()

/*
blogdata_display()

Display Blog Data
*/
function blogdata_display($uid = '', $name = '', $blog_path = '', $user = '', $url = '', $message = '') {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

?>
<?php
if ($message != '') {
	echo '<div class="information">'.$message.'<br /></div>';
}
?>
<table cellpadding="0" align="center">

<tr>

<td class="right">
Name :
</td>
<td class="left">
<?php echo $name; ?>
</td>

</tr>

<tr>

<td class="right">
Blog Path :
</td>
<td class="left">
<?php echo $blog_path; ?>
</td>

</tr>

<tr>

<tr>

<td class="right">
Local user :
</td>
<td class="left">
<?php echo $user; ?>
</td>

</tr>

<tr>

<td class="right">
Blog URL :
</td>
<td class="left">
<?php echo $url; ?>
</td>

</tr>


</table>
<?php
} //end function blogdata_display($uid = '', $name = '', $blog_path = '', $user = '', $url = '', $message = '')

/*
blogdata_view()

View output of a template for a Blog
*/
function blogdata_view($blogid = '', $tplid = '') {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	// Create navigation form
	// Read template data to create selection list
	$result = db_multirec_read_all_templates();
	debug_msg ("Query Result: $result",5);
	$num_records = count($result);
	debug_msg ("Number of records: $num_records",4);
	if ($num_records > 0) {
		$tplselect = '';
		foreach ($result as $row) {
			if ($row['id'] == $tplid) {
				$tplselect = $tplselect.'<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
			}else{
				$tplselect = $tplselect.'<option value="'.$row['id'].'">'.$row['name'].'</option>';
			}
		}
	}
	$navform = '<form action="blogdata.php" method="post"><select name="tplid">'.$tplselect.'</select><br /><br /><input type="hidden" name="uid" value="'.$blogid.'" /><button name="action" value="view" type="submit">View Template Output</button><br /><br /><button name="action" value="viewall" type="submit">Process all blogs with template</button><br /><br /><button name="action" value="back" type="submit">Back to Blog Data</button></form>';

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
	$template_contents = html_entity_decode($templatedata['template'], ENT_COMPAT, LANG_CHARSET);

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
		$template_contents = str_replace('{'.$tplvar['name'].'}', html_entity_decode($tplvar['value'], ENT_COMPAT, LANG_CHARSET), $template_contents);
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

	html_header("S9Y_Conf Output of the template '$TEMPLATE_DESCRIPTION' for Blog '$BLOGNAME'");
	echo $navform."<br />";
	echo "Output of the template '".$TEMPLATE_NAME."' for blog '".$BLOGNAME."'<br />";
	echo "<br />";
	echo "Click <a href=\"tplfile.php?blogid=$blogid&amp;tplid=$tplid\" onmouseover=\"window.status='Click to download template contents';return true\" onmouseout=\"window.status='';return true\">here</a> to download";
	echo '<hr /><div class="left">';
	echo nl2br(htmlentities($template_contents, ENT_COMPAT, LANG_CHARSET));
	echo "</div><hr />";
	echo "Click <a href=\"tplfile.php?blogid=$blogid&amp;tplid=$tplid\" onmouseover=\"window.status='Click to download template contents';return true\" onmouseout=\"window.status='';return true\">here</a> to download";
	echo "<br />";
	echo "<br />".$navform."<br />";

	html_footer();

} //end function blogdata_view($uid = '', $tplid = '')



/*
blogdata_view_all()

View output of a template for ALL Blog
*/
function blogdata_view_all($tplid = '') {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	// Create navigation form
	// Read template data to create selection list
	$result = db_multirec_read_all_templates();
	debug_msg ("Query Result: $result",5);
	$num_records = count($result);
	debug_msg ("Number of records: $num_records",4);
	if ($num_records > 0) {
		$tplselect = '';
		foreach ($result as $row) {
			if ($row['id'] == $tplid) {
				$tplselect = $tplselect.'<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
			}else{
				$tplselect = $tplselect.'<option value="'.$row['id'].'">'.$row['name'].'</option>';
			}
		}
	}
	$navform = '<form action="blogdata.php" method="post"><select name="tplid">'.$tplselect.'</select><br /><br /><button name="action" value="viewall" type="submit">View Template Output</button><br /><br /><button name="action" value="back" type="submit">Back to Blog Data</button></form>';

	// Set System template variables
	$NOW = date('r');
	$S9YCONF = S9YCONF_PROGRAM_NAME.' v'.S9YCONF_VERSION;

	// Set template variables
	$templatevars = db_multirec_read_all_templatevars();


	// Set specific template variables
	$templatedata = db_read_templates($tplid);
	$TEMPLATE_ID = $templatedata['id'];
	$TEMPLATE_NAME = $templatedata['name'];
	$TEMPLATE_DESCRIPTION = $templatedata['description'];

	// Template contents
	$template_contents = html_entity_decode($templatedata['template'], ENT_COMPAT, LANG_CHARSET);

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
		$template_contents = str_replace('{'.$tplvar['name'].'}', html_entity_decode($tplvar['value'], ENT_COMPAT, LANG_CHARSET), $template_contents);
	}

	// Insert specific template template variables
	$template_contents = str_replace('{TPLID}', $TEMPLATE_ID, $template_contents);
	$template_contents = str_replace('{TPLNAME}', $TEMPLATE_NAME, $template_contents);
	$template_contents = str_replace('{TPLDESC}', $TEMPLATE_DESCRIPTION, $template_contents);

	html_header("S9Y_Conf Output of the template '$TEMPLATE_DESCRIPTION' for all blogs");
	echo $navform."<br />";
	echo "Output of the template '".$TEMPLATE_NAME."' for all blogs<br />";
	echo "<br />";
	echo "Click <a href=\"tplfileall.php?tplid=$tplid\" onmouseover=\"window.status='Click to download template contents';return true\" onmouseout=\"window.status='';return true\">here</a> to download";
	echo '<hr /><div class="left">';

	$result = db_select_all_blogdata();
	while($row = mysql_fetch_assoc($result)) {
		$template_temp = $template_contents;

		// Set specific Blog template variables
		$BLOGID = $row['uid'];
		$BLOGNAME = $row['name'];
		$BLOGPATH = $row['blog_path'];
		$BLOGUSER = $row['user'];
		$BLOGURL = $row['url'];

		// Insert specific blog template variables
		$template_temp = str_replace('{BLOGID}', $BLOGID, $template_temp);
		$template_temp = str_replace('{BLOGNAME}', $BLOGNAME, $template_temp);
		$template_temp = str_replace('{BLOGPATH}', $BLOGPATH, $template_temp);
		$template_temp = str_replace('{BLOGUSER}', $BLOGUSER, $template_temp);
		$template_temp = str_replace('{BLOGURL}', $BLOGURL, $template_temp);


		echo nl2br(htmlentities($template_temp, ENT_COMPAT, LANG_CHARSET));

	}


	echo "</div><hr />";
	echo "Click <a href=\"tplfile.php?tplid=$tplid\" onmouseover=\"window.status='Click to download template contents';return true\" onmouseout=\"window.status='';return true\">here</a> to download";
	echo "<br />";
	echo "<br />".$navform."<br />";

	html_footer();

} //end function blogdata_view_all($tplid = '')
?>
