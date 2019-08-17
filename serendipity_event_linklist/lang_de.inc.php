<?php

/**
 *  @version 
 *  @author Thomas Hochstein <thh@inter.net>
 */

//
//  serendipity_event_linklist.php
//
@define('PLUGIN_LINKLIST_TITLE', 'Linkliste');
@define('PLUGIN_LINKLIST_DESC', 'Linkmanager - zeigt Ihre Lieblingslinks in der Seitenleiste an.');
@define('PLUGIN_LINKLIST_LINK', 'Link');
@define('PLUGIN_LINKLIST_LINK_NAME', 'Name');
@define('PLUGIN_LINKLIST_ADMINLINK', 'Links verwalten');
@define('PLUGIN_LINKLIST_ORDER', 'Links sortiuern nach:');
@define('PLUGIN_LINKLIST_ORDER_DESC', 'Sortierung der angezeigten Links auswählen.');
@define('PLUGIN_LINKLIST_ORDER_NUM_ORDER', 'Benutzerdefiniert');
@define('PLUGIN_LINKLIST_ORDER_DATE_ACS', 'Nach Datum (vom ältesten aufsteigend)');
@define('PLUGIN_LINKLIST_ORDER_DATE_DESC', 'Nach Datum (vom neuesten absteigend)');
@define('PLUGIN_LINKLIST_ORDER_CATEGORY', 'Nach Kategorien');
@define('PLUGIN_LINKLIST_ORDER_ALPHA', 'Alphabetisch');
@define('PLUGIN_LINKLIST_LINKS', 'Links verwalten');
@define('PLUGIN_LINKLIST_NOLINKS', 'Keine Links vorhanden');
@define('PLUGIN_LINKLIST_CATEGORY', 'Kategorien verwenden');
@define('PLUGIN_LINKLIST_CATEGORYDESC', 'Kategorien verwenden, um Links zu organisieren.');
@define('PLUGIN_LINKLIST_ADDLINK', 'Link hinzufügen');
@define('PLUGIN_LINKLIST_LINK_EXAMPLE', 'Beispiel: http://www.s9y.org oder http://www.s9y.org/forums/');
@define('PLUGIN_LINKLIST_EDITLINK', 'Link bearbeiten');
@define('PLUGIN_LINKLIST_LINKDESC', 'Beschreibung für den Link');
@define('PLUGIN_LINKLIST_CATEGORY_NAME', 'Kategoriensystem:');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DESC', 'Sie können entweder die Blog-Kategorien oder die mit diesem Plugin bereitgestellten benutzerdefinierten Kategorien verwenden.');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_CUSTOM', 'Benutzerdefiniert');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DEFAULT', 'Standard');
@define('PLUGIN_LINKLIST_ADD_CAT', 'Kategorie verwalten');
@define('PLUGIN_LINKLIST_CAT_NAME', 'Name der Kategorie');
@define('PLUGIN_LINKLIST_PARENT_CATEGORY', 'Übergeordnete Kategorie');
@define('PLUGIN_LINKLIST_ADMINCAT', 'Kategorien administrieren');
@define('PLUGIN_LINKLIST_CACHE_NAME', 'Seitenleiste cachen');
@define('PLUGIN_LINKLIST_CACHE_DESC', 'Durch das Zwischenspeichern der Seitenleiste wird die Geschwindigkeit Ihrer Seite erhöht. Um den Cache für Fehlerbehebungszwecke zu löschen, schalten Sie ihn aus und wieder ein.');
@define('PLUGIN_LINKLIST_ENABLED_NAME', 'Aktiviert');
@define('PLUGIN_LINKLIST_ENABLED_DESC', 'Plugin aktivieren/deaktivieren.');
@define('PLUGIN_LINKLIST_DELETE_WARN', 'Wenn eine Kategorie gelöscht wird, werden alle ihre Einträge in die Stammkategorie verschoben.');

