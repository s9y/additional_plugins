<?php
# Copyright by Aaron Axelsen
# Modevia Web Services - http://www.modevia.com
# axelseaa [at] modevia [dot] com
#


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_G2embed extends serendipity_event {
	function serendipity_event_G2embed() {
		$this->isG2Loaded = false;
	}

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name', G2EMBED_TITLE . ': ' . $this->get_config('pagetitle', ''));
        $propbag->add('description', G2EMBED_TITLE_DESC);
        $propbag->add('event_hooks',  array('entries_header' => true, 'entry_display' => true, 'genpage' => true, 'frontend_generate_plugins' => true));
        $propbag->add('configuration', array('g2dir', 'g2uri', 'embedUri', 'headline', 'pagetitle', 'fontsize', 'divwidth'));
        $propbag->add('author', 'Aaron Axelsen');
        $propbag->add('version', '0.3');
        $propbag->add('requirements',  array(
            'serendipity' => '0.9.1',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
        $propbag->add('stackable', true);

        $this->pagetitle = $this->get_config('pagetitle', 'pagetitle');
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
		    case 'headline':
				$propbag->add('type',        'string');
                $propbag->add('name',        G2EMBED_HEADLINE);
                $propbag->add('description', G2EMBED_HEADLINE_DESC);
				$propbag->add('default',     'Photo Gallery');
			 	break;
		    case 'g2dir':
				$propbag->add('type',        'string');
                $propbag->add('name',        G2EMBED_G2DIR);
                $propbag->add('description', G2EMBED_G2DIR_DESC);
				$propbag->add('default',     '/var/www/html/gallery2');
			 	break;
		    case 'g2uri':
				$propbag->add('type',        'string');
                $propbag->add('name',        G2EMBED_G2URI);
                $propbag->add('description', G2EMBED_G2URI_DESC);
				$propbag->add('default',     $serendipity['serendipityHTTPPath']);
			 	break;
		    case 'relativeG2Path':
				$propbag->add('type',        'string');
                $propbag->add('name',        G2EMBED_RELG2PATH);
                $propbag->add('description', G2EMBED_RELG2PATH_DESC);
				$propbag->add('default',     '../gallery2');
			 	break;
		    case 'embedUri':
				$propbag->add('type',        'string');
                $propbag->add('name',        G2EMBED_EMBEDURI);
                $propbag->add('description', G2EMBED_EMBEDURI_DESC);
                $propbag->add('default',     $serendipity['rewrite'] != 'none'
                                             ? $serendipity['serendipityHTTPPath'] . 'gallery2.html'
                                             : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/gallery2.html');
			 	break;
            case 'pagetitle':
                $propbag->add('type',        'string');
                $propbag->add('name',        G2EMBED_PAGETITLE);
                $propbag->add('description', '');
                $propbag->add('default',     'gallery2');
                break;
            case 'fontsize':
                $propbag->add('type',        'string');
                $propbag->add('name',        G2EMBED_FONTSIZE);
                $propbag->add('description', G2EMBED_FONTSIZE_DESC);
                $propbag->add('default',     '1.6em');
                break;
            case 'divwidth':
                $propbag->add('type',        'string');
                $propbag->add('name',        G2EMBED_DIVWIDTH);
                $propbag->add('description', G2EMBED_DIVWIDTH_DESC);
                $propbag->add('default',     '670px');
                break;
            default:
                return false;
        }
        return true;
    }

	function loadG2() {
		global $serendipity;
			if ($this->isG2Loaded === false) {
				require_once( $this->get_config('g2dir') . 'embed.php');
				$ret = GalleryEmbed::init(array(
								   'g2Uri' => $this->get_config('g2uri'),
								   'embedUri' => $this->get_config('embedUri'),
								   //'fullInit' => 'false',
								   'gallerySessionId' => $_COOKIE['PHPSESSID']
								   ));
				GalleryCapabilities::set('login',true);

				// handle the G2 request
				$this->g2moddata = GalleryEmbed::handleRequest();

				// show error message if isDone is not defined
				if (!isset($this->g2moddata['isDone']))
				{
					print 'isDone is not defined, something very bad must have happened.';
					exit;
				}
				// die if it was a binary data (image) request
				if ($this->g2moddata['isDone'])
				{
					exit; /* uploads module does this too */
				}

				$this->isG2Loaded = true;
			}
	}

    function show() {
        global $serendipity;

        if ($this->selected()) {
            if (!headers_sent()) {
                header('HTTP/1.0 200');
                header('Status: 200 OK');
            }

			$this->loadG2();
            //print_r($this->g2moddata['themeData']['systemLinks']);
	        echo '<h2><a href="' . $this->get_config('embedUri') . '">' . $this->get_config('headline') . '</a></h2>';
			echo '<div id="gallery" style="font-size: ' . $this->get_config('fontsize') . ';';
			if ($this->g2moddata['themeData']['item']['canContainChildren'] == 0 || isset($this->g2moddata['themeData']['systemLinks']['core.Logout'])) {
				echo ' width:' . $this->get_config('divWidth') . ';';
			}
			echo '">'. $this->g2moddata['headHtml'] . $this->g2moddata['bodyHtml'] .'</div>';
			//print_r($this->g2moddata['themeData']['permissions']);
        }
    }

    function selected() {
        global $serendipity;

        if ($serendipity['GET']['subpage'] == $this->get_config('pagetitle') ||
            preg_match('@^' . preg_quote($this->get_config('embedUri')) . '@i', $serendipity['GET']['subpage'])) {
            return true;
        }

        return false;
    }

    function generate_content(&$title) {
        $title = G2EMBED_TITLE.' ('.$this->get_config('pagetitle').')';
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {
			    case 'frontend_generate_plugins':
                    if ($this->selected()) {
						if ($this->g2moddata['themeData']['item']['canContainChildren'] == 0 || isset($this->g2moddata['themeData']['systemLinks']['core.Logout'])) {
	                    	$eventData = array();
						}
                    }
                    break;

                case 'genpage':
                    $args = implode('/', serendipity_getUriArguments($eventData, true));
                    if ($serendipity['rewrite'] != 'none') {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $args;
                    } else {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/' . $args;
                    }

                    if (empty($serendipity['GET']['subpage'])) {
                        $serendipity['GET']['subpage'] = $nice_url;
                    }
                    break;

                case 'entry_display':
                    if ($this->selected()) {
                        if (is_array($eventData)) {
                            $eventData['clean_page'] = true; // This is important to not display an entry list!
                        } else {
                            $eventData = array('clean_page' => true);
                        }
                    }

                    if (version_compare($serendipity['version'], '0.7.1', '<=')) {
						$this->show();
                    }

                    return true;
                    break;

                case 'entries_header':
					$this->show();
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
