<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (!defined('PLUGIN_EVENT_SPAMBLOCK_BEE_TITLE')) {
    if (file_exists($probelang)) {
        include $probelang;
    } else {
        include dirname(__FILE__) . '/lang_en.inc.php';
    }
}
if (!defined('PLUGIN_SPAMBLOCK_BEE_VERSION')) {
    include dirname(__FILE__) . '/version.inc.php';
}

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_DEBUG', FALSE);

@define('PLUGIN_EVENT_SPAMBLOCK_SWTCH_OFF', 'OFF');
@define('PLUGIN_EVENT_SPAMBLOCK_SWTCH_MODERATE', 'MODERATE');
@define('PLUGIN_EVENT_SPAMBLOCK_SWTCH_REJECT', 'REJECT');


/**
 * Serendipity plug-in for providing spam protection via a
 * Honey Pot field and a hidden Captcha.
 *
 * @author Grischa Brockhaus
 * @author Janek Bevendorff
 */
class serendipity_event_spamblock_bee extends serendipity_event
{
    /**
     * Plug-in title
     * @var string
     */
    var $title = PLUGIN_EVENT_SPAMBLOCK_BEE_TITLE;

    /**
     * Whether to use a Honey Pot
     * @var boolean
     */
    var $useHoneyPot = true;

    /**
     * Whether the Captcha is enabled and what to do when validation failed
     * @var string
     */
    var $hiddenCaptchaHandle = null;

    /**
     * Method for retrieving the correct answer of the hidden Captcha.
     * Either 'default', 'json' or 'smarty'.
     * @var string
     */
    var $answerRetrievalMethod = null;

    /**
     * Correct answer for the Captcha. If RegExp matching is on, it'll
     * also contain an index 'pattern'
     * @var array
     */
    var $captchaAnswer = array('answer' => null);

    /**
     * Type of question asked in the Captcha. This is either 'math' or 'custom'
     * @var string
     */
    var $captchaQuestionType = null;

    /**
     * Whether to use RegExp matching for the hidden Captcha
     * @var boolean
     */
    var $useRegularExpressions = false;

    /**
     * Constructor. Initialize class variables from configuration
     * @return void
     */
    function __construct($instance) {
        $this->instance = $instance;

        $this->answerRetrievalMethod = $this->get_config('answer_retrieval_method', 'default');
        $this->captchaQuestionType   = $this->get_config('question_type', 'math');
        $this->useHoneyPot           = $this->get_config('do_honeypot', true);
        $this->hiddenCaptchaHandle   = $this->get_config('do_hiddencaptcha', PLUGIN_EVENT_SPAMBLOCK_SWTCH_MODERATE);
        $this->useRegularExpressions = $this->get_config('use_regexp', false);
    }

