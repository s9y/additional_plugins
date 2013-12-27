/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/08/08
 */

@define('PLUGIN_EVENT_USERGALLERY_TITLE', 'Galerie');
@define('PLUGIN_EVENT_USERGALLERY_DESC', 'Umo¾òuje nepøihlá¹eným u¾ivatelùm prohlí¾et Serendipity knihovnu médií');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_TWO', '2');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_THREE', '3');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_FOUR', '4');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_FIVE', '5');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_DESC', 'Poèet sloupcù v zobrazení galerie');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_NAME', 'Poèet sloupcù');
@define('PLUGIN_EVENT_USERGALLERY_PERMALINK_NAME', 'Stálý odkaz (permalink) na stránku galerie');
@define('PLUGIN_EVENT_USERGALLERY_PERMALINK_DESC', 'Zadejte jedineèný odkaz, pod kterým bude pøístupná galerie');
@define('PLUGIN_EVENT_USERGALLERY_SUBNAME_NAME', 'Jméno podstránky pro zobrazení galerie');
@define('PLUGIN_EVENT_USERGALLERY_SUBNAME_DESC', 'Zadejte jedineèné jméno podstránky, které bude svázáno s galerií (galerie bude pøístupná pod adresou index.php?serendipity[subpage]=zde_zadané_jméno)');
@define('PLUGIN_EVENT_USERGALLERY_DIRECTORY_NAME', 'Vyberte výchozí adresáø');
@define('PLUGIN_EVENT_USERGALLERY_DIRECTORY_DESC', 'Vyberte adresáø knihovny médií, na který má být omezeno zobrazení galerie');
@define('PLUGIN_EVENT_USERGALLERY_STYLE_NAME', 'Vyberte vzhled galerie');
@define('PLUGIN_EVENT_USERGALLERY_STYLE_DESC', '"Knihovna médií! umo¾òuje procházení po adresáøích a vyhledávání, zatímco "Stránka s náhledy" zobrazí náhledy v¹ech obrázkù v adresáøi a obrázky otevírá v novém oknì.');
@define('PLUGIN_EVENT_USERGALLERY_STYLE_SERENDIPITY', 'Knihovna médií');
@define('PLUGIN_EVENT_USERGALLERY_STYLE_THUMBPAGE', 'Stránka s náhledy');
@define('PLUGIN_EVENT_USERGALLERY_PRETTY_NAME', 'Nadpis galerie');
@define('PLUGIN_EVENT_USERGALLERY_PRETTY_DESC', 'Zadejte nadpis stránka s galerií');
@define('PLUGIN_EVENT_USERGALLERY_INTRO', 'Úvodní text (nepovinné)');
@define('PLUGIN_EVENT_USERGALLERY_FIXED_WIDTH', 'Pevná velikost obrázkù v zobrazení galerie');
@define('PLUGIN_EVENT_USERGALLERY_FIXED_DESC', 'Nastaví vý¹ku a ¹íøku obrázku na pevnou hodnotu pøi prohlí¾ení galerie. Zadejte nulu pro pou¾ití standardních náhledù.');
@define('PLUGIN_EVENT_USERGALLERY_FILESIZE', 'Velikost souboru');
@define('PLUGIN_EVENT_USERGALLERY_FILENAME', 'Jméno souboru');
@define('PLUGIN_EVENT_USERGALLERY_DIMENSION', 'Rozmìry');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_NAME', 'Zobrazit jediný obrázek');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_DESC', 'Mùete zobrazovat obrázky v mìøítku pøizpùsobené stránce (s adaptivním pop-up oknem pro velké obrázky), nebo v adaptivním pop-up oknì pøímo po kliknutí na náhled na stránce galerie.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_INPAGE', 'Pøizpùsobené mìøítko');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_POPUP', 'Adaptivní pop-up okno');
@define('PLUGIN_EVENT_USERGALLERY_DIRLIST_NAME', 'Zobrazit výpis adresáøe');
@define('PLUGIN_EVENT_USERGALLERY_DIRLIST_DESC', 'Pokud je nastavené na "Ano", galerie bude zobrazovat výpis v¹ech podadresáøù ve výchozím adresáøi.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGESTRICT_NAME', 'Pouze obrázky v aktuálním adresáøi');
@define('PLUGIN_EVENT_USERGALLERY_IMAGESTRICT_DESC', 'Pokud nastaveno na "Ano", galerie bude zobrazovat pouze obrázky v aktuálním adresáøi. Pokud nastaveno na "Ne", galerie bude zobrazovat v¹echny obrázky ze v¹ech podadresáøù.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_NAME', 'Øazení');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_DESC', 'Vyberte poøadí, v jakém se mají vypisovat obrázky');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_NAMEACS', 'Jméno (vzestupnì)');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_NAMEDESC', 'Jméno (sestupnì)');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_DATEACS', 'Datum (vzestupnì)');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_DATEDESC', 'Datum (sestupnì)');
@define('PLUGIN_EVENT_USERGALLERY_DISPLAYDIR_NAME', 'Zobrazit celý strom adresáøù');
@define('PLUGIN_EVENT_USERGALLERY_DISPLAYDIR_DESC', '"Ano" znamená, ¾e se bude na ka¾dé stránce galerie zobrazovat celý strom adresáøù. "Ne" znamená, ¾e se bude vypisovat pouze strom podadresáøù aktuálního adresáøe. (Toto chování je také závislé na ¹ablonì vzhledu pou¾ité pro zobrazení galerie.)');
@define('PLUGIN_EVENT_USERGALLERY_1SUBLVL_NAME','Zobrazovat pouze jednu úroveò podadresáøù');  
@define('PLUGIN_EVENT_USERGALLERY_1SUBLVL_DESC','Toto nastavení omezí výpis stromu podadresáøù pouze na první úroveò podadresáøù. Tedy podadresáøe podadresáøù u¾ se nebudou zobrazovat. Také vypí¹e celkový poèet obrázkù v podadresáøích. Toto nastavení není pøístupné pokud pou¾íváte zobrazení plného stromu adresáøù.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGESPERPAGE_NAME', 'Poèet obrázkù na stránce');
@define('PLUGIN_EVENT_USERGALLERY_IMAGESPERPAGE_DESC', 'Pokud zde zadáte "0", stránkování bude vypnuto a v¹echny obrázky se budou zobrazovat na první stránce.');
@define('PLUGIN_EVENT_USERGALLERY_PREVIOUS', 'pøedchozí');
@define('PLUGIN_EVENT_USERGALLERY_NEXT', 'dal¹í');
@define('PLUGIN_EVENT_USERGALLERY_UPONELEVEL', 'O úroveò vý¹e');
@define('PLUGIN_EVENT_USERGALLERY_BACK', 'Zpìt');
@define('PLUGIN_EVENT_USERGALLERY_FRONTPAGE_NAME', 'Nastavit tuto stránku jako úvodní stránku blogu Serendipity');
@define('PLUGIN_EVENT_USERGALLERY_FRONTPAGE_DESC', 'Místo výchozí stránky Serendipity mù¾ete zobrazovat galerii. Pokud chcete zmìnit úvodní stránku zpìt na výchozí stránku Serendipity, pou¾ijte "index.php?frontpage". Pokud chcete pou¾ívat tuto funkci, ujistìte se, ¾e pøed pluginem "Galerie" (v nastavení nainstalovaných pluginù) nejsou pou¾ity ¾ádné dal¹í pluginy, které definují stálé odkazy (permalink), jako napø. hlasování, náv¹tìvní kniha.');

