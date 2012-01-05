<?php # $Id$
# Copyright (c) 2003-2005, Jannis Hermanns (on behalf the Serendipity Developer Team)
# All rights reserved.  See LICENSE file for licensing details

if (empty($HTTP_RAW_POST_DATA)) {
    global $HTTP_RAW_POST_DATA;
    $HTTP_RAW_POST_DATA = implode("\r\n", file('php://input'));
}

global $serendipity;
if ($serendipity['xmlrpc_debuglog']=='normal') $debug_xmlrpc = 1;
elseif ($serendipity['xmlrpc_debuglog']=='verbose') $debug_xmlrpc = 2;
else  $debug_xmlrpc = 0;

if ($debug_xmlrpc) {
    //@define('DEBUG_LOG_XMLRPC', '/tmp/rpc.log');
    @define('DEBUG_LOG_XMLRPC', dirname(__FILE__) . "/rpc.log");
    $fp = fopen(DEBUG_LOG_XMLRPC, 'a');
    fwrite($fp, '[' . date('d.m.Y H:i') . ']' . print_r($HTTP_RAW_POST_DATA, true));
    fclose($fp);
    ob_start();
    @define('DEBUG_XMLRPC', true);
} else {
    @define('DEBUG_XMLRPC', false);
}

if ($debug_xmlrpc === 2) {
    #$HTTP_RAW_POST_DATA = file_get_contents('/www/input.xml');
}
@define('XMLRPC_WP_COMPATIBLE', TRUE);

@define('XMLRPC_ERR_CODE_AUTHFAILED', 4);
@define('XMLRPC_ERR_NAME_AUTHFAILED', 'Authentication Failed');

$dispatches = array(
                    /* WordPress API */
                    'wp.getUsersBlogs' =>
                        array('function' => 'wp_getUsersBlogs'),
                    'wp.getCategories' =>
                        array('function' => 'wp_getCategories'),
                    'wp.uploadFile' =>
                        array('function' => 'wp_uploadFile'),
                    'wp.newCategory' =>
                        array('function' => 'wp_newCategory'),
                    'wp.getPostFormats' =>
                        array('function' => 'wp_getPostFormats'),
                    'wp.getComments' =>
                        array('function' => 'wp_getComments'),
                    'wp.deleteComment' =>
                        array('function' => 'wp_deleteComment'),
                    'wp.editComment' =>
                        array('function' => 'wp_editComment'),
                    'wp.newComment' =>
                        array('function' => 'wp_newComment'),
                    'wp.getTags' =>
                        array('function' => 'wp_getTags'),
					'wp.getOptions' =>
                        array('function' => 'wp_getOptions'),
					'wp.getPages' =>
                        array('function' => 'wp_getPages'),
					'wp.getPageList' =>
                        array('function' => 'wp_getPageList'),

					/* BLOGGER API */
                    'blogger.getUsersBlogs' =>
                        array('function' => 'blogger_getUsersBlogs'),
                    'blogger.getUserInfo' =>
                        array('function' => 'blogger_getUserInfo'),
                    'blogger.newPost' =>
                        array('function' => 'blogger_newPost'),
                    'blogger.editPost' =>
                        array('function' => 'blogger_editPost'),
                    'blogger.deletePost' =>
                        array('function' => 'blogger_deletePost'),
                    'blogger.getRecentPosts' =>
                        array('function' => 'blogger_getRecentPosts'),
                    'blogger.getPost' =>
                        array('function' => 'blogger_getPost'),

                    /* MT/metaWeblog API */
                    'metaWeblog.newPost' =>
                        array('function' => 'metaWeblog_newPost'),
                    'metaWeblog.editPost' =>
                        array('function' => 'metaWeblog_editPost'),
                    'metaWeblog.getPost' =>
                        array('function' => 'metaWeblog_getPost'),
                    'metaWeblog.deletePost' =>
                        array('function' => 'metaWeblog_deletePost'),
                    'metaWeblog.setPostCategories' =>
                        array('function' => 'metaWeblog_setPostCategories'),
                    'metaWeblog.getPostCategories' =>
                        array('function' => 'metaWeblog_getPostCategories'),
                    'metaWeblog.newMediaObject' =>
                        array('function' => 'metaWeblog_newMediaObject'),
                    'metaWeblog.getRecentPosts' =>
                        array('function' => 'metaWeblog_getRecentPosts'),
                    'metaWeblog.getCategories' =>
        		        array('function' => 'metaWeblog_getCategories'),
                        
                    'mt.getRecentPostTitles' =>
                        array('function' => 'mt_getRecentPostTitles'),
                    'mt.getCategoryList' =>
                        array('function' => 'mt_getCategoryList'),
                    'mt.getPostCategories' =>
                        array('function' => 'metaWeblog_getPostCategories'),
                    'mt.setPostCategories' =>
                        array('function' => 'metaWeblog_setPostCategories'),
                    'mt.supportedTextFilters' =>
                        array('function' => 'mt_supportedTextFilters'),
                    'mt.publishPost' =>
                        array('function' => 'metaWeblog_publishPost'),
                    'mt.supportedMethods' =>
                        array('function' => 'mt_supportedMethods')
                    );

function wp_getUsersBlogs($message) {
    global $serendipity;

    $val = $message->params[0];
    $username = $val->getval();
    $val = $message->params[1];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    $blog1 = new XML_RPC_Value(
        array('url'      => new XML_RPC_Value($serendipity['baseURL'], 'string'),
              'blogid'   => new XML_RPC_Value('1', 'string'),
              'blogName' => new XML_RPC_Value($serendipity['blogTitle'], 'string'),
              'isAdmin' => new XML_RPC_Value('false', 'boolean'),
			  'xmlrpc' =>  new XML_RPC_Value($serendipity['baseURL'] . 'serendipity_xmlrpc.php', 'string')
        ),
        'struct');
    $blogs = new XML_RPC_Value(array($blog1), 'array');
    #$blogs = $blog1;
    $r = new XML_RPC_Response($blogs);
    return($r);
}

function wp_uploadFile($message) {
    universal_debug("wp_uploadFile");
    return metaWeblog_newMediaObject($message);
}
function wp_getCategories($message) {
    global $serendipity;

    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    $cats = serendipity_fetchCategories($serendipity['authorid']);
    $xml_entries_vals = array();
    foreach ((array) $cats as $cat ) {
        if ($cat['categoryid']) {
            $values = array(
              'categoryId'    => new XML_RPC_Value($cat['categoryid'], 'int'),
              'categoryName'  => new XML_RPC_Value($cat['category_name'], 'string'),
              'description'   => new XML_RPC_Value($cat['category_description'], 'string'),
              'htmlUrl'       => new XML_RPC_Value(serendipity_categoryURL($cat, 'baseURL'), 'string'),
              'rssUrl'        => new XML_RPC_Value(serendipity_feedCategoryURL($cat, 'baseURL'), 'string')
            );
            if (!empty($cat['parentid'])) {
                $values['parentId'] = new XML_RPC_Value($cat['parentid'], 'int');
            }
            else {
                $values['parentId'] = new XML_RPC_Value(0, 'int');
            }
            $xml_entries_vals[] = new XML_RPC_Value($values,'struct');
        }
    }
    $xml_entries = new XML_RPC_Value($xml_entries_vals, 'array');
    return new XML_RPC_Response($xml_entries);
}

