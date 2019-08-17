<?php # 

/**
 *  @version 
 *  @author Thomas Hochstein <thh@inter.net>
 */

@define('PLUGIN_EVENT_GALLERYIMAGE_NAME', 'Markup: Gallery');
@define('PLUGIN_EVENT_GALLERYIMAGE_DESC', 'Fügt ein Gallery-Album oder Bild in Form von Markup ein.');
@define('PLUGIN_EVENT_GALLERYIMAGE_GALLERY_BASE', 'URL der Gallery-Installation');
@define('PLUGIN_EVENT_GALLERYIMAGE_GALLERY_BASE_BLAHBLAH', 'Die Basis-Installations-URL von Gellery für Album-Links.');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_BASE', 'URL des Gallery-Album-Verzeichnisses');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_BASE_BLAHBLAH', 'Die Album-URL für <img>-Tags. (Für Gallery 2.x dient dies dazu, die korrekten Bildgrößen zu erhalten!)');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_MAXPOPUPSIZE', 'Maximale Größe für Popup-Fenster.');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_MAXPOPUPSIZE_BLAHBLAH', 'Horizontal oder vertikal, Standard ist 640 px.');      
@define('PLUGIN_EVENT_GALLERYIMAGE_VERSION', 'Welche Gallery-Version wird verwendet?');

@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_MAXTHUMBSIZE', 'Maximale Größe für Vorschaubilder (Nur für Gallery 2.x-Versionen!)');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_MAXTHUMBSIZE_BLAHBLAH', 'Horizontal oder vertikal, Standard ist 120 px.');
@define("PLUGIN_EVENT_GALLERYIMAGE_ALBUM_ABS", "Absoluter Album-Pfad (Nur für Gallery 2.x-Versionen!)");
@define("PLUGIN_EVENT_GALLERYIMAGE_ALBUM_ABS_BLAHBLAH", "Der absolute Server-Pfad zum Albumverzeichnis. Das './tmp'-Verzeichnis in diesem Albumverzeichnis muss für den Webserver beschreibbar sein!");
@define("PLUGIN_EVENT_GALLERYIMAGE_GALLERY_ABS", "Absoluter Pfad für Gallery (Nur für Gallery 2.x-Versionen verwendet!)");
@define("PLUGIN_EVENT_GALLERYIMAGE_GALLERY_ABS_BLAHBLAH", "Der absolute Server-Pfad zum Galerie-Verzeichnis.");

?>
