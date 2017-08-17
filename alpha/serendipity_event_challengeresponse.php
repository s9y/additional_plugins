<?php
if (IN_serendipity !== true) die ("Don't hack!");

class serendipity_event_challengeresponse extends serendipity_event {
    function introspect(&$propbag) {
        global $serendipity;

        $this->title = 'Spam: Challenge/Response';

        $propbag->add('name',          $this->title);
        $propbag->add('description',   '');
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Nobody');
        $propbag->add('requirements',  array(
            'serendipity' => '1.0',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',       '0.12');
        $propbag->add('event_hooks',    array(
            'frontend_saveComment' => true,
            'frontend_comment'     => true
        ));
        $propbag->add('configuration', array(
            'challenge',
            'response',
            'error'));
        $propbag->add('groups', array('ANTISPAM'));
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;

        switch($name) {
            case 'challenge':
                $propbag->add('type', 'text');
                $propbag->add('name', 'Challenge');
                $propbag->add('description', '');
                $propbag->add('default', 'What\'s the name of this blog?');
                break;

            case 'response':
                $propbag->add('type', 'text');
                $propbag->add('name', 'Response');
                $propbag->add('description', '');
                $propbag->add('default', 'Serendipity');
                break;

            case 'error':
                $propbag->add('type', 'text');
                $propbag->add('name', 'Error message');
                $propbag->add('description', '');
                $propbag->add('default', 'You suck.');
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
                case 'frontend_saveComment':
                    if (!is_array($eventData) || serendipity_db_bool($eventData['allow_comments'])) {
                        if (is_string($_POST['response']) && strtolower($_POST['response']) === strtolower($this->get_config('response'))) {
                            return true;
                        }else{
                            $eventData = array('allow_comments' => false);
                            $serendipity['messagestack']['comments'][] = $this->get_config('error');
                            return false;
                        }
                    }

                    return true;
                    break;

                case 'frontend_comment':
                    echo '<div class="serendipity_challengeresponse"><label for="serendipity_challengeresponse_response">' . $this->get_config('challenge') . '</label>
                        <input type="text" id="serendipity_challengeresponse_response" name="response" value="" />
                        </div>';

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
