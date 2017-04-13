<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing 
$probelang =  dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';

if (file_exists($probelang)) { 
    include $probelang; 
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_sort extends serendipity_event
{
    var $title = PLUGIN_EVENT_SORT_TITLE;

   // everything else is sorted at the end 
   function utf8cmp($a, $b) { 
        static $order = null;
        static $char2order = null;
        
        if ($order === null) {
            // Kyrillic. More languages to come?
            $order = '0123456789AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZzАаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя';
        }

        if (!function_exists('mb_strlen')) return 0;

        if (function_exists('mb_internal_encoding')) {
            mb_internal_encoding("UTF-8"); 
        }
       
        if ($a == $b) { 
            return 0; 
        }

        // lazy init mapping 
        if ($char2order === null) { 
            $len = mb_strlen($order); 
            for ($_order=0; $_order < $len; ++$_order) {
                $char2order[mb_substr($order, $_order, 1)] = $_order; 
            } 
        } 

        $len_a = mb_strlen($a); 
        $len_b = mb_strlen($b); 
        $max=min($len_a, $len_b); 
        for ($i=0; $i < $max; ++$i) { 
            $char_a= mb_substr($a, $i, 1); 
            $char_b= mb_substr($b, $i, 1); 
        
            if ($char_a == $char_b) continue; 
            $order_a = (isset($char2order[$char_a])) ? $char2order[$char_a] : 9999; 
            $order_b = (isset($char2order[$char_b])) ? $char2order[$char_b] : 9999; 
        
            return ($order_a < $order_b) ? -1 : 1; 
        } 

        return ($len_a < $len_b) ? -1 : 1; 
    } 

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_SORT_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_SORT_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'LazyBadger, Garvin Hicking');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',       '0.1');
        $propbag->add('event_hooks',    array(
            'sort'                             => true,
        ));
        $propbag->add('groups', array('FRONTEND_FEATURES'));
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {
                case 'sort':
                    uksort($eventData, array($this, 'utf8cmp'));
                    return true;

                default:
                    return false;
                    break;
            }
        } else {
            return false;
        }
    }
}
