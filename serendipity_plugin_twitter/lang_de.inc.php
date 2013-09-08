<?php 
@define('PLUGIN_TWITTER_TITLE',                         'Twitter Timeline');
@define('PLUGIN_TWITTER_DESC',                          'Zeigt die aktuellsten Twitter-Eintr�ge an');
@define('PLUGIN_TWITTER_NUMBER',                        'Anzahl der Eintr�ge');
@define('PLUGIN_TWITTER_NUMBER_DESC',                   'Wieviele Eintr�ge sollen angezeigt werden? (Standard: 10)');
@define('PLUGIN_TWITTER_TOALL_ONLY',                    'Keine Antworten');
@define('PLUGIN_TWITTER_TOALL_ONLY_DESC',               'Wenn eingeschaltet, werden keine Tweets angezeigt, die mit @ beginnen. Retweets werden auf diese Weise dargestellt. (Nur in der PHP Version)');
@define('PLUGIN_TWITTER_FILTER_ALL',                    'Keine User tweets');
@define('PLUGIN_TWITTER_FILTER_ALL_DESC',               'Wenn eingeschaltet, werden keine Tweets angezeigt, die ein @ enthalten. (Nur in der PHP Version)');
@define('PLUGIN_TWITTER_SERVICE',                       'Dienst');
@define('PLUGIN_TWITTER_SERVICE_DESC',                  'Genutzter Microblogging Dienst');
@define('PLUGIN_TWITTER_USERNAME',                      'Username');
@define('PLUGIN_TWITTER_USERNAME_DESC',                 'Der Benutzername, mit dem Du Dich bei Twitter oder indenti.ca einloggst.');
@define('PLUGIN_TWITTER_SHOWFORMAT',                    'Ausgabeformat');
@define('PLUGIN_TWITTER_SHOWFORMAT_DESC',               'Entweder werden deine Eintr�ge per Javascript angezeigt oder durch PHP. Wenn mehrere Versionen dieses Plugins auf einer Seite dargestellt werden sollen, dann muss PHP benutzt werden, da dies mit der JS Version nicht funktioniert.');
@define('PLUGIN_TWITTER_SHOWFORMAT_RADIO_JAVASCRIPT',   'JavaScript');
@define('PLUGIN_TWITTER_SHOWFORMAT_RADIO_PHP',          'PHP');

@define('PLUGIN_TWITTER_CACHETIME',                     'Wie lang sollen Daten zwischengespeichert werden (nur PHP-Ausgabeformat)');
@define('PLUGIN_TWITTER_CACHETIME_DESC',                'Um zu verhindern, dass zu viele Daten von und zu Twitter �bertragen werden, kann das Plugin Daten zwischenspeichern. Geben Sie hier die Anzahl an Sekunden ein, die das Plugin Daten nicht nochmal neu anfordern soll.');
@define('PLUGIN_TWITTER_BACKUP',                        'Sicherungskopie der Tweets anlegen? (Experimentell, nur Twitter)');
@define('PLUGIN_TWITTER_BACKUP_DESC',                   'Falls aktiviert, wird dieses Plugin ihre Tweets t�glich herunterladen und in einer Datenbanktabelle  (' . $serendipity['dbPrefix'] . 'tweets) speichern.');

@define('PLUGIN_TWITTER_LINKTEXT',                      'Text von Tweet Links');
@define('PLUGIN_TWITTER_LINKTEXT_DESC',                 'In tweets gefundene Links werden durch anklickbaren HTML Code ersetzt. Hier kann der Text angegeben werden, den diese Links haben sollen. Wenn $1 eingegeben wird, dann wird der Link selbst als Linktext benutzt (so wie twitter das auch tut).');

@define('PLUGIN_TWITTER_FOLLOWME_LINK',                 'Follow me Link');
@define('PLUGIN_TWITTER_FOLLOWME_LINK_DESC',            'F�gt einen "Follow me" Link unter die timeline.');
@define('PLUGIN_TWITTER_FOLLOWME_LINK_TEXT',            'Follow me');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET',               'Twitter Followme Widget');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DESC',          'Wenn das Plugin eine Twitter Timeline darstellt, kannst das Twitter Followme Widget anschalten, das Deine aktuelle Follower Anzahl und mehr anzeigt. Wird im identi.ca Modus ignoriert.');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_COUNT',         'Twitter Followme Widget Follower Anzahl');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_COUNT_DESC',    'Soll das Widget die aktuelle Anzahl Deiner Follower anzeigen?');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DARK',          'Twitter Followme Widget auf dunklem Hintergrund');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DARK_DESC',     'Wenn Dein Template dunkel ist, so solltest Du diese Option einschalten.');

