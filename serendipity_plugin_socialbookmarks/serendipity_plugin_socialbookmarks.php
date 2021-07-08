<?php
/*
    A social bookmark services plug-in - v0.48
    -------------------------------------------------
        email: mattsches@gmail.com
        download: https://github.com/s9y/additional_plugins/tree/master/serendipity_plugin_socialbookmarks
        forum announcement: http://www.s9y.org/forums/viewtopic.php?t=6067
    -------------------------------------------------
    About:
     This social bookmark services plug-in(feed edition) provides a basic social bookmark servies integration into Serendipity via RSS.
     Supports xFolk microformat standard (RC1, see http://microformats.org/wiki/xfolk); that's why taglinks aren't configurable, I guess ;O)

    Based upon:
     Most of the source code was copied from the S9Y del.icio.us plugin v0.2.3 by riscky (thanks!)

    Change log:
    v0.48:
     * upgrade SimplePie library to version 1.4.1 (tags/1.4.2)
     * add access modifiers to class methods
     * fix some minor issues
    v0.47:
     * included more current version of SimplePie
     * added docblocks
    v0.46:
     * fixed problem with encoding!?
     * corrected <script>-Tag (thx again to Andreas <http://www.depretis.at/>)
    v0.45:
     * title now displayed in backend
     * added support for del.icio.us's JS based tag clouds (inspired by Andreas <http://www.depretis.at/sd/archives/5-del.icio.us-Tag-Cloud-im-Serendipity-Joshua-Template.html>)
    v0.44:
     * SimplePie: new version (1.0 Beta 3.2) added
     * del.icio.us, ma.gnolia: they changed the format of their rss feed
     * corrected language files, added explanatory text
     v0.43:
     * automatic security patch
     v0.42:
     * SimplePie: new version (1.0 Beta 3) added
     * small UTF-8 fix
     v0.41:
     * additional features and url fixes for mister-wong.de
     * fixed charset bug (hopefully)
     v0.40:
     * html entities in title attribute
     * added new service: mister-wong.de
     v0.35:
     * fix the fix of $_SERVER['DOCUMENT_ROOT'] ;)
     v0.34:
     * fix use of $_SERVER['DOCUMENT_ROOT'] (garvinhicking)
     * change way of freetag detection
     v0.33:
     * sidebar title now customizable
     * fixed issue with "more" link
     * check if freetag plugin is installed
     v0.32:
     * made tag links more compatible with freetag plugin
     * changed class names
     v0.31:
     * fixed caching problem (thx, kodewulf)
     v0.3:
     * introduced method for getting tags
     * fixed title display
     v0.2:
     * replaced Onyx_RSS with SimplePie (http://simplepie.org/) because of better docs and nicer looks ;O)
     * added tags display

    Todo:
     * fix a bug regarding special characters (or wait for the next SimplePie release, maybe?)
     * convert inline styles to CSS classes
     * remove discontinued services!
     * clean up code
     * filter out sponsored items (inserted by delicious)
*/

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

/**
 * Class serendipity_plugin_socialbookmarks
 */
class serendipity_plugin_socialbookmarks extends serendipity_plugin {

    /**
     * @var string
     */
    public $title = PLUGIN_SOCIALBOOKMARKS_N;

