<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_schema extends serendipity_event {
    var $title = PLUGIN_EVENT_SCHEMA_NAME;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_SCHEMA_NAME);
        $propbag->add('description',   PLUGIN_EVENT_SCHEMA_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Malte Paskuda');
        $propbag->add('version',       '0.2.2');
        $propbag->add('requirements',  array(
            'serendipity' => '2.0'
        ));
        $propbag->add('event_hooks',   array('frontend_display:html:per_entry' => true));
        $propbag->add('groups', array('FRONTEND_ENTRY_RELATED'));

        $propbag->add('configuration', array('article_image', 'publisher'));

    }

    function generate_content(&$title) {
        $title = $this->title;
    }


    function introspect_config_item($name, &$propbag) {
        global $serendipity;
        switch($name) {
            case 'article_image':
                $propbag->add('type',           'media');
                $propbag->add('name',           PLUGIN_EVENT_SCHEMA_IMAGE);
                $propbag->add('description',    PLUGIN_EVENT_SCHEMA_IMAGE_DESC);
                $propbag->add('default',        '');
                break;

            case 'publisher':
                $propbag->add('type',           'text');
                $propbag->add('name',           PLUGIN_EVENT_SCHEMA_PUBLISHER);
                $propbag->add('description',    PLUGIN_EVENT_SCHEMA_PUBLISHER_DESC);
                $propbag->add('default',        '"publisher": {
    "@type": "Organization",
    "name": "' . $serendipity['realname'] . '",
    "logo": {
        "@type": "ImageObject",
        "width": 60,
        "height": 60,
        "url": "' . $serendipity['baseURL'] . 'favicon.png' . '"
    }
  }');
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
                    if ($serendipity['view'] ?? '' == 'entry') {
                        $article_image = $this->get_config('article_image', '');
                        if (isset($eventData['properties']) && isset($eventData['properties']['entry_image'])) {
                            // if entry_image is set, use this image instead (first priority)
                            $article_image = $eventData['properties']['entry_image'];
                        } else if (isset($eventData['properties']) && isset($eventData['properties']['timeline_image'])) {
                            // if timeline_image from timeline theme is set, use this image (second priority)
                            $article_image = $eventData['properties']['timeline_image'];
                        } else if (isset($eventData['properties']) && isset($eventData['properties']['ep_featuredImage'])) {
                            // if ep_featuredImage from photo theme is set, use this image (third priority)
                            $article_image = $eventData['properties']['ep_featuredImage'];
                        } else {
                            // Fourth priority:
                            // This is searching for the first image in an entry to use as facebook article image.
                            // A better approach would be to register in the entry editor when an image was added
                            if (preg_match_all('@<img.*src=["\'](.+)["\']@imsU', $eventData['body'] . $eventData['extended'], $images)) {
                                foreach ($images[1] as $im) {
                                    if (strpos($im, '/emoticons/') === false) {
                                        $article_image = $im;
                                        break;
                                    }
                                }
                            }
                        }
                        $blogURL = 'http' . ($_SERVER['HTTPS'] ? 's' : '') . '://' . $_SERVER['HTTP_HOST'];
                        $publisher = $this->get_config('publisher', '"publisher": {
                                "@type": "Organization",
                                "name": "' . $eventData['author'] . '",
                                "logo": {
                                    "@type": "ImageObject",
                                    "width": 60,
                                    "height": 60,
                                    "url": "' . $blogURL . '/favicon.png' . '"
                                }
                              }');

                        $eventData['display_dat'] .= '<script type="application/ld+json">
                            {
                              "@context": "https://schema.org",
                              "@type": "BlogPosting",
                              "mainEntityOfPage": {
                                "@type": "WebPage",
                                "@id": "' . $eventData['rdf_ident'] . '"
                              },
                              "headline": "' . $eventData['title'] . '",
                              ' . ($article_image ? "\"image\":  \"{$article_image}\"," : '') . '
                              "datePublished": "' . date(DATE_ISO8601, $eventData['timestamp'] ) . '",
                              "dateModified": "' . date(DATE_ISO8601, $eventData['last_modified']) . '",
                              "author": {
                                "@type": "Person",
                                "name": "' . $eventData['author'] . '"
                              },
                              ' . $publisher .' 
                            }
                            </script>';

                        if (isset($eventData['properties']) && isset($eventData['properties']['ep_schemaType'])
                                                            && isset($eventData['properties']['ep_schemaName'])
                                                            && isset($eventData['properties']['ep_schemaBrandName'])
                                                            && isset($eventData['properties']['ep_schemaRating'])
                                                
                        ) {
                            $eventData['display_dat'] .= '<script type="application/ld+json">      
                                      {"@context": "http://schema.org",
                                    "@type": "' . $eventData['properties']['ep_schemaType'] . '",
                                    "name": "' . htmlspecialchars($eventData['properties']['ep_schemaName']) . '",
                                    ' . ($article_image ? "\"image\":  [ \"{$article_image}\" ]," : '') . '
                                    "description": "",
                                    "brand": {
                                        "@type": "Thing",
                                        "name": "' . $eventData['properties']['ep_schemaBrandName'] . '"
                                    },
                                    "review": {
                                        "@type": "Review",
                                        "author": {
                                            "@type": "Person",
                                            "name": "' . $eventData['author'] . '"
                                        },
                                        "datePublished": "' . date(DATE_ISO8601, $eventData['timestamp'] ) . '",
                                        "reviewRating": {
                                            "@type": "Rating",
                                            "ratingValue": "' . $eventData['properties']['ep_schemaRating'] . '"
                                        }
                                    }
                                }
                                </script>'; 
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