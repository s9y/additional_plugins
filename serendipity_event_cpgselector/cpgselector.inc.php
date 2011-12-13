<?php


function cpg_init(){

	global $CPG;
	global $serendipity;

	if (isset($_POST['CPG_POST'])) $CPG['post'] = $_POST['CPG_POST'];

	$params = array('album','page','textarea','step','sortorder','image','adminModule','htmltarget','filename_only');

	foreach ($params as $p){

		if (isset($CPG['post'][$p])) $CPG[$p] = $CPG['post'][$p];
		elseif (isset($CPG['get'][$p])) $CPG[$p] = $CPG['get'][$p];

	}

}


function cpg_end($db){

	global $serendipity;

	if (!isset($db)) return;

	mysql_close($db);

	$serendipity['dbConn'] = mysql_connect($serendipity['dbHost'], $serendipity['dbUser'], $serendipity['dbPass']);
	mysql_select_db($serendipity['dbName']);

}


function cpg_start(){

	global $CPG;

	$db = mysql_connect($CPG['server'], $CPG['user'], $CPG['password']);

	if (!$db) {
		echo 'Unable to connect to the database server<br>';
		return NULL;
	}

	if (! @mysql_select_db($CPG['database'],$db) ) {
		echo 'Unable to locate the picture database<br>';
		mysql_close($DB);
		return NULL;
	}

	return $db;


}


function cpg_canConnect(){

	if (!($db = cpg_start())){
		echo 'Failed to connect to CPG<br>';
		return;
	}

	echo 'Connected to CPG successfully<br>';

	cpg_end($db);

}


function truncate($str,$len = 0){

	if ($len <= 0) return $str;

	if (strlen($str) > $len) return (substr($str,0,$len) . '...');
	else return $str;

}


