<?php
/*
templatevars.php

S9Y_Conf Template Variables Data display/edit

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
		templatevars_add();
		break;

	case 'edit':
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			templatevars_edit($id);
		}
		break;

	case 'delete':
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			templatevars_delete($id);
		}
		break;

	case 'deleterecord':
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			templatevars_deleterecord($id);
		}
		break;

	case 'insert':
		templatevars_insert();
		break;

	case 'update':
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			templatevars_update($id);
		}
		break;

	default :
		list_templatevars();
		break;

} //end switch

exit(0);


/*
templatevars_deleterecord($id = '')

Delete a Template Variables Data record (no recovery)
*/
function templatevars_deleterecord($id = '') {
	debug_msg ("FUNCTION: ".__FUNCTION__,4);

	db_delete_templatevars($id);

	// If no headers are sent, send one
	if (!headers_sent()) {
		header("Location: http://" . $_SERVER['HTTP_HOST']
                      . dirname($_SERVER['PHP_SELF'])
                      . "/templatevars.php");
	    exit;
	}
} // end function templatevars_deleterecord($id = '')


/*
templatevars_delete($id = '')

Delete a Template Variables Data record (last chance)
*/
function templatevars_delete($id = '') {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	html_header("Delete Template Variables Data");

	$result = db_read_templatevars($id);

	$name = $result['name'];
	$value=$result['value'];

?>
<div align="center">
<h1>Delete Template Variable</h1>
<br />

<?php
	templatevars_display($id, $name, $value);
?>
<br />
<br />
Really DELETE this record ?
<br />
<form action="templatevars.php" method="post">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<button name="action" value="deleterecord" type="submit">Yes</button>
<button name="action" value="back" type="submit">No</button>
</form>
</div>
<?php
	html_footer();

} // end function templatevars_delete($id = '')


/*
templatevars_update($id = '')

Update a Blog Data record
*/
function templatevars_update($id = '') {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$name = '';
	$value = '';
	
	if ($_POST['name']) {
		$name = strtoupper(trim($_POST['name']));
	}
	if ($_POST['value']) {
		$value = trim($_POST['value']);
	}

	debug_msg('NAME: '.$name, 5);
	debug_msg('VALUE: '.$value, 5);
	if (($name == '') || ($value == '') || (array_search($name, array(	'NOW', 'S9YCONF', 'BLOGID',
																							'BLOGNAME', 'BLOGPATH',
																							'BLOGUSER', 'BLOGURL',
																							'TPLID', 'TPLNAME', 'TPLDESC')
														) !== FALSE)) {
		html_header("Edit Template Variable Data");
?>
<div align="center">
<h1>Edit Template Variable</h1>
<br />
<?php
		if ($name == '') {
			templatevars_form('update', $id, $name, $value, 'No name entered for this template variable');
		}elseif ($value == '') {
			templatevars_form('update', $id, $name, $value, 'No value entered for this template variable');
		}elseif (array_search($name, array(	'NOW', 'S9YCONF', 'BLOGID', 'BLOGNAME', 'BLOGPATH',
														'BLOGUSER', 'BLOGURL', 'TPLID', 'TPLNAME', 'TPLDESC')
														) !== FALSE) {
			templatevars_form('update', $id, $name, $value, 'The name entered is reserved by this program');
		}
?>
</div>

<?php
	html_footer();
	exit();
	}


	$result = db_update_templatevars($id, $name, htmlspecialchars($value));


	// SQL Error inserting record
	if ($result == '') {
		html_header("Edit Template Variable Data");
?>
<div align="center">
<h1>Edit Template Variable</h1>
<br />
<?php
		templatevars_form('update', $id, $name, $value, 'The variable '.$name.' already exists!');
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
                      . "/templatevars.php");
	    exit;
	}
} //end function templatevars_update($id = '')