function wp_newCategory($message) {
    global $serendipity;
    
    universal_debug("wp_newCategory");

    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    $val = $message->params[3];
    if (is_object($val)) {
        $cat = XML_RPC_decode($val);
        $category = array();
        $category['category_name'] = $cat['name'];
        $category['category_description'] = $cat['description'];
        if (!empty($cat['parent_id'])) {
            $category['parentid'] = $cat['parent_id'];
        }
        if (serendipity_db_insert('category', $category)) {
            $saved = serendipity_fetchCategoryInfo(0, $cat['name']);
            $saved_id = $saved['categoryid'];
            return new XML_RPC_Response(new XML_RPC_Value($saved_id, 'i4'));
        }
    }
    return new XML_RPC_Response('', 99, 'Error writing category');
}

function wp_getPostFormats( $message ) {
    global $serendipity;
    
    universal_debug("wp_getPostFormats");

    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    if (count($message->params)>3) {
        $val = $message->params[3];
        $formats_to_show = $val->getval();
    }
    
    $all_formats = new XML_RPC_Value(
        array(
            'aside' => new XML_RPC_Value("Aside", 'string'), 
            'audio' => new XML_RPC_Value("Audio", 'string'), 
            'chat' => new XML_RPC_Value("Chat", 'string'), 
            'gallery' => new XML_RPC_Value("Gallery", 'string'), 
            'image' => new XML_RPC_Value("Image", 'string'), 
            'link' => new XML_RPC_Value("Link", 'string'), 
            'quote' => new XML_RPC_Value("Quote", 'string'), 
            'standard' => new XML_RPC_Value("Article", 'string'), 
            'status' => new XML_RPC_Value("Status", 'string'), 
            'video' => new XML_RPC_Value("Video", 'string'), 
        ),'struct'
    );
    $supported_formats = new XML_RPC_Value(
        array(
            'standard' => new XML_RPC_Value("Article (Serendipity)", 'string'), 
        ),'struct'
    );
    //return new XML_RPC_Response($all_formats);
    return new XML_RPC_Response($supported_formats);
}

function wp_getOptions($message) {
    global $serendipity;
    
    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    
    if (count($message->params)>3) {
        $val = $message->params[3];
        $filter = XML_RPC_decode($val);
    }
    
    $doFilter = !empty($filter) && is_array($filter) && count($filter) >0;
    
    $xml_entries_vals = array();
    if (empty($serendipity['xmlrpc_wpfakeversion'])) {
        if (!$doFilter || in_array('software_name', $filter)) 
            $xml_entries_vals[] = wp_getOptions_createOption('software_name', 'Serendipity');
        if (!$doFilter || in_array('software_version', $filter)) 
            $xml_entries_vals[] = wp_getOptions_createOption('software_version', $serendipity['version']);
    }
    else {
        if (!$doFilter || in_array('software_name', $filter)) 
            $xml_entries_vals[] = wp_getOptions_createOption('software_name', 'WordPress');
        if (!$doFilter || in_array('software_version', $filter)) 
            $xml_entries_vals[] = wp_getOptions_createOption('software_version', $serendipity['xmlrpc_wpfakeversion']);
    }
    if (!$doFilter || in_array('blog_url', $filter)) 
        $xml_entries_vals[] = wp_getOptions_createOption('blog_url', $serendipity['baseURL']);
    if (!$doFilter || in_array('blog_title', $filter)) 
        $xml_entries_vals[] = wp_getOptions_createOption('blog_title', $serendipity['blogTitle']);
    $xml_entries = new XML_RPC_Value($xml_entries_vals, 'array');
    return new XML_RPC_Response($xml_entries);
    
}
/**
 * Private function to create a single wpOption
 * @param string $desc
 * @param string $value
 * @param boolean $readonly default true
 */
function wp_getOptions_createOption($desc, $value, $readonly=true) {
    $values =             array(
        //'tag_id'     => new XML_RPC_Value(0, 'int'),
        'desc'     => new XML_RPC_Value($desc, 'string'),
        'readonly'     => new XML_RPC_Value($readonly, 'boolean'),
        'value'     => new XML_RPC_Value($value, 'string'),
    
    );
    return new XML_RPC_Value( $values, 'struct');
}

// Get an array of all the pages on a blog.
function wp_getPages($message) {
    global $serendipity;

    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    
    $xml_entries_vals = array();
    
    //TODO: For now this returns an empty array in order not to make the client crash. If we want to edit pages, we have to add some more code (to the static pages plugin) 
    
    $xml_entries = new XML_RPC_Value($xml_entries_vals, 'array');
    return new XML_RPC_Response($xml_entries);
}

// Get an array of all the pages on a blog. Just the minimum details, lighter than wp.getPages. 
function wp_getPageList($message) {
    global $serendipity;

    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    
    $xml_entries_vals = array();
    
    //TODO: For now this returns an empty array in order not to make the client crash. If we want to edit pages, we have to add some more code (to the static pages plugin) 
    
    $xml_entries = new XML_RPC_Value($xml_entries_vals, 'array');
    return new XML_RPC_Response($xml_entries);
}

