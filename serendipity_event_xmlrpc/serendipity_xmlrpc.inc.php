<?php # $Id$
# Copyright (c) 2003-2005, Jannis Hermanns (on behalf the Serendipity Developer Team)
# All rights reserved.  See LICENSE file for licensing details

if (empty($HTTP_RAW_POST_DATA)) {
    global $HTTP_RAW_POST_DATA;
    $HTTP_RAW_POST_DATA = implode("\r\n", file('php://input'));
}

$debug_xmlrpc = 1;
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

$dispatches = array(
                    /* WordPress API */
                    'wp.getUsersBlogs' =>
                        array('function' => 'wp_getUsersBlogs'),
                    'wp.getCategories' =>
                        array('function' => 'wp_getCategories'),
                    'wp.uploadFile' =>
                        array('function' => 'wp_uploadFile'),

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
                    'metaWeblog.getCategories' =>
        		        array('function' => 'metaWeblog_getCategories'),
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
        return new XML_RPC_Response('', 4, 'Authentication Failed');
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

function wp_getCategories($message) {
    return mt_getCategoryList($message);
}
function wp_uploadFile($message) {
    universal_debug("wp_uploadFile");
    return metaWeblog_newMediaObject($message);
}

function blogger_getUsersBlogs($message) {
    global $serendipity;

    $val = $message->params[1];
    $username = $val->getval();
    $val = $message->params[2];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', 4, 'Authentication Failed');
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
        return new XML_RPC_Response('', 4, 'Authentication Failed');
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
        return new XML_RPC_Response('', 4, 'Authentication Failed');
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
        return new XML_RPC_Response('', 4, 'Authentication Failed');
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
        return new XML_RPC_Response('', 4, 'Authentication Failed');
    }
    $cats = serendipity_fetchCategories($serendipity['authorid']);
    $xml_entries_vals = array();
    foreach ((array) $cats as $cat ) {
        if ($cat['categoryid']) $xml_entries_vals[] = new XML_RPC_Value(
            array(
              'categoryName'   => new XML_RPC_Value($cat['category_name'], 'string'),
              'description'   => new XML_RPC_Value($cat['category_name'], 'string'),
              'htmlUrl'       => new XML_RPC_Value(serendipity_categoryURL($cat, 'serendipityHTTPPath'), 'string'),
              'rssUrl'        => new XML_RPC_Value(serendipity_feedCategoryURL($cat, 'serendipityHTTPPath'), 'string')
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
        return new XML_RPC_Response('', 4, 'Authentication Failed');
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
        return new XML_RPC_Response('', 4, 'Authentication Failed');
    }
    $entries = serendipity_fetchEntries('', false, $numposts, true);
    $xml_entries_vals = array();

    foreach ((array)$entries as $tentry) {
        $entry = serendipity_fetchEntry('id', $tentry['id'], true, 'true');
        serendipity_plugin_api::hook_event('xmlrpc_fetchEntry', $entry);
        if ($entry['id']) {
            $values =             array(
                'dateCreated'       => new XML_RPC_Value(XML_RPC_iso8601_encode($entry['timestamp'], $serendipity['XMLRPC_GMT']) . ($serendipity['XMLRPC_GMT'] ? 'Z' : ''), 'dateTime.iso8601'),
                'postid'            => new XML_RPC_Value($entry['id'], 'string'),
                'userid'            => new XML_RPC_Value($entry['authorid'], 'string'),
                'description'       => new XML_RPC_Value($entry['body'], 'string'),
                'mt_excerpt'        => new XML_RPC_Value('', 'string'),
                'mt_allow_comments' => new XML_RPC_Value($entry['allow_comments'] ? 1 : 0, 'int'),
                'mt_text_more'      => new XML_RPC_Value($entry['extended'], 'string' ),
                'mt_allow_pings'    => new XML_RPC_Value(1, 'int'),
                'mt_convert_breaks' => new XML_RPC_Value('', 'string'),
                'mt_keywords'       => new XML_RPC_Value(isset($entry['mt_keywords']) ? $entry['mt_keywords']:'', 'string'),
                'title'             => new XML_RPC_Value($entry['title'],'string'),
                'permalink'         => new XML_RPC_Value(serendipity_archiveURL($entry['id'], $entry['title'], 'serendipityHTTPPath', true, array('timestamp' => $entry['timestamp'])), 'string'),
                'link'              => new XML_RPC_Value(serendipity_archiveURL($entry['id'], $entry['title'], 'serendipityHTTPPath', true, array('timestamp' => $entry['timestamp'])), 'string')
             );
            if (XMLRPC_WP_COMPATIBLE) {
                $values['permaLink'] =  new XML_RPC_Value(serendipity_archiveURL($entry['id'], $entry['title'], 'serendipityHTTPPath', true, array('timestamp' => $entry['timestamp'])), 'string');
                $values['wp_slug'] =  new XML_RPC_Value(serendipity_archiveURL($entry['id'], $entry['title'], 'serendipityHTTPPath', true, array('timestamp' => $entry['timestamp'])), 'string');
                $values['wp_password'] =  new XML_RPC_Value('', 'string');
                $values['wp_author_id'] =  new XML_RPC_Value($entry['authorid'], 'string');
                $values['wp_author_display_name'] =  new XML_RPC_Value($entry['author'], 'string');
                $values['wp_post_format'] =  new XML_RPC_Value('', 'string');
                $draft = isset($entry['isdraft']) && serendipity_db_bool($entry['isdraft']);
                $values['post_status'] =  new XML_RPC_Value($draft?'draft':'publish', 'string');
            }
            $xml_entries_vals[] = new XML_RPC_Value( $values, 'struct');
        }
     }
    $xml_entries = new XML_RPC_Value($xml_entries_vals, 'array');
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
        return new XML_RPC_Response('', 4, 'Authentication Failed');
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
        return new XML_RPC_Response('', 4, 'Authentication Failed');
    }
    $val = $message->params[4];
    $entry['body']  = $val->getval();
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
    $id = serendipity_updertEntry($entry);
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
        return new XML_RPC_Response('', 4, 'Authentication Failed');
    }
    $val = $message->params[4];
    $entry['body']  = $val->getval();
    $entry['author'] = $username;
    ob_start();
    universal_fixEntry($entry);
    $id = serendipity_updertEntry($entry);
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
        return new XML_RPC_Response('', 4, 'Authentication Failed');
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
                    $cat_id = $cat_obj['categoryId']->getval();
                    if (!empty($cat_id)) {
                        $categories[$cat_id] = $cat_id;
                    }
                }
            }
        }
        else { // Just an array with names, has to be resolved to ids
            foreach($post_categories AS $cat_name) {
                $info = serendipity_fetchCategoryInfo(0, $cat_name);
                $cat_id= $info['categoryid'];
                $categories[$cat_id] = $cat_id;
            }
        }
    }
    return $categories;
}

