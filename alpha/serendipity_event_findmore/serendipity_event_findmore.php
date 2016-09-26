<?php // 


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_findmore extends serendipity_event
{
    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_FINDMORE_NAME);
        $propbag->add('description',   PLUGIN_FINDMORE_DESCRIPTION);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Kodewulf');
        $propbag->add('version',       '1.22');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

        $propbag->add('configuration',
                array(
                      'disabled_services',
                      'extended_only',
                      'lazyload',
                      'lazyload_text',
                      'path',
                      'diggCountDisplay',
                      'diggCountPlacement',
                      'spreadly_social',
                      'spreadly_emails'
                     ));

        $propbag->add('event_hooks',
            array(
                'frontend_display:html:per_entry' => true,
                'css' => true,
                'frontend_header' => true,
            )
        );

        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
    }

    function generate_content(&$title) {
        $title       = PLUGIN_FINDMORE_NAME;
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;
        switch ($name) {
            // Show on article summary, or only extended page?
            case 'extended_only':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_FINDMORE_EXTENDEDONLY);
                $propbag->add('description', PLUGIN_FINDMORE_EXTENDEDONLY_BLAHBLAH);
                $propbag->add('default', 'false');
                break;

            case 'spreadly_social':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_FINDMORE_SPREADLY);
                $propbag->add('description', PLUGIN_FINDMORE_SPREADLY_DESC);
                $propbag->add('default', 'true');
                break;
                
            case 'spreadly_emails':
                $propbag->add('type', 'text');
                $propbag->add('name', PLUGIN_FINDMORE_SPREADLY_EMAILS);
                $propbag->add('description', PLUGIN_FINDMORE_SPREADLY_EMAILS_DESC);
                $propbag->add('default', 'true');
                break;

            case 'lazyload':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_FINDMORE_LAZYLOAD);
                $propbag->add('description', PLUGIN_EVENT_FINDMORE_LAZYLOAD_DESC);
                $propbag->add('default', 'false');
                break;

            case 'disabled_services':
                $types = array(
                        'addthis'       => 'addthis',
                        'blinklist'     => 'blinklist',
                        'bloglines'     => 'bloglines',
                        'blogmarks'     => 'blogmarks',
                        'delicious'     => 'del.icio.us',
                        'digg'          => 'digg',
                        'facebook'      => 'Facebook',
                        'fark'          => 'fark',
                        'furl'          => 'furl',
                        'friendfeed'    => 'friendfeed',
                        'google'        => 'Google Bookmarks',
                        'plusone'       => 'Google +1',
                        'identica'      => 'Identi.ca',
                        'misterwong'    => 'mister-wong',
                        'mixx'          => 'mixx',
                        'newsvine'      => 'newsvine',
                        'printthis'     => 'print this',
                        'reddit'        => 'reddit',
                        'simpy'         => 'simpy',
                        'spurl'         => 'spurl',
                        'spreadly'      => 'Spread.ly',
                        'stumbleupon'   => 'stumbleupon',
                        'technorati'    => 'technorati',
                        'tellafriend'   => 'tell a friend',
                        'twitter'       => 'Twitter',
                        'wists'         => 'wists',
                        'yahoo'         => 'yahoo',
                    );
                $propbag->add('type', 'multiselect');
                $propbag->add('name', PLUGIN_EVENT_FINDMORE_DISABLED_SERVICES);
                $propbag->add('description', PLUGIN_EVENT_FINDMORE_DISABLED_SERVICES_DESC);
                $propbag->add('select_values', $types);
                $propbag->add('select_size', 17);
                $propbag->add('default', '');
                break;

            case 'lazyload_text':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_FINDMORE_LAZYLOAD_TEXT);
                $propbag->add('description', PLUGIN_EVENT_FINDMORE_LAZYLOAD_TEXT_DESC);
                $propbag->add('default',     PLUGIN_EVENT_FINDMORE_LAZYLOAD_TEXT_EXAMPLE);
                break;

            case 'path':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_FINDMORE_PATH_NAME);
                $propbag->add('description', PLUGIN_FINDMORE_PATH_DESC);
                $propbag->add('default',     $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_findmore/img/');
                break;

            case 'diggCountDisplay':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_FINDMORE_DIGGCOUNT_DISPLAY_NAME);
                $propbag->add('description', PLUGIN_FINDMORE_DIGGCOUNT_DISPLAY_DESC);
                $propbag->add('default', 'true');
                break;

            case 'diggCountPlacement':
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_NAME);
                $propbag->add('description', PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_DESC);
                $propbag->add('select_values', array(   'before-entry' => 'Before entry',
                                                        'after-entry' => 'After entry',
                                                        'after-findmore' => 'After Findmore links'));
                $propbag->add('default', 'after-entry');
        };
        return true;
    }

    function &smartyParse(&$data, $filename = '') {
        global $serendipity;
        static $disabled_services = null;
        static $lazyload = null;

        if ($disabled_services == null) {
            $disabled_services = array();
            $_disabled_services = explode('^', $this->get_config('disabled_services'));
            foreach($_disabled_services AS $i => $service) {
                $disabled_services[$service] = true;
            }
            $serendipity['smarty']->assign('findmore_disabled_services', $disabled_services);
        }
        
        if ($lazyload == null) {
            $lazyload  = serendipity_db_bool($this->get_config('lazyload'));
            $serendipity['smarty']->assign('findmore_lazyload', $lazyload);
            $serendipity['smarty']->assign('findmore_lazyload_text', $this->get_config('lazyload_text'));
        }
        $serendipity['smarty']->assign('findmore_spreadly_social', serendipity_db_bool($this->get_config('spreadly_social')));

        if (empty($filename)) {
            $filename = 'plugin_findmore.tpl';
        }

        $filename = basename($filename);
        $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
        if (!$tfile || $tfile == $filename) {
            $tfile = dirname(__FILE__) . '/' . $filename;
        }
        $inclusion = $serendipity['smarty']->security_settings[INCLUDE_ANY];
        $serendipity['smarty']->security_settings[INCLUDE_ANY] = true;

        $serendipity['smarty']->assign('entrydata', $data);
        $content = $serendipity['smarty']->fetch('file:'. $tfile);
        $serendipity['smarty']->security_settings[INCLUDE_ANY] = $inclusion;

        return $content;
    }

    function generateMicroid($firstUri, $secondUri) {
        $firstUriHash = sha1($firstUri);
        $secondUriHash = sha1($secondUri);

        return sha1($firstUriHash . $secondUriHash);
    }


    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;
        static $path = null;
        static $diggUrl = null;

        $diggCountDisplay = null;
        $diggCountPlacement = null;

        if ($path === null) {
            $path = $this->get_config('path');
        }

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'css':
                    if (stristr($eventData, '.serendipity_findmore')) {
                        // class exists in CSS, so a user has customized it and we don't need default
                        return true;
                    }
