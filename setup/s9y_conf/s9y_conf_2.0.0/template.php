<?php
/*
template.php

S9Y_Conf Template Data display/edit

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
		template_add();
		break;

	case 'edit':
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			template_edit($id);
		}
		break;

	case 'delete':
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			template_delete($id);
		}
		break;

	case 'deleterecord':
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			template_deleterecord($id);
		}
		break;

	case 'insert':
		template_insert();
		break;

	case 'update':
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			template_update($id);
		}
		break;

	default :
		list_templates();
		break;

} //end switch

exit(0);


/*
template_deleterecord($id = '')

Delete a Blog Data record (no recovery)
*/
function template_deleterecord($id = '') {
	debug_msg ("FUNCTION: ".__FUNCTION__,4);

	db_delete_templates($id);

	// If no headers are sent, send one
	if (!headers_sent()) {
		header("Location: http://" . $_SERVER['HTTP_HOST']
                      . dirname($_SERVER['PHP_SELF'])
                      . "/template.php");
	    exit;
	}
} // end function template_deleterecord($id = '')


/*
template_delete($id = '')

Delete a Template Data record (last chance)
*/
function template_delete($id = '') {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	html_header("Delete Template Data");

	$result = db_read_templates($id);

	$name = $result['name'];
	$description=$result['description'];
	$template = $result['template'];

?>
<div align="center">
<h1>Delete Template</h1>
<br />

<?php
	template_display($id, $name, $description, $template);
?>
<br />
<br />
Really DELETE this record ?
<br />
<form action="template.php" method="post">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<button name="action" value="deleterecord" type="submit">Yes</button>
<button name="action" value="back" type="submit">No</button>
</form>
</div>
<?php
	html_footer();

} // end function template_delete($id = '')


/*
template_update($id = '')

Update a Blog Data record
*/
function template_update($id = '') {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$name = '';
	$description = '';
	$template = '';
	
	if ($_POST['name']) {
		$name = trim($_POST['name']);
	}
	if ($_POST['description']) {
		$description = trim($_POST['description']);
	}
	if ($_POST['template']) {
		$template = trim($_POST['template']);
	}

	if ($name == '' || $description == '' || $template == '') {
		html_header("Edit Template Data");
?>
<div align="center">
<h1>Edit Template</h1>
<br />
<?php
		if ($name == '') {
			template_form('update', $id, $name, $description, $template, 'No name entered for this template');
		}elseif ($description == '') {
			template_form('update', $id, $name, $description, $template, 'No description entered for this template');
		}elseif ($template == '') {
			template_form('update', $id, $name, $description, $template, 'No contents entered for this template');
		}
?>
</div>

<?php
	html_footer();
		exit();
	}

	$result = db_update_templates($id, $name, $description, htmlspecialchars($template));

	// SQL Error inserting record
	if ($result == '') {
		html_header("Edit Template Data");
?>
<div align="center">
<h1>Edit Template</h1>
<br />
<?php
		template_form('update', $id, $name, $description, $template, 'The template '.$name.' already exists!');

?>
</div>

<?php
		html_footer();
		exit();
	}

	// If no headers are sent, send one
	if (!headers_sent()) {
		header("Location: http://" . $_SERVER['HTTP_HOST']
                      . dirname($_SERVER['PHP_SELF'])
                      . "/template.php");
	    exit;
	}
} //end function template_update($id = '')


/*
template_insert()

Add a Template Data record
*/
function template_insert() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$name = '';
	$description = '';
	$template = '';
	
	if ($_POST['name']) {
		$name = trim($_POST['name']);
	}
	if ($_POST['description']) {
		$description = trim($_POST['description']);
	}
	if ($_POST['template']) {
		$template = trim($_POST['template']);
	}

	if ($name == '' || $description == '' || $template == '') {
		html_header("Add Template Data");
?>
<div align="center">
<h1>Add Template</h1>
<br />
<?php
		if ($name == '') {
			template_form('insert', '', $name, $description, $template, 'No name entered for this template');
		}elseif ($description == '') {
			template_form('insert', '', $name, $description, $template, 'No description entered for this template');
		}elseif ($template == '') {
			template_form('insert', '', $name, $description, $template, 'No actual template entered for this template');
		}
?>
</div>

<?php
	html_footer();
		exit();
	}

	$result = db_insert_templates($name, $description, htmlspecialchars($template));

	// SQL Error inserting record
	if ($result == '') {
		html_header("Add Template Data");
?>
<div align="center">
<h1>Add Template</h1>
<br />
<?php
		template_form('insert', '', $name, $description, $template, 'The template '.$name.' already exists!');
?>
</div>

<?php
	html_footer();
		exit();
	}

	// If no headers are sent, send one
	if (!headers_sent()) {
		header("Location: http://" . $_SERVER['HTTP_HOST']
                      . dirname($_SERVER['PHP_SELF'])
                      . "/template.php");
	    exit;
	}
} // end function template_insert($id = '')