//Exif data tags
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_SHOW_NAME', 'Zobrazovat exif tagy?');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_SHOW_DESC', 'EXIF tagy jsou pøídavné informace o obrázku obsa¾ené pøímo v souboru s obrázkem. Tyto jsou automaticky vytváøené fotoaparáty, obsahují informace jako je model fotoaparátu, nastavení expozice, pou¾ití blesku, èas závìrky apod. Star¹í fotoaparáty (pøed rokem 2000) nemusí tyto informace zapisovat.');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_CAMERA', 'Podporované fotoaparáty: Agfa, Canon, Casio, Epson, Fujifilm, Konica Minolta, Kyocera, Nikon, Olympus, Panasonic, Pentax, Ricoh, Sony.');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_NAME', 'EXIF data');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_DESC', 'V seznamu ní¾e jsou v¹echny pøístupné volby. Vá¹ konkrétní fotoaparát mù¾e pøeskoèit jednu nebo dvì hodnoty, proto¾e ne v¹echny hodnoty jsou zapisovány v¹emi fotoaparáty.');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_ADDITIONALDATA', 'Dal¹í informace');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_NOADDITIONALDATA', '®ádné dal¹í informace');

@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED', 'Rozmìry obrázku v RSS kanálu');
@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_DESC', 'Tento plugin nabízí RSS kanál s posledními obrázky na blogu. Mù¾ete ho zobrazit jako jakýkoliv jiný RSS kanál na bogu, tedy zadáním následující URL adresy: %s. Promìnná "gallery=true" v URL adrese je dùle¾itá, proto¾e znamená, ¾e se mají zobrazovat obrázky galerie. Mù¾ete pou¾ít také dal¹í promìnnou "limit=XX" k omezení obrázkù v RSS kanálu. Promìnná "picdir=XXX" urèuje adresáø, jeho¾ obrázky se mají zobrazovat v RSS kanálu. Promìnná "hide_title=true" skryje názvy souborù a "feed_width=XXX" nastaví velikost cílových obrázkù (podporované od verze Serendipity 1.1). Zadejte maximální velikost obrázkù v RSS kanálu.');

