<?php # 


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_youtube extends serendipity_event
{
    var $title = PLUGIN_EVENT_YOUTUBE_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_YOUTUBE_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_YOUTUBE_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',       '1.6.1');
        $propbag->add('event_hooks',    array(
            'backend_entry_toolbar_extended' => true,
            'backend_entry_toolbar_body' => true,
        ));

        $propbag->add('legal',    array(
            'services' => array(
                'youtube' => array(
                    'url'  => 'https://www.youtube.com',
                    'desc' => 'Youtube.'
                ),
            ),
            'frontend' => array(
                'When youtube videos are embedded, google gets the request metadata (IP address, user agent) of the visitor',
            ),
            'backend' => array(
            ),
            'cookies' => array(
                'Google can set tracking cookies for videos'
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => false,
            'transmits_user_input'  => true
        ));


        $propbag->add('groups', array('BACKEND_EDITOR'));
        $propbag->add('configuration', array('youtube_server', 'youtube_iframe', 'youtube_width', 'youtube_height', 'youtube_rel', 'youtube_border', 'youtube_color1', 'youtube_color2'));
    }

    function generate_content(&$title) {
        $title = PLUGIN_EVENT_YOUTUBE_TITLE;
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'youtube_server':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_YOUTUBE_SERVER);
                $propbag->add('default',     'http://www.youtube.com/v/');
                return true;
                break;

            case 'youtube_width':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_YOUTUBE_WIDTH);
                $propbag->add('default',     '425');
                return true;
                break;

            case 'youtube_height':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_YOUTUBE_HEIGHT);
                $propbag->add('default',     '344');
                return true;
                break;

            case 'youtube_rel':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_YOUTUBE_REL);
                $propbag->add('default',     'true');
                return true;
                break;

            case 'youtube_iframe':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_YOUTUBE_IFRAME);
                $propbag->add('default',     'true');
                return true;
                break;


            case 'youtube_border':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_YOUTUBE_BORDER);
                $propbag->add('default',     'false');
                return true;
                break;

            case 'youtube_color1':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_YOUTUBE_COLOR1);
                $propbag->add('default',     '0x3a3a3a');
                return true;
                break;

            case 'youtube_color2':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_YOUTUBE_COLOR2);
                $propbag->add('default',     '0x999999');
                return true;
                break;
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_entry_toolbar_extended':
                    if (!isset($txtarea)) {
                        $txtarea = 'serendipity[extended]';
                        $func    = 'extended';
                    }

                case 'backend_entry_toolbar_body':
                    if (!isset($txtarea)) {
                        if (isset($eventData['backend_entry_toolbar_body:textarea'])) {
                            // event caller has given us the name of the textarea converted
                            // into a wysiwg editor(for example, the staticpages plugin)
                            $txtarea = $eventData['backend_entry_toolbar_body:textarea'];
                        } else {
                            // default value
                            $txtarea = 'serendipity[body]';
                        }
                        if (isset($eventData['backend_entry_toolbar_body:nugget'])) {
                            $func = $eventData['backend_entry_toolbar_body:nugget'];
                        } else{
                            $func    = 'body';
                        }
                    }
                    // CKEDITOR needs this little switch
                    if (preg_match('@^nugget@i', $func)) {
                        $cke_txtarea = $func;
                    } else {
                        $cke_txtarea = $txtarea;
                    }

?>
<script type="text/javascript">
<!--
var youtube_server = '<?php echo $this->get_config('youtube_server'); ?>';
var youtube_width  = '<?php echo $this->get_config('youtube_width'); ?>';
var youtube_height = '<?php echo $this->get_config('youtube_height'); ?>';
var youtube_rel    = '<?php echo (serendipity_db_bool($this->get_config('youtube_rel')) ? '1' : '0'); ?>';
var youtube_border = '<?php echo (serendipity_db_bool($this->get_config('youtube_border')) ? '1' : '0'); ?>';
var youtube_color1 = '<?php echo $this->get_config('youtube_color1'); ?>';
var youtube_color2 = '<?php echo $this->get_config('youtube_color2'); ?>';
var youtube_iframe = '<?php echo (serendipity_db_bool($this->get_config('youtube_iframe')) ? '1' : '0'); ?>';

