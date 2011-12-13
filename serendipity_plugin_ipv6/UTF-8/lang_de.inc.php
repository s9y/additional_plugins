<?php // $Id: lang_de.inc.php,v 1.1 2011/03/23 21:36:45 webcompas Exp $

@define('PLUGIN_IPV6_NAME', 'IPv6-Check');
@define('PLUGIN_IPV6_DESC', 'Dieses Plugin zeigt in einem Sidebar-Element an, mit welcher IP-Version (IPv4 oder IPv6) der Besucher die Website aufgerufen hat.');
@define('PLUGIN_IPV6_CONFIG_TITLE', 'Titel des Sidebar-Elements');
@define('PLUGIN_IPV6_CONFIG_TITLE_DESC', 'Text, der als Titel des Sidebar-Elements angezeigt werden soll');
@define('PLUGIN_IPV6_CONFIG_SUCCESS_MESSAGE', 'Info-Text für verwendete IP-Version');
@define('PLUGIN_IPV6_CONFIG_SUCCESS_MESSAGE_DESC', 'Text für die Angabe der verwendeten IP-Version. Als Platzhalter für die IP-Version kann an der gewünschten Stelle "%s" (ohne Anführungszeichen!) eingefügt werden. Wenn nicht angegeben, wird ein sprachspezifischer Standardtext verwendet.');
@define('PLUGIN_IPV6_CONFIG_SUCCESS_MESSAGE_DEFAULT', 'Sie haben diese Website via %s aufgerufen!');
@define('PLUGIN_IPV6_CONFIG_ERROR_MESSAGE', 'Fehlermeldung, falls IP-Version nicht ermittelt werden kann');
@define('PLUGIN_IPV6_CONFIG_ERROR_MESSAGE_DESC', 'Falls die verwendete IP-Version einmal nicht ermittelt werden können sollte, wird diese Nachricht angezeigt. Wenn nicht angegeben, wird ein sprachspezifischer Standardtext verwendet.');
@define('PLUGIN_IPV6_CONFIG_ERROR_MESSAGE_DEFAULT', 'Leider konnte nicht ermittelt werden, welche IP-Version beim Aufruf der Website verwendet wurde!');