<?php # 

use \Michelf\Markdown, \Michelf\MarkdownExtra, \Michelf\SmartyPants, \Michelf\SmartyPantsTypographer;

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_markdown extends serendipity_event
{
    var $title = PLUGIN_EVENT_MARKDOWN_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_MARKDOWN_NAME);
        $propbag->add('description',   PLUGIN_EVENT_MARKDOWN_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Serendipity Team and Jan Lehnardt');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '5.3.0'
        ));
        $propbag->add('version',       '1.22');
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks',   array('frontend_display' => true, 'frontend_comment' => true));
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

        $conf_array = array();
        foreach($this->markup_elements as $element) {
            $conf_array[] = $element['name'];
        }
        $conf_array[] = 'MARKDOWN_EXTRA';
        $conf_array[] = 'MARKDOWN_VERSION';
        $conf_array[] = 'MARKDOWN_SMARTYPANTS';

        $propbag->add('configuration', $conf_array);
    }

    function install() {
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    function uninstall(&$propbag) {
        serendipity_plugin_api::hook_event('backend_cache_purge', $this->title);
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    function generate_content(&$title) {
        $title = $this->title;
    }


    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'ENTRY_BODY':
            case 'EXTENDED_BODY':
            case 'COMMENT':
            case 'HTML_NUGGET':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        constant($name));
                $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
                $propbag->add('default', 'true');
                return true;
                break;

            case 'MARKDOWN_EXTRA':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_MARKDOWN_EXTRA_NAME);
                $propbag->add('description', PLUGIN_EVENT_MARKDOWN_EXTRA_DESC);
                $propbag->add('default',     false);
                return true;
                break;

            case 'MARKDOWN_SMARTYPANTS':
                $propbag->add('type',        'radio');
                $propbag->add('name',        PLUGIN_EVENT_MARKDOWN_SMARTYPANTS_NAME);
                $propbag->add('description', PLUGIN_EVENT_MARKDOWN_SMARTYPANTS_DESC);
                $propbag->add('radio',       array(
                                                'value' => array(1, 2, 0),
                                                'desc'  => array(YES, PLUGIN_EVENT_MARKDOWN_SMARTYPANTS_EXTENDED, PLUGIN_EVENT_MARKDOWN_SMARTYPANTS_NEVER)
                                             ));
                $propbag->add('default',     0);
                return true;
                break;

            case 'MARKDOWN_VERSION':
                $propbag->add('type',        'radio');
                $propbag->add('name',        PLUGIN_EVENT_MARKDOWN_VERSION);
                $propbag->add('description', PLUGIN_EVENT_MARKDOWN_VERSION_BLABLAH);
                $propbag->add('radio',       array(
                                                'value' => array(1, 2),
                                                'desc'  => array('classic', 'lib'),
                                             ));
                $propbag->add('default',     2);
                return true;
                break;
        }
    }


    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $mdsp = $this->get_config('MARKDOWN_SMARTYPANTS');
        $mdv  = $this->get_config('MARKDOWN_VERSION');

        switch($mdv) {
            case 2:
                if ($this->get_config('MARKDOWN_EXTRA', false)) {
                    require_once dirname(__FILE__) . '/lib/Michelf/MarkdownExtra.inc.php';
                } else {
                    require_once dirname(__FILE__) . '/lib/Michelf/Markdown.inc.php';
                }
                if ($mdsp > 0) {
                    require_once dirname(__FILE__) . '/lib/Michelf/SmartyPants.php';
                }
                if ($mdsp == 2) {
                    require_once dirname(__FILE__) . '/lib/Michelf/SmartyPantsTypographer.php';
                }
                break;

            case 1:
                if (serendipity_db_bool($this->get_config('MARKDOWN_EXTRA', false))) {
                    include_once  dirname(__FILE__) . '/markdown_extra.php';
                } else {
                    include_once  dirname(__FILE__) . '/markdown.php';
                }
                break;
        }

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_display':

                    foreach ($this->markup_elements as $temp) {
                        if (serendipity_db_bool($this->get_config($temp['name'], true)) && !empty($eventData[$temp['element']]) &&
                            !$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                            !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = $temp['element'];
                            if ($mdv == 2) {
                                $eventData[$element] = str_replace('javascript:', '', Markdown::defaultTransform($eventData[$element]));
                                if ($mdsp == 1) $eventData[$element] = SmartyPants::defaultTransform($eventData[$element]);
                                if ($mdsp == 2) $eventData[$element] = SmartyPantsTypographer::defaultTransform($eventData[$element]);
                            } else {
                                $eventData[$element] = str_replace('javascript:', '', Markdown($eventData[$element]));
                            }
                        }
                    }
                    $this->setPlaintextBody($eventData, $mdv, $mdsp);
                    return true;
                    break;

                case 'frontend_comment':
                    if (serendipity_db_bool($this->get_config('COMMENT', true))) {
                        echo '<div class="serendipity_commentDirection serendipity_comment_markdown">' . PLUGIN_EVENT_MARKDOWN_TRANSFORM . '</div>';
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

    /**
     * Sets a GLOBAL plaintext body by first transforming the body to HTML, then stripping HTML tags from the body
     * @see http://board.s9y.org/viewtopic.php?f=11&t=18351 Discussion of this feature in the S9y forum.
     *
     * @param array $eventData
     * @param int   $version    Markdown Classic or Lib  default 2
     * @param int   $pants      SmartyPants option       default 0
     */
    function setPlaintextBody(array $eventData, $version=2, $pants=0)
    {
        if (isset($GLOBALS['entry'][0]['plaintext_body'])) {
            $html =  ($version == 2) ? Markdown::defaultTransform($GLOBALS['entry'][0]['plaintext_body']) : Markdown($GLOBALS['entry'][0]['plaintext_body']);
        } else {
            $html =  ($version == 2) ? Markdown::defaultTransform(html_entity_decode($eventData['body'], ENT_COMPAT, LANG_CHARSET)) : Markdown(html_entity_decode($eventData['body'], ENT_COMPAT, LANG_CHARSET));
        }
        if ($pants > 0) $html =  ($pants == 2) ? SmartyPantsTypographer::defaultTransform($html) : SmartyPants::defaultTransform($html);
        $GLOBALS['entry'][0]['plaintext_body'] = trim(strip_tags(str_replace('javascript:', '', $html)));
    }

    /* disabled, probably used in later versions
    function _markdown_markup($text) {
        return Markdown($text);
    }
    */
}

/* vim: set sts=4 ts=4 expandtab :
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * indent-tabs-mode: nil
 * End:
*/
?>