function metaWeblog_newPost($message) {
    global $serendipity;

    universal_debug("newPost dispatch called.");
    
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

    universal_debug("Incoming user $username : $password");

    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', 4, 'Authentication Failed');
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
    $entry['body']              = $post_array['description'];
    if (XMLRPC_WP_COMPATIBLE) { // WP adds an obj behind an image upload
        universal_debug("body 1: " . $entry['body']);
        $entry['body'] = str_replace('￼', '', $entry['body']);
        universal_debug("body 2: " . $entry['body']);
    }
    $entry['extended']          = $post_array['mt_text_more'];
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

    $id = serendipity_updertEntry($entry);

    universal_debug("Created entry: " . print_r($id, true));

    if ($id) {
        if (!$entry['id']) {
            $entry['id']=$id;
        }
        $entry['mt_keywords'] = $post_array['mt_keywords'];
        serendipity_plugin_api::hook_event('xmlrpc_updertEntry', $entry);
    }
    $errs = ob_get_contents();
    ob_clean();

    universal_debug("Outgoing Data: " . $errs);

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
        return new XML_RPC_Response('', 4, 'Authentication Failed');
    }

    $entry['isdraft']    = 'false';
    $entry['id']         = $postid;

    ob_start();
    if ($entry['id']) {
        universal_fixEntry($entry);
        $id = serendipity_updertEntry($entry);
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
        return new XML_RPC_Response('', 4, 'Authentication Failed');
    }

    $val = $message->params[3];
    $post_array = $val->getval();
    $val = $message->params[4];
    $publish = $val->getval();
    if (XMLRPC_WP_COMPATIBLE) {
        if ($post_array['post_status'] == 'draft') $publish = 0;
        else if ($post_array['post_status'] == 'publish') $publish = 1;
    }
    

    universal_debug("metaWeblog_editPost");
    universal_debug(print_r($post_array, true));
    
    if (isset($post_array['categories'])) {
        $entry['categories'] = universal_fetchCategories($post_array['categories']);
    }
    $entry['title']          = @html_entity_decode($post_array['title'],ENT_COMPAT,'UTF-8');
    $entry['body']           = $post_array['description'];
    $entry['extended']       = $post_array['mt_text_more'];
    $entry['isdraft']        = ($publish == 0) ? 'true' : 'false';
    $entry['author']         = $username;
    $entry['authorid']       = $serendipity['authorid'];
    $entry['id']             = $postid;
    $entry['allow_comments'] = serendipity_db_bool($post_array['mt_allow_comments']);

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
        $id = serendipity_updertEntry($entry);
    } else {
        $id = 0;
    }

    //if plugins want to manage it, let's instantiate all non managed meta
    if ($id) {
        $entry['mt_keywords'] = $post_array['mt_keywords'];
        serendipity_plugin_api::hook_event('xmlrpc_updertEntry', $entry);
    }
    ob_clean();

    return new XML_RPC_Response(new XML_RPC_Value($id ? true : false, 'boolean'));
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
        return new XML_RPC_Response('', 4, 'Authentication Failed');
    }

    $entry = serendipity_fetchEntry('id', $postid, true, 'true');
    //if plugins want to manage it, let's get all non managed meta
    if ($entry["id"]) {
        serendipity_plugin_api::hook_event('xmlrpc_fetchEntry', $entry);
    }

    $tmp = new XML_RPC_Value(array(
        'userid'            => new XML_RPC_Value($entry['authorid'], 'string'),
        'dateCreated'       => new XML_RPC_Value(XML_RPC_iso8601_encode($entry['timestamp'], $serendipity['XMLRPC_GMT']) . ($serendipity['XMLRPC_GMT'] ? 'Z' : ''), 'dateTime.iso8601'),
        'postid'            => new XML_RPC_Value($postid, 'string'),
        'description'       => new XML_RPC_Value($entry['body'], 'string'),
        'title'             => new XML_RPC_Value($entry['title'],'string'),
        'link'              => new XML_RPC_Value(serendipity_archiveURL($entry['id'], $entry['title'], 'baseURL', true, array('timestamp' => $entry['timestamp'])), 'string'),
        'permalink'         => new XML_RPC_Value(serendipity_archiveURL($entry['id'], $entry['title'], 'baseURL', true, array('timestamp' => $entry['timestamp'])), 'string'),
        'mt_excerpt'        => new XML_RPC_Value($entry['excerpt'], 'string'),
        'mt_text_more'      => new XML_RPC_Value($entry['extended'], 'string'),
        'mt_allow_comments' => new XML_RPC_Value(($entry['allow_comments'] == true ? 1 : 0), 'int'),
        'mt_allow_pings'    => new XML_RPC_Value(($entry['mt_allow_pings'] == true ? 1 : 0), 'int'),
        'mt_convert_breaks' => new XML_RPC_Value($entry['mt_convert_breaks'], 'string'),
        'mt_keywords'       => new XML_RPC_Value($entry['mt_keywords'], 'string')), 'struct');

    return new XML_RPC_Response($tmp);
}

