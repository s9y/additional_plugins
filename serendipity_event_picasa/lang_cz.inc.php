<?php # lang_cz.inc.php 1.1 2009-11-21 11:38:18 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/21
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/11/21
 */

@define('PLUGIN_EVENT_PICASA_NAME',                 'Picasa');
@define('PLUGIN_EVENT_PICASA_DESC',                 'Zobrazuje fotoalba z Picasy exportovaná do XML formátu');
@define('PLUGIN_EVENT_PICASA_PROP_PATH',            'Cesta');
@define('PLUGIN_EVENT_PICASA_PROP_PATH_DESC',       'Cesta k adresáøi, kde jsou ulo¾ena fotoalba Picasa na webserveru.');
@define('PLUGIN_EVENT_PICASA_PROP_JSWINDOW',        'Otevøít okno pomocí JavaScriptu');
@define('PLUGIN_EVENT_PICASA_PROP_JSWINDOW_DESC',   'Ka¾dý z obrázkù se mù¾e zobrazovat ve vìt¹í velikosti v novém oknì. Pomocí JavaScriptu mù¾e být velikost tohoto okna automaticky pøizpùsobena velikosti obrázku.');
@define('PLUGIN_EVENT_PICASA_PROP_SHOWTITLE',       'Zobrazovat nadpis fotoalb');
@define('PLUGIN_EVENT_PICASA_PROP_SHOWTITLE_DESC',  'Má se v pøíspìvku zobrazovat název fotoalba? Bude pou¾ito pouze pokud se vzhled negeneruje pomocí Smarty-¹ablony.');
@define('PLUGIN_EVENT_PICASA_PROP_SMARTY',          'Smarty-¹ablona');
@define('PLUGIN_EVENT_PICASA_PROP_SMARTY_DESC',     'Která ¹ablona Smarty se má pou¾ít k vykreslení výsledku?');
@define('PLUGIN_EVENT_PICASA_PROP_SMARTY_NONE',     'Nepou¾ívat Smarty');
@define('PLUGIN_EVENT_PICASA_ERR_INDEXNOTFOUND',    '<i>Plugin Picasa: Výchozí soubor fotoalba nebyl nalezen</i>');

// Next lines were translated on 2009/11/21
@define('PLUGIN_EVENT_PICASA_PROP_UPLOAD_SIZE',     'Velikost nahraných obrázkù');
@define('PLUGIN_EVENT_PICASA_PROP_UPLOAD_SIZE_DESC','Pokud jsou obrázky nahrávány pøímo z picasy, jejich velikot bude');
@define('PLUGIN_EVENT_PICASA_PROP_CREATE_ENTRY_AFTER_UPLOAD','Vytvoøit nový pøíspìvek pro nahrané album');
@define('PLUGIN_EVENT_PICASA_PROP_CREATE_ENTRY_AFTER_UPLOAD_DESC','Poté, co je album nahráno, má být vytvoøen nový pøíspìvek (jako koncept), který bude obsahovat obrázky nového alba?');
@define('PLUGIN_EVENT_PICASA_ERR_MISSING_RSS',      'Omlouváme se, ¾ádné obrázky nebyly pøijaty. Tento URL odkaz pracuje správnì pouze pøi nahrávání obrázkù pomocí tlaèítka Picasa.');
@define('PLUGIN_EVENT_PICASA_ERR_UPLOAD_DIR_ALREADY_EXISTS','Adresáø pro stahování obrázkù ji¾ existuje');
@define('PLUGIN_EVENT_PICASA_ERR_DIR_CREATION_FAILED','Nepodaøilo se vytvoøit adresáø pro nahrání obrázkù');
@define('PLUGIN_EVENT_PICASA_UPLOAD_HEADER',        'Nahrání obrázkù z Google Picasa do Serendipity blogu na');
@define('PLUGIN_EVENT_PICASA_UPLOAD_USERNAME',      'U¾ivatelské jméno');
@define('PLUGIN_EVENT_PICASA_UPLOAD_PASSWORD',      'Heslo');
@define('PLUGIN_EVENT_PICASA_UPLOAD_REMEMBER_LOGIN','Pamatovat pøihla¹ovací údaje?');
@define('PLUGIN_EVENT_PICASA_UPLOAD_LOGIN',         'Pøihlásit');
@define('PLUGIN_EVENT_PICASA_UPLOAD_DISCARD',       'Zru¹it');
@define('PLUGIN_EVENT_PICASA_UPLOAD_ALBUMNAME',     'Jméno alba');
@define('PLUGIN_EVENT_PICASA_UPLOAD_DESCRIPTION',   'Popis');
@define('PLUGIN_EVENT_PICASA_UPLOAD_PARENTDIR',     'Rodièovský adresáø');
@define('PLUGIN_EVENT_PICASA_UPLOAD_PARENTDIR_BASEDIR','Základní adresáø');
@define('PLUGIN_EVENT_PICASA_UPLOAD_UPLOAD',        'Nahrát');
@define('PLUGIN_EVENT_PICASA_UPLOAD_SUCCESS',       'Úspì¹nì nahráno!');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_HEADER',       'Pokyny pro pøidání tlaèítka "Nahrát" na Google Picasa');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP1',        'Stáhnìte následující soubor: ');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP2',        'Pøejmenujte soubor na pøíponu .zip.');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP3',        'Vybalte soubor .pbf ze .zip archivu.');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP4',        'Otevøete jej v textovém editoru. Jedná se o xml soubor. Nahraïte v¹echny výskyty "mysite.com" jménem stránky s Va¹ím blogem. Dále nahraïte  "mysite.com/serendipity/index.php" platnou cestou k souboru index.php na Va¹em serendipity blogu.');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP5',        'Vra»te .pbf soubor zpìt do .zip archivu.');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP6',        'Pøejmenujte .zip archiv na .pbz.');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP7',        'Vlo¾te soubor .pbz do adresáøe s tlaèítky va¹í picasy, co¾ je typicky  "C:\Program Files\Google\Picasa\buttons".');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP8',        'Spus»te picasu, tlaèítko by se v ní mìlo objevit. Pokud ne, mìli byste ho najít v Tools >> Configure Buttons (Nástroje >> Nastavení tlaèítek)...');