<?php #

/* This file creates a package XML file for all additional_plugins CVS files
 *
 * It can only be run by authorized users on special machines. The file
 * ../emerge_spartacus.dat contains the username:password information to mirror servers
 */

header('Content-Type: text/plain');
define('IN_serendipity', true);
error_reporting(E_ALL &  ~E_NOTICE);

class emerge_spartacus {

    var $helper;
    var $pluginpath;
    var $plugins = array();
    var $xmlData = array();
    var $i18n    = true;

    function emerge_spartacus($lang = 'en', $path = '/var/www/virtual/s9y/html/') {
        global $serendipity;

        if ($lang == 'final') {
            $lang = 'en';
            $this->i18n = false;
        }

        // Load Serendipity Framework
        echo "Language set to " . $lang . "\n";
        $this->memSnap('Emerge call');
        include_once $path . 'include/compat.inc.php';
        $serendipity['serendipityPath'] = $path;
        $serendipity['dbType']          = 'mysql';
        $serendipity['lang']            = $lang;
        $serendipity['charset']         = 'UTF-8/';
        define('S9Y_INCLUDE_PATH', $serendipity['serendipityPath']);
        define('S9Y_PEAR_PATH', $serendipity['serendipityPath'] . 'bundled-libs/');
        include_once S9Y_INCLUDE_PATH . 'lang/UTF-8/serendipity_lang_' . $lang . '.inc.php';
        include_once S9Y_INCLUDE_PATH . 'include/plugin_api.inc.php';
        $this->memSnap('Framework loaded');
    }

    function init() {
        $this->pluginpath = dirname(__FILE__);
    }

    function load_plugin(&$plugins) {
        global $serendipity;

        foreach($plugins AS $plugin_name => $plugin_data) {
            $path = $this->pluginpath . '/' . $plugin_data['pluginPath'] . '/';
            include_once $path . $plugin_data['name'] . '.php';
            $plugins[$plugin_name]['plugin'] = new $plugin_data['name']($plugin_name);
            $plugin =&$plugins[$plugin_name]['plugin'];

            if (is_object($plugin)) {
                $bag = new serendipity_property_bag;
                $plugin->introspect($bag);
                $plugins[$plugin_name]['properties'] = $bag->properties;
                $plugins[$plugin_name]['files']      = $this->get_files($plugin_data['pluginPath']);

                if (file_exists($path . 'ChangeLog')) {
                    $plugins[$plugin_name]['properties']['changelog'] = 'https://github.com/s9y/additional_plugins/blob/master/' . $plugin_data['pluginPath'] . '/ChangeLog';
                }

                echo 'Successfully loaded plugin ' . $plugin_name . "\n";
            } else {
                echo 'Error loading plugin ' . $plugin_name . ' (' . $plugin_data['pluginPath'] . ')' . "\n";
            }
            $this->memSnap($plugin_name);
            unset($plugins[$plugin_name]['plugin']);
            $this->memSnap($plugin_name . ' UNSET');
        }
    }

    function memSnap($tshow = '') {
        static $avail    = null;
        static $show     = false;
        static $memUsage = 0;

        if (!$show) {
            return false;
        }

        if ($avail === false) {
            return true;
        } elseif ($avail === null) {
            if (function_exists('memory_get_usage')) {
                $avail = memory_get_usage();
            } else {
                $avail = false;
                return false;
            }
        }

        if ($memUsage === 0) {
            $memUsage = $avail;
        }

        $current = memory_get_usage();
        echo '[' . date('d.m.Y H:i') . '] ' . number_format($current - $memUsage, 2, ',', '.') . ' label "' . $tshow . '",' . "\n" . ' totalling ' . number_format($current, 2, ',', '.') . "\n";
        $memUsage = $current;
    }

