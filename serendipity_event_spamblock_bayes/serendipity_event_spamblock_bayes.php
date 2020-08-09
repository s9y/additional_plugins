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

class serendipity_event_spamblock_bayes extends serendipity_event {

	function introspect(&$propbag) {
		global $serendipity;


		$this->title = PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME;
		$propbag->add ( 'description', PLUGIN_EVENT_SPAMBLOCK_BAYES_DESC);
		$propbag->add ( 'name', $this->title);
		$propbag->add ( 'version', '1.0' );
		$propbag->add ( 'event_hooks', array ('frontend_saveComment' => true,
		                                     'backend_comments_top' => true,
		                                     'external_plugin' => true,
		                                     'backend_view_comment' => true,
                                             'xmlrpc_comment_spam' => true,
                                             'xmlrpc_comment_ham' => true,
                                             'js_backend' => true,
                                             'css_backend' => true,
                                             'backend_sidebar_admin_appearance' => true,
		                                     'backend_sidebar_entries_event_display_spamblock_bayes' => true,
		                                     ));
		$propbag->add ( 'groups', array ('ANTISPAM' ) );
		$propbag->add ( 'author', 'kleinerChemiker,  Malte Paskuda, based upon b8 by Tobias Leupold');
		$propbag->add('configuration', array(
			'method',
            'recycler'
			));
        $propbag->add('requirements',  array(
            'serendipity' => '2.1',
            'php'         => '7.0'
        ));
        $propbag->add('legal',    array(
            'services' => array(
            ),
            'frontend' => array(
                'All user data and metadata (IP address, comment fields) can be logged to database or file'
            ),
            'backend' => array(
            ),
            'cookies' => array(
            ),
            'stores_user_input'     => true,
            'stores_ip'             => true,
            'uses_ip'               => true
        ));

	}


    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'method':
            	$propbag->add('type', 'select');
            	$propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_METHOD);
            	$propbag->add('select_values', array(
            	                                    'moderate'   => PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_MODERATE,
            	                                    'block'      => PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_BLOCK,
            	                                    ));
            	$propbag->add('default', 'moderation');
            	break;
            case 'recycler':
            	$propbag->add('type', 'boolean');
            	$propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_RECYCLER);
            	$propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DESC);
            	$propbag->add('default', true);
            	break;
            default:
            	return false;
			}
		return true;
	}

	function generate_content(&$title) {
		$title = $this->title;
	}

    function install() {
        $this->setupDB();
    }

    function upgrade() {
        $this->setupDB();
    }

    function setupDB() {
        global $serendipity;
        # b8 needs to one table for the tokens
        $sql = 'CREATE TABLE IF NOT EXISTS b8_wordlist(
          token varchar(255) {PRIMARY} NOT NULL,
          count_ham int {UNSIGNED} default NULL,
          count_spam int {UNSIGNED} default NULL
        ) {UTF_8}';
        serendipity_db_schema_import($sql);

        switch ($serendipity['dbType']) {
            case 'mysql':
            case 'mysqli':
                $sql = "INSERT IGNORE INTO b8_wordlist (token, count_ham) VALUES ('b8*dbversion', 3);";
                serendipity_db_query($sql);
                $sql = "INSERT IGNORE INTO b8_wordlist (token, count_ham, count_spam) VALUES ('b8*texts', 0, 0);";
                serendipity_db_query($sql);
                
                # our recycler bin needs to copy the comments table
                $sql = "CREATE TABLE IF NOT EXISTS
                        {$serendipity['dbPrefix']}spamblock_bayes_recycler
                        LIKE
                        {$serendipity['dbPrefix']}comments";
                break;
            case 'sqlite':
            case 'sqlite3':
            case 'pdo-sqlite':
            case 'pdo-sqliteoo':
                $sql = "INSERT OR IGNORE INTO b8_wordlist (token, count_ham) VALUES ('b8*dbversion', 3);";
                serendipity_db_query($sql);
                $sql = "INSERT OR IGNORE INTO b8_wordlist (token, count_ham, count_spam) VALUES ('b8*texts', 0, 0);";
                serendipity_db_query($sql);

                # To get all column definitions we get the SQL used for creating the original table
                $sql = "SELECT sql FROM sqlite_master WHERE type = 'table' AND name = '{$serendipity['dbPrefix']}comments';";
                $sql = serendipity_db_query($sql);
                if (is_array($sql)) {
                    $sql = $sql[0][0];
                }
                $sql = str_replace("{$serendipity['dbPrefix']}comments", "{$serendipity['dbPrefix']}spamblock_bayes_recycler", $sql);
                if (strpos("sql", "NOT EXISTS") === false) {
                    $sql = str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $sql);
                }
                break;
            default:
                $sql = "CREATE TABLE IF NOT EXISTS
                    {$serendipity['dbPrefix']}spamblock_bayes_recycler
                    as SELECT * FROM
                    {$serendipity['dbPrefix']}comments ORDER BY id LIMIT 1 WITH NO DATA";
        }
    }

	function event_hook($event, &$bag, &$eventData, $addData = null) {
		global $serendipity;
		$hooks = &$bag->get('event_hooks');

		if (isset($hooks[$event])) {
			switch ($event) {
                case 'external_plugin':
                    switch ($eventData) {
                        case 'bayes_learncomment':
						    if (!serendipity_checkPermission('adminComments')) {
                                break;
                            }
							$category = $_REQUEST['category'];
							$ids = $_REQUEST['id'];
							$ids = explode(';', $ids);
							foreach($ids as $id) {
                                $databaseComment = $this->getComment($id)[0];
                                print_r($databaseComment);

                                $comment = $databaseComment['url'] . ' ' . $databaseComment['body'] . ' ' . $databaseComment['author'] . ' ' . $databaseComment['email'];

                                $this->learn($comment, $category);

                                //Ham shall be approved, Spam deleted
                                if ($category == 'ham') {
                                    serendipity_approveComment($id, $databaseComment['entry_id']);
                                }
                                if ($category == 'spam') {
                                    if ($this->get_config('recycler', true)) {
                                        $this->recycleComment($id, $databaseComment['entry_id']);
                                    }
                                    echo 'id: ';
                                    print_r($id);
                                    echo 'entry_id: ';
                                    print_r($databaseComment['entry_id']);
                                    serendipity_deleteComment($id, $databaseComment['entry_id']);
                                }
                            }
							break;
                        case 'bayes_recycle':
                            if (!serendipity_checkPermission('adminComments')) {
                                break;
                            }
                            if (!empty($_REQUEST['serendipity']['selected'])) {
                                $ids = array_keys($_REQUEST['serendipity']['selected']);
                            }
                            if (isset($_REQUEST['restore'])) {
                                if (!empty($ids)) {
                                    $this->restoreComments($ids);

                                    if (count($ids) > 1) {
                                        $msg = 'Comments '. implode(', ', $ids) .' restored';
                                    } else {
                                        $msg = 'Comment '. implode(', ', $ids) .' restored';
                                    }
                                    $msgtype = 'success';
                                } else {
                                    $msg = 'No comment selected';
                                    $msgtype = 'message';
                                }
                            }
                            
                            if (isset($_REQUEST['empty'])) {
                                $this->emptyRecycler();
                            }
                            
                            $redirect= '<meta http-equiv="REFRESH" content="0;url=';
                            $url = 'serendipity_admin.php?serendipity[adminModule]=event_display';
                            $url .= '&amp;serendipity[adminAction]=spamblock_bayes">';
                            echo $redirect . $url;
                            break;
                    }
                    break;
                    
				case 'frontend_saveComment':
					if (! is_array ( $eventData ) || serendipity_db_bool ( $eventData ['allow_comments'] )) {
						if (!isset($serendipity['csuccess'])) {
							$serendipity['csuccess'] = 'true';
						}

                        $comment = $addData['url'] . ' ' . $addData['comment'] . ' ' . $addData['name'] . ' ' . $addData['email'];

                        echo $this->rate($comment);
                        if ($this->rate($comment) > 0.8) {
                            $method = $this->get_config('method', 'moderate');
                            if ($method == 'moderate') {
                                $this->moderate($eventData, $addData);
                                return false;
                            } elseif($method == 'block') {
                                $this->block($eventData, $addData);
                                return false;
                            }
                        }
					}
					break;
                    
                case 'backend_view_comment':
                    $imgpath = $serendipity['baseURL'] . 'index.php?/plugin/';

                    $comment = $eventData['url'] . ' ' . $eventData['fullBody'] . ' ' . $eventData['name'] . ' ' . $eventData['email']; 

                    $eventData['action_more'] = '<ul id="bayes_actions" class="plainList clearfix actions">
                        <li>
                        <a
                        class="button_link spamblockBayesControls"
                        onclick="return ham('. $eventData['id'].');"
                        title="'. PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME . ': ' . PLUGIN_EVENT_SPAMBLOCK_BAYES_HAM .'"
                        ><span class="icon-ok-circled" aria-hidden="true"></span><span class="visuallyhidden"> ' . PLUGIN_EVENT_SPAMBLOCK_BAYES_HAM .'</span></a>
                        </li>
                        <li>
                        <a
                        class="button_link spamblockBayesControls"
                        onclick="return spam('. $eventData['id'] .');"
                        title="'. PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME . ': ' . PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAM .'"
                        ><span class="icon-cancel" aria-hidden="true"></span><span class="visuallyhidden"> ' . PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAM .'</span></a>
                        </li>
                        <li class="bayes_spamrating">
                        <span id="' . $eventData['id'] . '_rating"> ' . preg_replace('/\..*/', '', $this->rate($comment) * 100) . '%</span>
                        </li>
                    </ul>';
                    break;
                    
                case 'xmlrpc_comment_spam':
                    $entry_id = $addData['id'];
                    $comment_id = $addData['cid'];
                    $comment = eventData['url'] . ' ' . $eventData['body'] . ' ' . $eventData['name'] . ' ' . $eventData['email']; 
                    $this->learn($eventData, 'spam');
                    serendipity_deleteComment($comment_id, $entry_id);
 				    break;

                case 'xmlrpc_comment_ham':
                    $comment_id = $addData['cid'];
                    $entry_id = $addData['id'];
                    $comment = eventData['url'] . ' ' . $eventData['body'] . ' ' . $eventData['name'] . ' ' . $eventData['email'];
                    $this->learn($comment, 'ham'); 
                    //moderated ham-comments should be instantly approved, that's why they need an id:
                    serendipity_approveComment($comment_id, $entry_id);
				    break;

                case 'backend_sidebar_admin_appearance':
                    if (!serendipity_checkPermission('adminComments')) {
                        break;
                    }

                    echo '<li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks">
                        <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes">
                            '. PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME .'
                        </a>
                    </li>';
                    break;

                case 'backend_sidebar_entries_event_display_spamblock_bayes':
                    if (!serendipity_checkPermission('adminComments')) {
                        break;
                    }
                   
                    $this->displayRecycler();
                    break;

                    
                case 'js_backend':
                    echo "var learncommentPath = '{$serendipity['baseURL']}index.php?/plugin/bayes_learncomment';";
                    echo file_get_contents(dirname(__FILE__). '/bayes_commentlist.js');
                    break;
                    
                case 'css_backend':
                    echo '.spamblockBayesControls { cursor: pointer; }';
                    break;
				default :
					return false;
			}
            return true;
		} else {
			return false;
		}
	}

    # we init b8 in this function and not directly in the event hook, because in the event hook the SPL autoload gets triggered by smarty and fails
    function initB8() {
        global $serendipity;
        if ($this->$b8 === null) {
            require_once(dirname(__FILE__) . '/b8/b8.php');
            switch ($serendipity['dbType']) {
            case 'mysql':
            case 'mysqli':
                $config_b8      = [ 'storage'  => 'mysql' ];
                break;
            case 'sqlite':
            case 'sqlite3':
            case 'pdo-sqlite':
            case 'pdo-sqliteoo':
                $config_b8      = [ 'storage'  => 'sqlite' ];
                break;
            }
            
            $config_storage = [ 'resource' => $serendipity['dbConn'],
                    'table'    => 'b8_wordlist' ];
            $this->$b8 = new b8\b8($config_b8, $config_storage);
        }
    }

    # Return the bayes rating reflecting the spamminess of the comment string. 0: ham, 1: spam
    function rate($comment) {
        $this->initB8();
        return $this->$b8->classify($comment);
    }

    # Mark a comment text as ham or spam
    function learn($comment, $category) {
        $this->initB8();
        if ($category == 'ham') {
            $this->$b8->learn($comment, b8\b8::HAM);
        }
        if ($category == 'spam') {
            $this->$b8->learn($comment, b8\b8::SPAM);
        }
    }

    function block(&$eventData, &$addData) {
        global $serendipity;
        if ($this->get_config('recycler', true)) {
            $this->throwInRecycler($eventData, $addData);
        }
        $eventData['allow_comments'] = false;
        $serendipity['messagestack']['comments'][] = PLUGIN_EVENT_SPAMBLOCK_BAYES_ERROR;
    }

    function moderate(&$eventData, &$addData) {
        global $serendipity;
        $eventData['moderate_comments'] = true;
        $serendipity['csuccess']        = 'moderate';
        $serendipity['moderate_reason'] = sprintf(PLUGIN_EVENT_SPAMBLOCK_BAYES_MODERATE);
    }

    # id: id of a comment
	function getComment($id) {
        global $serendipity;

        $sql = "SELECT id, body, entry_id, author, email, url, ip, referer FROM {$serendipity['dbPrefix']}comments
                WHERE id = " . (int)$id;
        
        $comments = serendipity_db_query($sql, false, 'assoc');
        return $comments;
    }

    ### Recycler functionality ###

    function displayRecycler() {
        global $serendipity;
        $comments = $this->getAllRecyclerComments();
        if (is_array($comments[0])) {
            for ($i=0; $i < count($comments); $i++) {
                $databaseComment = $comments[$i];
                $comment = $databaseComment['url'] . ' ' . $databaseComment['body'] . ' ' . $databaseComment['author'] . ' ' . $databaseComment['email'];
                
                $databaseComment['article_link'] = serendipity_archiveURL($databaseComment['entry_id'], 'comments', 'serendipityHTTPPath', true);
                $databaseComment['article_title'] = $this->getEntryTitle($databaseComment['entry_id']);
                $comments[$i] = $databaseComment;

            }
        } else {
            $comments = array();
        }
        if (!is_object($serendipity['smarty'])) {
            serendipity_smarty_init();
        }
        $serendipity['smarty']->assign('comments', $comments);
        echo $this->parseTemplate('bayesRecyclermenu.tpl');
    }

    function getAllRecyclerComments() {
        global $serendipity;
        $sql = "SELECT * FROM {$serendipity['dbPrefix']}spamblock_bayes_recycler ORDER BY id DESC";
        $comments = serendipity_db_query($sql, false, 'assoc');

        return $comments;
    }

    //Empty the Recycler
    function emptyRecycler() {
        global $serendipity;
        $sql = "DELETE FROM
                {$serendipity['dbPrefix']}spamblock_bayes_recycler";
        return serendipity_db_query($sql);
    }

    //Get the blocked comment and store it in the recycler-table
    //Used when the comment is from a current happening event
    function throwInRecycler(&$ca, &$commentInfo) {
        global $serendipity;

        #code copied from serendipity_insertComment. Changed: $id and $status
        $id            = (int)$ca['id'];
        $type          = $commentInfo['type'];
        $email         = serendipity_db_escape_string($commentInfo['email']);
        if (isset($commentInfo['subscribe'])) {
            if (!isset($serendipity['allowSubscriptionsOptIn']) || $serendipity['allowSubscriptionsOptIn']) {
                $subscribe = 'false';
            } else {
                $subscribe = 'true';
            }
        } else {
            $subscribe = 'false';
        }
        //'approved' cause only relevant after recovery
        $dbstatus = 'approved';

        $title         = serendipity_db_escape_string($ca['title']);
        $comments      = $commentInfo['comment'];
        $ip            = serendipity_db_escape_string(isset($commentInfo['ip']) ? $commentInfo['ip'] : $_SERVER['REMOTE_ADDR']);
        $commentsFixed = serendipity_db_escape_string($commentInfo['comment']);
        $name          = serendipity_db_escape_string($commentInfo['name']);
        $url           = serendipity_db_escape_string($commentInfo['url']);
        $parentid      = (isset($commentInfo['parent_id']) && is_numeric($commentInfo['parent_id'])) ? $commentInfo['parent_id'] : 0;
        $status        = serendipity_db_escape_string(isset($commentInfo['status']) ? $commentInfo['status'] : (serendipity_db_bool($ca['moderate_comments']) ? 'pending' : 'approved'));
        $t             = serendipity_db_escape_string(isset($commentInfo['time']) ? $commentInfo['time'] : time());
        $referer       = substr((isset($_SESSION['HTTP_REFERER']) ? serendipity_db_escape_string($_SESSION['HTTP_REFERER']) : ''), 0, 200);

        $sql  = "INSERT INTO
                    {$serendipity['dbPrefix']}spamblock_bayes_recycler (entry_id, parent_id, ip, author, email, url, body, type, timestamp, title, subscribed, status, referer)
                    VALUES ('$id', '$parentid', '$ip', '$name', '$email', '$url', '$commentsFixed', '$type', '$t', '$title', '$subscribe', '$dbstatus', '$referer')";

        serendipity_db_query($sql);
    }

    function recycleComment($id, $entry_id) {
        global $serendipity;
        $sql  = "INSERT INTO
                    {$serendipity['dbPrefix']}spamblock_bayes_recycler (entry_id, parent_id, ip, author, email, url, body, type, timestamp, title, subscribed, status, referer)
                        SELECT
                            entry_id, parent_id, ip, author, email, url, body, type, timestamp, title, subscribed, status, referer
                        FROM
                            {$serendipity['dbPrefix']}comments
                        WHERE
                            id = '$id' AND entry_id = '$entry_id';";
        serendipity_db_query($sql);
    }



    function restoreComments($ids) {
        global $serendipity;

        if (is_array($ids)) {
            $sql = "INSERT INTO
                    {$serendipity['dbPrefix']}comments
                    (entry_id, parent_id, ip, author, email, url, body, type, timestamp, title, subscribed, status, referer)
                    SELECT
                    entry_id, parent_id, ip, author, email, url, body, type, timestamp, title, subscribed, status, referer
                    FROM
                    {$serendipity['dbPrefix']}spamblock_bayes_recycler
                    WHERE " . serendipity_db_in_sql ( 'id', $ids );
        } else {
            $sql = "INSERT INTO
                    {$serendipity['dbPrefix']}comments
                    (entry_id, parent_id, ip, author, email, url, body, type, timestamp, title, subscribed, status, referer)
                    SELECT
                    entry_id, parent_id, ip, author, email, url, body, type, timestamp, title, subscribed, status, referer
                    FROM
                    {$serendipity['dbPrefix']}spamblock_bayes_recycler
                    WHERE id = " . (int)$ids;
        }
        $result = serendipity_db_query($sql);
        $this->deleteFromRecycler($ids);
    }

    function deleteFromRecycler($ids) {
        global $serendipity;
        if (is_array($ids)) {
            $sql = "DELETE FROM
                    {$serendipity['dbPrefix']}spamblock_bayes_recycler
                    WHERE " . serendipity_db_in_sql ( 'id', $ids );
        } else {
            $sql = "DELETE FROM
                    {$serendipity['dbPrefix']}spamblock_bayes_recycler
                    WHERE id = " . (int)$ids;
        }
        return serendipity_db_query($sql);
    }

    function getEntryTitle($id) {
        global $serendipity;
        $sql = "SELECT title FROM {$serendipity['dbPrefix']}entries WHERE id = '$id'";
        $title = serendipity_db_query($sql, true, "assoc");
        $title = $title['title'];
        return $title;
    }

}