    /**
     * Declare Serendipity backend properties.
     *
     * @param  serendipity_property_bag $propbag
     */
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_SPAMBLOCK_BEE_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_SPAMBLOCK_BEE_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Grischa Brockhaus, Janek Bevendorff');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '5.2.0'
        ));

        $propbag->add('version',       PLUGIN_SPAMBLOCK_BEE_VERSION); // setup via version.inc.php

        $propbag->add('event_hooks',    array(
            'frontend_comment'     => true,
            'frontend_saveComment' => true,
            'frontend_footer'      => true,
            'css'                  => true,
            'external_plugin'      => true
        ));
        $propbag->add('groups', array('ANTISPAM'));

        $propbag->add('legal',    array(
            'services' => array(
            ),
            'frontend' => array(
                'Anti-Spam measurements by this plugin can transfer user data and metadata (??? plugin description missing ???)',
                'All user data and metadata (IP address, comment fields) can be logged to database or file'
            ),
            'backend' => array(
            ),
            'cookies' => array(
            ),
            'stores_user_input'     => true,
            'stores_ip'             => true,
            'uses_ip'               => true,
            'transmits_user_input'  => true
        ));

        $configuration = array('header_desc','do_honeypot', 'do_hiddencaptcha' );
        // Only do that, if spamblock is not installed
        if (!class_exists('serendipity_event_spamblock')) {
            $configuration = array_merge($configuration, array('entrytitle', 'samebody', 'required_fields'));
        }
        $configuration = array_merge($configuration, array('spamlogtype', 'spamlogfile', 'plugin_path'));
        $configuration = array_merge($configuration, array(
            'advanced_cc_desc', 'answer_retrieval_method', 'question_type',
            'questions', 'answers', 'use_regexp'
        ));

        $propbag->add('configuration', $configuration );
        $propbag->add('config_groups', array(
                PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SECTION_LOGGING => array(
                    'spamlogtype', 'spamlogfile', 'plugin_path'
                ),
                PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SECTION_ADVANCED => array(
                    'advanced_cc_desc', 'answer_retrieval_method', 'question_type',
                    'questions', 'answers', 'use_regexp'
                )
            )
        );
    }

    /**
     * Set plug-in title.
     *
     * @param  string $title
     */
    function generate_content(&$title) {
        $title = PLUGIN_EVENT_SPAMBLOCK_BEE_TITLE;
    }

    /**
     * Generate backend configuration fields
     *
     * @param  string                   $name     field name
     * @param  serendipity_property_bag $propbag properties
     * @return bool
     */
    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        $rejectType = array(
            PLUGIN_EVENT_SPAMBLOCK_SWTCH_OFF      => PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_OFF,
            PLUGIN_EVENT_SPAMBLOCK_SWTCH_MODERATE => PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_MODERATE,
            PLUGIN_EVENT_SPAMBLOCK_SWTCH_REJECT   => PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_REJECT,
        );

        $retrievalMethod = array(
            'default'    => PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_DEFAULT,
            'json'       => PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_JSON,
            'smarty'     => PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_SMARTY,
            'smarty_enc' => PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_SMARTY_ENC
        );

        $questionType = array(
            'math'   => PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QT_MATH,
            'custom' => PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QT_CUSTOM
        );

        switch($name) {
            case 'header_desc':
                $propbag->add('type',    'content');
                $propbag->add('default', PLUGIN_EVENT_SPAMBLOCK_BEE_EXTRA_DESC .
                    '<img src="' . $serendipity['baseURL'] . 'index.php?/plugin/spamblockbee.png" alt="" title="' . PLUGIN_EVENT_SPAMBLOCK_BEE_TITLE . '" style="float:right">'                );
                break;

            case 'do_honeypot':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT_DESC);
                $propbag->add('default',     true);
                break;

            case 'do_hiddencaptcha':
                $propbag->add('type',        'select');
                $propbag->add('name',        PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HCAPTCHA);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HCAPTCHA_DESC);
                $propbag->add('select_values', $rejectType);
                $propbag->add('default',     PLUGIN_EVENT_SPAMBLOCK_SWTCH_MODERATE);
                break;

            case 'required_fields':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS_DESC);
                $propbag->add('default',     '');
                break;

            case 'entrytitle':
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_TITLE);
                $propbag->add('description',    PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_TITLE_DESC);
                $propbag->add('select_values',  $rejectType);
                $propbag->add('default',        PLUGIN_EVENT_SPAMBLOCK_SWTCH_REJECT);
                break;

            case 'samebody':
                $propbag->add('type',          'select');
                $propbag->add('name',          PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_SAMEBODY);
                $propbag->add('description',   PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_SAMEBODY_DESC);
                $propbag->add('select_values', $rejectType);
                $propbag->add('default',       PLUGIN_EVENT_SPAMBLOCK_SWTCH_REJECT);
                break;

            case 'spamlogtype':
                $logtypevalues = array (
                    'none' => PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_NONE,
                    'file' => PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_FILE,
                    'db' => PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DATABASE,
                );
                $propbag->add('type',          'select');
                $propbag->add('name',          PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE);
                $propbag->add('description',   PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DESC);
                $propbag->add('select_values', $logtypevalues);
                $propbag->add('default',       'none');
                break;

            case 'spamlogfile':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE_DESC);
                $propbag->add('default',     $serendipity['serendipityPath'] . 'spamblock.log');
                break;

            case 'plugin_path':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_SPAMBLOCK_BEE_PATH);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BEE_PATH_DESC);
                $propbag->add('default',     $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_spamblock_bee/');
                break;

            case 'advanced_cc_desc':
                $propbag->add('type',          'content');
                $propbag->add('default',       PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DESC);
                break;

            case 'answer_retrieval_method':
                $propbag->add('type',          'select');
                $propbag->add('name',          PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWER_RETRIEVAL);
                $propbag->add('description',   PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWER_RETRIEVAL_DESC);
                $propbag->add('select_values', $retrievalMethod);
                $propbag->add('default',       'default');
                break;

            case 'question_type':
                $propbag->add('type',          'select');
                $propbag->add('name',          PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTION_TYPE);
                $propbag->add('description',   PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTION_TYPE_DESC);
                $propbag->add('select_values', $questionType);
                $propbag->add('default',       'math');
                break;

            case 'questions':
                $propbag->add('type',          'text');
                $propbag->add('rows',          8);
                $propbag->add('name',          PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTIONS);
                $propbag->add('description',   PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTIONS_DESC);
                $propbag->add('default',       PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DEFAULT_QUESTIONS);
                break;

            case 'answers':
                $propbag->add('type',          'text');
                $propbag->add('rows',          8);
                $propbag->add('name',          PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWERS);
                $propbag->add('description',   PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWERS_DESC);
                $propbag->add('default',       PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DEFAULT_ANSWERS);
                break;

            case 'use_regexp':
                $propbag->add('type',          'boolean');
                $propbag->add('name',          PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_USE_REGEXP);
                $propbag->add('description',   PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_USE_REGEXP_DESC);
                $propbag->add('default',       false);
                break;

            default:
                return false;
        }
        return true;
    }

    /**
     * Hook for Serendipity events, initialize plug-in features
     *
     * @param  string                   $event
     * @param  serendipity_property_bag $bag
     * @param  array                    $eventData
     * @param  array                    $addData
     * @return bool
     */
    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {
                case 'external_plugin':
                    switch($eventData) {
                        case 'spamblockbee.png':
                            header('Content-Type: image/png');
                            echo file_get_contents(dirname(__FILE__). '/spamblockbee.png');
                            break;
                        case 'spamblockbeecaptcha':
                            echo $this->produceCaptchaAnswerJson();
                            break;
                    }
                    break;

                case 'frontend_saveComment':
                    // Check only, if no one else denied it before
                    if (!is_array ( $eventData ) || serendipity_db_bool ( $eventData ['allow_comments'] )) {
                        return $this->checkComment($eventData, $addData);
                    }
                    return true;
                    break;

                case 'frontend_comment':
                    $this->printCommentEditExtras($eventData, $addData);
                    break;

                case 'frontend_footer':
                    // Comment header code only if in single article mode or contactform
                    // If contact form is installed, display on any page not being the article list
                    // else display in single article only.
                    $contactFormInstalled = class_exists('serendipity_event_contactform');
                    if (($contactFormInstalled && empty($eventData['GET']['page']))
                        || (!$contactFormInstalled && !empty($eventData['GET']['id'])))
                    {
                        $this->printJsExtras();
                    }
                    break;

                case 'css':
                    $this->printCss($eventData, $addData);
                    break;

                default:
                    return false;
                    break;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if Honey Pot or Captcha have been filled correctly (or if any
     * other indications for spam can be found).
     *
     * @param  array $eventData
     * @param  array $addData
     * @return bool
     */
    function checkComment(&$eventData, &$addData) {
        global $serendipity;

        if ("NORMAL" == $addData['type']) { // only supported for normal comments

            // Check for Honey Pot:
            $phone = $serendipity['POST']['phone'] ?? '';
            if ($this->useHoneyPot && (!empty($phone) || $phone == '0') ) {
                if (mb_strlen($phone) > 40) {
                    $phone = mb_substr($phone, 0, 40) . '..';
                }
                $this->spamlog($eventData['id'], 'REJECTED', "BEE Honeypot [" . $phone . "]", $addData);
                $eventData = array('allow_comments' => false);
                return false;
            }

            // Check hidden Captcha
            if (PLUGIN_EVENT_SPAMBLOCK_SWTCH_OFF != $this->hiddenCaptchaHandle) {
                $answer                  = trim(strtolower($serendipity['POST']['beecaptcha'] ?? ''));
                $correctAnswer           = $this->getCaptchaAnswer();
                $correctAnswer['answer'] = strtolower($correctAnswer['answer']);
                $isCorrect               = false;

                // If provided answer is longer than 1000 characters and RegExp matching is on,
                // reject comment for security reasons (minimize risk of ReDoS)
                if ($this->useRegularExpressions && mb_strlen($answer) > 1000) {
                    $this->processComment($this->hiddenCaptchaHandle, $eventData, $addData, PLUGIN_EVENT_SPAMBLOCK_BEE_ERROR_HCAPTCHA, "BEE HiddenCaptcha [ Captcha input too long ]");
                    return false;
                }

                if ($this->captchaQuestionType == 'custom' && $this->useRegularExpressions) {
                    // Sanitize regular expression and remove answer part
                    $pattern = preg_replace('/^\s*\/(.*)\/\s*[imsxeADSUXJu]*\s*$/s', '$1', $correctAnswer['pattern']);

                    // Try to match pattern with given answer
                    $match = @preg_match('/' . $pattern . '/si', $answer);

                    // If pattern contains errors, fall back to basic string comparison
                    if ($match === false) {
                        $this->useRegularExpressions = false;
                    } else {
                        $isCorrect = ($match === 1);
                    }
                }

                if ($this->captchaQuestionType != 'custom' || !$this->useRegularExpressions) {
                    $isCorrect = ($answer == $correctAnswer['answer']);
                }

                // Also allow numbers as words
                if (!$isCorrect && $this->captchaQuestionType == 'math') {
                    $number    = $this->generateNumberString($correctAnswer['answer']);
                    $isCorrect = ($answer == $number && $number != 'ERROR');
                }

                if (!$isCorrect) {
                    if (mb_strlen($answer) > 40) {
                        $answer = mb_substr($answer, 0, 40) . '..';
                    }
                    $this->processComment($this->hiddenCaptchaHandle, $eventData, $addData, PLUGIN_EVENT_SPAMBLOCK_BEE_ERROR_HCAPTCHA, "BEE HiddenCaptcha [ $correctAnswer[answer] != $answer ]");
                    return $isCorrect;
                }
            }
            // AntiSpam check, the general spamblock supports, too: Only if spamblock is not installed.
            if (!class_exists('serendipity_event_spamblock')) {

                // Check for required fields. Don't log but tell the user about the fields.
                $required_fields = $this->get_config('required_fields', '');
                if (!empty($required_fields)) {
                    $required_field_list = explode(',', $required_fields);
                    foreach($required_field_list as $required_field) {
                        $required_field = trim($required_field);
                        if (empty($addData[$required_field])) {
                            $this->reject($eventData, $addData, sprintf(PLUGIN_EVENT_SPAMBLOCK_BEE_REASON_REQUIRED_FIELD, $required_field));
                            return false;
                        }
                    }
                }
            }
        }

        // AntiSpam check, the general spamblock supports, too: Only if spamblock is not installed.
        if (!class_exists('serendipity_event_spamblock')) {

            // Check if entry title is the same as comment body
            $spamHandle = $this->get_config('entrytitle', PLUGIN_EVENT_SPAMBLOCK_SWTCH_REJECT);
            if (PLUGIN_EVENT_SPAMBLOCK_SWTCH_OFF != $spamHandle) {
                // Remove the blog name from the comment which might be in <title>
                $comment = str_replace($serendipity['blogTitle'], '', $addData['comment']);
                $comment = str_replace($eventData['title'], '', $comment);
                // Now blog- and entry title was stripped from comment.
                // Remove special letters, that might have been between them:
                $comment = trim(preg_replace('@[\s\-_:\(\)\|/]*@', '', $comment));

                // Now that we stripped blog and entry title: Do we have an empty comment?
                if (empty($comment)) {
                    $this->processComment($spamHandle, $eventData, $addData, PLUGIN_EVENT_SPAMBLOCK_BEE_ERROR_BODY, "BEE Body the same as title");
                    return false;
                }
            }

            // This check loads from DB, so do it last!
            // Check if we already have a comment with the same body. (it's a reload normaly)
            $spamHandle = $this->get_config('samebody', PLUGIN_EVENT_SPAMBLOCK_SWTCH_REJECT);
            if (PLUGIN_EVENT_SPAMBLOCK_SWTCH_OFF!=$spamHandle) {
                $query = "SELECT count(id) AS counter FROM {$serendipity['dbPrefix']}comments WHERE type = '" . $addData['type'] . "' AND body = '" . serendipity_db_escape_string($addData['comment']) . "'";
                // This is a little different to the normal Spam Plugin:
                // We allow the same comment, if it is a trackback, but never on the same article
                // (One article sending trackbacks to more than one local article)
                if ($addData['type'] == 'PINGBACK' ||  $addData['type'] == 'TRACKBACK') {
                    $query .= ' AND entry_id=' . $eventData['id'];
                }
                $row   = serendipity_db_query($query, true);
                if (is_array($row) && $row['counter'] > 0) {
                    $this->processComment($spamHandle, $eventData, $addData, PLUGIN_EVENT_SPAMBLOCK_BEE_ERROR_BODY, "BEE Body already saved");
                    return false;
                }

            }
        }

        return true;
    }

    /**
     * Reject or moderate a comment. Convenience function.
     *
     * @param  string $spamHandle
     * @param  array $eventData
     * @param  array $addData
     * @param  string $remoteResponse
     * @param  string $logResponse
     * @return void
     */
    function processComment($spamHandle, &$eventData, &$addData, $remoteResponse, $logResponse = NULL) {
        if ($spamHandle == PLUGIN_EVENT_SPAMBLOCK_SWTCH_MODERATE) {
            $this->moderate($eventData, $addData, $remoteResponse, $logResponse);
        }
        else {
            $this->reject($eventData, $addData, $remoteResponse, $logResponse);
        }
    }

    /**
     * Reject a comment with optional log entry.
     *
     * @param  array  $eventData
     * @param  array  $addData
     * @param  string $remoteResponse
     * @param  string $logResponse
     */
    function reject(&$eventData, &$addData, $remoteResponse, $logResponse = NULL) {
        global $serendipity;

        if (!empty($logResponse)) {
            $this->spamlog($eventData['id'], 'REJECTED', $logResponse, $addData);
        }
        $eventData = array('allow_comments' => false);
        $serendipity['csuccess'] = 'false';
        $serendipity['messagestack']['comments'][] = $remoteResponse;

        $this->log(print_r($serendipity['messagestack'], true));
    }

    /**
     * Moderate a comment with optional log entry
     * @param  array  $eventData
     * @param  array  $addData
     * @param  string $remoteResponse
     * @param  string $logResponse
     * @return void
     */
    function moderate(&$eventData, &$addData, $remoteResponse, $logResponse = NULL) {
        global $serendipity;

        if (!empty($logResponse)) {
            $this->spamlog($eventData['id'], 'MODERATE', $logResponse, $addData);
        }
        $eventData['moderate_comments'] = true;
        $serendipity['csuccess']        = 'moderate';
        $serendipity['moderate_reason'] = $remoteResponse;
        $serendipity['messagestack']['comments'][] = $remoteResponse;

        $this->log(print_r($serendipity['messagestack'], true));
    }

    /**
     * Produce JSON string with the correct for fetching via Ajax.
     *
     * @return string The generated JSON string
     */
    function produceCaptchaAnswerJson() {
        $answer      = $this->getCaptchaAnswer();
        $scrambleKey = rand();

        if (!isset($answer['answer'])) {
            $answer = array('answer' => 'ERROR');
        } else {
            $answer['answer']      = rawurlencode($this->xorScramble($answer['answer'], $scrambleKey));
            $answer['scrambleKey'] = $scrambleKey;
        }

        return json_encode($answer);
    }

    /**
     * Write the Honey Pot and Captcha field to the output buffer.
     *
     * @param  array $eventData
     * @param  array $addData
     */
    function printCommentEditExtras(&$eventData, &$addData) {
        global $serendipity;

        // Don't put extras on admin menu. They are not working there: ...or other backend forms like guestbook
        if ((isset($eventData['GET']['action']) && $eventData['GET']['action']=='admin') || (int)($serendipity['serendipityUserlevel'] ?? null) >= (int)USERLEVEL_ADMIN) return;

        // Honeypot
        if (serendipity_db_bool($this->useHoneyPot)) {
            echo '<div id="serendipity_comment_phone" class="serendipity_commentDirection comment_phone_input">' . "\n";
            echo '    <label for="serendipity_commentform_phone">Phone*</label>' . "\n";
            echo '    <input id="serendipity_commentform_phone" class="comment_phone_input" type="text" name="serendipity[phone]" value="" size="50" maxlength="60" placeholder="' . PLUGIN_EVENT_SPAMBLOCK_BEE_WARN_HONEPOT . '"/>' . "\n";
            echo "</div>\n";
        }

        // Captcha
        if (PLUGIN_EVENT_SPAMBLOCK_SWTCH_OFF != $this->hiddenCaptchaHandle) {
            $question = $this->generateCaptchaQuestion();

            echo '<div id="serendipity_comment_beecaptcha" class="form_field">' . "\n";
            echo '    <label for="bee_captcha">'. $question. '</label>' . "\n";
            echo '    <input class="" type="text" id="bee_captcha" name="serendipity[beecaptcha]" size="10" value="" placeholder=""/>' . "\n";
            echo "</div>\n";

            if ($this->answerRetrievalMethod == 'smarty' || $this->answerRetrievalMethod == 'smarty_enc') {
                $answer = $this->getCaptchaAnswer();
                if ($this->answerRetrievalMethod == 'smarty_enc') {
                    $scrambleKey      = rand();
                    $answer['answer'] = $this->xorScramble($answer['answer'], $scrambleKey);
                    $serendipity['smarty']->assign('beeCaptchaScrambleKey', $scrambleKey);
                }

                $serendipity['smarty']->assign('beeCaptchaAnswer', $answer['answer']);
            }
        }
    }

    /**
     * If retrieval method != 'smarty' and the hidden Captcha is turned on,
     * print the needed JavaScript for filling out and hiding the Captcha to the buffer.
     */
    function printJsExtras() {
        if ($this->answerRetrievalMethod == 'smarty' || $this->answerRetrievalMethod == 'smarty_enc') {
            return;
        }

        global $serendipity;

        if (PLUGIN_EVENT_SPAMBLOCK_SWTCH_OFF != $this->hiddenCaptchaHandle) {
            $path         = $this->path = $this->get_config('plugin_path', $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_spamblock_bee/');
            $answer       = $this->getCaptchaAnswer();
            $answer       = $answer['answer'];
            $jsProperties = array('method' => $this->answerRetrievalMethod);


            if ($this->answerRetrievalMethod == 'json') {
                $jsProperties['url'] = $serendipity['baseURL'] . 'index.php/plugin/spamblockbeecaptcha';
                echo '<script>var spamBeeData = ' . json_encode($jsProperties) . ';</script>' . "\n";
            } else {
                $scrambleKey                 = rand();
                $answer                      = rawurlencode($this->xorScramble($answer, $scrambleKey));
                $jsProperties['scrambleKey'] = $scrambleKey;
                $jsProperties['answer']      = is_numeric($answer) ? $answer : trim($answer);
            }
            unset($jsProperties['pattern']);

            if ($this->answerRetrievalMethod == 'default') {
                // Do some weird obfuscation stuff to the JS code
                $spamBeeVar = $this->generateUniqueVarName(array());

                // Shuffle array but preserve keys
                $jsPropertiesKeys = array_keys($jsProperties);
                shuffle($jsPropertiesKeys);
                $jsProperties = array_merge(array_flip($jsPropertiesKeys) , $jsProperties);

                echo '<script>var spamBeeData = function() { var ' . $spamBeeVar . ' = {};';

                $jsVars       = array();
                $existingKeys = array($spamBeeVar);
                foreach($jsProperties as $property => $value) {
                    $varName          = $this->generateUniqueVarName($existingKeys);
                    $jsVars[$varName] = $property;
                    $existingKeys[]   = $varName;

                    // URL encode all characters to make values appear almost equal
                    $encVal = '';
                    $valLength = mb_strlen($value);
                    for ($i = 0; $i < $valLength; ++$i) {
                        $encVal .= '%' . bin2hex(mb_substr($value, $i, 1));
                    }

                    echo 'var ' . $varName . " = unescape('" . $encVal . "');";
                }

                foreach ($jsVars as $var => $value) {
                    echo $spamBeeVar . "['" . $value . "'] = " . $var . ';';
                }

                echo 'return ' . $spamBeeVar . '; }();';
                echo "</script>\n";
            }

            echo '<script src="' . $path . 'serendipity_event_spamblock_bee.js"></script>' . "\n";
        }
    }

    /**
     * Generate a unique random variable name. Used for generating obfuscated
     * JS code. To make sure, the name is really unique, pass an array of all
     * variable names already existing to this function.
     * Returns an empty string if no unique variable name could be generated.
     *
     * @param  array $existingVarNames
     * @param  int   $length
     * @return string
     */
    function generateUniqueVarName($existingVarNames, $length = 5) {
        $varName = '';
        $pool    = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz_';

        $attempts = 0;
        for ($i = 0; $i < $length; ++$i) {
            $varName .= $pool[rand(0, strlen($pool) - 1)];

            // If variable name has been generated, but is not unique, start over again
            if ($i == ($length - 1) && in_array($varName, $existingVarNames)) {
                // If we already have 10 attempts, give up and return empty string (should not happen)
                if ($attempts >= 9) {
                    return '';
                }
                $i = 0;
                ++$attempts;
            }
        }

        return $varName;
    }

    /**
     * If retrieval method != 'json' and the hidden Captcha is enabled, print
     * the needed CSS for hiding it to the output buffer.
     *
     * @param  array $eventData
     * @param  array $addData
     */
    function printCss(&$eventData, &$addData) {
        if ($this->answerRetrievalMethod == 'smarty' || $this->answerRetrievalMethod == 'smarty_enc') {
            return;
        }

        global $serendipity;

        // Hide and reveal classes by @yellowled used be the RSS chooser:
        if (PLUGIN_EVENT_SPAMBLOCK_SWTCH_OFF != $this->hiddenCaptchaHandle) {
?>
.spambeehidden {
    border: 0;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
}
<?php
        }

        if (!(strpos($eventData, '.comment_phone_input'))) {
?>
.comment_phone_input {
    max-width: 100%;
    display:none;
    visibility:hidden;
}
<?php
        }
    }

    function hashString( $what ) {
        $installation_secret = $this->get_config('installation_secret');
        if (empty($installation_secret)) {
            $installation_secret = md5(date('l jS \of F Y h:i:s A'));
            $this->set_config('installation_secret', $installation_secret);
        }
        return md5($installation_secret . ':' . $what);
    }

    /**
     * Generate the question for the Captcha and save the answer to the session.
     *
     * @return string the question
     */
    function generateCaptchaQuestion() {
        if ($this->captchaQuestionType == 'custom') {
            $question = $this->selectRandomCustomCaptchaQuestion();
            if (null === $question) {
                // no valid question could be selected, fall back to math questions
                $this->captchaQuestionType = 'math';
                $this->set_config('question_type', 'math');
            } else {
                $this->setCaptchaAnswer($question['answer']);
                return $question['question'];
            }
        }

        if ($this->captchaQuestionType == 'math') {
            $captchaData = $this->generateCaptchaMathProblem();
            $this->setCaptchaAnswer($captchaData['answer']);

            $method = PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_PLUS;
            if ($captchaData['operator'] == '-') {
                $method = PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_MINUS;
            }

            return PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_QUEST . ' ' .
                   $this->generateNumberString($captchaData['n1']) . " " .
                   $method . " " . $this->generateNumberString($captchaData['n2']) . '?';
        }
    }

    /**
     * Get correct answer for current Captcha question.
     * This method returns an array with one or two indices:
     *     array(
     *         'answer'  => the answer to the question
     *         'pattern' => the pattern for matching the answer (only present
     *                      when regExp matching is turned on)
     *     )
     *
     * @return array
     */
    function getCaptchaAnswer() {
        if (!isset($this->captchaAnswer['answer']) && isset($_SESSION['spamblockbee']['captcha'])) {
            $this->captchaAnswer = $_SESSION['spamblockbee']['captcha'];
        }

        // If for some reason RegExp matching is on, but no pattern is present,
        // turn off RegExp matching
        if ($this->useRegularExpressions && !isset($this->captchaAnswer['pattern'])) {
            $this->useRegularExpressions = false;
        }

        return $this->captchaAnswer;
    }

    /**
     * Save the answer for the Captcha question.
     * Call this method when you have changed the question.
     * If RegExp matching is turned on, pass a string in the format /pattern/:answer.
     *
     * @param string $answer
     */
    function setCaptchaAnswer($answer) {
        $answer = array('answer' => $answer);

        // Split answer into array if RegExp matching is on
        if ($this->captchaQuestionType == 'custom' && $this->useRegularExpressions) {
            $delimiterIndex = strrpos($answer['answer'], ':');

            if ($delimiterIndex !== false) {
                $answer = array(
                    'pattern' => substr($answer['answer'], 0, $delimiterIndex),
                    'answer'  => substr($answer['answer'], $delimiterIndex + 1)
                );
            } else {
                // Answer contains either no pattern or no answer part, fall back to string matching
                $this->useRegularExpressions = false;
            }
        }

        $this->captchaAnswer                 = $answer;
        $_SESSION['spamblockbee']['captcha'] = $this->captchaAnswer;
    }

    /**
     * Generate a simple arithmetic problem for use in the Captcha.
     * Returns an array containing the operator, the operands and the result.
     *
     * @return array
     */
    function generateCaptchaMathProblem() {
        $result = array();

        $number1 = rand(0,9);
        $number2 = rand(0,9);
        if (($number1 + $number2) > 10 ) {
            // Substract them
            $result['operator'] = '-';
            if ($number1>$number2) {
                $result['n1'] = $number1;
                $result['n2'] = $number2;
                $result['answer'] =  $number1 - $number2;
            }
            else {
                $result['n2'] = $number1;
                $result['n1'] = $number2;
                $result['answer'] =  $number2 - $number1;
            }
        } else {
                // Add them
                $result['operator'] = '+';
                $result['n1'] = $number1;
                $result['n2'] = $number2;
                $result['answer'] =  $number1 + $number2;
        }

        return $result;
    }

    /**
     * Turn numbers between 0 and 10 into words.
     *
     * @param  int $number
     * @return string
     */
    function generateNumberString($number) {
        //$number = (int)$number;
        switch ($number) {
            case 0: return PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_0;
            case 1: return PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_1;
            case 2: return PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_2;
            case 3: return PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_3;
            case 4: return PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_4;
            case 5: return PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_5;
            case 6: return PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_6;
            case 7: return PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_7;
            case 8: return PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_8;
            case 9: return PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_9;
            case 10: return PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_10;
            default: return "ERROR";
        }
    }

    /**
     * Select a random question from the list of custom questions.
     * Returns an array with to indices:
     *     array(
     *         'question' => the selected question
     *         'answer'   => the answer for that question
     *     )
     *
     * @return array
     */
    function selectRandomCustomCaptchaQuestion() {
        $questions = trim($this->get_config('questions', ''));
        $answers   = trim($this->get_config('answers', ''));
        if (empty($questions) || empty($answers)) {
            return null;
        }

        $questions = preg_split('/(?:\r?\n|\r)/', $questions);
        $answers   = preg_split('/(?:\r?\n|\r)/', $answers);

        // ignore questions without answer
        if (count($questions) > count($answers)) {
            array_splice($questions, count($answers));
        }

        // if no questions left
        if (!count($questions)) {
            return null;
        }

        $questionIndex = rand(0, count($questions) - 1);
        return array(
            'question' => trim($questions[$questionIndex]),
            'answer'   => trim($answers[$questionIndex])
        );
    }

    /**
     * Scramble a UTF-8 string with a simple XOR cipher in order
     * to perform string obfuscation.
     *
     * @param  string $string
     * @param  int    $key
     * @return string
     */
    function xorScramble($string, $key) {
        $scrambled = '';
        $length    = mb_strlen($string, 'UTF-8');

        for ($i = 0; $i < $length; ++$i) {
            $chr        = mb_substr($string, $i, 1, 'UTF-8');
            $ord        = $this->ordUtf8($chr);
            $scrambled .= $this->chrUtf8($ord ^ $key);
        }

        return $scrambled;
    }

    /**
     * Multi-byte safe UTF-8 version of chr()
     * Thanks to http://pastebin.com/fmiSnNin
     *
     * @param  int    $ord
     * @return string
     */
    function chrUtf8($ord)
    {
        return mb_convert_encoding(pack('n', $ord) , 'UTF-8', 'UTF-16BE');
    }

    /**
     * Multi-byte safe UTF-8 version of ord().
     * Thanks to http://pastebin.com/fmiSnNin
     * Returns -1 on error.
     *
     * @param  string $chr
     * @return int
     */
    function ordUtf8($chr)
    {
        // Return value of ord() if only single-byte
        if (strlen($chr) == 1) {
            return ord($chr);
        }

        $codePoint = ord($chr[0]);

        if ($codePoint <= 0x7f) {
            return $codePoint;
        } else if ($codePoint < 0xc2) {
            return -1;
        } else if ($codePoint <= 0xdf) {
            return ($codePoint & 0x1f) << 6 | (ord($chr[1]) & 0x3f);
        } else if ($codePoint <= 0xef) {
            return ($codePoint & 0x0f) << 12 | (ord($chr[1]) & 0x3f) << 6 | (ord($chr[2]) & 0x3f);
        } else if ($codePoint <= 0xf4) {
            return ($codePoint & 0x0f) << 18 | (ord($chr[1]) & 0x3f) << 12 | (ord($chr[2]) & 0x3f) << 6 | (ord($chr[3]) & 0x3f);
        } else {
            return -1;
        }
    }

    /**
     * Log spam to file
     * @param  string $message
     */
    function log($message){
        if (!PLUGIN_EVENT_SPAMBLOCK_BEE_DEBUG) return;
        $fp = fopen(dirname(__FILE__) . '/spambee.log','a');
        fwrite($fp, date('Y.m.d H:i:s') . " - " . $message . "\n");
        fflush($fp);
        fclose($fp);
    }

    /**
     * Log spam to database
     * @param  string $id
     * @param  string $switch
     * @param  string $reason
     * @param  string $addData
     */
    function spamlog($id, $switch, $reason, $addData) {
        global $serendipity;

        $method = $this->get_config('spamlogtype', 'none');
        $logfile = $this->get_config('spamlogfile', $serendipity['serendipityPath'] . 'spamblock.log');

        switch($method) {
            case 'file':
                if (empty($logfile)) {
                    return;
                }
                if (strpos($logfile, '%') !== false) {
                    $logfile = strftime($logfile);
                }

                $fp = @fopen($logfile, 'a+');
                if (!is_resource($fp)) {
                    return;
                }
                fwrite($fp, sprintf(
                    '[%s] - [%s: %s] - [#%s, Name "%s", E-Mail "%s", URL "%s", User-Agent "%s", IP %s] - [%s]' . "\n",
                    date('Y-m-d H:i:s', serendipity_serverOffsetHour()),
                    $switch,
                    $reason,
                    $id,
                    str_replace("\n", ' ', $addData['name']),
                    str_replace("\n", ' ', $addData['email']),
                    str_replace("\n", ' ', $addData['url']),
                    str_replace("\n", ' ', $_SERVER['HTTP_USER_AGENT']),
                    $_SERVER['REMOTE_ADDR'],
                    str_replace("\n", ' ', $addData['comment'])
                ));

                fclose($fp);
                break;

            case 'none':
                return;
                break;

            case 'db':
            default:
                $reason = serendipity_db_escape_string($reason);
                $q = sprintf("INSERT INTO {$serendipity['dbPrefix']}spamblocklog
                                          (timestamp, type, reason, entry_id, author, email, url,  useragent, ip,   referer, body)
                                   VALUES (%d,        '%s',  '%s',  '%s',     '%s',   '%s',  '%s', '%s',      '%s', '%s',    '%s')",

                           serendipity_serverOffsetHour(),
                           serendipity_db_escape_string($switch),
                           serendipity_db_escape_string($reason),
                           serendipity_db_escape_string($id),
                           serendipity_db_escape_string($addData['name']),
                           serendipity_db_escape_string($addData['email']),
                           serendipity_db_escape_string($addData['url']),
                           substr(serendipity_db_escape_string($_SERVER['HTTP_USER_AGENT']), 0, 255),
                           serendipity_db_escape_string($_SERVER['REMOTE_ADDR']),
                           substr(serendipity_db_escape_string(isset($_SESSION['HTTP_REFERER']) ? $_SESSION['HTTP_REFERER'] : $_SERVER['HTTP_REFERER']), 0, 255),
                           serendipity_db_escape_string($addData['comment'])
                );

                serendipity_db_schema_import($q);
                break;
        }
    }
}
