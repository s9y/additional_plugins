<?php # $Id: smarty.inc.php,v 1.2 2007/07/10 08:55:43 garvinhicking Exp $

// You can fetch static pages via smarty as well. Syntax:
//
// {staticpage_display template="$TEMPLATE" pagevar="$PAGEVAR" id="$ID" permalink="$PERMALINK" pagetitle="$PAGETITLE" authorid="$AUTHORID" query="$QUERY"}
//
// Variable options:
// $TEMPLATE can be replaced with the name of the staticpage template to parse. It defaults to "plugin_staticpage.tpl".
// $PAGEVAR must match the variable prefix of the staticpage template. If you want to parse multiple staticpages,
// you might need to seperate those from each other. Always use the variable prefix that is also employed in the template file.
//
// To retrieve a staticpage, you need to supply either one of those options:
// $ID can be replaced with the ID of the staticpage you want to fetch.
// $PERMALINK can be replaced with the fully configured permalink of a staticpage.
// $PAGETITLE can be replaced with the URL shorthand/backwards compatibility name of a staticpage
// $AUTHORID additionally can be combined with the variables above to restrict output to a specific author
//
// If you need more customization, you can pass a SQL query directly using $QUERY.
//
// EXAMPLE:
// To fetch a static page with the URL shorthand name 'static' you simply put this in your template file (index.tpl, a userprofile .tpl or whatever):
// {staticpage_display pagetitle='static'}
//

function staticpage_display($params, &$smarty) {
    global $serendipity;

    if (empty($params['template'])) {
        $params['template'] = 'plugin_staticpage.tpl';
    }

    if (empty($params['pagevar'])) {
        $params['pagevar'] = 'staticpage_';
    }

    if (!empty($params['id'])) {
        $where = "id = '" . serendipity_db_escape_string($params['id']) . "'";
    } elseif (!empty($params['pagetitle'])) {
        $where = "pagetitle = '" . serendipity_db_escape_string($params['pagetitle']) . "'";
    } elseif (!empty($params['permalink'])) {
        $where = "permalink = '" . serendipity_db_escape_string($params['permalink']) . "'";
    } else {
        $smarty->trigger_error(__FUNCTION__ .": missing 'id', 'permalink' or 'pagetitle' parameter");
        return;
    }

    if (!empty($params['authorid'])) {
        $where .= " AND authorid = " . (int)$params['authorid'];
    }

    if (empty($params['query'])) {
        $params['query'] = "SELECT *
                              FROM {$serendipity['dbPrefix']}staticpages
                             WHERE $where
                             LIMIT 1";
    }

    $page = serendipity_db_query($params['query'], true, 'assoc');

    if (is_array($page)) {
        $old_staticpage = $serendipity['staticpage_plugin']->staticpage;
        $serendipity['staticpage_plugin']->staticpage =& $page;
        $serendipity['staticpage_plugin']->checkPage();

        echo $serendipity['staticpage_plugin']->parseStaticPage($params['pagevar'], $params['template']);
        $serendipity['staticpage_plugin']->staticpage = $old_staticpage;

        return;
    }
}


 /**
 * Smarty Function: Returns the s9y-URL for a given category-id
 *
 * @access public
 * @data   array       Smarty parameter input array:
 *                          cid: id of the category
 * @param   object  Smarty object
 * @return string       The URL of the category - must be added to {$serendipityBaseURL} for a full URL
 */

function smarty_getCategoryLinkByID ($data, &$smarty) {
    $cat    = serendipity_fetchCategoryInfo($data['cid']);
    $result = serendipity_getPermalink($cat, 'category');
    return $result;
}

/**
 * Smarty Function: Get the URL to the archives-path
 *
 * @access public
 * @return  string      The archive-path
 */

function getArchiveURL() {
    global $serendipity;
    return serendipity_rewriteURL(PATH_ARCHIVES);
}