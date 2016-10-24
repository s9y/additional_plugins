<?php

@define('PLUGIN_ADMINNOTES_TITLE', 'QuickNotes');
@define('PLUGIN_ADMINNOTES_DESC', 'Displays information for authors on the administration panel');
@define('PLUGIN_ADMINNOTES_FEEDBACK', 'Allow users to post notes?');
@define('PLUGIN_ADMINNOTES_FEEDBACK_DESC', 'If not enabled, only Admins can post messages. If enabled, users can post messages to all user groups they are a member of.');
@define('PLUGIN_ADMINNOTES_FEEDBACK_INFO', 'Enter a message to appear on the Admin backend and choose the target user groups that should see this message.');
@define('PLUGIN_ADMINNOTES_HTML', 'Allow HTML formatting?');
@define('PLUGIN_ADMINNOTES_HTML_DESC', 'If enabled, HTML is allowed. Beware that "evil users" might introduce JavaScript on your pages. Only enable if you fully trust your users!');
@define('PLUGIN_ADMINNOTES_CUTOFF', 'Shorten notes after X bytes?');
@define('PLUGIN_ADMINNOTES_CUTOFF_DESC', 'Notes that contain more characters than configured will be cut off and can be expanded by clicking on a link.');