function cpg_displayImageList($page = 0, $lineBreak = NULL, $manage = false, $url = NULL){

	global $serendipity;
	global $CPG;

	$album = (isset($CPG['album'])) ? $CPG['album'] : NULL;

	if ($album == -1) $album = NULL;

	$sort_row_interval = array(8, 16, 50, 100);
	$sort_order = array('ctime' => 'Date', 'owner_id' => 'Owner', 'pid' => 'ID');

	$perPage = (isset($CPG['sortorder']['perpage']) ? $CPG['sortorder']['perpage'] : $sort_row_interval[1]);
	$start = ($page-1)*$perPage;

	$order = 'ctime DESC';
	if (isset($CPG['sortorder']['order']) && isset($CPG['sortorder']['order']))
		$order = $CPG['sortorder']['order'] . ' ' . $CPG['sortorder']['ordermode'];

	$images = cpg_getImages($totalImages, $start, $perPage, $album, $order, $serendipity['thumbSize']);
	$albums = cpg_getAlbums();

	$extraParams = '';

    $importParams = array('adminModule', 'htmltarget', 'filename_only', 'textarea');
    foreach($importParams AS $importParam) {
        if (isset($CPG[$importParam])) {
            $extraParams .= $importParam . '='. $CPG[$importParam] .'&amp;';
        }
    }

    if (isset($CPG['only_path']) && !empty($CPG['only_path']) ) {
        $extraParams .= 'only_path='. $CPG['only_path'] .'&amp;';
        serendipity_uploadSecure($CPG['only_path'], true);
    }

    foreach ( (array)$CPG['sortorder'] as $k => $v ) {
        $extraParams .= 'sortorder['. $k .']='. $v .'&amp;';
    }

    $extraParams .= 'album='.((isset($album))?$album:-1).'&amp;';

    if (is_null($lineBreak)) {
        $lineBreak = floor(750 / ($serendipity['thumbSize'] + 20));
    }

    $link = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/plugin/' . CPG_EVENT . '&amp;';

    $left  = '<input type="button" value="&lt;&lt;&lt;" onclick="location.href=\'' . $link . $extraParams .'page=' . ($page-1) . '\';" '. (($start <= 0) ? 'disabled' : '') .'>' . "\n";
    $right = '<input type="button" value="&gt;&gt;&gt;" onclick="location.href=\'' . $link . $extraParams .'page=' . ($page+1) . '\';" '. (($totalImages <= $start+$perPage) ? 'disabled' : '') .'>' . "\n";

//    $left  = '<input type="button" value="&lt;&lt;&lt;" onclick="location.href=\'?/plugin/' . CPG_EVENT . '&'. $extraParams .'page=' . ($page-1) . '\';" '. (($start <= 0) ? 'disabled' : '') .'>' . "\n";
//    $right = '<input type="button" value="&gt;&gt;&gt;" onclick="location.href=\'?/plugin/' . CPG_EVENT . '&'. $extraParams .'page=' . ($page+1) . '\';" '. (($totalImages <= $start+$perPage) ? 'disabled' : '') .'>' . "\n";

?>

<style type="text/css">
<!--

.cpg_thumbnail_block {

	padding-bottom: 10px;

}

.cpg_thumbnail {

	border: 0;
	text-align: center;
	height: <?php echo $serendipity['thumbSize']; ?>px;
	width: <?php echo $serendipity['thumbSize']; ?>px;
	background-color: #D6EFD1;
	vertical-align: middle;


}

.cpg_data {

	border: 0;
	text-align: center;
	width: <?php echo $serendipity['thumbSize']; ?>px;
	text-align: left;
	font-size: 9px;
	color: #669966;


}

.cpg_option {
	text-align: right;
	font-size: 10px;
	font-weight: bold;
	color: #FFFFFF;
}


.cpg_title {
	font-size: 14px;
	font-weight: bold;
	padding: 5px;
	color: #669966;
	background-color: #D6EFD1;
}


.cpg_table {

	background-color: #669966;
	margin: 0;
}


.cpg_body {

	margin: 0;
	background-color: #FFFFFF;

}

-->
</style>

<form style="display: inline; margin: 0px; padding: 0px;" method="post" action="<?php echo $link; ?>">
<?php
    foreach($CPG['get'] AS $g_key => $g_val) {
        if ( !is_array($g_val) && $g_key != 'page' ) {
            echo '<input type="hidden" name="CPG_POST[' . $g_key . ']" value="' . htmlspecialchars($g_val) . '" />';
        }
    }
?>
    <table class="cpg_table" cellspacing="0" width="100%" border="0">
        <tr>
            <td colspan="9"><div class="cpg_title"><?php echo PLUGIN_CPG_TITLE; ?></div></td>
        </tr>
        <tr>
            <td><div class="cpg_option">Album</div></td>
            <td><select name="CPG_POST[album]">
                    <option value="-1">All Albums</option>

<?php
foreach ($albums as $alb){
	echo '<option value="' . $alb['aid'] . '"';
	if ($alb['aid'] == $album) echo " selected";
	echo '>' . $alb['title'] . '</option>';
}
?>

                </select>
            </td>
            <td><div class="cpg_option"><?php echo SORT_BY ?></div></td>
            <td><select name="CPG_POST[sortorder][order]">
<?php
        foreach($sort_order AS $so_key => $so_val) {
            echo '<option value="' . $so_key . '" ' . (isset($CPG['sortorder']['order']) && $CPG['sortorder']['order'] == $so_key ? 'selected="selected"' : '') . '>' . $so_val . '</option>';
        }
?>              </select>
</td>
            <td><div class="cpg_option"><?php echo SORT_ORDER ?></div></td>
            <td><select name="CPG_POST[sortorder][ordermode]">
                    <option value="DESC" <?php echo (isset($CPG['sortorder']['ordermode']) && $CPG['sortorder']['ordermode'] == 'DESC' ? 'selected="selected"' : '') ?>><?php echo SORT_ORDER_DESC ?></option>
                    <option value="ASC"  <?php echo (isset($CPG['sortorder']['ordermode']) && $CPG['sortorder']['ordermode'] == 'ASC'  ? 'selected="selected"' : '') ?>><?php echo SORT_ORDER_ASC  ?></option>
                </select>
            </td>
		<td><div class="cpg_option"><?php echo FILES_PER_PAGE ?></div></td>
		<td><select name="CPG_POST[sortorder][perpage]">
<?php
        foreach($sort_row_interval AS $so_val) {
            echo '<option value="' . $so_val . '" ' . ($perPage == $so_val ? 'selected="selected"' : '') . '>' . $so_val . '</option>';
        }
?>              </select>
		</td>
            <td align="right">
                <input type="submit" name="go" value=" - <?php echo GO ?> - " />
            </td>
        </tr>
</table>
</form>
<table border="0" width="100%">
    <tr>
        <td colspan="<?php echo floor($lineBreak); ?>">
            <table width="100%">
                <tr>
                    <td><?php echo $left; ?></td>
                    <td align="right"><?php echo $right; ?></td>
                </tr>
            </table>
        </td>
    </tr>



    <tr>

<?php

        $x = 0;
        foreach ($images as $image) {

            ++$x;


?>
                <td nowrap="nowrap" align="center" valign="bottom" <?php echo ($manage) ? 'style="border-bottom: 1px solid #000000"' : '' ?>>
				<div class="cpg_thumbnail_block">
<?php
            if (isset($url)) echo '<a href="' . $url . '&amp;image='. $image['id'] . '">';
            echo '<div class="cpg_thumbnail">' . $image['thumbnail'] . '</div>';
            if (isset($url)) echo '</a>';
            echo '<div class="cpg_data">' . truncate($image['file'],16) . '</div>';
            echo '<div class="cpg_data">' . $image['owner'] . '</div>';
            echo '<div class="cpg_data">' . date('d/m/y',$image['date']) . '</div>';

?>
				</div>
                </td>

<?php
        // Newline?
        if ($x % $lineBreak == 0) {
?>
    </tr>
    <tr>
<?php
        }
    }
?>
    </tr>

    <tr>
        <td colspan="<?php echo floor($lineBreak); ?>">
            <table width="100%">
                <tr>
                    <td><?php echo $left; ?></td>
                    <td align="right"><?php echo $right; ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php

}



