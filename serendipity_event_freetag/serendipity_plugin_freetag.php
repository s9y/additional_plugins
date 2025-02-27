<?php


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_freetag extends serendipity_plugin
{
    var $title = PLUGIN_FREETAG_NAME;
    var $dependencies = array();

    function introspect(&$propbag)
    {
        global $serendipity;

        $this->title = $this->get_config('title', $this->title);

        $propbag->add('name',          PLUGIN_FREETAG_NAME);
        $propbag->add('description',   PLUGIN_FREETAG_BLAHBLAH);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Jonathan Arkell, Grischa Brockhaus, Lars Strojny');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',       '4.0');
        $propbag->add('groups',        array('FRONTEND_ENTRY_RELATED'));
        $propbag->add('configuration', array('title', 'show_xml','xml_image', 'show_newline', 'taglink', 'scale_tag', 'max_tags', 'min_percent', 'max_percent', 'treshold_tag_count', 'order_by', 'template'));
        $this->dependencies = array('serendipity_event_freetag' => 'keep');
    }


    function introspect_config_item($name, &$propbag) {
        global $serendipity;
        switch($name) {
            case 'title':
                 $propbag->add('type',        'string');
                 $propbag->add('name',        TITLE);
                 $propbag->add('description', TITLE_FOR_NUGGET);
                 $propbag->add('default',     PLUGIN_FREETAG_NAME);
                 break;

            case 'taglink':
                 $propbag->add('type',        'string');
                 $propbag->add('name',        PLUGIN_EVENT_FREETAG_TAGLINK);
                 $propbag->add('description', '');
                 $propbag->add('default',     $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/tag/');
                 break;

            case 'scale_tag':
                 $propbag->add('type',        'boolean');
                 $propbag->add('name',        PLUGIN_FREETAG_SCALE);
                 $propbag->add('description', '');
                 $propbag->add('default',     false);
                 break;

            case 'show_xml':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_FREETAG_XML);
                $propbag->add('description', '');
                $propbag->add('default',     true);
                break;

            case 'show_newline':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_FREETAG_NEWLINE);
                $propbag->add('description', '');
                $propbag->add('default',     true);
                break;

            case 'min_percent':
                 $propbag->add('type',        'string');
                 $propbag->add('name',        PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN);
                 $propbag->add('description', '');
                 $propbag->add('default',     '100');
                 break;

            case 'max_percent':
                 $propbag->add('type',        'string');
                 $propbag->add('name',        PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX);
                 $propbag->add('description', '');
                 $propbag->add('default',     '300');
                 break;

            case 'max_tags':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_FREETAG_MAX_TAGS);
                $propbag->add('description', '');
                $propbag->add('default',     '100');
                break;

            case 'treshold_tag_count':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_FREETAG_TRESHOLD_TAG_COUNT);
                $propbag->add('description', '');
                $propbag->add('default',     '2');
                break;

            case 'order_by':
                $order     = array('tag' => PLUGIN_EVENT_FREETAG_ORDER_TAGNAME, 'total' => PLUGIN_EVENT_FREETAG_ORDER_TAGCOUNT);
                $propbag->add('type',        'select');
                $propbag->add('select_values', $order);
                $propbag->add('name',        SORT_ORDER);
                $propbag->add('description', '');
                $propbag->add('default',     'tag');
                break;
            
            case 'xml_image':
                 $propbag->add('type',        'string');
                 $propbag->add('name',        PLUGIN_EVENT_FREETAG_XMLIMAGE);
                 $propbag->add('description', '');
                 $propbag->add('default',     'img/xml.gif');
                 break;

            case 'template':
                $propbag->add('type',         'string');
                $propbag->add('name',         PLUGIN_EVENT_FREETAG_TEMPLATE);
                $propbag->add('description',  PLUGIN_EVENT_FREETAG_TEMPLATE_DESCRIPTION);
                $propbag->add('default',      '');
                break;
            }

        return true;
    }

    function generate_content(&$title)
    {
        global $serendipity;

        $title = $this->get_config('title', $this->title);

        if ($this->get_config('max_tags', 0) != 0) {
            $limit = "LIMIT " . $this->get_config('max_tags', 0);
        } else {
            $limit = '';
        }

        $query = "SELECT et.tag, count(et.tag) AS total
                    FROM {$serendipity['dbPrefix']}entrytags AS et
         LEFT OUTER JOIN {$serendipity['dbPrefix']}entries AS e
                      ON et.entryid = e.id
                   WHERE e.isdraft = 'false' "
                         . (!serendipity_db_bool($serendipity['showFutureEntries']) ? " AND e.timestamp <= " . time() : '') . "
                GROUP BY et.tag
                  HAVING count(et.tag) >= " . $this->get_config('treshold_tag_count') . "
                ORDER BY total DESC $limit";

        $rows = serendipity_db_query($query);

        if (!is_array($rows)) {
            return;
        }

        // not sure if we can optimize this loop... :/
        // Probably through some SQL magick.
        foreach($rows as $r) {
            $tags[$r['tag']] = $r['total'];
        }
        if ($this->get_config('order_by') == 'tag'){
            uksort($tags, 'strnatcasecmp');
            serendipity_plugin_api::hook_event('sort', $tags);
        } else if ($this->get_config('order_by') == 'total'){
            asort($tags);
        }

        $xml     = serendipity_db_bool($this->get_config('show_xml'));
        $nl      = serendipity_db_bool($this->get_config('show_newline'));
        $scaling = serendipity_db_bool($this->get_config('scale_tag'));

        serendipity_event_freetag::displayTags($tags, $xml, $nl, $scaling, $this->get_config('max_percent', 300), $this->get_config('min_percent', 100),
                                               $this->get_config('taglink'), $this->get_config('template'), $this->get_config('xml_image','img/xml.gif'));
    }

    function cleanup() {
        global $serendipity;

        serendipity_event_freetag::static_install();
    }
}

/* vim: set sts=4 ts=4 expandtab : */
