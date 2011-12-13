<?php # $Id: lang_en.inc.php,v 1.3 2006/04/30 10:26:11 garvinhicking Exp $

/**
 *  @version $Revision: 1.3 $
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_RELATEDLINKS_TITLE', 'Related entries/links');
@define('PLUGIN_EVENT_RELATEDLINKS_DESC', 'Insert related links/entries per entry. For flexibility you can edit the "plugin_relatedlinks.tpl" Smarty-Template file to adjust the output. Note that this plugin only outputs data in the detailed/full entry view.');
@define('PLUGIN_EVENT_RELATEDLINKS_ENTERDESC', 'Enter the related links you want to show. One URL (no HTML code!) per line (means: separated by newlines). If you want to enter a description, use this format: http://example.com/link.html=Example Link. Everything after the "=" will be used as description. If that is not entered, only the link will be shown as title');
@define('PLUGIN_EVENT_RELATEDLINKS_LIST', 'Related Links:');

@define('PLUGIN_EVENT_RELATEDLINKS_POSITION', 'Position for the related entries/links');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_DESC', 'Append list of related links to the footer of the entry or use Smarty templating? If you activate the Smarty templating, you need to insert this line into your entries.tpl template inside the foreach loop where $entry is set (i.e. the place where comments, trackbacks and the extended entry is shown): {serendipity_hookPlugin hook="frontend_display_relatedlinks" data=$entry hookAll="true"}{$RELATEDLINKS}');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_FOOTER', 'Place in entry-footer');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_BODY', 'Place in entry-body');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_SMARTY', 'Use Smarty call');

@define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR', 'Link separation character');
@define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR_DESC', 'Enter the character that will split entry URLs and descriptions. Be careful to choose one character that does neither exist in the URL nor the title, like "|".');

?>
