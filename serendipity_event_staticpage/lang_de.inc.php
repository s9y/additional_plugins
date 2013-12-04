<?php # 

@define('LANG_ALL', 'Alle Sprachen');
@define('LANG_BG', 'Bulgarisch');
@define('LANG_CN', 'Vereinfachtes Chinesisch (UTF-8)');
@define('LANG_CS', 'Tschechisch (Win-1250)');
@define('LANG_CZ', 'Tschechisch (ISO-8859-2)');
@define('LANG_DA', 'Dänisch');
@define('LANG_DE', 'Deutsch');
@define('LANG_EN', 'Englisch');
@define('LANG_ES', 'Spanisch');
@define('LANG_FA', 'Persisch');
@define('LANG_FI', 'Finnisch');
@define('LANG_FR', 'Französisch');
@define('LANG_IS', 'Isländisch');
@define('LANG_IT', 'Italienisch');
@define('LANG_JA', 'Japanisch');
@define('LANG_KO', 'Koreanisch');
@define('LANG_NL', 'Holländisch');
@define('LANG_NO', 'Norwegisch');
@define('LANG_PT', 'Portugiesisch (Brasilien)');
@define('LANG_RO', 'Rumänisch');
@define('LANG_RU', 'Russisch');
@define('LANG_TN', 'Traditionelles Chinesisch (UTF-8)');
@define('LANG_TW', 'Traditionelles Chinesisch (Big5)');
@define('LANG_ZH', 'Vereinfachtes Chinesisch (GB2312)');

@define('PLUGIN_STATICPAGELIST_NAME',               'Liste der statischen Seiten');
@define('PLUGIN_STATICPAGELIST_NAME_DESC',          'Dieses Plugin zeigt eine konfigurierbare Liste der statischen Seiten. Das StaticPage-Plugin benötigt Version 1.22 oder höher.');
@define('PLUGIN_STATICPAGELIST_TITLE',              'Titel');
@define('PLUGIN_STATICPAGELIST_TITLE_DESC',         'Überschrift für die Sidebar:');
@define('PLUGIN_STATICPAGELIST_TITLE_DEFAULT',      'Statische Seiten');
@define('PLUGIN_STATICPAGELIST_LIMIT',              'Seitenanzahl');
@define('PLUGIN_STATICPAGELIST_LIMIT_DESC',         'Maximale Anzahl der anzuzeigenden Seiten');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_NAME',     'Startseitenlink anzeigen');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_DESC',     'Einen Link zur Startseite erstellen');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME', 'Startseite');

@define('STATICPAGE_LIST_EXISTING_PAGES',           'Liste vorhandener statischer Seiten');
@define('STATICPAGE_HEADLINE',                      'Kopfzeile');
@define('STATICPAGE_HEADLINE_BLAHBLAH',             'Zeigt eine Kopfzeile als Titel der statischen Seite an');
@define('STATICPAGE_TITLE',                         'Statische Seiten');
@define('STATICPAGE_TITLE_BLAHBLAH',                'Verwaltet beliebige statische Seiten innerhalb des Blogs mit dem Blog-Design und allen Formatierungen. Fügt einen neuen Menüpunkt in der Admin-Oberfläche hinzu!');
@define('STATICPAGE_PAGETITLE',                     'URL-Titel der Seite');
@define('STATICPAGE_PERMALINK',                     'Permalink');
@define('STATICPAGE_PERMALINK_BLAHBLAH',            'Gibt den Permalink der statischen Seite an. Dieser muss eine absolute Pfadangabe vom HTTP-Root ab sein und die Dateiendung .htm oder .html besitzen!');
@define('CONTENT_BLAHBLAH',                         'Der Inhalt');
@define('STATICPAGE_ARTICLEFORMAT',                 'Als Artikel formatieren?');
@define('STATICPAGE_ARTICLEFORMAT_BLAHBLAH',        'Legt fest, ob die Ausgabe automatisch wie ein Artikel formatiert werden soll (Farben, Ränder, etc.) (Standard: ja)');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE',       'Seitentitel für "Als Artikel formatieren"-Ansicht');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH', 'Wenn die Option "Als Artikel formatieren" gewählt ist kann durch diesen Titel bestimmt werden, was an der Stelle angezeigt wird, wo normalerweise das Blog-Datum dargestellt wird.');
@define('STATICPAGE_SELECT',                        'Statische Seite zur Bearbeitung wählen.');
@define('STATICPAGE_PASSWORD_NOTICE',               'Diese Seite ist Passwortgeschützt. Bitte geben Sie das geeignete Passwort ein: ');
@define('STATICPAGE_PARENTPAGES_NAME',              'Elternseite');
@define('STATICPAGE_PARENTPAGE_DESC',               'Die übergeordnete Seite auswählen');
@define('STATICPAGE_PARENTPAGE_PARENT',             'Ist Elternseite');
@define('STATICPAGE_AUTHORS_NAME',                  'Name des Autors');
@define('STATICPAGE_AUTHORS_DESC',                  'Dieser Autor ist der Seiteninhaber');
@define('STATICPAGE_FILENAME_NAME',                 'Template (Smarty)');
@define('STATICPAGE_FILENAME_DESC',                 'Geben Sie den Dateinamen des Templates an, das für diese Seite genutzt werden soll. Diese Smarty-Datei kann sich entweder im Verzeichnis dieses Plugins befinden oder in ihrem Template-Ordner.');

