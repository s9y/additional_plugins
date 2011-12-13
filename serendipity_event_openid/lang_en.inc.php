<?php 

@define('PLUGIN_OPENID_NAME',     'OpenID Authentication');
@define('PLUGIN_OPENID_DESC',     'Allows authors to authenticate using an OpenID.');

@define('PLUGIN_OPENID_EXISTS', 'You have already registered with this OpenID.');
@define('PLUGIN_OPENID_WRONG_ACTIVATION', 'Invalid activation URL!');

@define('PLUGIN_EVENT_OPENID_SELECT', 'Current OpenID associated with this account');

@define('PLUGIN_OPENID_STORE_PATH', 'OpenID storage path');
@define('PLUGIN_OPENID_STORE_PATH_DESC', 'Path on server to store temporary OpenID session data');

@define('PLUGIN_OPENID_SERVER', 'OpenID server');
@define('PLUGIN_OPENID_SERVER_DESC', 'OpenID server to use for delegate (requires OpenID delegate to be populated)');

@define('PLUGIN_OPENID_DELEGATE', 'OpenID delegate');
@define('PLUGIN_OPENID_DELEGATE_DESC', 'OpenID delegate (requires OpenID server to be populated)');

@define('PLUGIN_OPENID_XRDS_LOC', 'OpenID XRDS Location');
@define('PLUGIN_OPENID_XRDS_LOC_DESC', 'URL for XRDS Document Location (requires OpenID server to be populated)');

@define('PLUGIN_OPENID_UPDATE_SUCCESS', 'Your OpenID has been updated');
@define('PLUGIN_OPENID_UPDATE_FAIL', 'An Error occurred updating your OpenID');
@define('PLUGIN_OPENID_INVALID_RESPONSE', 'Invalid OpenID Entered');
?>