    function getTemplates($dir = '/home/s9y/workspace/additional_themes/') {
        $this->i18n = false;
        $ret = serendipity_traversePath($dir, '', true, null, 1, 1);

        $this->xmlData['template'] = array();
        $x = &$this->xmlData['template'];

        $x[] = '<?xml version="1.0" encoding="UTF-8" ?>';
        $x[] = '<!--  -->' . "\n";
        $x[] = '<packages>';

        $_blacklist = explode("\n", file_get_contents($dir . '/blacklist.txt'));
        $blacklist = array();
        foreach($_blacklist AS $idx => $blackline) {
            $blackline = trim($blackline);
            if (empty($blackline)) continue;
            if ($blackline[0] == '#') continue;
            $blacklist[$blackline] = true;
        }

        $t = array();
        $nametofile = array();
        foreach($ret AS $idx => $path) {
            $info = array();
            if (file_exists($dir . $path['name'] . '/info.txt')) {
                $info = serendipity_fetchTemplateInfo($path['name'], $dir);
            }

            if (empty($info['name'])) {
                continue;
            }

            $olddir = getcwd();
            chdir($dir);
            $info['files'] = $this->get_files($path['name']);
            chdir($olddir);

            $td = '';
            $td .= '<h4 class="theme_summary">' . $this->encode($info['name']) . $this->encode($info['summary']) . '</h4>';
            $td .= '<dl class="theme_meta">';
            $td .= '<dt class="theme_name"><img alt="" src="cvs/additional_themes/' . $path['name'] . '/preview_fullsize.jpg"></dt>';
            if (empty($info['version'])) {
                $info['version'] = '1.0';
            }
            if (empty($info['license'])) {
                $info['license'] = 'N/A (=GPL)';
            }
            $td .= '<dd class="theme_version">' . $this->encode(VERSION . ' ' . $info['version']) . '(' . $this->encode($info['license']) . ', ' . $this->encode($info['date']) . ')</dd>';
            $td .= '<dd class="theme_maintainers">' . $this->encode($info['author']) . '</dd>';
            if (!empty($info['require serendipity'])) {
                $td .= '<dd class="theme_requirements">Serendipity &gt;= ' . $this->encode($info['require serendipity']) . '</dd>';
            }
            $td .= '</dl>';
            $td .= '<ul class="theme_actions">';
            if (!isset($blacklist[$path['name']])) {
                $td .= '<li class="theme_demo"><a href="http://blog.s9y.org/index.php?user_template=additional_themes/' . $path['name'] . '">Demo on blog.s9y.org</a></li>';
            }
            $td .= '<li class="theme_download"><a href="cvs/additional_themes/' . $path['name'] . '.zip">Download</a></li>';
            $td .= '</ul>';

            $x[] = '<package version="1.0">';
            $x[] = '<name>' . $this->encode($info['name'], true) . '</name>';
            $x[] = '<template>' . $this->encode($path['name'], true) . '</template>';
            $x[] = '<license>' . $this->encode($info['license'], true) . '</license>';
            $x[] = '<summary>' . $this->encode($info['summary']) . '</summary>';
            $x[] = '<description>' . $this->encode($info['description']) . '</description>';
            $x[] = '<recommended>' . $this->encode($info['recommended']) . '</recommended>';
            $x[] = '<maintainers><maintainer><name>' . $this->encode($info['author'], true) . '</name><role>lead</role></maintainer></maintainers>';

            $x[] = '<release>';
            $x[] = '  <version>' . $this->encode($info['version'], true) . '</version>';
            $x[] = '  <requirements:s9yVersion>' . $this->encode($info['require serendipity'], true) . '</requirements:s9yVersion>';
            $x[] = '  <date>' . $this->encode($info['date'], true) . '</date>';
            $x[] = '  <filelist>';
            $x[] = $info['files']['xml'];
            $x[] = '  </filelist>';

            $x[] = '  <serendipityFilelist>';
            foreach($info['files']['full'] AS $file) {
                $x[] = '    <file>' . $file . '</file>';
            }
            $x[] = '  </serendipityFilelist>';
            $x[] = '</release>';

            $x[] = '</package>';

            $t[$info['name']] .= '<div class="theme">' . $td . '</div>' . "\n";
            $nametofile[$info['name']] = $path['name'];
        }
        $x[] = '</packages>';
        ksort($t);

        $theme_li = '';
        foreach($t as $theme => $html) {
            $theme_li .= '<li><a href="index.php?mode=template_' . $nametofile[$theme] . '">' . $theme . '</a></li>' . "\n";
            $fp = fopen('homepage/template_' . $nametofile[$theme] . '.htm', 'w');
            fwrite($fp, $html);
            fclose($fp);
        }
        $fp = fopen('homepage/template_all.htm', 'w');
        fwrite($fp, implode("\n", $t));
        fclose($fp);

        $fp = fopen('homepage/box_groups_template.htm', 'w');
        fwrite($fp, $theme_li);
        fclose($fp);
    }

