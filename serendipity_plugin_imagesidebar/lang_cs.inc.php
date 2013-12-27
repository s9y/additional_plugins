/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/03/16
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/21
 */

@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_NAME',		'Jednotné zobrazování obrázkù v postranním sloupci');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DESC',		'Umožòuje zobrazovat obrázky v postranním sloupci. Zdrojù tìchto obrázkù mùže být vícero. Plugin se dokáže pøipojit do Menalto Gallery, do databáze Coppermine galerie (pouze pokud bìží na MySQL), k webové službì Zooomr (http://beta.zooomr.com/home) a samozøejmì i ke Knihovnì médií Serendipity.');

@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_NAME',		'Zdroj obrázku');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_DESC',		'Vyberte ze seznamu zdroj obrázkù');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_NONE',		'Ještì nebylo nic vybráno');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_MENALTO',		'Menalto Gallery');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_COPPERMINE',		'Databáze Coppermine');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_MEDIALIB',		'Knihovna médií Serendipity');

@define('PLUGIN_GALLERYRANDOMBLOCK_NAME',		'Náhodné foto (Gallery Random Photo Block)');
@define('PLUGIN_GALLERYRANDOMBLOCK_DESC',		'Pøidává odkaz na skript Gallery Random Block (funkce Menalto Gallery, více viz. http://gallery.menalto.com)');
@define('PLUGIN_GALLERYRANDOMBLOCK_URL_NAME',		'Adresáø galerie');
@define('PLUGIN_GALLERYRANDOMBLOCK_URL_DESC',		'Zadejte virtuální cestu ke galerii');
@define('PLUGIN_GALLERYRANDOMBLOCK_NUMREPEAT_NAME',		'Poèet náhodných fotek');
@define('PLUGIN_GALLERYRANDOMBLOCK_NUMREPEAT_DESC',		'Poèet fotek, které se mají zobrazovat v postranním bloku.');
@define('PLUGIN_GALLERYRANDOMBLOCK_FILE_NAME',		'Jméno souboru vnoøeného skriptu (pouze pro verze Gallery 1.x!)');
@define('PLUGIN_GALLERYRANDOMBLOCK_VERSION',		'Kterou verzi Gallery používáte?');
@define('PLUGIN_GALLERYRANDOMBLOCK_ERROR_CONNECT',		'CHYBA: URL adresa nemohla být použita. Žádná galerie pod ní není pøístupná.');
@define('PLUGIN_GALLERYRANDOMBLOCK_ERROR_HTTP',		'CHYBA: HTTP server vrátil chybu nebo varování (výsledek: %d).');
@define('PLUGIN_GALLERYRANDOMBLOCK_ITEMID',		'ID alba');
@define('PLUGIN_GALLERYRANDOMBLOCK_ITEMID_DESC',		'Pøi prázdném poli budou zobrazena všechna alba. Pouze pro verze Gallery 2.x.');
@define('PLUGIN_GALLERYRANDOMBLOCK_G2DISPLAYTYPE',		'Zobrazený obrázek');
@define('PLUGIN_GALLERYRANDOMBLOCK_G2DISPLAYTYPE_RAND',		'Náhodný');
@define('PLUGIN_GALLERYRANDOMBLOCK_G2DISPLAYTYPE_RENCENT',		'Poslední');
@define('PLUGIN_GALLERYRANDOMBLOCK_G2DISPLAYTYPE_VIEWED',		'Nejèastìji prohlížený');
@define('PLUGIN_GALLERYRANDOMBLOCK_G2DISPLAYTYPE_SPECIFIC',		'Zadaný');
@define('PLUGIN_GALLERYRANDOMBLOCK_SINGLE_ITEMID',		'ID identifikátor konkrétního obrázku');
@define('PLUGIN_GALLERYRANDOMBLOCK_SINGLE_ITEMID_DESC',		' ');
@define('PLUGIN_GALLERYRANDOMBLOCK_MAXSIZE',		'Maximální šíøka obrázku');
@define('PLUGIN_GALLERYRANDOMBLOCK_MAXSIZE_DESC',		'Nastaví šíøku obrázku na zadanou hodnotu. Naneštìstí toto nastavení vyžaduje, aby byly vìtší obrázky staženy a teprvé poté zmìnšeny. Ponechte prázdné a použije se standardní náhled Gallery.');
@define('PLUGIN_GALLERYRANDOMBLOCK_LINKTARGET',		'Cíl odkazu');
@define('PLUGIN_GALLERYRANDOMBLOCK_LINKTARGET_DESC',		'Hodnota cíle odkazu - v <a href="" target="">. Rozumné nastavení je "_blank".');
@define('PLUGIN_GALLERYRANDOMBLOCK_SHOWDETAIL',		'Zobrazené podrobnosti');
@define('PLUGIN_GALLERYRANDOMBLOCK_SHOWDETAIL_DESC',		'Seznam klíèových slov oznaèujících podrobnosti o obrázku oddìlený èárkou. Použitelná klíèová slova jsou: "title" (titulek), "date" (datum), "views" (poèet zobrazení), "owner" (vlastník, autor), "heading" (nadpis). Ke skrytí informací napište "none".');


