<?php

/**
 *  @version
 *  @author Translator Name <yourmail@example.com>
 *  DE-Revision: Revision of lang_de.inc.php
 */

@define('PLUGIN_EVENT_LIGHTBOX_NAME', 'Lightbox für Blog Einträge mit Bildern');
@define('PLUGIN_EVENT_LIGHTBOX_DESC', 'Das Lightbox Plugin ist eine einfaches unauffälliges Skript, das Bilder auf der Seite überlagern kann, wenn die große Version angeklickt wurde. Es fügt sich selbstständig in die Seite ein und funktioniert mit jedem modernen Browser. Alle Leuchtkästen verschönern Bilder-Popups. Dieses Plugin durchsucht ihre Einträge und ersetzt jeden auf ein Bild verweisenden \'a href="XXX"\' Link so, dass die interne Darstellung benutzt wird. Wenn Sie also ein Thumbnail Bild mit einem Popup der großen Version haben wollen, so fügen Sie das Thumbnail in ihren Eintrag ein und verlinken dieses mit der großen Version. Um auch versteckte Bilder mit display:none anzuzeigen, nutzen Sie das Lightbox2 Script. Diese Leuchtkasten Scripte sind alle jQuery basiert. Sie unterstützen nicht allein nur Bildtypen, sondern überwiegend auch anderes, wie Ajax, Videos, Flash, YouTube, iFrame, Inline oder modale Felder. Dieses Plugin nutzt sie nur für Fotografie Leuchtkästen, aber Sie können leicht andere Typen ihren Blog-Einträgen manuell hinzufügen und eine lightbox entsprechend für diesen Zweck initiieren, so wie es den jeweiligen Online-Dokumentationen beschrieben wird.');
@define('PLUGIN_EVENT_LIGHTBOX_TYPE', 'Wählen Sie das Skript aus, das ihre Bilder/Links formatieren soll');
@define('PLUGIN_EVENT_LIGHTBOX_PATH', 'Pfad zu den Skripten');
@define('PLUGIN_EVENT_LIGHTBOX_PATH_DESC', 'Geben Sie hier den kompletten HTTP Pfad ein (alles nach ihrem Domain Namen), der das Verzeichnis des Plugins angibt.');

@define('PLUGIN_EVENT_LIGHTBOX_OPTIMIZATION', 'JavaScript Ladeoptimierung');
@define('PLUGIN_EVENT_LIGHTBOX_OPTIMIZATION_DESC', 'Wenn sie diese Option anschalten, so werden die Skripte und CSS Dateien von Lightbox nur in den Seitenfooter geladen, wenn auch ein Bild auf der aktuellen Seite dargestellt wird. Dies kann die Ladezeit von Seiten ohne Lightbox fähige Bilder spürbar verkürzen.');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY', 'Galerie-Erzeugung');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_NONE', 'Nur einzelnes Bild');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_ENTRY', 'nur Fotos eines Artikels');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_PAGE', 'alle Fotos der Seite');