    function get_files($path, $init = true) {
        if ($init) {
            $this->helper = array('full' => array(), 'xml' => '');
        }

        if (is_dir($path)) {
            if ($d = opendir($path)) {
                $this->helper['xml'] .= '<dir name="' . basename($path) . '">' . "\n";
                while (($f = readdir($d)) !== false) {
                    if ($f != '.' && $f != '..' && $f != 'CVS') {
                        if (is_dir($path . '/' . $f)) {
                            $this->get_files($path . '/' . $f, false);
                        } else {
                            $this->helper['full'][] = $path . '/' . $f;
                            $this->helper['xml'] .= '<file>' . $f . '</file>' . "\n";
                        }
                    }
                }
                $this->helper['xml'] .= '</dir>' . "\n";
            }
        }

        if ($init) {
            return $this->helper;
        }
    }

    function get_plugins() {
        global $serendipity;

        serendipity_plugin_api::traverse_plugin_dir($this->pluginpath, $this->plugins['event'], true);
        serendipity_plugin_api::traverse_plugin_dir($this->pluginpath, $this->plugins['sidebar'], false);
        $this->load_plugin($this->plugins['event']);
        $this->load_plugin($this->plugins['sidebar']);
    }

    function encode($string, $force_utf8 = false) {
        if ($force_utf8) {
            $string = utf8_encode($string);
            // TODO: This screw must be changed. Many authors entered their
            // names inside plugins, but saved the file as ISO. Since some
            // strings are not localized (like author name), it needs to
            // be ensured that UTF-8 coding is the final result.
        }
        return htmlspecialchars($string);
    }

    function emerge($key) {
        $this->xmlData[$key] = array();
        $x = &$this->xmlData[$key];

        $x[] = '<?xml version="1.0" encoding="UTF-8" ?>';
        $x[] = '<!--  -->' . "\n";
        $x[] = '<packages>';

        foreach($this->plugins[$key] AS $plugin_name => $plugin_data) {
            $version    = isset($plugin_data['properties']['version'])    ? $plugin_data['properties']['version'] : '1.0';
            $s9yVersion = isset($plugin_data['properties']['requirements']['serendipity']) ? $plugin_data['properties']['requirements']['serendipity']    : '0.8';
            $license    = isset($plugin_data['properties']['license'])    ? $plugin_data['properties']['license']    : 'GPL';
            $author     = isset($plugin_data['properties']['author'])     ? $plugin_data['properties']['author']     : 'Serendipity Team';

            $x[] = '<package version="1.0">';
            $x[] = '<name>' . $this->encode($plugin_name, true) . '</name>';
            if (!empty($plugin_data['properties']['website'])) {
                $x[] = '<website>' . $this->encode($plugin_data['properties']['website'], true) . '</website>';
            }
            if (!empty($plugin_data['properties']['changelog'])) {
                $x[] = '<changelog>' . $this->encode($plugin_data['properties']['changelog'], true) . '</changelog>';
            }
            $x[] = '<license>' . $this->encode($license, true) . '</license>';
            $x[] = '<summary>' . $this->encode($plugin_data['properties']['name']) . '</summary>';
            $x[] = '<groups>' . $this->encode(implode(',', (array)$plugin_data['properties']['groups'])) . '</groups>';
            $x[] = '<description>' . $this->encode($plugin_data['properties']['description']) . '</description>';
            $x[] = '<maintainers><maintainer><name>' . $this->encode($author, true) . '</name><role>lead</role></maintainer></maintainers>';

            $x[] = '<release>';
            $x[] = '  <version>' . $this->encode($version, true) . '</version>';
            $x[] = '  <requirements:s9yVersion>' . $this->encode($s9yVersion, true) . '</requirements:s9yVersion>';
            $x[] = '  <date>' . date('Y-m-d', filemtime($plugin_data['pluginPath'] . '/' . $plugin_data['name'] . '.php')) . '</date>';
            $x[] = '  <filelist>';
            $x[] = $plugin_data['files']['xml'];
            $x[] = '  </filelist>';

            $x[] = '  <serendipityFilelist>';
            foreach($plugin_data['files']['full'] AS $file) {
                $x[] = '    <file>' . $file . '</file>';
            }
            $x[] = '  </serendipityFilelist>';
            $x[] = '</release>';

            $x[] = '</package>';
        }
        $x[] = '</packages>';
    }