@define('PLUGIN_TWITTER_USE_TIME_AGO',                  'Benutze vergangene Zeit');
@define('PLUGIN_TWITTER_USE_TIME_AGO_DESC',             'Wenn eingeschalten, dann wird die vergangene Zeit seit dem update angezeigt (so wie Twitter das auch tut), ansonsten wird das konfigurierte Datumsformat benutzt.');

@define('PLUGIN_TWITTER_PROBLEM_TWITTER_ACCESS',        'Es kann gerade nicht auf Twitter zugegriffen werden.<br/>Bitte sp�ter noch einmal laden.');

// Twitter Event Plugin 
@define('PLUGIN_EVENT_TWITTER_NAME',                    'Microblogging (Twitter,Identica)');
@define('PLUGIN_EVENT_TWITTER_DESC',                    'F�gt einen Twitter/Identica Client zum Administrator Interface hinzu, sucht nach Tweetbacks und k�ndigt neue Artikel �ber Twitter/Identica Accounts an.');

@define('PLUGIN_EVENT_TWITTER_ACCOUNT_NAME',            'Benutzername');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_NAME_DESC',       'Der Benutzername, der f�r den Backend Client und zum ank�ndigen von neuen Artikeln benutzt werden soll.');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_PWD',             'Passwort');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_PWD_DESC',        'Das Passwort f�r diesen Benutzernamen.');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_TITLE', 'Ank�ndigung von Artikeln');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES',       'Neue Artikel ank�ndigen');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_DESC',  'Wenn eingeschaltet, dann werden neu ver�ffentlichte Artikel �ber Twitter/Identica Konten angek�ndigt.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_WITHTTAGS',      'Mit Tags ank�ndigen');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_WITHTTAGS_DESC', 'Wenn das Free Tag Plugin installiert ist, wird beim Ank�ndigen die �berschrift des Artikels durchsucht, ob Worte darin mit den vergebenen Tags �bereinstimmen. In dem Fall werden diese Worte in Twitter Tags umgewandelt (ein # voran gestellt). Es kann au�erdem #tags# im Ank�ndigungsformat benutzt werden. Dies wird ersetzt durch alle Tags, die im Titel nicht eingebunden wurden (also alle, wenn diese Option ausgeschaltet ist).');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_SERVICE',        'URL K�rzer f�r Ank�ndigungen');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_SERVICE_DESC',   'Zu benutzender Service beim K�rzen von URLs f�r Artikelank�ndigungen und im Tweeter. 7ax.de oder tinyurl.com werden empfohlen, da Sie die einzigen sind, die zuverl�ssig in der Tweetback Suche zu findende URLs produzieren.');

@define('PLUGIN_EVENT_TWITTER_TWEETBACKS_TITLE',        'Tweetbacks');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETBACKS',           'Nach Tweetbacks suchen');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETBACKS_DESC',      'Wenn eingeschaltet, dann wird das Plugin versuchen, Tweetbacks zu Artikeln zu finden und es wird ein "check tweetback" Link unterhalb der Artikel eingef�gt, wenn der Besucher ein eingeloggter Blogbenutzer ist.');
@define('PLUGIN_EVENT_TWITTER_IGNORE_MYTWEETBACKS',     'Eigene Tweets ignorieren');
@define('PLUGIN_EVENT_TWITTER_IGNORE_MYTWEETBACKS_DESC','Wenn die eigenen Tweets nicht in das Blog als Tweetback importiert werden sollen (z.B: die �ber den Tweeter gesendeten oder die Artikel Ank�ndigungen), dann sollte diese Option eingeschaltet sein.');

@define('PLUGIN_EVENT_TWITTER_TWEETBACK_CHECK_FREQ',    'Tweetback Suchfrequenz');
@define('PLUGIN_EVENT_TWITTER_TWEETBACK_CHECK_FREQ_DESC','Die Zeit, die zwischen zwei Tweetback Suchen mindestens vergehen soll. Hier kann nicht weniger als 5 Minuten angegeben werden.');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE',                 'Tweetback Typ');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_DESC',            'Serendipity selbst unterst�tzt keine Tweetbacks. Somit m�ssen diese als Trackbacks oder Kommentare gespeichert werden. Tweetbacks kommen von au�erhalb und sind somit den Trackbacks �hnlich, schaut man jedoch ihren Inhalt an, sind sie meist den Kommentaren �hnlicher. Entscheiden Sie hier, als was Tweetbacks bei ihnen gespeichert werden sollen.');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_TRACKBACK',       'Trackback');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_COMMENT',         'Kommentar');

