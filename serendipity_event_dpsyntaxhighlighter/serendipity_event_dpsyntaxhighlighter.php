<?php

if (IN_serendipity !== true) {
    die ('Don\'t hack!');
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

// dp-SyntaxHighlighter Plugin for Serendipity
// May 25, 2007 by Brendon Kozlowski <webmaster@mysiteonline.org>
// Feb 12, 2009 by J.M.Roth <jm+dpsh@roth.lu>
class serendipity_event_dpsyntaxhighlighter extends serendipity_event {

    var $title = PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_NAME;

  var $version = '3.0.83'; // helps to be easily able to upgrade on upstream upgrade
  
  /* _get_directory_match support function:
   * read files from $dir that match regexp $tomatch and store matches in 
   * array $matches needed to read theme and scripts directory
   *
   * This has the advantage that one can just copy new styles and themes to 
   * the appropriate directories to be recognized.
   */
  function _get_directory_match($dir, $tomatch, &$matches) {
    if ($handle = opendir($dir)) {
      while (false !== ($file = readdir($handle))) {
	if ($file == '.' || $file == '..') continue;
	if (preg_match($tomatch, $file, $m) > 0) {
	  $matches[$m[1]] = $m[1];
	}
      }
      closedir($handle);
    }
  }

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',           PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_NAME);
        $propbag->add('description',    PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_DESC);
        $propbag->add('author',         'Alex Gorbatchev (core), Brendon Kozlowski and J.M. Roth (plugin)');
        $propbag->add('version',        $this->version);
        $propbag->add('requirements',  array(
            'serendipity' => '1.0',
            'smarty'      => '2.6.7',
            'php'         => '5.0.0'
        ));
        $propbag->add('event_hooks',    array('frontend_header' => true, 'frontend_footer' => true, 'backend_preview' => true));
        $propbag->add('stackable',      false);
        $propbag->add('groups',         array('MARKUP'));

        $conf_array = array();
        $conf_array[] = 'path';
        $conf_array[] = 'theme';
        $conf_array[] = 'toolbar';
        $conf_array[] = 'auto-links';
        $conf_array[] = 'class-name';
        $conf_array[] = 'collapse';
        $conf_array[] = 'gutter';
        $conf_array[] = 'smart-tabs';
        $conf_array[] = 'tab-size';
        $conf_array[] = 'stripBrs';
        $propbag->add('configuration', $conf_array);
    }


    function generate_content(&$title) {
        $title = PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_NAME;
    }


    function introspect_config_item($name, &$propbag) {
        global $serendipity;

        switch($name) {
            case 'path':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_PATH);
                $propbag->add('description',    PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_PATH_DESC);
                $propbag->add('default',        '');
                $propbag->add('default',        str_replace('//', '/', $serendipity['serendipityHTTPPath'] . preg_replace('@^.*(/plugins.*)@', '$1', dirname(__FILE__))));
                break;
            case 'theme':
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_THEME);
                $propbag->add('description',    PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_THEME_DESC);
		$this->_get_directory_match($serendipity['serendipityPath'].'plugins/serendipity_event_dpsyntaxhighlighter/sh/'.$this->version.'/styles/', "/shTheme(.*).css/", $themes);
                $propbag->add('select_values',  $themes);
                $propbag->add('default',        'Default');
                break;
            case 'toolbar':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_TOOLBAR);
                $propbag->add('description',    PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_TOOLBAR_DESC);
                $propbag->add('default',        true);
                break;
            case 'auto-links':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_AUTOLINS);
                $propbag->add('description',    PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_AUTOLINKS_DESC);
                $propbag->add('default',        true);
                break;
            case 'class-name':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_CLASSNAME);
                $propbag->add('description',    PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_CLASSNAME_DESC);
                $propbag->add('default',        '');
                break;
            case 'collapse':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_COLLAPSE);
                $propbag->add('description',    PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_COLLAPSE_DESC);
                $propbag->add('default',        false);
                break;
            case 'gutter':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_GUTTER);
                $propbag->add('description',    PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_GUTTER_DESC);
                $propbag->add('default',        true);
                break;
            case 'smart-tabs':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_SMARTTABS);
                $propbag->add('description',    PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_SMARTTABS_DESC);
                $propbag->add('default',        true);
                break;
            case 'tab-size':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_TABSIZE);
                $propbag->add('description',    PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_TABSIZE_DESC);
                $propbag->add('default',        '4');
                $propbag->add('validate',       'number');
                break;
            case 'stripBrs':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_STRIPBRS);
                $propbag->add('description',    PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_STRIPBRS_DESC);
                $propbag->add('default',        'false');
                break;
        }
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;
        static $regex = null;
        static $sub   = null;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            $pluginDir = $this->get_config('path');

	    /** HTML header includes (configurable) theme **/

	    $theme = $this->get_config('theme');

	    $header_add = '
