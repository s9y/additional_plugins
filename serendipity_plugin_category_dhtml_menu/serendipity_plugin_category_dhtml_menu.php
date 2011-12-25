<?php
/**
 * @author Jackson Miller <docblock@jaxn.org>
 * @author Sebastian Bauer <sbauer@gjl-network.net>
 * @license PHP
 * @package additional_plugins
 * @version $Id$
 */



if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

/**
 * Provides a DHTML tree menu of serendipity categories.
 * As of this commit an example can be seen at http://jaxn.org/blog/
 * @see serendipity_plugin
 */
class serendipity_plugin_category_dhtml_menu extends serendipity_plugin {
    var $title = null;
    /**
     * Provides reflection for plugin management.
     * @param $propbag
     * @return void
     */
    function introspect(&$propbag)
    {
        $propbag->add('name',        PLUGIN_DHTMLMENU_NAME);
        $propbag->add('description', PLUGIN_DHTMLMENU_NAME_DESC);
        $propbag->add('configuration', array('title', 'expand_all','image_path','script_path','show_count','image'));
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('author',      'Jackson Miller, Sebastian Bauer');
        $propbag->add('version',     '1.12');
        $propbag->add('groups', array('FRONTEND_VIEWS'));
    }

    /**
     * Provides reflection for plugin configuration
     * @param $name
     * @param $propbag
     * @return bool
     */
    function introspect_config_item($name, &$propbag)
    {
        switch ($name) {
            case 'title':
                $propbag->add('type', 'string');
                $propbag->add('name', TITLE);
                $propbag->add('description', '');
                break;

            case 'expand_all':
                $propbag->add('type', 'bool');
                $propbag->add('name', TOGGLE_ALL);
                $propbag->add('description', '');
                $propbag->add('default', 'false');
                break;

            case 'image_path':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_DHTMLMENU_PATH);
                $propbag->add('description', PLUGIN_DHTMLMENU_PATH_DESC);
                $propbag->add('default', 'plugins/serendipity_plugin_category_dhtml_menu/img');
                break;

            case 'script_path':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_DHTMLMENU_JSPATH);
                $propbag->add('description', PLUGIN_DHTMLMENU_JSPATH_DESC);
                $propbag->add('default','plugins/serendipity_plugin_category_dhtml_menu/TreeMenu.js');
                break;

