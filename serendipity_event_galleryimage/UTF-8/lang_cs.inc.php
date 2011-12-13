<?php # lang_cs.inc.php 1.0 2009-07-14 20:11:52 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/07/14
 */

@define('PLUGIN_EVENT_GALLERYIMAGE_NAME',     'Markup: fotoalbum Gallery');
@define('PLUGIN_EVENT_GALLERYIMAGE_DESC',     'Vkládá album nebo obrázek z fotoalba aplikace Gallery pomocí značky v textu příspěvku.');
@define('PLUGIN_EVENT_GALLERYIMAGE_GALLERY_BASE',     'URL adresa serveru, na kterém je provozována Gallery');
@define('PLUGIN_EVENT_GALLERYIMAGE_GALLERY_BASE_BLAHBLAH',     'Základní URL adresa k instalaci aplikace Gallery');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_BASE',     'URL adresa k adresáři Gallery');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_BASE_BLAHBLAH',     'URL adresa alba pro tag <img>. (Pro verzi Gallery 2.x je tato volba používána pro správné nastavení velikosti obrázku!)');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_MAXPOPUPSIZE',     'Maximální rozměr vyskakovacího okna.');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_MAXPOPUPSIZE_BLAHBLAH',     'Svisle nebo vodorovně, výchozí hodnota je 640 pixelů.');      
@define('PLUGIN_EVENT_GALLERYIMAGE_VERSION',        'Kterou verzi aplikace Gallery používáte?');

@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_MAXTHUMBSIZE',     'Maximální rozměry pro náhledy (pouze pokud používáte Gallery verze 2.x!)');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_MAXTHUMBSIZE_BLAHBLAH',     'Svisle nebo vodorovně, výchozí hodnota je 120 pixelů.');      
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_ABS', 'Absolutní cesta k fotoalbu (Pouze pro verzi Gallery 2.x!)');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_ABS_BLAHBLAH', 'Absolutní serverová cesta k adresáři s fotoalbem. Podadresář ./tmp v tomto fotoalbu musí existovat a být zapisovatelný webserverem!');
@define('PLUGIN_EVENT_GALLERYIMAGE_GALLERY_ABS', 'Absolutní cesta ke galeriím (Pouze pro verzi Gallery 2.x!)');
@define('PLUGIN_EVENT_GALLERYIMAGE_GALLERY_ABS_BLAHBLAH', 'Absolutní serverová cesta k adresáři s galeriemi.');

?>