@define('STATICPAGE_SHOWCHILDPAGES_NAME',           'Kinderseiten anzeigen');
@define('STATICPAGE_SHOWCHILDPAGES_DESC',           'Alle Kindseiten als Linkliste anzeigen.');
@define('STATICPAGE_PRECONTENT_NAME',               'Einleitung');
@define('STATICPAGE_PRECONTENT_DESC',               'Diese Einleitung wird vor den Kindseiten angezeigt.');
@define('STATICPAGE_CANNOTDELETE_MSG',              'Diese Seite kann nicht gelöscht werden. Es sind noch Kindseiten in der Datenbank. Diese müssen erst gelöscht werden.');
@define('STATICPAGE_IS_STARTPAGE',                  'Diese Seite als Startseite definieren');
@define('STATICPAGE_IS_STARTPAGE_DESC',             'Anstatt der standartmäßigen Serendipity Startseite wird diese statische Seite angezeigt. Nur eine Seite als Startseite definieren! Wenn du zur ursprünglischen Startseite verlinken möchtest, muss nach "index.php?frontpage" verlinkt werden.');
@define('STATICPAGE_IS_404_PAGE',                   'Diese Seite als 404-Fehler-Seite definieren');
@define('STATICPAGE_IS_404_PAGE_DESC',              'Mit dieser Option kann diese statische Seite als 404-Fehler-Seite verwendet werden. Dies darf jedoch nur für eine Seite definiert werden! Der Webserver muss zudem so konfiguriert sein, dass er diese Seite verwendet!');
@define('STATICPAGE_TOP',                           'Hoch');
@define('STATICPAGE_LINKNAME',                      'Bearbeiten');
@define('STATICPAGE_NEXT',                          'Weiter');
@define('STATICPAGE_PREV',                          'Zurück');

@define('STATICPAGE_ARTICLETYPE',                   'Artikeltyp');
@define('STATICPAGE_ARTICLETYPE_DESC',              'Den Artikeltyp auswählen, den die Seite erhalten soll.');

@define('STATICPAGE_CATEGORY_PAGEORDER',            'Seitenreihenfolge');
@define('STATICPAGE_CATEGORY_PAGES',                'Seiten bearbeiten');
@define('STATICPAGE_CATEGORY_PAGETYPES',            'Seitentypen bearbeiten');

@define('PAGETYPES_SELECT',                         'Einen Seitentypen zum bearbeiten auswählen.');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION',       'Beschreibung');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC',  'Beschreibung der Seite.');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE',          'Templatename');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE_DESC',     'Der Name des Templates. Das Template kann im staticpages-plugin-Ordner oder im standardmäßigen Template-Ordner sein.');
@define('STATICPAGE_ARTICLETYPE_IMAGE',             'Bildpfad');
@define('STATICPAGE_ARTICLETYPE_IMAGE_DESC',        'Die URL zu einem Kategoriebild.');

@define('STATICPAGE_STATUS',                        'Status');

@define('STATICPAGE_PLUGINS_INSTALLED',             'Plugin ist installiert');
@define('STATICPAGE_PLUGIN_AVAILABLE',              'Plugin ist verfügbar, aber nicht installiert');
@define('STATICPAGE_PLUGIN_NOTAVAILABLE',           'Plugin ist nicht verfügbar');
@define('STATICPAGE_PAGEADD_DESC',                  'Wählen Sie die Plugins aus, die in der staticpage sidebar als Link zur Verfügung stehen sollen.');
@define('STATICPAGE_PAGEADD_PLUGINS',               'Die folgenden Plugins können in die staticpage sidebar eingefügt werden.');
@define('STATICPAGE_CATEGORY_PAGEADD',              'Andere Plugins');
@define('STATICPAGE_SEARCHRESULTS',                 'Weitere %d Seiten gefunden:');

@define('STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRIES',  'Die URL der verschobenen Verzeichnisse wurde in %s statischen Seiten angepasst.');
@define('STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRY', 'Bei Nicht-MySQL Datenbanken ist es nicht möglich, jede statische Seite durchzugehen und das alte Verzeichnis durch das neue zu ersetzen. Daher müssen Sie manuell bestehende statische Seiten überarbeiten und die neuen URLs eintragen. Sie können natürlich auch das Verzeichnis an seinen alten Platz zurückschieben, falls dies zu viel Aufwand bedeuten würde.');

