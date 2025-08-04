<?php /* serendipity_plugin_timezones.php from Christoph Eunicke <s9y-plugin@eunicke.org> */


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_timezones extends serendipity_plugin {
    var $title = PLUGIN_TIMEZONES_TITLE;
    function introspect(&$propbag) {
        $propbag->add('name',           PLUGIN_TIMEZONES_TITLE);
        $propbag->add('description',    PLUGIN_TIMEZONES_BLAHBLAH);
        $propbag->add('configuration',  array('title', 'zone1_text', 'zone1_name', 'zone1_format',
                                                       'zone2_text', 'zone2_name', 'zone2_format',
                            'zone3_text', 'zone3_name', 'zone3_format',
                            'zone4_text', 'zone4_name', 'zone4_format'));
        $propbag->add('author',         'Christoph Eunicke <s9y-plugin@eunicke.org>');
        $propbag->add('stackable',      true);
        $propbag->add('version',        '1.0');
        $propbag->add('requirements',  array(
            'serendipity' => '0.9',
            'smarty'      => '2.6.7',
            'php'         => '5.2.0'
        ));
        $propbag->add('groups', array('FRONTEND_FEATURES'));
    }

    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'zone1_text':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_TIMEZONES_ZONE1_TEXT);
                $propbag->add('description',    PLUGIN_TIMEZONES_ZONE1_TEXT_BLABLAH);
                $propbag->add('default',        'Cologne:');
                break;

            case 'zone2_text':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_TIMEZONES_ZONE2_TEXT);
                $propbag->add('description',    PLUGIN_TIMEZONES_ZONE2_TEXT_BLABLAH);
                $propbag->add('default',        'Sacramento:');
                break;

            case 'zone3_text':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_TIMEZONES_ZONE3_TEXT);
                $propbag->add('description',    PLUGIN_TIMEZONES_ZONE3_TEXT_BLABLAH);
                $propbag->add('default',        '');
                break;

            case 'zone4_text':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_TIMEZONES_ZONE4_TEXT);
                $propbag->add('description',    PLUGIN_TIMEZONES_ZONE4_TEXT_BLABLAH);
                $propbag->add('default',        '');
                break;

            case 'title':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_TIMEZONES_NUGGET_TITLE);
                $propbag->add('description', PLUGIN_TIMEZONES_NUGGET_TITLE_BLABLAH);
                $propbag->add('default', PLUGIN_TIMEZONES_TITLE);
                break;

            case 'zone1_name':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_TIMEZONES_ZONE1_NAME);
                $propbag->add('description',    PLUGIN_TIMEZONES_ZONE1_NAME_BLABLAH);
                $propbag->add('default',        'Europe/Berlin');
                break;

            case 'zone2_name':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_TIMEZONES_ZONE2_NAME);
                $propbag->add('description',    PLUGIN_TIMEZONES_ZONE2_NAME_BLABLAH);
                $propbag->add('default',        'PST');
                break;

            case 'zone3_name':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_TIMEZONES_ZONE3_NAME);
                $propbag->add('description',    PLUGIN_TIMEZONES_ZONE3_NAME_BLABLAH);
                $propbag->add('default',        '');
                break;

            case 'zone4_name':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_TIMEZONES_ZONE4_NAME);
                $propbag->add('description',    PLUGIN_TIMEZONES_ZONE4_NAME_BLABLAH);
                $propbag->add('default',        '');
                break;

            case 'zone1_format':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_TIMEZONES_ZONE1_FORMAT);
                $propbag->add('description',    PLUGIN_TIMEZONES_ZONE1_FORMAT_BLABLAH);
                $propbag->add('default',        'H:i');
                break;

            case 'zone2_format':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_TIMEZONES_ZONE2_FORMAT);
                $propbag->add('description',    PLUGIN_TIMEZONES_ZONE1_FORMAT_BLABLAH);
                $propbag->add('default',        'H:i');
                break;

            case 'zone3_format':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_TIMEZONES_ZONE3_FORMAT);
                $propbag->add('description',    PLUGIN_TIMEZONES_ZONE1_FORMAT_BLABLAH);
                $propbag->add('default',        '');
                break;

            case 'zone4_format':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_TIMEZONES_ZONE4_FORMAT);
                $propbag->add('description',    PLUGIN_TIMEZONES_ZONE1_FORMAT_BLABLAH);
                $propbag->add('default',        '');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {
        global $serendipity;

        $title = $this->get_config('title');
        $d = new DateTimeImmutable();
        $timezoneIds = [$this->get_config('zone1_name'), $this->get_config('zone2_name'), $this->get_config('zone3_name'), $this->get_config('zone4_name')];

        echo '<ul class="plainList">';
        $i = 0;
        foreach ($timezoneIds as $timezoneId) {
            $i += 1;
            if ($timezoneId) {
                $tzo = new DateTimeZone($timezoneId);
                $local = $d->setTimezone($tzo);
                
                echo '<li>';
                echo $this->get_config("zone{$i}_text");
                echo ' ';
                echo $local->format( $this->get_config("zone{$i}_format"));
                echo '</li>';
            }
        }

        echo '</ul>';
    }
} 