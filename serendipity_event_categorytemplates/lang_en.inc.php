<?php # 

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_CATEGORYTEMPLATES_NAME', 'Properties/Templates of categories');
@define('PLUGIN_CATEGORYTEMPLATES_DESC', 'This plugin provides additional properties for categories and their entries, including custom templates, sort order, display limit, password protection, and RSS hiding.');
@define('PLUGIN_CATEGORYTEMPLATES_SELECT', 'Please enter the directory name of the template you wish to use for this category. The relative directory names begin below the templates/ structure. So you can use i.e. "blue" or "kubrick". You can also enter a subdirectory name, if you saved a subdirectory within your template directory as if it were a template on its own. Then you can enter i.e. "blue/category1" or "blue/category2".<br />To change the order categories will be considered in when custom templates are applied, configure the category templates plugin.');
@define('PLUGIN_CATEGORYTEMPLATES_FETCHLIMIT', 'Entries to display on category frontpage');
@define('PLUGIN_CATEGORYTEMPLATES_PASS', 'Password protection:');
@define('PLUGIN_CATEGORYTEMPLATES_PASS_DESC', 'Should password-protection of categories be allowed? The drawbacks are that another database lookup needs to be made, and that entries in password-protected categories are NOT shown on the frontpage for users until they go to the protected category\'s view.');
@define('PLUGIN_CATEGORYTEMPLATES_PASS_USER', 'Serendipity Category Password protection');
@define('PLUGIN_CATEGORYTEMPLATES_FIXENTRY', 'Globally set entry\'s category');
@define('PLUGIN_CATEGORYTEMPLATES_FIXENTRY_DESC', 'If enabled, the category of an article in single entry view will be set as the current category.');
@define('PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE', 'Precedence of category templates');
@define('PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE_DESC', 'When an entry is assigned to multiple categories, this list determines the category whose custom template is applied.  The category on top is considered first.');
@define('PLUGIN_CATEGORYTEMPLATES_NO_CUSTOMIZED_CATEGORIES', 'No categories have customized templates yet.');
@define('PLUGIN_CATEGORYTEMPLATES_HIDERSS', 'Should entries in this category be hidden from RSS feeds?');
