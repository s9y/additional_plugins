<?php # 

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_textlinkads extends serendipity_event
{
    var $title = PLUGIN_EVENT_TEXTLINKADS_TITLE;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_TEXTLINKADS_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_TEXTLINKADS_DESC);
        $propbag->add('stackable',     true);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
        $propbag->add('version',       '0.12.1');
        $propbag->add('configuration', array('htmlid', 'xmlfilename'));
        $propbag->add('event_hooks',    array(
            'css'                  => true,
            'external_service_tla' => true,
            'external_service_ad'  => true
        ));
    }

    function example() {
        return PLUGIN_EVENT_TEXTLINKADS_INFO;
    }
    
    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'htmlid':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_TEXTLINKADS_HTMLID);
                $propbag->add('description', '');
                $propbag->add('default',     'textlinkad1');
                break;

            case 'xmlfilename':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_TEXTLINKADS_XMLFILENAME);
                $propbag->add('description', '');
                $propbag->add('default',     'local_0815.xml');
                break;

            default:
                return false;
        }
        return true;
    }

    /* BEGIN FOREIGN CODE */
    function tla_ads() {
        global $serendipity;

        // Number of seconds before connection to XML times out
        // (This can be left the way it is)
        $CONNECTION_TIMEOUT = 10;

        // Local file to store XML
        // This file MUST be writable by web server
        // You should create a blank file and CHMOD it to 666
        $LOCAL_XML_FILENAME = $serendipity['serendipityPath'] . $this->get_config('xmlfilename');

        if (!file_exists($LOCAL_XML_FILENAME)) {
            echo "Text Link Ads script error: $LOCAL_XML_FILENAME does not exist. Please create a blank file named $LOCAL_XML_FILENAME.";
            return false;
        }

        if (!is_writable($LOCAL_XML_FILENAME)) {
            echo "Text Link Ads script error: $LOCAL_XML_FILENAME is not writable. Please set write permissions on $LOCAL_XML_FILENAME.";
            return false;
        }

        if (filemtime($LOCAL_XML_FILENAME) < (time() - 3600) || filesize($LOCAL_XML_FILENAME) < 20) {
            $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : "";
            $user_agent  = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
            $this->tla_updateLocalXML("http://www.text-link-ads.com/xml.php?inventory_key=0FPDC7VH5JLP3YAN8K1M&referer=" . urlencode($request_uri) . "&user_agent=" . urlencode($user_agent), $LOCAL_XML_FILENAME, $CONNECTION_TIMEOUT);
        }

        $xml     = $this->tla_getLocalXML($LOCAL_XML_FILENAME);
        $arr_xml = $this->tla_decodeXML($xml);

        if (!is_array($arr_xml)) {
            return false;
        }
        echo "\n<ul id=\"" . $this->get_config('htmlid') . "\">\n";

        for ($i = 0, $maxi = count($arr_xml['URL']); $i < $maxi; $i++) {
            echo "<li><span>" . $arr_xml['BeforeText'][$i] . " <a href=\"".$arr_xml['URL'][$i]."\">" . $arr_xml['Text'][$i] . "</a> "
                 . $arr_xml['AfterText'][$i] . "</span></li>\n";
        }

        echo "</ul>";
    }

    function tla_updateLocalXML($url, $file, $time_out) {
        if ($handle = fopen($file, "a")) {
            fwrite($handle, "\n");
            fclose($handle);
        }

        if ($xml = $this->file_get_contents_tla($url, $time_out)) {
            $xml = substr($xml, strpos($xml, '<?'));

            if ($handle = fopen($file, "w")) {
                fwrite($handle, $xml);
                fclose($handle);
            }
        }
    }

    function tla_getLocalXML($file) {
        $contents = "";
        if ($handle = fopen($file, "r")){
            $contents = fread($handle, filesize($file)+1);
            fclose($handle);
        }

        return $contents;
    }

    function file_get_contents_tla($url, $time_out) {
        $result = "";
        $url = parse_url($url);

        if ($handle = @fsockopen ($url["host"], 80)) {
            if (function_exists("socket_set_timeout")) {
                socket_set_timeout($handle,$time_out,0);
            } else if(function_exists("stream_set_timeout")) {
                stream_set_timeout($handle,$time_out,0);
            }

            fwrite ($handle, "GET $url[path]?$url[query] HTTP/1.0\r\nHost: $url[host]\r\nConnection: Close\r\n\r\n");
            while (!feof($handle)) {
                $result .= @fread($handle, 40960);
            }
            fclose($handle);
        }

        return $result;
    }

    function html_entity_decode($string) {
        if (function_exists('html_entity_decode')) {
            return html_entity_decode($string);
        }

        // replace numeric entities
        $string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\1"))', $string);
        $string = preg_replace('~&#([0-9]+);~e', 'chr(\1)', $string);
        // replace literal entities
        $trans_tbl = get_html_translation_table(HTML_ENTITIES);
        $trans_tbl = array_flip($trans_tbl);
        return strtr($string, $trans_tbl);
    }

    function tla_decodeXML($xmlstg) {
        $out = "";
        $retarr = "";

        preg_match_all ("/<(.*?)>(.*?)</", $xmlstg, $out, PREG_SET_ORDER);
        $search_ar  = array('<', '>', '"');
        $replace_ar = array('<', '>', '"');
        $n = 0;

        while (isset($out[$n])) {
            $retarr[$out[$n][1]][] = str_replace($search_ar, $replace_ar, $this->html_entity_decode(strip_tags($out[$n][0])));
            $n++;
        }

        return $retarr;
    }
    /* END FOREIGN CODE */

    function generate_content(&$title) {
        $title = $this->title;
    }

    function textlink_custom(&$data) {
        global $serendipity;
        
        $config = explode(':', $data);
        $params['dir']       = $config[0];
        $params['frequency'] = $config[1];
        
        if (!isset($params['dir'])) {
            echo __FUNCTION__ .": missing 'dir' parameter";
            return;
        }
    
        if (!isset($params['frequency'])) {
            $params['frequency'] = 'per-call';
        }
    
        $basedir = dirname(__FILE__) . '/';
        if (!is_dir($basedir . $params['dir'])) {
            echo __FUNCTION__ .": dir '{$basedir}" . (function_exists('serendipity_specialchars') ? serendipity_specialchars($params['dir']) : htmlspecialchars($params['dir'], ENT_COMPAT, LANG_CHARSET)) . " does not exist";
            return;
        }

        $last = $this->get_config('last_' . $data);
        if (empty($last)) {
            $last = 1;
        }
        
        $use_cache = false;
        $now = time();
        switch($params['frequency']) {
            case 'per-call':
                break;

            case 'weekly':
                if ($last > ($now - 86400*7)) {
                    $use_cache = true;
                }
                break;

            case 'daily':
                if ($last > ($now - 86400)) {
                    $use_cache = true;
                }
                break;

            case 'hourly':
                if ($last > ($now - 3600)) {
                    $use_cache = true;
                }
                break;

            case 'half-hour':
                if ($last > ($now - 1800)) {
                    $use_cache = true;
                }
                break;
        }
        
        if ($use_cache) {
            echo "<!--Cached: Last $last, Now $now-->" . $this->get_config('ad_' . $data);
            return;
        }

        $dh    = opendir($basedir . $params['dir']);
        $stack = array();
        while (false !== ($file = readdir($dh))) {
            if ($file[0] == '.') continue;
            if (!preg_match('@\.html?$@', $file)) continue;
            
            $stack[] = $file;
        }
        
        $randomkey = array_rand($stack, 1);
        $file  = $stack[$randomkey];
        
        $out = file_get_contents($basedir . $params['dir'] . '/' . $file);
        echo "<!--Stored {$params['frequency']}: Last $last, Now $now-->$out";
        
        $this->set_config('ad_' . $data, $out);
        $this->set_config('last_' . $data, $now);
        return;
    }


    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'external_service_ad':
                    $this->textlink_custom($eventData);
                    break;

                case 'css':
                    $id = $this->get_config('htmlid');
?>
    ul#<?php echo $id; ?> { width: 100%; list-style: none; overflow: hidden; margin: 0px; padding: 0px; border: 1px solid #000000; border-spacing: 0px; background-color: #F0F0F0; }
    ul#<?php echo $id; ?> li { display: inline; float: left; clear: none; width: 100%; padding: 0px; margin: 0px; }
    ul#<?php echo $id; ?> li span { display: block; width: 100%; padding: 3px; margin: 0px; font-size: 12px; color: #000000; }
    ul#<?php echo $id; ?> li span a { font-size: 12px; color: #0000FF; }
<?php
                    return true;
                    break;

                case 'external_service_tla':
                    $this->tla_ads();
                    return true;
                    break;

                default:
                    return false;
                    break;
            }
        } else {
            return false;
        }
    }
}

/* vim: set sts=4 ts=4 expandtab : */