<?php # 

/*
 * EXPERIMANTEL CACHING PLUGIN
 *
 * This plugin will create PEAR::Cache_Lite static pages. It will only parse
 * basic frontend pages.
 *
 * GOTCHAS:
 * --------
 *
 * - Does not work well with dynamic plugins (karma, ...)
 * - Prohibits referrer-tracking
 * - header() calls in cached output will not be part of the cache output later
 *   on, which is the reason why CSS will not get cached
 * - And probably some more...
 *
 * TODO:
 * ----
 *
 * - TESTING
 * - Improving the purge function to only purge certain elements and not
 *   every cache
 * - Check interoperatibility to dynamic plugins - TESTING! :)
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

class serendipity_event_cachesimple extends serendipity_event
{
    var $debug = false;

    var $title = PLUGIN_EVENT_CACHESIMPLE_NAME;
    var $cache = null;
    var $cache_group = 'serendipity_cachesimple';
    var $cache_key = '';
    var $cached = false;
    var $disallowed_files = array(
        'serendipity_admin.php',
        'serendipity_admin_image_selector.php',
        'serendipity_xmlrpc.php',
        'comment.php',
        'exit.php',
        'serendipity_define.js.php',
        'serendipity.css.php',
        'wfwcomment.php'
    ); // Leaves only index.php and rss.php

    function __construct() {
        // garvin: Nasty shortcircuit to get Grandma's Performance Pennies.

        if ($this->cacheAllowed()) {
            $null = null;
            $bypass_data = array('shortcircuit' => true);
            $this->event_hook('frontend_shortcircuit', $null, $bypass_data);
        }
    }

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',        PLUGIN_EVENT_CACHESIMPLE_NAME);
        $propbag->add('description', PLUGIN_EVENT_CACHESIMPLE_DESC);
        $propbag->add('stackable',   false);
        $propbag->add('author',      'Garvin Hicking');
        $propbag->add('version',     '1.2.2');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks', array(
            'frontend_configure'    => true,
            'frontend_comment'      => true,
            'frontend_saveComment'  => true,
            'backend_publish'       => true,
            'backend_save'          => true,
            'frontend_shortcircuit' => true,
            'xmlrpc_deleteEntry'    => true,
            'xmlrpc_updateEntry'    => true
        ));
        $propbag->add('groups', array('BACKEND_FEATURES'));
        $propbag->add('configuration', array('browser','keep_fresh'));
    }

    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'browser':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_CACHESIMPLE_BROWSER);
                $propbag->add('description', '');
                $propbag->add('default',     false);
                break;

            case 'keep_fresh':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_CACHESIMPLE_KEEPFRESH);
                $propbag->add('description', PLUGIN_EVENT_CACHESIMPLE_KEEPFRESH_DESC);
                $propbag->add('default',     false);
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function cacheHeaders($lm = null) {
        global $serendipity;

        if ($lm === null || empty($lm)) {
            $last_modified_ts = serendipity_serverOffsetHour();
        } else {
            $last_modified_ts = serendipity_serverOffsetHour($lm, true);
        }

        $modified_since = !empty($_SERVER['HTTP_IF_MODIFIED_SINCE'])
                        ? gmdate('D, d M Y H:i:s \G\M\T', serendipity_serverOffsetHour(strtotime(stripslashes($_SERVER['HTTP_IF_MODIFIED_SINCE'])), true))
                        : false;
        $none_match     = !empty($_SERVER['HTTP_IF_NONE_MATCH'])
                        ? str_replace('"', '', stripslashes($_SERVER['HTTP_IF_NONE_MATCH']))
                        : false;

        $last_modified = gmdate('D, d M Y H:i:s \G\M\T', $last_modified_ts);
        $etag          = '"' . $last_modified . '"';

        serendipity_header('Last-Modified: ' . $last_modified);
        serendipity_header('ETag: '          . $etag);

        if (($none_match == $last_modified && $modified_since == $last_modified) ||
            (!$none_match && $modified_since == $last_modified) ||
            (!$modified_since && $none_match == $last_modified)) {
            header('HTTP/1.0 304 Not Modified');
            header('Status: 304 Not Modified');
            return true;
        }

        return false;
    }

    function debugMsg($msg) {
        global $serendipity;

        if (!$this->debug) {
            return false;
        }

        $this->debug_fp = @fopen($serendipity['serendipityPath'] . 'templates_c/cachesimple.log', 'a');
        if (!$this->debug_fp) {
            return false;
        }

        if (empty($msg)) {
            fwrite($this->debug_fp, "\n");
        } else {
            fwrite($this->debug_fp, '[' . date('d.m.Y H:i') . '] ' . $msg . "\n");
        }
        fclose($this->debug_fp);
    }

    function cacheAllowed() {
        global $serendipity;

        if (in_array(basename($_SERVER['PHP_SELF']), $this->disallowed_files)) {
            $this->debugMsg(basename($_SERVER['REQUEST_URI']) . ' cannot be cached.');
            return false;
        }

        if (count($serendipity['POST']) > 0) {
            $this->debugMsg('POST to ' . $_SERVER['REQUEST_URI'] . ' not cached');
            return false;
        }

        if (isset($GLOBALS['css_mode'])) {
            // Don't cache CSS, headers() are not cached.
            $this->debugMsg('Not caching CSS files.');
            return false;
        }

        if ((basename($_SERVER['PHP_SELF']) == 'rss.php' || (defined('PAT_FEEDS') && preg_match(PAT_FEEDS, $_SERVER['REQUEST_URI']))) &&
            !empty($_SERVER['HTTP_IF_MODIFIED_SINCE']) &&
            !empty($_SERVER['HTTP_IF_NONE_MATCH'])) {
            $this->debugMsg('RSS Cache lives on itself to enable Conditional GET.');
            return false;
        }

        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = array();

        if (is_object($bag)) {
            $hooks = &$bag->get('event_hooks');
        } elseif (is_array($eventData) && $eventData['shortcircuit']) {
            $hooks[$event] = true;
        }

        if (isset($hooks[$event])) {
            $this->debugMsg('');
            $this->debugMsg($_SERVER['REQUEST_URI']);

            @include_once 'Cache/Lite.php';

            if (!class_exists('Cache_Lite')) {
                $this->debugMsg('Cache_Lite not available.');
                return false;
            }

            $options = array(
                'cacheDir' => $serendipity['serendipityPath'] . 'templates_c/',
                'lifeTime' => 3600,
                'hashedDirectoryLevel' => 2
            );

            $this->cache = new Cache_Lite($options);

            switch($event) {
                case 'frontend_comment':
                    if (isset($serendipity['GET']['adminModule']) && $serendipity['GET']['adminModule'] == 'comments') {
                        return true;
                    }
?>
<script type="text/javascript">
// <![CDATA[
function getCommentCookie(name) {
    var dc = document.cookie;
    var prefix = 'serendipity[' + name + "]=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return '';
    } else {
        begin += 2;
    }
    var end = document.cookie.indexOf(";", begin);
    if (end == -1) {
        end = dc.length;
    }

    value = unescape(dc.substring(begin + prefix.length, end));
    if (value && value != null) {
        return value;
    } else {
        return '';
    }
}

document.getElementById('serendipity_commentform_name').value  = getCommentCookie('name');
document.getElementById('serendipity_commentform_email').value = getCommentCookie('email');
document.getElementById('serendipity_commentform_url').value   = getCommentCookie('url');
<?php
                    $post_import = array('name', 'email', 'url');
                    foreach($post_import AS $importvar) {
                        if (!empty($serendipity['POST'][$importvar])) {
                            echo "document.getElementById('serendipity_commentform_$importvar').value   = '" . (function_exists('serendipity_specialchars') ? serendipity_specialchars($serendipity['POST'][$importvar]) : htmlspecialchars($serendipity['POST'][$importvar], ENT_COMPAT, LANG_CHARSET)) . "';\n";
                        }
                    }
?>
// ]]>
</script>
<?php
                    break;

                case 'frontend_configure':
                    if (!$this->cacheAllowed()) {
                        return true;
                    }

                case 'frontend_shortcircuit':
                    $cache_options           = $serendipity['GET'];
                    // This tries to keep individual sites with pre-filled form elements,
                    // but also swamps your cache directory with individual cache files.
                    $cache_options['COOKIE'] = $serendipity['COOKIE'];
                    $cache_options['base']   = $serendipity['baseURL'];
                    unset($cache_options['COOKIE']['author_information']);
                    unset($cache_options['COOKIE']['karmaVote']);
                    unset($cache_options['COOKIE']['name']);
                    unset($cache_options['COOKIE']['url']);
                    unset($cache_options['COOKIE']['email']);

                    if (serendipity_db_bool($this->get_config('browser'))) {
                        if (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE')
                            && !stristr($_SERVER['HTTP_USER_AGENT'], 'Opera')
                            && !stristr($_SERVER['HTTP_USER_AGENT'], 'Mac_PowerPC')
                            && !stristr($_SERVER['HTTP_ACCEPT'], 'text/html')) {

                            $cache_options['browser'] = 'ie';
                        } else {
                            $cache_options['browser'] = 'other';
                        }
                    }

                    $this->cache_key = 'serendipity_cachesimple_' . preg_replace('@[^0-9a-z\-_]@', '_', $_SERVER['REQUEST_URI']) . crc32(serialize($cache_options));

                    $this->debugMsg($this->cache_key . ' cache prepared');
                    $this->cache->_setFileName($this->cache_key, $this->cache_group);


                    if (serendipity_db_bool($this->get_config('keep_fresh',false))) {
                        serendipity_header('Pragma:');
                        serendipity_header('Cache-Control:  max-age=3');
                    } else {
                        serendipity_header('Pragma:');
                        serendipity_header('Cache-Control:  max-age=3600, must-revalidate');
                        serendipity_header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time()+$options['lifeTime']));
                    }

                    if (function_exists('microtime_float')) {
                        $time_end = microtime_float();
                        serendipity_header('X-Serendipity-ParseTime: ' . round($time_end-$GLOBALS['time_start'],6));
                    }

                    // HTTP Conditional Request. May exit with 304.
                    if ($this->cacheHeaders(@filemtime($this->cache->_file))) {
                        exit;
                    }

                    if ($content = $this->cache->get($this->cache_key, $this->cache_group)) {
                        serendipity_header('X-Serendipity-Cache: true');
                        // No valid HTTP Conditional Request. Emit output.
                        echo $content;
                        $this->debugMsg('CACHE HIT');
                        exit;
                    } else {
                        serendipity_header('X-Serendipity-Cache: false');
                        $this->debugMsg('CACHE MISS');
                    }

                    $serendipity['useGzip'] = false;

                    // This is a bit wicked. Index.php already starts a ob, thus
                    // we end it here, output the data so far, start another handler
                    // and forward the data to it. Then we can throw our own handler
                    // later on.

                    // Get previous ob data of the outmost OB and erase it afterwards
                    $prev_data = ob_get_contents();
                    ob_end_clean();

                    // Create our new outmost OB and set a callback method.
                    ob_start(array(&$this, 'storeCache'));

                    // Create a faked inner OB which will be the outmost OB to Serendipity
                    ob_start();

                    // Echo previous data to the faked OB
                    echo $prev_data;

                    // "What comes around, goes around, you'll see." ;)
                    register_shutdown_function(array(&$this, 'shutdown'));

                    return true;
                    break;

                case 'xmlrpc_updertEntry':
                case 'xmlrpc_deleteEntry':
                case 'backend_save':
                case 'backend_publish':
                    $this->purgeCache();
                    return true;
                    break;

                case 'frontend_saveComment':
                    if (is_array($eventData) && serendipity_db_bool($eventData['allow_comments'])) {
                        // Only purge comments if a comment could be made. Prevents purging and recreating cache when
                        // unter spam/referrer attack.
                        $this->purgeCache();
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

    function &storeCache($buffer) {
        $this->cached = true;

        if (isset($GLOBALS['css_mode']) || preg_match(PAT_FEEDS, $_SERVER['REQUEST_URI'])) {
            // Don't cache CSS, headers() are not cached.
            $this->debugMsg('Not caching CSS/RSS files.');
            $retval = false;
            return $retval;
        }

        $this->cache->save($buffer, $this->cache_key, $this->cache_group);
        $this->debugMsg('CACHE STORED (' . strlen($buffer) . ' bytes)');
        return $buffer;
    }

    function purgeCache() {
        $this->debugMsg('CACHE PURGED');
        $this->cache->clean($this->cache_group);
    }

    function uninstall(&$propbag) {
        global $serendipity;

        @include_once 'Cache/Lite.php';
        $options = array(
         'cacheDir' => $serendipity['serendipityPath'] . 'templates_c/',
         'lifeTime' => 3600,
         'hashedDirectoryLevel' => 2
        );

        $this->cache = new Cache_Lite($options);
        $this->cache->clean();
    }

    function shutdown() {
        if ($this->cached === false) {
            $this->debugMsg('Shutdown function: Got Attention.');
            $this->storeCache(ob_get_contents());
        }
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>