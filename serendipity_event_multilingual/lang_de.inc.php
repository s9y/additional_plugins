<?php
//
//  serendipity_event_multilingual.php
//

@define('PLUGIN_EVENT_MULTILINGUAL_TITLE', 'Multilinguale Eintr�ge');
@define('PLUGIN_EVENT_MULTILINGUAL_DESC', 'Erlaubt die Erstellung mehrerer Sprachversionen eines Eintrags');
@define('PLUGIN_EVENT_MULTILINGUAL_NEEDTOSAVE', 'Der Artikel muss gespeichert werden, bevor eine alternative Sprachversion erstellt werden kann. Der Eintrag kann dazu auch als Entwurf gespeichert werden.');
@define('PLUGIN_EVENT_MULTILINGUAL_CURRENT', 'Sprachversion zur Bearbeitung ausw�hlen: ');
@define('PLUGIN_EVENT_MULTILINGUAL_SWITCH', 'Sprache wechseln');
@define('PLUGIN_EVENT_MULTILINGUAL_COPY', 'Behalten Sie vorhergehenden Spracheninhalt bei');
@define('PLUGIN_EVENT_MULTILINGUAL_COPYDESC', 'Halten Sie vorhergehenden Spracheninhalt intakt im Inputkasten, wenn Sie neue Sprachversion schreiben');
@define('PLUGIN_EVENT_MULTILINGUAL_TAGTITLE', '�bersetzung des Blogtitels');
@define('PLUGIN_EVENT_MULTILINGUAL_TAGTITLE_DESC', 'Aktiviert {{!<lang>}}<text>{{--}} tags f�r den Blogtitel oder benutzt die im nicht-tag-Modus �bersetzten Eintragstitel.');
@define('PLUGIN_EVENT_MULTILINGUAL_TAGENTRIES', '�bersetzung von Artikeln und Artikeltiteln per tag');
@define('PLUGIN_EVENT_MULTILINGUAL_TAGENTRIES_DESC', 'Aktiviert {{!<lang>}}<text>{{--}} tags f�r Artikel');
@define('PLUGIN_EVENT_MULTILINGUAL_TAGSIDEBAR', '�bersetzung von Seitenleisten-Eintr�gen per tag');
@define('PLUGIN_EVENT_MULTILINGUAL_TAGSIDEBAR_DESC', 'Aktiviert {{!<lang>}}<text>{{--}} tags f�r Seitenleisten-Eintr�ge');
@define('PLUGIN_EVENT_MULTILINGUAL_PLACE', 'Wo sollen die Links platziert werden?');
@define('PLUGIN_EVENT_MULTILINGUAL_PLACE_ADDFOOTER', 'im Footer des Artikels');
@define('PLUGIN_EVENT_MULTILINGUAL_PLACE_ADDSPECIAL', '"multilingual_footer" f�r benutzerdefinierten Smarty output');

@define('PLUGIN_EVENT_MULTILINGUAL_LANGSWITCH', 'Vollst�ndigen Sprachwechsel erzwingen?');
@define('PLUGIN_EVENT_MULTILINGUAL_LANGSWITCH_DESC', 'Die Auswahl einer �bersetzung eines Blogeintrags �ndert die Sprache des gesamten Blogs');

@define('PLUGIN_EVENT_MULTILINGUAL_HIDEENTRIES', 'Nicht �bersetzte Artikel auf der Startseite ausblenden?');
@define('PLUGIN_EVENT_MULTILINGUAL_HIDEENTRIES_DESC', 'Sollen Artikel in der Standardsprache angezeigt werden, die in der gew�hlten Sprache nicht verf�gbar sind?');

@define('PLUGIN_EVENT_MULTILINGUAL_ENTRY_RELOADED', 'Multilinguale Artikelsprache &lt;%s&gt; neu geladen');

//
//  serendipity_plugin_multilingual.php
//
@define('PLUGIN_SIDEBAR_MULTILINGUAL_TITLE', 'Sprachauswahl');
@define('PLUGIN_SIDEBAR_MULTILINGUAL_DESC', 'Erm�glicht Besuchern die Ausgabesprache von Serendipity zu �ndern');
@define('PLUGIN_SIDEBAR_MULTILINGUAL_USERDESC', 'Hier k�nnen Sie eine andere Ausgabesprache dieser Blog-Oberfl�che w�hlen: ');
@define('PLUGIN_SIDEBAR_MULTILINGUAL_SUBMIT', 'Submit-Button?');
@define('PLUGIN_SIDEBAR_MULTILINGUAL_SUBMIT_DESC', 'Einen Submit-Button anzeigen?');
@define('PLUGIN_SIDEBAR_MULTILINGUAL_SIZE', 'Schriftkegelgr��e');

