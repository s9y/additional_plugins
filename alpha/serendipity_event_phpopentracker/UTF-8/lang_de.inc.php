<?php // v1.2, (c) Rene Schmidt

        @define('S9YPOT_NAME', 'PHPOpenTracker');
        @define('S9YPOT_CID', 'PHPOpenTracker-Client-ID');
        @define('S9YPOT_CID_DESC', 'Diese Client-ID zum Erfassen der Zugriffe benutzen');
        @define('S9YPOT_PATH', 'Pfad zu PHPOpenTracker');
        @define('S9YPOT_PATH_DESC', 'Absoluter Pfad der PHPOpenTracker-Installation (kein Slash am Ende)');
        @define('S9YPOT_FNAME', 'PHPOpenTracker-Dateiname');
        @define('S9YPOT_FNAME_DESC', 'Die Standard-Einstellung sollte OK sein.');
        @define('S9YPOT_DESC', 'Erfasst Zugriffe mittels PHPOpenTracker. Setzt installiertes phpOpenTracker voraus, siehe mitgelieferte readme.txt.');
        
        @define('S9YPOT_CID_ERROR', "Client_ID darf nur aus Ziffern bestehen.");
        @define('S9YPOT_PATH_ERROR', "Pfad muss absolut sein und darf kein Slash am Ende haben.");
        @define('S9YPOT_FNAME_ERROR', "Eine Datei mit diesem Namen existiert nicht an angegebenem Ort.");
        
        @define('S9YPOT_ERR_RESET', "Einstellungen wurden auf Standard-Werte zur&uuml;ckgesetzt. Lade die Seite neu, um die Standard-Werte zu sehen. Zugriffe werden nicht erfasst, solange keine funktionierenden Einstellungen gespeichert wurden.");
