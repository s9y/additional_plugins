<?php # $Id$

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_dashboard extends serendipity_event {

    var $debug;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_DASHBOARD_TITLE);
        $propbag->add('description',   PLUGIN_DASHBOARD_DESC);
        $propbag->add('requirements',  array(
            'serendipity' => '1.3',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

        $propbag->add('version',       '0.6.6');
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('stackable',     false);
        $propbag->add('configuration', array('read_only', 'limit_draft', 'limit_comments', 'limit_comments_pending', 'limit_future', 'sequence', 'update'));
        $propbag->add('event_hooks',   array(
                                            'backend_frontpage_display'                         => true,
                                            'css_backend'                                       => true,
                                        )
        );
        $propbag->add('groups', array('BACKEND_FEATURES'));
    }

    function introspect_config_item($name, &$propbag) {
        switch($name) {
            case 'limit_draft':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_DASHBOARD_LIMIT_DRAFT);
                $propbag->add('description', '');
                $propbag->add('default',     '5');
                break;

            case 'read_only':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_DASHBOARD_READONLY);
                $propbag->add('description', PLUGIN_DASHBOARD_READONLY_DESC);
                $propbag->add('default',     'false');
                break;

            case 'update':
                $propbag->add('type',        'radio');
                $propbag->add('name',        PLUGIN_DASHBOARD_UPDATE);
                $propbag->add('description', PLUGIN_DASHBOARD_UPDATE_DESC);
                $propbag->add('radio', array(
                    'value' => array('stable', 'beta', 'none'),
                    'desc'  => array(PLUGIN_DASHBOARD_STABLE, PLUGIN_DASHBOARD_UNSTABLE, PLUGIN_DASHBOARD_NONE)
                ));
                $propbag->add('radio_per_row', '1');
                $propbag->add('default',     'stable');
                break;

            case 'limit_comments':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_DASHBOARD_LIMIT_COMMENTS);
                $propbag->add('description', '');
                $propbag->add('default',     '5');
                break;

            case 'limit_comments_pending':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_DASHBOARD_LIMIT_COMMENTS_PENDING);
                $propbag->add('description', '');
                $propbag->add('default',     '5');
                break;

            case 'limit_future':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_DASHBOARD_LIMIT_FUTURE);
                $propbag->add('description', '');
                $propbag->add('default',     '5');
                break;

            case 'sequence':
                $propbag->add('type',        'sequence');
                $propbag->add('name',        PLUGIN_DASHBOARD_SEQUENCE);
                $propbag->add('description', PLUGIN_DASHBOARD_SEQUENCE_DESC);
                $propbag->add('checkable',   true);
                $values = array(
                    'update'   => array('display' => UPDATE),
                    'draft'    => array('display' => DRAFT),
                    'comments' => array('display' => COMMENT),
                    'future'   => array('display' => PLUGIN_DASHBOARD_FUTURE),
                    'comments_pending' => array('display' => PLUGIN_DASHBOARD_COMMENTS_PENDING)
                );
                $propbag->add('values',      $values);
                $propbag->add('default',     'update,draft,comments_pending,comments,future');
                break;

            default:
                    return false;
        }
        return true;
    }

    function generate_content(&$title) {
        $title = PLUGIN_DASHBOARD_TITLE;
    }
    
    function showElementCommentlist($where, $limit) {
        global $serendipity;

        $summaryLength = 200;
        $i = 0;

        if (version_compare(substr($serendipity['version'], 0, 3), '1.6') >= 0) { 
            $comments = serendipity_fetchComments(null, $limit, 'co.id DESC', true, 'NORMAL', $where);
        } else {
            $comments = serendipity_db_query("SELECT c.*, e.title FROM {$serendipity['dbPrefix']}comments c
                                        LEFT JOIN {$serendipity['dbPrefix']}entries e ON (e.id = c.entry_id)
                                        WHERE 1 = 1 " . $where
                                        . (!serendipity_checkPermission('adminEntriesMaintainOthers') ? 'AND e.authorid = ' . (int)$serendipity['authorid'] : '') . "
                                        ORDER BY c.id DESC LIMIT $limit");
        }

        if (!is_array($comments)) {
            return;
        }
        if (count($comments)==0) {
            return;
        }

        echo '<table width="100%" cellpadding="3" border="0" cellspacing="0">';

        foreach ($comments as $rs) {
            $i++;
            $comment = array(
                'fullBody'  => $rs['body'],
                'summary'   => serendipity_mb('substr', $rs['body'], 0, $summaryLength),
                'status'    => $rs['status'],
                'type'      => $rs['type'],
                'id'        => $rs['id'],
                'title'     => $rs['title'],
                'timestamp' => $rs['timestamp'],
                'referer'   => $rs['referer'],
                'url'       => $rs['url'],
                'ip'        => $rs['ip'],
                'entry_url' => serendipity_archiveURL($rs['entry_id'], $rs['title']),
                'email'     => $rs['email'],
                'author'    => (empty($rs['author']) ? ANONYMOUS : $rs['author']),
                'entry_id'  => $rs['entry_id']
            );
        
            $entrylink = serendipity_archiveURL($comment['entry_id'], 'comments', 'serendipityHTTPPath', true) . '#c' . $comment['id'];
            if (strlen($comment['fullBody']) > strlen($comment['summary']) ) {
                $comment['summary'] .= ' ...';
                $comment['excerpt'] = true;
        
                // When summary is not the full body, strip HTML tags from summary, as it might break and leave unclosed HTML.
                $comment['fullBody'] = nl2br(htmlspecialchars($comment['fullBody']));
                $comment['summary']  = nl2br(strip_tags($comment['summary']));
            } else {
                $comment['excerpt'] = false;
        
                $comment['fullBody'] = $comment['summary'] = nl2br(htmlspecialchars($comment['fullBody']));
            }
        
            #serendipity_plugin_api::hook_event('backend_view_comment', $comment, '&amp;serendipity[page]='. $page . $searchString);
            $class = 'serendipity_admin_list_item_' . (($i % 2 == 0 ) ? 'even' : 'uneven');
            if ($comment['status'] == 'pending' || $comment['status'] === 'confirm') {
                $class .= ' serendipity_admin_comment_pending'; 
            }
            $header_class = ($comment['status'] == 'pending' || $comment['status'] === 'confirm' ? 'serendipityAdminMsgNote serendipity_admin_comment_pending_header' : '');
        ?>
        <tr>
            <td class="<?php echo $header_class; ?>">
        <?php   if ($header_class=='serendipityAdminMsgNote serendipity_admin_comment_pending_header') { ?>
                    <img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="<?php echo serendipity_getTemplateFile('admin/img/admin_msg_note.png'); ?>" alt="" />
        <?php   }?>
                <a name="c<?php echo $comment['id'] ?>"></a>
                <?php echo ($comment['type'] == 'NORMAL' ? COMMENT : ($comment['type'] == 'TRACKBACK' ? TRACKBACK : PINGBACK )) . ' #'. $comment['id'] .', '. IN_REPLY_TO .' <strong><a href="' . $comment['entry_url'] . '">'. htmlspecialchars($comment['title']) .'</a></strong>, '. ON . ' ' . serendipity_formatTime('%b %e %Y, %H:%M', $comment['timestamp'])?>
            </td>
        </tr>
        <tr>
            <td class="serendipity_admin_list_item <?php echo $class ?>" id="comment_<?php echo $comment['id'] ?>">
                <table width="100%" cellspacing="0" cellpadding="3" border="0">
                    <tr>
                        <td width="40%"><strong><?php echo AUTHOR ?></strong>: <?php echo htmlspecialchars(serendipity_truncateString($comment['author'],30)) . $comment['action_author']; ?></td>
                        <td><strong><?php echo EMAIL ?></strong>:
                            <?php
                                if ( empty($comment['email']) ) {
                                    echo 'N/A';
                                } else {
                            ?>
                                    <a href="mailto:<?php echo htmlspecialchars($comment['email']) ?>" title="<?php echo htmlspecialchars($comment['email']) ?>"><?php echo htmlspecialchars(serendipity_truncateString($comment['email'],30)) ?></a>
                            <?php } ?>
                        <?php echo $comment['action_email']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="40%"><strong>IP</strong>:
                            <?php
                                if ( empty($comment['ip']) ) {
                                    echo '0.0.0.0';
                                } else {
                                    echo htmlspecialchars($comment['ip']);
                                }
                            ?>
                            <?php echo $comment['action_ip']; ?>
                            </td>
                        <td><strong><?php echo URL; ?></strong>:
                            <?php
                                if ( empty($comment['url']) ) {
                                    echo 'N/A';
                                } else {
                            ?>
                                    <a href="<?php echo htmlspecialchars($comment['url']) ?>" title="<?php echo htmlspecialchars($comment['url']) ?>" target="_blank"><?php echo htmlspecialchars(serendipity_truncateString($comment['url'],30)) ?></a>
                            <?php } ?>
                            <?php echo $comment['action_url']; ?>
                            </td>
                    </tr>
                    <tr>
                        <td width="40%">&nbsp;</td>
                        <td><strong><?php echo REFERER; ?></strong>:
                            <?php
                                if ( empty($comment['referer']) ) {
                                    echo 'N/A';
                                } else {
                            ?>
                                  <a href="<?php echo htmlspecialchars($comment['referer']) ?>" title="<?php echo htmlspecialchars($comment['referer']) ?>" target="_blank"><?php echo htmlspecialchars(serendipity_truncateString($comment['referer'],30)) ?></a>
                            <?php } ?>
                            <?php echo $comment['action_referer']; ?>
                            </td>
                    <tr>
                        <td style="border-top: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC" colspan="3">
                            <div id="<?php echo $comment['id'] ?>_summary"><?php echo $comment['summary'] ?></div>
                            <div id="<?php echo $comment['id'] ?>_full" style="display: none"><?php echo $comment['fullBody'] ?></div>
                        </td>
                    </tr>
                </table>
        <?php if (($comment['status'] == 'pending' || $comment['status'] === 'confirm') && !serendipity_db_bool($this->get_config('read_only'))) { ?>
                  <a href="?serendipity[action]=admin&amp;serendipity[adminModule]=comments&amp;serendipity[adminAction]=approve&amp;serendipity[id]=<?php echo $comment['id'] ?>&amp;<?php echo serendipity_setFormToken('url'); ?>" class="serendipityIconLink" title="<?php echo APPROVE; ?>"><img src="<?php echo serendipity_getTemplateFile('admin/img/accept.png'); ?>" alt="<?php echo APPROVE ?>" /><?php echo APPROVE ?></a>
        <?php } ?>
        <?php if ($comment['status'] == 'approved' && !serendipity_db_bool($this->get_config('read_only'))) { ?>
                  <a href="?serendipity[action]=admin&amp;serendipity[adminModule]=comments&amp;serendipity[adminAction]=pending&amp;serendipity[id]=<?php echo $comment['id'] ?>&amp;<?php echo serendipity_setFormToken('url'); ?>" class="serendipityIconLink" title="<?php echo SET_TO_MODERATED; ?>"><img src="<?php echo serendipity_getTemplateFile('admin/img/clock.png'); ?>" alt="<?php echo SET_TO_MODERATED ?>" /><?php echo SET_TO_MODERATED ?></a>
        <?php } ?>
        <?php if ($comment['excerpt']) { ?>
                  <a href="#c<?php echo $comment['id'] ?>" onclick="FT_toggle(<?php echo $comment['id'] ?>); return false;" title="<?php echo VIEW; ?>" class="serendipityIconLink"><img src="<?php echo serendipity_getTemplateFile('admin/img/zoom.png'); ?>" alt="<?php echo TOGGLE_ALL; ?>" /><span id="<?php echo $comment['id'] ?>_text"><?php echo TOGGLE_ALL ?></span></a>
        <?php } ?>
                  <a target="_blank" href="<?php echo $entrylink; ?>" title="<?php echo VIEW; ?>" class="serendipityIconLink"><img src="<?php echo serendipity_getTemplateFile('admin/img/zoom.png'); ?>" alt="<?php echo VIEW; ?>" /><?php echo VIEW ?></a>
                  <a href="?serendipity[action]=admin&amp;serendipity[adminModule]=comments&amp;serendipity[adminAction]=edit&amp;serendipity[id]=<?php echo $comment['id'] ?>&amp;serendipity[entry_id]=<?php echo $comment['entry_id'] ?>&amp;<?php echo serendipity_setFormToken('url'); ?>" title="<?php echo EDIT; ?>" class="serendipityIconLink"><img src="<?php echo serendipity_getTemplateFile('admin/img/edit.png'); ?>" alt="<?php echo EDIT; ?>" /><?php echo EDIT ?></a>
        <?php if (!serendipity_db_bool($this->get_config('read_only'))) { ?>
                  <a href="?serendipity[action]=admin&amp;serendipity[adminModule]=comments&amp;serendipity[adminAction]=delete&amp;serendipity[id]=<?php echo $comment['id'] ?>&amp;serendipity[entry_id]=<?php echo $comment['entry_id'] ?>&amp;<?php echo serendipity_setFormToken('url'); ?>" onclick='return confirm("<?php echo sprintf(COMMENT_DELETE_CONFIRM, $comment['id'], htmlspecialchars($comment['author'])) ?>")' title="<?php echo DELETE ?>" class="serendipityIconLink"><img src="<?php echo serendipity_getTemplateFile('admin/img/delete.png'); ?>" alt="<?php echo DELETE; ?>" /><?php echo DELETE ?></a>
        <?php } ?>
                  <a target="_blank" onclick="cf = window.open(this.href, 'CommentForm', 'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1'); cf.focus(); return false;" href="?serendipity[action]=admin&amp;serendipity[adminModule]=comments&amp;serendipity[adminAction]=reply&amp;serendipity[id]=<?php echo $comment['id'] ?>&amp;serendipity[entry_id]=<?php echo $comment['entry_id'] ?>&amp;serendipity[noBanner]=true&amp;serendipity[noSidebar]=true&amp;<?php echo serendipity_setFormToken('url'); ?>" title="<?php echo REPLY ?>" class="serendipityIconLink"><img src="<?php echo serendipity_getTemplateFile('admin/img/user_editor.png'); ?>" alt="<?php echo REPLY; ?>" /><?php echo REPLY ?></a>
                  <?php echo $comment['action_more']; ?>
            </td>
        </tr>
        <?php 
        }
        echo '</table>';
    }

    function showElementEntrylist($filter = array(), $limit = 0) {
        global $serendipity;

        $filter_sql = implode(' AND ', $filter);

        $orderby = 'timestamp DESC';
        // Fetch the entries
        $entries = serendipity_fetchEntries(
                     false,
                     false,
                     $limit,
                     true,
                     false,
                     $orderby,
                     $filter_sql
                   );

        $rows = 0;
        if (!is_array($entries)) {
            return;
        }

        foreach ($entries as $entry) {
            $rows++;
            // Find out if the entry has been modified later than 30 minutes after creation
            if ($entry['timestamp'] <= ($entry['last_modified'] - 60*30)) {
                $lm = '<a href="#" title="' . LAST_UPDATED . ': ' . serendipity_formatTime(DATE_FORMAT_SHORT, $entry['last_modified']) . '" onclick="alert(this.title)"><img src="'. serendipity_getTemplateFile('admin/img/clock.png') .'" alt="*" style="border: 0px none ; vertical-align: bottom;" /></a>';
            } else {
                $lm = '';
            }

            if (!$serendipity['showFutureEntries'] && $entry['timestamp'] >= serendipity_serverOffsetHour()) {
                $entry_pre = '<a href="#" title="' . ENTRY_PUBLISHED_FUTURE . '" onclick="alert(this.title)"><img src="'. serendipity_getTemplateFile('admin/img/clock_future.png') .'" alt="*" style="border: 0px none ; vertical-align: bottom;" /></a> ';
            } else {
                $entry_pre = '';
            }

            if (serendipity_db_bool($entry['properties']['ep_is_sticky'])) {
                $entry_pre .= ' ' . STICKY_POSTINGS . ': ';
            }

            if (serendipity_db_bool($entry['isdraft'])) {
                $entry_pre .= ' ' . DRAFT . ': ';
            }
?>
            <div class="serendipity_admin_list_item serendipity_admin_list_item_<?php echo ($rows % 2) ? 'even' : 'uneven'; ?>">

                <table width="100%" cellspacing="0" cellpadding="3">
                    <tr>
                        <td>
                            <strong><?php echo $entry_pre; ?><a href="?serendipity[action]=admin&amp;serendipity[adminModule]=entries&amp;serendipity[adminAction]=edit&amp;serendipity[id]=<?php echo $entry['id']; ?>" title="#<?php echo $entry['id']; ?>"><?php echo serendipity_truncateString(htmlspecialchars($entry['title']),50) ?></a></strong>
                        </td>
                        <td align="right">
                            <?php echo serendipity_formatTime(DATE_FORMAT_SHORT, $entry['timestamp']) . ' ' .$lm; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                echo POSTED_BY . ' ' . htmlspecialchars($entry['author']);
                if (count($entry['categories'])) {
                    echo ' ' . IN . ' ';
                    $cats = array();
                    foreach ($entry['categories'] as $cat) {
                        $caturl = serendipity_categoryURL($cat);
                        $cats[] = '<a href="' . $caturl . '">' . htmlspecialchars($cat['category_name']) . '</a>';
                    }
                    echo implode(', ', $cats);
                }
                $entry['link']         = serendipity_archiveURL($entry['id'], $entry['title'], 'serendipityHTTPPath', true, array('timestamp' => $entry['timestamp']));
                $entry['preview_link'] = '?serendipity[noBanner]=true&amp;serendipity[noSidebar]=true&amp;serendipity[action]=admin&amp;serendipity[adminModule]=entries&amp;serendipity[adminAction]=preview&amp;serendipity[id]=' . $entry['id'];
                ?>

                        </td>
                        <td align="right">
                            <?php if (serendipity_db_bool($entry['isdraft']) || (!$serendipity['showFutureEntries'] && $entry['timestamp'] >= serendipity_serverOffsetHour())) { ?>
                            <a target="_blank" href="<?php echo $entry['preview_link']; ?>" title="<?php echo PREVIEW . ' #' . $entry['id']; ?>" class="serendipityIconLink"><img src="<?php echo serendipity_getTemplateFile('admin/img/zoom.png'); ?>" alt="<?php echo PREVIEW; ?>" /><?php echo PREVIEW ?></a>
                            <?php } else { ?>
                            <a target="_blank" href="<?php echo $entry['link']; ?>" title="<?php echo VIEW . ' #' . $entry['id']; ?>" class="serendipityIconLink"><img src="<?php echo serendipity_getTemplateFile('admin/img/zoom.png'); ?>" alt="<?php echo VIEW; ?>" /><?php echo VIEW ?></a>
                            <?php } ?>
                            <a href="?serendipity[action]=admin&amp;serendipity[adminModule]=entries&amp;serendipity[adminAction]=edit&amp;serendipity[id]=<?php echo $entry['id']; ?>" title="<?php echo EDIT . ' #' . $entry['id']; ?>" class="serendipityIconLink"><img src="<?php echo serendipity_getTemplateFile('admin/img/edit.png'); ?>" alt="<?php echo EDIT; ?>" /><?php echo EDIT ?></a>
                        </td>
                    </tr>
                </table>
            </div>
<?php
        } // end entries output
    }

    function showElementDraft() {
        $lim = $this->get_config('limit_draft');
        if ($lim < 1) return;

        echo '<div class="dashboard dashboard_draft">';
        echo '<h3>' . DRAFT . '</h3>';

        $this->showElementEntrylist(array("e.isdraft = 'true'"), $lim);
        echo '</div>';
    }

    function compareVersion($newV, $actV) {
        $newV = explode('.', $newV);
        $actV = explode('.', $actV);
        $length = ( count($newV) < count($actV) ? count($newV) : count($actV) );

        for($i=0; $i < $length; $i++){
            if ($newV[$i] > $actV[$i]){
                return 1;
            }
        }
        return 0;
    }
    

    function CheckUpdate() {
        global $serendipity;
        if ($this->get_config('update') == 'none') {
            return;
        }
        $updateURL = 'https://raw.github.com/s9y/Serendipity/master/docs/RELEASE';

        $file = fopen($updateURL, 'r');
        if (!$file) {
            echo "PLUGIN_DASHBOARD_ERROR_URL";
            return;
        }
        $version=$this->get_config('update');
        while(!feof($file)){
            $line = fgets($file);

            if(preg_match('/^' . $version . ':(.+$)/', $line, $match)){
                $update_to_version = $match[1];
                $this->set_config('last_version', $update_to_version);
                if ($version == "stable"){
                    $url="http://prdownloads.sourceforge.net/php-blog/serendipity-" . $update_to_version . ".zip";
                }
                else {
                    if (date('H') >= 23 && date('i') >=42){
                        $day = date("d");
                    }
                    else {
                        $day = date("d") - 1;
                    }
                    $url="http://www.s9y.org/snapshots/s9y_". date("Ym") . $day . "2342.tar.gz";
                }
                if($this->compareVersion($update_to_version, $serendipity['version'])){
                    $u_text = '<div class="serendipity_admin_list_item serendipity_admin_list_item_even" id="notifier"> ';
                    $u_text .= PLUGIN_DASHBOARD_UPDATE_NOTIFIER . ' <a href="' . $url . '">' . $update_to_version . '</a>';
                    $u_text .= '</div>';
                    $this->set_config('update_text', $u_text);
                }
            }
        }
    }

    function showElementComments() {
        $lim = $this->get_config('limit_comments');
        if ($lim < 1) return;

        echo '<div class="dashboard dashboard_comments">';
        echo '<h3>' . COMMENT . '</h3>';
        $this->showElementcommentlist("AND status = 'approved'", $lim);
        echo '</div>';
    }
    
    function showElementCommentsPending() {
        $lim = $this->get_config('limit_comments_pending');
        if ($lim < 1) return;

        echo '<div class="dashboard dashboard_comments_pending">';
        echo '<h3>' . COMMENTS_FILTER_NEED_APPROVAL . '</h3>';

        $this->showElementcommentlist(" AND status IN ('pending','confirm')", $lim);
        echo '</div>';
    }

    function showUpdateNotifier() {
        global $serendipity;

        // If we didn't check today, do it now and remeber, that we did.
        if (($this->get_config('last_update') != date('Ymd'))){
            $this->set_config('last_update', date('Ymd'));
            $this->CheckUpdate(); // this will fill all needed config values
        }
        
        // Check if the last found update version is newer and tell it, if this is the case
        $newVersion = $this->get_config('last_version');
        if($this->compareVersion($newVersion, $serendipity['version'])){
            $eventData = '';
            serendipity_plugin_api::hook_event('plugin_dashboard_updater', $eventData, $newVersion);
            print '<div class="dashboard dashboard_update">';
            print '<h3> ' . PLUGIN_DASHBOARD_UPD . ' </h3>';
            $update_text = $this->get_config('update_text');
            print $update_text . $eventData;
            print '</div>';
        }
    }

    function showElementFuture() {
        $lim = $this->get_config('limit_future');
        if ($lim < 1) return;

        echo '<div class="dashboard dashboard_future">';
        echo '<h3>' . PLUGIN_DASHBOARD_FUTURE . '</h3>';
        
        $this->showElementEntrylist(array("e.isdraft != 'true' AND e.timestamp >= " . serendipity_serverOffsetHour()), $lim);
        echo '</div>';
    }

    function showElement($element) {
        switch($element) {
            case 'update':
                $this->ShowUpdateNotifier();
                break;
            case 'draft':
                $this->showElementDraft();
                break;
            case 'comments':
                $this->showElementComments();
                break;
            case 'comments_pending':
                $this->showElementCommentsPending();
                break;
            case 'future':
                $this->showElementFuture();
                break;
        }
        
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_frontpage_display':
                    $elements = explode(',', $this->get_config('sequence'));
                    
                    ob_start();
?>
<div class="dashboard_start">&nbsp;</div>
<script type="text/javascript">
function FT_toggle(id) {
    if ( document.getElementById(id + '_full').style.display == '' ) {
        document.getElementById(id + '_full').style.display='none';
        document.getElementById(id + '_summary').style.display='';
        document.getElementById(id + '_text').innerHTML = '<?php echo VIEW_FULL ?>';
    } else {
        document.getElementById(id + '_full').style.display='';
        document.getElementById(id + '_summary').style.display='none';
        document.getElementById(id + '_text').innerHTML = '<?php echo HIDE ?>';
    }
    return false;
}
function invertSelection() {
    var f = document.formMultiDelete;
    for (var i = 0; i < f.elements.length; i++) {
        if( f.elements[i].type == 'checkbox' ) {
            f.elements[i].checked = !(f.elements[i].checked);
            f.elements[i].onclick();
        }
    }
}
</script>

<?php
                    foreach($elements AS $element) {
                        $this->showElement($element);
                    }
                    $dashboard = ob_get_contents();
                    ob_end_clean();
                    
                    $eventData['more'] = $dashboard;
                    break;

                case 'css_backend':
                    $filename = 'dashboard.css';
                    $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
                    if (!$tfile || $tfile == $filename) {
                        $tfile = dirname(__FILE__) . '/' . $filename;
                    }
                    echo file_get_contents($tfile);
                    break;

            }
        }

        return true;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
