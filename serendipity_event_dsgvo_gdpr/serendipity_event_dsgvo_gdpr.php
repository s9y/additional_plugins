<?php
if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_dsgvo_gdpr extends serendipity_event
{
    var $title = PLUGIN_EVENT_DSGVO_GDPR_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_DSGVO_GDPR_NAME);
        $propbag->add('description',   PLUGIN_EVENT_DSGVO_GDPR_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Serendipity Team');
        $propbag->add('version', '1.3.1');
        $propbag->add('requirements',  array(
            'serendipity' => '2.0',
            'smarty'      => '2.6.7',
            'php'         => '5.3.3'
        ));
        $propbag->add('groups', array('FRONTEND_FEATURES', 'BACKEND_FEATURES'));
        $propbag->add('event_hooks',
            array(
                'frontend_saveComment'  => true,
                'frontend_comment'      => true,
                'entries_header'        => true,
                'entry_display'         => true,
                'genpage'               => true,
                'frontend_footer'       => true,
                'frontend_configure'    => true,
                'css'                   => true,
                'backend_sidebar_admin' => true,
                'backend_sidebar_entries_event_display_dsgvo'  => true,
                'backend_deletecomment' => true

            )
        );

        $propbag->add('configuration', array('commentform_checkbox', 'commentform_text', 'gdpr_url', 'gdpr_info', 'gdpr_content', 'show_in_footer', 'show_in_footer_text', 'cookie_consent', 'cookie_consent_text', 'cookie_consent_path', 'anonymizeIp'));
        $propbag->add('config_groups', array(
            PLUGIN_EVENT_DSGVO_GDPR_MENU => array('gdpr_url', 'gdpr_info', 'gdpr_content'),
            PLUGIN_EVENT_DSGVO_GDPR_COOKIE_MENU => array('cookie_consent', 'cookie_consent_text', 'cookie_consent_path')
        ));
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'gdpr_url':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GDPR_URL);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_URL_DESC);
                $propbag->add('default',     '');
                break;

            case 'gdpr_content':
                $propbag->add('type',        'html');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GDPR_STATEMENT);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_STATEMENT_DESC);
                $propbag->add('default',     "");
                break;

            case 'commentform_text':
                $propbag->add('type',        'html');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT_DESC);
                $propbag->add('default',     PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT_DEFAULT);
                break;

            case 'commentform_checkbox':
                $propbag->add('type','boolean');
                $propbag->add('name', PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_CHECKBOX);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_CHECKBOX_DESC);
                $propbag->add('default', 'false');
                break;

            case 'anonymizeIp':
                $propbag->add('type','boolean');
                $propbag->add('name', PLUGIN_EVENT_DSGVO_GDPR_ANONYMIZE);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_ANONYMIZE_DESC);
                $propbag->add('default', 'true');
                break;

            case 'show_in_footer':
                $propbag->add('type','boolean');
                $propbag->add('name', PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_DESC);
                $propbag->add('default', 'true');
                break;

            case 'show_in_footer_text':
                $propbag->add('type',        'html');
                $propbag->add('name', PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT_DESC);
                $propbag->add('default',     PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT_DEFAULT);
                break;

            case 'gdpr_info':
                $propbag->add('type',        'content');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GDPR_INFO);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_INFO_DESC);
                $propbag->add('default',     $this->inspect_gdpr() . $this->buttonCopyToClipboard($this->inspect_gdpr()));
                break;

            case 'cookie_consent':
                $propbag->add('type','boolean');
                $propbag->add('name', PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_DESC);
                $propbag->add('default', 'true');
                break;

            case 'cookie_consent_text':
                $propbag->add('type',        'text');
                $propbag->add('name', PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_TEXT);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_TEXT_DESC);
                $propbag->add('default',     PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_TEXT_DEFAULT);
                break;

            case 'cookie_consent_path':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_PATH);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_PATH_DESC);
                $propbag->add('default',     $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_dsgvo_gdpr/');
                break;

        }

        return true;
    }

    function inspect_gdpr() {
        global $serendipity;

        $out = PLUGIN_EVENT_DSGVO_GDPR_SERENDIPITY_CORE;

        $classes = serendipity_plugin_api::enum_plugins();
        foreach ($classes as $class_data) {
            $plugin =& serendipity_plugin_api::load_plugin($class_data['name']);

            if (is_object($plugin)) {
                // Object is returned when a plugin could not be cached.
                $bag = new serendipity_property_bag;
                $plugin->introspect($bag);

                $legal = $bag->get('legal');
                if (is_array($legal)) {
                    $out .= '<h3>' . $bag->get('name') . '</h3>';

                    // "services" should list every service that a plugin connects to via a HTTP or other API interface,
                    // and describe what each service does, and which data it gets.
                    // Only services that are executed on visitor input must be listed; services that the blog server (instead
                    // of a client) connects to are nice to have, but are only required to be shown if it includes visitor (meta)data
                    if (is_array($legal['services']) && count($legal['services']) > 0) {
                        $out .= '<h4>Web services / Third Party</h4>';
                        $out .= '<ul>';
                        foreach($legal['services'] AS $servicename => $servicedata) {
                            $out .= '<li><a href="' . $servicedata['url'] . '">' . $servicename . '</a>: ' . $servicedata['desc'] . '</li>';
                        }
                        $out .= '</ul>';
                    }

                    // "frontend" lists descriptions what the plugin does on the frontendside and where it uses visitor data or metadata
                    if (is_array($legal['frontend']) && count($legal['frontend']) > 0) {
                        $out .= '<h4>Frontend</h4>';
                        $out .= '<ul>';
                        foreach($legal['frontend'] AS $servicename => $servicedata) {
                            $out .= '<li>' . $servicedata . '</li>';
                        }
                        $out .= '</ul>';
                    }

                    // "backend" lists descriptions what the plugin does on the backend and where it uses visitor data or metadata
                    if (is_array($legal['backend']) && count($legal['backend']) > 0) {
                        $out .= '<h4>Backend</h4>';
                        $out .= '<ul>';
                        foreach($legal['backend'] AS $servicename => $servicedata) {
                            $out .= '<li>' . $servicedata . '</li>';
                        }
                        $out .= '</ul>';
                    }

                    // "cookies" lists an array of which cookies might be set a a plugin and why. If a plugin makes use of
                    // session features, also mention that it relies on that session id.
                    if (is_array($legal['cookies']) && count($legal['cookies']) > 0) {
                        $out .= '<h4>Cookies</h4>';
                        $out .= '<ul>';
                        foreach($legal['cookies'] AS $servicename => $servicedata) {
                            $out .= '<li>' . $servicedata . '</li>';
                        }
                        $out .= '</ul>';
                    }

                    // "sessiondata" lists an array of which PHP session data values are (temporarily) saved
                    if (is_array($legal['sessiondata']) && count($legal['sessiondata']) > 0) {
                        $out .= '<h4>Session data</h4>';
                        $out .= '<ul>';
                        foreach($legal['sessiondata'] AS $servicename => $servicedata) {
                            $out .= '<li>' . $servicedata . '</li>';
                        }
                        $out .= '</ul>';
                    }

                    // This is a list of TRUE/FALSE boolean toggles
                    $out .= '<h4>Attributes</h4>';
                    $out .= '<ul>';
                    if ($legal['stores_user_input']) {
                        $out .= '<li>Stores user data (like names, text, preferences) to a database, file or other storage (mail)</li>';
                    } else {
                        $out .= '<li>Does not store user data (or not specified)</li>';
                    }

                    if ($legal['stores_ip']) {
                        $out .= '<li>Stores IP data (written to storage)</li>';
                    } else {
                        $out .= '<li>Does not store IP data (or not specified)</li>';
                    }

                    if ($legal['uses_ip']) {
                        $out .= '<li>Operates on IP data (read-access, also when passing through metadata)</li>';
                    } else {
                        $out .= '<li>Does not operate on IP data (or not specified)</li>';
                    }

                    if ($legal['transmits_user_input']) {
                        $out .= '<li>Transmits user input to services / third parties (not necessarily stored)</li>';
                    } else {
                        $out .= '<li>Does not transmit user input to services / third parties (or not specified)</li>';
                    }

                    $out .= '</ul>';
                }
            }

        }

        // Themes
        $stack = array();
        serendipity_plugin_api::hook_event('backend_templates_fetchlist', $stack);
        $themes = serendipity_fetchTemplates();
        foreach($themes AS $theme) {
            $stack[$theme] = serendipity_fetchTemplateInfo($theme);
        }
        ksort($stack);

        $theme_active = '';
        $theme_other = '';

        $static_info =  array(
                '2k11' => array(
                    'This theme can optionally use webfonts. If enabled, webfonts are loaded from Google/CDN servers, who will receive the IP address of the visitor and his metadata (browser, referrer, user agent, possible cookies)'
                ),
                'next' => array(
                    'This theme can optionally use webfonts. If enabled, webfonts are loaded from Google/CDN servers, who will receive the IP address of the visitor and his metadata (browser, referrer, user agent, possible cookies)'
                ),
                'clean-blog' => array(
                    'This theme can optionally use webfonts. If enabled, webfonts are loaded from Google/CDN servers, who will receive the IP address of the visitor and his metadata (browser, referrer, user agent, possible cookies)'
                ),
                'skeleton' => array(
                    'This theme can optionally use webfonts. If enabled, webfonts are loaded from Google/CDN servers, who will receive the IP address of the visitor and his metadata (browser, referrer, user agent, possible cookies)'
                ),
                'timeline' => array(
                    'This theme can optionally use webfonts. If enabled, webfonts are loaded from Google/CDN servers, who will receive the IP address of the visitor and his metadata (browser, referrer, user agent, possible cookies)'
                ),

        );

        foreach ($stack as $theme => $info) {
            if ( strtolower($info['engine']) == 'yes') {
                continue;
            }

            if (file_exists($serendipity["serendipityPath"] . $serendipity["templatePath"] . $theme . "/legal.txt") || isset($static_info[$theme])) {
                if ($theme == $serendipity['template']) {
                    $pointer = 'theme_active';

                    $$pointer .= '<h3>Active Theme "' . $theme .  '"</h3>' . "\n";
                } else {
                    $pointer = 'theme_other';

                    $$pointer .= '<h3>Available Theme "' . $theme .  '"</h3>' . "\n";
                }

                $$pointer .= '<ul>';
                if (isset($static_info[$theme])) {
                    foreach($static_info[$theme] AS $themeout) {
                        $$pointer .= '<li>' . $themeout . "</li>\n";
                    }
                }

                if (file_exists($serendipity["serendipityPath"] . $serendipity["templatePath"] . $theme . "/legal.txt")) {
                    $$pointer .= '<li>' . file_get_contents($serendipity["serendipityPath"] . $serendipity["templatePath"] . $theme . "/legal.txt") . '</li>';
                }
                $$pointer .= '</ul>';
            }
        }

        $out .= $theme_active . $theme_other;

        return $out;
    }

    function parseText($text) {
        global $serendipity;

        $url = $this->get_config('gdpr_url');
        if (empty($url)) {
            $url = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?serendipity[subpage]=dsgvo_gdpr_privacy';
        }
        $text = str_replace('%gdpr_url%', $url, $text);
        return $text;
    }

    function isActive() {
        global $serendipity;

        if ($serendipity['GET']['subpage'] == 'dsgvo_gdpr_privacy') {
            return true;
        }

        return false;
    }

    function parseParts($string) {
        $out = array();
        $parts = explode("\n", $string);
        foreach($parts AS $part) {
            $part = trim($part);
            if (empty($part)) continue;
            $out[] = "'" . serendipity_db_escape_string($part) . "'";
        }
        return $out;
    }

    // outputs html for a button that copies the given text to the browser clipboard
    function buttonCopyToClipboard($text) {
        $out = '<textarea style="display: none;white-space: pre;" id="copyWrapper">' . serendipity_specialchars($text) . '</textarea>';
        $out .= '<button type="button" onclick="copyTextFromWrapper()">' . PLUGIN_EVENT_DSGVO_GDPR_COPY_CLIPBOARD . '</button>';
        $out .= '<script>
            function copyTextFromWrapper() {
                var target = document.getElementById("copyWrapper");
                target.style.display = "block";
                target.focus();
                target.select();
                document.execCommand("Copy");
                target.style.display = "none";
            }</script>';
        return $out;
    }

    function showBackend() {
        global $serendipity;

        if ($serendipity['serendipityUserlevel'] < USERLEVEL_ADMIN) {
            return false;
        }

        $clist = array();
        if (isset($serendipity['POST']['delete']) || isset($serendipity['POST']['export'])) {

            $author_list = $this->parseParts($serendipity['POST']['filter']['author']);
            $email_list = $this->parseParts($serendipity['POST']['filter']['email']);

            if (count($author_list) == 0 && count($email_list) == 0) {
                echo '<p>' . PLUGIN_EVENT_DSGVO_GDPR_BACKEND_DELFAIL . '</p>';
            } else {
                $where = array();

                if (count($author_list) > 0) {
                    $where[] = 'author IN (' . implode(', ', $author_list) . ')';
                }

                if (count($email_list) > 0) {
                    $where[] = 'email IN (' . implode(', ', $email_list) . ')';
                }

                $clist = serendipity_db_query("SELECT *
                                                 FROM {$serendipity['dbPrefix']}comments
                                                WHERE " . implode(' OR ', $where), false, 'assoc');
            }

            if (!is_array($clist) || count($clist) == 0) {
                echo '<p>' . NO_COMMENTS . '</p>';
            } else {

                if (isset($serendipity['POST']['delete'])) {
                    foreach($clist AS $comment) {
                        echo '<p>' . sprintf(COMMENT_DELETED, $comment['id']) . '</p>';
                        serendipity_deleteComment($comment['id'], $comment['entry_id']);
                    }
                }

                if (isset($serendipity['POST']['export'])) {
                    header('Content-Type: application/csv; charset=' . LANG_CHARSET);
                    header('Content-Disposition: attachment; filename=blog-userData.csv');
                    header('Pragma: no-cache');
                    echo '#';
                    foreach($clist[0] AS $key => $val) {
                        echo '"' . $key . '";';
                    }
                    echo "\n";
                    foreach($clist AS $comment) {
                        foreach($comment AS $key => $val) {
                            echo '"' . $val . '";';
                        }
                        echo "\n";
                    }
                    exit;
                }
            }
        }

        echo '<form action="?" method="post">';
        echo serendipity_setFormToken();
        echo '<input type="hidden" name="serendipity[adminModule]" value="event_display" />';
        echo '<input type="hidden" name="serendipity[adminAction]" value="dsgvo" />';

        echo '<p>' . PLUGIN_EVENT_DSGVO_GDPR_BACKEND_INFO . '</p>';

        ?>
        <fieldset id="filter_dsgvo" class="filter_pane">
            <legend class="visuallyhidden"><?php echo PLUGIN_EVENT_DSGVO_GDPR_BACKEND; ?></legend>
            <div class="clearfix inputs">
                <div class="form_field">
                    <label for="filter_author"><?php echo AUTHOR; ?></label>
                    <textarea id="filter_author" name="serendipity[filter][author]"><?php echo serendipity_specialchars($serendipity['POST']['filter']['author']); ?></textarea>
                </div>

                <div class="form_field">
                    <label for="filter_email"><?php echo EMAIL; ?></label>
                    <textarea id="filter_email" name="serendipity[filter][email]"><?php echo serendipity_specialchars($serendipity['POST']['filter']['email']); ?></textarea>
                </div>

            </div>

            <div class="form_buttons">
                <input name="serendipity[export]" value="CSV" type="submit">
                <input name="serendipity[delete]" class="state_cancel comments_multidelete" data-delmsg="<?php echo COMMENTS_DELETE_CONFIRM; ?>" value="<?php echo DELETE; ?>" type="submit">
            </div>
        </fieldset>
        <?php

        echo '</form>';


    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_sidebar_admin':
                    ?>
                    <li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=dsgvo"><?php echo PLUGIN_EVENT_DSGVO_GDPR_BACKEND; ?></a></li>
                    <?php
                    break;

                case 'backend_sidebar_entries_event_display_dsgvo':
                    $this->showBackend();
                    break;

                case 'frontend_configure':
                    if (serendipity_db_bool($this->get_config('anonymizeIp'))) {
                        $_SERVER['REMOTE_ADDR'] = IpAnonymizer::anonymizeIp($_SERVER['REMOTE_ADDR']);
                    }
                    return true;
                    break;

                case 'frontend_saveComment':
                    if (serendipity_db_bool($this->get_config('commentform_checkbox'))) {
                        if ($addData['type'] == 'NORMAL') {
                            // Only act to comments. Trackbacks are an API so we cannot add checks there.
                            if (empty($serendipity['POST']['accept_privacy'])) {
                                $eventData = array('allow_comments' => false);
                                $serendipity['messagestack']['comments'][] = PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_ERROR;
                                return false;
                            }
                        }
                    }
                    return true;
                    break;

                case 'frontend_comment':
                    if (serendipity_db_bool($this->get_config('commentform_checkbox'))) {
?>
                        <div class="form_toolbar dsgvo_gdpr_comment">
                            <div class="form_box">
                                <input id="checkbox_dsgvo_gdpr" name="serendipity[accept_privacy]" value="1" type="checkbox" <?php echo ($serendipity['POST']['accept_privacy'] == 1 ? 'checked="checked"' : ''); ?>><label for="checkbox_dsgvo_gdpr"><?php echo $this->parseText($this->get_config('commentform_text')); ?></label>
                            </div>
                        </div>
<?php
                    }
                    return true;
                    break;

                case 'genpage':
                    if ($this->isActive()) {
                        $serendipity['is_staticpage'] = true;
                    }
                    return true;
                    break;

                case 'backend_deletecomment':
                    // Vanilla s9y does not delete all metadata of a comment that has threaded replies, it only sets the body to "Deleted".
                    // Here we take care that all metadata is cleared in that case.
                    serendipity_db_query("UPDATE {$serendipity['dbPrefix']}comments
                                             SET title = '', author = '', email = '', url = '', ip = '', referer = ''
                                           WHERE id = {$addData['cid']}");

                    return true;
                    break;

                case 'entry_display':
                    if ($this->isActive()) {
                        if (is_array($eventData)) {
                            $eventData['clean_page'] = true; // This is important to not display an entry list!
                        } else {
                            $eventData = array('clean_page' => true);
                        }
                    }

                    return true;
                    break;

                case 'entries_header':
                    if ($this->isActive()) {
                        serendipity_header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
                        serendipity_header('Status: 200 OK');

                        $statement = $this->get_config('gdpr_content');

                        if (empty($statement)) {
                            $statement = '<div class="dsgvo_gdpr_statement_error">' . PLUGIN_EVENT_DSGVO_GDPR_STATEMENT_ERROR . '</div>';
                        }

                        echo '<div class="dsgvo_gdpr_statement">' . $statement . '</div>';
                    }
                    return true;
                    break;

                case 'frontend_footer':
                    if (serendipity_db_bool($this->get_config('show_in_footer'))) {
                        echo '<div class="dsgvo_gdpr_footer">' . $this->parseText($this->get_config('show_in_footer_text')) . '</div>';
                    }

                    if (serendipity_db_bool($this->get_config('cookie_consent'))) {
?>
                        <link rel="stylesheet" type="text/css" href="<?php echo $this->get_config('cookie_consent_path'); ?>/cookieconsent.min.css" />
                        <script type="text/javascript" src="<?php echo $this->get_config('cookie_consent_path'); ?>cookieconsent.min.js"></script>
<?php
                        echo $this->parseText($this->get_config('cookie_consent_text'));
                    }
                    return true;
                    break;

                case 'css':
                    if (!strpos($eventData, '.dsgvo_gdpr')) {
                        // class exists in CSS, so a user has customized it and we don't need default
                        echo file_get_contents(dirname(__FILE__) . '/style.css');
                    }

                    return true;
                    break;

                default:
                    return false;
            }
        } else {
            return false;
        }
    }
}

