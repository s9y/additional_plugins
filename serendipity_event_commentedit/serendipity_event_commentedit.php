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

class serendipity_event_commentedit extends serendipity_event
{
    var $title = PLUGIN_EVENT_COMMENTEDIT_NAME;
    
    
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_COMMENTEDIT_NAME);
        $propbag->add('description',   PLUGIN_EVENT_COMMENTEDIT_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Malte Paskuda');
        $propbag->add('requirements',  array(
            'serendipity' => '1.5',
            'php'         => '5.2.0'
        ));
        $propbag->add('version',       '0.2.3');
        $propbag->add('event_hooks',   array(
        	'frontend_saveComment_finish'               => true,
        	'fetchcomments'                           => true,
        	'frontend_header'                            => true,
        	'external_plugin'                            => true
        ));
        $propbag->add('groups', array('FRONTEND_VIEWS'));

        $propbag->add('configuration', array('path',
                                             'timeout',
                                             'mail'
                                             )
                                        );
        
        if (!$serendipity['capabilities']['jquery']) {
	        $this->dependencies = array('serendipity_event_jquery' => 'remove');
		}
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;

        switch($name) {
            case 'path':
                    $propbag->add('type', 'string');
                    $propbag->add('name', PLUGIN_EVENT_COMMENTEDIT_PATH);
                    $propbag->add('description', PLUGIN_EVENT_COMMENTEDIT_PATH_DESC);
                    $propbag->add('default', $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_commentedit/');
                    return true;
                    break;
            case 'timeout':
                    $propbag->add('type', 'string');
                    $propbag->add('name', PLUGIN_EVENT_COMMENTEDIT_TIMEOUT);
                    $propbag->add('description', PLUGIN_EVENT_COMMENTEDIT_TIMEOUT_DESC);
                    $propbag->add('default', '300');
                    return true;
                    break;
            case 'mail':
                    $propbag->add('type', 'boolean');
                    $propbag->add('name', PLUGIN_EVENT_COMMENTEDIT_MAIL);
                    $propbag->add('description', PLUGIN_EVENT_COMMENTEDIT_MAIL_DESC);
                    $propbag->add('default', false);
                    return true;
                    break;
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            if ($timeout === null) {
                $timeout = $this->get_config('timeout', '300');
            }
            if ($path === null) {
                $path = $this->get_config('path', '');
            }
            if (!empty($path) && $path != 'default' && $path != 'none' && $path != 'empty') {
                $path_defined = true;
            } else {
                $path_defined = false;
            }
            if ($mail == null) {
                $mail = $this->get_config('mail', false);
            }
            
            switch($event) {
                case 'external_plugin':
                    switch($eventData) {
                        case 'commentedit.js':
                            header('Content-Type: text/javascript');
                            echo file_get_contents(dirname(__FILE__). '/serendipity_event_commentedit.js');
                            break;
                        case 'jquery.jeditable.js':
                            header('Content-Type: text/javascript');
                            echo file_get_contents(dirname(__FILE__). '/jquery.jeditable.js');
                            break;
                        case 'commentedit':
                            global $serendipity;
                            //the js sent us the comment and an id json-encrypted,
                            //so they are named
                            $comment = $_REQUEST['comment'];
                            $comment_id = $_REQUEST['cid'];
                            $entry_id = $_REQUEST['entry_id'];
                            
                            //Break when comment_id !=> session
                            if ($this->get_cached_commentid($timeout) == $comment_id) {
                                $this->editComment($comment_id, $comment, $entry_id);
                                $data = array('comment' => $comment);
                                serendipity_plugin_api::hook_event('frontend_display', $data);
                                //send mail with edit-notification to blogowner, only if normal notification is enabled and config, too
                                if ($serendipity['mail_comments'] == 1 && $mail) {
                                    serendipity_sendMail($serendipity['email'], 'Comment ' . $comment_id . ' edited' , 'New comment: ' . $comment, $serendipity['blogMail']);
                                }
                                echo $data['comment'];
                            }
                            
                            break;

                        case 'commentedit_load':
                            //load a comment from the db
                            $comment = $this->getComment($_REQUEST['cid'], $_REQUEST['entry_id']);
                            echo $comment[0]['body'];
                            break;
                        case 'commentedit_time':
                            //echo the remaining time
                            if($_SESSION['comment_made_time'] > time() - $timeout) {
                                echo $_SESSION['comment_made_time'] + $timeout - time();
                            } else {
                                echo 0;
                            }
                            break;
                        case 'commentedit_language':
                            $language=array('editlink' => EDIT,
                                            'edittooltip' => PLUGIN_EVENT_COMMENTEDIT_EDITTOOLTIP,
                                            'edittimer' => PLUGIN_EVENT_COMMENTEDIT_EDITTIMER,
                                            'editsubmit' => SAVE,
                                            'editcancel' => ABORT_NOW
                                            );
                            //For json to work, the strings has to be utf8-encoded
                            echo json_encode(array_map(utf8_encode, $language));
                            break;
                    }
                    return true;
                    break;
                    
                case 'frontend_saveComment_finish':
                    //save corresponding sessionid because we later fetch a comment
                    //and check if the current session_id() belongs to the comment_cid
                    $this->cache_commentid($addData['comment_cid']);
                    return true;
                    break;
                    
                case 'fetchcomments':
                    $postBase = false;
                    $cids = array();
                    foreach($eventData as $comment) {
                        if ($this->get_cached_commentid($timeout) == $comment['id']) {
                            //we now know that the comment is from the
                            //user and created within the last minutes, 
                            //so add comment_id
                            $cids[] = $comment['id'];
                            $postBase = true;
                        }
                    }
                    
                    if ($postBase) {
                        //cebase is used for the POST of the edited
                        //comment to the external_plugin-call
                        echo '<script>var cebase = "'. $serendipity['baseURL'] .'index.php?/plugin/";</script>';
  
                        foreach($cids as $cid) {
                            //add edit-ability:
                            echo '<script>makeEditable(' . $comment['id'] . ','. $eventData['0']['entry_id'] .') </script>' . "\n";
                        }
                    }
                    return true;
                    break;
              
                case 'frontend_header':
                    if($path_defined) {
                        echo '<script type="text/javascript" src="' . $path . 'jquery.jeditable.js"></script>' . "\n";
                        echo '<script type="text/javascript" src="' . $path . 'serendipity_event_commentedit.js"></script>' . "\n";
                    } else {
                        echo '<script type="text/javascript" src="' . $serendipity['baseURL'] . 'index.php?/plugin/jquery.jeditable.js"></script>' . "\n";
                        echo '<script type="text/javascript" src="' . $serendipity['baseURL'] . 'index.php?/plugin/commentedit.js"></script>' . "\n";
                    }
                default:
                    return false;
            }
        } else {
            return false;
        }
    }

    /*
     * Get id of the comment in the session
     * @param timeout time to edit in seconds
     * */
    function get_cached_commentid($timeout) {
        if ($_SESSION['comment_made_time'] > time() - $timeout) {
    	    return $_SESSION['comment_made'];
        } else {
            return false;
        }
    }
    
    /*
     * Save which commentid belongs to this session
     * data: commentid
     * */
    function cache_commentid($commentid) {
        $_SESSION['comment_made'] = $commentid;
        $_SESSION['comment_made_time'] = time();
    }

    function editComment($comment_id, $comment, $entry_id) {
        global $serendipity;
        $sql = "UPDATE {$serendipity['dbPrefix']}comments
                    SET
                        body      = '" . $comment . "'
            WHERE id = " . (int)$comment_id . " AND
                  entry_id = " . (int)$entry_id;
        serendipity_db_query($sql);
    }

    function getComment($comment_id, $entry_id) {
        global $serendipity;
        $sql = "SELECT body FROM {$serendipity['dbPrefix']}comments
            WHERE id = " . (int)$comment_id . " AND
                  entry_id = " . (int)$entry_id;
        return serendipity_db_query($sql);
    }

    function debugMsg($msg) {
        global $serendipity;

        $this->debug_fp = @fopen($serendipity['serendipityPath'] . 'templates_c/commentedit.log', 'a');
        if (!$this->debug_fp) {
            return false;
        }

        if (empty($msg)) {
            fwrite($this->debug_fp, "failure \n");
        } else {
            fwrite($this->debug_fp, print_r($msg, true));
        }
        fclose($this->debug_fp);
    }
}

/* vim: set sts=4 ts=4 expandtab :
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * indent-tabs-mode: nil
 * End:
*/
