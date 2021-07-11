<?php # 


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_entrysplit extends serendipity_event
{
    var $title        = PLUGIN_ENTRYSPLIT_NAME;
    var $toc_count;
    var $toc;
    var $split_index;
    var $header_order;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_ENTRYSPLIT_NAME);
        $propbag->add('description',   PLUGIN_ENTRYSPLIT_BLAHBLAH);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Tadashi Jokagi, Thomas Werner');
        $propbag->add('version',       '1.5.7');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',   array('entry_display' => true));
        $propbag->add('scrambles_true_content', true);
        $propbag->add('groups', array('BACKEND_EDITOR'));
        $propbag->add('configuration', array('split_char', 'split_length', 'showbody'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'split_char':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_ENTRYSPLIT_CHAR);
                $propbag->add('description', PLUGIN_ENTRYSPLIT_CHAR_DESC);
                $propbag->add('default', '<!--nextpage-->');
                break;

            case 'split_length':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_ENTRYSPLIT_LENGTH);
                $propbag->add('description', PLUGIN_ENTRYSPLIT_LENGTH_DESC);
                $propbag->add('default', '20000');
                break;

            case 'showbody':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_ENTRYSPLIT_SHOWBODY);
                $propbag->add('description', '');
                $propbag->add('default', true);
                break;

            default:
                    return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        $title       = $this->title;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'entry_display':
                    $evtCount = count($eventData);

                    for ($entryIdx = 0; $entryIdx < $evtCount; ++$entryIdx) {
                        $this->toc_count = 0;
                        $current_page = $this->get_userselected_page();
                        if (!isset($eventData[$entryIdx])) continue;

                        // Check whether the cache plugin is used. If so, we need to append our karma-voting output
                        // to the cached version, since that one is used instead of the 'extended' key later on.
                        $text = &$this->getFieldReference('extended', $eventData[$entryIdx]);
                        $body_text = &$this->getFieldReference('body', $eventData[$entryIdx]);

                        if(!$addData['extended']) {
                            // The entry url needs to be specified more precisely if the system isn't currently
                            // displaying the current entry.
                            $url = $this->get_entrysplit_url($eventData[$entryIdx]['id'], $eventData[$entryIdx]['title']);
                        } else {
                            // Otherwise the current user-specified URL already contains entry id and title.
                            $url = $this->get_entrysplit_url();
                        }

                        $split_char = $this->get_config('split_char');

                        if (strpos($text, $split_char) === false) {
                            $split_char = '<!--s9y_next_page-->';
                            $text = wordwrap($text, $this->get_config('split_length'), '<!--s9y_next_page-->');
                        }

                        $parts = explode($split_char, $text);
                        $parts_count = count($parts);

                        // Create table of contents if a quick search for a [TOCx]-tag is successful
                        if ((strpos($text, '[TOC') !== false) ||
                            (strpos($body_text, '[TOC') !== false)) {
                            // Create table of contents
                            $this->toc_count = 0;

                            for ($this->header_order = 3; $this->header_order <= 6; ++$this->header_order) {
                                $this->toc = '';

                                for ($this->split_index = 0; $this->split_index < $parts_count; ++$this->split_index) {
                                    $this->add_to_toc($parts[$this->split_index]);
                                }

                                $this->toc .= '</ul></div>';

                                for ($i = 0; $i < $parts_count; ++$i) {
                                    $parts[$i] = str_replace('[TOC'.$this->header_order.']', $this->toc, $parts[$i]);
                                    $body_text = str_replace('[TOC'.$this->header_order.']', $this->toc, $body_text);
                                }
                            }
                        }

                        if (!$addData['extended']) {
                            continue;
                        }

                        if ($current_page != 'all') {
                            $text = $parts[$current_page - 1];
                        }

                        $parts_count++;
                        if ($parts_count <= 2) {
                            return true;
                        }

                        if ($current_page > 1 && !serendipity_db_bool($this->get_config('showbody'))) {
                            $eventData[$entryIdx]['body'] = '';
                            $eventData[$entryIdx]['properties']['ep_cache_body'] = '';
                        }

                        $pagination = '<div style="width: 70%; margin-top: 1em; margin-left: auto; margin-right: auto; text-align: center" id="entry_pagination">' . PLUGIN_ENTRYSPLIT_PAGES . ': ';
                        if ( $current_page - 1 < 1) {
                            $pagination .= PLUGIN_ENTRYSPLIT_PAGES_PREV . ' | ';
                        } else {
                            $pagination .= '<a href="' . $url . ( $current_page - 1) . '">' . PLUGIN_ENTRYSPLIT_PAGES_PREV . '</a> | ';
                            $text = '<a href="' . $url . ( $current_page - 1) . '">[' . PLUGIN_ENTRYSPLIT_PAGES_PREV . '...] </a> '.$text;
                        }
                        for ($page = 1; $page < $parts_count; $page++) {
                            $pagination .= '<a href="' . $url . $page . '">'
                                        . ($page == $current_page ? '<strong>' : '')
                                        . ($page)
                                        . ($page == $current_page ? '</strong>' : '')
                                        . '</a> | ';
                        }
                        if ( $current_page != 'all' && $current_page + 1 < $parts_count) {
                            $pagination .= '<a href="' . $url . ( $current_page + 1) . '">' . PLUGIN_ENTRYSPLIT_PAGES_NEXT . '</a> | ';
                            $text .= '<a href="' . $url . ( $current_page + 1) . '"> [...' . PLUGIN_ENTRYSPLIT_PAGES_NEXT . ']</a> ';
                        } else {
                            $pagination .= PLUGIN_ENTRYSPLIT_PAGES_NEXT . ' | ';
                        }
                        $pagination .= '<a href="' . $url . 'all">' . PLUGIN_ENTRYSPLIT_PAGES_ALL . '</a></div>';

                        $eventData[0]['exflag'] = 1;
                        $text .= $pagination;
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

    function modify_header_tag($match) {
        $order = $match[1];
        $label = $match[2];

        if($order == $this->header_order) {
            $url = $this->get_entrysplit_url().($this->split_index + 1);
            $this->toc .= '<li class="articletoc"><a class="articletoc" href="'.$url.'#artoc'.($this->toc_count).'">'.$label.'</a></li>';

            return '<a name="artoc'.($this->toc_count++).'"></a>'.$match[0];
        }

        return $match[0];
    }

    function add_to_toc(&$txt) {
        if(!$this->toc) {
            $this->toc = '<div class="articletoc">'.PLUGIN_ENTRYSPLIT_TOC.'<ul class="articletoc">';
        }

        $txt = preg_replace_callback('#<h(\d)[^>]*?>(.*)?</h[^>]*?>#i', array($this, 'modify_header_tag'), $txt);
    }

    function get_entrysplit_url($id = false, $title = false) {
        static $url;

        if ($url === null || $id !== false) {
            if ($id !== false) {
                $url = serendipity_archiveURL($id, $title);
            } else {
                $url = serendipity_currentURL();
            }

            $url = preg_replace('@(\&amp;serendipity\[entrypage\]=[^\&]*)@i', '', $url);
            $url .= '&amp;serendipity[entrypage]=';
        }

        return $url;
    }

    function get_userselected_page() {
        global $serendipity;
        static $current_page;

        if ($current_page === null) {
            if (isset($serendipity['GET']['entrypage'])) {
                $current_page = (int)$serendipity['GET']['entrypage'];
            } else {
                $current_page = 1;
            }
        }

        return $current_page;
    }
}

/* vim: set sts=4 ts=4 expandtab : */

