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
        $propbag->add('version',       '1.1');
        $propbag->add('requirements',  array(
            'serendipity' => '2.0'
        ));
        $propbag->add('event_hooks',   array('frontend_display:html:per_entry' => true,
                                       'css' => true,
                                       'frontend_header' => true,
                                       'backend_display' => true,
                                       'backend_publish' => true,
                                       'backend_save' => true));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));

        $propbag->add('configuration', array('services', 'theme', 'size', 'overview', 'twitter_via', 'mastodon_via', 'bluesky_via', 'social_image'));

        $propbag->add('legal',    array(
            'services' => array(
                'tootpick' => array(
                    'url' => 'https://tootpick.org/',
                    'desc' => 'When enabled, this toot backend will receive user data and metadata.'
                )
            ),
            'frontend' => array(
                'When sharing functions of the plugin are used by the visitor, those selected sharing services will receive the URL and the metadata of the visitor (IP, User Agent, Referrer, etc.).',
            ),
            'backend' => array(
            ),
            'cookies' => array(
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => false,
            'transmits_user_input'  => true
        ));

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
                $propbag->add('default',        'twitter^facebook');
                $propbag->add('select_values',  array('mastodon' => 'mastodon', 'bluesky' => 'bluesky', 'twitter' => 'X', 'facebook' => 'facebook', 'linkedin' => 'linkedin', 'pinterest' => 'pinterest', 'xing' => 'xing', 'whatsapp' => 'whatsapp', 'mail' => 'mail', 'tumblr' => 'tumblr', 'diaspora' => 'diaspora', 'reddit' => 'reddit', 'threema' => 'threema', 'weibo' => 'weibo', 'qzone' => 'qzone', 'telegram' => 'telegram', 'vk' => 'vk', 'flipboard' => 'flipboard', 'buffer' => 'buffer', 'pocket' => 'pocket'));
                break;
            case 'theme':
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_SOCIAL_THEME);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_THEME_DESC);
                $propbag->add('select_values',  array('standard' => PLUGIN_EVENT_SOCIAL_THEME_STD, 'white' => PLUGIN_EVENT_SOCIAL_THEME_WHITE, 'grey' => PLUGIN_EVENT_SOCIAL_THEME_GREY));
                $propbag->add('default',        'standard');
                break;
            case 'size':
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_SOCIAL_SIZE);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_SIZE_DESC);
                $propbag->add('select_values',  array('standard' => PLUGIN_EVENT_SOCIAL_SIZE_STD, 'icons' => PLUGIN_EVENT_SOCIAL_SIZE_ICONS));
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
            case 'mastodon_via':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_SOCIAL_MASTODONVIA);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_MASTODONVIA_DESC);
                $propbag->add('default',        'none');
                break;
            case 'bluesky_via':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_SOCIAL_BLUESKYVIA);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_BLUESKYVIA_DESC);
                $propbag->add('default',        'none');
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
                    if (($serendipity['view'] ?? '') != 'entry') {
                        if (! serendipity_db_bool($this->get_config('overview', true))) {
                            // We are in overview mode and the user opted to not show the button
                            return true;
                        }
                    }
                    $twitter_via = $this->get_config('twitter_via', 'none');
                    $twitter_via_tag = '';
                    if ($twitter_via != 'none') {
                        $twitter_via_tag = $twitter_via;
                    }
                    $mastodon_via = $this->get_config('mastodon_via', 'none');
                    $mastodon_via_tag = '';
                    if ($mastodon_via != 'none') {
                        $mastodon_via_tag = $mastodon_via;
                    }
                    $bluesky_via = $this->get_config('bluesky_via', 'none');
                    $bluesky_via_tag = '';
                    if ($bluesky_via != 'none') {
                        $bluesky_via_tag = $bluesky_via;
                    }
                    $theme = $this->get_config('theme');
                    $size = $this->get_config('size', 'standard');
                    $lang = $this->get_config('lang', 'en');
                    $services = $this->get_config('services');
                    $services = explode('^', $services);
                    $data = [   'services' => $services,
                                'url' => $eventData['rdf_ident'],
                                'title' => $eventData['title'],
                                'theme' => $theme,
                                'size' => $size,
                                'twitter_via_tag' => $twitter_via_tag,
                                'mastodon_via_tag' => $mastodon_via_tag,
                                'bluesky_via_tag' => $bluesky_via_tag,
                                'bluesky_via_tag' => $bluesky_via_tag,
                            ];
                    
                    $serendipity['smarty']->assign($data);
                    if (! isset($eventData['display_dat'])) {
                        $eventData['display_dat'] = '';
                    }
                    $eventData['display_dat'] .= $this->parseTemplate('plugin_social.tpl');
                    break;

                case 'css':
                    $eventData .= file_get_contents(dirname(__FILE__) . '/social.css');
                    break;

                case 'frontend_header':
                    if ($serendipity['view'] != 'entry') {
                        return true;
                    }
                
                    // we iterate over the internal smarty object to see which entry we are printing. This is hacky and should be improved
                    if ($eventData['smarty']->tpl_vars['entries']->value != null) { 
                        $entry = (current($eventData['smarty']->tpl_vars['entries']->value)['entries'][0]);
                    } else {
                        return true;
                    }

                    $blogURL = 'http' . ($_SERVER['HTTPS'] ? 's' : '') . '://' . $_SERVER['HTTP_HOST'];

                    echo '<!--serendipity_event_social-->' . "\n";
                    echo '<meta name="twitter:card" content="summary" />' . "\n";
                    echo '<meta property="og:title" content="' . serendipity_specialchars($entry['title']) . '" />' . "\n";
                    # get desciption from serendipity_event_metadesc, if set; take first 200 chars from body otherwise
                    $meta_description = strip_tags($entry['properties']['meta_description'] ?? '');
                    if (empty($meta_description)) {
                                                             # /\s+/: multiple newline and whitespaces
                        $meta_description = trim(preg_replace('/\s+/', ' ', substr(strip_tags($entry['body']), 0, 200))) . '...';
                    }
                    echo '<meta property="og:description" content="' . serendipity_specialchars($meta_description) . '" />' . "\n";
                    echo '<meta property="og:type" content="article" />' . "\n";
                    echo '<meta property="og:site_name" content="' . $serendipity['blogTitle'] . '" />' . "\n";
                    echo '<meta property="og:url" content="'. $blogURL . serendipity_specialchars($_SERVER['REQUEST_URI']) . '" />' . "\n";

                    // set default image from plugin configuration
                    $social_image = $this->get_config('social_image', '');
                    if (isset($entry['properties']) && isset($entry['properties']['entry_image'])) {
                        // if entry_image is set, use this image instead (first priority)
                        $social_image = $entry['properties']['entry_image'];
                    } else if (isset($entry['properties']) && isset($entry['properties']['timeline_image'])) {
                        // if timeline_image from timeline theme is set, use this image (second priority)
                        $social_image = $entry['properties']['timeline_image'];
                    } else if (isset($entry['properties']) && isset($entry['properties']['ep_featuredImage'])) {
                        // if ep_featuredImage from photo theme is set, use this image (third priority)
                        $social_image = $entry['properties']['ep_featuredImage'];
                    } else {
                        // Fourth priority:
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
                    
                    break;

                case 'backend_display':
                    if (isset($serendipity['POST']['properties']['entry_image'])) {
                        $entry_image = $serendipity['POST']['properties']['entry_image'];
                    } elseif (!empty($eventData['properties']['entry_image'])) {
                        $entry_image = $eventData['properties']['entry_image'];
                    } else {
                        $entry_image = '';
                    }
?>
                    <div class="social_entry_image adv_opts_box form_field">
                        <div class="clearfix form_area media_choose" id="ep_column_entry_image">
                            <label for="properties_entry_image"><?php echo PLUGIN_EVENT_SOCIAL_ENTRY_IMAGE; ?>:</label>
                            <textarea data-configitem="properties_entry_image" name="serendipity[properties][entry_image]" class="change_preview" id="properties_entry_image" style="width: 100%"><?php echo serendipity_specialchars($entry_image); ?></textarea>
                            <button class="customfieldMedia" type="button" name="insImage" title="<?php echo MEDIA ; ?>"><span class="icon-picture" aria-hidden="true"></span><span class="visuallyhidden"><?php echo MEDIA ; ?></span></button>
                            <figure id="properties_entry_image_preview">
                                <figcaption><?php echo PREVIEW; ?></figcaption>
                                <img src="<?php echo $entry_image; ?>"  alt=""/>
                            </figure>
                        </div>
                    </div>
<?php
                    break;

                case 'backend_publish':
                case 'backend_save':
                    if (!isset($serendipity['POST']['properties']) || !is_array($serendipity['POST']['properties']) || !isset($eventData['id'])) {
                        return true;
                    }

                    $entry_image = $serendipity['POST']['properties']['entry_image'];

                    // don't change anything if entry_image is not set
                    if (!isset($entry_image)) {
                        return true;
                    }

                    // delete old entry, if any
                    $q = "DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = " . (int)$eventData['id'] . " AND property = 'entry_image'";
                    serendipity_db_query($q);

                    // save new entry
                    if (!empty($entry_image)) {
                        $q = "INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, property, value) VALUES (" . (int)$eventData['id'] . ", 'entry_image', '" . serendipity_db_escape_string($entry_image) . "')";
                        serendipity_db_query($q);
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