function cpg_getImages(&$totalImages, $first = 0, $count = 10, $album = NULL, $order = 'ctime DESC', $iconSize = 80){

	global $CPG;

	$images = array();

	if (!($db = cpg_start())){
		echo 'Failed to connect to CPG<br>';
		return NULL;
	}

	$where = '';
	if (isset($album)) $where = 'WHERE aid = ' . $album;

	$query = "SELECT count(*) FROM " . $CPG['prefix'] . "pictures {$where}";

	$result = @mysql_query($query,$db);
	if (!$result){
		echo 'Error performing query: ' . mysql_error() . '<br>';
		cpg_end($db);
		return NULL;
	}
	$row = mysql_fetch_array($result);
	$totalImages = $row[0];

	$query = "SELECT * FROM " . $CPG['prefix'] . "pictures {$where} ORDER BY {$order} LIMIT {$first}, {$count}";

	$result = @mysql_query($query,$db);
	if (!$result){
		echo 'Error performing query: ' . mysql_error() . '<br>';
		cpg_end($db);
		return NULL;
	}

	while ($row = mysql_fetch_array($result)){

		$image = array();

		$image['aid'] = $row['aid'];
		$image['id'] = $row['pid'];

		$image['width'] = $row['pwidth'];
		$image['height'] = $row['pheight'];

		$image['owner'] = $row['owner_name'];
		$image['date'] = $row['ctime'];

		$image['file'] = $row['filename'];
		$image['path'] = $row['filepath'];

        if ((int)$image['width'] > 0 && (int)$image['height'] > 0) {
		    $aspect = $image['width'] / $image['height'];
		} else {
		    $aspect = 1;
		}

		if ($aspect >= 1){
			$image['iconWidth'] = $iconSize;
			$image['iconHeight'] = floor($iconSize / $aspect);
		} else {
			$image['iconWidth'] = floor($iconSize * $aspect);
			$image['iconHeight'] = $iconSize;
		}

		$image['link'] = $CPG['path'] . 'displayimage.php?album=' . $image['aid'] . '&pos=-' . $image['id'];
		$image['thumbnail'] = '<img src="' . $CPG['path'] . 'albums/' . $image['path'] . 'thumb_' . $image['file'] . '" alt="' . $image['file'] . '" border="0" width="' . $image['iconWidth'] . '" height="' . $image['iconHeight'] . '">';

		$images[] = $image;

	}

	cpg_end($db);

	return $images;

}


