<?php # lang_cz.inc.php 1.4 2009-02-23 17:20:11 VladaAjgl $

/**
 *  @version 1.4
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  Revize: Vladimír Ajgl <vlada@ajgl.cz> 2007/11/25 
 *  @author Vladimir Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/15
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/23
 */

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_NAME',		'Rozšířené volby pro práci s médii');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_DESC',		'Rozšiřuje možnosti vkládání obrázků z knihovny médií - quickblog a hromadné vkládání obrázků (více v dokumentaci v adresáři plugins/serendipity_evnets_imageselectorplus) [verze Serendipity >= 0.9].');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET',		'Cíl pro tento odkaz:');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_JS',		'Vyskakovací popup okno (pomocí JavaScriptu, přizpůsobitelná velikost)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_ENTRY',		'Samostatný příspěvek');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_BLANK',		'Vyskakovací popup okno (pomocí target=_blank)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_QUICKBLOG',		'QuickBlog');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_QUICKBLOG_DESC',		'Pokud v následujících polích zadáte alespoň nadpis, obrázek bude na blog zároveň odeslán jako nový záznam (příspěvek). Jeho vzhled je možno editovat pomocí šablony plugin_quickblog.tpl');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_MAXWIDTH',		'Maximální výška náhledu (šířka je přizpůsobena proporcionálně)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_MAXHEIGHT',		'Maximání šířka náhledu (výška je přizpůsobena proporcionálně)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_AUTORESIZE',		'Dynamicky měnit velikost obrázků v závislosti na atributech "width" a "height"');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_AUTORESIZE_DESC',		'Automaticky posílá klientovi obrázky s upravenou velikostí v závislosti na hodnotách atributí width a/nebo height v tagu IMG. Toto Vám může trochu usnadnit život a sníž dobu stahování stránek, ale také to snižuje výkon serveru. (Poznámka: poměr stran zůstává zachován)');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES',		'Rozbalování ZIP archivů');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES_BLABLAH',		'Pokud je nahraný soubor ZIP archiv, má se rozbalit? - Přednastavená hodnota pro zaškrtávací políčko ve formuláři pro nahrávání souborů.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES_DESC',		'Pokud je nahraný soubor ZIP archiv, má se rozbalit?');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_OK',		'ZIP archiv byl úspěšně rozbalen');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FAILED',		'ZIP archive se nepodařilo rozbalit');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_IMAGE_FROM_ARCHIVE',		'Obrázek ze ZIP archivu');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_ADD_TO_DB',		'přidán do databáze');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_JHEAD',		'Použít jhead pro získání EXIF dat');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_JHEAD_DESC',		'Překrývá standardní chování a používá externí volání aplikace jhead pro získání EXIF dat. Vyberte tuto možnost pouze pokud je aplikace jhead nainstalovaná a může být spouštěna.');