@define('PLUGIN_CPGS_NAME',		'Coppermine náhledy');
@define('PLUGIN_CPGS_DESC',		'Zobrazit náhledy galerie Coppermine v postranním sloupci');
@define('PLUGIN_CPGS_SERVER_NAME',		'Server');
@define('PLUGIN_CPGS_SERVER_DESC',		'SQL server použitý v Coppermine');
@define('PLUGIN_CPGS_DB_NAME',		'Databáze');
@define('PLUGIN_CPGS_DB_DESC',		'SQL databáze');
@define('PLUGIN_CPGS_PREFIX_NAME',		'Pøedpona (prefix)');
@define('PLUGIN_CPGS_PREFIX_DESC',		'Pøedpona - prefix tabulek Coppermine galerie');
@define('PLUGIN_CPGS_USER_NAME',		'Pøihlašovací jméno');
@define('PLUGIN_CPGS_USER_DESC',		'Pøihlašovací jméno do databáze');
@define('PLUGIN_CPGS_PASSWORD_NAME',		'Heslo');
@define('PLUGIN_CPGS_PASSWORD_DESC',		'Heslo do databáze');
@define('PLUGIN_CPGS_URL_NAME',		'URL');
@define('PLUGIN_CPGS_URL_DESC',		'URL adresa galerie');
@define('PLUGIN_CPGS_TYPE_NAME',		'Typ');
@define('PLUGIN_CPGS_TYPE_DESC',		'Které obrázky zobrazit?');
@define('PLUGIN_CPGS_TITLE_NAME',		'Nadpis');
@define('PLUGIN_CPGS_TITLE_DESC',		'Nadpis postranního bloku');
@define('PLUGIN_CPGS_ALBUM_NAME',		'Odkaz na album');
@define('PLUGIN_CPGS_ALBUM_DESC',		'Pøiložit odkaz na album pod náhled obrázku');
@define('PLUGIN_CPGS_GALLLINK_NAME',		'URL odkaz na galerii');
@define('PLUGIN_CPGS_GALLLINK_DESC',		'URL adresa - odkaz pod náhledy (prázdné = žádný odkaz)');
@define('PLUGIN_CPGS_GALLNAME_NAME',		'Název galerie');
@define('PLUGIN_CPGS_GALLNAME_DESC',		'Text pro odkaz na galerii');
@define('PLUGIN_CPGS_COUNT_NAME',		'Náhledy');
@define('PLUGIN_CPGS_COUNT_DESC',		'Poèet zobrazených náhledù');
@define('PLUGIN_CPGS_SIZE_NAME',		'Velikost');
@define('PLUGIN_CPGS_SIZE_DESC',		'Maximální velikost náhledù');
@define('PLUGIN_CPGS_THUMB_NAME',		'Zpracovat i ne-obrázky?');
@define('PLUGIN_CPGS_THUMB_DESC',		'Pokusí se nalézt náhledy generované galerií Coppermine i pro ne-obrázky (videa apod.)');
@define('PLUGIN_CPGS_FILTER_NAME',		'Filtr alb');
@define('PLUGIN_CPGS_FILTER_DESC',		'Tøídit alba podle:');
@define('PLUGIN_CPGS_RECENT',		'Nejnovìjší');
@define('PLUGIN_CPGS_POPULAR',		'Nejèastìji zobrazované');
@define('PLUGIN_CPGS_RANDOM',		'Náhodné');