@define('PLUGIN_EVENT_TWITTER_TWEETER_TITLE',           'Microblogging Client');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SIDEBARTITLE',    'Tweeter');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW',            'Microblogging Client benutzen');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_DESC',       'Hiermit wird ein Microblogging Client auf der Hauptseite oder in der Seitenleiste des Administationsbereiches zur Verf�gung gestellt.');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_FRONTPAGE',  'Hauptseite');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_SIDEBAR',    'Seitenleiste');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_DISABLE',    'Ausschalten');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY',         'Timeline anzeigen');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_DESC',    'Stellt Ihre Timeline unterhalb der Client Eingabe dar.');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_COUNT',   'Eintr�ge in der Timeline');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_COUNT_DESC','Anzahl der Timeline Eintr�ge, die unterhalb des Clients geladen werden sollen.');

@define('PLUGIN_EVENT_TWITTER_TWEETER_FORM',            'Tweet eingeben:');
@define('PLUGIN_EVENT_TWITTER_TWEETER_CHARSLEFT',       'Zeichen �brig');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHORTEN',         'URL k�rzen');
@define('PLUGIN_EVENT_TWITTER_TWEETER_UPDATE',          'Update');
@define('PLUGIN_EVENT_TWITTER_TWEETER_STORED',          'Tweet gesichert. ');
@define('PLUGIN_EVENT_TWITTER_TWEETER_STOREFAIL',       'Tweet konnte nicht �bertragen werden! Fehler: ');

@define('PLUGIN_EVENT_TWITTER_GENERAL_TITLE',           'Allgemein');
@define('PLUGIN_EVENT_TWITTER_PLUGIN_EVENT_REL_URL',    'Plugin rel. Pfad');
@define('PLUGIN_EVENT_TWITTER_PLUGIN_EVENT_REL_URL_DESC', 'Geben Sie hier den kompletten HTTP Pfad ein (alles nach ihrem Domain Namen), der das Verzeichnis des Plugins angibt.');

@define('PLUGIN_EVENT_TWITTER_TWEETER_WARNING',         '<p class="serendipityAdminMsgError">' .
                '<img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_error.png'). '" alt="" />' .
                'WARNING: Ein installiertes TwitterTweeter Plugin gefunden.</p>' .
                '<p class="serendipityAdminMsgError">Dieses Plugin ist ein Merge des alten S9Y Titter Plugins und des Twitter Tweeters. Es erweitert beide. Das Twitter Tweeter Plugin sollte deshalb deinstalliert werden.</p>');

@define('PLUGIN_EVENT_TWITTER_TB_USE_URL',              'Tweetback URL');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_DESC',         'Was soll als URL f�r einen Tweetback gespeichert werden? Es gibt 3 M�glichkeiten. Status: Die URL des Tweets, der den Tweetback erzeugt hat, Profil: Die URL des Profils des Twitter Benutzers oder Web URL, die URL, die der Benutzer in seinem Profil als seine Web URL angegeben hat.');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_STATUS',       'Status');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_PROFILE',      'Twitter Profil');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_WEBURL',       'Web URL');

@define('PLUGIN_EVENT_TWITTER_IDENTITIES',              'Benutzerkonten');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_IDCOUNT',         'Kontenzahl');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_IDCOUNT_DESC',    'Nachdem die Zahl gespeichert wurde, wird die entsprechende Anzahl von Konten Konfigurationen zur Verf�gung gestellt. Manchmal muss man zweimal speichern, bis man die Konfigurationen sieht.');
@define('PLUGIN_EVENT_TWITTER_IDENTITY',                'Benutzerkonto');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE',         'Konto Service');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_DESC',    'Bitte angeben, ob dies ein Twitter oder ein Identica Konto ist');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_TWITTER', 'twitter');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_IDENTICA','identica');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ACCOUNTS',       'Ank�ndigungskonten');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ACCOUNTS_DESC',  'Bitte die Konten ausw�hlen, die f�r Artikel Ank�ndigungen benutzt werden sollen.');

