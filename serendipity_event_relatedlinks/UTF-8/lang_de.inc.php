<?php # lang_de.inc.php 1.0 2009-08-20 10:12:40 VladaAjgl $

/**
 *  @version 1.0
 *  @author Konrad Bauckmeier <kontakt@dd4kids.de>
 *  @translated 2009/08/20
 */
        @define('PLUGIN_EVENT_RELATEDLINKS_TITLE', 'Verwandte Links/Einträge');
        @define('PLUGIN_EVENT_RELATEDLINKS_DESC', 'Fügt verwandte Links/Einträge in die Artikelansicht ein, die manuell für jeden Eintrag eingegeben werden können. Für flexible Ausgabe kann das Smarty-Template "plugin_relatedlinks.tpl" angepasst werde.');
        @define('PLUGIN_EVENT_RELATEDLINKS_ENTERDESC', 'Bitte in der folgenden Maske die verwandten Links eintragen, die später angezeigt werden sollen. Eine URL pro Zeile (d.h. durch Returns/Zeilenumbrüche getrennt, kein HTML!). Falls Sie ein Beschreibung des Links angeben wollen, bitte folgendes Format benutzen: http://example.com/link.html=Beispiel Beschreibung. Alles nach dem "=" Zeichen wird somit als Beschreibung gewertet. Falls dies nicht getan wird, werden nur URLs als Beschreibung dargestellt.');
        @define('PLUGIN_EVENT_RELATEDLINKS_LIST', 'Verwandte Links:');

        @define('PLUGIN_EVENT_RELATEDLINKS_POSITION', 'Position der Verwandten Links/Einträge');
        @define('PLUGIN_EVENT_RELATEDLINKS_POSITION_DESC', 'Soll die Liste der verwandten Links im Footer, im Eintrag oder via Smarty-Templating eingefügt werden? Falls Sie Smarty-Templating aktivieren müssen Sie folgende Zeile in ihre entries.tpl Datei einbinden, und zwar innerhalb der foreach-Schleife in der $entry gesetzt wird (z.B. bei den Kommentaren, Trackbacks und dem Erweiterten Eintrag): {serendipity_hookPlugin hook="frontend_display_relatedlinks" data=$entry hookAll="true"}{$RELATEDLINKS}');
        @define('PLUGIN_EVENT_RELATEDLINKS_POSITION_FOOTER', 'Im Footer des Eintrags');
        @define('PLUGIN_EVENT_RELATEDLINKS_POSITION_BODY', 'Im Text des Eintrags');
        @define('PLUGIN_EVENT_RELATEDLINKS_POSITION_SMARTY', 'Smarty-Aufruf verwenden');

// Next lines were translated on 2009/08/20
@define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR', 'Trennzeichen für Links');
@define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR_DESC', 'Geben Sie das Zeichen ein, womit die URLs von den Beschreibungen getrennt werden. Bitte achten Sie darauf, ein Sonderzeichen zu wählen, welches weder in der URL noch in der Beschreibung vorkommt, wie z.B. "|". ');