<?php # 
@define('PLUGIN_SNAPSHOTLINKS_NAME',                'Link Vorschau mit snap.com');
@define('PLUGIN_SNAPSHOTLINKS_DESC',                "Dieses Plugin zeigt eine Vorschau auf eine verlinkte Seite, wenn die Maus über dem Link schwebt. Dafür wird der SnapShot Service www.snap.com benutzt. Sie müssen sich dort vorher einmal mit Ihrer Domain und EMail registrieren, um einen Key zu erhalten, der benötigt wird, um die SnapShot Funktionalität aufzurufen.\nSnap.com ist ein kostenloser Service, aber beachten Sie, dass es snap.com möglich wäre, Datenprofile über Benutzer IPs, die einen Link auf dieser Seite anschauen, zu erstellen. Snap.com verspricht jedoch, dies nicht zu tun.");
@define('PLUGIN_SNAPSHOTLINKS_DESC_DUMMY',          "Dieses Plugin zeigt eine Vorschau auf eine verlinkte Seite, wenn die Maus über dem Link schwebt. Dafür wird der SnapShot Service www.snap.com benutzt.\nSnap.com ist ein kostenloser Service, aber beachten Sie, dass es snap.com möglich wäre, Datenprofile über Benutzer IPs, die einen Link auf dieser Seite anschauen, zu erstellen. Snap.com verspricht jedoch, dies nicht zu tun.");

@define('PLUGIN_SNAPSHOTLINKS_URL_NAME',            'Registrierte Domain');
@define('PLUGIN_SNAPSHOTLINKS_URL_DESC',            'Die bei der Registrierung bei snap.com angebene Domain.');
@define('PLUGIN_SNAPSHOTLINKS_KEY_NAME',            'Ihr SnapShots key');
@define('PLUGIN_SNAPSHOTLINKS_KEY_DESC',            'Nachdem die Domain und EMail Adresse registriert wurde, wird ein Skript angezeigt. In diesem ist der Key zwischen "key=" und "&" zu finden. Bitte kopieren Sie diesen Key in dieses Konfigurationsfeld (ohne das "&" am Ende)');

@define('PLUGIN_SNAPSHOTLINKS_THEME_NAME',          'Farb Thema');
@define('PLUGIN_SNAPSHOTLINKS_THEME_DESC',          'Bitte wähle Sie ein Farbthema');

@define('PLUGIN_SNAPSHOTLINKS_THEME_ASPHALT',       'Asphalt');
@define('PLUGIN_SNAPSHOTLINKS_THEME_GREEN',         'Grün');
@define('PLUGIN_SNAPSHOTLINKS_THEME_ICE',           'Hellblau');
@define('PLUGIN_SNAPSHOTLINKS_THEME_LINEN',         'Leinen');
@define('PLUGIN_SNAPSHOTLINKS_THEME_ORANGE',        'Orange');
@define('PLUGIN_SNAPSHOTLINKS_THEME_PINK',          'Rosa');
@define('PLUGIN_SNAPSHOTLINKS_THEME_PURPLE',        'Violett');
@define('PLUGIN_SNAPSHOTLINKS_THEME_SILVER',        'Silber');

@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSIZE_NAME',    'Vorschau Größe');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSIZE_DESC',    'Bitte beachten Sie, dass Sie die Ladezeit für Ihre Besucher erhöhen, wenn Sie hier "groß" auswählen, da dafür mehr Daten übertragen werden müssen.');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSIZE_SMALL',   'klein');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSIZE_LARGE',   'groß');

@define('PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_NAME', 'Vorschau auslösen durch Maus über..');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_DESC', 'Die Vorschau wird ausgelöst, wenn die Mausentweder über dem Link, dem (optionalen) Icon neben dem oder über einem von beidem schwebt.');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_LINK', 'den Link');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_ICON', 'das Icon');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_BOTH', 'beides, Link und Icon');

@define('PLUGIN_SNAPSHOTLINKS_LINKICON_NAME',       'Link Icon anzeigen');
@define('PLUGIN_SNAPSHOTLINKS_LINKICON_DESC',       'Soll ein Link Icon neben dem Link angezeigt werden?');

@define('PLUGIN_SNAPSHOTLINKS_USERPREVIEW_NAME',    'Vorschau vorladen');
@define('PLUGIN_SNAPSHOTLINKS_USERPREVIEW_DESC',    'Zuerst wird die Vorschau geladen. Das sollte ausgeschaltet sein, da ansonsten das Laden der Seite sehr langsam erscheint!');
@define('PLUGIN_SNAPSHOTLINKS_CUSTOMLOGO_NAME',     'Eigenes Logo');
@define('PLUGIN_SNAPSHOTLINKS_CUSTOMLOGO_DESC',     'Sie müssen Ihr eigenes Logo beim snap.com Service hoch laden, damit Sie es hier in der Vorschau einschalten können.');

// "Advanced options"
@define('PLUGIN_SNAPSHOTLINKS_SEARCHBOX_NAME',      'Sucheingabe darstellen');
@define('PLUGIN_SNAPSHOTLINKS_SEARCHBOX_DESC',      'Eine Sucheingabe in der Vorschau darstellen für die Suche im Web von Snap.com');
@define('PLUGIN_SNAPSHOTLINKS_ALLLINKS_NAME',       'Vorschau für externe Links');
@define('PLUGIN_SNAPSHOTLINKS_ALLLINKS_DESC',       'Wollen Sie eine Vorschau für externe Links? Das sind die, die auf Seiten aßerhalb Ihrer Domain zeigen.');
@define('PLUGIN_SNAPSHOTLINKS_LOCALLINKS_NAME',     'Vorschau für interne Links');
@define('PLUGIN_SNAPSHOTLINKS_LOCALLINKS_DESC',     'Wollen Sie eine Vorschau für interne Links? Das sind die, die auf Seiten innerhalb Ihrer Domain zeigen.');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSHOTS_NAME',   'Vorschau immer als Bild');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSHOTS_DESC',   'Stellt die Vorschau immer als Bild dar. Wenn Sie dies ausschalte wird zuerst versucht, die Vorschau in Textform (RSS Feeds z.B.) darzustellen. Das Ausschalten verringert die Ladezeiten beim Besucher.');

// Wikipedia Optionen:
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_NAME',         'Wikipedia Vorschau anzeigen');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_DESC',         'Es können Worte mit einem Icon versehen werden, bei dem der passende Wikipedia Eintrag angezeigt wird, wenn man über das Icon streicht. Wollen Sie diese Eigenschaft benutzen?');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_LANG_NAME',    'Wikipedia Sprache');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_LANG_DESC',    'Sie können einstellen, in welcher Sprachversion von Wikipedia gesucht werden soll. Für Deutsch sollten Sie hier "de" eintragen.');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_NAME',    'Wikipedia Markierung');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_DESC',    'Wie wollen Sie Worte markieren, für die ein Wikipedia Eintrag angezeigt werden soll?');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_BOLD',    'Fett markieren');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_ITALIC',  'Kursiv markieren');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_SUBLINED','Unterstreichen');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_REMOVE_TYPE_NAME',     'Wikipedia Markierung ersetzen?');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_REMOVE_TYPE_DESC',     'Wollen Sie, dass diese Markierung dann in der Darstellung nicht mehr vorhanden ist, oder wollen Sie diese Markierung behalten?');

?>