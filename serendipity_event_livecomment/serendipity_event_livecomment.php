<?php # $Id$


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_livecomment extends serendipity_event
{
    var $title = PLUGIN_EVENT_LIVECOMMENT_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_LIVECOMMENT_NAME);
        $propbag->add('description',   PLUGIN_EVENT_LIVECOMMENT_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Malte Paskuda, Garvin Hicking');
        $propbag->add('requirements',  array(
            'serendipity' => '1.0',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',       '2.5.4');
        $propbag->add('event_hooks',   array(
        	'frontend_footer'               => true,
        	'external_plugin'               => true,
        	'fetchcomments'                 => true,
        	'genpage'                       => true
        ));
        $propbag->add('groups', array('FRONTEND_VIEWS'));
        $propbag->add('configuration', array('variant',
                                             'buttons',
                                             'elastic',
                                             'path',
                                             'preview_animation',
                                             'preview_animation_speed',
                                             'button_animation',
                                             'button_animation_speed',
                                             'timeout',
                                             'inline'
                                             )
                                        );
        if (!$serendipity['capabilities']['jquery']) {
	        $this->dependencies = array('serendipity_event_jquery' => 'remove');
		}
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;

        switch($name) {
	        case 'variant':
	            $propbag->add('type', 'select');
	            $propbag->add('name', PLUGIN_EVENT_LIVECOMMENT_VARIANT);
	            $propbag->add('description', PLUGIN_EVENT_LIVECOMMENT_VARIANT_DESC);
                $propbag->add('select_values', array('jquery' => PLUGIN_EVENT_LIVECOMMENT_VARIANT_JQUERY, 'legacy' => PLUGIN_EVENT_LIVECOMMENT_VARIANT_LEGACY, 'none' => PLUGIN_EVENT_LIVECOMMENT_VARIANT_NONE));
	            $propbag->add('default', 'jquery');
	            return true;
	            break;
            case 'buttons':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_LIVECOMMENT_BUTTON);
                $propbag->add('description', PLUGIN_EVENT_LIVECOMMENT_BUTTON_DESC);
                $propbag->add('default', true);
                return true;
	            break;
            case 'elastic':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_LIVECOMMENT_ELASTIC);
                $propbag->add('description', PLUGIN_EVENT_LIVECOMMENT_ELASTIC_DESC);
                $propbag->add('default', false);
                return true;
	            break;
            case 'path':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_LIVECOMMENT_PATH);
                $propbag->add('description', PLUGIN_EVENT_LIVECOMMENT_PATH_DESC);
                $propbag->add('default', $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_livecomment/');
                return true;
                break;
            case 'preview_animation':
                $propbag->add('type', 'select');
	            $propbag->add('name', PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION);
	            $propbag->add('description', PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION_DESC);
                $propbag->add('select_values', array('show' => 'show', 'fadeIn' => 'fadeIn', 'slideDown' => ' slideDown'));
	            $propbag->add('default', 'fadeIn');
	            return true;
	            break;
            case 'preview_animation_speed':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION_SPEED);
                $propbag->add('description', PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION_SPEED_DESC);
                $propbag->add('default', 'slow');
                return true;
                break;
            case 'button_animation':
                $propbag->add('type', 'select');
	            $propbag->add('name', PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION);
	            $propbag->add('description', PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION_DESC);
                $propbag->add('select_values', array('show' => 'show', 'fadeIn' => 'fadeIn', 'slideDown' => ' slideDown'));
	            $propbag->add('default', 'slideDown');
	            return true;
	            break;
            case 'button_animation_speed':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION_SPEED);
                $propbag->add('description', PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION_SPEED_DESC);
                $propbag->add('default', 'slow');
                return true;
                break;
            case 'timeout':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_LIVECOMMENT_TIMEOUT);
                $propbag->add('description', PLUGIN_EVENT_LIVECOMMENT_TIMEOUT_DESC);
                $propbag->add('default', '');
                return true;
                break;
            case 'inline':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_LIVECOMMENT_INLINE);
                $propbag->add('description', PLUGIN_EVENT_LIVECOMMENT_INLINE_DESC);
                $propbag->add('default', false);
                return true;
	            break;
        }
    }

    function event_hook($event, &$bag, &$eventData) {
        global $serendipity;
        static $variant = null;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            if ($variant === null) {
                $variant = $this->get_config('variant', 'jquery');
            }
            if ($buttons === null) {
                $buttons = serendipity_db_bool($this->get_config('buttons', true));
            }
            if ($timeout === null) {
                $timeout = $this->get_config('timeout', '');
            }
            if ($preview_animation === null) {
                $preview_animation = $this->get_config('preview_animation', 'fadeIn');
            }
            if ($preview_animation_speed === null) {
                $preview_animation_speed = $this->get_config('preview_animation_speed', 'slow');
            }
            if ($button_animation === null) {
                $button_animation = $this->get_config('button_animation', 'slideDown');
            }
            if ($button_animation_speed === null) {
                $button_animation_speed = $this->get_config('button_animation_speed', 'slow');
            }
            if ($elastic === null) {
                $elastic = serendipity_db_bool($this->get_config('elastic', false));
            }
            if ($inline === null) {
                $inline = serendipity_db_bool($this->get_config('inline', false));
            }
            if ($path === null) {
                $path = $this->get_config('path', '');
            }
            if (!empty($path) && $path != 'default' && $path != 'none' && $path != 'empty') {
                $path_defined = true;
                $imgpath = $path . 'img/';
            } else {
                $path_defined = false;
                $imgpath = $serendipity['baseURL'] . 'index.php?/plugin/';
            }
            
            switch($event) {
                case 'external_plugin':
                    switch($eventData) {
                        case 'livecomment.js':
                            header('Content-Type: text/javascript');
                            echo file_get_contents(dirname(__FILE__). '/serendipity_event_livecomment.js');
                            break;
                        case 'livecomment':    
                            $data = array('comment' => $_REQUEST['data']);
                            serendipity_plugin_api::hook_event('frontend_display', $data);
                            echo $data['comment'];
                            break;
                        case 'reallivecomment.js':
                            header('Content-Type: text/javascript');
                            echo file_get_contents(dirname(__FILE__). '/serendipity_event_reallivecomment.js');
                            break;
                        case 'reallivecomment':
                            $markups =& $this->get_markups();    
                            $data = array($this->check_markup($markups, 'serendipity_event_s9ymarkup', 's9ymarkup'),
                                      $this->check_markup($markups, 'serendipity_event_nl2br', 'nl2br'),
                                      $this->check_markup($markups, 'serendipity_event_textile', 'textile'),
                                      $this->check_markup($markups, 'serendipity_event_bbcode', 'bb'),
                                      $this->check_markup($markups, 'serendipity_event_markdown', 'markdown'),
                                      $this->check_markup($markups, 'serendipity_event_nl2p', 'nl2p'),
                                      $this->check_markup($markups, 'serendipity_event_liquid', 'liquid'),
                                      $this->output($preview_animation),
                                      $this->output($preview_animation_speed),
                                      $this->output($button_animation),
                                      $this->output($button_animation_speed),
                                      $this->output(PLUGIN_EVENT_LIVECOMMENT_BOLD),
                                      $this->output(PLUGIN_EVENT_LIVECOMMENT_ITALIC),
                                      $this->output(PLUGIN_EVENT_LIVECOMMENT_UNDERLINE),
                                      $this->output(PLUGIN_EVENT_LIVECOMMENT_URL),
                                      $this->output($variant == 'jquery'),
                                      $this->output($buttons),
                                      $this->output($elastic),
                                      $this->output($imgpath),
                                      //has to be last element:
                                      $this->get_Title()
                                      );
                            break;
                        case 'commentMarkup.listen.js':
                            header('Content-Type: text/javascript');
                            echo file_get_contents(dirname(__FILE__). '/commentMarkup.listen.js');
                            break;
                        case 'commentMarkup.fieldselection.js':
                            header('Content-Type: text/javascript');
                            echo file_get_contents(dirname(__FILE__). '/commentMarkup.fieldselection.js');
                            break;
                        case 'jquery.elastic.js':
                            header('Content-Type: text/javascript');
                            echo file_get_contents(dirname(__FILE__). '/jquery.elastic.js');
                            break;
                        case 'bold.png':
                            header('Content-Type: image/png');
                            echo file_get_contents(dirname(__FILE__). '/img/bold.png');
                            break;
                        case 'italic.png':
                            header('Content-Type: image/png');
                            echo file_get_contents(dirname(__FILE__). '/img/italic.png');
                            break;
                        case 'underline.png':
                            header('Content-Type: image/png');
                            echo file_get_contents(dirname(__FILE__). '/img/underline.png');
                            break;
                        case 'world.png':
                            header('Content-Type: image/png');
                            echo file_get_contents(dirname(__FILE__). '/img/world.png');
                            break;
                    }
                    return true;
                    break;

                case 'genpage':
                    if ($variant == 'legacy') {
                        $serendipity['plugindata']['smartyvars']['comment_onchange'] = 'liveCommentKeyPress(\'js\'); ';
                    }
            	  	return true;
                    break;

                case 'fetchcomments':                   
                    if ($variant == 'legacy') {
                        $serendipity['plugindata']['onchange'] = 'javascript:liveCommentKeyPress()';
                    }
            	  	return true;
                    break;

            	case 'frontend_footer':
            	    if ($eventData['view'] === 'entry' ) {
                        if ($variant == 'jquery' || $buttons || $elastic){
                            //lay basic for ajax-calls
                            if ($path_defined) {
                                echo '<script type="text/javascript" src="' . $path . 'serendipity_event_reallivecomment.js"></script>
    <script type="text/javascript">
    var lcbase = "' . $serendipity['baseURL'] .'index.php?/plugin/reallivecomment";
    </script>' . "\n";
                            } else {
                                echo '<script type="text/javascript" src="' . $serendipity['baseURL'] . 'index.php?/plugin/reallivecomment.js"></script>
    <script type="text/javascript">
    var lcbase = "' . $serendipity['baseURL'] .'index.php?/plugin/reallivecomment";
    </script>' . "\n";
                            }
                        }
                        if($inline && ($variant == 'jquery' || $buttons || $elastic)) {
                            $markups =& $this->get_markups();
    ?><script type="text/javascript">
    var storage.s9ymarkup = <?php                       $this->check_markup($markups, 'serendipity_event_s9ymarkup', 's9ymarkup');
    ?>var storage.nl2br = <?php                         $this->check_markup($markups, 'serendipity_event_nl2br', 'nl2br');
    ?>var storage.textile = <?php                       $this->check_markup($markups, 'serendipity_event_textile', 'textile');
    ?>var storage.bb = <?php                            $this->check_markup($markups, 'serendipity_event_bbcode', 'bb');
    ?>var storage.markdown = <?php                      $this->check_markup($markups, 'serendipity_event_markdown', 'markdown');
    ?>var storage.nl2p = <?php                          $this->check_markup($markups, 'serendipity_event_nl2p', 'nl2p');
    ?>var storage.liquid = <?php                        $this->check_markup($markups, 'serendipity_event_liquid', 'liquid');
    ?>var storage.preview_animation = <?php             $this->output($preview_animation);
    ?>var storage.preview_animation_speed = <?php       $this->output($preview_animation_speed);
    ?>var storage.button_animation = <?php              $this->output($button_animation);
    ?>var storage.button_animation_speed = <?php        $this->output($button_animation_speed);
    ?>var storage.bold = <?php                          $this->output(PLUGIN_EVENT_LIVECOMMENT_BOLD);
    ?>var storage.italic = <?php                        $this->output(PLUGIN_EVENT_LIVECOMMENT_ITALIC);
    ?>var storage.underline = <?php                     $this->output(PLUGIN_EVENT_LIVECOMMENT_UNDERLINE);
    ?>var storage.url = <?php                           $this->output(PLUGIN_EVENT_LIVECOMMENT_URL);
    ?>var storage.preview = <?php                       $this->output($variant == 'jquery');
    ?>var storage.buttons = <?php                       $this->output($buttons);
    ?>var storage.elastic = <?php                       $this->output($elastic);
    ?>var imgpath = <?php                               $this->output($imgpath);
                                                        //has to be last element:
    ?>var storage.preview_title = <?php                 $this->get_Title();?>
    ');
    var inline = true;</script>
    <?php
                        }
                        if ($variant == 'legacy') {
                            if ($path_defined) {
                                echo '<script type="text/javascript">
    var lcbase = "'. $serendipity['baseURL'] .'index.php?/plugin/livecomment"; 
    var lcchar = LANG_CHARSET;
    </script>
    <script type="text/javascript" src="'. $path .'serendipity_event_livecomment.js"></script>'. "\n";
                            } else {
                                echo '<script type="text/javascript">
    var lcbase = "'. $serendipity['baseURL'] .'index.php?/plugin/livecomment"; 
    var lcchar = LANG_CHARSET;
    </script>
    <script type="text/javascript" src="' . $serendipity['baseURL'] . 'index.php?/plugin/livecomment.js"></script>'. "\n";
                            }
                        }
                        if ($buttons) {
                            if (!empty($timeout) && $timeout != 'default' && $timeout != 'none' && $timeout != 'empty') {
                                echo '<script type=\"text/javascript\">
    var lctimeout = '. $timeout .';
    </script>'. "\n";
                            }
                            if ($path_defined) {
                                echo '<script type="text/javascript" src="' . $path . 'commentMarkup.listen.js"></script>
    <script type="text/javascript" src="' . $path . 'commentMarkup.fieldselection.js"></script>'. "\n";
                            } else {
                                echo '<script type="text/javascript" src="' . $serendipity['baseURL'] . 'index.php?/plugin/commentMarkup.listen.js"></script>
    <script type="text/javascript" src="' . $serendipity['baseURL'] . 'index.php?/plugin/commentMarkup.fieldselection.js"></script>'. "\n";
                            }
                        }
                        if ($elastic) {
                            if ($path_defined) {
                                echo '<script type="text/javascript" src="' . $path . 'jquery.elastic.js"></script>'. "\n";
                            } else {
                                echo '<script type="text/javascript" src="' . $serendipity['baseURL'] . 'index.php?/plugin/jquery.elastic.js"></script>'. "\n";
                            }
                        }
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

    function get_markups() {
        global $serendipity;

        $supported = serendipity_db_query("SELECT name, value
                                             FROM {$serendipity['dbPrefix']}config
                                            WHERE name LIKE 'serendipity_event_s9ymarkup:%/comment'
                                               OR name LIKE 'serendipity_event_nl2br:%/comment'
                                               OR name LIKE 'serendipity_event_textile:%/comment'
                                               OR name LIKE 'serendipity_event_bbcode:%/comment'
                                               OR name LIKE 'serendipity_event_markdown:%/comment'
                                               OR name LIKE 'serendipity_event_nl2p:%/comment'
                                               OR name LIKE 'serendipity_event_liquid:%/comment'");
        if (!is_array($supported)) {
            return array();
        }
        
        $enabled_markups = array();
        foreach($supported AS $row) {
            preg_match('@^(.*):@', $row['name'], $m);
            if (serendipity_db_bool($row['value'])) {
                $enabled_markups[$m[1]] = 'true';
            } else {
                $enabled_markups[$m[1]] = 'false';
            }
        }

        return $enabled_markups;
    }

    function check_markup(&$dbset, $plugin_key = 'serendipity_event_s9ymarkup', $js_var = 's9ymarkup') {
        global $serendipity;

        echo ' ' . (isset($dbset[$plugin_key]) ? (string)$dbset[$plugin_key] : (string)'false') . ';';
    }

    function get_title() {
        echo PLUGIN_EVENT_LIVECOMMENT_PREVIEW_TITLE;
    }
    function output($element) {
        echo $element . ';';
    }
}

/* vim: set sts=4 ts=4 expandtab :
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * indent-tabs-mode: nil
 * End:
*/
