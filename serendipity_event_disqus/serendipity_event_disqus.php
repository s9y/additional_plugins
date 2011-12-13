<?php # $Id: serendipity_event_disqus.php,v 1.1 2011/05/22 19:09:31 garvinhicking Exp $

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_disqus extends serendipity_event {
    var $title = PLUGIN_DISQUS_TITLE;
    
    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_DISQUS_TITLE);
        $propbag->add('description',   PLUGIN_DISQUS_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',       '0.1');
        $propbag->add('groups', array('FRONTEND_VIEWS'));
        $propbag->add('event_hooks', array(
            'frontend_display:html:per_entry' => true,
            'entries_footer' => true
        ));
        
        $propbag->add('configuration', array('shortname', 'enable_since'));
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;
        
        switch($name) {
        /*
            plugin_display_dat
            $TRACKBACKS
            $COMMENTS
            $COMMENTFORM
         */   
            case 'enable_since':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_DISQUS_ENABLE_SINCE);
                $propbag->add('description', PLUGIN_DISQUS_ENABLE_SINCE_DESC);
                $propbag->add('default',     date('Y-m-d'));
                break;
                
            case 'shortname':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_DISQUS_SHORTNAME);
                $propbag->add('description', PLUGIN_DISQUS_SHORTNAME_DESC);
                $propbag->add('default',     '');
                break;

        }

        return true;
    }

    function generate_content(&$title) {
        $title = PLUGIN_DISQUS_TITLE;
    }
    
    function example() {
        echo nl2br(PLUGIN_DISQUS_DESC2);
    }
    
    function event_hook($event, &$bag, &$eventData, &$addData) {
        global $serendipity;
        
        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
            
                case 'entries_footer':
?>
<script type="text/javascript">
    var disqus_shortname = '<?php echo $this->get_config('shortname'); ?>';

    (function () {
        var s = document.createElement('script'); s.async = true;
        s.type = 'text/javascript';
        s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
    }());
</script>
<?php
                    return true;

                case 'frontend_display:html:per_entry':
                    $_ts = explode('-', $this->get_config('enable_since'));
                    $ts = mktime(0, 0, 0, $_ts[1], $_ts[2], $_ts[0]);
                    
                    if ($eventData['timestamp'] < $ts) {
                        return true;
                    }

                    $eventData['comments'] = '<a href="' . $eventData['link'] . '#disqus_thread" data-disqus-identifier="disq_id_' . $eventData['id'] . '">Disqus</a>';
                    if (!$eventData['is_extended']) return true;

                    $disqus = '
<style type="text/css">
.serendipity_comments,
.serendipity_section_comments,
.serendipity_section_trackbacks,
.serendipity_section_commentform {
  display: none;
}
</style>

<div class="disqus">
    <div id="disqus_thread"></div>
    <script type="text/javascript">
        var disqus_shortname = \'' . $this->get_config('shortname') . '\';
    
        // The following are highly recommended additional parameters. Remove the slashes in front to use.
        var disqus_identifier = \'disq_id_' . $eventData['id'] . '\';
        var disqus_url = \'' . $eventData['rdf_ident'] . '\';
        var disqus_title = \'' . addslashes($eventData['title']) . '\';
    
        (function() {
            var dsq = document.createElement(\'script\'); dsq.type = \'text/javascript\'; dsq.async = true;
            dsq.src = \'http://\' + disqus_shortname + \'.disqus.com/embed.js\';
            (document.getElementsByTagName(\'head\')[0] || document.getElementsByTagName(\'body\')[0]).appendChild(dsq);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
</div>
';

                    $eventData['display_dat'] .= $disqus;
                    $eventData['disqus'] .= $disqus;
                    $eventData['commentform'] = true;
                    return true;
                
              default:
                return false;
            }
        } else {
            return false;
        }
    }
    
}
