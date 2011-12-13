<?php # $Id: serendipity_event_layout_printerfriendly.php,v 1.7 2006/12/01 09:00:45 garvinhicking Exp $


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

@define('PLUGIN_LAYOUT_PRINTERFRIENDLY_VERSION', '1.0');

class serendipity_event_layout_printerfriendly extends serendipity_event
{
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_LAYOUT_PRINTERFRIENDLY_NAME);
        $propbag->add('description',   PLUGIN_LAYOUT_PRINTERFRIENDLY_BLAHBLAH);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Sebastian Nohn');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',       '1.1');
        $propbag->add('event_hooks',   array('frontend_header' => true,
					     'external_plugin' => true));
        $propbag->add('configuration', array('display_sidebars',
					     'display_footer',
					     'display_comments'));
        $propbag->add('groups', array('BACKEND_TEMPLATES'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
	    case 'display_sidebars':
                $propbag->add('type',          'boolean');
                $propbag->add('name',          PLUGIN_LAYOUT_PRINTERFRIENDLY_SIDEBARS);
                $propbag->add('description',   '');
                $propbag->add('default',       'false');
                break;
	    case 'display_footer':
                $propbag->add('type',          'boolean');
                $propbag->add('name',          PLUGIN_LAYOUT_PRINTERFRIENDLY_FOOTER);
                $propbag->add('description',   '');
                $propbag->add('default',       'false');
                break;
	    case 'display_comments':
                $propbag->add('type',          'boolean');
                $propbag->add('name',          PLUGIN_LAYOUT_PRINTERFRIENDLY_COMMENTS);
                $propbag->add('description',   '');
                $propbag->add('default',       'true');
                break;
            default:
	      return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        $title       = $this->title;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_header':
                    echo '<link rel="stylesheet" type="text/css" href="'.$serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '').'plugin/print.css" media="print" />';
                    return true;
                    break;

                case 'external_plugin':
                    switch($eventData) {
                        case 'print.css':
                            header('Content-Type: text/css');
?>
body, div {
	font-size:	10pt;
	font-family:	serif; }

.serendipity_entry {
	background: 	white;
	color:		black;
	margin-bottom:	8em; }

h4.serendipity_title {
	font-family:	sans-serif;
	font-weight:	bold;
	font-size:	14pt; }

a {
	text-decoration: underline;
	color:		black; }

.serendipity_entry a:link:after,
.serendipity_entry a:visited:after {
   	content: 	" (" attr(href) ") ";
   	font-size: 	90%; }

.serendipity_entry a[href^="/"]:after {
  	content: 	" (<?php echo $serendipity['baseURL'] ?>" attr(href) ") "; }

<?php
    if (!$this->get_config('display_sidebars')) {
?>
#serendipityLeftSideBar,
#serendipityRightSideBar,
#sidebar {
	display:	none; }
<?php
    }
?>

<?php
    if (!$this->get_config('display_footer')) {
?>
.serendipity_babelfish,
.serendipity_entryFooter
 {
	display:	none; }
<?php
    }
?>

<?php
    if (!$this->get_config('display_footer')) {
?>
.serendipity_comments
 {
	display:	none; }
<?php
    }
?>

#serendipity_banner,
.serendipityCommentForm {
	display:	none; }
<?php
		    return true;
		  }
		  return true;
		  break;

                default:
                    return false;
            }
        } else {
            return false;
        }
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>