function metaWeblog_deletePost($message) {
    $val = $message->params[1];
    $entry['id'] = $val->getval();
    $val = $message->params[2];
    $username = $val->getval();
    $val = $message->params[3];
    $password = $val->getval();
    if (!serendipity_authenticate_author($username, $password)) {
        return new XML_RPC_Response('', 4, 'Authentication Failed');
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
        return new XML_RPC_Response('', 4, 'Authentication Failed');
    }

    $category_ids = universal_fetchCategories($categories->getval(), true);
    $entry = serendipity_fetchEntry('id', $postid, true, 'true');

    if ($entry['id']) {
        $entry['categories'] = $category_ids;
        ob_start();
        universal_fixEntry($entry);
        $entry = serendipity_updertEntry($entry);
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
        return new XML_RPC_Response('', 4, 'Authentication Failed');
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
        return new XML_RPC_Response('', 4, 'Authentication Failed');
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
        $entry['allow_comments'] = (empty($serendipity['xml_rpc_default_allow_comments'])?'false':'true');
    }

    if (empty($entry['moderate_comments'])) {
        $entry['moderate_comments'] = (empty($serendipity['xml_rpc_default_moderate_comments'])?'false':'true');
    }
}

function universal_debug($message) {
    if (DEBUG_XMLRPC) {
        $fp = fopen(DEBUG_LOG_XMLRPC, 'a');
        fwrite($fp, $message . "\n");
        fclose($fp);
    }
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
