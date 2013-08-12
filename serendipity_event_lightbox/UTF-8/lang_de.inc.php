<?php # 

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  DE-Revision: Revision of lang_de.inc.php
 */

@define('PLUGIN_EVENT_LIGHTBOX_NAME',               'Lightbox/Thickbox JS/Graybox');
@define('PLUGIN_EVENT_LIGHTBOX_DESC',               'Lightbox JS ist eine einfaches unauffälliges Skript, das Bilder auf der Seite überlagern kann, wenn die große Version angeklickt wurde. Es fügt sich selbstständig in die Seite ein und funktioniert mit jedem modernen Browser. Lightbox verschönert Bilder-Popups, während ThickBox auch HTML Popups verändert. Beide Skripte durchsuchen ihre Einträge und ersetzen jeden \'a href="XXX"\' so, dass die interne Darstellung benutzt wird. Wenn Sie also ein Thumbnail Bild mit einem Popup der großen Version haben wollen, so fügen Sie das Thumbnail in ihren Eintrag ein und verlinken dieses mit der großen Version. Wenn Sie Thickbox benutzen, können sie zusätzlich auch ein \'class="thickbox"\' Attribut in ihren \'a href\' Link einfügen, um diese in einem Popup Fenster zu laden.');
@define('PLUGIN_EVENT_LIGHTBOX_TYPE',               'Wählen Sie das Skript aus, das ihre Bilder/Links formatieren soll');
@define('PLUGIN_EVENT_LIGHTBOX_PATH',               'Pfad zu den Skripten');
@define('PLUGIN_EVENT_LIGHTBOX_PATH_DESC',          'Geben Sie hier den kompletten HTTP Pfad ein (alles nach ihrem Domain Namen), der das Verzeichnis des Plugins angibt.');

@define('PLUGIN_EVENT_LIGHTBOX_OPTIMIZATION',       'JavaScript Ladeoptimierung');
@define('PLUGIN_EVENT_LIGHTBOX_OPTIMIZATION_DESC',  'Wenn sie diese Option anschalten, so werden die Skripte und CSS Dateien von Lightbox nur in den Seitenheader geladen, wenn auch ein Bild auf der aktuellen Seite dargestellt wird. Dies wird die Ladezeit von Seiten ohne Lightbox fähige Bilder spürbar verkürzen. Leider funktioniert das offenbar nicht bei allen Blogs, deshalb kann diese Optimierung ausgeschaltet werden, wodurch die Skripte wieder auf jeder Seite geladen werden.');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY',  'Galerie-Erzeugung');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_DESC',  'Steuert, ob das Blättern zum nächsten Bild über Pfeile möglich ist.');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_NONE', 'keine Galerie');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_ENTRY', 'nur Fotos eines Artikels');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_PAGE', 'alle Fotos der Seite'); 