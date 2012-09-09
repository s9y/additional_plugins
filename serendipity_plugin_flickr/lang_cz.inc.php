<?php # lang_cz.inc.php 1.1 2011-09-18 13:11:29 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/23
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/09/18
 */
@define('PLUGIN_SIDEBAR_FLICKR', 'Flickr');
@define('PLUGIN_SIDEBAR_FLICKR_DESC', 'Zobrazuje nejnovìj¹í fotografie z libovolného (co¾ obvykle znamená z Va¹eho) kanálu Flickr. Podrobnosti viz. http://www.flickr.com/.');
@define('PLUGIN_EVENT_FLICKRCSS', 'Flickr Photostream CSS');
@define('PLUGIN_EVENT_FLICKRCSS_DESC', 'Tento plugin je roz¹íøením postranního pluginu "Flickr Photostream" a pøidává k nìmu stylování (CSS).');

@define('PLUGIN_SIDEBAR_FLICKR_TITLE_TITLE', 'Nadpis');
@define('PLUGIN_SIDEBAR_FLICKR_TITLE_BLAHBLAH', 'Nadpis postranního sloupce s Flickrem. Mù¾e být prázdný.');
@define('PLUGIN_SIDEBAR_FLICKR_USER_TITLE', 'Úèet Flickr');
@define('PLUGIN_SIDEBAR_FLICKR_USER_BLAHBLAH', 'U¾ivatelské jméno nebo email');

@define('PLUGIN_SIDEBAR_FLICKR_IMG_SQUARE', 'Ètverec');
@define('PLUGIN_SIDEBAR_FLICKR_IMG_THUMBNAIL', 'Náhled');
@define('PLUGIN_SIDEBAR_FLICKR_IMG_SMALL', 'Malý');
@define('PLUGIN_SIDEBAR_FLICKR_IMG_MEDIUM', 'Prostøední');
@define('PLUGIN_SIDEBAR_FLICKR_IMG_LARGE', 'Velký');
@define('PLUGIN_SIDEBAR_FLICKR_IMG_ORIGINAL', 'Pùvodní');

@define('PLUGIN_SIDEBAR_FLICKR_LIGHTBOX_TITLE', 'Lightbox');
@define('PLUGIN_SIDEBAR_FLICKR_LIGHTBOX_BLAHBLAH', 'Pro pou¾ití pluginu LIghtbox pro zobrazení obrázkù FlickrShow, zadejte pøiøazené tagy "rel". Pracuje pouze pokud je odkaz nastavený na "JPG". Výchozí: lightbox[lightbox_group_etnry_flickr]');

@define('PLUGIN_SIDEBAR_FLICKR_SRCIMG_TITLE', 'Velikost náhledu');
@define('PLUGIN_SIDEBAR_FLICKR_TGTIMG_TITLE', 'Odkaz');

@define('PLUGIN_SIDEBAR_FLICKR_SHOWDATE', 'Zobrazovat datum obrázku');
@define('PLUGIN_SIDEBAR_FLICKR_SHOWTITLE', 'Zobrazovat popis obrázku');

@define('PLUGIN_SIDEBAR_FLICKR_TGTLINK_TITLE', 'Odkaz obrázku');
@define('PLUGIN_SIDEBAR_FLICKR_TGTLINK_JPG', 'JPG');
@define('PLUGIN_SIDEBAR_FLICKR_TGTLINK_FLICKR', 'Flickr');

@define('PLUGIN_SIDEBAR_FLICKR_NUM_TITLE', 'Poèet zobrazených obrázkù');
@define('PLUGIN_SIDEBAR_FLICKR_NUM_BLAHBLAH', 'Min: 1, Max: 500');

@define('PLUGIN_SIDEBAR_FLICKR_APIKEY_TITLE', 'Flickr API Key');
@define('PLUGIN_SIDEBAR_FLICKR_APIKEY_BLAHBLAH', 'Abyste mohli vyu¾ívat tento plugin, musíte vlastnit Flickrem vygenerovaný "Services API Key". Generátor najdete na http://www.flickr.com/services/api/key.gne. Registrace je jednoduchá, klíè obdr¾íte na poèkání.');

@define('PLUGIN_SIDEBAR_FLICKR_APISECRET_TITLE', 'Flickr API Secret');
@define('PLUGIN_SIDEBAR_FLICKR_APISECRET_DESC', 'Tajný klíè - není povinný, umo¾òuje zabezpeèený pøenos dat. Tento tajný klíè mù¾ete obdr¾et/nastavit na Flickru na stránce s profilem.');

@define('PLUGIN_SIDEBAR_FLICKR_CACHE_TITLE', 'Cache timeout');
@define('PLUGIN_SIDEBAR_FLICKR_CACHE_DESC', 'Tento plugin pou¾ívá cachování PEAR::Cache_Lite. Zadejte platnost cache ve vteøinách.');

@define('PLUGIN_SIDEBAR_FLICKR_SHOWRSS', 'Zobrazit RSS odkaz');
@define('PLUGIN_SIDEBAR_FLICKR_SHOWPHOTOSTREAM', 'Zobrazit odkaz na Flickr Photostream');

@define('PLUGIN_SIDEBAR_FLICKR_LINK_SHOWRSS', 'Flickr RSS kanál');
@define('PLUGIN_SIDEBAR_FLICKR_LINK_PHOTOSTREAM', 'Flickr Photostream');

/* Errors */
@define('PLUGIN_SIDEBAR_FLICKR_ERROR_WRONGUSER', 'Úèet na Flickru neexistuje, nebo je ¹patnì zadaný API klíè.');
@define('PLUGIN_SIDEBAR_FLICKR_ERROR_NOIMG', '®ádné obrázky.');

// Next lines were translated on 2011/09/18
@define('PLUGIN_SIDEBAR_FLICKR_NUMBEROFCHOICES', 'Poèet vybraných obrázkù');
@define('PLUGIN_SIDEBAR_FLICKR_USECHOICES', 'Náhodnì zamíchat vybrané obrázky?');