    function emergeHomepage($key) {
        global $serendipity;

        $groups = array();
        foreach($this->plugins[$key] AS $plugin_name => $plugin_data) {
            $version    = isset($plugin_data['properties']['version'])    ? $plugin_data['properties']['version'] : '1.0';
            $s9yVersion = isset($plugin_data['properties']['requirements']['serendipity']) ? $plugin_data['properties']['requirements']['serendipity']    : '0.8';
            $license    = isset($plugin_data['properties']['license'])    ? $plugin_data['properties']['license']    : 'GPL';
            $author     = isset($plugin_data['properties']['author'])     ? $plugin_data['properties']['author']     : 'Serendipity Team';

            $x = '';
            $x .= '<div class="plugin">';
            $x .= '<div class="plugin_summary">' . $this->encode($plugin_data['properties']['name']) . '</div>';
            $x .= '<div class="plugin_name">' . $this->encode($plugin_name) . '</div>';
            $x .= '<div class="plugin_version">' . $this->encode(VERSION . ' ' . $version) . ' (' . $this->encode($license) . ', ' . $this->encode(LAST_UPDATED) . ' ' . date('Y-m-d', filemtime($plugin_data['pluginPath'] . '/' . $plugin_data['name'] . '.php')) . ')</div>';
            $x .= '<div class="plugin_maintainers">' . $this->encode($author) . '</div>';
            $x .= '<div class="plugin_requirements">Serendipity &gt;= ' . $this->encode($s9yVersion) . '</div>';
            #$x .= '<div class="plugin_groups">' . $this->encode(implode(',', (array)$plugin_data['properties']['groups'])) . '</div>';

            $x .= '<div class="plugin_description">' . $this->encode($plugin_data['properties']['description']) . '</div>';

            if (is_dir($plugin_name)) {
                $zipfile = $plugin_name;
            } else {
                if (stristr($plugin_name, '_event_') !== FALSE) {
                    $zipfile = str_replace('_event_', '_plugin_', $plugin_name);
                } else {
                    $zipfile = str_replace('_plugin_', '_event_', $plugin_name);
                }
            }
            $x .= '<div class="plugin_download"><a href="cvs/additional_plugins/' . $zipfile . '.zip">Download</a> <a href="https://github.com/s9y/additional_plugins/tree/master/' . $this->encode($zipfile) . '">ViewCVS</a>';

            if (!empty($plugin_data['properties']['website'])) {
                $x .= '<br /><a href="' . $this->encode($plugin_data['properties']['website']) . '">Documentation</a>';
            }
            if (!empty($plugin_data['properties']['changelog'])) {
                $x .= '<br /><a href="' . $this->encode($plugin_data['properties']['changelog']) . '">ChangeLog</a>';
            }

            $x .= '</div></div>';

            foreach((array)$plugin_data['properties']['groups'] AS $group) {
                $gnames[constant('PLUGIN_GROUP_' . $group)] = $group;
                $groups[constant('PLUGIN_GROUP_' . $group)][$plugin_data['properties']['name']] = array(
                    'plugin'  => $this->encode($plugin_name),
                    'name'    => $this->encode($plugin_data['properties']['name']),
                    'content' => $x
                );
            }

            $fp = fopen('homepage/byplugin_' . $plugin_name . '_' . $serendipity['lang'] . '.htm', 'w');
            fwrite($fp, $x);
            fclose($fp);
        }

        $fp = fopen('homepage/bygroups_' . $key . '_' . $serendipity['lang'] . '.htm', 'w');
        $li_groups = '';
        ksort($groups);
        foreach($groups AS $gname => $group) {
            $p = array();
            $gshort = $gnames[$gname];
            ksort($group);
            foreach($group AS $plug) {
                $p[] = $plug['content'];
            }
            $c = '<div class="group" id="group_' . $gshort . '">
                    <h3>' . $gname . '</h3>
                    ' . implode("\n", $p) . '
                 </div>';
            fwrite($fp, $c);
            $fp2 = fopen('homepage/bygroup_' . $key . '_' . $gshort . '_' . $serendipity['lang'] . '.htm', 'w');
            fwrite($fp2, $c);
            fclose($fp2);
            $li_groups .= '<li><a href="index.php?mode=bygroup_' . $key . '_' . $gshort . '_[LANG]">' . $gname . '</a></li>' . "\n";
        }
        fclose($fp);

        $fp = fopen('homepage/box_groups_' . $key . '.htm', 'w');
        fwrite($fp, $li_groups);
        fclose($fp);
    }