function wp_getTags($message) {
    global $serendipity;

    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    
    $xml_entries_vals = array();
    
    if (class_exists('serendipity_event_freetag')) {
        $tags = serendipity_event_freetag::getAllTags();
        $rsslink = $serendipity['baseURL'] . 'rss.php?serendipity%5Btag%5D=';
        
        // Find the plugins tag http path setting
        $q = "select value from {$serendipity['dbPrefix']}config WHERE name LIKE 'serendipity_plugin_freetag:%/taglink'";
        $row = serendipity_db_query($q, true);
        if (is_array($row)) $http_url = $row['value'];
        else $http_url = $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/tag/'; // copied default from plugin
        
        foreach ($tags AS $tag => $count) {
            $values =             array(
                //'tag_id'     => new XML_RPC_Value(0, 'int'),
                'name'     => new XML_RPC_Value($tag, 'string'),
                'count'     => new XML_RPC_Value($count, 'int'),
                'slug'     => new XML_RPC_Value($tag, 'string'),
                'html_url'     => new XML_RPC_Value($http_url . $tag, 'string'),
                'rss_url'     => new XML_RPC_Value($rsslink . $tag, 'string'),
            
            );
            $xml_entries_vals[] = new XML_RPC_Value( $values, 'struct');
        }
    }
    
    $xml_entries = new XML_RPC_Value($xml_entries_vals, 'array');
    return new XML_RPC_Response($xml_entries);
    
}
function wp_getComments($message) {
    global $serendipity;
    
    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    
    $val = $message->params[3];
    $comment_filter =  $val->getval();
    
    $limit = !empty($comment_filter['number'])?$comment_filter['number']:'10'; // defaults to 10
    if (!empty($comment_filter['offset'])) $limit = serendipity_db_limit($comment_filter['offset'], $limit); 
    if (version_compare($serendipity['version'],'1.7-alpha1')>=0)
        $order = ' co.timestamp DESC';
    else 
        $order = ' DESC'; //  old versions have a bug here producing wrong results
    $showAll = $comment_filter['status'] != 'approve';
    $type = 'comments_and_trackbacks';
    
    $entries = serendipity_fetchComments($comment_filter['post_id'], $limit, $order, $showAll, $type);
    $xml_entries_vals = array();
    foreach ((array)$entries as $entry) {
        if ($entry['commentid']) {
            
            if ($entry['type']=='TRACKBACK') $type = 'trackback';
            else if ($entry['type']=='PINGBACK') $type = 'pingback';
            else $type = '';
             
            $values =             array(
				'date_created_gmt'  =>  new XML_RPC_Value(XML_RPC_iso8601_encode($entry['timestamp'], 1) . 'Z', 'dateTime.iso8601'),
                'userid'            => new XML_RPC_Value($entry['authorid'], 'string'),
                'comment_id'        => new XML_RPC_Value($entry['commentid'], 'int'),
                'parent'            => new XML_RPC_Value($entry['parent_id'], 'int'),
                'status'			=> new XML_RPC_Value($entry['status']=='approved'?'approved':'hold', 'string'),
                'content'			=> new XML_RPC_Value($entry['body'], 'string'),
                'link'			    => new XML_RPC_Value($entry['url'], 'string'),
        		'permaLink'         => new XML_RPC_Value(serendipity_archiveURL($entry['entryid'], $entry['title'], 'baseURL', true, array('timestamp' => $entry['timestamp'])) . '#c' . $entry['commentid'], 'string'),
            	'post_id'			=> new XML_RPC_Value($entry['entryid'], 'int'),
                'post_title'	    => new XML_RPC_Value($entry['title'], 'string'),
                'author'	        => new XML_RPC_Value($entry['author'], 'string'),
                'author_url'	    => new XML_RPC_Value($entry['url'], 'string'),
                'author_email'	    => new XML_RPC_Value($entry['email'], 'string'),
                'author_ip'	        => new XML_RPC_Value($entry['ip'], 'string'),
                'type'	            => new XML_RPC_Value($type, 'string'),
             );
             
            $xml_entries_vals[] = new XML_RPC_Value( $values, 'struct'); 
        }
    }
     
    $xml_entries = new XML_RPC_Value($xml_entries_vals, 'array');
    return new XML_RPC_Response($xml_entries);

}

function wp_deleteComment($message) {
    global $serendipity;
    
    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    
    $val = $message->params[3];
    $comment_id =  $val->getval();
    if (!empty($comment_id)) {
        // We need the entryid, so fetch it:
        $sql = serendipity_db_query("SELECT entry_id FROM {$serendipity['dbPrefix']}comments WHERE id = ". $comment_id, true);
        $entry_id = $sql['entry_id'];
        $result = serendipity_deleteComment($comment_id, $entry_id);
    }
    else {
        $result = false;
    }
    return new XML_RPC_Response(new XML_RPC_Value($result, 'boolean'));
}

/**
 * This will update the comment and approve/moderate it. 
 * @param unknown_type $message
 */
function wp_editComment($message) {
    global $serendipity;
    
    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    
    $val = $message->params[3];
    $comment_id =  $val->getval();
    $val = $message->params[4];
    $rpccomment =  $val->getval();
    
    if (!empty($comment_id)) {
        ob_start();
        
        // We need the entryid, so fetch it:
        $commentInfo = serendipity_db_query("SELECT c.entry_id as entry_id, c.body as content, c.email as author_email, c.author as comment_author, c.status as comment_status, c.url as author_url, e.authorid AS entry_authorid
        	FROM {$serendipity['dbPrefix']}comments c
        	LEFT JOIN {$serendipity['dbPrefix']}entries e ON (e.id = c.entry_id)
        	WHERE c.id = $comment_id"
        , true);
        
        // If we fetched a row, process it
        if (is_array($commentInfo)) {
            $entry_id = $commentInfo['entry_id'];
            $entry_authorid = $commentInfo['entry_authorid'];
            $comment_status = $commentInfo['comment_status'];
            
            // Setup new comment to save. Preserve old values, if nothing is given by the client.
            $comment = array(
                'author'  => empty($rpccomment['author'])       ? $commentInfo['author']       : $rpccomment['author'],
                'url'     => empty($rpccomment['author_url'])   ? $commentInfo['author_url']   : $rpccomment['author_url'],
                'email'   => empty($rpccomment['author_email']) ? $commentInfo['author_email'] : $rpccomment['author_email'],
                'body'    => empty($rpccomment['content'])      ? $commentInfo['content']      : $rpccomment['content'],
            );
            $result = universal_updateComment($comment_id, $entry_id, $entry_authorid, $comment);
            if ($result) {
                $rpc_comment_status = $rpccomment['status'];
                $result = serendipity_approveComment($comment_id, $entry_id, false, $rpc_comment_status !== 'approve');
                if ($result) {
                    // Sent out plugin hooks, perhaps someone is interested?
                    if ($rpc_comment_status=='spam') serendipity_plugin_api::hook_event('xmlrpc_comment_spam', $comment);
                    // dont call hooks, if we changed nothing (except for spam clicks, as Bayes is learning..)
                    elseif ($rpc_comment_status=='hold' && $comment_status != 'pending') serendipity_plugin_api::hook_event('xmlrpc_comment_pending', $comment);
                    elseif ($rpc_comment_status=='approve' && $comment_status != 'approved') serendipity_plugin_api::hook_event('xmlrpc_comment_approve', $comment);
                }
            }
        } else {
            $result = false;
        }
        $errs = ob_get_contents();
        if (!empty($errs)) universal_debug("errors: $errs");
        ob_clean();
    }
    else {
        $result = false;
    }
    return new XML_RPC_Response(new XML_RPC_Value($result, 'boolean'));
}
function wp_newComment($message) {
    global $serendipity;
    
    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    $val = $message->params[3];
    $article_id =  $val->getval();
    $val = $message->params[4];
    $comment =  $val->getval();
    
    // Setup defaults, if not given by client. The serendipity vars were setup while authenticating.
    if (empty($comment['author'])) $comment['author'] = $serendipity['serendipityRealname'];
    if (empty($comment['author_email'])) $comment['author_email'] = $serendipity['serendipityEmail'];
    
    $commentInfo['comment'] = $comment['content'];
    $commentInfo['name'] = $comment['author'];
    $commentInfo['url'] = $comment['author_url'];
    $commentInfo['email'] = $comment['author_email'];
    if (!empty($commentInfo['comment_parent'])) $commentInfo['comment_parent'] = $comment['parent_id'];
    
    universal_debug("Saving new comment: " .  print_r($commentInfo, true));
    $result = serendipity_insertComment($article_id, $commentInfo);
    return new XML_RPC_Response(new XML_RPC_Value($result, 'boolean'));
}
function blogger_getUsersBlogs($message) {
    global $serendipity;

    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    $blog1 = new XML_RPC_Value(
        array('url'      => new XML_RPC_Value($serendipity['baseURL'], 'string'),
              'blogid'   => new XML_RPC_Value('1', 'string'),
              'blogName' => new XML_RPC_Value($serendipity['blogTitle'], 'string')),
        'struct');
    $blogs = new XML_RPC_Value(array($blog1), 'array');
    #$blogs = $blog1;
    $r = new XML_RPC_Response($blogs);
    return($r);
}

