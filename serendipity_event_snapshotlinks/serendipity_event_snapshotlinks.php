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

@define('PLUGIN_SNAPSHOTLINKS_DUMMYDOMAIN', true);

class serendipity_event_snapshotlinks extends serendipity_plugin
{
    var $title = PLUGIN_SNAPSHOTLINKS_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $this->title = $this->get_config('title', $this->title);

        $propbag->add('name',          PLUGIN_SNAPSHOTLINKS_NAME);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Grischa Brockhaus');
        $propbag->add('version',       '1.02');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks', 
            array(
                'frontend_footer'   => true,
                'frontend_header'   => true, 
                'frontend_display'  => true,
            )
        );
        
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
        
        if (PLUGIN_SNAPSHOTLINKS_DUMMYDOMAIN) { // No URL and KEY needed in dummy domain mode!
            $propbag->add('description',   PLUGIN_SNAPSHOTLINKS_DESC_DUMMY);
            $propbag->add('configuration', array(
                                                 'theme',
                                                 'link_icon',
                                                 'preview_trigger',
                                                 'alllinks',
                                                 'locallinks',
                                                 'preview_size',
                                                 'previewshots',
                                                 'userpreview',
                                                 'searchbox',
                                                 'wikify',
                                                 'wikify_lang',
                                                 'wikify_type',
                                                 'wikify_remove_type',
                                                ));
        }
        else {
            $propbag->add('description',   PLUGIN_SNAPSHOTLINKS_DESC);
            $propbag->add('configuration', array(
                                                 'url',
                                                 'key',
                                                 'theme',
                                                 'link_icon',
                                                 'preview_trigger',
                                                 'alllinks',
                                                 'locallinks',
                                                 'preview_size',
                                                 'previewshots',
                                                 'userpreview',
                                                 'searchbox',
                                                 'customlogo',
                                                 'wikify',
                                                 'wikify_lang',
                                                 'wikify_type',
                                                 'wikify_remove_type',
                                                ));
        }
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;
        
        switch($name) {
            case 'url':
                $propbag->add('type',       'string');
                $propbag->add('name',       PLUGIN_SNAPSHOTLINKS_URL_NAME);
                $propbag->add('description',PLUGIN_SNAPSHOTLINKS_URL_DESC);
                $propbag->add('default',    $_SERVER['HTTP_HOST']);//$serendipity['baseURL']);
                break;
            case 'key':
                $propbag->add('type',       'string');
                $propbag->add('name',       PLUGIN_SNAPSHOTLINKS_KEY_NAME);
                $propbag->add('description',PLUGIN_SNAPSHOTLINKS_KEY_DESC);
                $propbag->add('default',    '');
                break;
            case 'theme':
                $types = array(
                    'asphalt'   => PLUGIN_SNAPSHOTLINKS_THEME_ASPHALT,
                    'green'     => PLUGIN_SNAPSHOTLINKS_THEME_GREEN,
                    'ice'       => PLUGIN_SNAPSHOTLINKS_THEME_ICE,
                    'linen'     => PLUGIN_SNAPSHOTLINKS_THEME_LINEN,
                    'orange'    => PLUGIN_SNAPSHOTLINKS_THEME_ORANGE,
                    'pink'      => PLUGIN_SNAPSHOTLINKS_THEME_PINK,
                    'purple'    => PLUGIN_SNAPSHOTLINKS_THEME_PURPLE,
                    'silver'    => PLUGIN_SNAPSHOTLINKS_THEME_SILVER,
                );
                $propbag->add('type',       'select');
                $propbag->add('name',       PLUGIN_SNAPSHOTLINKS_THEME_NAME);
                $propbag->add('description',PLUGIN_SNAPSHOTLINKS_THEME_DESC);
                $propbag->add('select_values', $types);
                $propbag->add('default',     'silver');
                break;
            case 'preview_trigger':
                $types = array(
                    '-'         => PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_LINK,
                    'icon'      => PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_ICON,
                    'both'      => PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_BOTH,
                );
                $propbag->add('type',       'select');
                $propbag->add('name',       PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_NAME);
                $propbag->add('description',PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_DESC);
                $propbag->add('select_values', $types);
                $propbag->add('default',     'both');
                break;
            case 'preview_size':
                $types = array(
                    'small'     => PLUGIN_SNAPSHOTLINKS_PREVIEWSIZE_SMALL,
                    'large'     => PLUGIN_SNAPSHOTLINKS_PREVIEWSIZE_LARGE,
                );
                $propbag->add('type',       'select');
                $propbag->add('name',       PLUGIN_SNAPSHOTLINKS_PREVIEWSIZE_NAME);
                $propbag->add('description',PLUGIN_SNAPSHOTLINKS_PREVIEWSIZE_DESC);
                $propbag->add('select_values', $types);
                $propbag->add('default',     'small');
                break;
            case 'link_icon':
                $propbag->add('type',       'boolean');
                $propbag->add('name',       PLUGIN_SNAPSHOTLINKS_LINKICON_NAME);
                $propbag->add('description',PLUGIN_SNAPSHOTLINKS_LINKICON_DESC);
                $propbag->add('default', false);
                break;
            case 'userpreview':
                $propbag->add('type',       'boolean');
                $propbag->add('name',       PLUGIN_SNAPSHOTLINKS_USERPREVIEW_NAME);
                $propbag->add('description',PLUGIN_SNAPSHOTLINKS_USERPREVIEW_DESC);
                $propbag->add('default', false);
                break;
            case 'customlogo':
                $propbag->add('type',       'boolean');
                $propbag->add('name',       PLUGIN_SNAPSHOTLINKS_CUSTOMLOGO_NAME);
                $propbag->add('description',PLUGIN_SNAPSHOTLINKS_CUSTOMLOGO_DESC);
                $propbag->add('default', false);
                break;

            // Advanced options
            case 'searchbox':
                $propbag->add('type',       'boolean');
                $propbag->add('name',       PLUGIN_SNAPSHOTLINKS_SEARCHBOX_NAME);
                $propbag->add('description',PLUGIN_SNAPSHOTLINKS_SEARCHBOX_DESC);
                $propbag->add('default', false);
                break;
            case 'alllinks':
                $propbag->add('type',       'boolean');
                $propbag->add('name',       PLUGIN_SNAPSHOTLINKS_ALLLINKS_NAME);
                $propbag->add('description',PLUGIN_SNAPSHOTLINKS_ALLLINKS_DESC);
                $propbag->add('default', true);
                break;
            case 'locallinks':
                $propbag->add('type',       'boolean');
                $propbag->add('name',       PLUGIN_SNAPSHOTLINKS_LOCALLINKS_NAME);
                $propbag->add('description',PLUGIN_SNAPSHOTLINKS_LOCALLINKS_DESC);
                $propbag->add('default', false);
                break;
            case 'previewshots':
                $propbag->add('type',       'boolean');
                $propbag->add('name',       PLUGIN_SNAPSHOTLINKS_PREVIEWSHOTS_NAME);
                $propbag->add('description',PLUGIN_SNAPSHOTLINKS_PREVIEWSHOTS_DESC);
                $propbag->add('default', false);
                break;
            case 'wikify':
                $propbag->add('type',       'boolean');
                $propbag->add('name',       PLUGIN_SNAPSHOTLINKS_WIKIFY_NAME);
                $propbag->add('description',PLUGIN_SNAPSHOTLINKS_WIKIFY_DESC);
                $propbag->add('default', false);
                break;
            case 'wikify_lang':
                $propbag->add('type',       'string');
                $propbag->add('name',       PLUGIN_SNAPSHOTLINKS_WIKIFY_LANG_NAME);
                $propbag->add('description',PLUGIN_SNAPSHOTLINKS_WIKIFY_LANG_DESC);
                $propbag->add('default',    'en');
                break;
            case 'wikify_type':
                $types = array(
                    'b'   => PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_BOLD,
                    'i'   => PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_ITALIC,
                    'u'   => PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_SUBLINED,
                );
                $propbag->add('type',       'select');
                $propbag->add('name',       PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_NAME);
                $propbag->add('description',PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_DESC);
                $propbag->add('select_values', $types);
                $propbag->add('default',     'u');
                break;
            case 'wikify_remove_type':
                $propbag->add('type',       'boolean');
                $propbag->add('name',       PLUGIN_SNAPSHOTLINKS_WIKIFY_REMOVE_TYPE_NAME);
                $propbag->add('description',PLUGIN_SNAPSHOTLINKS_WIKIFY_REMOVE_TYPE_DESC);
                $propbag->add('default', false);
                break;
            default:
                    return false;
        }
        return true;
    }

    function generate_content(&$title) {
        $title       = PLUGIN_SNAPSHOTLINKS_NAME;
    }

    function event_hook($event, &$bag, &$eventData, &$addData) {
        global $serendipity;
        static $state, $locked;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_header':
                    echo $this->generate_snapshotstyles();
                    break;
                case 'frontend_footer':
                    echo $this->generate_snapshotscript();
                    break;
                
                case 'frontend_display':
                    if (!serendipity_db_bool($this->get_config('wikify',false))) {
                        return true;
                    }
                    if (!isset($eventData['body']) && !isset($eventData['extended'])) {
                        return true;
                    }
                    
                    $wikifytype     = $this->get_config('wikify_type','u');
                    $searchpattern  = '@<' . $wikifytype . '>(.*?)</' . $wikifytype . '>@si';
                    
                    // If the RSS produces the output, stop wikifying, except for removing mark ups, if configured.
                    if (isset($addData) && $addData['from'] == 'functions_entries:printEntries_rss') {
                        if (serendipity_db_bool($this->get_config('wikify_remove_type',false))) {
                            if (isset($eventData['body'])) {
                                $eventData['body'] = preg_replace($searchpattern, '\1', $eventData['body']);
                            } 
                            if (isset($eventData['extended'])) {
                                $eventData['extended'] = preg_replace($searchpattern, '\1', $eventData['extended']);
                            } 
                            
                        }
                        return true;
                    }
                    
                    $wikifylang     = $this->get_config('wikify_lang','en');
                    $wikifyremove   = serendipity_db_bool($this->get_config('wikify_remove_type',false));
                    
                    $searchpattern  = '@<' . $wikifytype . '>(.*?)</' . $wikifytype . '>@si';
                    $replacepattern = '\1';
                    
                    if (!$wikifyremove){
                        $replacepattern = '<' . $wikifytype . '>' . $replacepattern . '</' . $wikifytype . '>';
                    }
                    $replacepattern = '<span class="Snap_Shot_Wikipedia"><span class="Snap_Shot_Attribute_Wikipedia_Edition">' . $wikifylang . '</span>' . $replacepattern . '</span>';
                    
                    if (isset($eventData['body'])) {
                        $eventData['body'] = preg_replace($searchpattern, $replacepattern, $eventData['body']);
                    } 
                    if (isset($eventData['extended'])) {
                        $eventData['extended'] = preg_replace($searchpattern, $replacepattern, $eventData['extended']);
                    } 
                    break;

            }
            return true;
            
        } else {
            return false;
        }
    }
    
    function generate_snapshotstyles() {
        global $serendipity;
        if (serendipity_db_bool($this->get_config('wikify',false))) {
            return "<style>.Snap_Shot_Attribute_Wikipedia_Edition {display:none}</style>\n";
        }
        else {
            return '';
        }
        
    }
    function generate_snapshotscript() {
        global $serendipity;
        
        // If no key is specified, return nothing
        if (!PLUGIN_SNAPSHOTLINKS_DUMMYDOMAIN &&  $this->get_config('key') == ''){  
            return "<!-- please get your key at http://www.snap.com/ -->";
        }
        
        $script = "\n<!-- Serendipity SnapShot event plugin BEGIN -->\n";
        $script .= '<script defer="defer" type="text/javascript" src="http://shots.snap.com/snap_shots.js?ap=';
        
        if (serendipity_db_bool($this->get_config('alllinks'))){
            $script .= '1';
        }
        else {
            $script .= '0';
        }
        
        $script .= '&amp;si=';
        if (serendipity_db_bool($this->get_config('locallinks'))){
            $script .= '1';
        }
        else {
            $script .= '0';
        }
        
        if (PLUGIN_SNAPSHOTLINKS_DUMMYDOMAIN){
            $script .= '&amp;key=02cc9c99fdc36ada7be2c4b4a8c51687'; // created for test.test.de and test@test.de
        }
        else {
            $script .= '&amp;key=' . $this->get_config('key');
        }
        
        $script .= '&amp;sb=';
        if (serendipity_db_bool($this->get_config('searchbox'))){
            $script .= '1';
        }
        else {
            $script .= '0';
        }
        
        $script .= '&amp;link_icon=';
        if (serendipity_db_bool($this->get_config('link_icon'))){
            $script .= 'on';
        }
        else {
            $script .= 'off';
        }
        
        $script .= '&amp;oi=';
        if (serendipity_db_bool($this->get_config('userpreview'))){
            $script .= '1';
        }
        else {
            $script .= '0';
        }
        
        $script .= '&amp;cl=';
        if (serendipity_db_bool($this->get_config('customlogo'))){
            $script .= '1';
        }
        else {
            $script .= '0';
        }
        
        $script .= '&amp;po=';
        if (serendipity_db_bool($this->get_config('previewshots'))){
            $script .= '1';
        }
        else {
            $script .= '0';
        }

        $script .= '&amp;th='. $this->get_config('theme');
        
        if ($this->get_config('preview_trigger')!='-'){
            $script .= '&amp;preview_trigger='. $this->get_config('preview_trigger');
        }
        if ($this->get_config('preview_size')=='large'){
            $script .= '&amp;size='. $this->get_config('preview_size');
        }

        // Don't know, what this is for:
        $script .= '&amp;df=0';
        
        // Hand over visitors language 
        $script .= '&amp;lang=' . $this->evaluateVisitorLanguage();

        if (PLUGIN_SNAPSHOTLINKS_DUMMYDOMAIN){
            $script .= '&amp;domain=test.test.de'; 
        }
        else {
            $script .= '&amp;domain='. $this->get_config('url'); 
        }
        
        $script .=  '"></script>';
        
        $script .= "\n<!-- Serendipity SnapShot event plugin END -->\n";
         
        return $script;
    }
    
    /**
     * Returns the first language supported by the visitor in xx-xx format. 
     *
     * @access private
     * @return first supported language of the visitor
     */
    function evaluateVisitorLanguage(){
        global $serendipity;
        
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
            //de,en;q=0.8,en-us;q=0.5,ca;q=0.3
            $lang_array = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
            $firstlang = $lang_array[0];
            $firstqlangarry = explode(';',$firstlang);
            $firstlang = $firstqlangarry[0];
        }
        else {
            $firstlang = $serendipity['lang'];
        }
        
        // This is some kind of hack: Assure xx-xx format:
        if (strlen($firstlang)<3){
            $firstlang = $firstlang . '-' .$firstlang; 
        } 
        
        return $firstlang;
    }

}

?>