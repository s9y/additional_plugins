<?php // $Id$

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_babelfish extends serendipity_event
{
    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_BABELFISH_NAME);
        $propbag->add('description',   PLUGIN_BABELFISH_DESCRIPTION);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Sebastian Nohn');
        $propbag->add('version',       '1.7');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

        $propbag->add('configuration',
            array(
                'EngineURL',
                'TranslationPairs'
            )
        );

        $propbag->add('event_hooks',
            array(
                'frontend_display' => true,
                'css' => true,
                'frontend_display_cache' => true
            )
        );
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
        $propbag->add('scrambles_true_content', true);
    }

    function generate_content(&$title) {
        $title       = PLUGIN_BABELFISH_NAME;
    }

    function introspect_config_item($name, &$propbag)
    {
        switch ($name) {

                case 'EngineURL':
                        $propbag->add('type',        'string');
                        $propbag->add('name',        $name);
                        $propbag->add('description', PLUGIN_BABELFISH_URL_DESC);
                        $propbag->add('default', 'http://babelfish.altavista.com/babelfish/trurl_pagecontent?url=$bfURL&lp=$bfFromLang%5F$bfToLang');
                        break;

                case 'TranslationPairs':
                        $propbag->add('type',        'string');
                        $propbag->add('name',        $name);
                        $propbag->add('description', PLUGIN_BABELFISH_PAIRS_DESC);
                        $propbag->add('default', 'en->de,en->es,en->fr,en->it,en->pt,en->ja,de->en,de->fr,es->en,fr->en,fr->de,it->en,pt->en,ru->en,ja->en');
                        break;
        };
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
    global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'css':
                    if (stristr($eventData, '.serendipity_babelfish')) {
                        // class exists in CSS, so a user has customized it and we don't need default
                        return true;
                    }
?>

      .serendipity_babelfish {
         margin-left: auto;
         margin-right: 0px;
         text-align: right;
         font-size: 7pt;
         display: block;
         margin-top: 5px;
         margin-bottom: 0px;
      }

      .serendipity_babelfish a {
         font-size: 7pt;
         text-decoration: none;
      }

      .serendipity_babelfish a:hover {
         color: green;
      }
<?php
                    return true;
                    break;

                case 'frontend_display':
                    if ($bag->get('scrambles_true_content') && is_array($addData) && isset($addData['no_scramble'])) {
                        return true;
                    }

                case 'frontend_display_cache':
                    $pairs = explode(',', $this->get_config('TranslationPairs'));
                    $msg = '';

                    foreach($pairs as $pair) {
                        list($src_lang, $dst_lang) = explode('->', $pair);

                        if ($src_lang == $serendipity['lang']) {
                            if ($msg == '') {
                                $msg = '<div class="serendipity_babelfish">' . PLUGIN_BABELFISH_TRANSLATE;
                            }

                            $bfURL = urlencode(
                                   serendipity_archiveURL(
                                    $eventData['id'],
                                    $eventData['title'],
                                    'baseURL',
                                    true,
                                    array('timestamp' => $eventData['timestamp'])
                                )
                            );

                            $bfFromLang = $src_lang;
                            $bfToLang   = $dst_lang;

                            $line = $this->get_config('EngineURL');
                            eval("\$line = \"$line\";"); // dirrrrrrty
                            $msg .= ' <a href="' . $line . '">' . $dst_lang . '</a>';
                        }
                    }

                    $msg .= '</div>';
                    $eventData['body'] .= $msg;
                    break;

                default:
                   return false;
           }
        }
    }
}
?>
