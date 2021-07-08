<?php

// Wikipedia Finder Plugin for Serendipity
// 10/2004 by Thomas Nesges <thomas@tnt-computer.de>
// Mozilla-compatible Javascript by Garvin Hicking (http://www.supergarv.de)
// English translation and some Javascript-Debugging done by Paul Wistrand (http://paulwistrand.com)
// Spanish translation by Francisco Ortiz <frortiz@gmail.com>


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_wikipedia_finder extends serendipity_plugin {

    function introspect(&$propbag) {
        $propbag->add('name',           PLUGIN_WIKIPEDIAFINDER_TITLE);
        $propbag->add('description',    PLUGIN_WIKIPEDIAFINDER_DESC);
        $propbag->add('configuration',  array('title', 'site', 'color', 'target', 'jswindow', 'jswindow_height', 'jswindow_width'));
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

        $propbag->add('legal',    array(
            'services' => array(
                'wikipedia' => array(
                    'url'  => 'https://www.wikipedia.com/',
                    'desc' => 'Looks up a selected term on the Wikipedia'
                )
            ),
            'frontend' => array(
                'Users can select text on the blog and look up the term on Wikipedia. When clicking the submit button, the selected text is submitted to wikipedia from the client\'s browser. Wikipedia will then be able to submit Cookies and knows the visitor\s IP.',
            ),
            'backend' => array(
            ),
            'cookies' => array(
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => true,
            'transmits_user_input'  => true
        ));


        $propbag->add('version',     '1.5.1');
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
    }

    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'title':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_WIKIPEDIAFINDER_PROP_TITLE);
                $propbag->add('description',    PLUGIN_WIKIPEDIAFINDER_PROP_TITLE_DESC);
                $propbag->add('default',        PLUGIN_WIKIPEDIAFINDER_TITLE);
                break;

            case 'site':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_WIKIPEDIAFINDER_PROP_SITE);
                $propbag->add('description',    PLUGIN_WIKIPEDIAFINDER_PROP_SITE_DESC);
                $propbag->add('default',        PLUGIN_WIKIPEDIAFINDER_SITE);
                break;

            case 'color':
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_WIKIPEDIAFINDER_PROP_COLOR);
                $propbag->add('description',    PLUGIN_WIKIPEDIAFINDER_PROP_COLOR_DESC);
                $propbag->add('select_values',  array('black' => PLUGIN_WIKIPEDIAFINDER_PROP_COLOR_DARK, 'white' => PLUGIN_WIKIPEDIAFINDER_PROP_COLOR_LIGHT));
                $propbag->add('default',        'black');
                break;

            case 'target':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_WIKIPEDIAFINDER_PROP_TARGET);
                $propbag->add('description',    PLUGIN_WIKIPEDIAFINDER_PROP_TARGET_DESC);
                $propbag->add('default',        "");
                break;

            case 'jswindow':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW);
                $propbag->add('description',    PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_DESC);
                $propbag->add('default',        "false");
                break;

            case 'jswindow_height':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_HEIGHT);
                $propbag->add('description',    PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_HEIGHT_DESC);
                $propbag->add('default',        "600");
                break;

            case 'jswindow_width':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_WIDTH);
                $propbag->add('description',    PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_WIDTH_DESC);
                $propbag->add('default',        "600");
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {
        global $serendipity;

        $title              = $this->get_config('title', PLUGIN_WIKIPEDIAFINDER_TITLE);
        $site               = $this->get_config('site', PLUGIN_WIKIPEDIAFINDER_SITE);
        $color              = $this->get_config('color', 'black');
        $target             = $this->get_config('target', '');
        $jswindow           = $this->get_config('jswindow', 'false');
        $jswindow_height    = $this->get_config('jswindow_height', '600');
        $jswindow_width     = $this->get_config('jswindow_width', '600');

        echo '<script type="text/javascript">
//<![CDATA[
            function getSelectedText() {
                if (!document.selection) Qr = window.getSelection(); // not IE
				else Qr = (document.selection && document.selection.type && document.selection.type == \'Text\' ? document.selection.createRange().text : ""); // is IE
                if (!Qr || Qr == "") {
                    Qr = prompt("' . PLUGIN_WIKIPEDIAFINDER_DESC . '", "");
                }

                word = Qr.toString();
                document.getElementById("wikipediafinder").value = word.replace(/\s+$/, "");
                document.getElementById("wikipediafinderform").submit();
            }
//]]>
        </script>';

        $plugin_dir = basename(dirname(__FILE__));

        echo "<div align='center'><form id='wikipediafinderform'
                    action='$site/wiki/Spezial:Search' method='get'
                    style='margin-bottom:0px;'";
        if($target!="" || $jswindow) {
            if($jswindow && $target != "s9y_wikipediafinder") {
                $target = "s9y_wikipediafinder";
                $this->set_config("target", "s9y_wikipediafinder");
            }
            echo "  target='$target'";
        }
        echo ">";
        echo "  <input type='hidden' name='search' value='' id='wikipediafinder' />
                <input onmousedown='";
        if($jswindow==TRUE) {
            echo "window.open(\"/plugins/".$plugin_dir."/wikipedia.png\", \"s9y_wikipediafinder\", \"height=".$jswindow_height.", width=".$jswindow_width.", resizable=yes, scrollbars=yes, toolbar=no, status=no, menubar=no, location=no\");";
        }
        echo "      getSelectedText(); return false;'
                    onclick='return false;'
                    type='image' style='height:30px; width:31px;'
                    src='".$serendipity['baseURL']."plugins/".$plugin_dir."/wikipedia_".$color.".gif' /><br />
                ".PLUGIN_WIKIPEDIAFINDER_DESC."
            </form></div>";
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>