function blogger_getUserInfo($message) {
    global $serendipity;
    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    $userdata = new XML_RPC_Value(
        array('nickname'  => new XML_RPC_Value($serendipity['serendipityUser']),
              'userid'    => new XML_RPC_Value($serendipity['authorid'], 'string'),
              'url'       => new XML_RPC_Value($serendipity['baseURL']),
              'email'     => new XML_RPC_Value($serendipity['serendipityEmail']),
              'lastname'  => new XML_RPC_Value(''),
              'firstname' => new XML_RPC_Value('')),
        'struct');
    $r = new XML_RPC_Response($userdata);
    return($r);
}

function blogger_getRecentPosts($message) {
    global $serendipity;
    $val = $message->params[2];
    $username = $val->getval();
    $val = $message->params[3];
    $password = $val->getval();
    $val = $message->params[4];
    $numposts = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    $entries = serendipity_fetchEntries('', false, $numposts, true);
    $xml_entries_vals = array();
    foreach ((array) $entries as $entry ) {
        if ($entry['id']) {
            $xml_entries_vals[] = new XML_RPC_Value(
            array(
                  'postid'      => new XML_RPC_Value($entry['id'], 'string'),
                  'title'       => new XML_RPC_Value($entry['title'], 'string'),
                  'content'     => new XML_RPC_Value($entry['body'], 'string'),
                  'userid'      => new XML_RPC_Value($entry['authorid'], 'string'),
                  'dateCreated' => new XML_RPC_Value(XML_RPC_iso8601_encode($entry['timestamp'], $serendipity['XMLRPC_GMT']) . ($serendipity['XMLRPC_GMT'] ? 'Z' : ''), 'dateTime.iso8601')
                  ), 'struct');
        }
    }
    $xml_entries = new XML_RPC_Value($xml_entries_vals, 'array');
    return new XML_RPC_Response($xml_entries);
}

function blogger_getPost($message) {
    global $serendipity;
    $val = $message->params[1];
    $postid = $val->getval();
    $val = $message->params[2];
    $username = $val->getval();
    $val = $message->params[3];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }

    $entry = serendipity_fetchEntry('id', $postid, true, 'true');
    $entry = new XML_RPC_Value(blogger_setEntry($entry), 'struct');
    return new XML_RPC_Response($entry);
}

function metaWeblog_getCategories($message) {
    global $serendipity;

    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    $cats = serendipity_fetchCategories($serendipity['authorid']);
    $xml_entries_vals = array();
    foreach ((array) $cats as $cat ) {
        if ($cat['categoryid']) $xml_entries_vals[] = new XML_RPC_Value(
            array(
              'categoryName'   => new XML_RPC_Value($cat['category_name'], 'string'),
              'description'   => new XML_RPC_Value($cat['category_name'], 'string'),
              'htmlUrl'       => new XML_RPC_Value(serendipity_categoryURL($cat, 'baseURL'), 'string'),
              'rssUrl'        => new XML_RPC_Value(serendipity_feedCategoryURL($cat, 'baseURL'), 'string')
            ),
            'struct'
        );
    }
    $xml_entries = new XML_RPC_Value($xml_entries_vals, 'array');
    return new XML_RPC_Response($xml_entries);
}


function mt_getCategoryList($message) {
    global $serendipity;

    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    $cats = serendipity_fetchCategories($serendipity['authorid']);
    $xml_entries_vals = array();
    foreach ((array) $cats as $cat ) {
        if ($cat['categoryid']) $xml_entries_vals[] = new XML_RPC_Value(
            array(
              'categoryId'   => new XML_RPC_Value($cat['categoryid'], 'string'),
              'categoryName' => new XML_RPC_Value($cat['category_name'], 'string')
            ),
            'struct'
        );
    }
    $xml_entries = new XML_RPC_Value($xml_entries_vals, 'array');
    return new XML_RPC_Response($xml_entries);
}

function metaWeblog_getRecentPosts($message) {
    global $serendipity;
    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    $val = $message->params[3];
    $numposts = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    $entries = serendipity_fetchEntries('', false, $numposts, true);
    $xml_entries_vals = array();

    foreach ((array)$entries as $tentry) {
        $entry = serendipity_fetchEntry('id', $tentry['id'], true, 'true');
        serendipity_plugin_api::hook_event('xmlrpc_fetchEntry', $entry);
        if ($entry['id']) {
            $xml_entries_vals[] = metaWeblog_createPostRpcValue($entry);
        }
     }
    $xml_entries = new XML_RPC_Value($xml_entries_vals, 'array');
    //universal_debug("rescentPosts: " . print_r($xml_entries,true));
    return new XML_RPC_Response($xml_entries);

}
function mt_getRecentPostTitles($message) {
    global $serendipity;
    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    $val = $message->params[3];
    $numposts = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    $entries = serendipity_fetchEntries('', false, $numposts, true);
    $xml_entries_vals = array();
    foreach ((array)$entries as $entry) {
        if ($entry['id']) {
            $xml_entries_vals[] = new XML_RPC_Value(
            array(
                'postid'      => new XML_RPC_Value($entry['id'], 'string'),
                'title'       => new XML_RPC_Value($entry['title'], 'string'),
                'userid'      => new XML_RPC_Value($entry['authorid'], 'string'),
                'dateCreated' => new XML_RPC_Value(XML_RPC_iso8601_encode($entry['timestamp'], $serendipity['XMLRPC_GMT']) . ($serendipity['XMLRPC_GMT'] ? 'Z' : ''), 'dateTime.iso8601')
            ),
            'struct');
        }
    }
    $xml_entries = new XML_RPC_Value($xml_entries_vals, 'array');
    return new XML_RPC_Response($xml_entries);
}

function mt_supportedTextFilters($message) {
    # we support no text filters currently
    return new XML_RPC_Response(new XML_RPC_Value(array(), 'array'));
}

function blogger_newPost($message) {
    global $serendipity;
    $val = $message->params[2];
    $username = $val->getval();
    $val = $message->params[3];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    $val = $message->params[4];
    $entry['body']  = universal_autohtml($val->getval());
    $val = $message->params[5];
    $topublish = $val->getval();
    if ($topublish == 1){
        $entry['isdraft'] = 'false';
    } else {
        $entry['isdraft'] = 'true';
    }

    $entry['allow_comments'] = serendipity_db_bool($serendipity['allowCommentsDefault']);
    $entry['moderate_comments'] = serendipity_db_bool($serendipity['moderateCommentsDefault']);
    ob_start();
    universal_fixEntry($entry);
    if (!is_array($entry['categories']) || count($entry['categories']) < 1) {
        if (!empty($serendipity['xmlrpc_default_category'])) {
        	$entry['categories'] = array($serendipity['xmlrpc_default_category'] => $serendipity['xmlrpc_default_category']);
        } else {
        	$entry['categories'] = array(0 => 0);
        }
    }

    $serendipity['POST']['properties']['fake'] = 'fake';
    $id = universal_updertEntry($entry);
    ob_clean();
    return new XML_RPC_Response(new XML_RPC_Value($id, 'string'));
}

function blogger_editPost($message) {
    $val = $message->params[1];
    $entry['id'] = $val->getval();
    $val = $message->params[2];
    $username = $val->getval();
    $val = $message->params[3];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    $val = $message->params[4];
    $entry['body']  = universal_autohtml($val->getval());
    $entry['author'] = $username;
    ob_start();
    universal_fixEntry($entry);
    $id = universal_updertEntry($entry);
    ob_clean();
    return new XML_RPC_Response(new XML_RPC_Value($id, 'string'));
}

