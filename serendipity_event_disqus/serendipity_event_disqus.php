<?php # $Id$

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
        $propbag->add('author',        'Garvin Hicking, Grischa Brockhaus');
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',       '0.2');
        $propbag->add('groups', array('FRONTEND_VIEWS'));
        $propbag->add('event_hooks', array(
            'frontend_display:html:per_entry' => true,
            'entries_footer' => true,
            'entry_display' => true
        ));
        
        $propbag->add('configuration', array('shortname', 'enable_since','template_hide_css','footer_comment_link'));
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;
        
        switch($name) {
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
            case 'template_hide_css':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_DISQUS_HIDE_COMMENTCSS);
                $propbag->add('description', PLUGIN_DISQUS_HIDE_COMMENTCSS_DESC);
                $propbag->add('default',     'serendipity_section_comments,serendipity_section_commentform');
                break;
            case 'footer_comment_link':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_DISQUS_FOOTERCOMMENTLINK);
                $propbag->add('description', PLUGIN_DISQUS_FOOTERCOMMENTLINK_DESC);
                $propbag->add('default',     'false');
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
    
    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;
        
        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
            
                case 'entries_footer':
                    $putFooterLink = $this->get_config('footer_comment_link', false);
                    // If we don't have a DISQUSfied footer, the JS is of no sense.
                    if (!$putFooterLink) return true; 
                    
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
                    $putFooterLink = $this->get_config('footer_comment_link', false);
                    $eventData['has_disqus'] = true;
                    
                    // This is problematic, because some templates (like 2k11) expect text only here!
                    if ($putFooterLink) {
                        $eventData['comments'] = '<a href="' . $eventData['link'] . '#disqus_thread" data-disqus-identifier="disq_id_' . $eventData['id'] . '">DISQUS</a>';
                    }
                    else {
                        $eventData['comments'] = COMMENTS;
                    }
                    return true;
                case 'entry_display':
    		        $singleArticle = $addData['extended'];
    		        if (!$singleArticle) return true;
                    
    		        $_ts = explode('-', $this->get_config('enable_since'));
                    $ts = mktime(0, 0, 0, $_ts[1], $_ts[2], $_ts[0]);
                    
    		        if (isset($eventData) && is_array($eventData)) {
                    	foreach($eventData as $event) {
                            if ($event['timestamp'] < $ts) {
                                continue;
                            }
    		        
                    	    $i = 0;
                            $disqus = $this->produce_disqus_output($event);
                            $event[$i]['display_dat'] .= $disqus;
                            $eventData[$i]['disqus'] .= $disqus;
                            $eventData[$i]['has_disqus'] = true;
                            $eventData[$i]['commentform'] = true;
                            $eventData[$i]['add_footer'] .= $disqus;
                            
                    	    $i++;
                    	}
                    }
                    
    		        
                    return true;
                    
              default:
                return false;
            }
        } else {
            return false;
        }
    }
    
    function produce_disqus_output(&$eventData) {
        $hidecss = $this->get_config('template_hide_css','serendipity_section_comments,serendipity_section_commentform');
        if (empty($hidecss)) return '';
        $csslist = explode(',', $hidecss);
        $hide = '';
        $count = count($csslist);
        $index = 0;
        foreach ($csslist as $css) {
            $hide .= '.' . $css;
            $index ++;
            if ($index<$count) $hide .= ',';
        }
        
        return '
<style type="text/css">'. $hide .
' {
  display: none;
}
</style>

<div class="disqus">
    <div id="disqus_thread"></div>
    <script type="text/javascript">
        var disqus_shortname = \'' . $this->get_config('shortname') . '\';
    
        // The following are highly recommended additional parameters. Remove the slashes in front to use.
        var disqus_identifier = \'disq_id_' . $eventData['id'] . '\';
        var disqus_url = \'' . $this->generate_article_url($eventData) . '\';
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
    }
    
    function generate_article_url( $entry ) {
        global $serendipity;
        
        $urlparts = @parse_url($serendipity['baseURL']);
        $server = $urlparts['scheme'] . '://' . $urlparts['host'];
        if (!empty($urlparts['port'])) $server = $server . ':' . $urlparts['port'];  
        
        $relurl = serendipity_archiveURL($entry['id'], $entry['title'], 'serendipityHTTPPath', true, array('timestamp' => $entry['timestamp']));

        return $server . $relurl;
    }
    
}