<script type="text/javascript" src="'.$pluginDir.'/sh/'.$this->version.'/scripts/shCore.js"></script>

<link type="text/css" rel="stylesheet" href="'.$pluginDir.'/sh/'.$this->version.'/styles/shCore.css"/>
<link type="text/css" rel="stylesheet" href="'.$pluginDir.'/sh/'.$this->version.'/styles/shTheme'.(empty($theme)?'Default':$theme).'.css" id="shTheme"/>';
	    
	    /** HTML footer includes all brushes in the scripts directory **/

	    $this->_get_directory_match($serendipity['serendipityPath'].'plugins/serendipity_event_dpsyntaxhighlighter/sh/'.$this->version.'/scripts/', "/shBrush(.*).js/", $brushes);
				
	    foreach ($brushes as $brush) {
	      $footer_add .= '<script type="text/javascript" src="'.$pluginDir.'/sh/'.$this->version.'/scripts/shBrush'.$brush.'.js"></script>
';
	    }
	    $footer_add .= '<script type="text/javascript">
  SyntaxHighlighter.config.clipboardSwf = \''.$pluginDir.'/sh/'.$this->version.'/scripts/clipboard.swf\';';
            
            $stripBrs = $this->get_config('stripBrs');
            if ($stripBrs) {
                $footer_add .=  'SyntaxHighlighter.config.stripBrs = true;';
            }
            
            $toolbar = $this->get_config('toolbar');
            if (!$toolbar) {
                $footer_add .=  'SyntaxHighlighter.defaults[\'toolbar\'] = false;';
            }
            $autoLinks = $this->get_config('auto-links');
            if (!$autoLinks) {
                $footer_add .=  'SyntaxHighlighter.defaults[\'auto-links\'] = false;';
            }
            $className = $this->get_config('class-name');
            if ($className !== '') {
                $footer_add .=  'SyntaxHighlighter.defaults[\'class-name\'] = \'' . $className . '\';';
            }
            $collapse = $this->get_config('collapse');
            if ($collapse) {
                $footer_add .=  'SyntaxHighlighter.defaults[\'collapse\'] = true;';
            }
            $gutter = $this->get_config('gutter');
            if (!$gutter) {
                $footer_add .=  'SyntaxHighlighter.defaults[\'gutter\'] = false;';
            }
            $smartTabs = $this->get_config('smart-tabs');
            if (!$smartTabs) {
                $footer_add .=  'SyntaxHighlighter.defaults[\'smart-tabs\'] = false;';
            }
            $tabSize = $this->get_config('tab-size');
            if ($tabSize !== '4') {
                $footer_add .=  'SyntaxHighlighter.defaults[\'tab-size\'] = ' . intval($tabSize) . ';';
            }
            
  $footer_add .=  'SyntaxHighlighter.all();
</script>
';

            switch($event) {
                case 'frontend_header':
		    echo $header_add;
                    return true;
                    break;

                case 'frontend_footer':
		    echo $footer_add;
                    return true;
                    break;

                case 'backend_preview':
		    echo $header_add;
		    echo $footer_add;
                    return true;
                    break;

                default:
                    return false;
            }
        } else {
            return false;
        }
    }
/***************  Not Currently Used ****************
    function install() {
        //
    }

    function uninstall(&$propbag) {
        //
    }
/****************************************************/
}