            case 'show_count':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_DHTMLMENU_SHOWCOUNT);
                $propbag->add('description', '');
                $propbag->add('default',     false);
                break;

            case 'image':
                $propbag->add('type',         'string');
                $propbag->add('name',         XML_IMAGE_TO_DISPLAY);
                $propbag->add('description',  XML_IMAGE_TO_DISPLAY_DESC);
                $propbag->add('default',     serendipity_getTemplateFile('img/xml.gif'));
                break;

            default:
               break;
        }

        return true;
    }

    /**
     * Creates a DHTML menu of serendipity categories.
     *
     * The menu is echoed out.
     *
     * @param  string $title  (Serves as the top level menu item if present)
     * @return void
     * @see    http://pear.php.net/HTML_TreeMenu  PEAR::HTML_TreeMenu
     */
    function generate_content(&$title) {

        global $serendipity;

        $title = $this->get_config('title', $this->title);
        // may want to put this in bundled_libs or a sub directory of this directory
        $pear = false;
        if (@include_once('HTML/TreeMenu.php')) {
            $pear = true;
        } elseif (@include_once('HTML_TreeMenu/TreeMenu.php')) {
            $pear = true;
        }
        if ($pear) {

            $which_category = $this->get_config('authorid');

            // build an accessible array of categories
            foreach (serendipity_fetchCategories(empty($which_category) ? 'all' : $which_category) as $cat) {
                if (!is_array($cat) || !isset($cat['categoryid'])) continue;
                $categories[$cat['categoryid']] = $cat;
            }

            // create an array of numbers of entries per category
            $cat_count = array();
            if (serendipity_db_bool($this->get_config('show_count'))) {
                $cat_sql        = "SELECT c.categoryid, c.category_name, count(e.id) as postings
                                                FROM {$serendipity['dbPrefix']}entrycat ec,
                                                     {$serendipity['dbPrefix']}category c,
                                                     {$serendipity['dbPrefix']}entries e
                                                WHERE ec.categoryid = c.categoryid
                                                  AND ec.entryid = e.id
                                                  AND e.isdraft = 'false'
                                                      " . (!serendipity_db_bool($serendipity['showFutureEntries']) ? " AND e.timestamp  <= " . serendipity_db_time() : '') . "
                                                GROUP BY c.categoryid, c.category_name
                                                ORDER BY postings DESC";
                $category_rows  = serendipity_db_query($cat_sql);
                if (is_array($category_rows)) {
                    foreach($category_rows AS $cat) {
                        $cat_count[$cat['categoryid']] = $cat['postings'];
                    }
                }

            }

            $image = $this->get_config('image', serendipity_getTemplateFile('img/xml.gif'));
            $image = (($image == "'none'" || $image == 'none') ? '' : $image);

            // create nodes
            foreach ($categories as $cid => $cat) {
                if (function_exists('serendipity_categoryURL')) {
                    $link = serendipity_categoryURL($cat, 'serendipityHTTPPath');
                } else {
                    $link = serendipity_rewriteURL(PATH_CATEGORIES . '/' . serendipity_makePermalink(PERM_CATEGORIES, array('id' => $cat['categoryid'], 'title' => $cat['category_name'])), 'serendipityHTTPPath');
                }

                if (!empty($cat_count[$cat['categoryid']])) {
                    // $categories[$cid]['true_category_name'] = $cat['category_name'];
                    $cat['category_name'] .= ' (' . $cat_count[$cat['categoryid']] . ')';
                    // $categories[$cid]['article_count'] = $cat_count[$cat['categoryid']];
                }
                if (!empty($image)) {
                    $feedURL = serendipity_feedCategoryURL($cat, 'serendipityHTTPPath');
                    $feed = '<a class="serendipity_xml_icon" href="'. $feedURL .'"><img src="'. $image .'" alt="XML" style="border: 0px;vertical-align:middle"/></a> ';
                    $link = '<a href="'.$link.'" target="_self"><span>'.$cat['category_name'].'</span></a>';
                    // work around a problem in HTML_TreeNode: when there is a href in 'text', 'link' is not converted to a link.
                    $cat_nodes[$cat['categoryid']] = new HTML_TreeNode(array('text'=>($feed . $link)));
                }else
                    $cat_nodes[$cat['categoryid']] = new HTML_TreeNode(array('text'=>($feed . $cat['category_name']),'link'=>$link));
            }


            // create a top level for "all categories"
            // this serves as the title
            $cat_nodes[0] = new HTML_TreeNode(array('text'=>ALL_CATEGORIES,'link'=>$serendipity['baseURL']));
            // nest nodes (thanks to PHP references)
            foreach ($categories as $category) {
                $cat_nodes[$category['parentid']]->addItem($cat_nodes[$category['categoryid']]);
            }

            // nest the "all categories" category
            $menu = new HTML_TreeMenu();
            $menu->addItem( $cat_nodes[0] );

            $tree = new HTML_TreeMenu_DHTML($menu,array('images'=>$serendipity['baseURL'].$this->get_config('image_path')));
            // Add heading for block
            #$output = '<h2 class="serendipitySideBarTitle" style="font-weight: bold;">'.$title.'</h2><br />';
            // Put inside a div with "overflow:hidden" to avoid items of the sidebar plugin running outside the blog
            // Maybe we can put a config setting to choose if the block should be displayed with or without overflow setting.
            $output .= '<div style="overflow: hidden;">';
            $output .= $tree->toHTML();
            $output .= '</div>';
            echo '<script type="text/javascript" src="'.$serendipity['baseURL'].$this->get_config('script_path').'"></script>';
        } else {
            $output .= "Please install PEAR package HTML_TreeMenu to enable this plugin.";
        }

        echo $output;

    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>