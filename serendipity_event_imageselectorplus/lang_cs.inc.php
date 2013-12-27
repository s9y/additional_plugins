/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  Revize: Vladimír Ajgl <vlada@ajgl.cz> 2007/11/25 
 *  @author Vladimir Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/15
 */

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_NAME',		'Rozšíøené volby pro práci s médii');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_DESC',		'Rozšiøuje možnosti vkládání obrázkù z knihovny médií - quickblog a hromadné vkládání obrázkù (více v dokumentaci v adresáøi plugins/serendipity_evnets_imageselectorplus) [verze Serendipity >= 0.9].');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET',		'Cíl pro tento odkaz:');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_JS',		'Vyskakovací popup okno (pomocí JavaScriptu, pøizpùsobitelná velikost)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_ENTRY',		'Samostatný pøíspìvek');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_BLANK',		'Vyskakovací popup okno (pomocí target=_blank)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_QUICKBLOG',		'QuickBlog');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_QUICKBLOG_DESC',		'Pokud v následujících polích zadáte alespoò nadpis, obrázek bude na blog zároveò odeslán jako nový záznam (pøíspìvek). Jeho vzhled je možno editovat pomocí šablony plugin_quickblog.tpl');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_MAXWIDTH',		'Maximální výška náhledu (šíøka je pøizpùsobena proporcionálnì)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_MAXHEIGHT',		'Maximání šíøka náhledu (výška je pøizpùsobena proporcionálnì)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_AUTORESIZE',		'Dynamicky mìnit velikost obrázkù v závislosti na atributech "width" a "height"');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_AUTORESIZE_DESC',		'Automaticky posílá klientovi obrázky s upravenou velikostí v závislosti na hodnotách atributí width a/nebo height v tagu IMG. Toto Vám mùže trochu usnadnit život a sníž dobu stahování stránek, ale také to snižuje výkon serveru. (Poznámka: pomìr stran zùstává zachován)');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES',		'Rozbalování ZIP archivù');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES_BLABLAH',		'Pokud je nahraný soubor ZIP archiv, má se rozbalit? - Pøednastavená hodnota pro zaškrtávací políèko ve formuláøi pro nahrávání souborù.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES_DESC',		'Pokud je nahraný soubor ZIP archiv, má se rozbalit?');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_OK',		'ZIP archiv byl úspìšnì rozbalen');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FAILED',		'ZIP archive se nepodaøilo rozbalit');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_IMAGE_FROM_ARCHIVE',		'Obrázek ze ZIP archivu');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_ADD_TO_DB',		'pøidán do databáze');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_JHEAD',		'Použít jhead pro získání EXIF dat');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_JHEAD_DESC',		'Pøekrývá standardní chování a používá externí volání aplikace jhead pro získání EXIF dat. Vyberte tuto možnost pouze pokud je aplikace jhead nainstalovaná a mùže být spouštìna.');