function blogger_deletePost($message) {
    $val = $message->params[1];
    $entry['id'] = $val->getval();
    $val = $message->params[2];
    $username = $val->getval();
    $val = $message->params[3];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }

    ob_start();
    if ($entry['id']) {
        $id = serendipity_deleteEntry($entry['id']);
        serendipity_plugin_api::hook_event('xmlrpc_deleteEntry', $entry);
    }
    ob_clean();
    return new XML_RPC_Response(new XML_RPC_Value(true, 'boolean'));
}

function universal_fetchCategories($post_categories) {
    global $serendipity;

    $categories = array();
    if (is_array($post_categories)) {
        if (is_array($post_categories[0])) { // if it is a cat_id hash
            foreach($post_categories AS $cat_id => $cat_obj) {
                if (is_object($cat_obj)) {
                    $cat_name = $cat_obj->getval();
                    if (!empty($cat_name)) {
                        $cat = serendipity_fetchCategories(null, $cat_name);
                        if (isset($cat[0]['categoryid'])) {
                            $categories[$cat[0]['categoryid']] = $cat[0]['categoryid'];
                        }
                    }
                } elseif (is_array($cat_obj) && isset($cat_obj['categoryId'])) {
                    $cat_id = $cat_obj['categoryId']; //->getval();
                    if (!empty($cat_id)) {
                        $categories[$cat_id] = $cat_id;
                    }
                }
            }
        }
        else { // Just an array with names, has to be resolved to ids
            foreach($post_categories AS $cat_name) {
                $info = serendipity_fetchCategoryInfo(0, $cat_name);
                if (is_array($info)) {
                    $cat_id= $info['categoryid'];
                    $categories[$cat_id] = $cat_id;
                }
            }
        }
    }
    return $categories;
}

function metaWeblog_newPost($message) {
    global $serendipity;

    $val = $message->params[1];
    if (is_object($val)) {
        $username = $val->getval();
    } else {
        $username = '';
    }

    $val = $message->params[2];
    if (is_object($val)) {
        $password = $val->getval();
    } else {
        $password = '';
    }

    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }

    $val = $message->params[3];
    if (is_object($val)) {
        $post_array = XML_RPC_decode($val);// $val->getval();
    } else {
        $post_array = array();
    }
    
    $val = $message->params[4];
    if (is_object($val)) {
        $publish = $val->getval();
    } else {
        $publish = 1;
    }
    if (XMLRPC_WP_COMPATIBLE) {
        if ($post_array['post_status'] == 'draft') $publish = 0;
        else if ($post_array['post_status'] == 'publish') $publish = 1;
    }
    
    $entry['categories']        = universal_fetchCategories($post_array['categories']);
    $entry['title']             = @html_entity_decode($post_array['title'],ENT_COMPAT,'UTF-8');
    $entry['body']              = universal_autohtml($post_array['description']);
    if (XMLRPC_WP_COMPATIBLE) { // WP adds an obj behind an image upload
        universal_debug("body 1: " . $entry['body']);
        $entry['body'] = str_replace('￼', '', $entry['body']);
        universal_debug("body 2: " . $entry['body']);
    }
    $entry['extended']          = universal_autohtml($post_array['mt_text_more']);
    if (XMLRPC_WP_COMPATIBLE) { // WP adds an obj behind an image upload
        $entry['extended'] = str_replace('￼', '', $entry['extended']);
    }
    $entry['isdraft']           = ($publish == 0) ? 'true' : 'false';
    if (isset($post_array['mt_allow_comments'])) {
        $entry['allow_comments'] = serendipity_db_bool($post_array['mt_allow_comments']);
    } else {
        $entry['allow_comments'] = serendipity_db_bool($serendipity['allowCommentsDefault']);
    }
    $entry['moderate_comments'] = serendipity_db_bool($serendipity['moderateCommentsDefault']);

    if (isset($post_array['dateCreated'])) {
        $entry['timestamp']  = XML_RPC_iso8601_decode($post_array['dateCreated'],($post_array['dateCreated']{strlen($post_array['dateCreated'])-1} == "Z"));
    }
    
    ob_start();
    universal_fixEntry($entry);
    if (!is_array($entry['categories']) || count($entry['categories']) < 1) {
        if (!empty($serendipity['xmlrpc_default_category'])) {
        	$entry['categories'] = array($serendipity['xmlrpc_default_category'] => $serendipity['xmlrpc_default_category']);
        } else {
        	$entry['categories'] = array(0 => 0);
        }
    }

    $id = universal_updertEntry($entry);
    // Apply password has to be after serendipity_updertEntry, else it will override it empty!
    universal_save_entrypassword($id, $post_array['wp_password']);
    
    if ($id) {
        if (!$entry['id']) {
            $entry['id']=$id;
        }
        $entry['mt_keywords'] = $post_array['mt_keywords'];

        // check for custom fields
        if (isset($post_array['custom_fields'])) {
            $custom_fields = $post_array['custom_fields'];
            if (is_array($custom_fields)) {
                foreach($custom_fields as $custom_field) {
                    if (isset($custom_field['key'])) {
                        if ('geo_latitude'==$custom_field['key'])  $entry['geo_lat'] = $custom_field['value'];
                        else if ('geo_longitude'==$custom_field['key'])  $entry['geo_long'] = $custom_field['value'];
                        else if ('geo_public'==$custom_field['key'])  $entry['geo_public'] = $custom_field['value'];
                    }
                }
            }
        }
        serendipity_plugin_api::hook_event('xmlrpc_updertEntry', $entry);
    }
    $errs = ob_get_contents();
    ob_clean();

    return new XML_RPC_Response(new XML_RPC_Value($id, 'string'));
}

function metaWeblog_publishPost($message) {
    global $serendipity;

    $val = $message->params[0];
    $postid = $val->getval();
    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();

    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }

    $entry['isdraft']    = 'false';
    $entry['id']         = $postid;

    ob_start();
    if ($entry['id']) {
        universal_fixEntry($entry);
        $id = universal_updertEntry($entry);
    } else {
        $id = 0;
    }
    ob_clean();
    return new XML_RPC_Response(new XML_RPC_Value($id ? true : false, 'boolean'));
}

