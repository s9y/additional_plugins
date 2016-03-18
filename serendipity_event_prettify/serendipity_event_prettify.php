<?php #

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_prettify extends serendipity_event
{
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_PRETTIFY_NAME);
        $propbag->add('description',   PLUGIN_PRETTIFY_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        PLUGIN_PRETTIFY_AUTH);
        $propbag->add('version',       '1.6.2');
        $propbag->add('requirements',  array('serendipity' => '1.0',
                                             'smarty'      => '2.6.7',
                                             'php'         => '4.1.0'
                                             ));
        $propbag->add('event_hooks',   array('frontend_header' => true,
                                             'frontend_footer' => true,
                                             'backend_entry_toolbar_body' => true,
                                             'backend_entry_toolbar_extended' => true
                                             ));
        $propbag->add('groups',        array('MARKUP'));
        $propbag->add('configuration', array('jspath','csspath','genericpre','genericcode','convertangle'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {

            case 'jspath':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_PRETTIFY_JSPATH);
                $propbag->add('description', PLUGIN_PRETTIFY_JSPATH_DESC);
                $propbag->add('default',     $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_prettify/prettify/prettify.js');
                break;

            case 'csspath':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_PRETTIFY_CSSPATH);
                $propbag->add('description', PLUGIN_PRETTIFY_CSSPATH_DESC);
                $propbag->add('default',     $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_prettify/prettify/prettify.css');
                break;

            case 'genericpre':
                $propbag->add('type',        'radio');
                $propbag->add('name',        PLUGIN_PRETTIFY_GENERICPRE);
                $propbag->add('description', PLUGIN_PRETTIFY_GENERICPRE_DESC);
                $propbag->add('radio',       array('value' => array('true', 'false'),
                                                   'desc'  => array(PLUGIN_PRETTIFY_GENERICPRE_TRUE, PLUGIN_PRETTIFY_GENERICPRE_FALSE)
                              ));
                $propbag->add('default',     'false');
                break;

            case 'genericcode':
                $propbag->add('type',        'radio');
                $propbag->add('name',        PLUGIN_PRETTIFY_GENERICCODE);
                $propbag->add('description', PLUGIN_PRETTIFY_GENERICCODE_DESC);
                $propbag->add('radio',       array('value' => array('true', 'false'),
                                                   'desc'  => array(PLUGIN_PRETTIFY_GENERICCODE_TRUE, PLUGIN_PRETTIFY_GENERICCODE_FALSE)
                              ));
                $propbag->add('default',     'false');
                break;

            case 'convertangle':
                $propbag->add('type',        'radio');
                $propbag->add('name',        PLUGIN_PRETTIFY_CONVERTANGLE);
                $propbag->add('description', PLUGIN_PRETTIFY_CONVERTANGLE_DESC);
                $propbag->add('radio',       array('value' => array('true', 'false'),
                                                   'desc'  => array(PLUGIN_PRETTIFY_CONVERTANGLE_TRUE, PLUGIN_PRETTIFY_CONVERTANGLE_FALSE)
                              ));
                $propbag->add('default',     'true');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        $title = PLUGIN_PRETTIFY_NAME;
    }

    function example() {
        $s = '<p>Use this plugin in one of two ways by setting the Generic/Language-Specific flags.</p>
              <p>Setting the flag to Prettify content generically will inject the class name "prettify" into all PRE or CODE tags. This, in turn, will cause all PRE or CODE content to be generically brushed. Fast and Easy.</p>
              <p>Setting the flag to Language-Specific will prevent the plugin from assigning and/or changing the class name of all content of the specified type. Therefore, content in PRE and/or CODE blocks must be assigned a class by the blog author.</p>
              <p>Supported classes include:</p>
              <ul>
              <li>prettyprint (must be included - used alone, this provides generic brushing)</li>
              <li>lang-bsh</li>
              <li>lang-c</li>
              <li>lang-cc</li>
              <li>lang-cpp</li>
              <li>lang-cs</li>
              <li>lang-csh</li>
              <li>lang-cyc</li>
              <li>lang-cv</li>
              <li>lang-htm</li>
              <li>lang-html</li>
              <li>lang-java</li>
              <li>lang-js</li>
              <li>lang-m</li>
              <li>lang-msml</li>
              <li>lang-perl</li>
              <li>lang-pl</li>
              <li>lang-pm</li>
              <li>lang-py</li>
              <li>lang-rb</li>
              <li>lang-sh</li>
              <li>lang-xhtml</li>
              <li>lang-xml</li>
              <li>lang-xsl</li>
              </ul>
              <p>eg: PRE CLASS="prettyprint" -or- PRE CLASS="prettyprint lang-html"</p>
              <p>Mike Samuel is the genius behind Prettify - the Prettify project is hosted here: <a href="https://github.com/google/code-prettify">https://github.com/google/code-prettify</a></p>
             ';
        return $s;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        $jspath = $this->get_config('jspath');
        $csspath = $this->get_config('csspath');
        $genericpre = $this->get_config('genericpre');
        $genericcode = $this->get_config('genericcode');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_header':
                    echo "<link href=\"".$csspath."\" type=\"text/css\" rel=\"stylesheet\" />\n";
                    echo "<script type=\"text/javascript\" src=\"".$jspath."\"></script>";
                break;
                case 'frontend_footer':
                    if($genericpre == true){
                    echo "
                    <script type=\"text/javascript\">
                    pres = document.getElementsByTagName('pre');
                    for(var i = 0; i < pres.length; i++)
                    {
                    pres[i].className = 'prettyprint';
                    }
                    </script>\n";
                    }
                    if($genericcode == true){
                    echo "
                    <script type=\"text/javascript\">
                    codes = document.getElementsByTagName('code');
                    for(var i = 0; i < codes.length; i++)
                    {
                    codes[i].className = 'prettyprint';
                    }
                    </script>\n";
                    }
                    echo "<script type=\"text/javascript\">prettyPrint();</script>\n";
                break;
                case 'backend_entry_toolbar_body':
                    if (!$serendipity['wysiwyg']) {
                        if (isset($eventData['backend_entry_toolbar_body:textarea'])) {
                            $txtarea = $eventData['backend_entry_toolbar_body:textarea'];
                        } else {
                            $txtarea = "serendipity[body]";
                        }
                        $this->generate_button($txtarea);
                        return true;
                    } else {
                        return false;
                    }
                break;
                case 'backend_entry_toolbar_extended':
                    if (!$serendipity['wysiwyg']) {
                        if (isset($eventData['backend_entry_toolbar_extended:textarea'])) {
                            $txtarea = $eventData['backend_entry_toolbar_extended:textarea'];
                        } else {
                            $txtarea = "serendipity[extended]";
                        }
                        $this->generate_button($txtarea);
                        return true;
                    } else {
                        return false;
                    }
                break;
                default:
                    return false;
            }
        }

    }
    function generate_button($txtarea) {
        global $serendipity;
            if (!isset($txtarea)) {
                $txtarea = 'body';
            }
            if ($this->get_config('convertangle') == true) {
?>
                <input type="button" class="serendipityPrettyButton input_button" name="convertangle" value="&lt;&gt;" onclick="html_entity_decode('<?php echo $txtarea ?>')" />
                <script type="text/javascript">
                    function html_entity_decode(textarea) {
                        var textarea = document.getElementById(textarea);
                        if (document.selection) {
                            textarea.focus();
                            var sel = document.selection.createRange();
                            sel.text = sel.text.replace(/</g,"&lt;").replace(/>/g,"&gt;");
                        } else {
                            var len = textarea.value.length;
                            var start = textarea.selectionStart;
                            var end = textarea.selectionEnd;
                            var sel = textarea.value.substring(start,end);
                            var replace = sel.replace(/</g,"&lt;").replace(/>/g,"&gt;");
                            textarea.value = textarea.value.substring(0,start) + replace + textarea.value.substring(end,len);
                        }
                    }
                </script>
<?php
            }
    }
}