    /**
     * @var array
     */
    public $feed_types = array('misterwong'    => array(   'usr_bookmarks_page'    => 'http://www.mister-wong.de/user/%username%',
                                                        'usr_recent_bookmarks'  => 'http://www.mister-wong.de/rss/user/%username%/',
                                                        'gen_recent_bookmarks'  => 'http://www.mister-wong.de/rss/?more=fresh',
                                                        'gen_popular_bookmarks' => 'http://www.mister-wong.de/rss/?more=popular',
                                                        'usr_js_tagcloud'       => ''),
                            'del.icio.us'   => array(   'usr_bookmarks_page'    => 'http://del.icio.us/%username%',
                                                        'usr_recent_bookmarks'  => 'http://del.icio.us/rss/%username%',
                                                        'gen_recent_bookmarks'  => 'http://del.icio.us/rss/recent',
                                                        'gen_popular_bookmarks' => 'http://del.icio.us/rss/popular',
                                                        'usr_js_tagcloud'       => 'http://del.icio.us/feeds/js/tags/%username%'),
                            'furl'          => array(   'usr_bookmarks_page'    => 'http://www.furl.net/members/%username%',
                                                        'usr_recent_bookmarks'  => 'http://www.furl.net/members/%username%/rss.xml',
                                                        'gen_recent_bookmarks'  => 'http://www.furl.net/members/rss.xml',
                                                        'gen_popular_bookmarks' => 'http://www.furl.net/members/rssPopular.xml?days=1',
                                                        'usr_js_tagcloud'       => ''),
                            'linkroll'      => array(   'usr_bookmarks_page'    => 'http://www.linkroll.com/index.php?action=links&amp;user=%username%',
                                                        'usr_recent_bookmarks'  => 'http://www.linkroll.com/index.php?action=links&amp;user=%username%',
                                                        'gen_recent_bookmarks'  => 'http://www.linkroll.com/xml.php',
                                                        'gen_popular_bookmarks' => 'http://www.linkroll.com/index.php?action=popular',
                                                        'usr_js_tagcloud'       => ''),
                            'ma.gnolia'     => array(   'usr_bookmarks_page'    => 'http://ma.gnolia.com/people/%username%',
                                                        'usr_recent_bookmarks'  => 'http://ma.gnolia.com/rss/full/people/%username%',
                                                        'gen_recent_bookmarks'  => 'http://ma.gnolia.com/rss/full/bookmarks',
                                                        'gen_popular_bookmarks' => 'http://ma.gnolia.com/rss/full/popular',
                                                        'usr_js_tagcloud'       => '')
                            );

    /**
     * @param serendipity_property_bag $propbag
     * @return void
     */
    public function introspect(&$propbag) {
        $this->title = $this->get_config('sidebarTitle', $this->title);

        $propbag->add('name', PLUGIN_SOCIALBOOKMARKS_N);
        $propbag->add('description', PLUGIN_SOCIALBOOKMARKS_D);
        $propbag->add('author', 'Matthias Gutjahr');
        $propbag->add('version', '0.48');
        $propbag->add('requirements',  array(
            'serendipity' => '0.9alpha5',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));	// not sure about the requirements
        $propbag->add('stackable', true);
        $propbag->add('configuration',
            array(  'sidebarTitle',
                    'socialbookmarksService',
                    'socialbookmarksID',
                    'displayNumber',
                    'cacheTime',
                    'moreLink',
                    'displayTags',
                    'specialFeatures',
                    'displayThumbnails',
                    'additionalParams',
                    'explain'
        ));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
    }

