<?php # $Id$

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_mimetex extends serendipity_event
{
    var $title = PLUGIN_EVENT_MIMETEX_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_MIMETEX_NAME);
        $propbag->add('description',   PLUGIN_EVENT_MIMETEX_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Matthew Groeninger');
        $propbag->add('version',       '1.3');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks',    array(
            'external_plugin'                => true,
            'backend_entry_toolbar_extended' => true,
            'backend_entry_toolbar_body'     => true,
            'frontend_display'               => true
        ));

        $propbag->add('groups', array('MARKUP'));
        $this->markup_elements = array(
            array(
              'name'     => 'ENTRY_BODY',
              'element'  => 'body',
            ),
            array(
              'name'     => 'EXTENDED_BODY',
              'element'  => 'extended',
            ),
            array(
              'name'     => 'COMMENT',
              'element'  => 'comment',
            ),
            array(
              'name'     => 'HTML_NUGGET',
              'element'  => 'html_nugget',
            )
        );
        $conf_array = array('info','auto_replace','mimetex_or_latex','mimetex_path','latex_path','dvips_path','convert_path', 'transparency','filetype');


        foreach($this->markup_elements as $element) {
            $conf_array[] = $element['name'];
        }

        $propbag->add('configuration', $conf_array);



    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'info':
                $propbag->add('type',        'content');
                $propbag->add('default', PLUGIN_EVENT_MIMETEX_NOTE);
                break;

            case 'mimetex_or_latex':
                if (substr(php_uname(), 0, 7) != "Windows"){
                    $propbag->add('type', 'radio');
                    $propbag->add('name', PLUGIN_EVENT_MIMETEX_OR_LATEX);
                    $propbag->add('description', PLUGIN_EVENT_MIMETEX_OR_LATEX_BLAHBLAH);
                    $propbag->add('radio',  array(
                        'value' => array('mimetex', 'latex'),
                        'desc'  => array(PLUGIN_EVENT_MIMETEX_OR_LATEX_MIMETEX, PLUGIN_EVENT_MIMETEX_OR_LATEX_LATEX)
                        ));
                    $propbag->add('default', 'mimetex');
                }
            break;

            case 'mimetex_path':
                if($this->get_config('mimetex_or_latex','mimetex') == "mimetex")  {
                    $propbag->add('type', 'string');
                    $propbag->add('name', PLUGIN_EVENT_MIMETEX_PATH);
                    $propbag->add('description', PLUGIN_EVENT_MIMETEX_PATH_DESC);
                    $propbag->add('default', '/usr/bin/mimetex');
                }
                break;

            case 'latex_path':
                if($this->get_config('mimetex_or_latex','mimetex') == "latex")  {
                    $propbag->add('type', 'string');
                    $propbag->add('name', PLUGIN_EVENT_MIMETEX_LATEXPATH);
                    $propbag->add('description', PLUGIN_EVENT_MIMETEX_LATEXPATH_DESC);
                    $propbag->add('default', '/usr/bin/latex');
                }
                break;

            case 'dvips_path':
                if($this->get_config('mimetex_or_latex','mimetex') == "latex")  {
                    $propbag->add('type', 'string');
                    $propbag->add('name', PLUGIN_EVENT_MIMETEX_DVIPSPATH);
                    $propbag->add('description', PLUGIN_EVENT_MIMETEX_DVIPSPATH_DESC);
                    $propbag->add('default', '/usr/bin/dvips');
                }
                break;

            case 'convert_path':
                if($this->get_config('mimetex_or_latex','mimetex') == "latex")  {
                    $propbag->add('type', 'string');
                    $propbag->add('name', PLUGIN_EVENT_MIMETEX_CONVERTPATH);
                    $propbag->add('description', PLUGIN_EVENT_MIMETEX_CONVERTPATH_DESC);
                    $propbag->add('default', '/usr/bin/convert');
                }
                break;

            case 'transparency':
                if($this->get_config('mimetex_or_latex','mimetex') == "latex")  {
                    $propbag->add('type', 'boolean');
                    $propbag->add('name', PLUGIN_EVENT_MIMETEX_ADDTRANSPARENCY);
                    $propbag->add('description', PLUGIN_EVENT_MIMETEX_ADDTRANSPARENCY_DESC);
                    $propbag->add('default', 'false');
                }
                break;

            case 'filetype':
                if($this->get_config('mimetex_or_latex','mimetex') == "latex")  {
                    $propbag->add('type', 'select');
                    $propbag->add('name', PLUGIN_EVENT_MIMETEX_FILETYPE);
                    $propbag->add('description', PLUGIN_EVENT_MIMETEX_FILETYPE_DESC);
                    $propbag->add('select_values', array('gif' => 'gif', 'png' => 'png'));
                    $propbag->add('default', 'gif');
                }
                break;

            case 'auto_replace':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_MIMETEX_REPLACE);
                $propbag->add('description', PLUGIN_EVENT_MIMETEX_REPLACE_DESC);
                $propbag->add('default', 'false');
                break;

            default:
                if($this->get_config('auto_replace'))  {
                    $propbag->add('type',        'boolean');
                    $propbag->add('name',        constant($name));
                    $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
                    $propbag->add('default', 'false');
                }
        }
        return true;

    }


    function generate_content(&$title) {
        $title = $this->title;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        $links = array();
        $article_show = false;

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_entry_toolbar_extended':
                    if (!$this->get_config('auto_replace')) {
                        if (isset($eventData['backend_entry_toolbar_extended:textarea'])) {
                            $txtarea = $eventData['backend_entry_toolbar_extended:textarea'];
                        } else {
                            $txtarea = "serendipity[extended]";
                        }
                        if (!$serendipity['wysiwyg']) {
                            $this->generate_button($txtarea);
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                    break;

                case 'backend_entry_toolbar_body':
                    if (!$this->get_config('auto_replace')) {
                        if (isset($eventData['backend_entry_toolbar_body:textarea'])) {
                            $txtarea = $eventData['backend_entry_toolbar_body:textarea'];
                        } else {
                            $txtarea = "serendipity[body]";
                        }
                        if (!$serendipity['wysiwyg']) {
                            $this->generate_button($txtarea);
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                     break;


                case 'external_plugin':
                    $uri_parts = explode('?', str_replace('&amp;', '&', $eventData));
                    $uri_part = $uri_parts[0];
                    $uri_parts = array_pop($uri_parts);
                    $delim = 'q=';
                    $val_num = strpos($uri_parts,$delim);
                    if (is_int($val_num)) {
                        $val = substr($uri_parts, $val_num+2);
                        $_REQUEST['q'] = $val;
                    }

                    switch($uri_part) {
                        case 'mimetex.js':
                            header('Content-Type: text/javascript');
                            echo file_get_contents(dirname(__FILE__) . '/serendipity_event_mimetex.js');
                            return true;
                            break;

                        case 'mimetex.php':
                            $q = html_entity_decode(rawurldecode($_REQUEST['q']));
                            $filetype = $this->get_config('filetype','gif');
                            if (!empty($q)) {
                                $filename = md5($q);
                                $filename_full = '/images/'.$filename.'.'.$filetype;
                                if (!is_file(dirname(__FILE__) . $filename_full)) {
                                    if($this->get_config('mimetex_or_latex','mimetex') == "latex")  {
                                        include (dirname(__FILE__)."/latexrender/class.latexrender.php");
                                        $config_data = array('picture_path' => dirname(__FILE__).'/images/',
                                                             'tmp_dir' => $serendipity['serendipityPath'] . 'templates_c',
                                                             'filename' => $filename,
                                                             'latex_path' => $this->get_config('latex_path'),
                                                             'dvips_path' => $this->get_config('dvips_path'),
                                                             'convert_path'=> $this->get_config('convert_path'),
                                                             'filetype'=>$filetype,
                                                             'transparency'=> $this->get_config('transparency'));
                                        $latex = new LatexRender($config_data);
                                        $latex->renderLatex($q);
                                        if ($latex->_errorcode != 0 || !is_file(dirname(__FILE__) . $filename_full)) {
                                            $filename_full = '/images/error.'.$filetype;
                                            //perhaps someday offer some debug access
                                            //echo $latex->_errorextra;
                                        }
                                    } else {
                                        $command = $this->get_config('mimetex_path').' -e "'.dirname(__FILE__).$filename_full.'" '.escapeshellarg($q);
                                        system($command,$error);
                                        if ($error != 0 || !is_file(dirname(__FILE__) . $filename_full)) {
                                           $filename_full = '/images/error.'.$filetype;
                                        }
                                    }
                                }
                            } else {
                                     $filename_full = '/images/error.'.$filetype;
                            }
                            header('Content-Type: image/'.$filetype);
                            $contentsize = filesize(dirname(__FILE__) .$filename_full);
                            if ($contentsize > 0)  {
                                 header("Content-Length: ".$contentsize);
                            }
                            echo file_get_contents(dirname(__FILE__) . $filename_full);
                            return true;
                        break;

                        default:
                            return false;
                        break;
                    }
                    return true;
                    break;

                case 'frontend_display':
                    if ($this->get_config('auto_replace')) {
                        $url1 = '<img src="'.$serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '').'plugin/mimetex.php?q=';
                        $url2 = '" title="';
                        $url3 = '" alt="';
                        $url4 = '" \/>';
                        foreach ($this->markup_elements as $temp) {
                            if (serendipity_db_bool($this->get_config($temp['name'], true)) && isset($eventData[$temp['element']]) &&
                            !$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                            !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                                $element = $temp['element'];
                                $eventData[$element] = preg_replace('/(?<!\\\\)\[tex\](.*?)\[\/tex\]/e', "'$url1'.rawurlencode('\\1').'$url2'.'\\1'.'$url3'.'\\1'.'$url4'", $eventData[$element]);
                            }
                        }
                        return true;
                    } else {
                        return false;
                    }
                    break;

                default:
                    return false;
                    break;
            }
        } else {
            return false;
        }
    }

    function generate_button ($txtarea) {
        global $serendipity;
        if (!isset($txtarea)) {
           $txtarea = 'body';
        }
?>
     <script type="text/javascript" src="<?php echo $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : ''); ?>plugin/mimetex.js"></script>
     <input type="button" class="serendipityPrettyButton input_button"  name="insMimetex" value="<?php echo PLUGIN_EVENT_MIMETEX_NAME_BUTTON; ?>" style="" onclick="serendipity_insTex('<?php echo $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : ''); ?>plugin/mimetex.php','<?php echo $txtarea; ?>')" />
<?php
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>
