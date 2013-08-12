<?php # 

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_CRONJOB_NAME', 'Cronjob scheduler');
@define('PLUGIN_EVENT_CRONJOB_DESC', 'This plugin periodically executes plugins that provide/require periodic tasks. See the configuration of this plugin for details.');
@define('PLUGIN_EVENT_CRONJOB_DETAILS', 'This plugin provides new plugin API hooks (cronjob_5min, cronjob_30min, cronjob_1h, cronjob_12h, cronjob_daily, cronjob_weekly, cronjob_monthly) that other plugins can use. NOTE that the cronjob execution is based on your visitors - if nobody visits your page, no cronjobs can be executed.If you have your own server that can execute cronjobs, you should add this to your crontab:<br /><br />5 * * * wget http://yourblog/index.php?serendipity[cronjob]=all.<br /><br />And then disable the execution of visitor-cronjobs.');
@define('PLUGIN_EVENT_CRONJOB_VISITOR', 'Enable visitor-based cronjobs?');
@define('PLUGIN_EVENT_CRONJOB_VISITOR_DESC', 'If this option is enabled, cronjobs will get executed by your visitors. For this, a 0-pixel image will be emitted (that calls index.php?serendipity[cronjob]=true), that takes care of cronjob functionality. For people without the ability to add custom cronjobs on their server, this is the only way one can execute periodic events on the webserver. You should note that then cronjobs will be executed only on page calls, and the timespan between cronjobs might not be exact then (it could take you 3 hours until the hourly cronjob gets executed, if no visitors come during the 1-hour timeframe).');
@define('PLUGIN_EVENT_CRONJOB_LOG', 'Recent Cronjob activity');
@define('PLUGIN_EVENT_CRONJOB_CHOOSE', 'Execute when?');