/*
templatevars_insert()

Update a Blog Data record
*/
function templatevars_insert() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$name = '';
	$value = '';
	
	if ($_POST['name']) {
		$name = strtoupper(trim($_POST['name']));
	}
	if ($_POST['value']) {
		$value = trim($_POST['value']);
	}

	debug_msg('NAME: "'.$name.'"', 5);
	debug_msg('VALUE: "'.$value.'"', 5);
	if (($name == '') || ($value == '') || (array_search($name, array(	'NOW', 'S9YCONF', 'BLOGID',
																							'BLOGNAME', 'BLOGPATH',
																							'BLOGUSER', 'BLOGURL',
																							'TPLID', 'TPLNAME', 'TPLDESC')
														) !== FALSE)) {
		html_header("Add Template Variable Data");
?>
<div align="center">
<h1>Add Template Variable</h1>
<br />
<?php
		if ($name == '') {
			templatevars_form('insert', '', $name, $value, 'No name entered for this template variable');
		}elseif ($value == '') {
			templatevars_form('insert', '', $name, $value, 'No description entered for this template variable');
		}elseif (array_search($name, array(	'NOW', 'S9YCONF', 'BLOGID', 'BLOGNAME', 'BLOGPATH',
														'BLOGUSER', 'BLOGURL', 'TPLID', 'TPLNAME', 'TPLDESC')
														) !== FALSE) {
			templatevars_form('insert', '', $name, $value, 'The name entered is reserved by this program');
		}
?>
</div>

<?php
	html_footer();
	exit();
	}

	$result = db_insert_templatevars($name, htmlspecialchars($value));

	// SQL Error inserting record
	if ($result == '') {
		html_header("Add Template Variable Data");
?>
<div align="center">
<h1>Add Template Variable</h1>
<br />
<?php
//		templatevars_form('insert', '', $name, $value, mysql_error(S9YCONF_MYSQL_CONNECTION));
		templatevars_form('insert', '', $name, $value, 'The variable '.$name.' already exists!');
?>
</div>

<?php
	exit();
	}

	// If no headers are sent, send one
	if (!headers_sent()) {
		header("Location: http://" . $_SERVER['HTTP_HOST']
                      . dirname($_SERVER['PHP_SELF'])
                      . "/templatevars.php");
	    exit;
	}
} // end function templatevars_insert($id = '')


/*
templatevars_add()

Add a Template Data record
*/
function templatevars_add() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	html_header("Add Template Data");

	$id = '';
	$name = '';
	$value='';

?>
<div align="center">
<h1>Add Template Variable</h1>
<br />
<?php
	templatevars_form('insert', NULL, $name, $value);
?>
</div>

<?php
	html_footer();
} // end function templatevars_add()

/*
templatevars_edit()

Edit a Blog Data record
*/
function templatevars_edit($id) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	html_header("Edit Template Variables Data");

	$result = db_read_templatevars($id);

	$name = $result['name'];
	$value=html_entity_decode($result['value']);

?>
<div align="center">
<h1>Edit Template Variable</h1>
<br />

<?php
	templatevars_form('update', $id, $name, $value);
?>
</div>
<?php
	html_footer();
} // end function templatevars_edit($id)


/*
templatevars_form($action = "save")

Forms based data entry for Blog Data
*/
function templatevars_form($action = '', $id = NULL, $name = '', $value = '', $message = '') {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

?>
<?php
if ($message != '') {
	echo '<div class="error">'.$message.'<br /></div>';
}
?>
<form action="templatevars.php" method="post">

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
Value :
</td>
<td class="left">
<input type="text" name="value" value="<?php echo htmlspecialchars($value); ?>" size="30" maxlength="255" />
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
if (isset($id)) {
?>
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<?php
}
?>
</form>
<?php
} //end function templatevars_form($action = '', $id = NULL, $name = '', $value = '', $message = '')

/*
list_templatevars()

List Template Variables Data records
*/
function list_templatevars() {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$result = db_multirec_read_all_templatevars();
	debug_msg ("Query Result: $result",5);

	$num_records = count($result);
	debug_msg ("Number of records: $num_records",4);

	if ($num_records > 0) {
		html_header("List Templates Variables");
?>
<div align="center">
<h1>Template Variables Data</h1>
<br />
<table width="100%" cellpadding="0" align="center">
<tr>
<th colspan="2" class="list"></th>		<!-- Edit/Delete -->
<th class="list">Name</th>					<!-- Name -->
<th class="list">Value</th>				<!-- Value -->
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
<a href="templatevars.php?action=edit&amp;id=<?php echo $row['id']; ?>" onmouseover="window.status='Edit';return true" onmouseout="window.status='';return true"><img src="images/edit.png" alt="Edit" border="0" /></a>
&nbsp;
</td>
<td class="center-list">
&nbsp;
<a href="templatevars.php?action=delete&amp;id=<?php echo $row['id']; ?>" onmouseover="window.status='Delete';return true" onmouseout="window.status='';return true"><img src="images/delete.png" alt="Delete" border="0" /></a>
&nbsp;
</td>
<td class="left-list">
<?php echo $row['name']; ?>
</td>
<td class="left-list">
<?php echo $row['value']; ?>
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
<a href="templatevars.php?action=add" onmouseover="window.status='Add a new template';return true" onmouseout="window.status='';return true"><img src="images/add.png" alt="Add" border="0" /> Add new template variable</a>
</td>
</tr>
</table>
</div>
<?php
	}
	html_footer();
} // end function list_blogs()

/*
templatevars_display()

Forms based data entry for Blog Data
*/
function templatevars_display($id = '', $name = '', $value = '', $message = '') {
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
Value :
</td>
<td class="left">
<?php echo $value; ?>
</td>

</tr>

</table>
<?php
} //end function templatevars_display($id = '', $name = '', $value = '')


?>
