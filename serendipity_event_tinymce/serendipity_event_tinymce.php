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

class serendipity_event_tinymce extends serendipity_event
{
    var $title = PLUGIN_EVENT_TINYMCE_NAME;

    function example() {
        if (!file_exists(dirname(__FILE__) . '/tinymce/jscripts/tiny_mce/tiny_mce_gzip.php'))
            return PLUGIN_EVENT_TINYMCE_INSTALL;
    }

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_TINYMCE_NAME);
        $propbag->add('description',   PLUGIN_EVENT_TINYMCE_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Grischa Brockhaus');
        $propbag->add('version',       '1.13');
        $propbag->add('requirements',  array(
            'serendipity' => '0.9',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

        $propbag->add('event_hooks',   array(
            'frontend_header'           => true,
            'backend_wysiwyg'           => true,
            'backend_wysiwyg_finish'    => true
        ));
        $propbag->add('configuration', array( 'article_only'
            , 'imanager'
            , 'tinymce_plugins'
            , 'theme_advanced_buttons1'
            , 'theme_advanced_buttons2'
            , 'theme_advanced_buttons3'
            , 'relativeurls'
            , 'verifyhtml'
            , 'cleanup'
            , 'geckospellcheck'
            , 'plugin_http_path'
            ));
        $propbag->add('groups', array('BACKEND_EDITOR'));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;
        
        switch($name) {
            case 'article_only':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_TINYMCE_ARTICLE_ONLY);
                $propbag->add('description', PLUGIN_EVENT_TINYMCE_ARTICLE_ONLY_DESC);
                $propbag->add('default', false);
                break;

            case 'imanager':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_TINYMCE_IMANAGER);
                $propbag->add('description', PLUGIN_EVENT_TINYMCE_IMANAGER_DESC);
                $propbag->add('default', false);
                break;

            case 'tinymce_plugins':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_TINYMCE_PLUGINS);
                $propbag->add('description', PLUGIN_EVENT_TINYMCE_PLUGINS_DESC);
                $propbag->add('default', 'table,media,paste,directionality,fullscreen,s9ymdb');
                break;

            case 'theme_advanced_buttons1':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_TINYMCE_BUTTONS1);
                $propbag->add('description', PLUGIN_EVENT_TINYMCE_BUTTONS1_DESC);
                $propbag->add('default', 'help,visualaid,code,|,bold,italic,underline,strikethrough,sub,sup,|,bullist,numlist,|,outdent,indent,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontselect,fontsizeselect,formatselect,removeformat');
                break;

            case 'theme_advanced_buttons2':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_TINYMCE_BUTTONS2);
                $propbag->add('description', PLUGIN_EVENT_TINYMCE_BUTTONS2_DESC);
                $propbag->add('default', 'cut,copy,paste,pastetext,pasteword,|,search,replace,|,undo,redo,|,link,unlink,anchor,image,s9ymdb,imanager,tablecontrols,|,cleanup');
                break;

            case 'theme_advanced_buttons3':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_TINYMCE_BUTTONS3);
                $propbag->add('description', PLUGIN_EVENT_TINYMCE_BUTTONS3_DESC);
                $propbag->add('default', 'hr,|,charmap,emotions,media,|,ltr,rtl,|,fullscreen');
                break;

            case 'geckospellcheck':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_TINYMCE_SPELLING);
                $propbag->add('description', PLUGIN_EVENT_TINYMCE_SPELLING_DESC);
                $propbag->add('default', false);
                break;

            case 'relativeurls':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_TINYMCE_RELURLS);
                $propbag->add('description', PLUGIN_EVENT_TINYMCE_RELURLS_DESC);
                $propbag->add('default', true);
                break;

            case 'verifyhtml':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_TINYMCE_VFYHTML);
                $propbag->add('description', PLUGIN_EVENT_TINYMCE_VFYHTML_DESC);
                $propbag->add('default', true);
                break;

            case 'cleanup':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_TINYMCE_CLEANUP);
                $propbag->add('description', PLUGIN_EVENT_TINYMCE_CLEANUP_DESC);
                $propbag->add('default', true);
                break;

            case 'plugin_http_path':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_TINYMCE_HTTPREL);
                $propbag->add('description', PLUGIN_EVENT_TINYMCE_HTTPREL_DESC);
                $propbag->add('default', 'plugins/serendipity_event_tinymce');
                break;

            default:
                    return false;
        }
        return true;
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_header':
                    echo '<script type="text/javascript">var serenditpityBaseUrl = "' . $serendipity['baseURL'] . '";</script>' . "\n";
                    break;
                case 'backend_wysiwyg':
                    $eventData['skip'] = true;
                    if (preg_match('@^nugget@i', $eventData['item'])) {
                        $this->event_hook('backend_wysiwyg_finish', $bag, $eventData);
                    }
                    break;

                case 'backend_wysiwyg_finish':
                    $path = $this->get_config('plugin_http_path','plugins/serendipity_event_tinymce') . '/tinymce/';
                    
                    $imanager           = serendipity_db_bool($this->get_config('imanager'));
                    $geckospellcheck    = serendipity_db_bool($this->get_config('geckospellcheck'));
                    $relativeurls       = serendipity_db_bool($this->get_config('relativeurls'));
                    $verifyhtml         = serendipity_db_bool($this->get_config('verifyhtml'));
                    $cleanup            = serendipity_db_bool($this->get_config('cleanup'));
                    $article_only       = serendipity_db_bool($this->get_config('article_only'));
                    $tinymce_plugins = $this->get_config('tinymce_plugins');
                    
                    $theme_advanced_buttons1 = $this->get_config('theme_advanced_buttons1');
                    $theme_advanced_buttons2 = $this->get_config('theme_advanced_buttons2');
                    $theme_advanced_buttons3 = $this->get_config('theme_advanced_buttons3');
