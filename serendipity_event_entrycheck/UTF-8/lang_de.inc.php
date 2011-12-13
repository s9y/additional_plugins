<?php # $Id: lang_de.inc.php,v 1.4 2006/08/18 19:36:13 garvinhicking Exp $

        @define('PLUGIN_EVENT_ENTRYCHECK_TITLE', 'Regeln für Veröffentlichungen');
        @define('PLUGIN_EVENT_ENTRYCHECK_DESC', 'Führt einige Prüfungen vor der Veröffentlichung eines Artikels durch');
        @define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES', 'Leere Kategorien verhindern?');
        @define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_DESC', 'Wenn auf "ja" gesetzt, muss ein Artikel mindestens einer Kategorie zugeordnet sein.');
        @define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_WARNING', 'Es ist nicht erlaubt einen Eintrag ohne zugewiesene Kategorie zu veröffentlichen. Bitte die Kategorie setzen und erneut speichern!');
        @define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE', 'Leeren Titel verhindern?');
        @define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_DESC', 'Wenn auf "ja" gesetzt, muss ein Artikel einen Titel besitzten.');
        @define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_WARNING', 'Es ist nicht erlaubt einen Eintrag ohne Titel zu veröffentlichen. Bitte einen Titel eintragen und erneut speichern!');
        @define('PLUGIN_EVENT_ENTRYCHECK_DEFAULTCAT', 'Standardkategorie definieren');
        @define('PLUGIN_EVENT_ENTRYCHECK_DEFAULTCAT_DESC', 'Falls der Benutzer eine Kategorie leergelassen hat, kann der Eintrag automatisch dieser angegebenen Kategorie zugewiesen werden.');

@define('PLUGIN_EVENT_ENTRYCHECK_LOCKED', 'Dieser Artikel wurde vom Autoren %s am %s gesperrt');
@define('PLUGIN_EVENT_ENTRYCHECK_UNLOCK', 'Artikel entsperren');
@define('PLUGIN_EVENT_ENTRYCHECK_LOCK_WARNING', 'Dieser Artikel ist gesperrt und kann nur von dem sperrenden Autoren bearbeitet werden, oder Sie entfernen die Sperre.');
@define('PLUGIN_EVENT_ENTRYCHECK_LOCKING', 'Artikel-Sperren aktivieren?');
