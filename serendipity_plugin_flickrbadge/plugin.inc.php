<?php
/**
 * serendipity_plugin_flickrbadge - Your last photos from Flickr.com
 *
 * Serendipity plugin implementing a sidebar item which displays your last photos
 * you have added to Flickr.com
 *
 * @author Lars Strojny <lars@strojny.net>
 */
class serendipity_plugin_flickrbadge
	extends serendipity_plugin
{
	/**
	 * Plugin title
	 *
	 * @var string
	 */
	public $title = SERENDIPITY_PLUGIN_FLICKRBADGE_TITLE;

	/**
	 * Serendipity configuration array
	 *
	 * @var array
	 */
	protected $_serendipity;

	/**
	 * Overwriting the constructor to prevent myself from using the serendipity
	 * global in the class itself. Assigning a reference to a protected property
	 * which is much saner and better to use.
	 *
	 * @param serendipity_plugin_flickrbadge $instance
	 * @return serendipity_plugin_flickrbadge
	 */
	public function __construct($instance)
	{
		global $serendipity;
		parent::__construct($instance);
		$this->_serendipity = &$serendipity;
	}

	/**
	 * Plugin introspection
	 *
	 * Adding the root specification to the property bag of the plugin including
	 * requirements, configuration options, etc.
	 *
	 * @param serendipity_property_bag $propbag Property bag for the plugin
	 * @return null
	 */
	public function introspect(&$propbag)
	{
		$propbag->add('name', SERENDIPITY_PLUGIN_FLICKRBADGE_TITLE);
		$propbag->add('description', SERENDIPITY_PLUGIN_FLICKRBADGE_DESCRIPTION);
		$propbag->add('configuration', array('sidebar_title', 'image_number',
											'column_count', 'flickr_api_key',
											'flickr_username'));
		$propbag->add('stackable', true);
		$propbag->add('requirements', array('php' => '5.1', 'serendipity' => '0.9'));
		$propbag->add('groups', array(FRONTEND_EXTERNAL_SERVICES));
		$propbag->add('author', 'Lars Strojny');
		$propbag->add('version', SERENDIPITY_PLUGIN_FLICKRBADGE_VERSION);
	}

	/**
	 * Config item introspection
	 *
	 * This method specifies the various configuration options who belongs to
	 * this plugin.
	 *
	 * @param string $name Name of the configuration option
	 * @param serendipity_property_ba $propbag Property bag to specify the configuration options
	 * @return boolean
	 */
	public function introspect_config_item($name, &$propbag)
	{
		switch ($name) {
			case 'sidebar_title':
				$propbag->add('name', SERENDIPITY_PLUGIN_FLICKRBADGE_CONFIG_SIDEBARTITLE_TITLE);
				$propbag->add('description', SERENDIPITY_PLUGIN_FLICKRBADGE_CONFIG_SIDEBARTITLE_DESCRIPTION);
				$propbag->add('type', 'string');
				$propbag->add('default', SERENDIPITY_PLUGIN_FLICKRBADGE_TITLE);
				break;

			case 'flickr_api_key':
				$propbag->add('name', SERENDIPITY_PLUGIN_FLICKRBADGE_CONFIG_APIKEY_TITLE);
				$propbag->add('description', SERENDIPITY_PLUGIN_FLICKRBADGE_CONFIG_APIKEY_DESCRIPTION);
				$propbag->add('type', 'string');
				$propbag->add('validate', 'string');
				break;

			case 'flickr_username':
				$propbag->add('name', SERENDIPITY_PLUGIN_FLICKRBADGE_CONFIG_USERNAME_TITLE);
				$propbag->add('description', SERENDIPITY_PLUGIN_FLICKRBADGE_CONFIG_USERNAME_DESCRIPTION);
				$propbag->add('type', 'string');
				break;

			case 'image_number':
				$propbag->add('name', SERENDIPITY_PLUGIN_FLICKRBADGE_CONFIG_NUMBER_TITLE);
				$propbag->add('description', SERENDIPITY_PLUGIN_FLICKRBADGE_CONFIG_NUMBER_DESCRIPTION);
				$propbag->add('type', 'string');
				$propbag->add('default', '4');
				$propbag->add('validate', 'number');
				break;

			case 'column_count':
				$propbag->add('name', SERENDIPITY_PLUGIN_FLICKRBADGE_CONFIG_COLUMNNUMBER_TITLE);
				$propbag->add('description', SERENDIPITY_PLUGIN_FLICKRBADGE_CONFIG_COLUMNNUMBER_DESCRIPTION);
				$propbag->add('type', 'string');
				$propbag->add('validate', 'number');
				$propbag->add('default', 2);
				break;
		}
		return true;
	}

	/**
	 * Generate the sidebar content
	 *
	 * @param string $title
	 * @return null
	 */
	public function generate_content(&$title)
	{
		$title = $this->get_config('sidebar_title');

		try {
			require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'flickr' . DIRECTORY_SEPARATOR . 'filecache.php';
			$flickr = new serendipity_plugin_flickrbadge_flickr_filecache($this->get_config('flickr_api_key'));
			$flickr->setCacheDir($this->_serendipity['smarty']->compile_dir);
			$flickr->setCachePrefix('flickr-');
			/** Cache time to one hour. */
			$flickr->setCacheTime(60*60);
			$user_data = $flickr->findByUsername(
												array('username' => $this->get_config('flickr_username')),
												"people");
			$nsid = $user_data['user']['nsid'];
			$photos = $flickr->getPublicPhotos(array('user_id' => $nsid,
					'page' => 1, 'per_page' => (integer)$this->get_config('image_number')), 'people');

			$counter = 0;
			$column_max = (integer)$this->get_config('column_count');

			if ($column_max > 0) {
				?>
				<table class="serendipity_plugin_flickrbadge_table">
					<tr class="serendipity_plugin_flickrbadge_table_row">
				<?php
				foreach ($photos['photos']['photo'] as $photo) {
					/** Do not display private photos */
					if ($photo['ispublic'] !== 1) continue;

					/** Optimization: do not call require_once more often than needed */
					if ($counter === 0)
						require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'flickr.php';
					$image_markup = $this->_formatImageMarkup(
									serendipity_plugin_flickrbadge_flickr::getImageUrl($nsid, $photo['id']),
									serendipity_plugin_flickrbadge_flickr::buildImageUrl($photo),
									$photo['title']);

					if ($counter == $column_max) {
						echo '</tr><tr class="serendipity_plugin_flickrbadge_table_row">';
						$counter = 0;
					}

					echo '<td class="serendipity_plugin_flickrbadge_image_cell">'
						. $image_markup
						. '</td>';
					$counter++;
				}
				?>
					</tr>
				</table>
				<?php
			}
		} catch (Exception $e) {};
	}

	/**
	 * Returns an HTML-escaped string
	 *
	 * @param string $string
	 * @return string
	 */
	protected function _entify($string)
	{
		$charset = str_replace('/', '', $this->_serendipity['charset']);
		return htmlentities($string, ENT_QUOTES, $charset);
	}

	/**
	 * Format <a href=""><img/></a>-markup
	 *
	 * @param string $link_url
	 * @param string $photo_url
	 * @param string $image_name
	 * @return string
	 */
	protected function _formatImageMarkup($link_url, $photo_url, $image_name)
	{
		return sprintf('<a class="serendipity_plugin_flickrbadge_image_link" '
						. '"href="%1$s"><img class="serendipity_plugin_flickrbadge_image" '
						. 'src="%2$s" alt="%3$s" title="%3$s"/></a>',
						$this->_entify($link_url), $this->_entify($photo_url), $this->_entify($image_name), 1);
	}
}
