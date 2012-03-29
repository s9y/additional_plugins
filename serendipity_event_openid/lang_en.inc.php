<?php 

@define('PLUGIN_OPENID_NAME',     'OpenID Authentication');
@define('PLUGIN_OPENID_DESC',     'Allows authors to authenticate using an OpenID, their Google or Yahoo account.');

@define('PLUGIN_OPENID_EXISTS', 'You have already registered with this OpenID.');
@define('PLUGIN_OPENID_WRONG_ACTIVATION', 'Invalid activation URL!');

@define('PLUGIN_EVENT_OPENID_SELECT', 'Current OpenID associated with this account');

@define('PLUGIN_OPENID_DESCRIPTION', 
'<h3>Using OpenID to log into your blog</h3>' .
'<p>This plugin does not need any configuration to enable login into your blog using OpenID (OpenID is self configuring)</p>' .
'<p>But users, who want to use OpenID for login have to configure the OpenID URL they want to be identified with. ' . 
'So if you want to use OpenID as a login option, go to your <a href="serendipity_admin.php?serendipity[adminModule]=personal">Serendipity profile page</a> and configure your OpenID URL (at the bottom of the page).</p>' .
'<p>There are buttons for <b>Google</b>, <b>Yahoo</b> and <b>Aol</b> accounts, too. These services are also OpenID providers and the buttons will assist you while setting up.<br/>' .
'But there can <b>only be one OpenID connection for an account</b> configured at a time.</p>'
);

@define('PLUGIN_OPENID_DELEGATION_DESCRIPTION', 
'<h3>OpenID Delegation Settings (Optional)</h3>' .
'<p>If you want to use your blog as your OpenID URL while logging in to services supporting it, you can configure here a delegation from your blog to the OpenID service hosting your ID.<br/>' .
'The plugin will add some information to your blogs HTML informing the services about where to look up your ID when you enter your blogs URL as your OpenID.</p>' .
'<p>Settung up delegation is completely optional and not needed for logging into your blog with OpenID.</p>'
);

@define('PLUGIN_OPENID_LOGIN_USERS', 'Login with user selection');
@define('PLUGIN_OPENID_LOGIN_USERS_DESC', 
'After authors of this blog have configured their OpenID URL they can select their name and log in.
As this is a very convenient way to log in it shows others the names of the authors of your blog.
This should be no problem normaly as they are visible in your articles, too.
But if you don\'t like that you can switch this off and there will be a normal OpenID URL input only.');

@define('PLUGIN_OPENID_SERVER', 'OpenID server used for delegation');
@define('PLUGIN_OPENID_SERVER_DESC', 'OpenID server to use for delegate (requires OpenID delegate to be populated)');

@define('PLUGIN_OPENID_DELEGATE', 'Delegate to OpenID URL');
@define('PLUGIN_OPENID_DELEGATE_DESC', 'OpenID delegate (requires OpenID server to be populated)');

@define('PLUGIN_OPENID_XRDS_LOC', 'OpenID XRDS Location');
@define('PLUGIN_OPENID_XRDS_LOC_DESC', 'URL for XRDS Document Location (not needed normaly)');

@define('PLUGIN_OPENID_VERSION_SUPPORTED', 'OpenID Version');
@define('PLUGIN_OPENID_VERSION_SUPPORTED_DESC', 'The version your OpenID provider is supporting. Normaly "both" is okay, but if you know your provider does support only version 1 or only version 2 you can configure it here.');
@define('PLUGIN_OPENID_VERSION_SUPPORTED_V1', 'OpenID Version 1 only');
@define('PLUGIN_OPENID_VERSION_SUPPORTED_V2', 'OpenID Version 2 only');
@define('PLUGIN_OPENID_VERSION_SUPPORTED_BOTH', 'Both OpenID Versions');

@define('PLUGIN_OPENID_LOGIN_INPUT', 'Logon using your OpenID.');

@define('PLUGIN_OPENID_UPDATE_SUCCESS', 'Your OpenID has been updated');
@define('PLUGIN_OPENID_UPDATE_FAIL', 'An Error occurred updating your OpenID');
@define('PLUGIN_OPENID_INVALID_RESPONSE', 'Invalid OpenID Entered');

@define('PLUGIN_OPENID_LOGIN_WITH_GOOGLE', 'Login with your Google account');
@define('PLUGIN_OPENID_SET_GOOGLE_OID', 'Set your Google account as OpenID');
@define('PLUGIN_OPENID_LOGIN_WITH_YAHOO', 'Login with your Yahoo account');
@define('PLUGIN_OPENID_SET_YAHOO_OID', 'Set your Yahoo account as OpenID');
@define('PLUGIN_OPENID_LOGIN_WITH_AOL', 'Login with your Aol account');
@define('PLUGIN_OPENID_SET_AOL_OID', 'Set your Aol account as OpenID');

@define('PLUGIN_OPENID_LOGIN_NOOPENID', 'At the moment, there is no author having an OpenID URL configured.<br/>
If you want to log in using your OpenID please configure yours first in your personal settings.<br/>Thanks.');