//
//  serendipity_plugin_linklist.php
//
@define('PLUGIN_LINKS_NAME', 'Linkliste');
@define('PLUGIN_LINKS_BLAHBLAH', 'Linkmanager - zeigt Ihre Lieblingslinks in der Seitenleiste an.');
@define('PLUGIN_LINKS_TITLE', 'Überschrift');
@define('PLUGIN_LINKS_TITLE_BLAHBLAH', 'Die Überschrift für die Linkliste.');
@define('PLUGIN_LINKS_TOP_LEVEL', 'Text für die oberste Ebene');
@define('PLUGIN_LINKS_TOP_LEVEL_BLAHBLAH', 'Geben Sie hier einen beliebigen Text ein, der auf der obersten Ebene erscheinen soll (kann leer bleiben)');
@define('PLUGIN_LINKS_DIRECTXML', 'XML direkt eingeben');
@define('PLUGIN_LINKS_DIRECTXML_BLAHBLAH', 'Sie können XML-Daten direkt eingeben oder eine Webseite zum Verwalten von Links verwenden.');
@define('PLUGIN_LINKS_LINKS', 'Linkliste');
@define('PLUGIN_LINKS_LINKS_BLAHBLAH', 'Verwenden Sie XML!! - Verwenden Sie für Verzeichnissblöcke <dir name="dir name"> und schließen Sie mit </dir>. - Verwenden Sie für Links <link name="link name" link="http://link.com/" />.');
@define('PLUGIN_LINKS_OPENALL', 'Linktext für "Alle ausklappen"');
@define('PLUGIN_LINKS_OPENALL_BLAHBLAH', 'Geben Sie den Linktext für den Link "Alle ausklappen" ein.');
@define('PLUGIN_LINKS_OPENALL_DEFAULT', 'Alle ausklappen');
@define('PLUGIN_LINKS_CLOSEALL', 'Linktext für "Alle einklappen"');
@define('PLUGIN_LINKS_CLOSEALL_BLAHBLAH', 'Geben Sie den Linktext für den Link "Alle einklappen" ein.');
@define('PLUGIN_LINKS_CLOSEALL_DEFAULT', 'Alle einklappen');
@define('PLUGIN_LINKS_SHOW', 'Links zum Aus-/Einklappen anzeigen?');
@define('PLUGIN_LINKS_SHOW_BLAHBLAH', 'Möchten Sie die Links "Alle ausklappen" und "Alle einklappen" sehen?');
@define('PLUGIN_LINKS_LOCATION', 'Link-Position');
@define('PLUGIN_LINKS_LOCATION_BLAHBLAH', 'Position der Links zum Aus-/Einklappen.');
@define('PLUGIN_LINKS_LOCATION_TOP', 'Oben');
@define('PLUGIN_LINKS_LOCATION_BOTTOM', 'Unten');
@define('PLUGIN_LINKS_SELECTION', 'Auswahl ermöglichen');
@define('PLUGIN_LINKS_SELECTION_BLAHBLAH', 'Bei "Ja" können Knoten ausgewählt (hervorgehoben) werden.');
@define('PLUGIN_LINKS_COOKIE', 'Cookies verwenden');
@define('PLUGIN_LINKS_COOKIE_BLAHBLAH', 'Bei "Ja" verwendet die Baumanzeige Cookies, um ihren Zustand zu speichern.');
@define('PLUGIN_LINKS_LINE', 'Linien verwenden');
@define('PLUGIN_LINKS_LINE_BLAHBLAH', 'Bei "Ja" wird die Baumanzeige mit Linien gezeichnet.');
@define('PLUGIN_LINKS_ICON', 'Icons verwenden');
@define('PLUGIN_LINKS_SVGICON', 'Use link SVG icon by CSS');
@define('PLUGIN_LINKS_ICON_BLAHBLAH', 'Bei "Ja" wird die Baumanzeige mit Icons gezeichnet.');
@define('PLUGIN_LINKS_STATUS', 'Statuszeile verwenden');
@define('PLUGIN_LINKS_STATUS_BLAHBLAH', 'Bei "Ja" wird die Knotenbezeichnung statt der URL in der Statuszeile des Browsers angezeigt.');
@define('PLUGIN_LINKS_CLOSELEVEL', 'Gleiche Ebene schließen');
@define('PLUGIN_LINKS_CLOSELEVEL_BLAHBLAH', 'Bei "Ja" kann nur ein Knoten innerhalb eines übergeordneten Knotens gleichzeitig erweitert werden. "Alle ausklappen" und "Alle einklappen" funktionieren nicht, wenn diese Option aktiviert ist.');
@define('PLUGIN_LINKS_TARGET', 'Linkziel');
@define('PLUGIN_LINKS_TARGET_BLAHBLAH', 'Das Ziel für die Links kann "_blank", "_self", "_top", "_parent" oder der Name eines Frames sein.');
@define('PLUGIN_LINKS_IMGDIR', 'Plugin-Image-Verzeichnis verwenden');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH', 'Bei "Ja" geht das Plugin davon aus, dass sich die Bilder im Plugin-Ordner befinden. Bei "Nein" verwendet das Plugin als Pfad für die Bilder "/templates/default/img/". Das Deaktivieren des Plugin-Image-Verzeichnisses ist für gemeinsame Installationen erforderlich, erfordert jedoch, dass die Bilder manuell verschoben werden.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME', 'Kategoriebaum aus- oder einklappen');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_DESC', 'Bei der Sortierung nach Kategorien werden die Links standardmäßig aus- oder eingeklappt.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_CLOSED', 'Ausklappen');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_OPEN', 'Einklappen');
@define('PLUGIN_LINKLIST_OUTSTYLE_DTREE', 'dtree');
@define('PLUGIN_LINKLIST_OUTSTYLE_CSS', 'CSS-Liste');
@define('PLUGIN_LINKLIST_ORDER_OUTSTYLE_SIMP_CSS', 'Einfaches CSS');
@define('PLUGIN_LINKS_OUTSTYLE', 'Anzeige-Stil für die Linkliste wählen');
@define('PLUGIN_LINKS_OUTSTYLE_BLAHBLAH', 'Wählen Sie den Ausgabestil für die Linkliste. "dtree" verwendet Javascript, um eine browserübergreifende Baumansicht zu erstellen. "CSS-Liste" verwendet CSS und ein einfaches Javascript, um die "dtree"-Ansicht wiederzugeben, unterstützt jedoch nicht alle Funktionen von "dtree". "Einfaches CSS" gibt eine einfache CSS-gesteuerte Liste aus, die eine genaue Kontrolle über die Darstellung von Links ermöglicht. Beachten Sie, dass "dtree" in der Regel nicht von Suchmaschinen ausgewertet werden kann.');
@define('PLUGIN_LINKS_CALLMARKUP', 'Markup-Plugins anwenden?');
@define('PLUGIN_LINKS_CALLMARKUP_BLAHBLAH', 'Wählen Sie diese Option, um Markups-Plugins auf die Linkliste anzuwenden. Dies wendet alle Markup-Plugins an, die auch auf einen HTML-Klotz angewendet werden.');
@define('PLUGIN_LINKS_USEDESC', 'Vorhandene Beschreibung verwenden');
@define('PLUGIN_LINKS_USEDESC_BLAHBLAH', 'Verwenden Sie die Beschreibung als Linktitel, falls sie verfügbar ist.');
@define('PLUGIN_LINKS_PREPEND', 'Geben Sie einen beliebigen Text ein, der vor der Linkliste angezeigt werden soll.');
@define('PLUGIN_LINKS_APPEND', 'Geben Sie einen beliebigen Text ein, der nach der Linkliste angezeigt werden soll.');

