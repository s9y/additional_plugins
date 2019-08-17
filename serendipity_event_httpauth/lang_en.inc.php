<?php # 

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_HTTPAUTH_NAME', 'HTTP-Authentication');
@define('PLUGIN_HTTPAUTH_BLAHBLAH', 'Authenticates users via HTTP auth using their s9y user login data.');

@define('PLUGIN_HTTPAUTH_REMOTEUSER', 'Grant REMOTE_USER Authentication?');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_DESC', 'If enabled, users can be authenticated via IIS/Apache server means. Those will store a central Server variable REMOTE_USER with the name of your authenticated user, and Serendipity can then login with that username. If you enable this, pay attentation that your personal authentication system needs to ensure valid users, as it bypasses the Serendipity authentication scheme!');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_WILDCARD', 'Enable wildcard authentication?');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_WILDCARD_DESC', 'This setting is only used when REMOTE_USER Authentication is enabled. If this setting is enabled, an non-existant REMOTE_USER in your s9y database will be authenticated with a hard-coded serendipity author. This means that if a user logs in as "Raymond", but no Serendipity author profile exists, he could be logged in via a central Serendipity accound named "Visitor".');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_AUTHORID', 'Wildcard auth: Authorid');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_AUTHORID_DESC', 'Specify the authorid as which a wildcard-authenticated user will be logged in.');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_USERLEVEL', 'Wildcard auth: Userlevel');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_USERLEVEL_DESC', 'Specify the userlevel with which a wildcard-authenticated user will be logged in.');
@define('PLUGIN_HTTPAUTH_FRONTEND', 'Require authentication for frontend');
@define('PLUGIN_HTTPAUTH_FRONTEND_DESC', 'Shall the authentication routine already be required for the frontend? If enabled, access to the blog is denied without login - if disabled, login is only performed on the backend.');

?>
