<?php # $Id: lang_de.inc.php,v 1.1 2005/08/01 18:18:51 garvinhicking Exp $

        @define('PLUGIN_EVENT_EXTERNALAUTH_TITLE', 'Externe Benutzer-Authentifizierung (LDAP) [EXPERIMENTAL]');
        @define('PLUGIN_EVENT_EXTERNALAUTH_DESC', 'Ermöglicht die externe authentifizierung für Logins der Benutzer. Die Zugangsdaten werden im lokalen Serendipity Datenbank-Framework gecached.');
        @define('PLUGIN_EVENT_EXTERNALAUTH_SOURCE', 'Authentifizierungs-Quelle');
        @define('PLUGIN_EVENT_EXTERNALAUTH_SOURCE_DESC', 'Wählen Sie die Quelle der externen Zugangsdaten');
        @define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL', 'Standard Benutzerlevel');
        @define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_DESC', 'Wählen Sie den Standard-Benutzerlevel für einen neu hinzugefügten externen Benutzer');
        @define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ATTR', 'Benutzerlevel Attribut');
        @define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ATTR_DESC', 'Welches Attribut enthält die Angabe des Benutzerlevel für einen neu synchronisierten Benutzer?');
        @define('PLUGIN_EVENT_EXTERNALAUTH_HOST', 'Ziel-Host');
        @define('PLUGIN_EVENT_EXTERNALAUTH_HOST_DESC', 'Auf welchem Server befindet sich die Authentifizierungsquelle');
        @define('PLUGIN_EVENT_EXTERNALAUTH_PORT', 'Ziel-Port');
        @define('PLUGIN_EVENT_EXTERNALAUTH_PORT_DESC', 'Verbindungs-Port der Authentifizierungsquelle. Ein leerer Wert nutzt den Standardport.');
        @define('PLUGIN_EVENT_EXTERNALAUTH_RDN', 'Authentifizierungsstring');
        @define('PLUGIN_EVENT_EXTERNALAUTH_RDN_DESC', 'String für die Authentifizierung. %1 wird durch den Benutzernamen, %2 durch das Passwort und %3 durch das MD5-kodierte Passwort ersetzt');
        @define('PLUGIN_EVENT_EXTERNALAUTH_FIRSTLOGIN', 'Externe Authentifizierung nur einmalig durchführen');
        @define('PLUGIN_EVENT_EXTERNALAUTH_FIRSTLOGIN_DESC', 'Soll die externe Authentifizierung nur einmal pro Session ausgeführt werden, oder bei jeder Anfrage? JA wird die Geschwindigkeit erhöhen, NEIN die Sicherheit.');

        @define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_CHIEF', 'Chefredakteur');
        @define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_EDITOR', 'Editor');
        @define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ADMIN', 'Administrator');
        @define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_DENY', 'Zugriff verbieten');
