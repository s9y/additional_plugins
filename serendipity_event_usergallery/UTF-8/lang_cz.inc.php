<?php # lang_cz.inc.php 1.0 2009-08-08 13:35:22 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/08/08
 */

@define('PLUGIN_EVENT_USERGALLERY_TITLE', 'Galerie');
@define('PLUGIN_EVENT_USERGALLERY_DESC', 'Umožňuje nepřihlášeným uživatelům prohlížet Serendipity knihovnu médií');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_TWO', '2');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_THREE', '3');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_FOUR', '4');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_FIVE', '5');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_DESC', 'Počet sloupců v zobrazení galerie');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_NAME', 'Počet sloupců');
@define('PLUGIN_EVENT_USERGALLERY_PERMALINK_NAME', 'Stálý odkaz (permalink) na stránku galerie');
@define('PLUGIN_EVENT_USERGALLERY_PERMALINK_DESC', 'Zadejte jedinečný odkaz, pod kterým bude přístupná galerie');
@define('PLUGIN_EVENT_USERGALLERY_SUBNAME_NAME', 'Jméno podstránky pro zobrazení galerie');
@define('PLUGIN_EVENT_USERGALLERY_SUBNAME_DESC', 'Zadejte jedinečné jméno podstránky, které bude svázáno s galerií (galerie bude přístupná pod adresou index.php?serendipity[subpage]=zde_zadané_jméno)');
@define('PLUGIN_EVENT_USERGALLERY_DIRECTORY_NAME', 'Vyberte výchozí adresář');
@define('PLUGIN_EVENT_USERGALLERY_DIRECTORY_DESC', 'Vyberte adresář knihovny médií, na který má být omezeno zobrazení galerie');
@define('PLUGIN_EVENT_USERGALLERY_STYLE_NAME', 'Vyberte vzhled galerie');
@define('PLUGIN_EVENT_USERGALLERY_STYLE_DESC', '"Knihovna médií! umožňuje procházení po adresářích a vyhledávání, zatímco "Stránka s náhledy" zobrazí náhledy všech obrázků v adresáři a obrázky otevírá v novém okně.');
@define('PLUGIN_EVENT_USERGALLERY_STYLE_SERENDIPITY', 'Knihovna médií');
@define('PLUGIN_EVENT_USERGALLERY_STYLE_THUMBPAGE', 'Stránka s náhledy');
@define('PLUGIN_EVENT_USERGALLERY_PRETTY_NAME', 'Nadpis galerie');
@define('PLUGIN_EVENT_USERGALLERY_PRETTY_DESC', 'Zadejte nadpis stránka s galerií');
@define('PLUGIN_EVENT_USERGALLERY_INTRO', 'Úvodní text (nepovinné)');
@define('PLUGIN_EVENT_USERGALLERY_FIXED_WIDTH', 'Pevná velikost obrázků v zobrazení galerie');
@define('PLUGIN_EVENT_USERGALLERY_FIXED_DESC', 'Nastaví výšku a šířku obrázku na pevnou hodnotu při prohlížení galerie. Zadejte nulu pro použití standardních náhledů.');
@define('PLUGIN_EVENT_USERGALLERY_FILESIZE', 'Velikost souboru');
@define('PLUGIN_EVENT_USERGALLERY_FILENAME', 'Jméno souboru');
@define('PLUGIN_EVENT_USERGALLERY_DIMENSION', 'Rozměry');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_NAME', 'Zobrazit jediný obrázek');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_DESC', 'Můete zobrazovat obrázky v měřítku přizpůsobené stránce (s adaptivním pop-up oknem pro velké obrázky), nebo v adaptivním pop-up okně přímo po kliknutí na náhled na stránce galerie.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_INPAGE', 'Přizpůsobené měřítko');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_POPUP', 'Adaptivní pop-up okno');
@define('PLUGIN_EVENT_USERGALLERY_DIRLIST_NAME', 'Zobrazit výpis adresáře');
@define('PLUGIN_EVENT_USERGALLERY_DIRLIST_DESC', 'Pokud je nastavené na "Ano", galerie bude zobrazovat výpis všech podadresářů ve výchozím adresáři.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGESTRICT_NAME', 'Pouze obrázky v aktuálním adresáři');
@define('PLUGIN_EVENT_USERGALLERY_IMAGESTRICT_DESC', 'Pokud nastaveno na "Ano", galerie bude zobrazovat pouze obrázky v aktuálním adresáři. Pokud nastaveno na "Ne", galerie bude zobrazovat všechny obrázky ze všech podadresářů.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_NAME', 'Řazení');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_DESC', 'Vyberte pořadí, v jakém se mají vypisovat obrázky');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_NAMEACS', 'Jméno (vzestupně)');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_NAMEDESC', 'Jméno (sestupně)');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_DATEACS', 'Datum (vzestupně)');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_DATEDESC', 'Datum (sestupně)');
@define('PLUGIN_EVENT_USERGALLERY_DISPLAYDIR_NAME', 'Zobrazit celý strom adresářů');
@define('PLUGIN_EVENT_USERGALLERY_DISPLAYDIR_DESC', '"Ano" znamená, že se bude na každé stránce galerie zobrazovat celý strom adresářů. "Ne" znamená, že se bude vypisovat pouze strom podadresářů aktuálního adresáře. (Toto chování je také závislé na šabloně vzhledu použité pro zobrazení galerie.)');
@define('PLUGIN_EVENT_USERGALLERY_1SUBLVL_NAME','Zobrazovat pouze jednu úroveň podadresářů');  
@define('PLUGIN_EVENT_USERGALLERY_1SUBLVL_DESC','Toto nastavení omezí výpis stromu podadresářů pouze na první úroveň podadresářů. Tedy podadresáře podadresářů už se nebudou zobrazovat. Také vypíše celkový počet obrázků v podadresářích. Toto nastavení není přístupné pokud používáte zobrazení plného stromu adresářů.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGESPERPAGE_NAME', 'Počet obrázků na stránce');
@define('PLUGIN_EVENT_USERGALLERY_IMAGESPERPAGE_DESC', 'Pokud zde zadáte "0", stránkování bude vypnuto a všechny obrázky se budou zobrazovat na první stránce.');
@define('PLUGIN_EVENT_USERGALLERY_PREVIOUS', 'předchozí');
@define('PLUGIN_EVENT_USERGALLERY_NEXT', 'další');
@define('PLUGIN_EVENT_USERGALLERY_UPONELEVEL', 'O úroveň výše');
@define('PLUGIN_EVENT_USERGALLERY_BACK', 'Zpět');
@define('PLUGIN_EVENT_USERGALLERY_FRONTPAGE_NAME', 'Nastavit tuto stránku jako úvodní stránku blogu Serendipity');
@define('PLUGIN_EVENT_USERGALLERY_FRONTPAGE_DESC', 'Místo výchozí stránky Serendipity můžete zobrazovat galerii. Pokud chcete změnit úvodní stránku zpět na výchozí stránku Serendipity, použijte "index.php?frontpage". Pokud chcete používat tuto funkci, ujistěte se, že před pluginem "Galerie" (v nastavení nainstalovaných pluginů) nejsou použity žádné další pluginy, které definují stálé odkazy (permalink), jako např. hlasování, návštěvní kniha.');

