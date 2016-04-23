<?php # $Id$

	@define('PLUGIN_SIDEBAR_PIWIK_NAME', 'Piwik');
	@define('PLUGIN_SIDEBAR_PIWIK_DESC', 'show statistics of Piwik in sidebar');
	@define('PLUGIN_SIDEBAR_PIWIK_TITLE_NAME', 'Header');
	@define('PLUGIN_SIDEBAR_PIWIK_TITLE_DESC', 'the header for this sidebar-plugin');
	@define('PLUGIN_SIDEBAR_PIWIK_TOKEN_NAME','Token');
	@define('PLUGIN_SIDEBAR_PIWIK_TOKEN_DESC','the token of Piwik-user who can read statistics');
	@define('PLUGIN_SIDEBAR_PIWIK_SITEID_NAME','Site-ID');
	@define('PLUGIN_SIDEBAR_PIWIK_SITEID_DESC','ID of your webpage within Piwik');
	@define('PLUGIN_SIDEBAR_PIWIK_URL_NAME','URL');
	@define('PLUGIN_SIDEBAR_PIWIK_URL_DESC','URL of your Piwik-installation');
	
	@define('PLUGIN_SIDEBAR_PIWIK_LIVE_SHOW_NAME','Live: Display');
	@define('PLUGIN_SIDEBAR_PIWIK_LIVE_SHOW_DESC','show statistics of your visitors from the last xx minutes');
	@define('PLUGIN_SIDEBAR_PIWIK_LIVE_TITLE_NAME','Live: Header');
	@define('PLUGIN_SIDEBAR_PIWIK_LIVE_TITLE_DESC','header for live-section, leave empty for hiding');
	@define('PLUGIN_SIDEBAR_PIWIK_LIVE_MINUTES_NAME','Live: Period');
	@define('PLUGIN_SIDEBAR_PIWIK_LIVE_MINUTES_DESC','period in minutes which will be used for live-statistics');
	@define('PLUGIN_SIDEBAR_PIWIK_LIVE_VISITORS','unique visitors');
	@define('PLUGIN_SIDEBAR_PIWIK_LIVE_VISITS','visits');
	@define('PLUGIN_SIDEBAR_PIWIK_LIVE_ACTIONS','page views');
		
	@define('PLUGIN_SIDEBAR_PIWIK_ENTRIES_SHOW_NAME','Entries: Display');
	@define('PLUGIN_SIDEBAR_PIWIK_ENTRIES_SHOW_DESC','show most read entries of current week');
	@define('PLUGIN_SIDEBAR_PIWIK_ENTRIES_TITLE_NAME','Entries: Header');
	@define('PLUGIN_SIDEBAR_PIWIK_ENTRIES_TITLE_DESC','header for most read entries, leave empty for hiding');
        @define('PLUGIN_SIDEBAR_PIWIK_ENTRIES_DAYS_NAME','Entries: Period');
        @define('PLUGIN_SIDEBAR_PIWIK_ENTRIES_DAYS_DESC','last X days that should be considered (0 for current week)');
	@define('PLUGIN_SIDEBAR_PIWIK_ENTRIES_MAX_NAME','Entries: Number');
	@define('PLUGIN_SIDEBAR_PIWIK_ENTRIES_MAX_DESC','how many entries should be shown');
	@define('PLUGIN_SIDEBAR_PIWIK_ENTRIES_REMOVE_NAME','Entries: String to remove');
	@define('PLUGIN_SIDEBAR_PIWIK_ENTRIES_REMOVE_DESC','string that should be removed from page-title');
	@define('PLUGIN_SIDEBAR_PIWIK_ENTRIES_VIEWS','views');

	@define('PLUGIN_SIDEBAR_PIWIK_DEBUG_NAME','activate debug-logging:');
        @define('PLUGIN_SIDEBAR_PIWIK_DEBUG_DESC','if logging is enabled, some things will be written into ./templates_c/piwik_debug.log (for example the piwik-fetch-url');