@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_LINKONLY', 'Zobrazit v RSS pouze propojení obrázky?');
@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_LINKONLY_DESC', '"Ano" znamená, ¾e se v RSS kanálu objeví pouze obrázky, které jsou obsa¾ené v nìkterém z publikovaných pøíspìvkù.');

@define('USERGALLERY_SEE_FULLSIZED', 'Kliknìte pro obrázek v plné velikosti');
@define('USERGALLERY_DOWNLOAD_HERE', 'Download - kliknìte zde!');
@define('USERGALLERY_LINKED_ENTRIES', 'Pøíspìvky obsahující tento obrázek:');
@define('USERGALLERY_LINKED_STATICPAGES', 'Statické stránky zborazující tento obrázek:');
@define('PLUGIN_EVENT_USERGALLERY_SHOW_LINKED_ENTRY', 'Zobrazit odkaz na pøíspìvky obsahující obrázek?');
@define('PLUGIN_EVENT_USERGALLERY_DIRTAB_NAME','Odsazení podadresáøù ve stromu adresáøù');
@define('PLUGIN_EVENT_USERGALLERY_DIRTAB_DESC','Odsazení podadresáøe od rodièovského adresáøe v pixelech.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGE_WIDTH_NAME','Max. ¹íøka obrázku');
@define('PLUGIN_EVENT_USERGALLERY_IMAGE_WIDTH_DESC','Maximální ¹íøka obrázku. Na tuto ¹íøu budou zmen¹eny vìt¹í obrázky v pøípadì zobrazení "Pøizpùsobené mìøítko". Nastavení na "0" znamená bez omezení - v¹echny obrázky jsou zobrazení v pùvodní velikosti.');

//Media properties
@define('PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_SHOW_NAME', 'Zobrazit vlastnosti obrázkù');
@define('PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_SHOW_DESC', 'Zobrazit vlastnosti obrázkù pøiøazené v knihovnì médií?');
@define('PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_NAME', 'Seznam vlastností obrázku');
@define('PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_DESC', 'Toto je definice seznamu vlastností obrázku a pøiøazený popis jednotlivých polo¾ek. Formát je "POLO®KA1:Název polo¾ky 1;POLO®KA2: Název polo¾ky 2", kde jednotlivé polo¾ky jsou oddìlené støedníkem, první je název vlastnosti (jak jsou vypsány v "Nastavení blogu", pak èárka, pak zobrazené jméno.');

//Several consants used in the template
@define('PLUGIN_EVENT_USERGALLERY_IMAGES', 'obrázky');
@define('PLUGIN_EVENT_USERGALLERY_PAGINATION', 'Stránka %s z %s, celkem %s obrázkù');

@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_BODY', 'Pou¾ít originální formát pøíspìvku pro obrázek v RSS kanálu?');
@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_BODY_DESC', 'Pokud je povoleno, obrázek z knihovny médií, který byl pou¾it v pøíspìvku na blogu, bude mít v RSS kanálu stejné tìlo pøíspìvku jako pøíspìvek místo výchozího jednoduchého odkazu na pøíspìvek a pùvodní umístìní obrázku.');
?>