    function emergeRSS($key, $title) {
        $this->xmlData['RSS' . $key] = array();
        $x = &$this->xmlData['RSS' . $key];

        $x[] = '<?xml version="1.0" encoding="UTF-8" ?>';
        $x[] = '<rss version="2.0" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                                   xmlns:dc="http://purl.org/dc/elements/1.1/"
                                   xmlns:content="http://purl.org/rss/1.0/modules/content/">';
        $x[] = '<channel>';
        $x[] = '<title>Serendipity: Available External ' . $title . '</title>';
        $x[] = '<link>https://github.com/s9y/additional_plugins/</link>';
        $x[] = '<description>TOC</description>';
        $x[] = '<dc:language>en</dc:language>';
        $x[] = '<generator>Serendipity SPARTACUS</generator>';

        foreach($this->plugins[$key] AS $plugin_name => $plugin_data) {
            $version    = isset($plugin_data['properties']['version'])    ? $plugin_data['properties']['version'] : '1.0';
            $s9yVersion = isset($plugin_data['properties']['requirements']['serendipity']) ? $plugin_data['properties']['requirements']['serendipity']    : '0.8';
            $license    = isset($plugin_data['properties']['license'])    ? $plugin_data['properties']['license']    : 'GPL';
            $author     = isset($plugin_data['properties']['author'])     ? $plugin_data['properties']['author']     : 'Serendipity Team';

            $x[] = '<item>';
            $x[] = '<title>' . $this->encode($plugin_data['properties']['name'] . ': ' . $plugin_data['properties']['description']) . '</title>';
            $x[] = '<link>https://github.com/s9y/additional_plugins/tree/master/' . $plugin_data['pluginPath'] . '</link>';
            $x[] = '<category>' . $this->encode($title) . '</category>';
            $x[] = '<author>' . $this->encode($author) . '</author>';
            $x[] = '<content:encoded>' . $this->encode('<b>' . $plugin_name . '<br />' . $plugin_data['properties']['name'] . '</b><br />' . $plugin_data['properties']['description'] . '<br/>For: Serendipity ' . $s9yVersion) . '</content:encoded>';
            $x[] = '<pubDate>' . date('r', filemtime($plugin_data['pluginPath'] . '/' . $plugin_data['name'] . '.php')) . '</pubDate>';
            $x[] = '<guid isPermaLink="false">' . $this->encode($plugin_name) . '</guid>';
            $x[] = '</item>';
        }
        $x[] = '</channel>';
        $x[] = '</rss>';
    }

