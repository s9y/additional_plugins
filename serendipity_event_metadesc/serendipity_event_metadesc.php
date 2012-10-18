<?php # $Id$


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_metadesc extends serendipity_event {
    var $title = PLUGIN_METADESC_NAME;
    var $save_title = '';
    var $save_subtitle = '';
    var $meta_title = '';
    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_METADESC_NAME);
        $propbag->add('description',   PLUGIN_METADESC_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Judebert, Don Chambers');
        $propbag->add('version',       '0.14');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'php'         => '4.1.0'
        ));

        $propbag->add('event_hooks', array(
            'genpage'                                           => true,
            'frontend_header'                                   => true,
            'backend_publish'                                   => true,
            'backend_save'                                      => true,
            'backend_display'                                   => true,
            'backend_delete_entry'                              => true,
            'frontend_entryproperties'                          => true,
            'frontend_fetchentry'                               => true,
            'xmlrpc_updertEntry'                                => true,
            'xmlrpc_fetchEntry'                                 => true,
            'xmlrpc_deleteEntry'                                => true,
        ));
        $propbag->add('groups', array('FRONTEND_ENTRY_RELATED', 'BACKEND_METAINFORMATION'));
        $propbag->add('configuration', array('tag_names', 'default_description', 'default_keywords', 'escape'));
        $this->supported_properties = array('meta_description', 'meta_keywords', 'meta_head_title');
    }

    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'tag_names':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_METADESC_TAGNAMES);
                $propbag->add('description', PLUGIN_METADESC_TAGNAMES_DESC);
                $propbag->add('default',     'b,strong');
                break;
            case 'default_description':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_METADESC_DEFAULT_DESCRIPTION);
                $propbag->add('description', PLUGIN_METADESC_DEFAULT_DESCRIPTION_DESC);
                $propbag->add('default',     '');
                break;
            case 'default_keywords':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_METADESC_DEFAULT_KEYWORDS);
                $propbag->add('description', PLUGIN_METADESC_DEFAULT_KEYWORDS_DESC);
                $propbag->add('default',     '');
                break;

            case 'escape':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_METADESC_ESCAPE);
                $propbag->add('description', PLUGIN_METADESC_ESCAPE_DESC);
                $propbag->add('default',     true);
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function extract_description($text) {
        $x = strpos($text, '<p>');
        if ($x === false) {
            return substr(strip_tags($text), 0, 120);
        }

        $y = strpos($text, '</p>');
        if ($y === false) {
            return substr(strip_tags($text), 0, 120);
        }

        $title = substr($text, $x+3, $y-($x+3));
        $title = strip_tags($title);
        return $title;
    }

    function extract_keywords($text) {
        $tag_names = $this->get_config('tag_names');
        $tags = explode(",", $tag_names);
        $tags_count = count($tags);
        $results = array();
        for ($i=0; $i < $tags_count; $i++) {
            if (preg_match_all('/<' . $tags[$i] . '[^>]*>([^>]*)<\/' . $tags[$i] . '>/si', $text, $match)) {
                $results = array_merge($results, $match[1]);
            }
        }
        return $results;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'genpage':
                    // The 'genpage' hook is our last chance to modify Smarty
                    // variables before the template is called for the HTML head.

                    // Only modify the title on single-entry pages
                    if ($addData['view'] == 'entry') {
                        // Get the properties for this entry
                        $myid = $serendipity['GET']['id'];
                        // Requires a database fetch, but the only other way
                        // get the entry properties is to wait until we
                        // generate the entry; by the time that hook is
                        // called, the <title> tag has already been emitted.
                        // We need those properties now!
                        $property = serendipity_fetchEntryProperties($myid);
                        // Set a title, if one was defined for this entry
                        if (!empty($property['meta_head_title'])) {
                            // Make the variable name a little less unwieldy
                            $this->meta_title = $property['meta_head_title'];
                            $this->save_title = $serendipity['head_title'];
                            $this->save_subtitle = $serendipity['head_subtitle'];
                            $serendipity['head_title'] = htmlspecialchars($this->meta_title);
                            // Clear the subtitle (many templates use it along with the title)
                            $serendipity['head_subtitle'] = '';
                        }
                    }
                    return true;
                    break;
                case 'frontend_header':
                    $default_description = $this->get_config('default_description');
                    $default_keywords = $this->get_config('default_keywords');

                    // Only emit in Single Entry Mode
                    if ($serendipity['GET']['id'] && isset($GLOBALS['entry'][0]['body'])) {

                        // If we modified the <title>...
                        if (!empty($this->meta_title)) {
                            // We've messed up the banner.  Put it back the way it was.
                            // Set smarty variables for banner back to normal "entry title - blog description"
                            $serendipity['smarty']->assign(
                                array(
                                'head_title'    => $this->save_title,
                                'head_subtitle' => $this->save_subtitle
                                )
                            );
                        }

                        $meta_description = $GLOBALS['entry'][0]['properties']['meta_description'];
                        if (empty($meta_description)) {
                            $meta_description = $this->extract_description($GLOBALS['entry'][0]['body']);
                        }

                        $meta_keywords = $GLOBALS['entry'][0]['properties']['meta_keywords'];
                        if (empty($meta_keywords)) {
                            $meta_keywords = (array)$this->extract_keywords($GLOBALS['entry'][0]['body']);
                            if (!empty($meta_keywords))
                            {
                                $meta_keywords = implode(',', $meta_keywords);
                            } else {
                                // no entry specific keywords for this entry and extract_keywords was returned empty
                                $meta_keywords = $default_keywords;
                            }
                        }


                        if (serendipity_db_bool($this->get_config('escape'))) {
                            $md = htmlspecialchars($meta_description);
                            $mk = htmlspecialchars($meta_keywords);
                        } else {
                            $md = $meta_description;
                            $mk = $meta_keywords;
                        }
                        echo '<meta name="description" content="' . $md . '" />' . "\n";
                        if (!empty($meta_keywords))
                        {
                            echo '        <meta name="keywords" content="' . $mk . '" />' . "\n";
                        }
                    } else {
                        // emit default meta description and meta keyword, if not blank, for pages other than single entry

                        if (serendipity_db_bool($this->get_config('escape'))) {
                            $md = htmlspecialchars($default_description);
                            $mk = htmlspecialchars($default_keywords);
                        } else {
                            $md = $default_description;
                            $mk = $default_keywords;
                        }

                        if (!empty($default_description))
                        {
                            echo '<meta name="description" content="' . $md . '" />' . "\n";
                        }
                        if (!empty($default_keywords))
                        {
                            echo '        <meta name="keywords" content="' . $mk . '" />' . "\n";
                        }
                    }
                    break;

                case 'backend_publish':
                case 'backend_save':
                    if (!isset($serendipity['POST']['properties']) || !is_array($serendipity['POST']['properties']) || !isset($eventData['id'])) {
                        return true;
                    }

                    // Get existing data
                    $property = serendipity_fetchEntryProperties($eventData['id']);

                    foreach($this->supported_properties AS $prop_key) {
                        $prop_val = (isset($serendipity['POST']['properties'][$prop_key]) ? $serendipity['POST']['properties'][$prop_key] : null);
                        if (!isset($property[$prop_key]) && !empty($prop_val)) {
                            $q = "INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, property, value) VALUES (" . (int)$eventData['id'] . ", '" . serendipity_db_escape_string($prop_key) . "', '" . serendipity_db_escape_string($prop_val) . "')";
                        } elseif ($property[$propkey] != $prop_val && !empty($prop_val)) {
                            $q = "UPDATE {$serendipity['dbPrefix']}entryproperties SET value = '" . serendipity_db_escape_string($prop_val) . "' WHERE entryid = " . (int)$eventData['id'] . " AND property = '" . serendipity_db_escape_string($prop_key) . "'";
                        } else {
                            $q = "DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = " . (int)$eventData['id'] . " AND property = '" . serendipity_db_escape_string($prop_key) . "'";
                        }

                        serendipity_db_query($q);
                    }

                    return true;
                    break;

                case 'backend_display':
                    if (isset($serendipity['POST']['properties']['meta_description'])) {
                        $meta_description = $serendipity['POST']['properties']['meta_description'];
                    } elseif (isset($eventData['properties']['meta_description'])) {
                        $meta_description = $eventData['properties']['meta_description'];
                    } else {
                        $meta_description = '';
                    }

                    if (isset($serendipity['POST']['properties']['meta_keywords'])) {
                        $meta_keywords = $serendipity['POST']['properties']['meta_keywords'];
                    } elseif (isset($eventData['properties']['meta_keywords'])) {
                        $meta_keywords = $eventData['properties']['meta_keywords'];
                    } else {
                        $meta_keywords = '';
                    }

                    if (isset($serendipity['POST']['properties']['meta_head_title'])) {
                        $meta_head_title = $serendipity['POST']['properties']['meta_head_title'];
                    } elseif (isset($eventData['properties']['meta_head_title'])) {
                        $meta_head_title = $eventData['properties']['meta_head_title'];
                    } else {
                        $meta_head_title = '';
                    }
                    
?>
                    <fieldset style="margin: 5px">
                        <legend><?php echo PLUGIN_METADESC_NAME; ?></legend>
                        <p class="meta_description"><em><?php echo PLUGIN_METADESC_FORM; ?></em></p>

                        <label for="serendipity[properties][meta_description]"><?php echo PLUGIN_METADESC_DESCRIPTION; ?></label><br />
                        <input class="input_textbox" type="text" style="width: 100%" value="<?php echo htmlspecialchars($meta_description); ?>" name="serendipity[properties][meta_description]" id="properties_meta_description" />
                        <span class="meta_string_length"><?php echo PLUGIN_METADESC_LENGTH . ': ' . str_word_count($meta_description) . ' '. PLUGIN_METADESC_WORDS . ', ' . strlen($meta_description) . ' ' . PLUGIN_METADESC_CHARACTERS; ?></span>
                        <br /><br />
                        <label for="serendipity[properties][meta_keywords]"><?php echo PLUGIN_METADESC_KEYWORDS; ?></label><br />
                        <input class="input_textbox" type="text" style="width: 100%" value="<?php echo htmlspecialchars($meta_keywords); ?>" name="serendipity[properties][meta_keywords]" id="properties_meta_keywords" />
                        <span class="meta_string_length"><?php echo PLUGIN_METADESC_LENGTH . ': ' . str_word_count($meta_keywords) . ' '. PLUGIN_METADESC_WORDS . ', ' . strlen($meta_keywords) . ' ' . PLUGIN_METADESC_CHARACTERS; ?></span>
                        <br /><br />

                        <p class="meta_description"><em><?php echo PLUGIN_METADESC_HEADTITLE_DESC; ?></em></p>

                        <label for="serendipity[properties][meta_head_title]"><?php echo PLUGIN_METADESC_HEADTITLE; ?></label><br />
                        <input class="input_textbox" type="text" style="width: 100%" value="<?php echo htmlspecialchars($meta_head_title); ?>" name="serendipity[properties][meta_head_title]" id="properties_headtitle" />
                        <span class="meta_string_length"><?php echo PLUGIN_METADESC_LENGTH . ': ' . str_word_count($meta_head_title) . ' '. PLUGIN_METADESC_WORDS . ', ' . strlen($meta_head_title) . ' ' . PLUGIN_METADESC_CHARACTERS; ?></span>

                        <p class="meta_stringlength_disclaimer"><em><?php echo '<sup>*</sup> ' . PLUGIN_METADESC_STRINGLENGTH_DISCLAIMER; ?></em></p>
                    </fieldset>
<?php
                    return true;
                    break;

                case 'xmlrpc_deleteEntry':
                case 'backend_delete_entry':
                            $q = "DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = " . (int)$eventData['id'] . " AND property LIKE '%meta_%'";
                            serendipity_db_query($q);
                    return true;
                    break;

                case 'frontend_entryproperties':
                    if (class_exists('serendipity_event_entryproperties') || !is_array($addData)) {
                        // Fetching of properties is already done there, so this is just for poor users who don't have the entryproperties plugin enabled
                        return true;
                    }
                    $q = "SELECT entryid, property, value FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid IN (" . implode(', ', array_keys($addData)) . ") AND property LIKE '%meta_%'";
                    $properties = serendipity_db_query($q);
                    if (!is_array($properties)) {
                        return true;
                    }
                    foreach($properties AS $idx => $row) {
                        $eventData[$addData[$row['entryid']]]['properties'][$row['property']] = $row['value'];
                    }
                    return true;
                    break;

/* MAYBE FOR FUTURE
                case 'frontend_fetchentry':
                    $cond  = "meta_d.value AS meta_description,\n";
                    $cond .= "meta_k.value AS meta_keywords,\n";
                    if (empty($eventData['addkey'])) {
                        $eventData['addkey'] = $cond;
                    } else {
                        $eventData['addkey'] .= $cond;
                    }
                    $cond  = "\nLEFT OUTER JOIN {$serendipity['dbPrefix']}entryproperties meta_d
                                                 ON (e.id = meta_d.entryid AND meta_d.property = 'meta_description')";
                    $cond .= "\nLEFT OUTER JOIN {$serendipity['dbPrefix']}entryproperties meta_k
                                                 ON (e.id = meta_k.entryid AND meta_d.property = 'meta_keywords')";

                    if (empty($eventData['joins'])) {
                        $eventData['joins'] = $cond;
                    } else {
                        $eventData['joins'] .= $cond;
                    }

                    return true;
                    break;
*/

                case 'xmlrpc_updertEntry':
                    if (isset($eventData['id'])) {
                        //XMLRPC call

                        if (!empty($eventData['mt_keywords'])) {
                            $property = serendipity_fetchEntryProperties($eventData['id']);
                            if (!isset($property['meta_keywords'])) {
                                 $q = "INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, property, value) VALUES (" . (int)$eventData['id'] . ", 'meta_keywords', '" . serendipity_db_escape_string($eventData['mt_keywords']) . "')";
                            } elseif ($property['mt_keywords'] != $eventData['mt_keywords']) {
                                 $q = "UPDATE {$serendipity['dbPrefix']}entryproperties SET value = '" . serendipity_db_escape_string($eventData['mt_keywords']) . "' WHERE entryid = " . (int)$eventData['id'] . " AND property = 'meta_keywords'";
                            } else {
                                 $q = "DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = " . (int)$eventData['id'] . " AND property = 'meta_keywords'";
                            }
                            serendipity_db_query($q);
                       }
                    }
                    return true;
                    break;

                case 'xmlrpc_fetchEntry':
                    if (isset($eventData['id'])) {
                        //XMLRPC call
                        $q = "SELECT entryid, property, value FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid IN (" . $eventData['id'] . ") AND property LIKE '%meta_keywords%'";
                        $properties = serendipity_db_query($q);
                        if (!is_array($properties)) {
                            return true;
                        }
                        //wow, this is hack... is there a better way?
                        $properties = $properties[0];
                        $eventData['mt_keywords']=$properties['value'];
                    }
                    return true;
                    break;

                default:
                    return false;
                    break;
            }

            return true;
        } else {
            return false;
        }
    }
}

/* vim: set sts=4 ts=4 expandtab : */
