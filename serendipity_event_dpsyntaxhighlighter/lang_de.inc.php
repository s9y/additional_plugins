<?php

/**
 *  @version 
 *  @author Thomas Hochstein <thh@inter.net>
*/

@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_NAME', 'Markup: Syntax-Hervorhebung');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_DESC', 'Dieses Plugin ist ein JavaScript-Syntax-Hervorheber, der auf dem gleichnamigen Code von Alex Gorbatchev basiert. '
        .'Es benötigt weniger serverseitige Ressourcen als GeSHi und zeigt im eigentlichen HTML-Code weniger Markups an; eine leichtgewichtigere, sauberere Alternative. '
        .'Dieses Plugin benötigt das zugehörige Theme, um die folgenden Hooks bereitzustellen: frontend_header, frontend_footer (und optional backend_preview im '
        .'Admin-Theme).');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_PATH', 'Pfad zu den Scripts');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_PATH_DESC', 'Geben Sie den vollständigen HTTP-Pfad (alles nach Ihrem Domain-Namen) ein, der zum Verzeichnis dieses Plugins führt. ');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_THEME', 'Theme auswählen');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_THEME_DESC', 'Wählen Sie ein Theme / einen Stil für den Syntax-Hervorheber, der dem Blog am besten entspricht.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_TOOLBAR', 'Symbolleiste anzeigen?');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_TOOLBAR_DESC', 'Zeigt die Fragezeichen-Schaltfläche mit dem Info-Dialog an.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_AUTOLINS', 'URLs klickbar machen?');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_AUTOLINKS_DESC', 'Aktiviert/deaktiviert die Erkennung von Links im hervorgehobenen Element. Wenn die Option deaktiviert ist, können URLs nicht angeklickt werden.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_CLASSNAME', 'Benutzerdefinierte CSS-Klassen hinzufügen');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_CLASSNAME_DESC', 'Ermöglicht das Hinzufügen einer benutzerdefinierten Klasse (oder mehrerer Klassen) zu jedem hervorgehobenen Element, das auf der Seite angezeigt wird.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_COLLAPSE', 'Hervorgehobene Codeausschnitte einklappen?');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_COLLAPSE_DESC', 'Ermöglicht es Ihnen, hervorgehobene Elemente standardmäßíg einzuklappen. In diesem Fall muss die Symbolleiste angezeigt werden, andernfalls wird kein Code-Ausschnitt zu sehen sein.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_GUTTER', 'Zeilennummern anzeigen?');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_GUTTER_DESC', 'Ermöglicht das Ein- und Ausschalten der Zeilennummern.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_SMARTTABS', 'Smart tabs?');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_SMARTTABS_DESC', 'Aktiviert/deaktiviert Smart Tabs.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_TABSIZE', 'Größe der Smart Tabs');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_TABSIZE_DESC', 'Hier können Sie die Größe der Registerkarten anpassen.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_STRIPBRS', '<br> Tags ignorieren?');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_STRIPBRS_DESC', 'Wenn Ihre Software am Ende jeder Zeile <br />-Tags hinzufügt, können Sie diese ignorieren.');