function cpg_getImage($id){

	global $serendipity;
	global $CPG;

	$iconSize = $serendipity['thumbSize'];

	if (!($db = cpg_start())){
		echo 'Failed to connect to CPG<br>';
		return NULL;
	}

	$query = "SELECT * FROM " . $CPG['prefix'] . "pictures WHERE pid = {$id}";

	$result = @mysql_query($query,$db);
	if (!$result){
		echo 'Error performing query: ' . mysql_error() . '<br>';
		cpg_end($db);
		return NULL;
	}

	if (!($row = mysql_fetch_array($result))){
		echo 'Error: image not found (' . $id . ')<br>';
		cpg_end($db);
		return NULL;
	}

	cpg_end($db);

	$image = array();

	$image['aid'] = $row['aid'];
	$image['id'] = $row['pid'];

	$image['width'] = $row['pwidth'];
	$image['height'] = $row['pheight'];

	$image['owner'] = $row['owner_name'];
	$image['date'] = $row['ctime'];

	$image['filename'] = $row['filename'];


	$aspect = $image['width'] / $image['height'];

	if ($aspect >= 1){
		$image['iconWidth'] = $iconSize;
		$image['iconHeight'] = floor($iconSize / $aspect);
	} else {
		$image['iconWidth'] = floor($iconSize * $aspect);
		$image['iconHeight'] = $iconSize;
	}

	if ($CPG['maxwidth'] && is_numeric($CPG['maxwidth']) && (int)$CPG['maxwidth'] > 0 && (int)$image['width'] > (int)$CPG['maxwidth']) {
		$image['width'] = $CPG['maxwidth'];
		$image['height'] = floor($CPG['maxwidth'] / $aspect);
	}

	if ($CPG['maxheight'] && is_numeric($CPG['maxheight']) && (int)$CPG['maxheight'] > 0 && (int)$image['width'] > (int)$CPG['maxheight']) {
		$image['width'] = floor($CPG['maxheight'] * $aspect);
		$image['height'] = $CPG['maxheight'];
	}

	if ($CPG['usenormal'] == 'true') {
		$image['file'] = $CPG['path'] . 'albums/' . $row['filepath']. 'normal_' . $row['filename'];
	} else {
		$image['file'] = $CPG['path'] . 'albums/' . $row['filepath']. $row['filename'];
	}
	$image['thumbnail'] = $CPG['path'] . 'albums/' . $row['filepath'] . 'thumb_' . $row['filename'];
	$image['link'] = $CPG['path'] . 'displayimage.php?pos=-' . $image['id'];

	return $image;

}


function cpg_getAlbums(){

	global $CPG;

	$albums = array();

	if (!($db = cpg_start())){
		echo 'Failed to connect to CPG<br>';
		return NULL;
	}

	$query = "SELECT aid,title,description,category FROM " . $CPG['prefix'] . "albums ORDER BY title ASC";

	$result = @mysql_query($query,$db);
	if (!$result){
		echo 'Error performing query: ' . mysql_error() . '<br>';
		cpg_end($db);
		return NULL;
	}

	while ($row = mysql_fetch_array($result)) $albums[] = $row;

	cpg_end($db);

	return $albums;

}


