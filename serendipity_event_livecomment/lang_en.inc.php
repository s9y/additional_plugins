<?php # 

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_LIVECOMMENT_NAME', 'Enhanced Comment Area');
@define('PLUGIN_EVENT_LIVECOMMENT_DESC', 'Uses JavaScript to show a live preview and markup-buttons');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT', 'Choose method for display.');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT_DESC', 'The jQuery method uses javascript functions to render the comments on screen, directly before the comment form. It is quick and gets the job done in most cases, but only supports a specific set of text formattings (BBCode, Textile, s9y, nl2br, markdown). 
The old legacy method uses real AJAX calls to exactly format the comment with all possible markups (Wiki, Emoticons, etc) but is more laggy and inserts the comment preview at the exact place where it will later be shown.
NOTE: Your template needs to support the usual CSS IDs and Classes to work properly (#serendipity_replyform_*, #serendipity_commentForm etc. from commentform.tpl).');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT_JQUERY', 'jQuery (fixed position, faster and nicer)');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT_LEGACY', 'Old, legacy method (indented position, full markup support)');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT_NONE', 'None (deactivate the preview)');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_TITLE', 'Live Preview');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON', 'Markup Buttons');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_DESC', 'Places Buttons above the commentarea to format the text easily.');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION', 'Preview Animation');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION_DESC', 'Which animation shall be used to exhibit the preview-area? Select "show" if none.');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION_SPEED', 'Preview-Area Animation Speed');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION_SPEED_DESC', 'Choose the keyword "fast", "def" or "slow" or a number (in ms).');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION', 'Markup Buttons Animation');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION_DESC', 'Which animation shall be used to exhibit the buttons? Select "show" if none.');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION_SPEED', 'Markup Buttons Animation-Speed');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION_SPEED_DESC', 'Choose the keyword "fast", "def" or "slow" or a number (in ms).');
@define('PLUGIN_EVENT_LIVECOMMENT_TIMEOUT', 'Ajax Latency');
@define('PLUGIN_EVENT_LIVECOMMENT_TIMEOUT_DESC', 'Latency until the Buttons are shown, as from now the ajax-call has to be complete. Leave blank if unsure.');
@define('PLUGIN_EVENT_LIVECOMMENT_ELASTIC', 'Elastic Commentarea');
@define('PLUGIN_EVENT_LIVECOMMENT_ELASTIC_DESC', 'Resizes the textarea if necessary.');
@define('PLUGIN_EVENT_LIVECOMMENT_BOLD', 'bold');
@define('PLUGIN_EVENT_LIVECOMMENT_ITALIC', 'italic');
@define('PLUGIN_EVENT_LIVECOMMENT_UNDERLINE', 'underlined');
@define('PLUGIN_EVENT_LIVECOMMENT_URL', 'link');
@define('PLUGIN_EVENT_LIVECOMMENT_INLINE', 'Inline JavaScript');
@define('PLUGIN_EVENT_LIVECOMMENT_INLINE_DESC', 'Adds the JavaScript-Variables directly to the HTML-Output, improving performance.');
@define('PLUGIN_EVENT_LIVECOMMENT_PATH', 'Plugin Path');
@define('PLUGIN_EVENT_LIVECOMMENT_PATH_DESC', 'If a path is entered he is no longer determined dynamically, improving performance considerable. Example: http://www.example.com/plugins/serendipity_event_livecomment/ (note the / at the end).');
