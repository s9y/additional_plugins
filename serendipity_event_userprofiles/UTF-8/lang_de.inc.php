<?php

@define('PLUGIN_USERPROFILES_NAME',          "Serendipity Autoren");
@define('PLUGIN_USERPROFILES_NAME_DESC',     "Zeigt eine Liste aller Autoren");
@define('PLUGIN_USERPROFILES_TITLE',         "Titel");
@define('PLUGIN_USERPROFILES_TITLE_DESC',    "Den Titel der Seitenleiste eintragen:");
@define('PLUGIN_USERPROFILES_TITLE_DEFAULT', "Autoren");

@define('PLUGIN_EVENT_USERPROFILES_CITY',       'Stadt');
@define('PLUGIN_EVENT_USERPROFILES_COUNTRY',    'Land');
@define('PLUGIN_EVENT_USERPROFILES_URL',        'Homepage');
@define('PLUGIN_EVENT_USERPROFILES_OCCUPATION', 'Beschäftigung');
@define('PLUGIN_EVENT_USERPROFILES_HOBBIES',    'Hobbies');
@define('PLUGIN_EVENT_USERPROFILES_YAHOO',      'Yahoo');
@define('PLUGIN_EVENT_USERPROFILES_AIM',        'AIM');
@define('PLUGIN_EVENT_USERPROFILES_JABBER',     'Jabber');
@define('PLUGIN_EVENT_USERPROFILES_ICQ',        'ICQ');
@define('PLUGIN_EVENT_USERPROFILES_MSN',        'MSN');

@define('PLUGIN_EVENT_USERPROFILES_SHOWEMAIL',      'E-Mail-Adresse anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWCITY',       'Stadt anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWCOUNTRY',    'Land anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWURL',        'Homepage anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWOCCUPATION', 'Beschäftigung anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWHOBBIES',    'Hobbys anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWYAHOO',      'Yahoo anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWAIM',        'AIM anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWJABBER',     'Jabber anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWICQ',        'ICQ anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWMSN',        'MSN anzeigen');

@define('PLUGIN_EVENT_USERPROFILES_SHOW',  'Benutzerprofil des gewählten Autoren:');
@define('PLUGIN_EVENT_USERPROFILES_TITLE', 'Benutzerprofile');
@define('PLUGIN_EVENT_USERPROFILES_DESC',  'Zeigt einfache Benutzerprofile');

@define('PLUGIN_EVENT_AUTHORPIC_EXTENSION', 'Dateiendung');
@define('PLUGIN_EVENT_AUTHORPIC_EXTENSION_BLAHBLAH', 'Welche Dateiendung haben die Bilder der Autoren?');
@define('PLUGIN_EVENT_AUTHORPIC_ENABLED', 'Bild des Autoren im Eintrag zeigen?');
@define('PLUGIN_EVENT_AUTHORPIC_ENABLED_DESC', 'Falls aktiviert wird ein Bild des Autoren in jedem Eintrag eingebunden um optisch darzustellen wer den Eintrag erstellt hat. Das Bild muss im Ordner "img" vom jeweiligen Templateordner liegen und so heißen, wie der Autorname. Alle Sonderzeichen (Umlaute, Leerzeichen, ...) müssen dabei durch ein "_" im Dateinamen ersetzt werden.');

@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT', 'Anzahl der Kommentare zeigen?');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_BLAHBLAH', 'Soll die Anzahl der Kommentare, die ein Besucher gemacht hat, dargestellt werden? Dies kann entweder deaktiviert werden, die Anzahl kann vor oder nach dem Kommentartext platziert werden, oder mittels Smarty Template comments.tpl manuell platziert werden indem {$comment.plugin_commentcount} an die gewünschte Stelle gesetzt wird. Das Aussehen dieses Blocks kann mittels der .serendipity_commentcount CSS Klasse verändert werden.');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_APPEND', 'An Kommentartext anhängen');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_PREPEND', 'Vor Kommentartext setzen');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_SMARTY', 'Eigenes Smarty Template');

@define('PLUGIN_USERPROFILES_BIRTHDAYIN', 'Geburtstag in %d Tagen');
@define('PLUGIN_USERPROFILES_BIRTHDAYTODAY', 'Geburtstag heute');

@define('PLUGIN_EVENT_USERPROFILES_SHOWSTREET',         'Straße anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWSKYPE',          'Skype anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SELECT',             'Benutzerprofil zum Bearbeiten auswählen.');
@define('PLUGIN_EVENT_USERPROFILES_BIRTHDAY',           'Geburtstag');
@define('PLUGIN_EVENT_USERPROFILES_VCARD',              'VCard-Datei erstellen');
@define('PLUGIN_EVENT_USERPROFILES_STREET',             'Straße');


@define('PLUGIN_EVENT_USERPROFILES_VCARDCREATED_AT',    'VCard-Datei um %s erstellt');
@define('PLUGIN_EVENT_USERPROFILES_VCARDCREATED_NOTE',  'Die VCard-Datei wurde in der Mediendatenbank gespeichert.');
@define('PLUGIN_EVENT_USERPROFILES_VCARDNOTCREATED',    'Konnte VCard-Datei nicht erstellen.');
@define('PLUGIN_USERPROFILES_BIRTHDAYNUMBERS', 'Anzahl der Geburtstagskinder');
@define('PLUGIN_USERPROFILES_BIRTHDAYSNAME', 'Geburtstage von Redakteuren');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE', 'Geburtstage');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE_DESCRIPTION', 'Anzeigen, wann der Benutzer den nächsten Geburtstag hat.');

@define('PLUGIN_USERPROFILES_GRAVATAR', 'Gravatar-Bild bevorzugen?');
@define('PLUGIN_USERPROFILES_GRAVATAR_DEFAULT', 'Speicherort der Standard-Bilddatei');
@define('PLUGIN_USERPROFILES_GRAVATAR_DEFAULT_DESC', 'Gibt den Speicherort der Bilddatei an, wenn kein Gravatar vorhanden ist.');
@define('PLUGIN_USERPROFILES_GRAVATAR_DESC', 'Bindet ein Gravatar-Bild ein, dass mit der E-Mail-Adresse verbunden ist. Registrierung bei www.gravatar.com');
@define('PLUGIN_USERPROFILES_GRAVATAR_RATING', 'Einschränkung der Gravatare');
@define('PLUGIN_USERPROFILES_GRAVATAR_RATING_DESC','Hier können Sie Gravatare einschränken, damit nur Bilder mit gewissen Jugendschutz-Kriterien angezeigt werden (US-Wertungsstufen): G, PG, R oder X.');
@define('PLUGIN_USERPROFILES_GRAVATAR_SIZE', 'Größe des Gravatar-Bildes');
@define('PLUGIN_USERPROFILES_GRAVATAR_SIZE_DESC', 'Bestimmt die Bildgröße des Gravatars (quadratische Größe, maximal 80).');
@define('PLUGIN_USERPROFILES_SHOWAUTHORS', 'Liste der Benutzerprofile anzeigen?');
@define('PLUGIN_USERPROFILES_SHOWGROUPS', 'Link zu Benutzergruppen anzeigen?');