function use_text_<?php echo $func; ?>(img) {

    videoid = prompt('<?php echo PLUGIN_EVENT_YOUTUBE_ID; ?>', '');
    
    if (videoid == '') {
        return;
    }

    youtube_url = youtube_server + videoid + '&amp;fs=1&amp;rel=' + youtube_rel + '&amp;border=' + youtube_border + '&amp;color1=' + youtube_color1 + '&amp;color2=' + youtube_color2;
    if (youtube_border == 1) {
        youtube_width  += 20;
        youtube_height += 20;
    }

    img = "\n" + '<div class="youtube_player"><object width="' + youtube_width + '" height="' + youtube_height + '">'
        + '<param name="movie" value="' + youtube_url + '"></param>'
        + '<param name="allowFullScreen" value="true"></param>'
        + '<param name="allowscriptaccess" value="always">'
        + '</param>'
        + '<embed src="' + youtube_url + '" type="application/x-shockwave-flash" '
        + '  allowscriptaccess="always" allowfullscreen="true" width="' + youtube_width + '" height="' + youtube_height + '">'
        + '</embed></object></div>' 
        + '<noscript><a href="http://www.youtube.com/watch?v='+ videoid + '"></a></noscript>'
        + "\n";

    if (youtube_iframe) {
        img = "\n" + '<div class="youtube_player youtube_player_iframe"><iframe allow="encrypted-media" frameborder="0" height="' + youtube_height + '" src="https://www.youtube-nocookie.com/embed/' + videoid + '" width="' + youtube_width + '"><' + '/iframe></div>';
    }
    
    if(typeof(CKEDITOR) != 'undefined') {
        var oEditor = CKEDITOR.instances['<?php echo $cke_txtarea; ?>'];
        oEditor.insertHtml(img);
    } else if(typeof(FCKeditorAPI) != 'undefined') {
        var oEditor = FCKeditorAPI.GetInstance('<?php echo $txtarea; ?>') ;
        oEditor.InsertHtml(img);
    } else if(typeof(xinha_editors) != 'undefined') {
        if(typeof(xinha_editors['<?php echo $txtarea; ?>']) != 'undefined') {
        //alert(1);
            // this is good for the two default editors (body & extended)
            xinha_editors['<?php echo $txtarea; ?>'].insertHTML(img);
        } else if(typeof(xinha_editors['<?php echo $func; ?>']) != 'undefined') {
        //alert(2);
            // this should work in any other cases than previous one
            xinha_editors['<?php echo $func; ?>'].insertHTML(img);
        } else {
        //alert(3);
            // this is the last chance to retrieve the instance of the editor !
            // editor has not been registered by the name of it's textarea
            // so we must iterate over editors to find the good one
            for (var editorName in xinha_editors) {
                if('<?php echo $txtarea; ?>' == xinha_editors[editorName]._textArea.name) {
                    xinha_editors[editorName].insertHTML(img);
                    return;
                }
            }
            // not found ?!?
        }
    } else if(typeof(HTMLArea) != 'undefined') {
        //alert(4);
        if(typeof(editor<?php echo $func; ?>) != 'undefined') {
        //alert('4a<?php echo $func; ?>');
            editor<?php echo $func; ?>.insertHTML(img);
        } else if(typeof(htmlarea_editors) != 'undefined' && typeof(htmlarea_editors['<?php echo $func; ?>']) != 'undefined') {
        //alert('4b');
            htmlarea_editors['<?php echo $func; ?>'].insertHTML(img);
        }
    } else if(typeof(TinyMCE) != 'undefined') {
        //tinyMCE.execCommand('mceInsertContent', false, img);
        tinyMCE.execInstanceCommand('<?php echo $txtarea; ?>', 'mceInsertContent', false, img);
    } else  {
        //alert(5);
        // default case: no wysiwyg editor
        txtarea = document.getElementById('<?php echo $txtarea; ?>');
        if (txtarea.createTextRange && txtarea.caretPos) {
            caretPos = txtarea.caretPos;
            caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + ' ' + img + ' ' : caretPos.text + ' ' + img + ' ';
        } else {
            txtarea.value  += ' ' + img + ' ';
        }

        // alert(obj);
        txtarea.focus();
    }
}
//-->
</script>
<?php

                    #echo '<div id="serendipity_extbuttons_youtube" style="float: right; margin-top: 5px">';
                    echo '  <a class="serendipityPrettyButton serendipityExtButton" href="javascript:use_text_' . $func . '()" title="' . PLUGIN_EVENT_YOUTUBE_BUTTON . '">' . PLUGIN_EVENT_YOUTUBE_BUTTON . '</a>&nbsp;';
                    #echo '</div>';

                    return true;
                    break;

                default:
                    return false;
                    break;
            }
        } else {
            return false;
        }
    }
}

/* vim: set sts=4 ts=4 expandtab : */
