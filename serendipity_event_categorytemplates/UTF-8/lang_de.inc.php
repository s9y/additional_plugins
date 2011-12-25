<?php # $Id$

@define('PLUGIN_CATEGORYTEMPLATES_NAME', 'Eigenschaften/Templates von Kategorien');
@define('PLUGIN_CATEGORYTEMPLATES_DESC', 'Dieses Plugin ermöglicht erweitete Eigenschaften für Kategorien und deren Einträge festzulegen: speziell angepassete Templates, Anzeigereihenfolge, Anzeigeanzahl, Passwort-Schutz und Ausschluss aus dem RSS-Feed.');
@define('PLUGIN_CATEGORYTEMPLATES_SELECT', 'Bitte geben Sie den Verzeichnisnamen des Templates an, das für diese Kategorie verwendet werden soll. Die Verzeichnisnamen beginnen relativ ab ihrem templates/ Ordner. Sie können also z.B. "blue" oder "kubrick" eingeben. Alternativ können Sie auch Unterverzeichnisse eines Templates angeben, wenn Sie diese wie ein normales Template in einem Unterverzeichnis eines anderen Templates angelegt haben. Also z.B. "blue/kategorie1" oder "blue/kategorie2".');
@define('PLUGIN_CATEGORYTEMPLATES_FETCHLIMIT', 'Anzahl der Artikel für die Startseite der Kategorie');
@define('PLUGIN_CATEGORYTEMPLATES_PASS', 'Passwort-Schutz:');
@define('PLUGIN_CATEGORYTEMPLATES_PASS_DESC', 'Sollen Kategorien durch Passwörter geschützt werden können? Der Nachteil davon ist, dass eine weitere Datenbankabfrage durchgefürt werden muss und dass Artikel in passwortgeschützen Kategorien für Besucher NICHT auf der Startseite erscheinen, bis diese zur geschützen Kategorieansicht gehen.');
@define('PLUGIN_CATEGORYTEMPLATES_PASS_USER', 'Serendipity Kategorie Passwort-Schutz');
@define('PLUGIN_CATEGORYTEMPLATES_FIXENTRY', 'Fixe Zuweisung eines Artikels zu seiner Kategorie');
@define('PLUGIN_CATEGORYTEMPLATES_FIXENTRY_DESC', 'Wenn aktiviert, wird die Kategorie eines Artikels in der Detailansicht auf die jeweils aktuelle Kategorie gesetzt.');
@define('PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE', 'Rangordnung von Kategorie-Vorlagen');
@define('PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE_DESC', 'Wenn einem Artikel mehreren Kategorien zugewiesen ist, wird anhand dieser Liste entschieden, welches speziell angepasste Template (Formatvorlage) angewandt wird. Das oberste Template wird als erstes angewandt.');
@define('PLUGIN_CATEGORYTEMPLATES_NO_CUSTOMIZED_CATEGORIES', 'Bisher haben keine Kategorien speziell angepasste Templates.');
@define('PLUGIN_CATEGORYTEMPLATES_HIDERSS', 'Sollen Einträge in dieser Kategorie von RSS-Feeds ausgeschlossen werden?');
