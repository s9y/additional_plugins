<?php # 

// Done for augusto @ bauer - online . org :-)

// You can customize the entry read state, by customizing your entries.tpl file like this:
//
// Change
//         <h4 class="serendipity_title"><a href="{$entry.link}">{$entry.title}</a></h4>
// into
//         <h4 class="serendipity_title {if $entry.properties.is_read}serendipity_title_read{else}serendipity_title_unread{/if}><a href="{$entry.link}">{$entry.title}</a></h4>
//
// Then you can use CSS to differently style .serendipity_title_read and .serendipity_title_unread for each entry.


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_markread extends serendipity_event
{
    var $title        = PLUGIN_MARKREAD_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_MARKREAD_NAME);
        $propbag->add('description',   PLUGIN_MARKREAD_NAME);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('version',       '1.5');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',   array(
            'frontend_configure'       => true,
            'entry_display'            => true,
            'frontend_fetchentries'    => true,
            'frontend_fetchentry'      => true,
            'external_plugin'          => true,
            'frontend_entryproperties' => true
        ));

        $propbag->add('groups', array('STATISTICS'));
        $propbag->add('configuration', array('marklink', 'markedtext'));

        $propbag->add('legal',    array(
            'services' => array(
            ),
            'frontend' => array(
                'To remember the read-state of entries, they are stored in a cookie (markread_visitor). Read indicators are stored in the database, referencing anonymous visitor IDs plus their read-timestamp and author-ids for logged in authors.',
            ),
            'backend' => array(
            ),
            'cookies' => array(
                'Cookies are used to store the read-state of entries, by referencing visitor IDs to a database table'
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => false,
            'transmits_user_input'  => false
        ));

    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'marklink':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_MARKREAD_MARKLINK);
                $propbag->add('description', '');
                $propbag->add('default', PLUGIN_MARKREAD_MARKLINK_DEFAULT);
                break;

            case 'markedtext':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_MARKREAD_MARKTEXT);
                $propbag->add('description', '');
                $propbag->add('default', PLUGIN_MARKREAD_MARKTEXT_DEFAULT);
                break;

            default:
                    return false;
        }
        return true;
    }

    function checkScheme() {
        global $serendipity;

        $version = $this->get_config('version', 'none');

        if ($version == 'none') {
            $q   = "CREATE TABLE {$serendipity['dbPrefix']}markread (
                        entryid int(11) default null,
                        visitor varchar(64) default null,
                        read_date int(10) {UNSIGNED} NULL
                    )";
            $sql = serendipity_db_schema_import($q);

            $q   = "CREATE INDEX readfetch ON {$serendipity['dbPrefix']}markread (entryid, visitor);";
            $sql = serendipity_db_schema_import($q);

            $this->set_config('version', '1.0');
        }

        return true;
    }

    function generate_content(&$title)
    {
        $title       = $this->title;
    }

    function getToken() {
        global $serendipity;

        if ($_SESSION['serendipityAuthedUser'] === true && $_SESSION['serendipityAuthorid'] > 0) {
            // Set the cookie according to our username. This way we can login on other machines.
            if (!isset($serendipity['COOKIE']['registered_markread_visitor'])) {
                serendipity_setCookie('registered_markread_visitor', md5($_SESSION['serendipityAuthorid'] . $_SESSION['serendipityUser']));
            }
            return $serendipity['COOKIE']['registered_markread_visitor'];
        } else if (!isset($serendipity['COOKIE']['markread_visitor'])) {
            // This should be unique enough.
            serendipity_setCookie('markread_visitor', md5(time()) . md5($_SERVER['REMOTE_ADDR'] . $_SERVER['REQUEST_URI']));
            return $serendipity['COOKIE']['markread_visitor'];
        } else {
            // We already have a non-registered cookie item and are currently not logged in.
            return $serendipity['COOKIE']['markread_visitor'];
        }
    }

    function markRead($id) {
        global $serendipity;

        $time = time();
        $sql = "INSERT INTO {$serendipity['dbPrefix']}markread
                            (entryid, visitor, read_date)
                     VALUES (" . (int)$id . ", '" . serendipity_db_escape_string($this->getToken()) . "', " . $time . ")";
        return serendipity_db_query($sql);
    }

    function getRead($id) {
        global $serendipity;

        $res = serendipity_db_query("SELECT read_date
                                FROM {$serendipity['dbPrefix']}markread
                               WHERE visitor = '" . serendipity_db_escape_string($this->getToken()) . "'
                                 AND entryid = " . (int)$id, true, 'assoc');
        if (is_array($res)) {
            return $res['read_date'];
        } else {
            return false;
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'external_plugin':
                    $parts     = explode('_', $eventData);
                    if (!empty($parts[1])) {
                        $param     = (int)$parts[1];
                    } else {
                        return;
                    }

                    if ($parts[0] != 'markread') {
                        return;
                    }

                    $this->markRead($param);
?>
<html>
<head>
    <title><?php echo PLUGIN_MARKREAD_NAME; ?></title>
    <script type="text/javascript">
    self.close();
    </script>
</head>
<body>
<?php echo PLUGIN_MARKREAD_MSG; ?>
</body>
</html>
<?php

                    break;

                case 'frontend_fetchentries':
                case 'frontend_fetchentry':
                    $eventData['joins']  .= " LEFT OUTER JOIN {$serendipity['dbPrefix']}markread
                                                           AS mr
                                                           ON (mr.entryid = e.id AND mr.visitor = '" . serendipity_db_escape_string($this->getToken()) . "')\n";
                    $eventData['addkey'] .= "mr.read_date,\n";
                    return true;
                    break;

                case 'frontend_configure':
                    $this->checkScheme();

                    if (isset($serendipity['GET']['id'])) {
                        // Mark this entry as read, as it's called directly
                        $this->markRead($serendipity['GET']['id']);
                    }
                    break;

                case 'entry_display':
                    if (!is_array($eventData)) {
                        return false;
                    }

                    $read_url = $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/markread_%s';
                    $link = $this->get_config('marklink');
                    $text = $this->get_config('markedtext');

                    // Migrate the read status to the properties entry array, so that it can be used in your template:
                    // {if $entry.properties.read_date > 0}This entry has been read!{/if}
                    if (!is_array($eventData)) {
                    }
                    foreach($eventData as $i => $entry) {
                        if (!is_array($entry)) continue;

                        if (!isset($entry['read_date'])) {
                            $entry['read_date'] = $this->getRead($entry['id']);
                        }

                        $eventData[$i]['properties']['read_date'] = $entry['read_date'];
                        $eventData[$i]['properties']['read_link'] = sprintf($read_url, $entry['id']);

                        if ($entry['read_date'] > 0) {
                            $eventData[$i]['properties']['is_read'] = 1;
                            $eventData[$i]['add_footer'] .= '<div class="serendipity_mark_read serendipity_mark_read_yes">' . $text . '</div>';
                        } else {
                            $eventData[$i]['properties']['is_read'] = 0;
                            $eventData[$i]['add_footer'] .=
                                sprintf(
                                    '<div class="serendipity_mark_read serendipity_mark_read_no">
                                        <a href="#" onclick="window.open(\'%s\', \'markread\'); self.focus(); this.style.display = \'none\'; return false;">%s</a>
                                     </div>',

                                     sprintf($read_url, $entry['id']),
                                     $link
                                );
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
