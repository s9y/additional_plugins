<?php

@define('PLUGIN_FLATTR_NAME', 'Flattr');
@define('PLUGIN_FLATTR_DESC', 'Flattr is a social micropayment platform that lets you show love for the things you like. This plugin embedds "Flattr"-Badges in blog entries and RSS feeds. You can specify flattr-specific options per-entry, with a default global fallback.');

@define('PLUGIN_FLATTR_USER', 'User-ID (apply for it on flattr.com)');

@define('PLUGIN_FLATTR_PLACEMENT_FOOTER', 'Entry Footer');
@define('PLUGIN_FLATTR_PLACEMENT_SMARTY', 'Smarty-Variable {$entry.flattr}, for entries.tpl');
@define('PLUGIN_FLATTR_PLACEMENT', 'Where to place flattr-Badge');

@define('PLUGIN_FLATTR_BUTTON', 'Flattr Badge-Style ("default" or "compact")');
@define('PLUGIN_FLATTR_CATS', 'Flattr posting category');
@define('PLUGIN_FLATTR_LANG', 'Flattr posting language');
@define('PLUGIN_FLATTR_DSC', 'Flattr posting description (defaults to entry body)');
@define('PLUGIN_FLATTR_TAG', 'Flattr posting tags (defaults to freetag plugin, if used)');

@define('PLUGIN_FLATTR_ACTIVE', 'Enable flattr');

@define('PLUGIN_FLATTR_BUTTON_DESC', 'If you enter anything other than "default" or "compact", this text will be used for a static button. You can enter "Click here to flattr" for example.');
