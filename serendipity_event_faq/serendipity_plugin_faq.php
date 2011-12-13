<?php # $Id: serendipity_plugin_faq.php,v 1.3 2006/12/01 09:00:42 garvinhicking Exp $


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_plugin_faq extends serendipity_plugin
{

    function introspect(&$propbag)
    {
        $propbag->add('name',           FAQ_PLUGIN_NAME);
        $propbag->add('description',    FAQ_PLUGIN_NAME_DESC);
        $propbag->add('author',         'Falk Doering');
        $propbag->add('stackable',      true);
        $propbag->add('version',        '0.2');
        $propbag->add('copyright',      'LGPL');
        $propbag->add('configuration',  array(
            'title',
            'category'
        ));
        $propbag->add('requirements',  array(
            'serendipity'   => '1.0',
            'smarty'        => '2.6.7',
            'php'           => '4.1.0'
        ));
        $propbag->add('groups', array('FRONTEND_VIEWS'));
        $this->dependencies = array(
            'serendipity_event_faq' => 'keep'
        );

    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch ($name) {
            case 'title':
                $propbag->add('type',           'string');
                $propbag->add('name',           FAQ_PLUGIN_TITLE);
                $propbag->add('description',    FAQ_PLUGIN_TITLE_DESC);
                $propbag->add('default',        FAQS);
                break;

            case 'category':
                $propbag->add('type',           'multiselect');
                $propbag->add('name',           FAQ_PLUGIN_CATEGORY);
                $propbag->add('description',    FAQ_PLUGIN_CATEGORY_DESC);
                $propbag->add('select_values',  $this->get_categories());
                $propbag->add('default',        0);
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        global $serendipity;

        $title      = $this->get_config('title');
        $categoryids = explode('^',$this->get_config('category'));

        if (is_array($categoryids)) {
            $categories = $this->get_categories($categoryids);
            $q = 'SELECT value
                    FROM '.$serendipity['dbPrefix'].'config
                   WHERE name LIKE \'%faqurl%\'';
            $res = serendipity_db_query($q, true, 'assoc');
            $faqurl = $res['value'];

            $links = '';
            foreach ($categoryids as $id) {
                if (strlen($links)) {
                    $links .= "<br />\n";
                }
                if ($serendipity['rewrite'] == 'none') {
                    $links .= '<a href="'.$serendipity['serendipityHTTPPath'].$serendipity['indexFile'].'?/'.$serendipity['permalinkPluginPath'].'/'.$faqurl.'/'.$id.'">'.$categories[$id].'</a>';
                } else {
                    $links .= '<a href="'.$serendipity['serendipityHTTPPath'].$serendipity['permalinkPluginPath'].'/'.$faqurl.'/'.$id.'">'.$categories[$id].'</a>';
                }
            }
            echo $links;
        }

    }

    function &get_categories($ids = '')
    {
        global $serendipity;

        $q = 'SELECT id, category
                FROM '.$serendipity['dbPrefix'].'faq_categorys
               WHERE ';
        if (is_array($ids)) {
            $q .= serendipity_db_in_sql('id', $ids, '');
        } else {
            $q .= ' parent_id = 0';
        }
        $res = serendipity_db_query($q, false, 'assoc');
        if (is_array($res)) {
            foreach ($res as $value) {
                $erg[$value['id']] = $value['category'];
            }
        }
        return $erg;
    }

}
?>