//Exif data tags
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_SHOW_NAME', 'Zobrazovat exif tagy?');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_SHOW_DESC', 'EXIF tagy jsou přídavné informace o obrázku obsažené přímo v souboru s obrázkem. Tyto jsou automaticky vytvářené fotoaparáty, obsahují informace jako je model fotoaparátu, nastavení expozice, použití blesku, čas závěrky apod. Starší fotoaparáty (před rokem 2000) nemusí tyto informace zapisovat.');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_CAMERA', 'Podporované fotoaparáty: Agfa, Canon, Casio, Epson, Fujifilm, Konica Minolta, Kyocera, Nikon, Olympus, Panasonic, Pentax, Ricoh, Sony.');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_NAME', 'EXIF data');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_DESC', 'V seznamu níže jsou všechny přístupné volby. Váš konkrétní fotoaparát může přeskočit jednu nebo dvě hodnoty, protože ne všechny hodnoty jsou zapisovány všemi fotoaparáty.');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_ADDITIONALDATA', 'Další informace');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_NOADDITIONALDATA', 'Žádné další informace');

@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED', 'Rozměry obrázku v RSS kanálu');
@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_DESC', 'Tento plugin nabízí RSS kanál s posledními obrázky na blogu. Můžete ho zobrazit jako jakýkoliv jiný RSS kanál na bogu, tedy zadáním následující URL adresy: %s. Proměnná "gallery=true" v URL adrese je důležitá, protože znamená, že se mají zobrazovat obrázky galerie. Můžete použít také další proměnnou "limit=XX" k omezení obrázků v RSS kanálu. Proměnná "picdir=XXX" určuje adresář, jehož obrázky se mají zobrazovat v RSS kanálu. Proměnná "hide_title=true" skryje názvy souborů a "feed_width=XXX" nastaví velikost cílových obrázků (podporované od verze Serendipity 1.1). Zadejte maximální velikost obrázků v RSS kanálu.');