// Configuration Tabs:
@define('PLUGIN_EVENT_TWITTER_CFGTAB',                  'Konfigurationsreiter: ');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_IDENTITIES',       'Benutzerkonten');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_ANNOUNCE',         'Artikel Ank�ndigung');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETER',          'Microblogging Client');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETBACK',        'Tweetbacks');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_GLOBAL',           'Allgemein');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_ALL',              'ALLES');

@define('PLUGIN_EVENT_TWITTER_TWEETER_REPLY',           'Antwort auf den Tweet');
@define('PLUGIN_EVENT_TWITTER_TWEETER_RETWEET',         'Retweet');
@define('PLUGIN_EVENT_TWITTER_TWEETER_DM',              'Direct Message. (Funktioniert nur, wenn der Verfasser Dir folgt)');

@define('PLUGIN_EVENT_TWITTER_IGNORE_TWEETBACKS_BYNAME','Tweetbacks ignorieren von');
@define('PLUGIN_EVENT_TWITTER_IGNORE_TWEETBACKS_BYNAME_DESC','EIne Komma separierte Liste von Benutzern, deren Tweetbacks ignoriert werden sollen.');

@define('PLUGIN_TWITTER_EVENT_NOT_INSTALLED',           '<p class="serendipityAdminMsgError">' .
                '<img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="' . serendipity_getTemplateFile('admin/img/admin_msg_error.png'). '" alt="" />' .
                'WARNUNG: Das "' . PLUGIN_EVENT_TWITTER_NAME . '" Event Plugin wurde noch nicht installiert!</p>' .
                '<p class="serendipityAdminMsgError">Dies ist kein Fehler, aber der Hauptanteil der twitter/identica Funktionalit�t steckt im Microblogging (twitter/identica) Event Plugin.<br/>F�r eine komplette microblogging Unterst�tzung sollte dieses ebenfalls installiert werden.<br/>Au�erdem gibt das Event Plugin CSS code aus, der das Seitenleistenplugin etwas sch�ner aussehen l�sst.</p>');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_FORMAT',         'Ank�ndigungsformat');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_FORMAT_DESC',    'Hier wird die Formatierung von Ank�ndigungen beschrieben. Es sollten Platzhalter benutzt werden, um sinnvolle Ank�ndigungen zu erhalten. #title#: Ersetzt durch den Titel des Artikels (mit Tagersetzungen); #link#: Der Link auf den Blogeintrag; #autor#: Autor des Artikels; #tags#: �brig gebliebende Tags.');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYDESC',        '<h3>bitly Benutzername und API Key</h3><b>bit.ly</b> und <b>j.mp</b> KurzURLs ben�tigen ein bitly login und einen API Key. Wenn Du keine der beiden benutzt, ist diese Einstellung f�r Dich irrelevant.<br/>Der API Key, der hier eingetragen ist, wird die meiste Zeit �ber nicht funktionieren, da es ein Demo Key und seine Ratio meist �berschritten ist. Wenn Du einen bitly Account hast, so trage Deinen eigenen Namen und API Key ein.<br/><a href="http://bitly.com/a/your_api_key/" target="_blank">Hier findest Du beides</a>.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYLOGIN',        'bit.ly Benutzername');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYAPIKEY',    'bit.ly API Key');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_YOURLSDESC',        '<h3>Yourls Domain und API Signatur</h3><b>yourls</b> Braucht einen eigenen Yourls URL service.<br/>Die Defaults sind nur Platzhalter.<br/><a href="http://yourls.org/" target="_blank">Hier den yourls URL shortener runterladen und auf Server installieren.</a>.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_YOURLSURL',    'Deine Yourls Domain');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_YOURLSAPIKEY',    'Yourls API Schluessel');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_PIRATLYDESC',    '<h3>pirat.ly API Token</h3>F�r <b>pirat.ly</b> KurzURLs kannst Du Dir ein API token abholen, <a href="http://pirat.ly/account" target="_blank">indem Du Dich kostenlos bei dem Service registrierst</a>. Wenn das API Token bei der Artikel Ank�ndigung verwendet wird, kannst Du die Klick Raten der URL �ber das piratly Webinterface oder auf dem Android Handy mittels der <a href="http://pirat.ly/shortenerrr" target="_blank">Shortenerrr App</a> beobachten.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_PIRATLYAPIKEY',  'Dein pers�nliches piratly API Token');

