<?php # 

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_EXTERNALAUTH_TITLE', 'External user authentication (LDAP)/tracking');
@define('PLUGIN_EVENT_EXTERNALAUTH_DESC', 'Allows to use external ressource to validate logins. Logins will be cached in the Serendipity database framework. This plugin can also track logins inside the Database.');
@define('PLUGIN_EVENT_EXTERNALAUTH_SOURCE', 'Source of external authentication');
@define('PLUGIN_EVENT_EXTERNALAUTH_SOURCE_DESC', 'Select the source of your external user credentials');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL', 'Default userlevel');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_DESC', 'Which is the default userlevel for a new external user, if there is no Userlevel Attribute?');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ATTR', 'Userlevel Attribute');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ATTR_DESC', 'Which Attribute contains the userlevel for a new external user?');
@define('PLUGIN_EVENT_EXTERNALAUTH_HOST', 'Authentication host');
@define('PLUGIN_EVENT_EXTERNALAUTH_HOST_DESC', 'Enter the location of the authentication host');
@define('PLUGIN_EVENT_EXTERNALAUTH_PORT', 'Authentication host port');
@define('PLUGIN_EVENT_EXTERNALAUTH_PORT_DESC', 'Enter the port of the authentication host. Empty value will use the default port');
@define('PLUGIN_EVENT_EXTERNALAUTH_RDN', 'Authentication string');
@define('PLUGIN_EVENT_EXTERNALAUTH_RDN_DESC', 'String used for authentication. %1 will be replaced by the username, %2 will contain the password and %3 the MD5-encoded password. If "Query to find an user" expression is set, this value must hold the base DN to perform the query however.');
@define('PLUGIN_EVENT_EXTERNALAUTH_FIRSTLOGIN', 'Only perform once per session');
@define('PLUGIN_EVENT_EXTERNALAUTH_FIRSTLOGIN_DESC', 'Should the external auth only take place once for a whole session, or upon each request. TRUE will increase performance, FALSE will increase security.');
@define('PLUGIN_EVENT_EXTERNALAUTH_BIND_USER', 'LDAP DN name used to connect(bind)');
@define('PLUGIN_EVENT_EXTERNALAUTH_BIND_USER_DESC', 'If your LDAP is not freely browsable and requires authentication before queries can be done, this is the user account to be used for this initial login, in LDAP syntax, e.g: CN=s9yldapuser,CN=Users,DC=ilog,DC=com');
@define('PLUGIN_EVENT_EXTERNALAUTH_BIND_PASSWORD', 'Password for LDAP DN name used to connect(bind)');
@define('PLUGIN_EVENT_EXTERNALAUTH_BIND_PASSWORD_DESC', 'Password for this initial login');
@define('PLUGIN_EVENT_EXTERNALAUTH_QUERY', 'Query to find an user');
@define('PLUGIN_EVENT_EXTERNALAUTH_QUERY_DESC', 'The expression to find an user. For LDAP this can be for instance (objectclass=*) or (&(objectcategory=person)(objectclass=user)(sAMAccountName=%1)). %1 will be replaced by the username, %2 will contain the password and %3 the MD5-encoded password. The search will take place in the scope given by "Authentication string", e.g: DC=s9y,DC=org. If empty, simple query via "Authentication string" will be done.');

@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_CHIEF', 'Chief');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_EDITOR', 'Editor');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ADMIN', 'Administrator');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_DENY', 'Deny Access');

@define('PLUGIN_EVENT_EXTERNALAUTH_ENABLE_LDAP', 'Enable LDAP login?');
@define('PLUGIN_EVENT_EXTERNALAUTH_ENABLE_LOGGING', 'Enable login logging?');

@define('PLUGIN_EVENT_EXTERNALAUTH_USER_WYSIWYG', 'Wysiwyg enabled by default?');
@define('PLUGIN_EVENT_EXTERNALAUTH_USER_WYSIWYG_DESC', 'Are imported accounts created with the setting "Use WYSIWYG editor: on" by default?');

@define('PLUGIN_EVENT_EXTERNALAUTH_FAIL2BAN', 'fail2ban Logfile');
@define('PLUGIN_EVENT_EXTERNALAUTH_FAIL2BAN_DESC', '(Requires Serendipity &gt;= 1.6) This plugin can write a fail2ban compatible logfile when invalid logins were tried. If you want to enable this feature, enter a full filename including the path (i.e. "/var/log/fail2ban_s9y.log"). You might want to include this logfile in your system\'s logrotation. Fail2ban scans log files like /var/log/pwdfail or /var/log/apache/s9ybackend.log and bans IP that makes too many password failures. It updates firewall rules to reject the IP address.');
