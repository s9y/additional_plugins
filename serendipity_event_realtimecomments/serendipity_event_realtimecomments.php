<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_realtimecomments extends serendipity_event {
    var $title = PLUGIN_EVENT_REALTIMECOMMENTS_NAME;
    var $interval = 10;
    
    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_REALTIMECOMMENTS_NAME);
        $propbag->add('description',   PLUGIN_EVENT_REALTIMECOMMENTS_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Malte Paskuda');
        $propbag->add('version',       '0.1.2');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8'
        ));
        $propbag->add('event_hooks',   array(
                                            'frontend_comment'              => true,
                                            'external_plugin'               => true,
                                            'frontend_saveComment_finish'   => true
        ));
        $propbag->add('groups', array('FRONTEND_VIEWS'));

        $propbag->add('configuration', array('path',
                                             'interval'
                                             )
                                        );

        if (!$serendipity['capabilities']['jquery']) {
	        $this->dependencies = array('serendipity_event_jquery' => 'remove');
		}
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function install() {
        $this->setupDB();
    }


    function introspect_config_item($name, &$propbag) {
        global $serendipity;

        switch($name) {
            case 'path':
                    $propbag->add('type', 'string');
                    $propbag->add('name', PLUGIN_EVENT_REALTIMECOMMENTS_PATH);
                    $propbag->add('description', PLUGIN_EVENT_REALTIMECOMMENTS_PATH_DESC);
                    $propbag->add('default', $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_realtimecomments/');
                    return true;
                    break;
            case 'interval':
                    $propbag->add('type', 'string');
                    $propbag->add('name', PLUGIN_EVENT_REALTIMECOMMENTS_INTERVAL);
                    $propbag->add('description', PLUGIN_EVENT_REALTIMECOMMENTS_INTERVAL_DESC);
                    $propbag->add('default', '10');
                    return true;
                    break;
            }
    }


    function event_hook($event, &$bag, &$eventData, &$addData) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'external_plugin':
                    switch($eventData) {
                        case 'rtcomments.js':
                            header('Content-Type: text/javascript');
                            echo file_get_contents(dirname(__FILE__). '/rtcomments.js');
                            break;

                        case 'rtcomments_pull':
                            $entry_id = $_REQUEST['entryId'];
                            if ($this->hasNewComment($entry_id, time())) {
                                $comments = $this->getNewComments($entry_id);
                                $old_raw_mode = $serendipity['smarty_raw_mode'];
                                $serendipity['smarty_raw_mode'] = true; // Force output of Smarty stuff
                                serendipity_smarty_init();
                                #existing parent_id crashes the smarty-fetch
                                $comments_code = serendipity_printComments($comments, VIEWMODE_LINEAR);
                                $serendipity['smarty_raw_mode'] = $old_raw_mode;
                                
                                echo $comments_code;
                            }
                            break;
                        }
                    return true;
                    break;
                case 'frontend_comment':
                    if (!empty($path) && $path != 'default' && $path != 'none' && $path != 'empty') {
                        $path_defined = true;
                    } else {
                        $path_defined = false;
                    }
                    #it should be enough to set this only here, since
                    #it's the first thing happening on the site concerning the plugin
                    $this->interval = $this->get_config('interval', 10);
                    if($path_defined) {
                        echo '<script type="text/javascript" src="' . $path . 'rtcomments.js"></script>' . "\n";
                        echo '<script>var rtcbase = "'. $serendipity['baseURL'] .'index.php?/plugin/";
                        var rtcinterval = '. $this->interval .';
                        var rtcreply = '. REPLY .';</script>';
                    } else {
                        echo '<script type="text/javascript" src="' . $serendipity['baseURL'] . 'index.php?/plugin/rtcomments.js"></script>' . "\n";
                        echo '<script>var rtcbase = "'. $serendipity['baseURL'] .'index.php?/plugin/";
                        var rtcinterval = '. $this->interval .';
                        var rtcreply = "'. REPLY .'";</script>';
                    }
                    return true;
                    break;
                case 'frontend_saveComment_finish':
                    $this->addNewComment($eventData['id'], $addData['comment_cid'], time()); 
                    return true;
                    break;
                default:
                    return false;
            }
        } else {
            return false;
        }
    }

    function setupDB() {
        global $serendipity;
        $sql = "CREATE TABLE {$serendipity['dbPrefix']}rtcomments_comments (
                          timestamp int(10) UNSIGNED default NULL,
                          entry_id int(10) UNSIGNED NOT NULL default '0',
                          comment_id int(10) UNSIGNED NOT NULL default '0'
                          )";
        serendipity_db_query($sql);

    }

    #if entry has an observer, let him see this in his next pull
    function notify($entry_id, $comment_id, $timestamp) {
        
    }

    #Return true if entry has a new comment
    function hasNewComment($entry_id, $timestamp) {
        global $serendipity;
        #remove comments who weren't delivered in the last interval (*2 to prevent races)
        $this->cleanComments($timestamp - ($this->interval*2));
        $sql = "SELECT entry_id FROM
                    {$serendipity['dbPrefix']}rtcomments_comments
                WHERE
                    entry_id = $entry_id";
        $comments = serendipity_db_query($sql);
        if(empty($comments[0])) {
            return false;
        } else {
            return true;
        }
    }

    function addNewComment($entry_id, $comment_id, $timestamp) {
        global $serendipity;
        $sql = "INSERT INTO
                    {$serendipity['dbPrefix']}rtcomments_comments
                    (entry_id, comment_id, timestamp)
                VALUES($entry_id, $comment_id, $timestamp)";
        serendipity_db_query($sql);
    }

    function getNewComments($entry_id) {
        global $serendipity;
        $sql = "SELECT comment_id FROM
                    {$serendipity['dbPrefix']}rtcomments_comments
                WHERE
                    entry_id = $entry_id";
        $comment_id_arrays = serendipity_db_query($sql);
        $comment_ids = array();
        foreach($comment_id_arrays as $comment_id) {
            $comment_ids[] = $comment_id[0];
        }
        return  $this->getComment($comment_ids, $entry_id);

    }

    function cleanComments($timestamp) {
        global $serendipity;
        $sql = "DELETE FROM
                     {$serendipity['dbPrefix']}rtcomments_comments
                WHERE
                    timestamp < $timestamp";
        serendipity_db_query($sql);
    }

    #id: array of ids or a single id
	function getComment($id, $eid) {
        global $serendipity;
        
        if(is_array($id)) {
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}comments
                WHERE " . serendipity_db_in_sql ( 'id', $id ) ." AND status = 'approved'";
        } else {
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}comments
                WHERE id = " . (int)$id ." AND status = 'approved'";
        }
        $comments = serendipity_db_query($sql);
        
        return $comments;
    }
    
    function debugMsg($msg) {
		global $serendipity;
		
		$this->debug_fp = @fopen ( $serendipity ['serendipityPath'] . 'templates_c/realtimecomments.log', 'a' );
		if (! $this->debug_fp) {
			return false;
		}
		
		if (empty ( $msg )) {
			fwrite ( $this->debug_fp, "failure \n" );
		} else {
			fwrite ( $this->debug_fp, print_r ( $msg, true ) );
		}
		fclose ( $this->debug_fp );
	}

}

/* vim: set sts=4 ts=4 expandtab : */
