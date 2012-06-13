<?php
/**
 * serendipity_event_geshi.php
 *
 * This event plugin is a wrapper around GeSHi, the Generic Syntax Hi-liter
 * package.  This plugin allows you to use markup inside your articles that
 * indicates you are embedding code.
 *
 * The markup tag is:
 * [geshi lang=name {ln={y|n}}] [/geshi].
 *
 * Where 'name' is the name of the language file, and ln= is an optional
 * line numbering over ride parameter, that will explicitly set line numbering
 * for the code block to yes (on) or no (off).
 *
 * For example, to make a c++ block with line numbering on:
 *
 * [geshi lang=c++ ln=y] ..c++ code here [/geshi]
 *
 * There are numerous language files included with geshi, and it is even
 * possible to extend the package by defining your own files and including them
 * in the /geshi/ subdirectory.  See the GeSHi project page for more
 * information.
 *
 * $Id$
 * @package Serendipity
 * @author David Rolston <gizmo@gizmola.com>
 * @version 05
 *
 * .02 release:
 * -Enabled Path to GeSHi override.  Default should be best for 99.9% of users
 * -Default line numbering option implemented
 * -added ln={y|n} to turn on line numbering inside individual blocks
 * (overriding the default, set during plugin configuration)
 * -IE line numbering style issues magically went away in serendipity 08
 *
 * .03 release:
 * -Code blocks are now forced to be left aligned,
 * thanks to patch from Norbert Mocsnik
 *
 * .04 release:
 * Thanks to Ivan Cenov for language enhancements and bulgarian language strings
 * -Added PLUGIN_EVENT_GESHI_PATHTOGESHI_DESC and PLUGIN_EVENT_GESHI_SHOWLINENUMBERS_DESC strings.
 * -Changes in function introspect_config_item to use these string constants.
 *
 * .05 release
 * Updated GeSHi to latest release (1.0.7.4)
 * This release includes some fixes, and new language files for: applescript, D, diff output, DIV game language, DOS batch language,
 * eiffel, freebasic, gml, Delphi Inno script, Matlab M language files, MySQL specific SQL, Objective CAML, Ruby, Scheme, SDLBasic, and VHDL: Very high speed integrated circuit HDL
 *
 */


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_geshi extends serendipity_event
{
    var $title = PLUGIN_EVENT_GESHI_NAME;
    // Top Level Configuration, requires name of the Plugin, description text, and configuration information in an array..
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_GESHI_NAME);
        $propbag->add('description',   PLUGIN_EVENT_GESHI_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'David Rolston');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',       '0.9');
        $propbag->add('event_hooks', array('frontend_display' => true, 'frontend_comment' => true));
        $propbag->add('groups', array('MARKUP'));

        $this->markup_elements = array(
            array(
              'name'     => 'ENTRY_BODY',
              'element'  => 'body',
            ),
            array(
              'name'     => 'EXTENDED_BODY',
              'element'  => 'extended',
            ),
            array(
              'name'     => 'COMMENT',
              'element'  => 'comment',
            ),
            array(
              'name'     => 'HTML_NUGGET',
              'element'  => 'html_nugget',
            )
        );

        $conf_array = array('pathtogeshi','showlinenumbers');
        foreach($this->markup_elements as $element) {
            $conf_array[] = $element['name'];
        }
        $propbag->add('configuration', $conf_array);
    }

    function generate_content(&$title) {
        $title = $this->title;
    }


    function introspect_config_item($name, &$propbag) {
        switch ($name) {
            case 'pathtogeshi' :
                $propbag->add('name',        PLUGIN_EVENT_GESHI_PATHTOGESHI);
                $propbag->add('type', 'string');
                $propbag->add('description', PLUGIN_EVENT_GESHI_PATHTOGESHI_DESC);
                $pathtogeshi = substr(__FILE__, 0, strrpos(__FILE__, '/'));
                $propbag->add('default', $pathtogeshi);
                break;
            case 'showlinenumbers' :
                $propbag->add('name',        PLUGIN_EVENT_GESHI_SHOWLINENUMBERS);
                $propbag->add('type', 'boolean');
                $propbag->add('description', PLUGIN_EVENT_GESHI_SHOWLINENUMBERS_DESC);
                $propbag->add('default', 'false');
                break;
            default :
                $propbag->add('name',        constant($name));
                $propbag->add('type',        'boolean');
                $propbag->add('default',     'true');
                $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
        }
        return true;
    }

    function geshi($input) {
        $pathtogeshi = $this->get_config('pathtogeshi');
        require_once($pathtogeshi . '/geshi.php');
        $input = preg_replace_callback('/\[geshi(?:\s)*lang=([A-Za-z0-9_\-]+)(?:\s)*(ln=[YyNn])?\](.*?)\[\/geshi\]/si', array(&$this, 'geshicallback'), $input);
        return $input;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_display':
                    foreach ($this->markup_elements as $temp) {
                        if (serendipity_db_bool($this->get_config($temp['name'], true)) && isset($eventData[$temp['element']]) &&
                            !$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                            !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = $temp['element'];
                            $eventData[$element] = $this->geshi($eventData[$element]);
                        }
                    }
                    return true;
                    break;

                case 'frontend_comment':
                    if (serendipity_db_bool($this->get_config('COMMENT', true))) {
                        echo '<div class="serendipity_commentDirection serendipity_comment_geshi">' . PLUGIN_EVENT_GESHI_TRANSFORM . '</div>';
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

    function geshicallback($matches) {
        $pathtogeshi = $this->get_config('pathtogeshi') . '/geshi';
        $geshilang = strtolower($matches[1]);
        $showln = ($this->get_config('showlinenumbers') == TRUE) ? TRUE : FALSE;
        if ((strlen($matches[2]) == 4) and (substr($matches[2], 0, 3) == 'ln=')) {
            $showln = (strtolower(substr($matches[2],-1)) == 'y') ? TRUE : FALSE;
        }
        $geshi = new GeSHi($matches[3], $geshilang, $pathtogeshi);
        $geshi->set_header_type(GESHI_HEADER_DIV);
        if ($showln)
            $geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
        // Have to get rid of newlines.
        // Left align per suggestion from Norbert Mocsnik
        $geshi->set_overall_style('text-align: left');
        $geshi->set_overall_class('geshi');
        return str_replace("\n", '', $geshi->parse_code());
    }
}
/* vim: set sts=4 ts=4 expandtab : */
?>