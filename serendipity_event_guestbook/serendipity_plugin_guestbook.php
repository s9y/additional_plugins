<?php # $Id$
/* guestbooksidebar plugin by Jaap Boerma // j@webbict.com // v1.02 // 18-10-2005 */


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_plugin_guestbook extends serendipity_plugin {
    var $title = PLUGIN_GUESTSIDE_NAME;
    #var $conty = array('%serendipity_event_guestbook%/showapp', '%serendipity_event_guestbook%/automoderate');
    
    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_GUESTSIDE_NAME);
        $propbag->add('description',   PLUGIN_GUESTSIDE_BLAHBLAH);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Jaap Boerma ( j@webbict.com ), Tadashi Jokagi <elf2000@users.sourceforge.net>, Ian (Timbalu)');
        $propbag->add('version',       '1.19');
        $propbag->add('requirements', array(
                        'serendipity' => '0.7',
                        'smarty'      => '2.6.7',
                        'php'         => '5.0.0'
                    ));
        $propbag->add('groups',        array('FRONTEND_FEATURES'));
        $propbag->add('configuration', array(
                        'title', 
                        'showemail', 
                        'showhomepage', 
                        'max_chars', 
                        'max_items', 
                        'dateformat')
        );
        $this->dependencies = array('serendipity_event_guestbook' => 'keep'); 
        
        #if(!is_array($serendipity['plugin_guestbook_dependency'])) { 
        #    $this->dependency_config_merge($this->conty);
        #}
    }

    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'title':
                $propbag->add('type','string');
                $propbag->add('name', PLUGIN_GUESTSIDE_TITLE);
                $propbag->add('description',PLUGIN_GUESTSIDE_TITLE_BLAHBLAH);
                $propbag->add('default', PLUGIN_GUESTSIDE_NAME);
            break;

            case 'showemail':
                $propbag->add('type','boolean');
                $propbag->add('name',PLUGIN_GUESTSIDE_SHOWEMAIL);
                $propbag->add('description',PLUGIN_GUESTSIDE_SHOWEMAIL_BLAHBLAH);
                $propbag->add('default','false');
            break;

            case 'showhomepage':
                $propbag->add('type','boolean');
                $propbag->add('name',PLUGIN_GUESTSIDE_SHOWHOMEPAGE);
                $propbag->add('description',PLUGIN_GUESTSIDE_SHOWHOMEPAGE_BLAHBLAH);
                $propbag->add('default','false');
            break;

            case 'max_chars':
                $propbag->add('type','string');
                $propbag->add('name',PLUGIN_GUESTSIDE_MAXCHARS);
                $propbag->add('description',PLUGIN_GUESTSIDE_MAXCHARS_BLAHBLAH);
                $propbag->add('default','50');
            break;

            case 'max_items':
                $propbag->add('type','string');
                $propbag->add('name',PLUGIN_GUESTSIDE_MAXITEMS);
                $propbag->add('description',PLUGIN_GUESTSIDE_MAXITEMS_BLAHBLAH);
                $propbag->add('default','1');
            break;

            case 'dateformat' :
                $propbag->add('type', 'string');
                $propbag->add('name', GENERAL_PLUGIN_DATEFORMAT);
                $propbag->add('description', sprintf(GENERAL_PLUGIN_DATEFORMAT_BLAHBLAH, '%a, %m.%m.%Y %H:%M'));
                $propbag->add('default', '%a, %d.%m.%Y %H:%M');
            break;
            
            default:
                return false;
        }
        return true;
    }

    /* collaps array by name, value */
    function array_collapse($arr, $x, $y) {
        $carr = array();
        while ($el = current($arr)) {
            $carr[ $el[$x] ] = $el[$y];
            next($arr);
        }
        return $carr;
    }
    
    
    /* require dependency event plugins config setting 
     * @param  $merge   = array(searchstrings)
     * @return db array
    **/
    function dependency_config_merge($merge) { 
        global $serendipity;
        $sql = "SELECT SUBSTRING_INDEX(name,'/',-1) AS dbname, value FROM {$serendipity['dbPrefix']}config WHERE (name LIKE '" . $merge[0] . "'";
        foreach ($merge AS $key => $value) { 
            if($key > 0) $sql .= " OR name LIKE '" . $value . "'";
        }
        $sql .= ")";
        $centries = serendipity_db_schema_import($sql, true, 'assoc', true); 
        if(is_array($centries)) { 
            $serendipity['plugin_guestbook_dependency'] = $this->array_collapse($centries, 'dbname', 'value');
            return true;
        }
        return false;
    }


    function generate_content(&$title) {
        global $serendipity;

        $title        = $this->get_config('title');
        $showemail    = serendipity_db_bool($this->get_config('showemail'));
        $showhomepage = serendipity_db_bool($this->get_config('showhomepage'));
        $max_chars    = $this->get_config('max_chars');
        $max_items    = $this->get_config('max_items');
        $dateformat   = $this->get_config('dateformat');

        if (!$max_items || !is_numeric($max_items) || $max_items < 1) {
            $max_items = 3;
        }
        if (!$max_chars || !is_numeric($max_chars) || $max_chars < 1) {
            $max_chars = 50;
        }

        if (!$dateformat || strlen($dateformat) < 1) {
            $dateformat = '%a, %d.%m.%Y %H:%M';
        }

        $sql = "SELECT timestamp, name";

        if ($showhomepage){
            $sql .=", homepage";
        }

        if ($showemail){
            $sql .=", email";
        }
        
        #if($this->get_config('dbversion') == '3.0') { 
        #    $sql .=", approved";
        #}
        
        #$whe = (serendipity_db_bool($serendipity['plugin_guestbook_dependency']['showapp']) === true || 
        #        serendipity_db_bool($serendipity['plugin_guestbook_dependency']['automoderate']) === true) 
        #        ? "WHERE approved=1" 
        #        : '';
        // as of 2012/01/19 disabled all this dependency tweaks, while not in real nead for the sidebar (why did I do this then?)
        $whe = "WHERE approved=1";
        
        $sql .=", body FROM {$serendipity['dbPrefix']}guestbook $whe ORDER BY timestamp DESC";
        $sql .=" LIMIT ".$max_items;

        $entries = serendipity_db_query($sql);
        if($entries && is_array($entries)) {
            foreach($entries as $e => $row) {
                echo "<strong>" . htmlspecialchars(serendipity_strftime($dateformat, $row['timestamp'])) . '</strong> <br />' . "\n";
                $row['body'] = htmlspecialchars($row['body']);
                if (strlen($row['body'])>$max_chars) {
                    if (function_exists('mb_strimwidth')) {
                        $row['body'] = mb_strimwidth($row['body'],0,$max_chars,"...");
                    } else {
                        $row['body'] = substr($row['body'],0,$max_chars)."...";
                    }
                }
                $entry = array('comment' => $row['body']);
                serendipity_plugin_api::hook_event('frontend_display', $entry);

                echo $entry['comment'] . "<br />";
                echo "<strong>" . htmlspecialchars($row['name']) . "</strong><br />";

                if ($showemail){
                    echo "<a href=\"mailto:" . htmlspecialchars($row['email']) . "\">" . htmlspecialchars($row['email']) . "</a>";
                }

                if ($showhomepage) {
                    if ($showemail) {
                        echo "<br />";
                    }
                    echo "<a href=\"" . htmlspecialchars($row['homepage']) . "\">" . htmlspecialchars($row['homepage']) . "</a>";
                }

                echo "<br />\n\n";
            }
        } else {
            echo PLUGIN_GUESTSIDE_NOENTRIES ."<br />";
        }
    }
}


/* vim: set sts=4 ts=4 expandtab : */