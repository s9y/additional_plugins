<?php


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_randomquotes extends serendipity_plugin {

    function introspect(&$propbag) {
        $propbag->add('name',           PLUGIN_RNDQUOTES_TITLE);
        $propbag->add('description',    PLUGIN_RNDQUOTES_BLAHBLAH);
        $propbag->add('configuration',  array('title', 'searchenginelink', 'formatstring', 'quotes', 'newwindow', 'numquotes'));
        $propbag->add('author',         'Florian Solcher');
        $propbag->add('stackable',      true);
        $propbag->add('version',        '1.05.1');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
    }

    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'title':
                $propbag->add('type', 'string');
                $propbag->add('name', TITLE);
                $propbag->add('description', TITLE_FOR_NUGGET);
                $propbag->add('default', PLUGIN_RNDQUOTES_TITLE);
                break;

            case 'searchenginelink':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_RNDQUOTES_SEARCHENGINELINK);
                $propbag->add('description',    PLUGIN_RNDQUOTES_SEARCHENGINELINK_BLAHBLAH);
                $propbag->add('default',        'http://www.google.com/search?hl=en&amp;q=%QUERY%');
                break;

            case 'newwindow':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_RNDQUOTES_NEWWINDOW);
                $propbag->add('description',    PLUGIN_RNDQUOTES_NEWWINDOW_BLAHBLAH);
                $propbag->add('default',        false);
                break;

            case 'formatstring':
                $propbag->add('type',           'text');
                $propbag->add('name',           PLUGIN_RNDQUOTES_FORMATSTRING);
                $propbag->add('description',    PLUGIN_RNDQUOTES_FORMATSTRING_BLAHBLAH);
                $propbag->add('default',        '<i>&quot;%QUOTE%&quot;</i><br /><div style="text-align:right">%AUTHOR%</div>');
                break;

            case 'numquotes':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_RNDQUOTES_NUMQUOTES);
                $propbag->add('description',    PLUGIN_RNDQUOTES_NUMQUOTES_BLAHBLAH);
                $propbag->add('default',        '1');
		break;

            case 'quotes':
                $propbag->add('type',           'text');
                $propbag->add('name',           PLUGIN_RNDQUOTES_QUOTES);
                $propbag->add('description',    PLUGIN_RNDQUOTES_QUOTES_BLAHBLAH);
                $propbag->add('default',        "Faith is, at one and the same time, absolutely necessary and altogether impossible.|Stanislaw Lem\n".
                                                "Cannibals prefer those who have no spines.|Stanislaw Lem\n".
                                                "I do not fear computers. I fear the lack of them.|Isaac Asimov|http://www.asimovonline.com/\n".
                                                "If knowledge can create problems, it is not through ignorance that we can solve them.|Isaac Asimov|http://www.asimovonline.com/\n".
                                                "The people I distrust most are those who want to improve our lives but have only one course of action.|Frank Herbert\n".
                                                "All animals are equal but some animals are more equal than others.|George Orwell\n".
                                                "Most human beings have an almost infinite capacity for taking things for granted.|Aldous Huxley");
                break;


            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {
        global $serendipity;

        $title          = $this->get_config('title');
        $url            = $this->get_config('searchenginelink');
        $formatstring   = $this->get_config('formatstring');
        $quotes         = $this->get_config('quotes');
        $newwindow      = $this->get_config('newwindow');
        $numquotes      = (int)$this->get_config('numquotes');
        $quotes         = explode("\n", $quotes);
        $i              = 0;
        $quotes_array   = array();
        if ($newwindow) {
             $onclick = ' onclick="window.open(this.href); return false;"';
        }
        foreach ($quotes as $quote) {
            if (trim($quote) != '') {
                $exp = explode('|', $quote);
                if (count($exp) > 0 && trim($exp[0]) != '') {
                    $quotes_array[$i]['quote']  = (function_exists('serendipity_specialchars') ? serendipity_specialchars(trim($exp[0])) : htmlspecialchars(trim($exp[0]), ENT_COMPAT, LANG_CHARSET));
                    $quotes_array[$i]['author'] = trim($exp[1]);
                    if(count($exp) > 2) {
                        $quotes_array[$i]['link']   = trim($exp[2]);
                    }
                    $i++;
                }
            }
        }

        if ($numquotes > sizeof($quotes_array) || $numquotes == 0) {
            $numquotes = sizeof($quotes_array);
        }
        if ($numquotes == 1) {
            // Single key will be returned; we need an array!
            $keys = array(array_rand($quotes_array, $numquotes));
        } else {
            $keys = array_rand($quotes_array, $numquotes);
        }

        foreach ($keys as $key) {
            $item = $quotes_array[$key];
            if (trim($item['link']) == '') {
                if (trim($url) != '') {
                    $item['author'] = '<a href="'.str_replace('%QUERY%', urlencode($item['author']), $url).'"'.$onclick.'>'. (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['author']) : htmlspecialchars($item['author'], ENT_COMPAT, LANG_CHARSET)).'</a>'."\n";
                }
            } elseif (trim($item['link']) != 'none') {
                $item['author'] = '<a href="'.$item['link'].'"'.$onclick.'>'. (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['author']) : htmlspecialchars($item['author'], ENT_COMPAT, LANG_CHARSET)) .'</a>'."\n";
            } else {
                $item['author'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($item['author']) : htmlspecialchars($item['author'], ENT_COMPAT, LANG_CHARSET));
            }
            echo str_replace(array('%QUOTE%', '%AUTHOR%'), array($item['quote'], $item['author']), $formatstring);
        }
    }
}
