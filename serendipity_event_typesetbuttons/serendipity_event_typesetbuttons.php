<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

/**
 * Class serendipity_event_typesetbuttons
 */
class serendipity_event_typesetbuttons extends serendipity_event
{
    /**
     * @var string
     */
    public $title = PLUGIN_EVENT_TYPESETBUTTONS_TITLE;

    /**
     * @var string
     */
    protected $txtarea;

    /**
     * @var bool
     */
    protected $legacy = false;

    /**
     * @param serendipity_property_bag $propbag
     * @return true|void
     */
    public function introspect(&$propbag)
    {
        $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_TITLE);
        $propbag->add('description', PLUGIN_EVENT_TYPESETBUTTONS_DESC);
        $propbag->add('stackable', false);
        $propbag->add('author', 'Matthew Groeninger, Malte Diers, Matthias Gutjahr');
        $propbag->add('version', '0.22');
        $propbag->add('requirements', array(
            'serendipity' => '1.7',
            'smarty'      => '2.6.7',
            'php'         => '5.3.3'
        ));
        $propbag->add('configuration', array(
            'enable_center',
            'enable_strike',
            'enable_space',
            'enable_amp',
            'enable_emdash',
            'enable_endash',
            'enable_bullet',
            'enable_dquotes',
            'type_dquote_info',
            'type_dquotes',
            'enable_squotes',
            'type_squote_info',
            'type_squotes',
            'enable_apos',
            'real_apos',
            'enable_accent',
            'enable_gaccent',
            'use_xhtml11',
            'use_named_ents',
            'custom'
        ));
        $propbag->add('event_hooks', array(
            'backend_entry_toolbar_extended' => true,
            'backend_entry_toolbar_body' => true
        ));
        $propbag->add('groups', array('BACKEND_EDITOR'));
    }

    /**
     * @param string $name
     * @param serendipity_property_bag $propbag
     * @return bool
     */
    public function introspect_config_item($name, &$propbag)
    {
        switch ($name) {
            case 'custom':
                $propbag->add('type',        'text');
                $propbag->add('name',        PLUGIN_EVENT_TYPESETBUTTONS_CUSTOM);
                $propbag->add('description', PLUGIN_EVENT_TYPESETBUTTONS_CUSTOM_DESC);
                $propbag->add('default',     '');
                break;

            case 'use_xhtml11':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', INSTALL_XHTML11);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;

            case 'use_named_ents':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_USED_NAMED_ENTS);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;

            case 'enable_strike':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_STRIKE_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;

            case 'enable_center':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_CENTER_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;

            case 'enable_space':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_SPACE_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;

            case 'enable_amp':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_AMP_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;


            case 'enable_emdash':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_EMDASH_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;


            case 'enable_endash':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_ENDASH_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;


            case 'enable_bullet':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_BULLET_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;


            case 'enable_dquotes':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_DQUOTES_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;

            case 'type_dquotes':
                 if ($this->get_config('enable_dquotes') == 'yes') {
                     $propbag->add('type',          'radio');
                     $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_TYPE_DQUOTES_BUTTON);
                     $propbag->add('radio',
                         array( 'value' => array('type1','type2','type3','type4','type5','type6','type7','type8'),
                          'desc'  => array(PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES1,PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES2,PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES3,PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES4,PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES5,PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES6,PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES7,PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES8)
                         ));
                     $propbag->add('radio_per_row', '2');
                     $propbag->add('default', 'type1');
                 }
                break;

            case 'type_dquote_info':
                 if ($this->get_config('enable_dquotes') == 'yes') {
                    $propbag->add('type',        'content');
                    $propbag->add('default', PLUGIN_EVENT_TYPESETBUTTONS_TYPE_DQUOTES_NOTE);
                 }
                break;

            case 'enable_squotes':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_SQUOTES_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;

            case 'type_squotes':
                 if ($this->get_config('enable_squotes') == 'yes') {
                     $propbag->add('type',          'radio');
                     $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_TYPE_SQUOTES_BUTTON);
                     $propbag->add('radio',
                         array( 'value' => array('type1','type2','type3','type4','type5','type6','type7','type8'),
                          'desc'  => array(PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES1,PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES2,PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES3,PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES4,PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES5,PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES6,PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES7,PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES8)
                         ));
                     $propbag->add('radio_per_row', '2');
                     $propbag->add('default', 'type1');
                 }
                break;

            case 'type_squote_info':
                 if ($this->get_config('enable_squotes') == 'yes') {
                     $propbag->add('type',        'content');
                     $propbag->add('default', PLUGIN_EVENT_TYPESETBUTTONS_TYPE_SQUOTES_NOTE);
                 }
                break;


            case 'enable_apos':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_APOS_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;

            case 'real_apos':
                 if ($this->get_config('enable_apos') == 'yes') {
                     $propbag->add('type',          'radio');
                     $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_REAL_APOS);
                     $propbag->add('radio',
                         array( 'value' => array('yes','no'),
                          'desc'  => array(YES,NO)
                          ));
                     $propbag->add('radio_per_row', '2');
                     $propbag->add('default', 'yes');
                 }
                break;


            case 'enable_accent':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_ACCENT_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;

            case 'enable_gaccent':
                 $propbag->add('type',          'radio');
                 $propbag->add('name', PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_GACCENT_BUTTON);
                 $propbag->add('radio',
                     array( 'value' => array('yes','no'),
                     'desc'  => array(YES,NO)
                     ));
                 $propbag->add('radio_per_row', '2');
                 $propbag->add('default', 'yes');
                break;

            default:
               return false;
        }
        return true;
    }

    /**
     * @param string $event
     * @param serendipity_property_bag $bag
     * @param array $eventData
     * @param null $addData
     * @return bool|true
     */
    public function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;
        if (intval($serendipity['version'][0]) < 2) {
            $this->legacy = true;
        }
        $hooks = &$bag->get('event_hooks');
        $pluginConfigurationKeys = $bag->get('configuration');
        if (isset($hooks[$event])) {
            switch ($event) {
                case 'backend_entry_toolbar_extended':
                    return $this->processEvent('extended', $eventData, $pluginConfigurationKeys);
                    break;
                case 'backend_entry_toolbar_body':
                    return $this->processEvent('body', $eventData, $pluginConfigurationKeys);
                    break;
                default:
                    return false;
                    break;
            }
        }
        return false;
    }

    /**
     * @param string $type
     * @param array $eventData
     * @param array $pluginConfigurationKeys
     * @return bool
     */
    private function processEvent($type, $eventData, $pluginConfigurationKeys)
    {
        global $serendipity;
        if (!$serendipity['wysiwyg']) {
            if (isset($eventData['backend_entry_toolbar_' . $type . ':textarea'])) {
                $txtarea = $eventData['backend_entry_toolbar_' . $type . ':textarea'];
            } else {
                $txtarea = "serendipity[" . $type . "]";
            }
            $this->generate_button($txtarea, $pluginConfigurationKeys);
            return true;
        }
        return false;
    }
    /**
     * @param string $title
     * @return null|void
     */
    public function generate_content(&$title) {
            $title = PLUGIN_EVENT_TYPESETBUTTONS_TITLE;
    }

    /**
     * @param string $txtarea
     * @param array $pluginConfigurationKeys
     */
    private function generate_button($txtarea, array $pluginConfigurationKeys)  {
        global $serendipity; // required for optional logging of exceptions
        if (!isset($txtarea)) {
            $txtarea = 'body';
        }
        $this->txtarea = $txtarea;
        foreach ($pluginConfigurationKeys as $configKey) {
            $keyParts = explode('_', $configKey);
            if ($keyParts[0] !== 'enable' || $this->get_config($configKey) !== 'yes') {
                continue;
            }
            try {
                if ($keyParts[1] === 'dquotes') {
                    echo $html = $this->getButton($keyParts[1], $this->get_config('type_dquotes', 'type1'));
                } elseif ($keyParts[1] === 'squotes') {
                    echo $html = $this->getButton($keyParts[1], $this->get_config('type_squotes', 'type1'));
                } else {
                    echo $html = $this->getButton($keyParts[1]);
                }
            } catch (Exception $e) {
                // Uncomment the next three lines for debugging:
                // $fp = fopen($serendipity['serendipityPath'] . PATH_SMARTY_COMPILE . '/' . get_class($this) . '.log', 'a');
                // fwrite($fp, $e->getMessage() . PHP_EOL);
                // fclose($fp);
                continue;
            }
        }
        $custom = $this->get_config('custom');
        $custom = trim($custom);
        if (!empty($custom)) {
            echo '<br />';
            $parts = explode('|', $custom);
            foreach ($parts as $part) {
                $part = trim($part);
                if (empty($part)) {
                    continue;
                }
                echo $this->getCustomButton($txtarea, $part);
            }
        }
    }

    /**
     * @param string $name
     * @param string|null $type
     * @throws Exception
     * @return string
     */
    private function getButton($name, $type = null)
    {
        $name = ucfirst($name);
        $class = $name . 'Button';
        $classFile = 'buttons/' . $name . 'Button.php';
        if (!file_exists(__DIR__ . DIRECTORY_SEPARATOR . $classFile)) {
            throw new Exception($classFile . ' not found.');
        }
        require_once $classFile;
        /** @var ButtonInterface $button */
        $button = new $class($this->txtarea);
        $button->setIsLegacyMode($this->legacy);
        if ($this->get_config('use_xhtml11') !== 'yes') {
            $button->setIsXhtml11(false);
        }
        if ($this->get_config('use_named_ents') !== 'yes') {
            $button->setUseNamedEnts(false);
        }
        if ($type !== null && method_exists($button, 'setType')) {
            $button->setType($type);
        }
        if (method_exists($button, 'setUseRealApos')) {
            if ($this->get_config('real_apos', 'yes') === 'no') {
                $button->setUseRealApos(false);
            } else {
                $button->setUseRealApos(true);
            }
        }
        return $button->render();
    }

    /**
     * @param string $txtarea
     * @param string $part
     * @return string
     */
    private function getCustomButton($txtarea, $part)
    {
        $buttons = explode('@', $part);
        $b_name = htmlspecialchars($buttons[0]);
        $b_title = preg_replace('@[^a-z0-9]@i', '_', $buttons[0]);
        $b_open = str_replace(array('"', "'"), array('&quot;', "\\'"), $buttons[1]);
        $b_close = str_replace(array('"', "'"), array('&quot;', "\\'"), $buttons[2]);
        require_once 'buttons/CustomButton.php';
        $button = new CustomButton($txtarea);
        $button->setIsLegacyMode($this->legacy);
        $button->setName('ins_custom_' . $b_name);
        $button->setValue($b_title);
        $button->setOpen($b_open);
        $button->setClose($b_close);
        return $button->render();
    }
}

/* vim: set sts=4 ts=4 expandtab : */