    function output($key, $ext = 'xml') {
        global $serendipity;

        if ($this->i18n) {
            $remotefile = 'package_' . $key . '_' . $serendipity['lang'] . '.' . $ext;
        } else {
            $remotefile = 'package_' . $key . '.' . $ext;
        }
        $file       = dirname(__FILE__) . '/' . $remotefile;
        $fp = fopen($file, 'w');
        if ($fp) {
            fwrite($fp, implode("\n", $this->xmlData[$key]));
            fclose($fp);
        }

        $this->upload($file, $remotefile);
    }

    function upload($file, $remotefile) {
        static $c, $login;
        if (function_exists('ftp_connect')) {
            if (!is_resource($c) || !$login) {
                $c = ftp_connect('netmirror.org');
                $data = explode(':', file_get_contents('/home/s9y/bin/emerge_spartacus.dat'));
                if (!$c || !is_resource($c)) {
                    echo "FTP Login failed.\n";
                    #die('FTP LOGIN IMPOSSIBLE');
                }

                $login = ftp_login($c, $data[0], $data[1]);
            }
            if ($c && $login) {
                echo 'Uploading ' . $file . ' to ' . $remotefile . "\n";
                if (ftp_delete($c, $remotefile)) {
                    echo 'Previous file ' . $remotefile . ' deleted.' . "\n";
                } else {
                    echo 'ERROR: Could not delete previous file ' . $remotefile . '.' . "\n";
                }
                $retries = 0;
                $retry_count = 3;
                $test = ftp_put($c, $remotefile, $file, FTP_BINARY);
                while (!$test && $retries < $retry_count) {
                    $retries++;
                    sleep(30);
                    ftp_delete($c, $remotefile);
                    $test = ftp_put($c, $remotefile, $file, FTP_BINARY);
                }
            }
        }
    }
}

$lang = (!empty($argv['2']) ? $argv[2] : 'en');
$op   = (!empty($argv['1']) ? $argv[1] : 'plugin');

$spartacus = new emerge_spartacus($lang);
$spartacus->init();

if ($op == 'plugin') {
    $spartacus->get_plugins();
    $spartacus->emerge('event');
    $spartacus->emerge('sidebar');
    $spartacus->output('event');
    $spartacus->output('sidebar');

    $spartacus->emergeRSS('event', 'Event Plugins');
    $spartacus->emergeRSS('sidebar', 'Sidebar Plugins');
    $spartacus->emergeHomepage('event');
    $spartacus->emergeHomepage('sidebar');
    $spartacus->output('RSSevent');
    $spartacus->output('RSSsidebar');

    if ($lang == 'final') {
        emerge_spartacus::upload('additional_plugins.tgz', 'additional_plugins.tgz');
        emerge_spartacus::upload('additional_themes.tgz', 'additional_themes.tgz');
        emerge_spartacus::upload('last.txt', 'last.txt');
        exec('zip -9r spartacus_homepage.zip homepage/ -x \*.png -x \*.php -x \*.css -x \*.sh');
        #emerge_spartacus::upload('spartacus_homepage.zip', 'spartacus_homepage.zip');
        #exec('scp spartacus_homepage.zip garvinhicking@ssh.sf.net:/home/groups/p/ph/php-blog/htdocs/spartacus_homepage.zip');
        #exec('scp last.txt garvinhicking@ssh.sf.net:/home/groups/p/ph/php-blog/htdocs/last.txt');
    }
} elseif ($op == 'template') {
    $spartacus->getTemplates();
    $spartacus->output('template');
    exec('zip -9r spartacus_homepage_template.zip homepage/box_groups_template* homepage/template_*');
    #exec('scp spartacus_homepage_template.zip garvinhicking@ssh.sf.net:/home/groups/p/ph/php-blog/htdocs/spartacus_homepage_template.zip');
    #exec('ssh -l garvinhicking ssh.sf.net /home/groups/p/ph/php-blog/htdocs/cvs/additional_plugins/homepage/update.sh');
}