@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NAME',		'Zobrazení Knihovny médií v postranním sloupci');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DESC',		'Zobrazit náhodný obrázek z Knihovny médií Serendipity v postranním sloupci. (Pozor, nerozlišuje mezi typy souborù, neodlišuje obrázky a jiné soubory!)');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DIRECTORY_NAME',		'Výchozí adresáø');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DIRECTORY_DESC',		'Vyberte výchozí adresáø, plugin bude vyhledávat obrázky pouze v nìm.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_IMAGESTRICT_NAME',		'Nerekurzivní zobrazování obrázkù');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_IMAGESTRICT_DESC',		'Pokud je "Ano", budou se zobrazovat pouze obrázky z aktuálního adresáøe. Pokud je "Ne", pak se budou zobrazovat obrázky i ze všech podadresáøù.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_NAME',		'Chování odkazu');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_DESC',		'"Ve stránce" otevøe obrázek ve stávajícím oknì. "Vyskakovací okno" - obrázek bude otevøen v novém, velikostnì pøizpùsobeném oknì. "URL" umožòuje zadat statickou url adresu jako cíl odkazu. "Galerie" povede na stálou adresu (permalink) pluginu usergallery (pokud je nainstalován).');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_INPAGE',		'Ve stránce');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_POPUP',		'Vyskakovací okno');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_URL',		'URL adresa');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_GALLERY',		'Galerie');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_ENTRY',		'Odkaz na pøíbuzný pøíspìvek');

@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_WIDTH_NAME',		'Šíøka obrázku');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_WIDTH_DESC',		'Zadat pevnou šíøku obrázku. Pokud je zadána nula, plugin obrázku zadá "width: 100%"');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_URL_NAME',		'URL');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_URL_DESC',		'Stálá URL adresa, na kterou má vést odkaz. (napø. "http://www.s9y.org")');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_GALPERM_NAME',		'Zadejte stálý odkaz (permalink) nebo podstránku');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_GALPERM_DESC',		'Tato hodnota se musí shodovat s hodnotou zadanou v pluginu "galerie". Pamatujte, že pokud je vypnuté pøepisování URL adresy (url rewrite), musíte použít podstránku.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_INTRO',		'Libovolný text (html znaèky povoleny), který má být pøed obrázkem');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_SUMMERY',		'Libovolný text (html znaèky povoleny), který bude pøipojený za obrázek');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_ROTATETIME_NAME',		'Perioda výmìny obrázkù');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_ROTATETIME_DESC',		'Jak èasto mají být vymìòovány obrázky. V minutách. Hodnota "0" znamená obmìnu pøi každém naètení stránky.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NUMIMAGES_NAME',		'Poèet zobrazených obrázkù');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NUMIMAGES_DESC',		'Kolik obrázkù se má zobrazovat?');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKS_NAME',		'Omezit pouze na hotlink obrázky');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKS_DESC',		'Tato volba omezuje zobrazování obrázkù v postranním sloupci pouze na ty, které jsou v Knihovnì médií oznaèeny jako hotlink (nejsou uložené na vašem blogu, ale jedná se pouze na odkazy na cizí servery).');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKBASE_NAME',		'Klíèové slovo');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKBASE_DESC',		'Vstupem pro tuto funkci je jediné klíèové slovo (bez mezer). Funkce omezuje zobrazování pouze na obrázky obsahující zadané slovo. Napø. pokud máte hotlinky z více zdrojù, ale chcete zobrazovat pouze ty pocházející z jednoho zdroje, mùžete sem napsat napøíklad "zdroj.cz".');

@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_ZOOOMR',		'Plugin Zooomr');
@define('PLUGIN_ZOOOMR_DESC',		'Zobrazuje nejnovìjší obrázky ze Zooomr feedu');
@define('PLUGIN_ZOOOMR_FEEDURL',		'URL Adresa kanálu (feedu)');
@define('PLUGIN_ZOOOMR_FEEDDESC',		'URL adresa na Zooomr feed');
@define('PLUGIN_ZOOOMR_IMGCOUNT',		'Obrázky');
@define('PLUGIN_ZOOOMR_IMGCOUNTDESC',		'Poèet zobrazených obrázkù');
@define('PLUGIN_ZOOOMR_DLINK',		'Pøímý odkaz na obrázky');
@define('PLUGIN_ZOOOMR_DLINKDESC',		'Odkaz vedoucí pøímo na velkou verzi obrázkù');
@define('PLUGIN_ZOOOMR_LOGO',		'Zobrazit logo Zooomr');
@define('PLUGIN_ZOOOMR_IMGWIDTH',		'Šíøka náhledù');

@define('PLUGIN_CPGS_GROUP_NAME',		'Uživatelská skupina (usergroup)');
@define('PLUGIN_CPGS_GROUP_DESC',		'Coppermine umožòuje omezit zobrazení obrázkù pouze na zadanou skupinu uživatelù. Pokud potøebujete zobrazovat pouze nìkteré obrázky, zadejte uživatelskou skupinu, za kterou se bude tento plugin maskovat. "Everybody" znamená, že nastavení uživatelské skupiny bude ignorováno.');