/*
https://github.com/geertw/php-ip-anonymizer/blob/master/LICENSE

MIT License

Copyright (c) 2016 Geert Wirken

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
 */
class IpAnonymizer {
    /**
     * @var string IPv4 netmask used to anonymize IPv4 address.
     */
    public $ipv4NetMask = "255.255.255.0";
    /**
     * @var string IPv6 netmask used to anonymize IPv6 address.
     */
    public $ipv6NetMask = "ffff:ffff:ffff:0000:0000:0000:0000:0000";
    /**
     * Anonymize an IPv4 or IPv6 address.
     *
     * @param $address string IP address that must be anonymized
     * @return string The anonymized IP address. Returns an empty string when the IP address is invalid.
     */
    public static function anonymizeIp($address) {
        $anonymizer = new IpAnonymizer();
        return $anonymizer->anonymize($address);
    }
    /**
     * Anonymize an IPv4 or IPv6 address.
     *
     * @param $address string IP address that must be anonymized
     * @return string The anonymized IP address. Returns an empty string when the IP address is invalid.
     */
    public function anonymize($address) {
        $packedAddress = inet_pton($address);
        if (strlen($packedAddress) == 4) {
            return $this->anonymizeIPv4($address);
        } elseif (strlen($packedAddress) == 16) {
            return $this->anonymizeIPv6($address);
        } else {
            return "";
        }
    }
    /**
     * Anonymize an IPv4 address
     * @param $address string IPv4 address
     * @return string Anonymized address
     */
    public function anonymizeIPv4($address) {
        return inet_ntop(inet_pton($address) & inet_pton($this->ipv4NetMask));
    }
    /**
     * Anonymize an IPv6 address
     * @param $address string IPv6 address
     * @return string Anonymized address
     */
    public function anonymizeIPv6($address) {
        return inet_ntop(inet_pton($address) & inet_pton($this->ipv6NetMask));
    }
}

/* vim: set sts=4 ts=4 expandtab : */
