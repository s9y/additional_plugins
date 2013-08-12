<?php // 

@define('PLUGIN_IPV6_NAME', 'IPv6 Check');
@define('PLUGIN_IPV6_DESC', 'This plugin displays within a sidebar element the IP version used for accessing the website.');
@define('PLUGIN_IPV6_CONFIG_TITLE', 'Title of the sidebar element');
@define('PLUGIN_IPV6_CONFIG_TITLE_DESC', 'This text will be shown as title of the sidebar element.');
@define('PLUGIN_IPV6_CONFIG_SUCCESS_MESSAGE', 'Text for displaying the IP version');
@define('PLUGIN_IPV6_CONFIG_SUCCESS_MESSAGE_DESC', 'For showing the IP version this text will be used. You can include the determined IP version by inseting the placeholder "%s" (without quotes!) at the corresponding position. If empty a language-specific default text will be used.');
@define('PLUGIN_IPV6_CONFIG_SUCCESS_MESSAGE_DEFAULT', 'You have accessed this website using %s!');
@define('PLUGIN_IPV6_CONFIG_ERROR_MESSAGE', 'Error message, if the IP version can not be determined');
@define('PLUGIN_IPV6_CONFIG_ERROR_MESSAGE_DESC', 'If the IP version can not be detected this error message will be displayed. If empty a language-specific default text will be used.');
@define('PLUGIN_IPV6_CONFIG_ERROR_MESSAGE_DEFAULT', 'Unfortunately, your IP version could not be determined!');