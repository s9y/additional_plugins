<?php // v1.3, (c) Rene Schmidt

        @define('S9YPOT_NAME', 'PHPOpenTracker');
        @define('S9YPOT_CID', 'PHPOpenTracker-Client-ID');
        @define('S9YPOT_CID_DESC', 'Diese Client-ID zum Erfassen der Zugriffe benutzen');
        @define('S9YPOT_PATH', 'Pfad zu PHPOpenTracker');
        @define('S9YPOT_PATH_DESC', 'Bitte geben Sie den absoluten Pfad der PHPOpenTracker-Installation ohne Slash am Ende. Lassen Sie dieses Feld leer, wenn Sie einen Web Bug verwenden wollen.');
        @define('S9YPOT_FNAME', 'PHPOpenTracker-Dateiname');
        @define('S9YPOT_FNAME_DESC', 'Die Standard-Einstellung sollte OK sein.');
        @define('S9YPOT_DESC', 'Erfasst Zugriffe mittels PHPOpenTracker. Setzt installiertes phpOpenTracker voraus, siehe mitgelieferte readme.txt.');
        @define('S9YPOT_BUGFNAME', 'Web bug URL');
        @define('S9YPOT_BUGFNAME_DESC', 'Volle Web-Bug-URL mit http:// am Anfang.');
        @define('S9YPOT_BUGDEFAULT_FNAME', '');

        @define('S9YPOT_BUGURL_ERROR', "Web-Bug-URL muss mit http:// beginnen und absolut sein.");
        @define('S9YPOT_CID_ERROR', "Client_ID darf nur aus Ziffern bestehen.");
        @define('S9YPOT_PATH_ERROR', "Pfad muss entweder absolut sein und darf kein Slash am Ende haben oder leer sein.");
        @define('S9YPOT_FNAME_ERROR', "Eine Datei mit diesem Namen existiert nicht an angegebenem Ort.");

        @define('S9YPOT_ERR_RESET', "Einstellungen wurden auf Standard-Werte zur&uuml;ckgesetzt. Lade die Seite neu, um die Standard-Werte zu sehen. Zugriffe werden nicht erfasst, solange keine funktionierenden Einstellungen gespeichert wurden.");
