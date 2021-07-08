<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_randomblogdescription extends serendipity_event
{
    var $title = PLUGIN_EVENT_RANDOMBLOGDESCRIPTION_NAME;
    var $dbold = '';

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',        PLUGIN_EVENT_RANDOMBLOGDESCRIPTION_NAME);
        $propbag->add('description', PLUGIN_EVENT_RANDOMBLOGDESCRIPTION_DESC);
        $propbag->add('stackable',   false);
        $propbag->add('author',      'Florian Anderiasch');
        $propbag->add('version',     '0.6');
        $propbag->add('configuration', array('enabled', 'blogdescription'));
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks', array('frontend_configure' => true));
        $propbag->add('groups', array('BACKEND_METAINFORMATION'));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;


        switch($name) {
            case 'enabled':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        RBD_ACTIVE);
                $propbag->add('description', RBD_ACTIVE_BLAHBLAH);
                $propbag->add('default',     'true');
                break;

            case 'blogdescription':
                $propbag->add('type',        'text');
                $propbag->add('name',        RBD_ENTRIES);
                $propbag->add('description', RBD_ENTRIES_BLAHBLAH);
                $propbag->add('default',     "1:this description has frequency 1\nthis description has frequency 1, too\n2:but this description is displayed twice as often");
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
              case 'frontend_configure':

                if (serendipity_db_bool($this->get_config('enabled'))) {
                    $cfg = $this->get_config('blogdescription');
                    $c = explode('<br />', nl2br($cfg));
                    $tags = array();

                    foreach($c as $k => $v) {
                        $v = trim($v);
                        $pos = strpos($v, ':');
                        if ($pos === false) {
                            $tags[] = $v;
                        } else {
                            $count = substr($v, 0, $pos);
                            if (!is_numeric($count)) {
                                $tags[] = $v;
                            } else {
                                $v = substr($v, $pos+1);
                                for($i=0; $i<$count; $i++) {
                                    $tags[] = $v;
                                }
                            }
                        }
                    }

                    $count = count($tags);
                    if ($count > 0) {
                        $num = rand(0, $count-1);
                        $desc = $tags[$num];
                        $serendipity['blogDescription'] = $desc;
                    }
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
}

/* vim: set sts=4 ts=4 expandtab : */
