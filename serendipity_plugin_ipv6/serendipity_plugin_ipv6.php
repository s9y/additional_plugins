<?php // 

if (IN_serendipity !== TRUE) {
    die('Don\'t hack!');
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_plugin_ipv6 extends serendipity_plugin
{
    var $title = 'IPv6 Check';
    
    function introspect(&$propbag) {
        global $serendipity;
        
        $propbag->add('name',            PLUGIN_IPV6_NAME);
        $propbag->add('description',     PLUGIN_IPV6_DESC);
        $propbag->add('stackable',       FALSE);
        $propbag->add('author',          'Pascal Uhlmann');
        $propbag->add('version',         '1.0.0');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups',         'FRONTEND_VIEWS');
        $propbag->add('configuration',  array('title', 'success_msg', 'error_msg'));
    }
    
    function introspect_config_item($name, &$propbag) {
        switch ($name) {
            case 'title':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_IPV6_CONFIG_TITLE);
                $propbag->add('description', PLUGIN_IPV6_CONFIG_TITLE_DESC);
                $propbag->add('default', $this->title);
                break;
            
            case 'success_msg':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_IPV6_CONFIG_SUCCESS_MESSAGE);
                $propbag->add('description', PLUGIN_IPV6_CONFIG_SUCCESS_MESSAGE_DESC);
                $propbag->add('default', '');
                break;
            
            case 'error_msg':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_IPV6_CONFIG_ERROR_MESSAGE);
                $propbag->add('description', PLUGIN_IPV6_CONFIG_ERROR_MESSAGE_DESC);
                $propbag->add('default', '');
                break;
            
            default:
                return FALSE;
        }
        return TRUE;
    }
    
    function generate_content(&$title) {
        global $serendipity;
        
        $title = $this->get_config('title', $this->title);
        $ip_version = $this->get_ip_version($_SERVER['REMOTE_ADDR']);
        if($ip_version !== FALSE) {
            $content = sprintf("<b>".$this->get_config('success_msg', PLUGIN_IPV6_CONFIG_SUCCESS_MESSAGE_DEFAULT)."</b>", $ip_version);
        }
        else {
            $content = "<b>".$this->get_config('error_msg', PLUGIN_IPV6_CONFIG_ERROR_MESSAGE_DEFAULT)."</b>";
        }
        print $content;
    }
    
    /**
     * Determine the IP version of the given IP address
     * @param string $ip Address whose IP version shall be determined
     * @return string|bool Can be 'IPv4' or 'IPv6' in case of success or FALSE on error
     */
    function get_ip_version($ip) {
        // Patterns don't check the IP address for exact validity. But
        // in this case the following checks should be sufficient.
        $ipv6_patterns = array(	// Complete IPv6 address
                                '([a-f0-9]{1,4}:){7}[a-f0-9]{1,4}',
                                // IPv6 address with stripped leading zeros
                                ':(:[a-f0-9]{1,4}){1,6}',
                                // IPv6 address with stripped trailing zeros
                                '([a-f0-9]{1,4}:){1,6}:',
                                // IPv6 address with stripped zeros in the middle
                                '([a-f0-9]{1,4}:){1,6}(:[a-f0-9]{1,4}){1,6}',
                                // IPv6 address with only zeros
                                '::'
                                );
        
        if (preg_match(sprintf('/^%s$/i', implode('|', $ipv6_patterns)), $ip)) {
            return 'IPv6';
        }
        elseif (preg_match('/^(\d{1,3}\.){3}\d{1,3}$/', $ip)) {
            return 'IPv4';
        }
        else {
            return FALSE;
        }
    }
}

/* vim: set sts=4 ts=4 expandtab : */