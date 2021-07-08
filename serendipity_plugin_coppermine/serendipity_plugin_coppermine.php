<?php

// A plug-in for the Serendipity PHP blog (http://www.s9y.org) by Matthew Maude <s9y@risingdawn.org>
// Show recent/popular/random thumbnails from a Coppermine (http://coppermine.sourceforge.net) gallery


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_coppermine extends serendipity_plugin
{

    var $title = PLUGIN_CPGS_NAME;

	function introspect(&$propbag)
	{
		global $serendipity;

		$propbag->add('name',PLUGIN_CPGS_NAME);
		$propbag->add('description',PLUGIN_CPGS_DESC);

        $propbag->add('stackable',     true);
        $propbag->add('author',        'Matthew Maude');
        $propbag->add('version',       '1.4');
        $propbag->add('requirements',  array('serendipity' => '0.8'));
        $propbag->add('groups', array('IMAGES'));
		$propbag->add('configuration', array('cm_server','cm_prefix','cm_path','cm_title','cm_db','cm_user','cm_pass','cm_size','cm_count','cm_type','cm_plugin_title','cm_albumlink','cm_album','cm_gallerypath','cm_resolve'));

		return true;

	}

	function introspect_config_item($name, &$propbag){

		switch($name) {

		case 'cm_resolve':
			$propbag->add('type',        'boolean');
			$propbag->add('name',        PLUGIN_CPGS_THUMB_NAME);
			$propbag->add('description', PLUGIN_CPGS_THUMB_DESC);
			$propbag->add('default',     'true');
			break;

		case 'cm_type':
			$propbag->add('type', 'radio');
			$propbag->add('name', PLUGIN_CPGS_TYPE_NAME);
			$propbag->add('description', PLUGIN_CPGS_TYPE_DESC);
			$propbag->add('radio',  array(
				'value' => array('recent', 'random', 'popular'),
				'desc'  => array(PLUGIN_CPGS_RECENT, PLUGIN_CPGS_RANDOM, PLUGIN_CPGS_POPULAR)
				));
			$propbag->add('default', 'recent');
			break;

		case 'cm_plugin_title':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPGS_TITLE_NAME);
			$propbag->add('description', PLUGIN_CPGS_TITLE_DESC);
			$propbag->add('default', 'My Images');
			break;


		case 'cm_server':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPGS_SERVER_NAME);
			$propbag->add('description', PLUGIN_CPGS_SERVER_DESC);
			$propbag->add('default', 'localhost');
			break;

		case 'cm_db':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPGS_DB_NAME);
			$propbag->add('description', PLUGIN_CPGS_DB_DESC);
			$propbag->add('default', 'coppermine');
			break;

		case 'cm_prefix':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPGS_PREFIX_NAME);
			$propbag->add('description', PLUGIN_CPGS_PREFIX_DESC);
			$propbag->add('default', 'cpg132_');
			break;

		case 'cm_user':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPGS_USER_NAME);
			$propbag->add('description', PLUGIN_CPGS_USER_DESC);
			$propbag->add('default', 'username');
			break;

		case 'cm_pass':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPGS_PASSWORD_NAME);
			$propbag->add('description', PLUGIN_CPGS_PASSWORD_DESC);
			$propbag->add('default', 'password');
			break;

		case 'cm_path':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPGS_URL_NAME);
			$propbag->add('description', PLUGIN_CPGS_URL_DESC);
			$propbag->add('default', 'http://gallery.com');
			break;

		case 'cm_gallerypath':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPGS_GALLLINK_NAME);
			$propbag->add('description', PLUGIN_CPGS_GALLLINK_DESC);
			$propbag->add('default', 'http://gallery.com');
			break;

		case 'cm_title':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPGS_GALLNAME_NAME);
			$propbag->add('description', PLUGIN_CPGS_GALLNAME_DESC);
			$propbag->add('default', 'More images...');
			break;

		case 'cm_count':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPGS_COUNT_NAME);
			$propbag->add('description', PLUGIN_CPGS_COUNT_DESC);
			$propbag->add('default', '4');
			break;

		case 'cm_size':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPGS_SIZE_NAME);
			$propbag->add('description', PLUGIN_CPGS_SIZE_DESC);
			$propbag->add('default', '100');
			break;

		case 'cm_album':
			$propbag->add('type', 'string');
			$propbag->add('name', PLUGIN_CPGS_FILTER_NAME);
			$propbag->add('description', PLUGIN_CPGS_FILTER_DESC);
			$propbag->add('default', '');
			break;

		case 'cm_albumlink':
			$propbag->add('type', 'boolean');
			$propbag->add('name', PLUGIN_CPGS_ALBUM_NAME);
			$propbag->add('description', PLUGIN_CPGS_ALBUM_DESC);
			$propbag->add('default', true);
			break;

		default:
			return false;

		}

		return true;

	}

	function generate_content(&$title){

		$title = $this->get_config('cm_plugin_title');

		global $serendipity;

		$dbserver = $this->get_config('cm_server');
		$prefix = $this->get_config('cm_prefix');
		$path = $this->get_config('cm_path');
		$gallerypath = $this->get_config('cm_gallerypath');
		$dbname = $this->get_config('cm_db');
		$dbuser = $this->get_config('cm_user');
		$dbpass = $this->get_config('cm_pass');
		$size = $this->get_config('cm_size');
		$count = $this->get_config('cm_count');
		$gallery = $this->get_config('cm_title');
		$resolve = $this->get_config('cm_resolve');

		$type = $this->get_config('cm_type');
		$cm_title = $this->get_config('cm_plugin_title');

		$album = $this->get_config('cm_album');
		$albumlink = $this->get_config('cm_albumlink');

		$filter = '';


		if (!empty($album)){

			$show = array();
			$hide = array();

			$ids = preg_split('/[\s,]/',$album,-1,PREG_SPLIT_NO_EMPTY);
			foreach ($ids as $id){

				if (preg_match('/^!/',$id) && is_numeric(substr($id,1))){

					$hide[] = substr($id,1);

				} else if (is_numeric($id)){

					$show[] = $id;

				}

			}

			if (count($show) || count($hide)){

				$filter = ' WHERE aid ';

				if (count($show)){
					$filter .= 'IN (';
					$c = 0;
					foreach ($show as $id){
						$filter .= $id;
						if ($c < count($show)-1) $filter .= ',';
						++$c;
					}
					$filter .= ') ';
					if (count($hide)) $filter .= ' AND aid ';
				}

				if (count($hide)){
					$filter .= 'NOT IN (';
					$c = 0;
					foreach ($hide as $id){
						$filter .= $id;
						if ($c < count($hide)-1) $filter .= ',';
						++$c;
					}
					$filter .= ') ';
				}

			}

		}

		switch($type) {

		case 'random':
			$order = 'RAND()';
			break;

		case 'popular':
			$order = 'hits DESC';
			break;

		case 'recent':
		default:
			$order = 'pid DESC';
			break;

		}


		//if ($cm_title != "") $title = $cm_title;


		$DB = @mysql_connect($dbserver, $dbuser, $dbpass);

		if (!$DB) {
			echo 'Unable to connect to the database server<br>';
			return;
		}

		if (! @mysql_select_db($dbname,$DB) ) {
			echo 'Unable to locate the picture database<br>';
			$this->finished($DB);
			return;
		}

		$query = "SELECT * FROM " . $prefix	. "pictures " . $filter . " ORDER BY " . $order . " LIMIT 0," . $count;

		$result = @mysql_query($query,$DB);
		if (!$result){
			echo 'Error performing query: ' . mysql_error() . '<br>';
			$this->finished($DB);
			return;
		}

?>

<style type="text/css">
<!--

<?php

		readfile(dirname(__FILE__).'/styles.css');

?>

-->

</style>

<div class="cm_block">

<?php

		$defthumbnail = $serendipity['serendipityHTTPPath'].'plugins/serendipity_plugin_coppermine/none.jpg';

		if ($resolve){
			$file = @fopen($path.'/images/thumb_nopic.jpg',"r");
			if ($file){
				fclose($file);
				$defthumbnail = $path.'/images/thumb_nopic.jpg';
			} else {
				$file = @fopen($path.'/images/nopic.jpg',"r");
				if ($file){
					fclose($file);
					$defthumbnail = $path.'/images/nopic.jpg';
				}
			}
		}

		while ( $row = mysql_fetch_array($result) ) {

			echo '<div class="cm_cell">
				';

			$albumid = $row['aid'];  //This gets the picture's associated album name
			$pos = $row['pid'];      //This finds the picture's coppermine location

			$width = $row['pwidth'];
			$height = $row['pheight'];

			if (!isset($row['pwidth']) || empty($row['pwidth'])	|| $row['pwidth'] <= 0 ||
				!isset($row['pheight']) || empty($row['pheight']) || $row['pheight'] <= 0){

				$defimage = '<a href="' . $path . '/displayimage.php?album=' . $albumid . '&pos=-' . $pos . '">' .
					'<img src="' . $defthumbnail . '" title="' . $row['filename'] . '" alt="' . $row['filename'] . '" class="cm_thumbnail" style="width:' . $size . 'px; height:' . $size . 'px;"></a>';

				if ($resolve){

					if (preg_match("/[^\\.]+$/i",$row['filename'],$matches)){

						$ext = strtolower($matches[0]);
						$guess = $path.'/images/thumb_'.$ext.'.jpg';
						$file = @fopen($guess,"r");
						if ($file){
							fclose($file);
							echo '<a href="' . $path . '/displayimage.php?album=' . $albumid . '&pos=-' . $pos . '">' .
								'<img src="' . $guess . '" title="' . $row['filename'] . '" alt="' . $row['filename'] . '" class="cm_thumbnail" style="width:' . $size . 'px; height:' . $size . 'px;"></a>';

						} else echo $defimage;

					} else echo $defimage;

				} else echo $defimage;

			} else {

				$aspect = $width / $height;

				if ($aspect >= 1){

					$width = $size;
					$height = floor($size / $aspect);

					$hpad = 0;
					$vpad = floor(($width - $height) / 2);

				} else {

					$width = floor($size * $aspect);
					$height = $size;

					$vpad = 0;
					$hpad = floor(($height - $width) / 2);

				}

				echo '<a href="' . $path . '/displayimage.php?album=' . $albumid . '&pos=-' . $pos . '">' .
					'<img src="' . $path . '/albums/' . $row['filepath'] . thumb_.$row['filename'] . '" title="' . $row['filename'] . '" alt="' . $row['filename'] . '" class="cm_thumbnail" style="padding: '.$vpad.'px '.$hpad.'px '.$vpad.'px '.$hpad.'px;" width="' . $width . '" height="' . $height . '"></a>';

			}

			if ($albumlink){

				$albumresult = @mysql_query("SELECT * FROM " . $prefix . "albums WHERE aid = '" . $albumid . "'",$DB);

				if (!$albumresult) {
					echo 'Error performing query: ' . mysql_error() . '<br>';
					$this->finished($DB);
					return;
				}

				while ( $albumname = mysql_fetch_array($albumresult) ) {

					echo '<div class="cm_info"><a href="' . $path . '/thumbnails.php?album=' . $albumid . '">' . $albumname['title'] . '</a></div>';

				}

			}

?>

</div>

<?php

		}

?>

<?php

if (!empty($gallerypath)){

?>

<div class="cm_gallery">
<a href="<?php echo $gallerypath; ?>"><?php echo $gallery; ?></a>
</div>

<?php

}

?>

</div>

<?php

		$this->finished($DB);

	}

	function finished(&$db){

		global $serendipity;

		mysql_close($db);

		$serendipity['dbConn'] = mysql_connect($serendipity['dbHost'], $serendipity['dbUser'], $serendipity['dbPass']);
		mysql_select_db($serendipity['dbName']);


	}


}

?>
