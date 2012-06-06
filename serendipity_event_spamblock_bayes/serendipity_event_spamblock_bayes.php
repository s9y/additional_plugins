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
	var $lastRating;
	//store serendipity[GET] when loading the menu for later use in the
	//menu itself
	var $get;
    var $trojaUrl = "foo.ptlx.de:8124/";


    //Stores the needed structure of the comment (e.g. $comment['author'] shall store the name of the author, like s9y_comments)
	var $type = array(  'ip'        => 'ip',
                        'referrer'  => 'referer',
	                    'email'     => 'email',
	                    'url'       => 'url',
                        'name'      => 'author',
	                    'body'      => 'body'
	                    );
    var $path;
	                    
	function introspect(&$propbag) {
		global $serendipity;
		
		
		$this->title = PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME;
		$propbag->add ( 'description', PLUGIN_EVENT_SPAMBLOCK_BAYES_DESC);
		$propbag->add ( 'name', $this->title);
		$propbag->add ( 'version', '0.4.9.5' );
		$propbag->add ( 'event_hooks', array ('frontend_saveComment' => true,
		                                     'backend_spamblock_comments_shown' => true,
		                                     'external_plugin' => true,
		                                     'backend_view_comment' => true,
		                                     'backend_comments_top' => true,
		                                     'backend_sendcomment' => true,
		                                     'backend_sidebar_entries' => true,
		                                     'backend_sidebar_entries_event_display_spamblock_bayes' => true,
                                             'xmlrpc_comment_spam' => true,
                                             'xmlrpc_comment_ham' => true,
		                                     ));
		$propbag->add ( 'groups', array ('ANTISPAM' ) );
		$propbag->add ( 'author', 'kleinerChemiker,  Malte Paskuda, based upon b8 by Tobias Leupold');
		$propbag->add('configuration', array(
			'method',
			'moderateBarrier',
			'blockBarrier',
			'autolearn',
			'ignore',
            'menu',
            'recycler',
            'recyclerdelete',
            'emptyAll',
			'path',
			'logtype',
            'logfile'
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
            	                                    'custom'     => PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_CUSTOM,
            	                                    ));
            	$propbag->add('default', 'moderation');
            	break;
            case 'moderateBarrier':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_MODERATE);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_MODERATE_DESC);
                $propbag->add('default', 70);
                break;
            case 'blockBarrier':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_BLOCK);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_BLOCK_DESC);
                $propbag->add('default', 90);
                break;
            case 'autolearn':
            	$propbag->add('type', 'boolean');
            	$propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_BAYES_AUTOLEARN);
            	$propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BAYES_AUTOLEARN_DESC);
            	$propbag->add('default', false);
            	break;
            case 'menu':
            	$propbag->add('type', 'boolean');
            	$propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU);
            	$propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_DESC);
            	$propbag->add('default', true);
            	break;
            case 'recycler':
            	$propbag->add('type', 'boolean');
            	$propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_RECYCLER);
            	$propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DESC);
            	$propbag->add('default', true);
            	break;
            case 'recyclerdelete':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DELETE);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DELETE_DESC);
                $propbag->add('default', '');
                return true;
                break;
            case 'emptyAll':
            	$propbag->add('type', 'boolean');
            	$propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_EMPTY_ALL);
            	$propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_EMPTY_ALL_DESC);
            	$propbag->add('default', false);
            	break;
            case 'path':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_BAYES_PATH);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BAYES_PATH_DESC);
                $propbag->add('default', $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_spamblock_bayes/');
                return true;
                break;
            case 'logfile':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGFILE);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGFILE_DESC);
                $propbag->add('default', $serendipity['serendipityPath'] . 'spamblock-bayes.log');
                break;
            case 'logtype':
                $propbag->add('type', 'radio');
                $propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_DESC);
                $propbag->add('default', 'none');
                $propbag->add('radio',         array(
                    'value' => array('file', 'db', 'none'),
                    'desc'  => array(PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_FILE, PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_DB, PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_NONE)
                ));
                $propbag->add('radio_per_row', '1');
                break;
            case 'ignore':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_BAYES_IGNORE);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BAYES_IGNORE_DESC);
                $propbag->add('default', '');
                return true;
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
	
	function learnFromOld() {
	    global $serendipity;

		//approved comments are ham
		$sql = "SELECT
                    author,email,url,body,ip,referer
                FROM
                    {$serendipity['dbPrefix']}comments
                WHERE
                    status = 'approved'
                LIMIT 100;";
		$ham_comments = serendipity_db_query ( $sql );
        if (is_array($ham_comments[0])) {
            foreach ($ham_comments as $comment) {
                $this->startLearn($comment, 'ham');
            }
        }
        //maybe unset helps against the ram-issue
        unset($ham_comments);
        
		//learn via the spamblock-log what is spam:
		$sql = "SELECT
                    author,email,url,body,ip,referer
                FROM
                    {$serendipity['dbPrefix']}spamblocklog
                WHERE
                    type = 'REJECTED'
                LIMIT 100;";
		$spam_comments = serendipity_db_query ( $sql );
        
        if (is_array($spam_comments[0])) {
            foreach ($spam_comments as $comment) {
                $this->startLearn($comment, 'spam');
            }
        }
	}

    /*
    * get ratings of every part of the comment and combine
    * Wrapper for classify()
    */
	function startClassify($comment) {
	    $divider = 0;
	    $ratings = array();
	    $types = array_keys($this->type);
	    foreach($types as $type) {
            $rating = $this->classify($comment[$this->type[$type]], $this->type[$type]);
            if (is_numeric($rating)) {
                $ratings[] = $rating;
                $divider++;
            }
        }
        #catch error when failing to rate anything
        if (empty($ratings)) {
            return 0;
        }
        if($this->get_config('method', 'moderate') == 'custom') {
            $spamBarrier = max(array(
                                $this->get_config('moderateBarrier', 70) / 100,
                                $this->get_config('blockBarrier', 90) / 100
                                ));
        } else {
            $spamBarrier = 0.9;
        }

        #If a field is clearly spam, a spammer probably mixed
        #its spam with valid content to fool the spamfilter.
        $max_ratings = array();
        $min_ratings = array();
        foreach ($ratings as $rating) {
            if ($rating >= $spamBarrier) {
                $max_ratings[] = $rating;
            }
            if ($rating <= 0.1) {
                $min_ratings[] = $rating;
            }
        }
        if (count($max_ratings) > count($min_ratings)) {
            return max($ratings);
        }
        
        return (array_sum($ratings) / $divider);
    }

    #Wrapper to call learn()
    function startLearn($comment, $category) {
        $types = array_keys($this->type);
        foreach ($types as $type) {
            $this->learn($comment[$this->type[$type]], $category, $this->type[$type]);
        }
    }

    
	/*
     * classify a string in the boundaries of 0 (ham) to 1 (spam)
     * */
	function classify($comment = '', $type) {
	    global $serendipity;
	    $ignore = explode(',', $this->get_config('ignore', ''));
	    if (in_array($type, $ignore)) {
            //we ignore fields on the ignorelist
            return;
        }
		$spam_texts = $this->get_config("{$type}_spam", 0);
		$ham_texts = $this->get_config("{$type}_ham", 0);

		if ($comment == '' && ! is_string($comment)) {
			return false;
		}
		if ($spam_texts == 0 || $ham_texts == 0) {
			return false;
		}
    
		if ($type == $this->type['ip']) {
            $tokens = array($comment => 1);
		} else {
		    $tokens = $this->tokenize($comment);
        }

		if ($tokens === false|| empty($tokens)) {
			return false;
		}
		$words = array_keys($tokens);
		foreach ($words AS $word) {
			$temp[] = '\'' . serendipity_db_escape_string($word) . '\'';
		}
		#Die gespeicherten Werte der Tokens aus DB holen
		$sql = 'SELECT token, ham, spam FROM ' . $serendipity ['dbPrefix'] . 'spamblock_bayes WHERE ' . serendipity_db_in_sql ( 'token', $temp ) .' AND type = \''. $type .'\'';
		unset ($temp);
		$stored_tokens = serendipity_db_query ( $sql, FALSE, 'assoc', FALSE, 'token' );
		foreach($tokens as $word => $count) {
			$word_count[$word] = $count;
			if (!isset($stored_tokens[$word])) {
				$rating = 1;
			} else if (empty($word)) {
			    continue;
            } else {
				$rating = ($stored_tokens[$word]['ham'] / $ham_texts) / (($stored_tokens[$word]['ham'] / $ham_texts) + ($stored_tokens[$word]['spam'] / $spam_texts));
			}

			$ratings[$word] = (0.15 + (($stored_tokens[$word]['ham'] + $stored_tokens[$word]['spam']) * $rating)) / (0.3 + $stored_tokens[$word]['ham'] + $stored_tokens[$word]['spam']);

			# Importance (distance to 0.5)
			$importance[$word] = abs(0.5 - $ratings[$word]);

		}

		//importance can be null if the comment don't contains real tokens
		//(like the smiley :) )
		if (is_array($importance)) {
		    arsort($importance);
		    reset($importance);
        }

        #number of important words
        $n = 0;
        $probability = 0;

        foreach($tokens as $word => $count) {
            if ($importance[$word] > 0.2) {
                $n++;
                $probability += $ratings[$word];
            }
        }

        if ( $n > 0 ) {
            $probability = $probability / $n;
        } else {
            // was: = 1, but if undecided, we better want to be at
            // "undecided" than "ham"
            $probability = 0.5;
        }
        return abs(1 - $probability);
	}
	
	/*
     * learn string as ham or spam
     * $text: string 
     * $category: string  (ham, spam)
     * $type: string (ip, body, ...)
     **/
	function learn($text, $group, $type) {
		global $serendipity;
		$this->setupDB();
		if ($group != 'ham' && $group != 'spam') {
			return FALSE;
		}
		if ($text == '' or ! is_string ($text)) {
			return FALSE;
		}
		#split text in tokens
		if ($type == $this->type['ip']) {
		    $tokens = array( $text => 1);
        } else {
            $tokens = $this->tokenize($text);
        }
		$words = array_keys($tokens);
		
		foreach ($words AS $word) {
			$temp[] = '\'' . serendipity_db_escape_string($word) . '\'';
		}
		#get already saved value of tokens
		$sql = 'SELECT token, ' . $group . ' FROM ' . $serendipity ['dbPrefix'] . 'spamblock_bayes WHERE ' . serendipity_db_in_sql('token', $temp) . 'AND type = \'' . $type . '\' ';
		unset ($temp);
		$stored_values = serendipity_db_query ( $sql, FALSE, 'assoc', FALSE, 'token', $group );
		
		#Save new amount of all tokens
		foreach ($tokens as $token => $value) {
			if (isset ($stored_values [$token])) {
				$new_value [$token] = $stored_values [$token] + $value;
                if ($serendipity['dbType'] == 'mysql') {
                    $sql = "INSERT INTO
                        {$serendipity[dbPrefix]}spamblock_bayes
                            (token, $group, type)
                    VALUES('$token', $value, '$type')
                    ON DUPLICATE KEY 
                        UPDATE 
                            $group = $group + VALUES($group);";
                } else {
                    $sql = "UPDATE 
                            {$serendipity[dbPrefix]}spamblock_bayes
                            SET
                                $group = $group + $value 
                            WHERE
                                token = '$token' AND type = '$type';";
                }
			} else {
				$new_value [$token] = $value;
                if ($serendipity['dbType'] == 'mysql') {
                    $sql = "INSERT INTO
                        {$serendipity[dbPrefix]}spamblock_bayes
                            (token, $group, type)
                    VALUES('$token', $value, '$type')
                    ON DUPLICATE KEY 
                        UPDATE 
                            $group = $group + VALUES($group);";
                } else {
                    $sql = "INSERT INTO
                                {$serendipity[dbPrefix]}spamblock_bayes
                                    (token, $group, type)
                             VALUES('$token', $value, '$type')";
                }
			}
            serendipity_db_query ($sql);
		}
		
		#Save amount of ham/spam
		$this->set_config("{$type}_{$group}", $this->get_config("{$type}_{$group}", 0) + 1);
		
		return true;
	}
	
	/*
     * Split text in words
     * param1: string $text
     * return: array Tokens
     **/
	function tokenize($text = '') {
		if ($text == '' or ! is_string($text)) {
			return false;
		}

        //preg_split won't accept e.g. Umlaute as part of \w
        mb_regex_encoding('UTF-8'); 
        $tokens = mb_split("\W", $text );
        #preg_match_all('/[\w]+/u', "aaaÂ´bbb", $words);

		$temp = array ();
		foreach ( $tokens as $token ) {
			if (isset ( $temp ["$token"] )) {
				$temp ["$token"] ++;
			} else {
				$temp ["$token"] = 1;
			}
		}
		#prevent the whitespaces to get saved in the database, they
		#would displace more important markers
		if (isset($temp[""])) {
            unset($temp[""]);
        }
		return $temp;
	}
    
	function getAmount($category, $type) {
	    global $serendipity;
        $sql = "SELECT $category FROM
                    {$serendipity['dbPrefix']}spamblock_bayes
                WHERE
                    type = '$type'";
        $ratings = serendipity_db_query($sql);
        $amount = 0;
        if (is_array($ratings)) {
            foreach($ratings as $rating) {
                $amount += $rating[0];
            }
        }
        return $amount;
    }
	
	/**
	 * initialize the db at first install or change after upgrade
	 * */
	function setupDB() {
	    global $serendipity;
        #main-table
		$sql = "CREATE TABLE
                    {$serendipity['dbPrefix']}spamblock_bayes (
                    token VARCHAR(100) NOT NULL,
                    ham BIGINT UNSIGNED NOT NULL DEFAULT '0',
                    spam BIGINT UNSIGNED NOT NULL DEFAULT '0',
                    type VARCHAR(20) DEFAULT '{$this->type['body']}'
                    ) {UTF_8};";
		serendipity_db_schema_import($sql);
        #recycler-table
        if ($serendipity['dbType'] == 'mysql') {
            $sql = "CREATE TABLE IF NOT EXISTS
                    {$serendipity['dbPrefix']}spamblock_bayes_recycler
                    LIKE
                    {$serendipity['dbPrefix']}comments";
        } else {
            $sql = "CREATE TABLE
                    {$serendipity['dbPrefix']}spamblock_bayes_recycler
                    as SELECT * FROM
                    {$serendipity['dbPrefix']}comments LIMIT 1";
            serendipity_db_query($sql);
            $sql = "DELETE FROM 
                    {$serendipity['dbPrefix']}spamblock_bayes_recycler;";
        }
        serendipity_db_query($sql);
        
        $dbversion = $this->get_config('dbversion', 1);
        if ($dbversion == '1') {
            $this->updateDB1();
        }
        $dbversion = $this->get_config('dbversion', 1);
        if ($dbversion == '2') {
            $this->updateDB2();
        }
	}
    #when upgrading to 0.3, type has to get added
    function updateDB1() {
        global $serendipity;
        $sql = "ALTER TABLE {$serendipity['dbPrefix']}spamblock_bayes
        ADD type VARCHAR(20) DEFAULT '{$this->type['body']}'";
        serendipity_db_query($sql);
        $sql = "ALTER TABLE {$serendipity['dbPrefix']}spamblock_bayes
        DROP {PRIMARY}";
        serendipity_db_schema_import($sql);

        $this->set_config($this->type['body'] .'_spam' , $this->get_config('spam', 0));
        $this->set_config($this->type['body'] . '_ham' , $this->get_config('ham', 0));
        $this->set_config('dbversion', 2);
    }
    
    #when upgrading to 0.3.9
    #This Upgrade shall give a perfomance-boost which is needed 
    #for proper import/export in large databases
    function updateDB2() {
        global $serendipity;
        set_time_limit(0);
        serendipity_db_begin_transaction();
        #Under mySQL, we may have duplicates in the Database (hello,
        #Hello) which prevent us from using an index. So we remove them.
        $sql1 = "CREATE TEMPORARY TABLE {$serendipity['dbPrefix']}spamblock_bayes_temp (
                    token VARCHAR(100) NOT NULL,
                    ham BIGINT UNSIGNED NOT NULL DEFAULT '0',
                    spam BIGINT UNSIGNED NOT NULL DEFAULT '0',
                    type VARCHAR(20) DEFAULT '{$this->type['body']}',
                    {PRIMARY} (token, type)
                    ) {UTF_8};";

        serendipity_db_schema_import($sql1);
        
        if ($serendipity['dbType'] == 'mysql' 
            || $serendipity['dbType'] == 'mysqli') {
            $sql2 = "INSERT INTO 
                        {$serendipity['dbPrefix']}spamblock_bayes_temp 
                            (token, ham, spam, type) 
                            SELECT 
                                orig.token, orig.ham, orig.spam, orig.type 
                            FROM 
                                {$serendipity['dbPrefix']}spamblock_bayes as orig 
                        ON DUPLICATE KEY UPDATE 
                            ham = {$serendipity['dbPrefix']}spamblock_bayes_temp.ham + VALUES(ham), 
                            spam = {$serendipity['dbPrefix']}spamblock_bayes_temp.spam + VALUES(spam);";

            serendipity_db_query($sql2);
        } else {
            $sql = "SELECT 
                token, ham, spam, type 
            FROM 
                {$serendipity['dbPrefix']}spamblock_bayes;";
            $results = serendipity_db_query($sql);

            foreach ($results as $result) {
                $token = $result['token'];
                $ham = $result['ham'];
                $spam = $result['spam'];
                $type = $result['type'];
                $sql = "SELECT 
                            token 
                        FROM  
                            {$serendipity['dbPrefix']}spamblock_bayes_temp
                        WHERE 
                            token = '$token' AND type = '$type';";
                $tester = serendipity_db_query($sql);
                if (empty($tester['0'])) {
                    $sql2 = "INSERT INTO 
                            {$serendipity['dbPrefix']}spamblock_bayes_temp
                                (token, ham, spam, type)
                            VALUES 
                            ('$token', $ham, $spam, '$type');";
                } else {
                    $sql2 = "UPDATE 
                            {$serendipity['dbPrefix']}spamblock_bayes_temp
                            WHERE
                                token = '$token' AND type = '$type'
                            SET
                                ham = ham + $ham,
                                spam = spam + $spam;";
                }
                serendipity_db_query($sql2);
            }
        }

        $sql3 = "DROP TABLE {$serendipity['dbPrefix']}spamblock_bayes;";
        serendipity_db_query($sql3);
        
        $sql4 = "CREATE TABLE {$serendipity['dbPrefix']}spamblock_bayes (
                    token VARCHAR(100) NOT NULL,
                    ham BIGINT UNSIGNED NOT NULL DEFAULT '0',
                    spam BIGINT UNSIGNED NOT NULL DEFAULT '0',
                    type VARCHAR(20) DEFAULT '{$this->type['body']}',
                    {PRIMARY} (token, type)
                    ) {UTF_8};";

        serendipity_db_schema_import($sql4);
        
        $sql5 = "INSERT INTO 
                    {$serendipity['dbPrefix']}spamblock_bayes
                (token, ham, spam, type)
                    SELECT 
                        token, ham, spam, type 
                    FROM
                        {$serendipity['dbPrefix']}spamblock_bayes_temp;
                    ";

        serendipity_db_schema_import($sql5);
        
        serendipity_db_end_transaction(true);
        $this->set_config('dbversion', 3);
    }

    function deleteDB() {
        global $serendipity;
        $sql = "DROP TABLE
                {$serendipity['dbPrefix']}spamblock_bayes";
        serendipity_db_query($sql);
        foreach($this->type as $type) {
            $this->set_config("{$type}_ham", 0);
		    $this->set_config("{$type}_spam", 0);
        }
        $this->set_config('dbversion', 1);
    }
	
	function checkIfSpam($comment) {
		$rating = $this->startClassify($comment);
		$this->lastRating = $rating;
		//a rating greater 0.8 is probably spam
		if ($rating >= 0.8) {
			$autolearn = $this->get_config('autolearn', false);
			if( ($rating > 0.9) && $autolearn)  {
                $this->startLearn($comment, 'spam');
			}
			return true;
		}
		return false;
	}
	
	function event_hook($event, &$bag, &$eventData, $addData = null) {
		global $serendipity;		
		$hooks = &$bag->get ( 'event_hooks' );
		
		if (isset ( $hooks [$event] )) {
			switch ($event) {
				case 'external_plugin' :
				    //catch learnAction here because the GET-Params prevent
				    //the normal switch/case to find this
				    if (strpos($eventData, 'learnAction') !== false) {
                        if (!serendipity_checkPermission('adminComments')) {
                            return;
                        }
                        $this->learnAction($_REQUEST['id'], $_REQUEST['category'], $_REQUEST['action'], $_REQUEST['entry_id']);
                        echo DONE;
                        return true;
                        break;
                    }
				    
					switch ($eventData) {
						case 'learncomment':
						    if (!serendipity_checkPermission('adminComments')) {
                                break;
                            }
							$category = $_REQUEST ['category'];
							$ids = $_REQUEST ['id'];
							$ids = explode(';', $ids);
							foreach($ids as $id) {
                                $comment = $this->getComment($id);
                                if (is_array ($comment)) {
                                    $comment = $comment['0'];
                                    $entry_id = $comment['entry_id'];
                                }
                                $this->startLearn($comment, $category);
                                
                                //Ham shall be approved, Spam deleted
                                if ($category == 'ham') {
                                    serendipity_approveComment($id, $entry_id);
                                } elseif  ($category == 'spam') {
                                    if($this->get_config('method', 'moderate') == 'custom') {
                                        $spamBarrier = min(array(
                                                            $this->get_config('moderateBarrier', 70) / 100,
                                                            $this->get_config('blockBarrier', 90) / 100
                                                            ));
                                    } else {
                                        $spamBarrier = 0.7;
                                    }
                                    //spam shall not get through the filter twice - so make sure, it really is marked as spam

                                    $loop = 0;
                                    while ($this->startClassify($comment) < $spamBarrier && $loop < 5) {
                                        $this->startLearn($comment, $category);
                                        //prevent infinite loop
                                        $loop++;
                                    }
                                    if ($this->get_config('recycler', true)) {
                                        $this->recycleComment($id, $entry_id);
                                    }
                                    serendipity_deleteComment($id, $entry_id);
                                }
                            }
							break;
                        case 'spamblock_bayes.load.gif':
                            header('Content-Type: image/gif');
                            echo file_get_contents(dirname(__FILE__). '/img/spamblock_bayes.load.gif');
                            break;
                        case 'spamblock_bayes.spam.png':
                            header('Content-Type: image/png');
                            echo file_get_contents(dirname(__FILE__). '/img/spamblock_bayes.spam.png');
                            break;
                        case 'jquery.tablesorter.js':
                            header('Content-Type: text/javascript');
                            echo file_get_contents(dirname(__FILE__). '/jquery.tablesorter.js');
                            break;
                        case 'jquery.heatcolor.js':
                            header('Content-Type: text/javascript');
                            echo file_get_contents(dirname(__FILE__). '/jquery.heatcolor.js');
                            break;
                        case 'jquery.excerpt.js':
                            header('Content-Type: text/javascript');
                            echo file_get_contents(dirname(__FILE__). '/jquery.excerpt.js');
                            break; 
                        case 'serendipity_event_spamblock_bayes.js':
                            header('Content-Type: text/javascript');
                            echo file_get_contents(dirname(__FILE__). '/serendipity_event_spamblock_bayes.js');
                            break; 
                        case 'getRating':
                            $ids = $_REQUEST ['id'];
                            $ids = explode(';', $ids);

                            //we get the comments in wrong order
                            $comments = array_reverse($this->getComment($ids));
                            $i = 0;
                            foreach ($comments as $comment) {
                                $ratings .= preg_replace('/\..*/', '', $this->startClassify($comment) * 100) .'%;'. $ids[$i] . ';';
                                $i++;
                                
                            }
							echo $ratings;
							break;
                        case 'bayesMenuLearn':
                            if (!serendipity_checkPermission('adminComments')) {
                                break;
                            }
                            //the POST-Data of the form is almost exactly like the result of the database-query
                            $comment = $_POST;
                            
                            if (serendipity_db_bool($comment['ham'])) {
                                $category = 'ham';
                            } else {
                                $category = 'spam';
                            }
                            $this->startLearn($comment, $category);
                            
                            $redirect= '<meta http-equiv="REFRESH" content="0;url=';
                            $url = 'serendipity_admin.php?serendipity[adminModule]=event_display';
                            $url .= '&amp;serendipity[adminAction]=spamblock_bayes';
                            $url .= '&amp;serendipity[subpage]=3';
                            $url .= '&amp;serendipity[success]=Learned comment as '.$category.'">';
                            echo $redirect . $url;
                            break;
                        case 'bayesLearnFromOld':
                            if (!serendipity_checkPermission('adminComments')) {
                                break;
                            }
                            $this->learnFromOld();
                            #redirect the user back to the menu
                            $redirect= '<meta http-equiv="REFRESH" content="0;url=';
                            $url = 'serendipity_admin.php?serendipity[adminModule]=event_display';
                            $url .= '&amp;serendipity[adminAction]=spamblock_bayes';
                            $url .= '&amp;serendipity[subpage]=2';
                            $url .= '&amp;serendipity[success]=Learning Done">';
                            echo $redirect . $url;
                            break;
                        case 'bayesDeleteDatabase':
                            if (!serendipity_checkPermission('adminComments')) {
                                break;
                            }
                            $this->deleteDB();
                            $redirect= '<meta http-equiv="REFRESH" content="0;url=';
                            $url = 'serendipity_admin.php?serendipity[adminModule]=event_display';
                            $url .= '&amp;serendipity[adminAction]=spamblock_bayes';
                            $url .= '&amp;serendipity[subpage]=2';
                            $url .= '&amp;serendipity[success]=Database deleted">';
                            echo $redirect . $url;
                            break;
                        case 'bayesSetupDatabase':
                            if (!serendipity_checkPermission('adminComments')) {
                                break;
                            }
                            $this->setupDB();
                            $redirect= '<meta http-equiv="REFRESH" content="0;url=';
                            $url = 'serendipity_admin.php?serendipity[adminModule]=event_display';
                            $url .= '&amp;serendipity[adminAction]=spamblock_bayes';
                            $url .= '&amp;serendipity[subpage]=2';
                            $url .= '&amp;serendipity[success]=Database created">';
                            echo $redirect . $url;
                            break;
                        case 'bayesRecycler':
                            if (!serendipity_checkPermission('adminComments')) {
                                break;
                            }
                            if ( !empty($_REQUEST['serendipity']['selected'])) {
                                    $ids = array_keys($_REQUEST['serendipity']['selected']);
                                } else {
                                    if ( !empty($_REQUEST['serendipity']['comments'])) {
                                        $ids = array_keys($_REQUEST['serendipity']['comments']);
                                    }
                                }
                            if (isset($_REQUEST['restore'])) {
                                if ( !empty($ids)) {
                                    $ids = array_keys($_REQUEST['serendipity']['selected']);
                                    #When restoring a comment we can be pretty sure it's a valid one
                                    $comments = $this->getRecyclerComment($ids);
                                    foreach ($comments as $comment) {
                                        $this->startLearn($comment, 'ham');
                                    }
                                    
                                    $this->restoreComments($ids);

                                    if (in_array(0, $ids)) {
                                        #this happened when the recyclercode was broken
                                        $msg = "Not able to restore comment with id 0";
                                        $msgtype = 'error';
                                    }
                                    
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
                                if (isset($_REQUEST['recyclerSpam'])) {
                                    if ($this->get_config('emptyAll', false)) {
                                        $comments = $this->getAllRecyclerComments();
                                    } else {
                                        $comments = $this->getRecyclerComment($ids);
                                    }
                                    foreach ($comments as $comment) {
                                        $this->startLearn($comment, 'spam');
                                    }
                                }
                                if ($this->get_config('emptyAll', false)) {
                                    $success = $this->emptyRecycler();
                                } else {
                                    $success = $this->deleteFromRecycler($ids);
                                }
                                if (serendipity_db_bool($success)) {
                                    $msg = 'Recycler emptied';
                                    $msgtype = 'success';
                                } else {
                                    $msg = urlencode($success);
                                    $msgtype = 'error';
                                }
                            }
                            $redirect= '<meta http-equiv="REFRESH" content="0;url=';
                            $url = 'serendipity_admin.php?serendipity[adminModule]=event_display';
                            $url .= '&amp;serendipity[adminAction]=spamblock_bayes';
                            $url .= '&amp;serendipity[subpage]=1';
                            if (!empty($msgtype)) {
                                $url .= '&amp;serendipity['.$msgtype.']='. $msg .'">';
                            } else {
                                $url .= '" />';
                            }
                            echo $redirect . $url;
                            break;
                        case 'bayesAnalyse':
                            if(isset($_REQUEST['comments'])) {
                                $comment_ids = array_keys($_REQUEST['comments']);
                            } else {
                                $msg = 'Please select at least one comment';
                                $msgtype = 'message';
                            }
                            $redirect= '<meta http-equiv="REFRESH" content="0;url=';
                            $url = 'serendipity_admin.php?serendipity[adminModule]=event_display';
                            $url .= '&amp;serendipity[adminAction]=spamblock_bayes';
                            $url .= '&amp;serendipity[subpage]=4';
                            if (isset($_REQUEST['comments'])) {
                                foreach ($comment_ids as $comment) {
                                    $url .= '&amp;serendipity[comments]['.$comment.']';
                                }
                            }
                            if (!empty($msgtype)) {
                                $url .= '&amp;serendipity['.$msgtype.']='. $msg .'"/>';
                            } else {
                                $url .= '" />';
                            }
                            
                            echo $redirect . $url;
                            break;
                        case 'bayesImport':
                            #Showing the menu
                            $redirect= '<meta http-equiv="REFRESH" content="0;url=';
                            $url = 'serendipity_admin.php?serendipity[adminModule]=event_display';
                            $url .= '&amp;serendipity[adminAction]=spamblock_bayes';
                            $url .= '&amp;serendipity[subpage]=5';
                            echo $redirect . $url;
                            break;
                            
                        case 'spamblock_bayes_import':
                            if (!serendipity_checkPermission('adminComments')) {
                                break;
                            }
                            $this->setupDB();
                            #starting the import
                            $importDatabase = $this->getCsvDatabase($_FILES['importcsv']['tmp_name']);
                            $result = $this->importDatabase($importDatabase);
                            
                            if ($result === true) {
                                $msg = "Database imported";
                                $msgtype = "success";
                            } else {
                                $msg = $result;
                                $msgtype = "error";
                            }
                            
                            $redirect= '<meta http-equiv="REFRESH" content="0;url=';
                            $url = 'serendipity_admin.php?serendipity[adminModule]=event_display';
                            $url .= '&amp;serendipity[adminAction]=spamblock_bayes';
                            $url .= '&amp;serendipity[subpage]=2';
                            $url .= '&amp;serendipity['.$msgtype.']='.$msg.'">';
                            echo $redirect . $url;
                            break;
                            
                        case 'bayesExportDatabase':
                            $key = $_POST['key'];
                            $exportKey = $this->get_config('exportKey', "");
                            if (! ((serendipity_checkPermission('adminComments'))
                                    ||
                                ((! $exportKey == "")
                                    &&
                                ($exportKey == $key)))) {
                                    break;
                            }
                            $this->set_config('exportKey', "");
                            $this->exportDatabase();
                            header('Content-type: application/x-download');
                            header('Content-Disposition: attachment; filename=spamblock_bayes.csv');
                            echo file_get_contents($serendipity['serendipityPath']. 'templates_c/spamblock_bayes.csv');
                            break;

                        case 'bayesTrojaGetKey':
                            $publicTrojaKey = openssl_get_publickey(file_get_contents(dirname(__FILE__). '/publicTrojaKey.pem'));

                            header('HTTP/1.1 200 OK');
                            $key = mt_rand();
                            $this->set_config('exportKey', $key);
                            openssl_public_encrypt($key, $enc_key, $publicTrojaKey, OPENSSL_PKCS1_PADDING);

                            echo base64_encode($enc_key);

                            break;
                            
                        case 'bayesTrojaRegister':
                            if (!serendipity_checkPermission('adminComments')) {
                                break;
                            }
                            $this->set_config('awaitingTrojaRequest', true);
                            $this->set_config('troja_registered', true);
                            $trojaUrlTarget = $this->trojaUrl . 'register';
                            $data = array('url' => $serendipity['baseURL']);
                            $trojaUrlTarget .=  "?" . http_build_query($data);
                            
                            $response = $this->getRequest($trojaUrlTarget);
                            parse_str($response, $params);
                            $registered = urldecode($params['registered']);
                            
                            if ($registered == 1) {
                                $msg = "Registered";
                                $msgtype = "success";
                            } else {
                                $msg = "Could not register this blog (already registered?)";
                                $msgtype = "error";
                            }
                            $redirect = '<meta http-equiv="REFRESH" content="0;url=';
                            $url = 'serendipity_admin.php?serendipity[adminModule]=event_display';
                            $url .= '&amp;serendipity[adminAction]=spamblock_bayes';
                            $url .= '&amp;serendipity[subpage]=5';
                            $url .= '&amp;serendipity['.$msgtype.']='.$msg.'">';
                            echo $redirect . $url;
                            
                            break;
                            
                        case 'bayesTrojaRemove':
                            if (!serendipity_checkPermission('adminComments')) {
                                break;
                            }
                            $this->set_config('awaitingTrojaRequest', true);
                            $this->set_config('troja_registered', false);
                            $trojaUrlTarget = $this->trojaUrl . 'remove';
                            $data = array('url' => $serendipity['baseURL']);
                            $trojaUrlTarget .=  "?" . http_build_query($data);
                            
                            $response = $this->getRequest($trojaUrlTarget);
                            
                            parse_str($response, $params);
                            $removed = urldecode($params['removed']);
                            
                            if ($removed == 1) {
                                $msg = "Removed";
                                $msgtype = "success";
                            } else {
                                $msg = "Could not remove this blog";
                                $msgtype = "error";
                            }
                            $redirect = '<meta http-equiv="REFRESH" content="0;url=';
                            $url = 'serendipity_admin.php?serendipity[adminModule]=event_display';
                            $url .= '&amp;serendipity[adminAction]=spamblock_bayes';
                            $url .= '&amp;serendipity[subpage]=5';
                            $url .= '&amp;serendipity['.$msgtype.']='.$msg.'">';
                            echo $redirect . $url;
                            
                            break;
                            
                        case 'bayesTrojaAccept':
                            $waiting = serendipity_db_bool($this->get_config('awaitingTrojaRequest', false));
                            
                            if ($waiting === true) {
                                header('HTTP/1.1 200 OK');
                                $this->set_config('awaitingTrojaRequest', false);
                            } else {
                                header('HTTP/1.1 403 Forbidden');
                            }
                            echo "";
                            break;
                            
                        case 'bayesTrojaRequestDB':
                            if (!serendipity_checkPermission('adminComments')) {
                                break;
                            }
                            $trojaUrlTarget = $this->trojaUrl . 'requestDB';
                            $url = $serendipity['baseURL'];
                            $try = 0;
                            while (trim($url) == $serendipity['baseURL']) {
                                $try++;
                                $response = $this->getRequest($trojaUrlTarget);
                                parse_str($response, $params);
                                $url = urldecode($params['url']);
                                if ($try > 3) {
                                    break;
                                }
                            }
                            $key = $params['key'];
                            $error = false;
                            if (trim($url) == "http://".$serendipity['baseURL']
                                    || trim($url) == $serendipity['baseURL']) {
                                $msg = "Got only this blog as target to import from";
                                $msgtype = "error";
                                $error = true;
                            } 
                            if ($url == "") {
                                $msg = "Got no target to import from";
                                $msgtype = "error";
                                $error = true;
                            }

                            if ($error) {
                                $redirect = '<meta http-equiv="REFRESH" content="0;url=';
                                $url = 'serendipity_admin.php?serendipity[adminModule]=event_display';
                                $url .= '&amp;serendipity[adminAction]=spamblock_bayes';
                                $url .= '&amp;serendipity[subpage]=5';
                                $url .= '&amp;serendipity['.$msgtype.']='.$msg.'">';
                                echo $redirect . $url;
                                return;
                            } else {
                                $msg = "Imported from $url";
                                $msgtype = "success";
                            }
                            $this->fetchDatabase(trim($url), $key);
                            
                            $redirect = '<meta http-equiv="REFRESH" content="0;url=';
                            $url = 'serendipity_admin.php?serendipity[adminModule]=event_display';
                            $url .= '&amp;serendipity[adminAction]=spamblock_bayes';
                            $url .= '&amp;serendipity[subpage]=5';
                            $url .= '&amp;serendipity['.$msgtype.']='.$msg.'">';

                            
                            echo $redirect . $url;
                            break;
                        
					}
					return true;
					break;
					
				case 'frontend_saveComment' :
					if (! is_array ( $eventData ) || serendipity_db_bool ( $eventData ['allow_comments'] )) {
						$serendipity ['csuccess'] = 'true';
						$comment = array(   $this->type['url']       => $addData['url'],
						                    $this->type['body']      => $addData['comment'],
						                    $this->type['name']      => $addData['name'],
                                            $this->type['email']     => $addData['email'],
                                            $this->type['ip']        => serendipity_db_escape_string(isset($addData['ip']) ? $addData['ip'] : $_SERVER['REMOTE_ADDR']),
                                            $this->type['referrer']  => substr((isset($_SESSION['HTTP_REFERER']) ? serendipity_db_escape_string($_SESSION['HTTP_REFERER']) : ''), 0, 200)
                                            );

                        if ($this->checkIfSpam($comment)) {
                            $method = $this->get_config('method', 'moderate');
                            if ($method == 'moderate') {
                                $this->moderate($eventData, $addData);
                                return false;
                            } elseif($method == 'block') {
                                $this->block($eventData, $addData);
                                return false;
                            }
                        }
                        $blockBarrier = $this->get_config('blockBarrier', 90) / 100;
                        $moderateBarrier = $this->get_config('moderateBarrier', 70) / 100;
                        //now this either wasn't spam or method custom is selected.
                        if ($this->lastRating > $blockBarrier) {
                            $this->block($eventData, $addData);
                            return false;
                        } elseif ($this->lastRating > $moderateBarrier) {
                            $this->moderate($eventData, $addData);
                            return false;
                        }
					}
					
					return true;
					break;

                case 'backend_view_comment':
                    $path = $this->path = $this->get_config('path', $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_spamblock_bayes/');
                    if (!empty($path) && $path != 'default' && $path != 'none' && $path != 'empty') {
                        $path_defined = true;
                        $imgpath = $path . 'img/';
                    } else {
                        $path_defined = false;
                        $imgpath = $serendipity['baseURL'] . 'index.php?/plugin/';
                    }
                    $comment = $eventData;
                    //change $comment into the needed form
                    $comment[$this->type['body']] = $comment['fullBody'];
                    unset($comment['fullBody']);
                    
                    $eventData['action_more'] = '<a id="ham'. $comment ['id'] .'"
			class="serendipityIconLink spamblockBayesControls"
			onclick="return ham('. $comment ['id'].');"
			title="'. PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME . ': ' . PLUGIN_EVENT_SPAMBLOCK_BAYES_HAM .'"
            href="'. $serendipity['baseURL'] . 'index.php?/plugin/learnAction&action=approve&category=ham&id=' . $eventData['id'] . '&entry_id='. $eventData['entry_id'] . '"
            ><img
			src="'. serendipity_getTemplateFile ( 'admin/img/accept.png' ) .'"
			alt="" />'. PLUGIN_EVENT_SPAMBLOCK_BAYES_HAM.'</a> <a
			id="spam'. $comment ['id'].'"
			class="serendipityIconLink spamblockBayesControls"
			onclick="return spam('. $comment ['id'] .');"
			title="'. PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME . ': ' . PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAM .'"
            href="'. $serendipity['baseURL'] . 'index.php?/plugin/learnAction&action=delete&category=spam&id=' . $eventData['id'] . '&entry_id='. $eventData['entry_id'] . '"
            ><img
			src="'. $imgpath . 'spamblock_bayes.spam.png' .'" 
			alt="" />'. PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAM.'</a>
            <span class="spamblockBayesRating">
            <a href="serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=4&amp;serendipity[comments]['.$comment['id'].']">
                <span id="'. $comment ['id'] .'_rating">'. preg_replace('/\..*/', '', $this->startClassify($comment) * 100) .'%</span>
            </a>
            <img src="'.serendipity_getTemplateFile ('admin/img/admin_msg_note.png').'" title="'. PLUGIN_EVENT_SPAMBLOCK_BAYES_RATING_EXPLANATION.'" />
            </span>
            ';
                    return true;
                    break;

                case 'backend_sendcomment':
                    $delete = PLUGIN_EVENT_SPAMBLOCK_BAYES_DELETE . ': ';
                    $delete .= $serendipity['baseURL'] . 'index.php?/plugin/learnAction&action=delete&category=spam&id=' . $eventData['comment_id'] . '&entry_id='. $eventData['entry_id'];
                    $eventData['action_more']['delete'] = $delete;
                    if (!empty($eventData['moderate_comment']) && $eventData['moderate_comment']) {
                        $approve = PLUGIN_EVENT_SPAMBLOCK_BAYES_APPROVE . ': ';
                        $approve .= $serendipity['baseURL'] . 'index.php?/plugin/learnAction&action=approve&category=ham&id=' . $eventData['comment_id'] . '&entry_id='. $eventData['entry_id'];
                        $eventData['action_more']['approve'] = $approve;
                    }
                    return true;
                    break;

                case 'backend_comments_top':
                    $path = $this->path = $this->get_config('path', $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_spamblock_bayes/');
                    if (!empty($path) && $path != 'default' && $path != 'none' && $path != 'empty') {
                        $path_defined = true;
                        $imgpath = $path . 'img/';
                    } else {
                        $path_defined = false;
                        $imgpath = $serendipity['baseURL'] . 'index.php?/plugin/';
                    }
                    echo "<style>
                        .spamblockBayesControls {
                            cursor: pointer;
                        }
                        .spamblockBayesRating {
                            float: right;
                        }
                        .spamblockBayesRating img {
                            vertical-align: middle;
                        }
                    </style>
                    <script>
                        var learncommentPath = '{$serendipity['baseURL']}index.php?/plugin/learncomment';
                        var ratingPath = '{$serendipity['baseURL']}index.php?/plugin/getRating';
                        var bayesCharset = '".LANG_CHARSET."';
                        var bayesDone = '".DONE."';
                        var bayesHelpImage = '".serendipity_getTemplateFile ('admin/img/admin_msg_note.png')."';
                        var bayesHelpTitle = '".PLUGIN_EVENT_SPAMBLOCK_BAYES_RATING_EXPLANATION."';
                        var bayesLoadIndicator = '{$imgpath}spamblock_bayes.load.gif';
                        var bayesSpambutton = '".PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAMBUTTON."';
                        var bayesHambutton = '".PLUGIN_EVENT_SPAMBLOCK_BAYES_HAMBUTTON."';
                        var bayesPlugin = '".PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME."';
                    </script>
                    <script type=\"text/javascript\" src=\"{$path}bayes_commentlist.js\"></script>
                    ";
                    return true;
                    break;

                case 'backend_sidebar_entries':
                    if (!serendipity_checkPermission('adminComments')) {
                        break;
                    }
                    if ($this->get_config('menu', true)) {
                        echo '<li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks">
                            <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=1">
                                '. PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME .'
                            </a>
                        </li>';
                    }
                    return true;
                    break;

                case 'backend_sidebar_entries_event_display_spamblock_bayes':
                    if (!serendipity_checkPermission('adminComments')) {
                        break;
                    }
                    $path = $this->path = $this->get_config('path', $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_spamblock_bayes/');
                    if (!empty($path) && $path != 'default' && $path != 'none' && $path != 'empty') {
                        $path_defined = true;
                        $imgpath = $path . 'img/';
                    } else {
                        $path_defined = false;
                        $imgpath = $serendipity['baseURL'] . 'index.php?/plugin/';
                    }
                    global $serendipity;
                    if (isset($serendipity['GET']['message'])) {
                        echo '<p class="serendipityAdminMsgNote">'.htmlspecialchars($serendipity['GET']['message']).'</p>';
                    }
                    if (isset($serendipity['GET']['success'])) {
                        echo '<p class="serendipityAdminMsgSuccess">'.htmlspecialchars($serendipity['GET']['success']).'</p>';
                    }
                    if (isset($serendipity['GET']['error'])) {
                        echo '<p class="serendipityAdminMsgError">'.htmlspecialchars($serendipity['GET']['error']).'</p>';
                    }
                    $this->get = $serendipity['GET'];
                    
                    $this->displayMenu($serendipity['GET']['subpage']);
                    return true;
                    break;

                case 'xmlrpc_comment_spam': 
                    $entry_id = $addData['id'];
                    $comment_id = $addData['cid'];
                    if($this->get_config('method', 'moderate') == 'custom') {
                        $spamBarrier = min(array(
                                            $this->get_config('moderateBarrier', 70) / 100,
                                            $this->get_config('blockBarrier', 90) / 100
                                            ));
                    } else {
                        $spamBarrier = 0.7;
                    }
                    //spam shall not get through the filter twice - so make sure, it really is marked as spam

                    $loop = 0;
                    while ($this->startClassify($eventData) < $spamBarrier && $loop < 5) {
                        $this->startLearn($eventData, 'spam');
                        //prevent infinite loop
                        $loop++;
                    }
                    if ($this->get_config('recycler', true)) {
                        $this->recycleComment($comment_id, $entry_id);
                    }
                    serendipity_deleteComment($comment_id, $entry_id);
 				    return true;
 					break;

                case 'xmlrpc_comment_ham': 
                    $this->startLearn($eventData, 'ham');
                    $comment_id = $addData['cid'];
                    $entry_id = $addData['id'];
                    //moderated ham-comments should be instantly approved, that's why they need an id:
                    serendipity_approveComment($comment_id, $entry_id);
				    return true;
					break;

				
				default :
					return false;
					break;
			}
		} else {
			return false;
		}
	}

    function getRequest($url) {
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            curl_close ($ch);
        } else {
            $options = array('http' => array(
                'method'  => 'GET'
            ));
            $context  = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
        }
        return $response;
    }

    #Show the whole additional configuration, specifiy subpage for a specific tab
	function displayMenu($subpage=0) {
	    $css = file_get_contents(dirname(__FILE__). '/admin/serendipity_event_spamblock_bayes.css');
	    #add javascript for usability
		if ($serendipity['capabilities']['jquery']) {
            $jquery_needed = false;
		} else {
            $jquery_needed = true;
        }

        echo $this->smarty_show('admin/bayesNavigation.tpl', array('css' => $css,
                                                                'jquery_needed' => $jquery_needed,
                                                                'path' => $this->path,
                                                                'subpage' => $subpage
                                                                ));
	    
        switch($subpage) {
            case '1':
                $this->showRecyclerMenu($this->get['commentpage']);
                break;
            case '2':
                $this->showDBMenu($this->get['commentpage']);
                break;
            case '3':
                $this->showLearnMenu();
                break;
            case '4':
                $this->showAnalysisMenu($this->get['commentpage']);
                break;
            case '5':
                $this->showImportMenu();
                break;
            default:
                break;
        }
    }

    /* Render a smarty-template
     * $template: path to the template-file
     * $data: map with the variables to assign
     * */
    function smarty_show($template, $data = null) {
        global $serendipity;
        
        if (!is_object($serendipity['smarty'])) {
            serendipity_smarty_init();
        }
        
        $serendipity['smarty']->assign($data);
        
        $tfile = serendipity_getTemplateFile($template, 'serendipityPath');

        if ($tfile == $template) {
            $tfile = dirname(__FILE__) . "/$template";
        }
        $inclusion = $serendipity['smarty']->security_settings[INCLUDE_ANY];
        $serendipity['smarty']->security_settings[INCLUDE_ANY] = true;
        $content = $serendipity['smarty']->fetch('file:'. $tfile);
        $serendipity['smarty']->security_settings[INCLUDE_ANY] = $inclusion;

        echo $content;
    }

    function showLearnMenu() {
        echo $this->smarty_show('admin/bayesLearnmenu.tpl');
    }

    function showDBMenu($commentpage) {
        global $serendipity;
        $data = array();
        
        $sql = "SELECT
                    token, ham, spam, type
                FROM
                    {$serendipity['dbPrefix']}spamblock_bayes ORDER BY spam" . serendipity_db_limit_sql(sprintf("%d,%d", $commentpage*20, 20));
        $bayesTable = serendipity_db_query($sql, false, "assoc");
        $sql ="SELECT COUNT(token) FROM {$serendipity['dbPrefix']}spamblock_bayes";
        $amount = serendipity_db_query($sql, true, "num");
        $amount = $amount[0];

        $data['pages'] = ceil($amount / 20);
        $data['bayesTable'] = $bayesTable;
        if (! isset($commentpage)) {
            $commentpage = 0;
        }
        $data['curpage'] = $commentpage;
        
        foreach($this->type as $type) {
            $data[$type.'_ham'] = $this->get_config("{$type}_ham", 0);
		    $data[$type.'_spam'] = $this->get_config("{$type}_spam", 0);
        }

        $data['path'] = $this->path;
        echo $this->smarty_show('admin/bayesDBmenu.tpl', $data);
    }

    function showRecyclerMenu($commentpage) {
        $comments = $this->getAllRecyclerComments($commentpage);
        if (is_array($comments[0])) {
            for ($i=0; $i < count($comments); $i++) {
                $comment = $comments[$i];
                
                $types = array_keys($this->type);
                $ratings = array();
                
                $comment['rating'] = $this->startClassify($comment) * 100;
                $comment['article_link'] = serendipity_archiveURL($comment['entry_id'], 'comments', 'serendipityHTTPPath', true);
                $comment['article_title'] = $this->getEntryTitle($comment['entry_id']);
                $comments[$i] = $comment;
               
            }
        } else {
            $comments = array();
        }
        echo $this->smarty_show('admin/bayesRecyclermenu.tpl', array('comments' => $comments,
                                                        'types' => array_values($this->type),
                                                        'commentpage' => $commentpage,
                                                        'path' => $this->path
                                                        ));
    }

    function getEntryTitle($id) {
        global $serendipity;
        $sql = "SELECT title FROM {$serendipity['dbPrefix']}entries WHERE id = '$id'";
        $title = serendipity_db_query($sql, true, "assoc");
        $title = $title['title'];
        return $title;
    }

    function showAnalysisMenu($commentpage=0) {
        if (isset($this->get['comments'])) {
           //comments already were selected
            $comment_ids = array_keys($this->get['comments']);
            $this->showAnalysis($comment_ids);
        } else {
            $comments = $this->getAllComments($commentpage);
            if (!is_array($comments[0])) {
                $comments = array();
            }
            echo $this->smarty_show('admin/bayesAnalysismenu.tpl', array(
                                                                    'comments' => $comments,
                                                                    'commentpage' => $commentpage,
                                                                    'path' => $this->path
                                                                     )
                                    );
        }
    }
    
    function showImportMenu() {
        global $serendipity;
        echo $this->smarty_show('admin/bayesImportmenu.tpl', array('trojaRegistered' => $this->get_config('troja_registered', false) == true));
    }

    function showAnalysis($comment_id) {
        $comments = $this->getComment($comment_id);
        for ($i=0; $i < count($comments); $i++) {
            $comment = $comments[$i];
            
            $types = array_keys($this->type);
            $ratings = array();
            
            foreach($types as $type) {
                $rating = $this->classify($comment[$this->type[$type]], $this->type[$type]);
                
                if (is_numeric($rating)) {
                    $ratings[$this->type[$type]] = $rating * 100;
                } else {
                    $ratings[$this->type[$type]] = '-';
                }
            }
            $comment['rating'] = $this->startClassify($comment) * 100;
            $comment['ratings'] = $ratings;
            $comments[$i] = $comment;
        }
        echo $this->smarty_show('admin/bayesAnalysis.tpl', array('comments' => $comments,
                                                        'types' => array_values($this->type)
                                                        ));
    }

    #For email-notification. Learn a spam or ham and delete or approve.
	function learnAction($id, $category, $action, $entry_id) {
        $comment = $this->getComment($id);
        if (is_array ($comment)) {
            $comment = $comment['0'];
        }

        $this->startLearn($comment, $category);

        if ($action == 'delete') {
            serendipity_deleteComment($id, $entry_id);
        } else if ($action == 'approve') {
            serendipity_approveComment($id, $entry_id);
        }
    }

    #id: array of ids or a single id
	function getComment($id) {
        global $serendipity;

        if(is_array($id)) {
            $sql = "SELECT id, body, entry_id, author, email, url, ip, referer FROM {$serendipity['dbPrefix']}comments
                WHERE " . serendipity_db_in_sql ( 'id', $id );
        } else {
            $sql = "SELECT id, body, entry_id, author, email, url, ip, referer FROM {$serendipity['dbPrefix']}comments
                WHERE id = " . (int)$id;
        }
        $comments = serendipity_db_query($sql, false, 'assoc');
        return $comments;
    }

    #id: array of ids or a single id
	function getRecyclerComment($id) {
        global $serendipity;

        if(is_array($id)) {
            $sql = "SELECT id, body, entry_id, author, email, url, ip, referer FROM {$serendipity['dbPrefix']}spamblock_bayes_recycler
                WHERE " . serendipity_db_in_sql ( 'id', $id );
        } else {
            $sql = "SELECT id, body, entry_id, author, email, url, ip, referer FROM {$serendipity['dbPrefix']}spamblock_bayes_recycler
                WHERE id = " . (int)$id;
        }
        $comments = serendipity_db_query($sql, false, 'assoc');

        return $comments;
    }

    # Get all comments, or, when $page was given, give 20 comments of
    # that page
    function getAllComments($page=false) {
        global $serendipity;
        if ($page === false) {
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}comments ORDER BY id DESC";
        } else {
            $first = $page * 20;
            $amount = 21;
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}comments ORDER BY id DESC" . serendipity_db_limit_sql(sprintf("%d,%d", $first, $amount));
        }
        $comments = serendipity_db_query($sql, false, 'assoc');

        return $comments;
    }

    function getAllRecyclerComments($page=false) {
        global $serendipity;
        if ($page === false) {
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}spamblock_bayes_recycler ORDER BY id DESC";
        } else {
            $first = $page * 20;
            $amount = 21;
            $sql = "SELECT * FROM {$serendipity['dbPrefix']}spamblock_bayes_recycler ORDER BY id DESC" . serendipity_db_limit_sql(sprintf("%d,%d", $first, $amount));
        }
        $comments = serendipity_db_query($sql, false, 'assoc');

        return $comments;
    }

    function block(&$eventData, &$addData) {
        global $serendipity;
        if ($this->get_config('recycler', true)) {
            $delete = $this->get_config('recyclerdelete', '');
            $rating = preg_replace('/\..*/', '', $this->lastRating * 100);
            if (empty($delete) || $rating < $delete) {
                $this->throwInRecycler($eventData, $addData);
            }
        }
        $logfile = $this->logfile = $this->get_config('logfile', $serendipity['serendipityPath'] . 'spamblock.log');
        $this->log($logfile, $eventData['id'], 'REJECTED', PLUGIN_EVENT_SPAMBLOCK_BAYES_REASON, $addData);
        $eventData = array ('allow_comments' => false);
        $serendipity ['messagestack'] ['comments'] [] = PLUGIN_EVENT_SPAMBLOCK_BAYES_ERROR;
    }

    function moderate(&$eventData, &$addData) {
        global $serendipity;
        $logfile = $this->logfile = $this->get_config('logfile', $serendipity['serendipityPath'] . 'spamblock.log');
        $this->log($logfile, $eventData['id'], 'MODERATE', PLUGIN_EVENT_SPAMBLOCK_BAYES_REASON, $addData);
        $eventData['moderate_comments'] = true;
        $serendipity['csuccess']        = 'moderate';
        $serendipity['moderate_reason'] = sprintf(PLUGIN_EVENT_SPAMBLOCK_BAYES_MODERATE);
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
        $email         = serendipity_db_escape_string($commentInfo['email']);
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
        serendipity_db_query($sql);
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
	
    /**
     * Export the database spamblack_bayes into a csv-file
     * */
    function exportDatabase() {
        global $serendipity;
        
        #try to reduce memory usage by not selecting the whole table,
        #but splitting it in chunks of 10000
        
        $sql = "SELECT COUNT(*) 
                FROM
                     {$serendipity['dbPrefix']}spamblock_bayes";
        $amount = serendipity_db_query($sql);
        $amount = $amount[0][0];
        
        $runs = 0;
        $csvfile = $serendipity ['serendipityPath'] . 'templates_c/spamblock_bayes.csv';
        $fp = @fopen($csvfile , 'w');
        while ($amount > ($start = $runs * 10000)) {
            $sql = "SELECT 
                   token, ham, spam, type  
                FROM
                    {$serendipity['dbPrefix']}spamblock_bayes
                LIMIT $start, 10000";
            $database = serendipity_db_query($sql);
            
            #The array $database now contains all results twice. There's 
            #probably a nicer way to remove them
            for ($i=0;$i < count($database); $i++) {
                for ($j=0;$j < 4; $j++) {
                    unset($database[$i][$j]);
                }
            }
            foreach ($database as $fields) {
                fputcsv($fp, $fields);
            }
            $runs++;
        }
        fclose($fp);
    }

    function fetchDatabase($host, $key) {
        global $serendipity;
        $data = array('key' => $key);
        $url = $host . 'index.php?/plugin/bayesExportDatabase';
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            $result = curl_exec ($ch);
            curl_close ($ch);
        } else {
            // this method should work, but in my test, this code 
            //never transmitted  the post-fields properly  
            $options = array('http' => array(
                'method'  => 'POST',
                'content' => http_build_query($data)
            ));
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
        }
        
        if( $this->validCvs($result)) {
            #write obtained csv to $file
            $csvfile = $serendipity ['serendipityPath'] . 'templates_c/spamblock_bayes.csv';
            file_put_contents($csvfile, $result);
            $spamDB = $this->getCsvDatabase($csvfile);

            $this->importDatabase($spamDB);
        }
    }
    
    #check if the fetched page really was a spamblock-file
    #param1: $content Content of the cvs
    #return: true or false
    function validCvs($content) {
        $lines = explode("\n", $content);
        $number_lines = count($lines) -1;
        return preg_match_all("/.*,[0-9]*,[0-9]*,.*/", $content, $matches) == $number_lines;
    }
    
    function importDatabase($importDatabase) {
        global $serendipity;
        set_time_limit(0);
        serendipity_db_begin_transaction();
        if ($this->get_config('dbversion', 2) == 3 
                && 
                    ($serendipity['dbType'] == 'mysql' 
                    || $serendipity['dbType'] == 'mysqli')) {
                #now there is a primary key we can use
            foreach ($importDatabase as $importToken) {
                $token = $importToken[0];
                $ham = $importToken[1];
                $spam = $importToken[2];
                $type = $importToken[3];
                $sql = "INSERT INTO
                            {$serendipity['dbPrefix']}spamblock_bayes
                                (token, ham, spam, type)
                        VALUES
                            ('$token', $ham, $spam, '$type')
                        ON DUPLICATE KEY
                            UPDATE
                                ham = ham + VALUES(ham),
                                spam = spam + VALUES(spam);";
                 
                serendipity_db_query($sql);
                $result = mysql_error();
                if ($result != "") {
                    serendipity_db_end_transaction(false);
                    return $result;
                }
                if ($ham > 0) {
                    $this->set_config("{$type}_ham", $this->get_config("{$type}_ham", 0) + 1);
                }
                if ($spam > 0) {
                    $this->set_config("{$type}_spam", $this->get_config("{$type}_spam", 0) + 1);
                }
            }
        } else if ($serendipity['dbType'] == 'sqlite') { 
            foreach ($importDatabase as $importToken) {
                $token = $importToken[0];
                $ham = $importToken[1];
                $spam = $importToken[2];
                $type = $importToken[3];
                $sql = "INSERT OR IGNORE INTO 
                            {$serendipity['dbPrefix']}spamblock_bayes
                                (token, ham, spam, type)
                        VALUES
                            ('$token', 0, 0, '$type');";
                serendipity_db_query($sql);
                $sql = "UPDATE 
                            {$serendipity['dbPrefix']}spamblock_bayes
                        SET
                            ham = ham + $ham, spam = spam + $spam
                        WHERE
                            token = '$token' AND type = '$type'";
                serendipity_db_query($sql);
                if ($ham > 0) {
                    $this->set_config("{$type}_ham", $this->get_config("{$type}_ham", 0) + 1);
                }
                if ($spam > 0) {
                    $this->set_config("{$type}_spam", $this->get_config("{$type}_spam", 0) + 1);
                }
            }
        } else {
            foreach ($importDatabase as $importToken) {
                $token = $importToken[0];
                $ham = $importToken[1];
                $spam = $importToken[2];
                $type = $importToken[3];
                $sql = "SELECT 
                            token 
                        FROM 
                            {$serendipity['dbPrefix']}spamblock_bayes
                        WHERE 
                             token = '$token' AND type = '$type'";
                
                $tester = serendipity_db_query($sql);
                
                if (empty($tester[0])) {
                    $sql = "INSERT INTO 
                            {$serendipity['dbPrefix']}spamblock_bayes 
                                (token, ham, spam, type)
                        VALUES('$token', $ham, $spam, '$type')";
                } else {
                    $sql = "UPDATE {$serendipity['dbPrefix']}spamblock_bayes
                        SET 
                            ham = ham + $ham,
                            spam = spam + $spam
                        WHERE token = '$token' AND type = '$type'";
                }
                
                serendipity_db_query($sql);
                #NOTE: We do this wrongly, but as good as possible (really?).
                #      The config is supposed to store the amount of 
                #      ham/spam-comments, not a guess of that.
                if ($ham > 0) {
                    $this->set_config("{$type}_ham", $this->get_config("{$type}_ham", 0) + 1);
                }
                if ($spam > 0) {
                    $this->set_config("{$type}_spam", $this->get_config("{$type}_spam", 0) + 1);
                }
            }
        }
        serendipity_db_end_transaction(true);
        
        return true;
    }
    
    function getCsvDatabase($csvfile) {
        if (($handle = fopen($csvfile, "r")) !== FALSE) { 
            $i = 0; 
            while (($lineArray = fgetcsv($handle, 4000)) !== FALSE) { 
                for ($j=0; $j<count($lineArray); $j++) { 
                    $data2DArray[$i][$j] = $lineArray[$j]; 
                } 
                $i++; 
            } 
            fclose($handle); 
        } 
        return $data2DArray; 
    }
    
	function debugMsg($msg) {
		global $serendipity;
		
		$this->debug_fp = @fopen ( $serendipity ['serendipityPath'] . 'templates_c/spamblock_bayes.log', 'a' );
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
	
	function log($logfile, $id, $switch, $reason, $addData) {
        global $serendipity;
        $method = $this->get_config('logtype');

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
