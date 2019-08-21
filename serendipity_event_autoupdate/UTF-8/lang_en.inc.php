<?php

@define('PLUGIN_EVENT_AUTOUPDATE_NAME',     'Serendipity Autoupdate');
@define('PLUGIN_EVENT_AUTOUPDATE_DESC',     'When the dashboard-plugin (once a day) detects an update, this plugin adds the option to manually download or start an automatic and secured upgrade of the blog directly with one click from within the adminarea.');
@define('PLUGIN_EVENT_AUTOUPDATE_UPDATEBUTTON',     'Start automatic upgrade');
@define('PLUGIN_EVENT_AUTOUPDATE_DISABLE_INTEGRITY_CHECKS', 'Disable integrity checks (CAUTION!)');
@define(
    'PLUGIN_EVENT_AUTOUPDATE_DISABLE_INTEGRITY_CHECKS_DESC',
    'This setting disables the file integrity checks for one run of the auto updater. It will be automatically reset to `No` after the update.'
);
@define(
    'PLUGIN_EVENT_AUTOUPDATE_RETRY_NO_INTEGRITY_CHECKS_BUTTON',
    'Retry automatic upgrade with integrity checks disabled'
);
