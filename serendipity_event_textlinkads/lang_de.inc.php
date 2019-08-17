<?php # 

/**
 *  @version 
 *  @author Thomas Hochstein <thh@inter.net>
 */

@define('PLUGIN_EVENT_TEXTLINKADS_TITLE', 'Werbeanzeigen einbetten (TextLinkAds.com oder benutzerdefiniert)');
@define('PLUGIN_EVENT_TEXTLINKADS_DESC', 'Werbenanzeigen ins Blog einbetten.');
@define('PLUGIN_EVENT_TEXTLINKADS_INFO', '<p>Sie müssen die Smarty .tpl-Datei Ihres Themes bearbeiten, um anzugeben, wo die Anzeige platziert werden soll, sonst wird sie nicht auf Ihrer Seite angezeigt. Verwenden Sie diesen Smarty-Code, um eine TextLinkAd.com-Anzeige zu platzieren: {serendipity_hookPlugin hook="external_service_tla" hookAll="true"}. Wenn Sie  benutzerdefinierte Anzeigen verwenden möchten, können Sie den folgenden Smarty-Funktionsaufruf verwenden:</ p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="X: Y"}</ p>
<p>Ersetzen Sie dabei "X" durch den Namen des Unterverzeichnisses (relativ zum Basisverzeichnis des Plugins), in dem die Ad-Snippets erscheinen sollen. Das Plugin wählt dann mit der angegebenen Häufigkeit Y ("weekly", "daily", "hourly", "half-hour", "per-call") aus diesem Unterverzeichnis eine zufällige .html-Datei aus, die dann angezeigt wird.</ p>
<p>Sie haben beispielsweise ein Unterverzeichnis "headers" und "footes". Im Unterverzeichnis "headers" haben Sie die Dateien "nice.html", "nifty.html" und "great.html". Im Unterverzeichnis "footers" haben Sie die Dateien "great.html" und "awesome.html". Dann bearbeiten Sie die index.tpl-Datei Ihres Themes und platzieren diesen Code oben:</ p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="headers: daily"}</ p>
<p>und diesen Code im Footer-Bereich:</ p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="footers: weekly"}</ p>
<p>Wenn Sie dann Ihr Blog aufrufen, sehen Sie den oben eine zufällige .html-Datei aus "headers", die sich täglich ändert, und unten eine  zufällige .html-Datei aus "footers", die sich nur wöchentlich ändert. In den HTML-Dateien können Sie jeden beliebigen HTML-Code platzieren (wie JavaScript, GoogleAdSense usw.).');
@define('PLUGIN_EVENT_TEXTLINKADS_HTMLID', '(Für TextLinkAds) Die CSS-ID des HTML-Elements mit Ihren Textads.');
@define('PLUGIN_EVENT_TEXTLINKADS_XMLFILENAME', '(Für TextLinkAds) Der lokale Dateiname, in dem der Textlink gespeichert wird.');
