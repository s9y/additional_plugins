<?php # $Id$

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_POPULARENTRIES_TITLE', 'Popular Entries');
@define('PLUGIN_POPULARENTRIES_BLAHBLAH', 'Shows the titles and number of comments of the most popular entries calculated according to the entries most commented on.');
@define('PLUGIN_POPULARENTRIES_NUMBER', 'Number of entries');
@define('PLUGIN_POPULARENTRIES_NUMBER_BLAHBLAH', 'How many entries should be displayed? (Default: 10)');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM', 'Skip front page entries');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM_DESC', 'Only recent entries that are not on the front page will be shown. (Default: latest ' . $serendipity['fetchLimit'] . ' will be skipped)');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM_RADIO_ALL', 'Show all');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM_RADIO_POPULAR', 'Skip front page items');
@define('PLUGIN_POPULARENTRIES_SORTBY', 'Sort entries by:');
@define('PLUGIN_POPULARENTRIES_SORTBY_COMMENTS', 'comments');
@define('PLUGIN_POPULARENTRIES_SORTBY_COMMENTORS', 'commentors');
@define('PLUGIN_POPULARENTRIES_SORTBY_VISITS', 'most visits [requires karma plugin]');
@define('PLUGIN_POPULARENTRIES_SORTBY_LOWVISITS', 'less visits [requires karma plugin]');
@define('PLUGIN_POPULARENTRIES_SORTBY_KARMAVOTES', 'karma [requires karma plugin]');
@define('PLUGIN_POPULARENTRIES_SORTBY_EXITS', 'top-exits [requires Track Exits plugin]');
@define('PLUGIN_POPULARENTRIES_SORTBY_COMMENTORS_FILTER', 'Filtered commentors');
@define('PLUGIN_POPULARENTRIES_SORTBY_COMMENTORS_FILTER_DESC', 'Comma-separated list (no blanks!) of commentor names that will be filtered when sorting entries by commentors.');
