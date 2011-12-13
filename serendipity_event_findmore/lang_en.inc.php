<?php # $Id: lang_en.inc.php,v 1.10 2011/06/10 10:30:46 garvinhicking Exp $

/**
 *  @version $Revision: 1.10 $
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_FINDMORE_NAME', 'Show links to services like Facebook, Digg, Technorati, del.icio.us, spread.ly etc related to your entry.');
@define('PLUGIN_FINDMORE_DESCRIPTION', 'You can remove/insert other custom services to link to via the "plugin_findmore.tpl" template file easily. Also remember that if you want to save grandma\'s performance pennies that you can also insert the HTML/JS snippets into your entries.tpl template file instead of using this plugin!');

@define('PLUGIN_FINDMORE_PATH_NAME', 'Relative path to Findmore images');
@define('PLUGIN_FINDMORE_PATH_DESC', 'Enter the relative path to where you stored the images for the specific services. Usually points to the plugin directory!');

@define('PLUGIN_FINDMORE_DIGGCOUNT_DISPLAY_NAME', 'Display DiggCount badge');
@define('PLUGIN_FINDMORE_DIGGCOUNT_DISPLAY_DESC', 'Display the DiggCount badge for Digg links.');

@define('PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_NAME', 'DiggCount placement');
@define('PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_DESC', 'Determines the placement of the DiggCount badge.');

@define('PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_BEFORE-ENTRY', 'Before entry');
@define('PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_AFTER-ENTRY', 'After entry');
@define('PLUGIN_FINDMORE_DIGGCOUNT_PLACEMENT_AFTER-FINDMORE', 'After Findmore links');

@define('PLUGIN_EVENT_FINDMORE_DISABLED_SERVICES', 'Disabled services');
@define('PLUGIN_EVENT_FINDMORE_DISABLED_SERVICES_DESC', 'Select which services should NOT be shown. Select multiple values with Ctrl-Click.');

@define('PLUGIN_EVENT_FINDMORE_LAZYLOAD', 'Enable tracking security (for Facebook Like)');
@define('PLUGIN_EVENT_FINDMORE_LAZYLOAD_DESC', 'When enabled, all links to foreign services (like Facebook) will only load once the user has clicked on it. This is especially important for countries like Germany, where tracking without a user\s consent is forbidden. Requires javascript.');

@define('PLUGIN_EVENT_FINDMORE_LAZYLOAD_TEXT', 'Text for tracking security');
@define('PLUGIN_EVENT_FINDMORE_LAZYLOAD_TEXT_DESC', 'Enter the text that instructs the user to click on, so that the foreign service (like Facebook) will load. Can also be HTML code.');

@define('PLUGIN_FINDMORE_EXTENDEDONLY', 'Only extended article');
@define('PLUGIN_FINDMORE_EXTENDEDONLY_BLAHBLAH', 'Only show social bookmarks on extended article view?');

@define('PLUGIN_FINDMORE_SPREADLY_EMAILS', '(Spread.ly) Registered E-Mails');
@define('PLUGIN_FINDMORE_SPREADLY_EMAILS_DESC', 'When spreadly.com is enabled, you can associate/claim your blog with the spreadly.com account. For this, enter the E-Mail address(es) that you registered with on spreadly.com (seperate multiple lines with a newline). More information can be found on <a href="http://spreadly.com">spreadly.com</a>!');

@define('PLUGIN_FINDMORE_SPREADLY', '(Spread.ly) Enable extended, social functionality?');
@define('PLUGIN_FINDMORE_SPREADLY_DESC', 'When enabled, an iframe is embedded to track and show additional data. When disabled, a static image button is shown.');