    /**
     * @param string $name
     * @param serendipity_property_bag $propbag
     * @return bool
     */
    public function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'sidebarTitle':
            	$propbag->add('type', 'string');
            	$propbag->add('name', PLUGIN_SOCIALBOOKMARKS_TITLE_N);
            	$propbag->add('description', PLUGIN_SOCIALBOOKMARKS_TITLE_D);
            	break;
            case 'socialbookmarksService':
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_SOCIALBOOKMARKS_SOCIALBOOKMARKSSERVICE_N);
                $propbag->add('description', PLUGIN_SOCIALBOOKMARKS_SOCIALBOOKMARKSSERVICE_D);
                $propbag->add('select_values', array(   'del.icio.us' => 'del.icio.us',
                                                        'ma.gnolia' => 'ma.gnolia',
                                                        'furl' => 'Furl',
                                                        'linkroll' => 'Linkroll',
                                                        'misterwong' => 'Mister Wong'));
                $propbag->add('default', 'ma.gnolia');
                break;
            case 'socialbookmarksID':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_SOCIALBOOKMARKS_USERNAME_N);
                $propbag->add('description', PLUGIN_SOCIALBOOKMARKS_USERNAME_D);
                $propbag->add('default', 'numblog');
                break;
            case 'displayNumber':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_SOCIALBOOKMARKS_DISPLAYNUMBER_N);
                $propbag->add('description', PLUGIN_SOCIALBOOKMARKS_DISPLAYNUMBER_D);
                $propbag->add('default', '10');
                break;
            case 'cacheTime':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_SOCIALBOOKMARKS_CACHETIME_N);
                $propbag->add('description', PLUGIN_SOCIALBOOKMARKS_CACHETIME_D);
                $propbag->add('default', 1);
                break;
            case 'moreLink':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_SOCIALBOOKMARKS_MORELINK_N);
                $propbag->add('description', PLUGIN_SOCIALBOOKMARKS_MORELINK_D);
                $propbag->add('default', 'true');
                break;
            case 'displayTags':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_SOCIALBOOKMARKS_DISPLAYTAGS_N);
                $propbag->add('description', PLUGIN_SOCIALBOOKMARKS_DISPLAYTAGS_D);
                $propbag->add('default', 'true');
                break;
            case 'specialFeatures':
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_N);
                $propbag->add('description', PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_D);
                $propbag->add('select_values', array(   'usr_recent_bookmarks' => PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_USR_RECENT,
                                                        'gen_recent_bookmarks' => PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_GEN_RECENT,
                                                        'gen_popular_bookmarks'=> PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_GEN_POPULAR,
                                                        'usr_js_tagcloud'      => PLUGIN_SOCIALBOOKMARKS_SPECIALFEATURES_USR_JS_TAGCLOUD));
                $propbag->add('default', 'usr_recent_bookmarks');
                break;
            case 'displayThumbnails':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_SOCIALBOOKMARKS_DISPLAYTHUMBS_N);
                $propbag->add('description', PLUGIN_SOCIALBOOKMARKS_DISPLAYTHUMBS_D);
                $propbag->add('default', 'false');
                break;
            case 'additionalParams':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_SOCIALBOOKMARKS_ADDPARAMS_N);
                $propbag->add('description', PLUGIN_SOCIALBOOKMARKS_ADDPARAMS_D);
                $propbag->add('default', '?icon;count=30;size=10-20;color=87ceeb-0000ff;title=my%20del.icio.us%20tags;name;showadd');
                break;
            case 'explain':
                $propbag->add('type', 'content');
                $propbag->add('default', PLUGIN_SOCIALBOOKMARKS_EXPLAIN);
                break;
            default:
                return false;
        }
        return true;
    }

    /**
     * @param string $title
     * @return bool
     */
    public function generate_content(&$title) {
        global $serendipity;

        $socialbookmarksID = $this->get_config('socialbookmarksID');
        if (empty($socialbookmarksID)) {
            return false;
        }

        $socialbookmarksService = $this->get_config('socialbookmarksService');
        if (($title = $this->get_config('sidebarTitle')) === '') {
            $title = $socialbookmarksService;
        }
        $moreLink = $this->get_config('moreLink');

        $md5_socialbookmarksID = md5($socialbookmarksID);
        $md5_socialbookmarksService = md5($socialbookmarksService);

        $displayNumber = $this->get_config('displayNumber');
        if ($displayNumber < 1 || $displayNumber > 30) {
            $displayNumber = 30;
        }

        if ($this->get_config('cacheTime') > 0) {
            $cacheTime = ($this->get_config('cacheTime') * 3600);
        } else {
            $cacheTime = 3600 + 1 ;
        }

        $gsocialbookmarksURL        = $this->feed_types[$socialbookmarksService]['usr_bookmarks_page'];
        $gsocialbookmarksFeedURL    = $this->feed_types[$socialbookmarksService][$this->get_config('specialFeatures')];
        $gsocialbookmarksCacheLoc   = $serendipity['serendipityPath'].'/templates_c/socialbookmarks_';
        $parsedCache                = $gsocialbookmarksCacheLoc.$md5_socialbookmarksService.'_'.$md5_socialbookmarksID.'.cache';

        if (!is_file($parsedCache) || ((time() - filectime($parsedCache)) > $cacheTime)) {
            if (!@mkdir($gsocialbookmarksCacheLoc, 0775) && !is_dir($gsocialbookmarksCacheLoc)) {
                print 'Try to chmod go+rwx - permissions are wrong.';
            }

            if ($this->get_config('specialFeatures') !== 'usr_js_tagcloud') {
                if (file_exists(S9Y_PEAR_PATH . '/simplepie/simplepie.inc')) {
                    require_once S9Y_PEAR_PATH . '/simplepie/simplepie.inc';
                } else {
                    require_once __DIR__ . '/simplepie/simplepie.inc';
                }
                $socialbookmarksFeed = new SimplePie();
                $socialbookmarksFeed->set_feed_url(str_replace('%username%',urlencode(utf8_decode(stripslashes($socialbookmarksID))),$gsocialbookmarksFeedURL));
                $socialbookmarksFeed->set_cache_location($serendipity['serendipityPath'] . '/templates_c/');
                $socialbookmarksFeed->enable_cache(false);
                $socialbookmarksFeed->init();
                $socialbookmarksFeed->handle_content_type();
    
                if ($socialbookmarksFeed->data) {
                    $fileHandle = @fopen($parsedCache, 'w');
                    if ($fileHandle) {
                        $socialbookmarksContent = '<ul class="serendipity_socialbookmarks_list" style="padding:0.1em;list-style-type:none;font-size:1em;">' . "\r\n";
                        $max = $socialbookmarksFeed->get_item_quantity($displayNumber);
                        for ($x = 0; $x < $max; $x++) {
                            /** @var SimplePie_Item $item */
                            $item = $socialbookmarksFeed->get_item($x);
                            $socialbookmarksContent .= '<li class="serendipity_socialbookmarks_item xfolkentry" style="list-style-type:' . ($this->get_config('displayThumbnails') ? 'none' : 'square') . ';list-style-position:inside;">';
                            $socialbookmarksContent .= '<a href="' . $this->decode($item->get_permalink()).' " class="taggedlink" title="' . trim(substr($this->decode((function_exists('serendipity_specialchars') ? serendipity_specialchars(strip_tags($item->get_description())) : htmlspecialchars(strip_tags($item->get_description()), ENT_COMPAT, LANG_CHARSET))), 0, 100)) . '" rel="external">';
                            if ($this->get_config('displayThumbnails')) {
                                $socialbookmarksContent .= $this->socialbookmarks_get_thumbnail($item->get_description());
                            } else {
                                $socialbookmarksContent .= html_entity_decode($this->decode($item->get_title()), ENT_COMPAT, LANG_CHARSET);
                            }
                            $socialbookmarksContent .= '</a>';
                            if ($this->get_config('displayTags') && class_exists('serendipity_event_freetag')) {	// display tags for each bookmark
                                $socialbookmarksContent .= $this->socialbookmarks_get_tags($item);
                            }
                            $socialbookmarksContent .= '</li>' . "\r\n";
                        }
    
                        $socialbookmarksContent .= '</ul>';
                        fwrite($fileHandle, $socialbookmarksContent);
                        fclose($fileHandle);
                        print $socialbookmarksContent;
                    } else {
                        print 'A '.$this->get_config('socialbookmarksService').' error occured! <br />'.'Error Message: unable to make a socialbookmarks cache file: '.$parsedCache.'!';
                    }
                } elseif (is_file($parsedCache)) {
                    print file_get_contents($parsedCache);
                } else {
                    print 'A '.$this->get_config('socialbookmarksService').' error occured! <br />'.'Error Message: rss failed';
                }
            } else {
                $gsocialbookmarksFeedURL = str_replace('%username%',urlencode(utf8_decode(stripslashes($socialbookmarksID))),$gsocialbookmarksFeedURL);
                echo('<script type="text/javascript" src="' . $gsocialbookmarksFeedURL . $this->get_config('additionalParams') . '"></scipt>');
            }
        } else {
            print file_get_contents($parsedCache);
        }

        if (serendipity_db_bool($moreLink)) {
            print '<a href="'.str_replace('%username%', urlencode(utf8_decode(stripslashes($socialbookmarksID))), $gsocialbookmarksURL).'/">('.PLUGIN_SOCIALBOOKMARKS_MORELINK.')</a>';
        }
        return true;
    }

    /**
     * @param SimplePie_Item $item
     * @return string
     */
    private function socialbookmarks_get_tags($item) {
        global $serendipity;

        $return = '';
        $taglink = $serendipity['baseURL'].($serendipity['rewrite'] === 'none'?$serendipity['indexFile'].'?/':'').'plugin/tag/';

        switch ($this->get_config('socialbookmarksService')) {
            case 'del.icio.us': // quite easy
                $return .= '<br/><p style="font-size:.7em;margin:0;padding:0" class="serendipity_socialbookmarks_tags">[Tags:';
                /** @var array $tags */
                $tags = $item->get_categories();
                if ($tags !== null) {
                    /** @var SimplePie_Category $tag */
                    foreach ($tags as $tag) {
                        $return .= ' <a href="' . $taglink . socialbookmarks_freetag_compat(strtolower($tag->get_term())) . '" rel="tag">' . strtolower($tag->get_term()) . '</a>';
                    }
                }
                $return .= ']</p>';
                break;
            case 'ma.gnolia': // they've changed this recently
                $return .= '<br/><p style="font-size:.7em;margin:0;padding:0" class="serendipity_socialbookmarks_tags">[Tags:';
                /** @var array $tags */
                $tags = $item->get_categories();
                if ($tags !== null) {
                    foreach ($tags as $tag) {
                        $return .= ' <a href="' . $taglink . socialbookmarks_freetag_compat(strtolower($tag)) . '" rel="tag">' . strtolower($tag) . '</a>';
                    }
                }
                $return .= ']</p>';
                break;
            case 'furl':
                $return .= '<br/><p style="font-size:.7em;margin:0;padding:0" class="serendipity_socialbookmarks_tags">[Tags:';
                /** @var array $tags */
                $tags = $item->get_category();
                if ($tags !== null) {
                    foreach ($tags as $tag) {
                        $return .= ' <a href="' . $taglink . socialbookmarks_freetag_compat(strtolower($tag)) . '" rel="tag">' . strtolower($tag) . '</a>';
                    }
                }
                $return .= ']</p>';
                break;
            case 'misterwong':
            case 'linkroll':
                // services don't provide tags in their RSS feeds (yet)!?
            default:
                break;
        }
        return $return;
    }

    /**
     * @param string $item
     * @return string
     */
    private function socialbookmarks_get_thumbnail($item) {
        $regexp = '/(<img[^>]*src=")([^"]*)("[^>]*>)/i';
        preg_match($regexp, $item, $img);
        $return = $img[1] . $img[2] . '" style="border:none;margin:none;padding:none;" />';
        return $return;
    }

    /**
     * @param string $string
     * @return string
     */
    private function decode($string) {
        if (LANG_CHARSET !== 'UTF-8') {
            return utf8_decode($string);
        }
        return $string;
    }
}

/**
 * @param string $tag
 * @return mixed
 */
function socialbookmarks_freetag_compat($tag) {
    return str_replace(' ', '+', $tag);
}
