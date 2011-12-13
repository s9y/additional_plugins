<?php

        @define('PLUGIN_ADDUSER_NAME',     'Registrierung neuer User');
        @define('PLUGIN_ADDUSER_DESC',     'Ermöglicht es Blog-Besuchern sich einen eigenen Autoren-Account anzulegen. Zusammen mit dem Event-Plugin (index.php?serendipity[subpage]=adduser) kann eingestellt werden ob nur registrierte Benutzer Kommentare posten dürfen.');
        @define('PLUGIN_ADDUSER_INSTRUCTIONS', 'Eigene Hinweise');
        @define('PLUGIN_ADDUSER_INSTRUCTIONS_DESC', 'Geben Sie etwaige Zusatzinweise an, die im Formular erscheinen sollen');
        @define('PLUGIN_ADDUSER_INSTRUCTIONS_DEFAULT', 'Hier können Sie sich für dieses Blog als Autor anmelden. Einfach Daten eingeben, Formular abschicken und alles weitere per E-Mail erhalten.');
        @define('PLUGIN_ADDUSER_USERLEVEL', 'Standard Benutzerlevel');
        @define('PLUGIN_ADDUSER_USERLEVEL_DESC', 'Wählen Sie den Standard-Benutzerlevel für einen neu hinzugefügten Benutzer');
        @define('PLUGIN_ADDUSER_USERLEVEL_CHIEF', 'Chefredakteur');
        @define('PLUGIN_ADDUSER_USERLEVEL_EDITOR', 'Editor');
        @define('PLUGIN_ADDUSER_USERLEVEL_ADMIN', 'Administrator');
        @define('PLUGIN_ADDUSER_USERLEVEL_DENY', 'Zugriff verbieten');
        @define('PLUGIN_SIDEBAR_LOGIN', 'Seitenleisten-Plugin anzeigen?');
        @define('PLUGIN_SIDEBAR_LOGIN_DESC', 'Wenn aktiviert wird eine Loginbox in der Seitenleiste angezeigt. Wenn diese Option deaktiviert wird, erscheint die Seitenleisten-Box nicht, und neue User können sich nur mittels des zugehörigen Event-Plugins und dessen Extra-Unterseite anmelden.');
        
        @define('PLUGIN_ADDUSER_EXISTS', 'Sorry, der Username "%s" ist bereits vergeben. Bitte wählen Sie einen anderen Namen.');
        @define('PLUGIN_ADDUSER_MISSING', 'Sie müssen alle Felder ausfüllen, um einen Account zu beantragen.');
        @define('PLUGIN_ADDUSER_SENTMAIL', 'Ihr Account wurde erstellt. Sie haben gerade eine E-Mail mit weiteren Informationen erhalten.');
        @define('PLUGIN_ADDUSER_WRONG_ACTIVATION', 'Ungültiger Aktivierungslink!');

        @define('PLUGIN_ADDUSER_MAIL_SUBJECT', 'Ein neuer Autor hat sich registriert');
        @define('PLUGIN_ADDUSER_MAIL_BODY', "Für den Autoren %s wurde für das Blog %s ein Account eingerichtet. Um den Account zu aktivieren, bitte auf diesen Link klicken:\n\n%s\n\nErst nach diesem Vorgang ist der Login mit dem übermitteltem Passwort möglich. Diese Informations-E-Mail wurde sowohl an den Eigentümer des Blogs wie an den neuen Autoren geschickt.");
        @define('PLUGIN_ADDUSER_SUCCEED', 'Der Account wurde erfolgreich aktiviert. Sie können Sich nun in die Administrationsoberfläche einloggen, der Link dazu befindet sich in ihrer Aktivierungs-E-Mail.');
        @define('PLUGIN_ADDUSER_FAILED', 'Der Account konnte nicht freigeschaltet werden. Vielleicht haben Sie die URL aus ihrer Aktivierungs-E-Mail nicht korrekt kopiert?');

        @define('PLUGIN_ADDUSER_REGISTERED_ONLY', 'Nur registrierte Nutzer dürfen Kommentare schicken?');
        @define('PLUGIN_ADDUSER_REGISTERED_ONLY_DESC', 'Wenn diese Option aktiviert ist, dürfen nur registrierte Nutzer die Einträge kommentieren und müssen dazu eingelogged sein.');
        @define('PLUGIN_ADDUSER_REGISTERED_ONLY_REASON', 'Nur registrierte Benutzer dürfen Einträge kommentieren. Erstellen Sie sich einen eigenen Account <a href="%s">hier</a> und <a href="%s">loggen Sie sich danach ein</a>. Ihr Browser muss Cookies unterstützen.');

        @define('PLUGIN_ADDUSER_REGISTERED_CHECK', 'Autoren-Identitäten schützen');
        @define('PLUGIN_ADDUSER_REGISTERED_CHECK_DESC', 'Wenn aktiviert, können die Namen der registrierten Autoren nicht von Gästen benutzt werden.');
        @define('PLUGIN_ADDUSER_REGISTERED_CHECK_REASON', 'Der angegebene Benutzername wird bereits von einem Autoren dieses Blogs verwendet. Bitte <a href="%s" %s>loggen Sie sich ein</a> um das Kommentar abzuschicken oder benutzen einen anderen Benutzernamen.');

        @define('PLUGIN_ADDUSER_ADMINAPPROVE', 'Bestätigung der Registrierung durch Administrator?');
        @define('PLUGIN_ADDUSER_ADMINAPPROVE_DESC', 'Falls aktiviert müssen Administratoren einen neu registrierten Redakteur erst bestätigen, bevor sich diese einloggen können.');
        @define('PLUGIN_ADDUSER_SENTMAIL_APPROVE', 'Ihr Account wurde erstellt. Sie werden eine E-Mail mit weiteren Informationen erhalten, sobald ein Administrator ihren Antrag bestätigt hat.');
        @define('PLUGIN_ADDUSER_SENTMAIL_APPROVE_ADMIN', 'Der Account wurde akzeptiert, der entsprechende Redakteur wird nun seine E-Mail mit Zugangsdaten erhalten.');
        @define('PLUGIN_ADDUSER_MAIL_SUBJECT_APPROVE', '[Bewilligung notwendig] Ein neuer Autor hat sich registriert');
        @define('PLUGIN_ADDUSER_MAIL_BODY_APPROVE', "Für den Autoren %s wurde für das Blog %s ein Account eingerichtet. Um dem Redakteur den Login zu erlauben, bitte auf diesen Link klicken:\n\n%s\n\nErst nach diesem Vorgang wird der Redakteur seine Zugangsdaten per E-Mail erhalten.");
