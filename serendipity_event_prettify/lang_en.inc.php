<?php # 

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_PRETTIFY_NAME', 'Prettify for S9Y');
@define('PLUGIN_PRETTIFY_DESC', 'Use Prettify to brush content between PRE tags for simple syntax highlighting.');
@define('PLUGIN_PRETTIFY_AUTH', 'Adam Krause');
@define('PLUGIN_PRETTIFY_JSPATH', 'Path to prettify.js');
@define('PLUGIN_PRETTIFY_JSPATH_DESC', 'Specify path from S9Y root to prettify.js');
@define('PLUGIN_PRETTIFY_CSSPATH', 'Path to prettify.css');
@define('PLUGIN_PRETTIFY_CSSPATH_DESC', 'Specify path from S9Y root to prettify.css');
@define('PLUGIN_PRETTIFY_GENERICPRE', 'How should Prettify handle syntax highlighting of PRE blocks?');
@define('PLUGIN_PRETTIFY_GENERICPRE_DESC', 'Apply generic syntax highlighting to all content inside of PRE tags regardless of code language specified in CLASS.');
@define('PLUGIN_PRETTIFY_GENERICPRE_TRUE', 'Generic');
@define('PLUGIN_PRETTIFY_GENERICPRE_FALSE', 'Language-Specific');
@define('PLUGIN_PRETTIFY_GENERICCODE', 'How should Prettify handle syntax highlighting of CODE blocks?');
@define('PLUGIN_PRETTIFY_GENERICCODE_DESC', 'Apply generic syntax highlighting to all content inside of CODE tags regardless of code language specified in CLASS.');
@define('PLUGIN_PRETTIFY_GENERICCODE_TRUE', 'Generic');
@define('PLUGIN_PRETTIFY_GENERICCODE_FALSE', 'Language-Specific');
@define('PLUGIN_PRETTIFY_CONVERTANGLE', 'Provide an editor button to convert angle brackets');
@define('PLUGIN_PRETTIFY_CONVERTANGLE_DESC', 'Only appears in the standard (non-WYSIWYG) editor, select PRE/CODE block and click button to encode angles.  WYSIWYG editors auto-magically encode angles.');
@define('PLUGIN_PRETTIFY_CONVERTANGLE_TRUE', 'Yes');
@define('PLUGIN_PRETTIFY_CONVERTANGLE_FALSE', 'No');
?>
