<?php

@define('PLUGIN_AMAZON_TITLE',              "Amazon Empfehlungen");
@define('PLUGIN_AMAZON_DESC',               "Empfehlungsblock für Produkte innerhalb des Amazon-Partnerprogramms");
@define('PLUGIN_AMAZON_PROP_TITLE',         "Titel");
@define('PLUGIN_AMAZON_PROP_TITLE_DESC',    "Titel des Empfehlungsblocks");
@define('PLUGIN_AMAZON_NEW_WINDOW',         "Links in neuem Fenster öffnen");
@define('PLUGIN_AMAZON_TRACK_GOOGLE',       "Klicks mit Google Analytics auswerten");
@define('DESC_PLUGIN_AMAZON_TRACK_GOOGLE',  "Das Google-Analytics-Plugin wird benötigt.");
@define('PLUGIN_AMAZON_SMALL_MED',          "Größe der Vorschaubilder");
@define('PLUGIN_AMAZON_SMALL',              "Klein");
@define('PLUGIN_AMAZON_MEDIUM',             "Mittel");
@define('PLUGIN_AMAZON_LARGE',              "Groß");
@define('PLUGIN_AMAZON_SIDEBAR_CACHE',      "Cache-Dauer");
@define('PLUGIN_AMAZON_SIDEBAR_CACHE_DESC', "Anzahl der Minuten, in denen die gesamte Plugin-Ausgabe zwischengespeichert werden soll. Amazon-Anfragen werden für 24 Stunden zwischengespeichert, während der Anzeigetext für jeden Artikel für 60 Minuten zwischengespeichert wird. Diese Einstellung ermöglicht eine geringfügige Leistungssteigerung, indem die Ausgabe für die Dauer der Cache-Zeit nicht zufällig erfolgt. Für keinen Cache auf '0' setzen.");
@define('PLUGIN_AMAZON_ASIN',               "ASIN-Liste");
@define('PLUGIN_AMAZON_ASIN_DESC',          "Kommaseparierte Liste von ASIN, die vorgestellt werden sollen");
@define('PLUGIN_AMAZON_ASIN_CNT',           "Wie viele Artikel anzeigen?");
@define('PLUGIN_AMAZON_SERVER',             'Standard-Server');
@define('PLUGIN_AMAZON_SERVER_DESC',        'Amazon-Server, der zur Lokalisierung verwendet werden soll.');
@define('PLUGIN_AMAZON_GERMANY',            'Deutschland');
@define('PLUGIN_AMAZON_JAPAN',              'Japan');
@define('PLUGIN_AMAZON_UK',                 'Großbritannien');
@define('PLUGIN_AMAZON_US',                 'Vereinigte Staaten');
@define('PLUGIN_AMAZON_CA',                 'Kanada');
@define('PLUGIN_AMAZON_FR',                 'Frankreich');
@define('PLUGIN_AMAZON_DEPENDS_ON', 'Dieses Plugin hängt jetzt vom <a href="http://spartacus.s9y.org/index.php?mode=bygroups_event_en#group_BACKEND_EDITOR">Amazon Media Button</a>-Ereignis-Plugin ab. Bitte installieren Sie das Plugin und konfigurieren Sie es für die Verbindung mit Amazon.');
?>