?>

      .serendipity_findmore {
        margin: 5px auto 5px auto;
        padding: 5px;
        text-align: center;
      }

      .serendipity_findmore img {
        border: 0px;
      }

      .serendipity_diggcount {
          float: left;
      }

      .findmore_like_button img, .findmore_like_button iframe {
        cursor: pointer;
    }

    .lazyload_switcher {
        margin-right: 0.5em;
        display: inline;
        float: left;
        margin-top: 4px;
    }

    .findmore_like_button {
        display: inline-block;
        vertical-align: middle;
        margin-right: 2em;
    }

    .google_like {
        width: 150px;
        height: 21px;
    }

    .gplus_like {
        display: inline;
    }

    .serendipity_findmore_like {
        vertical-align: middle;
        height: 21px;
    }

<?php
                    return true;
                    break;

                case 'frontend_header':
                    echo '<!--serendipity_event_findmore-->' . "\n";
                    $hash = $this->generateMicroid('mailto:' . $serendipity['email'], $serendipity['baseURL']);
                    echo '<meta name="microid" content="mailto+http:sha1:' . $hash . '" />'."\n";

                    $emails = explode("\n", str_replace(',', "\n", $this->get_config('spreadly_emails')));
                    foreach($emails AS $email) {
                        $email = trim($email);
                        $hash = $this->generateMicroid('mailto:' . $email, $serendipity['baseURL']);
                        echo '<meta name="microid" content="mailto+http:sha1:' . $hash . '" />'."\n";
                    }

                    $_disabled_services = explode('^', $this->get_config('disabled_services'));
                    foreach($_disabled_services AS $i => $service) {
                        $disabled_services[$service] = true;
                    }

                    if ($lazyload == null) {
                        $lazyload  = serendipity_db_bool($this->get_config('lazyload'));
                    }
                    if ($lazyload) {
                        echo '<script src="' .  $path .'plugin_findmore.js"></script>'."\n";
                    }
                    
                    if (! ($disabled_services['plusone'] || $lazyload)) {
                        #echo '<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>'."\n";
                        echo '<script type="text/javascript">
                          (function() {
                            var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
                            po.src = "https://apis.google.com/js/plusone.js";
                            var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
                          })();
                        </script>' . "\n";
                    }

                    

                    return true;
                    break;

                case 'frontend_display:html:per_entry':
                    $entry = array(
                        'url'   => $eventData['rdf_ident'],
                        'title' => $eventData['title'],
                        'path'  => $path
                    );

                    if ($serendipity['view'] != 'entry' && serendipity_db_bool($this->get_config('extended_only'))) {
                        // We are in overview mode.
                        return true;
                    }

                    $diggCountDisplay   = serendipity_db_bool($this->get_config('diggCountDisplay'));
                    $diggCountPlacement = $this->get_config('diggCountPlacement');

                    $diggCountData = null;
                    if ($diggCountDisplay) {
                        $diggCountData = $this->getDiggCounts($eventData['body'].$eventData['extended']);
                    } else {
                        $diggCountData = '<!-- no digg badge -->';
                    }

                    if ($diggCountPlacement == 'before-entry') {
                        $eventData['display_dat'] = $diggCountData . $eventData['display_dat'];
                    }

                    if ($diggCountPlacement == 'after-entry') {
                        $eventData['display_dat'] .= $diggCountData;
                    }

                    $eventData['display_dat'] .= $this->smartyParse($entry);

                    if ($diggCountPlacement == 'after-findmore') {
                        $eventData['display_dat'] .= $diggCountData;
                    }

                    break;

                default:
                   return false;
           }
        }
    }

    function getUrls($input, $strict=true) {
        $types = array("href", "src", "url");
        while(list(,$type) = each($types)) {
            $innerT = $strict?'[a-z0-9:?=()&@/._-]+?':'.+?';
            preg_match_all("|$type\=([\"'`])(".$innerT.")\\1|i", $input, $matches);
            $ret[$type] = $matches[2];
	}
	return $ret;
    }

    function getDiggUrls($input, $strict=true) {
        $urls = $this->getUrls($input, $strict);
        $diggs = array();
        foreach ($urls['href'] as $url) {
            $pos = strpos($url, 'digg.com');
            if ($pos === false) {
            } else {
                if (in_array($url, $diggs) === false) {
                    $diggs[] = $url;
                }
            }
        }
        return $diggs;
    }

    function getDiggCounts($input) {
        $diggs = $this->getDiggUrls($input);
        if (empty($diggs) || count($diggs) < 1) {
            return '<!-- no digg urls in entry -->';
        }
        $diggCountDiv = "<div class=\"serendipity_diggcount\">\n<script>digg_url = '%s';</script>\n<script src=\"http://digg.com/api/diggthis.js\"></script>\n</div>\n\n";
        $diggCount = null;

        foreach ($diggs as $url) {
            $diggCount .= sprintf($diggCountDiv, $url);
	}
        return $diggCount;
    }
}
