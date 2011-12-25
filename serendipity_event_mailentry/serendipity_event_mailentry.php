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

class serendipity_event_mailentry extends serendipity_event {
    function introspect(&$propbag)
    {
        $propbag->add('name',        PLUGIN_MAILENTRY_NAME);
        $propbag->add('description', PLUGIN_MAILENTRY_DESC);
        $propbag->add('configuration', array('title'));
        $propbag->add('version',     '1.22');
        $propbag->add('event_hooks',
                      array('frontend_display:html:per_entry' => true));
        $propbag->add('groups', array('FRONTEND_ENTRY_RELATED'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        TITLE);
                $propbag->add('description', TITLE);
                $propbag->add('default',     PLUGIN_MAILENTRY_NAME);
                break;

            default:
                return false;
                break;
        }
        return true;
    }

    function generate_content(&$title) {
      $title = PLUGIN_MAILENTRY_NAME;
    }

    function stripMe($str) {
       return str_replace(array("\n", "\r", "\t", "\0"), array('', '', '', ''), $str);
    }

    function event_hook($event, &$bag, &$eventData) {
        global $serendipity;

        switch ($event) {
            case 'frontend_display:html:per_entry':
                if ( $serendipity['GET']['id'] ) {
                    ob_start();
                    if ( isset($serendipity['POST']) && isset($serendipity['POST']['mailEntry']) ) {
                        $me = $serendipity['POST']['mailEntry'];

                        if ( !preg_match('/^[.\w-]+@([\w-]+\.)+[a-zA-Z]{2,6}$/', $me['to']) ) {
                          echo '<div class="serendipity_msg_important">' . PLUGIN_MAILENTRY_TO_INVALID . "</div>\n";
                          break;
                        }

                        if ( !preg_match('/^[.\w-]+@([\w-]+\.)+[a-zA-Z]{2,6}$/', $me['fromAddr']) ) {
                          echo '<div class="serendipity_msg_important">' . PLUGIN_MAILENTRY_FROM_INVALID . "</div>\n";
                          break;
                        }

                        $headers = "To: " . $this->stripMe($me['to']) . "\r\n" .
                          "Reply-To: " . $this->stripMe($me['fromName']) . " <" . $this->stripMe($me['fromAddr']) . ">\r\n" .
                          "From: " . (!empty($serendipity['blogMail']) ? $serendipity['blogMail'] : $serendipity['email']) . "\r\n";

                        $message = sprintf(PLUGIN_MAILENTRY_EMAIL,
                                           $me['fromName'],
                                           $serendipity['blogTitle'],
                                           $eventData['title'],
                                           serendipity_archiveURL($eventData['id'], $eventData['title'], 'baseURL', true, array('timestamp' => $eventData['timestamp'])),
                                           trim($me['message']),
                                           $serendipity['signature']);

                        if ( mail($me['to'], $eventData['title'] . ' - ' . $serendipity['blogTitle'], $message, $headers) ) {
                          echo '<div class="serendipity_msg_notice">' . PLUGIN_MAILENTRY_SUCCESS . "</div>\n";
                        } else {
                          echo '<div class="serendipity_msg_important">' . PLUGIN_MAILENTRY_FAILURE . "</div>\n";
                        }
                    }
?>
<form id="serendipity_mailEntry_form" action="" method="post" class="serendipity_comments">
  <br/>
  <a id="serendipity_mailEntry"></a>
  <div class="serendipity_commentsTitle"><?php echo $this->get_config('title', PLUGIN_MAILENTRY_NAME); ?></div>
  <table>
    <tr>
      <td class="serendipity_commentsLabel"><label for="serendipity_mailEntry_to"><?php echo PLUGIN_MAILENTRY_TO; ?></label></td>
      <td class="serendipity_commentsValue"><input type="text" id="serendipity_mailEntry_to" name="serendipity[mailEntry][to]" /></td>
    </tr>

    <tr>
      <td class="serendipity_commentsLabel"><label for="serendipity_mailEntry_from_name"><?php echo PLUGIN_MAILENTRY_FROM_NAME; ?></label></td>
      <td class="serendipity_commentsValue"><input type="text" id="serendipity_mailEntry_from_name" name="serendipity[mailEntry][fromName]" /></td>
    </tr>

    <tr>
      <td class="serendipity_commentsLabel"><label for="serendipity_mailEntry_from_addr"><?php echo PLUGIN_MAILENTRY_FROM_ADDR; ?></label></td>
      <td class="serendipity_commentsValue"><input type="text" id="serendipity_mailEntry_from_addr" name="serendipity[mailEntry][fromAddr]" /></td>
    </tr>

    <tr>
      <td class="serendipity_commentsLabel"><label for="serendipity_mailEntry_message"><?php echo PLUGIN_MAILENTRY_MESSAGE; ?></label></td>
      <td class="serendipity_commentsValue"><textarea rows="10" cols="40" id="serendipity_mailEntry_message" name="serendipity[mailEntry][message]"></textarea></td>
    </tr>

    <tr>
      <td class="serendipity_commentsLabel"></td>
      <td class="serendipity_commentsValue"><input type="submit" id="serendipity_mailEntry_submit" name="serendipityp[mailentry][submit]" value="<?php echo PLUGIN_MAILENTRY_SEND; ?>" /></td>
    </tr>
  </table>
</form>
<?php
                        $eventData['display_dat'] = ob_get_contents();
                        ob_end_clean();
                    }
                break;

            default:
                return true;
                break;
        }
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>