@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_LINKONLY', 'Zobrazit v RSS pouze propojení obrázky?');
@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_LINKONLY_DESC', '"Ano" znamená, že se v RSS kanálu objeví pouze obrázky, které jsou obsažené v některém z publikovaných příspěvků.');

@define('USERGALLERY_SEE_FULLSIZED', 'Klikněte pro obrázek v plné velikosti');
@define('USERGALLERY_DOWNLOAD_HERE', 'Download - klikněte zde!');
@define('USERGALLERY_LINKED_ENTRIES', 'Příspěvky obsahující tento obrázek:');
@define('USERGALLERY_LINKED_STATICPAGES', 'Statické stránky zborazující tento obrázek:');
@define('PLUGIN_EVENT_USERGALLERY_SHOW_LINKED_ENTRY', 'Zobrazit odkaz na příspěvky obsahující obrázek?');
@define('PLUGIN_EVENT_USERGALLERY_DIRTAB_NAME','Odsazení podadresářů ve stromu adresářů');
@define('PLUGIN_EVENT_USERGALLERY_DIRTAB_DESC','Odsazení podadresáře od rodičovského adresáře v pixelech.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGE_WIDTH_NAME','Max. šířka obrázku');
@define('PLUGIN_EVENT_USERGALLERY_IMAGE_WIDTH_DESC','Maximální šířka obrázku. Na tuto šířu budou zmenšeny větší obrázky v případě zobrazení "Přizpůsobené měřítko". Nastavení na "0" znamená bez omezení - všechny obrázky jsou zobrazení v původní velikosti.');

//Media properties
@define('PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_SHOW_NAME', 'Zobrazit vlastnosti obrázků');
@define('PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_SHOW_DESC', 'Zobrazit vlastnosti obrázků přiřazené v knihovně médií?');
@define('PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_NAME', 'Seznam vlastností obrázku');
@define('PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_DESC', 'Toto je definice seznamu vlastností obrázku a přiřazený popis jednotlivých položek. Formát je "POLOŽKA1:Název položky 1;POLOŽKA2: Název položky 2", kde jednotlivé položky jsou oddělené středníkem, první je název vlastnosti (jak jsou vypsány v "Nastavení blogu", pak čárka, pak zobrazené jméno.');

//Several consants used in the template
@define('PLUGIN_EVENT_USERGALLERY_IMAGES', 'obrázky');
@define('PLUGIN_EVENT_USERGALLERY_PAGINATION', 'Stránka %s z %s, celkem %s obrázků');

@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_BODY', 'Použít originální formát příspěvku pro obrázek v RSS kanálu?');
@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_BODY_DESC', 'Pokud je povoleno, obrázek z knihovny médií, který byl použit v příspěvku na blogu, bude mít v RSS kanálu stejné tělo příspěvku jako příspěvek místo výchozího jednoduchého odkazu na příspěvek a původní umístění obrázku.');
?>
