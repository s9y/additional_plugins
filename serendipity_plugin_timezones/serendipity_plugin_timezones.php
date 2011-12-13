<?php /* serendipity_plugin_timezones.php from Christoph Eunicke <s9y-plugin@eunicke.org> */


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_plugin_timezones extends serendipity_plugin {
    var $title = PLUGIN_TIMEZONES_TITLE;
    function introspect(&$propbag) {
        $propbag->add('name',           PLUGIN_TIMEZONES_TITLE);
        $propbag->add('description',    PLUGIN_TIMEZONES_BLAHBLAH);
        $propbag->add('configuration',  array('title', 'zone1_text', 'zone1_name', 'zone1_format', 'timeshift1',
                                                       'zone2_text', 'zone2_name', 'zone2_format', 'timeshift2',
                            'zone3_text', 'zone3_name', 'zone3_format', 'timeshift3',
                            'zone4_text', 'zone4_name', 'zone4_format', 'timeshift4'));
        $propbag->add('author',         'Christoph Eunicke <s9y-plugin@eunicke.org>');
        $propbag->add('stackable',      true);
        $propbag->add('version',        '0.5');
        $propbag->add('requirements',  array(
            'serendipity' => '0.9',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
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
                $propbag->add('default',        'WEST');
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
                $propbag->add('default',        '%T');
                break;

            case 'zone2_format':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_TIMEZONES_ZONE2_FORMAT);
                $propbag->add('description',    PLUGIN_TIMEZONES_ZONE1_FORMAT_BLABLAH);
                $propbag->add('default',        '%T');
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

            case 'timeshift1':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_TIMEZONES_TIMESHIFT1);
                $propbag->add('description',    PLUGIN_TIMEZONES_TIMESHIFT1_BLABLAH);
                $propbag->add('default',        '');
                break;

            case 'timeshift2':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_TIMEZONES_TIMESHIFT2);
                $propbag->add('description',    PLUGIN_TIMEZONES_TIMESHIFT1_BLABLAH);
                $propbag->add('default',        '');
                break;

            case 'timeshift3':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_TIMEZONES_TIMESHIFT3);
                $propbag->add('description',    PLUGIN_TIMEZONES_TIMESHIFT1_BLABLAH);
                $propbag->add('default',        '');
                break;

            case 'timeshift4':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_TIMEZONES_TIMESHIFT4);
                $propbag->add('description',    PLUGIN_TIMEZONES_TIMESHIFT1_BLABLAH);
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

        if (($this->get_config('timeshift1') == "" ||
            $this->get_config('timeshift2') == "" ||
            $this->get_config('timeshift3') == "" ||
            $this->get_config('timeshift4') == "" ) &&
            @include_once 'Date.php') {

            $date = new Date();
            //create the first date

            $date->convertTZbyID($this->get_config('zone1_name'));
            $date1=$date->format($this->get_config('zone1_format'));

            $date->convertTZbyID($this->get_config('zone2_name'));
            $date2=$date->format($this->get_config('zone2_format'));

            $date->convertTZbyID($this->get_config('zone3_name'));
            $date3=$date->format($this->get_config('zone3_format'));

            $date->convertTZbyID($this->get_config('zone4_name'));
            $date4=$date->format($this->get_config('zone4_format'));
        } else {
            $date1=date($this->get_config('zone1_format'),time()+$this->get_config('timeshift1'));
            $date2=date($this->get_config('zone2_format'),time()+$this->get_config('timeshift2'));
            $date3=date($this->get_config('zone3_format'),time()+$this->get_config('timeshift3'));
            $date4=date($this->get_config('zone4_format'),time()+$this->get_config('timeshift4'));
        }

        echo '<ul class="plainList">';
        echo '<li>';
        echo $this->get_config('zone1_text');
        echo $date1;
        echo '</li>';

        echo '<li>';
        echo $this->get_config('zone2_text');
        echo $date2;
        echo '</li>';
   
        if ($this->get_config('zone3_text') !== ""){ //Third zone required
            echo '<li>';
            echo $this->get_config('zone3_text');
            echo $date3;
            echo '</li>';

            if ($this->get_config('zone4_text') !== ""){ //Fourth zone required
                echo '<li>';
                echo $this->get_config('zone4_text');
                echo $date4;
                echo '</li>';
            }
        }
        echo '</ul>';
    }
} 