function cpg_window(){

	global $CPG;
	global $serendipity;

	cpg_init();

?>

<html>
	<head>
		<title><?php echo SELECT_FILE; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo LANG_CHARSET; ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo $serendipity['serendipityHTTPPath']; ?>serendipity.css.php">
	</head>
<body class="cpg_body" id="serendipity_admin_image_page">


<?php
switch ($CPG['step']) {
	case '1':

		$image = cpg_getImage($CPG['image']);

?>
<script type="text/javascript" language="JavaScript" src="<?php echo $serendipity['serendipityHTTPPath']; ?>serendipity_define.js.php"></script>
<script type="text/javascript" language="Javascript">
<!--

function cpg_imageSelector_done(textarea)
{
	var insert = '';
	var img = '';
	var src = '';
	var f = document.forms['cpgSelForm'].elements;

	if (f['linkThumbnail'][0].checked == true) {
		img       = f['thumbName'].value;
		imgWidth  = f['imgThumbWidth'].value;
		imgHeight = f['imgThumbHeight'].value;
	} else {
		img       = f['imgName'].value;
		imgWidth  = f['imgWidth'].value;
		imgHeight = f['imgHeight'].value;
	}

	if (f['filename_only'] && f['filename_only'].value == 'true') {
		self.opener.serendipity_imageSelector_addToElement(img, f['htmltarget'].value);
		self.close();
		return true;
	}

	if (document.getElementById('serendipity_imagecomment').value != '') {
		styled = false;
	} else {
		styled = true;
	}

	floating = 'center';
	if (f['align'][0].checked == true) {
		img = "<img width='" + imgWidth + "' height='" + imgHeight + "' " + (styled ? 'style="border: 0px; padding-left: 5px; padding-right: 5px;"' : '') + ' src="' + img + "\" alt=\"\" />";
	} else if (f['align'][1].checked == true) {
		img = "<img width='" + imgWidth + "' height='" + imgHeight + "' " + (styled ? 'style="float: left; border: 0px; padding-left: 5px; padding-right: 5px;"' : '') + ' src="' + img + "\" alt=\"\" />";
		floating = 'left';
	} else if (f['align'][2].checked == true) {
		img = "<img width='" + imgWidth + "' height='" + imgHeight + "' " + (styled ? 'style="float: right; border: 0px; padding-left: 5px; padding-right: 5px;"' : '') + ' src="' + img + "\" alt=\"\" />";
		floating = 'right';
	}

	if (f['isLink'][1].checked == true) {
		if (f['cpg_noraw'].checked == true){
			insert = "<a href='" + f['cpg_link'].value + "'>" + img + "</a>";
		} else {
			insert = "<a href='" + f['url'].value + "'>" + img + "</a>";
		}
	} else {
		insert = img;
	}

	if (document.getElementById('serendipity_imagecomment').value != '') {
		comment = f['imagecomment'].value;
		block = '<div class="serendipity_imageComment_' + floating + '" style="width: ' + imgWidth + 'px">'
			  +     '<div class="serendipity_imageComment_img">' + insert + '</div>'
			  +     '<div class="serendipity_imageComment_txt">' + comment + '</div>'
			  + '</div>';
	} else {
//		block = '<div class="serendipity_imageComment_img">' + insert + '</div>';
		block = '<div class="serendipity_imageNoComment_' + floating + '" style="width: ' + imgWidth + 'px">'
			  +     '<div class="serendipity_imageComment_img">' + insert + '</div>'
			  + '</div>';
	}

	if (self.opener.editorref) {
		self.opener.editorref.surroundHTML(block, '');
	} else {
		self.opener.serendipity_imageSelector_addToBody(block, textarea);
	}

	self.close();
}
//-->
</script>

<div>
<?php if (isset($image)) {?>
	<img align="right" src="<?php echo $image['thumbnail']; ?>">
	<h1><?php printf(YOU_CHOSE, $image['filename']); ?></h1>
	<p>
		<form action="#" method="GET" name="cpgSelForm" onSubmit="serendipity_imageSelector_done()">
			<div>
				<input type="hidden" name="imgThumbWidth"  value="<?php echo $image['iconWidth']; ?>" />
				<input type="hidden" name="imgThumbHeight" value="<?php echo $image['iconHeight']; ?>" />
				<input type="hidden" name="imgWidth"  value="<?php echo $image['width']; ?>" />
				<input type="hidden" name="imgHeight" value="<?php echo $image['height']; ?>" />
				<input type="hidden" name="imgName"   value="<?php echo $image['file']; ?>" />
				<input type="hidden" name="thumbName" value="<?php echo $image['thumbnail']; ?>" />
				<input type="hidden" name="cpg_link" value="<?php echo $image['link']; ?>" />
				<?php if (!empty($CPG['htmltarget'])) { ?>
				<input type="hidden" name="htmltarget" value="<?php echo htmlspecialchars($CPG['htmltarget']); ?>" />
				<?php } ?>
				<?php if (!empty($CPG['filename_only'])) { ?>
				<input type="hidden" name="filename_only" value="<?php echo htmlspecialchars($CPG['filename_only']); ?>" />
				<?php } ?>

				<b><?php echo IMAGE_SIZE; ?>:</b>
				<br />
				<input id="radio_link_no" type="radio" name="linkThumbnail" value="no" checked="checked" /><label for="radio_link_no"><?php echo I_WANT_THUMB; ?></label><br />
				<input id="radio_link_yes" type="radio" name="linkThumbnail" value="yes" /><label for="radio_link_yes"><?php echo I_WANT_BIG_IMAGE; ?></label><br />
				<br />

				<?php if (empty($CPG['filename_only']) || $CPG['filename_only'] != 'true') { ?>
				<b><?php echo IMAGE_ALIGNMENT; ?>:</b>
				<br />
				<input type="radio" name="align" value="" />                       <img src="<?php echo serendipity_getTemplateFile('img/img_align_top.png') ?>"   vspace="5" /><br />
				<input type="radio" name="align" value="left" checked="checked" /> <img src="<?php echo serendipity_getTemplateFile('img/img_align_left.png') ?>"  vspace="5" /><br />
				<input type="radio" name="align" value="right" />                  <img src="<?php echo serendipity_getTemplateFile('img/img_align_right.png') ?>" vspace="5" /><br />
				<br />

				<b><?php echo IMAGE_AS_A_LINK; ?>:</b>
				<br />
				<input id="radio_islink_yes" type="radio" name="isLink" /><label for="radio_islink_yes"> <?php echo I_WANT_NO_LINK; ?></label><br />
				<input id="radio_islink_no"  type="radio" name="isLink" checked="checked" /><label for="radio_islink_no"> <?php echo I_WANT_IT_TO_LINK; ?></label>
					<input type="text"  name="url" size="30" value="<?php echo $image['file']; ?>" onfocus="value='';" /><br />
				<br />

				<b>Coppermine options:</b>
				<br />
				<input id="cpg_noraw" name="cpg_noraw" type="checkbox" value="checkbox" checked><label for="radio_islink_yes"> Link to gallery (not raw image)</label><br />
				<br />

				<b><?php echo COMMENT; ?>:</b>
				<br />
				<textarea id="serendipity_imagecomment" name="imagecomment" rows="5" cols="40"></textarea>
				<br />
				<?php } ?>

				<input type="button" value="<?php echo BACK; ?>" onclick="history.go(-1);" />
				<input type="button" value="<?php echo DONE; ?>" onclick="cpg_imageSelector_done('<?php echo $CPG['textarea'] ?>')" />
			</div>
		</form>
	</p>
<?php
	} else {
		// What to do if file is no image.
		// For the future, maybe allow the user to add title/link description and target window

		if (!empty($CPG['filename_only'])) {
?>
	<script type="text/javascript">
		self.opener.serendipity_imageSelector_addToElement('<?php echo htmlspecialchars($imgName); ?>', '<?php echo htmlspecialchars($CPG['htmltarget']); ?>');
		self.close();
	</script>
<?php
		} else {
?>
	<script type="text/javascript">
	block = '<a href="<?php echo htmlspecialchars($imgName); ?>" title="<?php echo htmlspecialchars($file['name'] . '.' . $file['extension']); ?>" target="_blank"><?php echo htmlspecialchars($file['name'] . '.' . $file['extension']); ?></a>';
	if (self.opener.editorref) {
		self.opener.editorref.surroundHTML(block, '');
	} else {
		self.opener.serendipity_imageSelector_addToBody(block, '<?php echo $CPG['post']['textarea']; ?>');
	}
	self.close();
	</script>
<?php
		}
	}
	break;

	default:
		$add_url = '';
		if (!empty($CPG['htmltarget'])) {
			$add_url .= '&amp;htmltarget=' . $CPG['htmltarget'];
		}

		if (!empty($CPG['filename_only'])) {
			$add_url .= '&amp;filename_only=' . $CPG['filename_only'];
		}
?>

	<?php

        $link = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/plugin/' . CPG_EVENT . '&amp;';

		cpg_displayImageList(
		  isset($CPG['page'])   ? $CPG['page']   : 1,
		  4,
		  false,
		  $link . 'step=1' . $add_url . '&amp;textarea='. $CPG['textarea']
		);


}
?>

</body>
</html>

<?php


}