@define('PLUGIN_LINKS_IMGDIR',                      'Verzeichnis für Bilder dieses Plugins');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH',             'Bitte geben Sie hier die URL ein, die zu dem Bildverzeichnis ihres Plugins führt. Das eingegebene Verzeichnis muss einen "img"-Unterordner besitzen, der standardmäßig mit diesem Plugin auch ausgeliefert wird.');
@define('PLUGIN_STATICPAGELIST_ICON',               'Baumstruktur');
@define('PLUGIN_STATICPAGELIST_IMG_NAME',           'Grafiken für Baumstruktur aktivieren');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY',        'Nur Eltern-Seiten darstellen?');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY_DESC',   'Falls aktiviert werden nur Eltern-Seiten dargestellt. Andernfalls werden auch Unterseiten angezeigt.');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_DESC',     'Baumstruktur oder einfache Textauflistung berwenden');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_NAME',     'Icons bzw. Klartext');
@define('PLUGIN_STATICPAGELIST_TEXT',               'Klartext');
@define('STATICPAGE_DEFAULT_DESC',                  'Standardeinstellung für neue Seiten');
@define('STATICPAGE_LANGUAGE_DESC',                 'Wählen Sie die Sprache dieser Seite');
@define('STATICPAGE_PAGEORDER_DESC',                'Hier kann die Reihenfolge der statischen Seiten geändert werden');
@define('STATICPAGE_PUBLISHSTATUS',                 'Artikelstatus');
@define('STATICPAGE_PUBLISHSTATUS_DESC',            'Artikelstatus dieser Seite (veröffentlicht oder im Entwurf)');
@define('STATICPAGE_SHOWARTICLEFORMAT_DEFAULT',     'Wie einen Blog-Eintrag formatieren');
@define('STATICPAGE_SHOWCHILDPAGES_DEFAULT',        'Unterseiten anzeigen');
@define('STATICPAGE_SHOWMARKUP_DEFAULT',            'Textformatierungs-Plugins anwenden');
@define('STATICPAGE_SHOWNAVI',                      'Navigation anzeigen');
@define('STATICPAGE_SHOWNAVI_DEFAULT',              'Navigation anzeigen');
@define('STATICPAGE_SHOWNAVI_DESC',                 'Zeigt eine Navigation für diese Seite an');
@define('STATICPAGE_SHOWONNAVI',                    'In der Navigation der Seitenleiste einbinden');
@define('STATICPAGE_SHOWONNAVI_DEFAULT',            'Soll diese Seite in der Liste des Seitenleisten-Plugins gezeigt werden');
@define('STATICPAGE_SHOWONNAVI_DESC',               'Diese Seite in der Liste des Seitenleisten-Plugins anzeigen');
@define('STATICPAGE_SHOWMETA_DEFAULT',              'Zeige HTML Meta input Felder');
@define('STATICPAGE_SHOWTEXTORHEADLINE_HEADLINE',   'Überschrift');
@define('STATICPAGE_SHOWTEXTORHEADLINE_NAME',       'Überschriften oder Vor/Zurück-Navigation anzeigen?');
@define('STATICPAGE_SHOWTEXTORHEADLINE_TEXT',       'Text: Vor/Zurück');

@define('STATICPAGE_QUICKSEARCH_DESC', 'Wenn aktiviert, werden Suchergebnisse in den Statischen Seiten berücksichtigt.');

@define('STATICPAGE_CATEGORYPAGE','Zugeordnete statische Seite');
@define('STATICPAGE_RELATED_CATEGORY', 'Zugeordnete Kategorie');
@define('STATICPAGE_RELATED_CATEGORY_DESCRIPTION', 'U.a. können Einträge einer Kategorie oder Links auf die Kategorie in einer statischen Seite eingebunden werden. Näheres in der "plugin_staticpage_related_category.tpl" und "README_FOR_RELATED_CATEGORIES.txt"');

@define('STATICPAGE_ARTICLE_OVERVIEW','Artikelübersicht');
@define('STATICPAGE_NEW_HEADLINES','Aktuelle Schlagzeilen:');

@define('STATICPAGES_CUSTOM_STRUCTURE_SHOW', 'Zeige Struktur Feld Optionen');
@define('STATICPAGES_CUSTOM_META_SHOW', 'Zeige optionale META FELD Einträge');
@define('STATICPAGES_CUSTOM_META_TITLE', 'HTML META Seitentitel (optional)');
@define('STATICPAGES_CUSTOM_META_DESC', 'HTML META Seitenbeschreibung (optional)');
@define('STATICPAGES_CUSTOM_META_KEYS', 'HTML META Seiten Schlüsselwörter (optional)');

@define('STATICPAGE_SHOW_BREADCRUMB_DEFAULT', 'Zeige Navigationspfad (Breadcrumbs)');
@define('STATICPAGE_SHOW_BREADCRUMB', 'Zeige Navigationspfad (Breadcrumbs)');
@define('STATICPAGE_SHOW_BREADCRUMB_DESC', 'Zeige auf dieser Seite den Navigationspfad (Breadcrumbs) an');
?>