@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETTHIS',        'Tweet This!');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_TITLE',         'Tweet This!');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETTHIS',            'Tweet This! benutzen');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETTHIS_DESC',       'Mit dieser Option wird ein "Tweet This!" Knopf im Footer eines Artikels angezeigt.');
@define('PLUGIN_EVENT_TWITTER_DO_IDENTICATHIS',         'Identica This! benutzen');
@define('PLUGIN_EVENT_TWITTER_DO_IDENTICATHIS_DESC',    'Mit dieser Option wird ein "Identica This!" Knopf im Footer eines Artikels angezeigt.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT',        'Tweet This! Format');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_DESC',   'Hier wird die Formatierung von Besucher Tweets beschrieben. Es sollten Platzhalter benutzt werden, um sinnvolle Ank�ndigungen zu erhalten. #title#: Ersetzt durch den Titel des Artikels (mit Tagersetzungen); #link#: Der Link auf den Blogeintrag; #autor#: Autor des Artikels; #tags#: �brig gebliebende Tags.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON', 'Knopf Typ');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_DESC', 'Derzeit gibt es zwei verschiedene Kopf Typen.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_BLACK', 'schwarz');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_WHITE', 'wei�');

@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_NEWWINDOW',     'TweetThis in neuem Fenster');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_NEWWINDOW_DESC','Wenn angeschaltet, werden twitter und identica in einem neuen Fenster geladen (anstatt im Blog Fenster).');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_SMARTIFY',      'TweetThis smartifizieren');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_SMARTIFY_DESC', 'Wenn angeschaltet, dann erzeugt das Plugin von sich aus nichts im Footer der Eintr�ge. Es werden statt dessen Variablen an die Eintr�ge geh�ngt, die im Template ausgewertet werden k�nnen: entry.url_tweetthis, entry.url_dentthis und entry.url_shorturl. Diese enthalten die URLs, die im Template verlinkt werden sollten. Somit kann man reine Textlinks im Template verwirklichen oder z.B. einen gro�en TweetThis Knopf im Kopfbereich jedes Eintrages oder �hnliches.');

@define('PLUGIN_EVENT_TWITTER_BACKEND_DONTANNOUNCE',    'Diesen Artikel *nicht* �ber Microblogging ank�ndigen');
@define('PLUGIN_EVENT_TWITTER_BACKEND_ENTERDESC',       'Bitte alle zutreffenden Tags angeben. Mehrere zutreffende Tags mit Komma (,) trennen. Wenn etwas hier eingegeben wurde, dann werden die "freien Artikel Tags" f�r die Ank�ndigung ignoriert!');

@define('PLUGIN_EVENT_TWITTER_TB_MODERATE',             'Tweetback Moderation');
@define('PLUGIN_EVENT_TWITTER_TB_MODERATE_DESC',        'Wie soll mit empfangenen Tweetbacks umgegangen werden? Es kann die globle Kommentar Einstellung benutzt werden, sie k�nnen moderiert oder automatisch akzeptiert werden. Bei der globalen Konfiguration wird ein evtl. installiertes AntiSpam Plugin gestartet, was ein speichern des Tweetbacks verhindern kann!');
@define('PLUGIN_EVENT_TWITTER_TB_MODERATE_DEFAULT',     'Globale Konfiguration nutzen (inklusive AntiSpam Plugin!)');

@define('PLUGIN_EVENT_TWITTER_SHORTURL_TITLE',          'Kurze URL dieses Artikels');
@define('PLUGIN_EVENT_TWITTER_SHORTURL_ON_CLICK',       'Dieser Link ist nicht aktiv. Er enth�lt die Kurz-URL zu diesem Eintrag. Sie k�nnen diese URL als Kurzform eines Links auf diesen Eintrag benutzen (z.B. in Twitter). Um den Link zu kopieren, klicken Sie ihn mit der rechten Maustaste an und w�hlen "Verkn�pfung kopieren" im Internet Explorer oder "Linkadresse kopieren" in Mozilla/Firefox.');

@define('PLUGIN_EVENT_TWITTER_SHOW_SHORTURL',           'Kurze URL f�r jeden Artikel anzeigen');
@define('PLUGIN_EVENT_TWITTER_SHOW_SHORTURL_DESC',      'Zeigt die default KurzURL im Footer jedes Artikels an. Wenn TweetThis smartifizieren angeschaltet wurde, dann erh�lt jeder Eintrag die Smarty Variable entry.url_shorturl.');