?>
<script type="text/javascript">var serenditpityBaseUrl = "<?php echo   $serendipity['baseURL']; ?>"</script>
<script language="javascript" type="text/javascript" src="<?php echo $path; ?>jscripts/tiny_mce/tiny_mce_gzip.php?js=1"></script>
<script type="text/javascript">
if (!window.tinymce_inited) {
    var Emulator = {
     surroundHTML: function(block, string) {
       tinyMCE.execCommand('mceInsertRawHTML', true, block);
     }
    };
    editorref = Emulator;
};
</script>
<script type="text/javascript">
if (!window.tinymce_inited) {
    tinyMCE_GZ.init({
        plugins 
            : "<?php echo $imanager ? 'imanager,' : ''; echo $tinymce_plugins ; ?>",
        theme
            : "advanced",
        languages
            : "<?php echo substr(WYSIWYG_LANG, 0, 2); ?>",
        disk_cache
            : true,
        debug
            : false
    });
};
</script>
<!-- Needs to be seperate script tags! -->
<script language="javascript" type="text/javascript">
if (!window.tinymce_inited) {
	tinyMCE.init({
        mode
            : "exact",
        elements 
            : "serendipity[body],serendipity[extended]<?php echo $article_only ? '' : ',serendipity[plugin][content],serendipity[plugin][pre_content]'; ?>",
        language
            : "<?php echo substr(WYSIWYG_LANG, 0, 2); ?>",
        theme
            : "advanced",
        plugins
            : "<?php echo $imanager ? 'imanager,' : ''; echo $tinymce_plugins!=''? $tinymce_plugins : ''; ?>",
        theme_advanced_buttons1
            : "<?php echo $theme_advanced_buttons1 ?>",
        theme_advanced_buttons2
            : "<?php echo $theme_advanced_buttons2 ?>",
        theme_advanced_buttons3
            : "<?php echo $theme_advanced_buttons3 ?>",
        theme_advanced_toolbar_location
            : "top",
        theme_advanced_toolbar_align
            : "left",
        theme_advanced_path_location
            : "bottom",
        gecko_spellcheck
            : <?php echo $geckospellcheck?"true":"false"; ?>,
        verify_html 
            : <?php echo $verifyhtml?"true":"false"; ?>,
        cleanup 
            : <?php echo $cleanup?"true":"false"; ?>,
        invalid_elements 
            : "",
        extended_valid_elements 
            : "object[classid|codebase|width|height|align],param[name|value],embed[quality|type|pluginspage|width|height|src|align|wmode]",
        forced_root_block : "p",
        relative_urls
            : <?php echo $relativeurls?"true":"false"; ?>,
        plugin_insertdate_dateFormat
            : "%Y-%m-%d",
        plugin_insertdate_timeFormat
            : "%H:%M:%S",
        extended_valid_elements
            : "a[name|href|target|title|onclick|style],img[style|class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],div[class|aign|style]",
        external_link_list_url
            : "example_link_list.js",
        external_image_list_url
            : "example_image_list.js",
        flash_external_list_url
            : "example_flash_list.js"
	});
};
window.tinymce_inited = 1;
</script>
<?php
                    break;

              default:
                return false;
            }

        } else {
            return false;
        }
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>