function metaWeblog_editPost($message) {
    global $serendipity;

    $val = $message->params[0];
    $postid = $val->getval();
    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();

    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }

    $val = $message->params[3];
    if (is_object($val)) {
        $post_array = XML_RPC_decode($val);
    } else {
        $post_array = $val->getval();
    }
    
    $val = $message->params[4];
    $publish = $val->getval();
    if (XMLRPC_WP_COMPATIBLE) {
        if ($post_array['post_status'] == 'draft') $publish = 0;
        else if ($post_array['post_status'] == 'publish') $publish = 1;
    }
    

    if (isset($post_array['categories'])) {
        $entry['categories'] = universal_fetchCategories($post_array['categories']);
    }
    
    $entry['title']          = @html_entity_decode($post_array['title'],ENT_COMPAT,'UTF-8');
    $entry['body']           = universal_autohtml($post_array['description']);
    $entry['extended']       = universal_autohtml($post_array['mt_text_more']);
    $entry['isdraft']        = ($publish == 0) ? 'true' : 'false';
    $entry['author']         = $username;
    $entry['authorid']       = $serendipity['authorid'];
    $entry['id']             = $postid;
    $entry['allow_comments'] = serendipity_db_bool($post_array['mt_allow_comments']);

    // Remember old geo coords for clients not resaving them:
    $entry_properties = serendipity_fetchEntryProperties($postid);
    if (is_array($entry_properties)) {
        $old_geo_long = $entry_properties['geo_long'];
        $old_geo_lat = $entry_properties['geo_lat'];
    }
    
    if (isset($post_array['dateCreated'])) {
        $entry['timestamp']  = XML_RPC_iso8601_decode($post_array['dateCreated'], ($post_array['dateCreated']{strlen($post_array['dateCreated'])-1} == "Z"));
        universal_debug("Handed date created: " . $post_array['dateCreated']);
    }
    else { // Get the original date, if no new date was defined
        $oldEntry = serendipity_fetchEntry('id', $postid, true, 'true');
        $entry['timestamp'] = $oldEntry['timestamp'];
    }
    ob_start();
    if ($entry['id']) {
        universal_fixEntry($entry);
        $id = universal_updertEntry($entry);
    } else {
        $id = 0;
    }
    
    // Apply password has to be after serendipity_updertEntry, else it will override it empty!
    universal_save_entrypassword($postid, $post_array['wp_password']);

    
    //if plugins want to manage it, let's instantiate all non managed meta
    if ($id) {
        $entry['mt_keywords'] = $post_array['mt_keywords'];
        
        // Resave old geo coord values (if not set by client)
        if (!empty($old_geo_lat) && !empty($old_geo_long)) {
            $entry['geo_lat'] = $old_geo_lat;
            $entry['geo_long'] = $old_geo_long;
        }
        
        // check for custom fields
        if (isset($post_array['custom_fields'])) {
            $custom_fields = $post_array['custom_fields'];
            if (is_array($custom_fields)) {
                foreach($custom_fields as $custom_field) {
                    if (isset($custom_field['key'])) {
                        if ('geo_latitude'==$custom_field['key'])  $entry['geo_lat'] = $custom_field['value'];
                        else if ('geo_longitude'==$custom_field['key'])  $entry['geo_long'] = $custom_field['value'];
                        else if ('geo_public'==$custom_field['key'])  $entry['geo_public'] = $custom_field['value'];
                    }
                }
                // If switched off by client, unset this
                if (isset($entry['geo_public']) && !$entry['geo_public']) {
                    unset($entry['geo_lat']);
                    unset($entry['geo_long']);
                }
            }
        }
        serendipity_plugin_api::hook_event('xmlrpc_updertEntry', $entry);
    }
    ob_clean();

    return new XML_RPC_Response(new XML_RPC_Value($id ? true : false, 'boolean'));
}

function universal_save_entrypassword($entryId, $password){
    global $serendipity;
    // Apply password:
    $q = "DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = " . (int)$entryId . " AND property = 'ep_entrypassword'";
    serendipity_db_query($q);
    if (!empty($password)) {
        $q = "INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, property, value) VALUES (" . (int)$entryId . ", 'ep_entrypassword', '" . serendipity_db_escape_string($password) . "')";
        serendipity_db_query($q);
    }
}

/**
 * This is not a XML RPC function. metaWeblog_getPost and metaWeblog_getRecentPosts produce exactly the same structure.
 * @param unknown_type $entry
 */
function metaWeblog_createPostRpcValue($entry) {
    global $serendipity;
    $values =             array(
        'dateCreated'       => new XML_RPC_Value(XML_RPC_iso8601_encode($entry['timestamp'], $serendipity['XMLRPC_GMT']) . ($serendipity['XMLRPC_GMT'] ? 'Z' : ''), 'dateTime.iso8601'),
        'postid'            => new XML_RPC_Value($entry['id'], 'string'),
        'userid'            => new XML_RPC_Value($entry['authorid'], 'string'),
        'description'       => new XML_RPC_Value($entry['body'], 'string'),
        'mt_excerpt'        => new XML_RPC_Value('', 'string'),
        'mt_allow_comments' => new XML_RPC_Value($entry['allow_comments'] ? 1 : 0, 'int'),
        'mt_text_more'      => new XML_RPC_Value($entry['extended'], 'string' ),
        'mt_allow_pings'    => new XML_RPC_Value($entry['allow_comments'] ? 1 : 0, 'int'), // we don't seperate the both.
        'mt_convert_breaks' => new XML_RPC_Value('', 'string'),
        'mt_keywords'       => new XML_RPC_Value(isset($entry['mt_keywords']) ? $entry['mt_keywords']:'', 'string'),
        'title'             => new XML_RPC_Value($entry['title'],'string'),
        'permaLink'         => new XML_RPC_Value(serendipity_archiveURL($entry['id'], $entry['title'], 'baseURL', true, array('timestamp' => $entry['timestamp'])), 'string'),
        'link'              => new XML_RPC_Value(serendipity_archiveURL($entry['id'], $entry['title'], 'baseURL', true, array('timestamp' => $entry['timestamp'])), 'string')
     );

     // Add geo coords if given:
    if (isset($entry['properties'])) {
        if (isset($entry['properties']['geo_lat']) && isset($entry['properties']['geo_long'])) {
            $geo_lat = new XML_RPC_Value(array(
            	'key'=> new XML_RPC_Value('geo_latitude', 'string'), 
            	'value'=>new XML_RPC_Value($entry['properties']['geo_lat'], 'double'),
            ), 'struct');
            $geo_long = new XML_RPC_Value(array(
            	'key'=> new XML_RPC_Value('geo_longitude', 'string'), 
            	'value'=>new XML_RPC_Value($entry['properties']['geo_long'], 'double'),
            ), 'struct');
            $values['custom_fields'] = new XML_RPC_Value(array($geo_lat, $geo_long), 'array');
        }
    }
    // Add Categories. metaWeblog supports names only.
    if (isset($entry['categories'])) {
        $rpc_categories = array();
        foreach ($entry['categories'] as $category)  {
            $rpc_categories[] = new XML_RPC_Value($category['category_name'], 'string');
        }
        $values['categories'] = new XML_RPC_Value($rpc_categories, 'array');
    }
        
    if (XMLRPC_WP_COMPATIBLE) {
        $values['wp_slug'] =  new XML_RPC_Value(serendipity_archiveURL($entry['id'], $entry['title'], 'baseURL', true, array('timestamp' => $entry['timestamp'])), 'string');
        $values['wp_author_id'] =  new XML_RPC_Value($entry['authorid'], 'string');
        $values['wp_author_display_name'] =  new XML_RPC_Value($entry['author'], 'string');
        $values['wp_post_format'] =  new XML_RPC_Value('', 'string');
        $draft = isset($entry['isdraft']) && serendipity_db_bool($entry['isdraft']);
        $values['post_status'] =  new XML_RPC_Value($draft?'draft':'publish', 'string');
        $values['date_created_gmt'] =  new XML_RPC_Value(XML_RPC_iso8601_encode($entry['timestamp'], 1) . 'Z', 'dateTime.iso8601');

        // Extended Article Properties supports passwords.
        $entry_properties = serendipity_fetchEntryProperties($entry['id']);
        if (is_array($entry_properties)) {
            $values['wp_password'] =  new XML_RPC_Value($entry_properties['ep_entrypassword'], 'string');
        }
        else {
            $values['wp_password'] =  new XML_RPC_Value('', 'string');
        }
        
    }
    return new XML_RPC_Value( $values, 'struct');
}

