<?php
if (!defined("PLUGIN_OEMBED_PROVIDER_XML_FILE")) {
    @define("PLUGIN_OEMBED_PROVIDER_XML_FILE",    dirname(__FILE__) . '/' . "providers.xml");
}

require_once dirname(__FILE__) . '/' . 'Exception404.class.php';
require_once dirname(__FILE__) . '/' . 'OEmbed.class.php';
require_once dirname(__FILE__) . '/' . 'LinkEmbed.class.php';
require_once dirname(__FILE__) . '/' . 'PhotoEmbed.class.php';
require_once dirname(__FILE__) . '/' . 'RichEmbed.class.php';
require_once dirname(__FILE__) . '/' . 'VideoEmbed.class.php';

require_once dirname(__FILE__) . '/' . 'EmbedProvider.class.php';
require_once dirname(__FILE__) . '/' . 'OEmbedProvider.class.php';

require_once dirname(__FILE__) . '/' . 'ProviderManager.class.php';

// Include all custom providers if any
$oembed_config_class_wildcard = dirname(__FILE__) . "/customs/*class.php";
foreach (glob($oembed_config_class_wildcard) as $filename)
{
    @include $filename;
}