// oauth
@define('PLUGIN_EVENT_TWITTER_CONSUMER_KEY',            'Consumer key');
@define('PLUGIN_EVENT_TWITTER_CONSUMER_KEY_DESC',       'Den "Consumer key" und "Consumer secret" erh�ltst du von Twitter nach dem du f�r deinen Block eine Twitter-Applikation erstellt hast.');
@define('PLUGIN_EVENT_TWITTER_CONSUMER_SECRET',         'Consumer secret');
@define('PLUGIN_EVENT_TWITTER_SIGN_IN',                 'Klicke auf den folgenden Button und erlaube Twitter eine Verbindung herzustellen.<br/>
<p><a style="color:red;">ACHTUNG!</a><br/>
Du must aktuell bei Twitter entweder ausgeloggt oder mit dem <b>richtigen Twitternamen eingeloggt</b> sein!<br/>
<a href="#" onclick="window.open(\'http://twitter.com\',\'\',\'width=1000,height=400\'); return false">Bitte vergewissere Dich vorher hier</a>.</p>');
@define('PLUGIN_EVENT_TWITTER_TIMELINE',                'Status Timeline');
@define('PLUGIN_EVENT_TWITTER_TIMELINE_DESC',           '');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_OK',           'Verbindung hergestellt');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_DEL',          'Verbindung l�schen');

@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_DEL_OK',        'Twitter OAuth token entfernt');
@define('PLUGIN_EVENT_TWITTER_CLOSEWINDOW',              'Fenster schlie�en');
@define('PLUGIN_EVENT_TWITTER_REGISTER',                 'Registrieren');
@define('PLUGIN_EVENT_TWITTER_SIGNIN',                   'Verbinden');
@define('PLUGIN_EVENT_TWITTER_CALLBACKURL',              'Call Back URL (bei Twitter angeben)');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_ERROR',         'Fehler im Twitter Callback');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_NO',     'Artikel standardm��ig nicht via Microblogging ver�ffentlichen');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_NO_DESC','Wenn aktiviert, werden neue Artikel nur dann via Microblogging ver�ffentlicht, wenn dies ausdr�cklich angegeben wird.');

@define('PLUGIN_EVENT_TWITTER_GENERALCONSUMER',        '<h3>Dein eigener Twitter Client</h3>Normaler Weise nimmt das Plugin einen Twitter Client namens \'s9y\'. Du kannst aber auch <a href="https://dev.twitter.com/apps" target="_blank">Deinen eigenen Twitter Client registrieren</a> und dann den consumer key und das secret hier eintragen, wenn Du m�chtest.');

@define('PLUGIN_TWITTER_FILTER_RT',                        'Native Retweets filtern');
@define('PLUGIN_TWITTER_FILTER_RT_DESC',                   'Sollen native Retweets gefiltert werden? (Nur f�r die Twitter API 1.1, API 1.0 filtert diese immer heraus)');
@define('PLUGIN_TWITTER_API11',                            'OAuth Twitter API 1.1 benutzen');
@define('PLUGIN_TWITTER_API11_DESC',                       'Die Twitter API 1.0 ist "auslaufend" und wird 2013 eingestellt. Also solltest Du die API 1.1 benutzen. Allerdings muss daf�r bereits eine OAuth Verbindung im Hauptplugin zu Twitter hergestellt worden sein. Wenn Du in der Auswahl hier drunter enien Account siehst, dann wurde das bereits erledigt.');
@define('PLUGIN_TWITTER_OAUTHACC',                        'OAuth Verbindung f�r das Plugin');
@define('PLUGIN_TWITTER_OAUTHACC_DESC',                   'Das Plugin ben�tigt f�r die neue OAuth Twitter API eine OAuth Verbindung. Der Account, der hier ausgew�hlt wird, wird auch der sein, auf dessen Rate Limit Calls des Plugins gerechnet werden. Der Account muss Dir geh�ren, kann aber beliebig sein (also zum Beispiel einer nur f�r das Plugin, um nur dort das Rate Limit zu belasten)');

@define('PLUGIN_EVENT_TWITTER_API_TYPE',                'Twitter API Version');
@define('PLUGIN_EVENT_TWITTER_API_TYPE_DESC',           'Die Twitter API 1.0 ist "auslaufend" und wird 2013 eingestellt. Also solltest Du die API 1.1 benutzen. Allerdings muss daf�r bereits (bei Benutzerkonten) eine OAuth Verbindung zu Twitter hergestellt und hier eingestellt worden sein.');
@define('PLUGIN_EVENT_TWITTER_API_10',                  'API 1.0 [auslaufend]');
@define('PLUGIN_EVENT_TWITTER_API_11',                  'API 1.1 OAuth');
