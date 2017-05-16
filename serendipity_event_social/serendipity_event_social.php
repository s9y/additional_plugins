<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_social extends serendipity_event {
    var $title = PLUGIN_EVENT_SOCIAL_NAME;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_SOCIAL_NAME);
        $propbag->add('description',   PLUGIN_EVENT_SOCIAL_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'onli, Matthias Mees, Thomas Hochstein');
        $propbag->add('version',       '0.12.1');
        $propbag->add('requirements',  array(
            'serendipity' => '2.0'
        ));
        $propbag->add('event_hooks',   array('frontend_display:html:per_entry' => true,
                                       'css' => true,
                                       'frontend_footer' => true,
                                       'frontend_header' => true));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));

        $propbag->add('configuration', array('services', 'theme', 'overview', 'twitter_via', 'social_image', 'lang', 'backend'));
    }

    function generate_content(&$title) {
        $title = $this->title;
    }


    function introspect_config_item($name, &$propbag) {
        global $serendipity;
        switch($name) {
            case 'services':
                $propbag->add('type',           'multiselect');
                $propbag->add('name',           PLUGIN_EVENT_SOCIAL_SERVICES);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_SERVICES_DESC);
                $propbag->add('default',        'twitter^facebook^googleplus');
                $propbag->add('select_values',  array('twitter' => 'twitter', 'facebook' => 'facebook', 'googleplus' => 'googleplus', 'linkedin' => 'linkedin', 'pinterest' => 'pinterest', 'xing' => 'xing', 'whatsapp' => 'whatsapp', 'mail' => 'mail', 'info' => 'info', 'addthis' => 'addthis', 'tumblr' => 'tumblr', 'flattr' => 'flattr', 'diaspora' => 'diaspora', 'reddit' => 'reddit', 'stumbleupon' => 'stumbleupon', 'threema' => 'threema'));
                break;
            case 'theme':
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_SOCIAL_THEME);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_THEME_DESC);
                $propbag->add('select_values',  array('standard' => PLUGIN_EVENT_SOCIAL_THEME_STD, 'white' => PLUGIN_EVENT_SOCIAL_THEME_WHITE, 'grey' => PLUGIN_EVENT_SOCIAL_THEME_GREY));
                $propbag->add('default',        'standard');
                break;
            case 'overview':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_SOCIAL_OVERVIEW);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_OVERVIEW_DESC);
                $propbag->add('default',        true);
                break;
            case 'twitter_via':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_SOCIAL_TWITTERVIA);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_TWITTERVIA_DESC);
                $propbag->add('default',        'none');
                break;
            case 'lang':
                $propbag->add('type',           'select');
                $propbag->add('name',           INSTALL_LANG);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_LANG_DESC);
                $propbag->add('default',        'en');
                $propbag->add('select_values',        array('bg' => 'bg', 'de' => 'de', 'en' => 'en', 'es' => 'es', 'fi' => 'fi', 'hr' => 'hr', 'hu' => 'hu', 'ja' => 'ja', 'ko' => 'ko', 'no' => 'no', 'pl' => 'pl', 'pt' => 'pt', 'ro' => 'ro', 'ru' => 'ru', 'sk' => 'sk', 'sl' => 'sl', 'sr' => 'sr', 'sv' => 'sv', 'tr' => 'tr', 'zh' => 'zh'));
                break;
            case 'backend':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_SOCIAL_BACKEND);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_BACKEND_DESC);
                $propbag->add('default',        'https://onli.columba.uberspace.de/s9y_shariff/');
                break;
            case 'social_image':
                $propbag->add('type',           'media');
                $propbag->add('name',           PLUGIN_EVENT_SOCIAL_IMAGE);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_IMAGE_DESC);
                $propbag->add('default',        '');
                break;

        }
        return true;
    }


    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_display:html:per_entry':
                    if ($serendipity['view'] != 'entry') {
                        if (! serendipity_db_bool($this->get_config('overview', true))) {
                            // We are in overview mode and the user opted to not show the button
                            return true;
                        }
                        // when sharing on the frontpage, at least the twitter button is using the page title instead of the entry title, so we set that manually
                        $hardcoded_title = ' data-title="' . $eventData['title'] .'"';
                    }
                    $twitter_via = $this->get_config('twitter_via', 'none');
                    if ($twitter_via != 'none') {
                        $twitter_via_tag = ' data-twitter-via="' . str_replace('@', '', $twitter_via) .'"';
                    }
                    $backend = $this->get_config('backend', 'https://onli.columba.uberspace.de/s9y_shariff/');
                    if ($backend != 'none') {
                        $backend_tag = ' data-backend-url="' . $backend .'"';
                    }
                    $theme = $this->get_config('theme');
                    $lang = $this->get_config('lang', 'en');
                    $services = $this->get_config('services');
                    $services = '&quot;' . str_replace('^', '&quot;,&quot;', $services) . '&quot;';
                    if (strpos($services, 'info') !== false) {
                        // the info button looks strange if not at the end, hardcode that position
                        $services = str_replace(',&quot;info&quot;', '', $services) . ',&quot;info&quot;';
                    }
                    
                    $eventData['display_dat'] = '<div class="shariff" data-url="' . $eventData['rdf_ident'] .'" data-services="[' . $services . ']" data-lang="' . $lang .'" data-theme="' . $theme . '" data-mail-url="mailto:foo@example.org"'. $hardcoded_title . $twitter_via_tag . $backend_tag . '></div>';
                    break;
                    
                case 'css':
                    $eventData .= file_get_contents(dirname(__FILE__) . '/shariff.complete.css');
                    break;
                    
                case 'frontend_footer':
                    // this script should go into the JS hook, but it has to be at the bottom to work, and the js hook places it at the top
                    echo '<script src="' . $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_social/shariff.min.js' . '"></script>';
                    break;
                    
                case 'frontend_header':
                    if ($serendipity['view'] != 'entry') {
                        return true;
                    }
                    // Facebook & Twitter can profit from having the og-properties set
                    if (strpos($this->get_config('services'), 'facebook') !== false || strpos($this->get_config('services'), 'twitter') !== false) {
                        
                        // we iterate over the internal smarty object to see which entry we are printing. This is hacky and should be improved
                        $entry = (current($eventData['smarty']->tpl_vars['entries']->value)['entries'][0]);

                        $blogURL = 'http' . ($_SERVER['HTTPS'] ? 's' : '') . '://' . $_SERVER['HTTP_HOST'];
                        
                        echo '<!--serendipity_event_shariff-->' . "\n";
                        echo '<meta name="twitter:card" content="summary" />' . "\n";
                        echo '<meta property="og:title" content="' . serendipity_specialchars($entry['title']) . '" />' . "\n";
                        # get desciption from serendipity_event_metadesc, if set; take first 200 chars from body otherwise
                        $meta_description = strip_tags($entry['properties']['meta_description']);
                        if (empty($meta_description)) {
                                                                 # /\s+/: multiple newline and whitespaces
                            $meta_description = trim(preg_replace('/\s+/', ' ', substr(strip_tags($entry['body']), 0, 200))) . '...';
                        }
                        echo '<meta property="og:description" content="' . serendipity_specialchars($meta_description) . '" />' . "\n";
                        echo '<meta property="og:type" content="article" />' . "\n";
                        echo '<meta property="og:site_name" content="' . $serendipity['blogTitle'] . '" />' . "\n";
                        echo '<meta property="og:url" content="'. $blogURL . serendipity_specialchars($_SERVER['REQUEST_URI']) . '" />' . "\n";

                        $social_image = $this->get_config('social_image', '');
                        if (isset($entry['properties']) && isset($entry['properties']['timeline_image'])) {
                            $social_image = $entry['properties']['timeline_image'];
                        } else if (isset($entry['properties']) && isset($entry['properties']['ep_featuredImage'])) {
                            $social_image = $entry['properties']['ep_featuredImage'];
                        } else {
                            // This is searching for the first image in an entry to use as facebook article image.
                            // A better approach would be to register in the entry editor when an image was added
                            if (preg_match_all('@<img.*src=["\'](.+)["\']@imsU', $entry['body'] . $entry['extended'], $images)) {
                                foreach ($images[1] as $im) {
                                    if (strpos($im, '/emoticons/') === false) {
                                        $social_image = $im;
                                        break;
                                    }
                                }
                            }
                        }

                        if (! preg_match('/^http/i', $social_image)) {
                            $social_image = $blogURL . $social_image;
                        }
                        
                        if ($social_image != $blogURL && $social_image != $blogURL . 'none') {
                            echo '<meta property="og:image" content="' . $social_image . '" />' . "\n";
                        }
                    }
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