function metaWeblog_getPost($message) {
    global $serendipity;
    $val = $message->params[0];
    $postid = $val->getval();
    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }

    $entry = serendipity_fetchEntry('id', $postid, true, 'true');
    //if plugins want to manage it, let's get all non managed meta
    
    if ($entry["id"]) {
        serendipity_plugin_api::hook_event('xmlrpc_fetchEntry', $entry);
    }

    return new XML_RPC_Response(metaWeblog_createPostRpcValue($entry));
}

function metaWeblog_deletePost($message) {
    $val = $message->params[1];
    $entry['id'] = $val->getval();
    $val = $message->params[2];
    $username = $val->getval();
    $val = $message->params[3];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }
    $val = $message->params[4];
    $entry['body'] = $val->getval();
    $entry['author'] = $username;
    ob_start();
    $id = serendipity_deleteEntry($entry['id']);
    if ($entry['id']) {
        serendipity_plugin_api::hook_event('xmlrpc_deleteEntry', $entry);
    }
    ob_clean();
    return new XML_RPC_Response(new XML_RPC_Value(true, 'boolean'));
}

function metaWeblog_setPostCategories($message) {
    global $serendipity;
    $val = $message->params[0];
    $postid = $val->getval();
    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    $categories = $message->params[3];

    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }

    $category_ids = universal_fetchCategories(XML_RPC_decode($categories), true); // before: $categories->getval() instead of XML_RPC_decode
    $entry = serendipity_fetchEntry('id', $postid, true, 'true');

    if ($entry['id']) {
        $entry['categories'] = $category_ids;
        ob_start();
        universal_fixEntry($entry);
        $entry = universal_updertEntry($entry);
        ob_clean();
        return new XML_RPC_Response(new XML_RPC_Value(true, 'boolean'));
    } else {
        return new XML_RPC_Response(new XML_RPC_Value(false, 'boolean'));
    }
}

function metaWeblog_getPostCategories($message) {
    $val = $message->params[0];
    $postid = $val->getval();
    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }

    $entry = serendipity_fetchEntry('id', (int)$postid, true, 'true');

    $categories = array();
    if (is_array($entry['categories'])) {
        foreach($entry['categories'] AS $i => $cat) {
            $categories[] = new XML_RPC_Value(
                array(
                  'categoryId'   => new XML_RPC_Value($cat['categoryid'], 'string'),
                  'categoryName' => new XML_RPC_Value($cat['category_name'], 'string')
                ),
                'struct'
            );
        }
    }

    return new XML_RPC_Response(new XML_RPC_Value($categories, 'array'));
}

function metaWeblog_newMediaObject($message) {
    global $serendipity;
    $val = $message->params[0];
    $postid = $val->getval();
    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    $val = $message->params[3];
    $struct = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', XMLRPC_ERR_CODE_AUTHFAILED, XMLRPC_ERR_NAME_AUTHFAILED);
    }

    $full = $serendipity['serendipityPath'] . $serendipity['uploadPath'] . $struct['name'];

    if (!is_dir(dirname($full))) {
        @mkdir(dirname($full));
        @umask(0000);
        @chmod(dirname($full), 0755);            
    }

    # some tools are broken and don't base64_encode() the data before submitting;
    # Quoting http://www.xmlrpc.com/metaWeblogApi#metaweblognewmediaobject:
    # "bits is a base64-encoded binary value containing the content of the object."
    if (preg_match('#^[a-zA-Z0-9/+]*={0,2}$#', $struct['bits'])) {
        if ($decoded = base64_decode ($struct['bits'])) {
            $struct['bits'] = $decoded;
        }
    }

    $fp = fopen($full, 'w');
    fwrite($fp, $struct['bits']);
    fclose($fp);
    @umask(0000);
    @chmod($full, 0664);            
            
    $path = $serendipity['baseURL'] . $serendipity['uploadHTTPPath'] . $struct['name'];
    return new XML_RPC_Response(new XML_RPC_Value(array('url' => new XML_RPC_Value($path, 'string')), 'struct'));
}

function blogger_setEntry(&$entry) {
    $tmp = array(
          'content'           => new XML_RPC_Value($entry['extended'], 'string'),
    );
    return universal_setEntry($entry, $tmp);
}

function metaWeblog_setEntry(&$entry) {
    $tmp = array(
          'mt_text_more'      => new XML_RPC_Value($entry['extended'], 'string'),
    );
    return universal_setEntry($entry, $tmp);
}

function mt_supportedMethods($message) {
    $supported_methods = new XML_RPC_Value(
        array(
            /* Wordpress API */
            new XML_RPC_Value('wp.getUsersBlogs', 'string'),
            new XML_RPC_Value('wp.getCategories', 'string'),
            new XML_RPC_Value('wp.uploadFile', 'string'),
            new XML_RPC_Value('wp.newCategory', 'string'),
            new XML_RPC_Value('wp.getPostFormats', 'string'),
            new XML_RPC_Value('wp.getComments', 'string'),
            new XML_RPC_Value('wp.deleteComment', 'string'),
            new XML_RPC_Value('wp.editComment', 'string'),
            new XML_RPC_Value('wp.newComment', 'string'),
            new XML_RPC_Value('wp.getTags', 'string'),
            new XML_RPC_Value('wp.getOptions', 'string'),
            new XML_RPC_Value('wp.getPages', 'string'),
            new XML_RPC_Value('wp.getPageList', 'string'),

        	/* Blogger API */
            new XML_RPC_Value('blogger.getUsersBlogs', 'string'),
            new XML_RPC_Value('blogger.getUserInfo', 'string'),
            new XML_RPC_Value('blogger.newPost', 'string'),
            new XML_RPC_Value('blogger.editPost', 'string'),
            new XML_RPC_Value('blogger.deletePost', 'string'),
            new XML_RPC_Value('blogger.getRecentPosts', 'string'),
            new XML_RPC_Value('blogger.getPost', 'string'),

            /* MT/metaWeblog API */
            new XML_RPC_Value('metaWeblog.newPost', 'string'),
            new XML_RPC_Value('metaWeblog.editPost', 'string'),
            new XML_RPC_Value('metaWeblog.getPost', 'string'),
            new XML_RPC_Value('metaWeblog.deletePost', 'string'),
            new XML_RPC_Value('metaWeblog.setPostCategories', 'string'),
            new XML_RPC_Value('metaWeblog.getPostCategories', 'string'),
            new XML_RPC_Value('metaWeblog.newMediaObject', 'string'),
            new XML_RPC_Value('metaWeblog.getRecentPosts', 'string'),
            new XML_RPC_Value('mt.getRecentPostTitles', 'string'),
            new XML_RPC_Value('mt.getCategoryList', 'string'),
            new XML_RPC_Value('mt.getPostCategories', 'string'),
            new XML_RPC_Value('mt.setPostCategories', 'string'),
            /* mt.supportedTextFilters call not really supported ... */
/*          new XML_RPC_Value('mt.supportedTextFilters', 'string'),*/
            new XML_RPC_Value('mt.publishPost', 'string'),
            new XML_RPC_Value('metaWeblog.getCategories', 'string'),
            new XML_RPC_Value('mt.supportedMethods', 'string')
      ), 'array');
    return new XML_RPC_Response($supported_methods);
}

