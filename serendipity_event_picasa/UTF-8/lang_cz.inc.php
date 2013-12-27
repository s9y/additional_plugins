/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/21
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/11/21
 */

@define('PLUGIN_EVENT_PICASA_NAME',                 'Picasa');
@define('PLUGIN_EVENT_PICASA_DESC',                 'Zobrazuje fotoalba z Picasy exportovaná do XML formátu');
@define('PLUGIN_EVENT_PICASA_PROP_PATH',            'Cesta');
@define('PLUGIN_EVENT_PICASA_PROP_PATH_DESC',       'Cesta k adresáři, kde jsou uložena fotoalba Picasa na webserveru.');
@define('PLUGIN_EVENT_PICASA_PROP_JSWINDOW',        'Otevřít okno pomocí JavaScriptu');
@define('PLUGIN_EVENT_PICASA_PROP_JSWINDOW_DESC',   'Každý z obrázků se může zobrazovat ve větší velikosti v novém okně. Pomocí JavaScriptu může být velikost tohoto okna automaticky přizpůsobena velikosti obrázku.');
@define('PLUGIN_EVENT_PICASA_PROP_SHOWTITLE',       'Zobrazovat nadpis fotoalb');
@define('PLUGIN_EVENT_PICASA_PROP_SHOWTITLE_DESC',  'Má se v příspěvku zobrazovat název fotoalba? Bude použito pouze pokud se vzhled negeneruje pomocí Smarty-šablony.');
@define('PLUGIN_EVENT_PICASA_PROP_SMARTY',          'Smarty-šablona');
@define('PLUGIN_EVENT_PICASA_PROP_SMARTY_DESC',     'Která šablona Smarty se má použít k vykreslení výsledku?');
@define('PLUGIN_EVENT_PICASA_PROP_SMARTY_NONE',     'Nepoužívat Smarty');
@define('PLUGIN_EVENT_PICASA_ERR_INDEXNOTFOUND',    '<i>Plugin Picasa: Výchozí soubor fotoalba nebyl nalezen</i>');

// Next lines were translated on 2009/11/21
@define('PLUGIN_EVENT_PICASA_PROP_UPLOAD_SIZE',     'Velikost nahraných obrázků');
@define('PLUGIN_EVENT_PICASA_PROP_UPLOAD_SIZE_DESC','Pokud jsou obrázky nahrávány přímo z picasy, jejich velikot bude');
@define('PLUGIN_EVENT_PICASA_PROP_CREATE_ENTRY_AFTER_UPLOAD','Vytvořit nový příspěvek pro nahrané album');
@define('PLUGIN_EVENT_PICASA_PROP_CREATE_ENTRY_AFTER_UPLOAD_DESC','Poté, co je album nahráno, má být vytvořen nový příspěvek (jako koncept), který bude obsahovat obrázky nového alba?');
@define('PLUGIN_EVENT_PICASA_ERR_MISSING_RSS',      'Omlouváme se, žádné obrázky nebyly přijaty. Tento URL odkaz pracuje správně pouze při nahrávání obrázků pomocí tlačítka Picasa.');
@define('PLUGIN_EVENT_PICASA_ERR_UPLOAD_DIR_ALREADY_EXISTS','Adresář pro stahování obrázků již existuje');
@define('PLUGIN_EVENT_PICASA_ERR_DIR_CREATION_FAILED','Nepodařilo se vytvořit adresář pro nahrání obrázků');
@define('PLUGIN_EVENT_PICASA_UPLOAD_HEADER',        'Nahrání obrázků z Google Picasa do Serendipity blogu na');
@define('PLUGIN_EVENT_PICASA_UPLOAD_USERNAME',      'Uživatelské jméno');
@define('PLUGIN_EVENT_PICASA_UPLOAD_PASSWORD',      'Heslo');
@define('PLUGIN_EVENT_PICASA_UPLOAD_REMEMBER_LOGIN','Pamatovat přihlašovací údaje?');
@define('PLUGIN_EVENT_PICASA_UPLOAD_LOGIN',         'Přihlásit');
@define('PLUGIN_EVENT_PICASA_UPLOAD_DISCARD',       'Zrušit');
@define('PLUGIN_EVENT_PICASA_UPLOAD_ALBUMNAME',     'Jméno alba');
@define('PLUGIN_EVENT_PICASA_UPLOAD_DESCRIPTION',   'Popis');
@define('PLUGIN_EVENT_PICASA_UPLOAD_PARENTDIR',     'Rodičovský adresář');
@define('PLUGIN_EVENT_PICASA_UPLOAD_PARENTDIR_BASEDIR','Základní adresář');
@define('PLUGIN_EVENT_PICASA_UPLOAD_UPLOAD',        'Nahrát');
@define('PLUGIN_EVENT_PICASA_UPLOAD_SUCCESS',       'Úspěšně nahráno!');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_HEADER',       'Pokyny pro přidání tlačítka "Nahrát" na Google Picasa');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP1',        'Stáhněte následující soubor: ');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP2',        'Přejmenujte soubor na příponu .zip.');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP3',        'Vybalte soubor .pbf ze .zip archivu.');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP4',        'Otevřete jej v textovém editoru. Jedná se o xml soubor. Nahraďte všechny výskyty "mysite.com" jménem stránky s Vaším blogem. Dále nahraďte  "mysite.com/serendipity/index.php" platnou cestou k souboru index.php na Vašem serendipity blogu.');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP5',        'Vraťte .pbf soubor zpět do .zip archivu.');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP6',        'Přejmenujte .zip archiv na .pbz.');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP7',        'Vložte soubor .pbz do adresáře s tlačítky vaší picasy, což je typicky  "C:\Program Files\Google\Picasa\buttons".');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP8',        'Spusťte picasu, tlačítko by se v ní mělo objevit. Pokud ne, měli byste ho najít v Tools >> Configure Buttons (Nástroje >> Nastavení tlačítek)...');