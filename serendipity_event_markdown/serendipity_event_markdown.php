<?php # 

use \Michelf\Markdown, \Michelf\MarkdownExtra, \Michelf\SmartyPants, \Michelf\SmartyPantsTypographer;

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_markdown extends serendipity_event
{
    var $title = PLUGIN_EVENT_MARKDOWN_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_MARKDOWN_NAME);
        $propbag->add('description',   PLUGIN_EVENT_MARKDOWN_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Serendipity Team, Jan Lehnardt and Thomas Hochstein');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '5.3.0'
        ));
        $propbag->add('version',       '1.30.1');
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks',   array(
            'frontend_display' => true,
            'frontend_comment' => true,
            'css'              => true
        ));
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
                                                'desc'  => array(PLUGIN_EVENT_MARKDOWN_SMARTYPANTS, PLUGIN_EVENT_MARKDOWN_SMARTYPANTS_EXTENDED, PLUGIN_EVENT_MARKDOWN_SMARTYPANTS_NEVER)
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
        $mde  = serendipity_db_bool($this->get_config('MARKDOWN_EXTRA', false));

        switch($mdv) {
            case 2:
                if ($mde) {
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
                if ($mde) {
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
                            # HTML special chars like ">" in comments may have been replaced by entities ("&gt;")
                            # by serendipity_event_unstrip_tags; we have to - partially - undo that, as ">" is
                            # used for blockquotes in Markdown.
                            # The regexp will only match "&gt;" preceded by the start of the line or another "&gt;",
                            # both optionally followed by whitespace.-
                            if ($element == 'comment') {
                              $eventData[$element] = preg_replace('/(^|(?<=&gt;))\s*&gt;/m', '>', $eventData[$element]);
                            }
                            if ($mdv == 2) {
                                // use lib
                                if ($mde) {
                                    // use Markdown Extra
                                    $parser = new MarkdownExtra;
                                    // parser configuration for Markdown Extra
                                    $parser->fn_id_prefix = $eventData['id'] . '_';
                                } else {
                                    // use Markdown
                                    $parser = new Markdown;
                                }
                                // parser configuration for both Markdown and Markdown Extra
                                $parser->header_id_func = function ($text) {
                                    return preg_replace('/[^a-z0-9]+/', '-', strtolower($text));
                                };
                                // apply Markdown (or Markdown Extra)
                                $eventData[$element] = str_replace('javascript:', '', $parser->transform($eventData[$element]));
                                // apply Smartypants
                                if ($mdsp == 1) $eventData[$element] = SmartyPants::defaultTransform($eventData[$element]);
                                // apply Smartypants Typographer
                                if ($mdsp == 2) $eventData[$element] = SmartyPantsTypographer::defaultTransform($eventData[$element]);
                            } else {
                                // use and apply "classic" version
                                $eventData[$element] = str_replace('javascript:', '', Markdown($eventData[$element]));
                            }
                        }
                    }
                    $this->setPlaintextBody($eventData, $mde, $mdv, $mdsp);
                    return true;
                    break;

                case 'frontend_comment':
                    if (serendipity_db_bool($this->get_config('COMMENT', true))) {
                        echo '<div class="serendipity_commentDirection serendipity_comment_markdown">' . PLUGIN_EVENT_MARKDOWN_TRANSFORM . '</div>';
                    }
                    return true;
                    break;

                case 'css':
                    // if (strpos($eventData, '.footnotes')) {
                    //     return true;
                    // }

                    $this->addToCSS($eventData);

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
     * @param bool  $extra      Markdown Extra           default FALSE
     * @param int   $version    Markdown Classic or Lib  default 2
     * @param int   $pants      SmartyPants option       default 0
     */
    function setPlaintextBody(array $eventData, $extra=FALSE, $version=2, $pants=0)
    {
        if (isset($GLOBALS['entry'][0]['plaintext_body'])) {
            $plaintext_body = $GLOBALS['entry'][0]['plaintext_body'];
        } else {
            $plaintext_body = html_entity_decode($eventData['body'], ENT_COMPAT, LANG_CHARSET);
        }

        if ($mde) {
            $html =  ($version == 2) ? MarkdownExtra::defaultTransform($plaintext_body) : Markdown($plaintext_body);
        } else {
            $html =  ($version == 2) ? Markdown::defaultTransform($plaintext_body) : Markdown($plaintext_body);
        }

        if ($pants > 0) $html =  ($pants == 2) ? SmartyPantsTypographer::defaultTransform($html) : SmartyPants::defaultTransform($html);
        $GLOBALS['entry'][0]['plaintext_body'] = trim(strip_tags(str_replace('javascript:', '', $html)));
    }

    /* disabled, probably used in later versions
    function _markdown_markup($text) {
        return Markdown($text);
    }
    */

    function addToCSS(&$eventData) {
        $eventData .= '
/* Footnotes (generated by serendipity_event_markdown) */

footnote-ref:after {
  content: ")";
}

.footnotes hr {
  border-top: dashed #ccc;
  border-width: 1px;
}

/* mostly taken from http://www.456bereastreet.com/archive/201105/styling_ordered_list_numbers/ */
.footnotes ol {
  counter-reset: li;
  margin-top: .2em;
  margin-left: 1.5em;
  padding-left: 0;
}
.footnotes ol > li {
  list-style: none;
  position: relative;
  padding-left: .5em;
  font-size: 90%;
}
.footnotes ol > li:before {
  content: counter(li)")";
  counter-increment: li;
  position: absolute;
  left: -2em;
  top: -.1em;
  width: 2em;
  text-align: right;
  font-size: 80%;
  font-weight: bold;
}

/* --- end of Footnotes */
';
    }

}

/* vim: set sts=4 ts=4 expandtab :
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * indent-tabs-mode: nil
 * End:
*/
?>