function universal_setEntry(&$entry, &$tmp) {
    global $serendipity;
    $tmp = array(
        'dateCreated'       => new XML_RPC_Value(XML_RPC_iso8601_encode($entry['timestamp'], $serendipity['XMLRPC_GMT']) . ($serendipity['XMLRPC_GMT'] ? 'Z' : ''), 'dateTime.iso8601'),
        'postid'            => new XML_RPC_Value($entry['id'], 'string'),
        'userid'            => new XML_RPC_Value($entry['authorid'], 'string'),
        'description'       => new XML_RPC_Value($entry['body'], 'string'),
        'mt_excerpt'        => new XML_RPC_Value('', 'string'),
        'mt_allow_comments' => new XML_RPC_Value(1, 'int'),
        'mt_allow_pings'    => new XML_RPC_Value(1, 'int'),
        'mt_convert_breaks' => new XML_RPC_Value('', 'string'),
        'mt_keywords'       => new XML_RPC_Value('', 'string'),
        'title'             => new XML_RPC_Value($entry['title'],'string'),
        'permalink'         => new XML_RPC_Value(serendipity_rewriteURL(PATH_ARCHIVES.'/' . $entry['id']. '_.html', 'baseURL'), 'string'),
        'link'              => new XML_RPC_Value(serendipity_rewriteURL(PATH_ARCHIVES.'/' . $entry['id'] . '_.html', 'baseURL'), 'string'),
    );

    return array_merge($entry, $tmp);
}

function universal_fixEntry(&$entry) {
    global $serendipity;
    unset($entry['properties']);

    if (empty($entry['timestamp']) || $entry['timestamp'] == 0) {
        $entry['timestamp'] = time();
    }
    
    if (empty($entry['allow_comments'])) {
        $entry['allow_comments'] = serendipity_db_bool($serendipity['allowCommentsDefault']);//(empty($serendipity['xml_rpc_default_allow_comments'])?'false':'true');
    }

    if (empty($entry['moderate_comments'])) {
        $entry['moderate_comments'] = serendipity_db_bool($serendipity['moderateCommentsDefault']);//(empty($serendipity['xml_rpc_default_moderate_comments'])?'false':'true');
    }
}

function universal_updertEntry(&$entry) {
    // The permission check is only executed, if this is set:
    $serendipity['GET']['adminModule'] = 'entries';
    return serendipity_updertEntry($entry);
}
function universal_updateComment($cid, $entry_id, $entry_authorid, &$comment) {
    global $serendipity;
    
    // Check for adminEntriesMaintainOthers
    if ($entry_authorid != $serendipity['authorid'] && !serendipity_checkPermission('adminEntriesMaintainOthers')) {
        return false; // wrong user having no adminEntriesMaintainOthers right
    }
    $sql = "UPDATE {$serendipity['dbPrefix']}comments
                    SET
                        author    = '" . serendipity_db_escape_string($somment['author'])    . "',
                        email     = '" . serendipity_db_escape_string($comment['email'])   . "',
                        url       = '" . serendipity_db_escape_string($comment['url'])     . "',
                        body      = '" . serendipity_db_escape_string($comment['body']) . "'
            WHERE id = " . (int)$cid . " AND entry_id = " . (int)$comment['entry_id'];
    serendipity_db_query($sql);
    serendipity_plugin_api::hook_event('backend_updatecomment', $comment, $cid);
    return true;
}

function universal_debug($message) {
    if (DEBUG_XMLRPC) {
        $fp = fopen(DEBUG_LOG_XMLRPC, 'a');
        fwrite($fp, $message . "\n");
        fflush($fp);
        fclose($fp);
    }
}

/**
 * Private function trying to detect, if the text is html or plain. If it is plain, it converts \n to <p>
 * @param string $text text to convert
 */
function universal_autohtml(&$text) {
    if (empty($text)) return $text;
    // if no p or br formatting is found, add it.
    if (!preg_match('@<p(.*)>@Usi', $text) && !preg_match('@</p>@Usi', $text) &&  !preg_match('@<br/?>@Usi', $text)) {
        $text = nl2p($text);
        $text = str_replace("\n", "", $text); // strip nl's in order not to have the nl2br plugin responding.
    }
    return $text;
}
/* stolen from nl2br plugin: Insert <p class="whiteline" at paragraphs ending with two newlines
 * Insert <p class="break" at paragraphs ending with one nl
 * @param string text
 * @return string
 * */
function nl2p(&$text) {
    if (empty($text)) {
        return $text;
    }
    //Standardize line endings:
    //DOS to Unix and Mac to Unix
    $text = str_replace(array("\r\n", "\r"), "\n", $text);
    $text = str_split($text);
    
    $big_p = '<p class="whiteline">';
    $small_p = '<p class="break">';

    $insert = true;
    $i = count($text);
    $whiteline = false;
    if ($text[$i-1] == "\n") {
        //prevent unnexessary p-tag at the end
        unset($text[$i-1]);
    }

    //main operation: convert \n to big_p and small_p 
    while ($i > 0) {
        if ($insert) {
            $i = next_nl_block($i, $text);
            if ($i == 0) {
                //prevent replacing of first character
                break;
            }                
            if ($whiteline == true) {
                $text[$i] = '</p>' . $big_p;
            } else {
                $text[$i] = '</p>' . $small_p;
            }
            $whiteline = false;
            $insert = false;
        } else {
            if ($text[$i-1] === "\n") {
                //newline is follower of a newline 
                $whiteline = true;
            }
            $insert = true;
        }
    }
    if ($whiteline) {
        $start_tag = $big_p;
    } else {
        $start_tag = $small_p;
    }
    return $start_tag . implode($text) . '</p>';
}
function next_nl_block($i, $text) {
    $skipped = false;
    for ($i--; $i>0; $i-- ) {
        if (!$skipped){
            //see if you skipped over a non-newline (heading to the next block)
            if (strpos($text[$i], "\n") === false) {
                $skipped = true;
            }
        }else if (strpos($text[$i], "\n") !== false) {
            break;
        }
    }
    return $i;
}


try {
    $server = new XML_RPC_Server($dispatches, 1, ($debug_xmlrpc === 2 ? 1 : 0));    
    
} catch (Exception $e) {
    $fp = fopen(DEBUG_LOG_XMLRPC, 'a');
    fwrite($fp, $e . "\n---------------------------------------\n");
    fclose($fp);
    ob_end_flush();
}

if ($debug_xmlrpc === 2) {
    print_r($GLOBALS['XML_RPC_Server_debuginfo']);
}

if ($debug_xmlrpc) {
    $fp = fopen(DEBUG_LOG_XMLRPC, 'a');
    fwrite($fp, ob_get_contents() . "\n---------------------------------------\n");
    fclose($fp);
    ob_end_flush();
}
/* vim: set sts=4 ts=4 expandtab : */