/*
template_add()

Add a Template Data record
*/
function template_add() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	html_header("Add Template Data");

	$id = '';
	$name = '';
	$description='';
	$template = '';

?>
<div align="center">
<h1>Add Template</h1>
<br />
<?php
	template_form('insert', NULL, $name, $description, $template);
?>
</div>

<?php
	html_footer();
} // end function template_add()

/*
template_edit()

Edit a Blog Data record
*/
function template_edit($id) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	html_header("Edit Template Data");

	$result = db_read_templates($id);

	$name = $result['name'];
	$description=$result['description'];
	$template = html_entity_decode($result['template']);

?>
<div align="center">
<h1>Edit Template</h1>
<br />

<?php
	template_form('update', $id, $name, $description, $template);
?>
</div>
<?php
	html_footer();
} // end function template_edit($id)


/*
template_form($action = "save")

Forms based data entry for Blog Data
*/
function template_form($action = '', $id = NULL, $name = '', $description = '', $template = '', $message = '') {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

?>
<?php
if ($message != '') {
	echo '<div class="error">'.$message.'<br /></div>';
}
?>
<form action="template.php" method="post">

<table cellpadding="0" align="center">

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
Description :
</td>
<td class="left">
<input type="text" name="description" value="<?php echo $description; ?>" size="30" maxlength="255" />
</td>

</tr>

<tr>

<tr>

<td class="topright">
Template :
</td>
<td class="left">
<textarea name="template" rows="15" cols="90" maxlength="2048"><?php echo htmlspecialchars($template); ?></textarea>
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
<hr align="center" width="50%" />
<br />
<table border="5">
<tr><td colspan="3">
Along with template variables you have created you can use these <i>variables</i> in your template, which will be replaced with data you have entered for individual blogs, and also this template:-<br />
<br />
</td></tr>
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
<?php
if (isset($id)) {
?>
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<?php
}
?>
</form>
<?php
} //end function template_form($action = '', $id = NULL, $name = '', $description = '', $template = '', $message = '')

/*
list_templates()

List Blog Data records
*/
function list_templates() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$result = db_multirec_read_all_templates();
	debug_msg ("Query Result: $result",5);

	$num_records = count($result);
	debug_msg ("Number of records: $num_records",4);

	if ($num_records > 0) {
		html_header("List Templates");
?>
<div align="center">
<h1>Template Data</h1>
<br />
<table width="100%" cellpadding="0" align="center">
<tr>
<th colspan="2" class="list"></th>		<!-- Edit/Delete -->
<th class="list">Name</th>					<!-- Name -->
<th class="list">Description</th>		<!-- Description -->
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
<a href="template.php?action=edit&amp;id=<?php echo $row['id']; ?>" onmouseover="window.status='Edit';return true" onmouseout="window.status='';return true"><img src="images/edit.png" alt="Edit" border="0" /></a>
&nbsp;
</td>
<td class="center-list">
&nbsp;
<a href="template.php?action=delete&amp;id=<?php echo $row['id']; ?>" onmouseover="window.status='Delete';return true" onmouseout="window.status='';return true"><img src="images/delete.png" alt="Delete" border="0" /></a>
&nbsp;
</td>
<td class="left-list">
<?php echo $row['name']; ?>
</td>
<td class="left-list">
<?php echo $row['description']; ?>
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
<a href="template.php?action=add" onmouseover="window.status='Add a new template';return true" onmouseout="window.status='';return true"><img src="images/add.png" alt="Add" border="0" /> Add new template</a>
</td>
</tr>
</table>
</div>
<?php
	}
	html_footer();
} // end function list_blogs()

/*
template_display()

Forms based data entry for Blog Data
*/
function template_display($id = '', $name = '', $description = '', $template = '', $message = '') {
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
Description :
</td>
<td class="left">
<?php echo $description; ?>
</td>

</tr>

<tr>

<tr>

<td class="topright">
Template :
</td>
<td class="left">
<?php echo nl2br($template); ?>
</td>

</tr>


</table>
<?php
} //end function template_display($id = '', $name = '', $description = '', $template = '', $message = '')


?>
