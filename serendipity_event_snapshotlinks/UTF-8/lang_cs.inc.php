<?php # lang_cs.inc.php 1.0 2009-05-31 15:54:45 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/31
 */@define('PLUGIN_SNAPSHOTLINKS_NAME',                'Odkazy s náhledy pomocí služby www.snap.com');
@define('PLUGIN_SNAPSHOTLINKS_DESC',                'Tento plugin zobrazuje náhledy odkazů v příspěvcích, když na ně návštěvník najede myší. Náhledy jsou generovány službou SnapShot (www.snap.com). Je třeba zaregistrovat si tam účet, pak obdržíte klíč pro přístup ke službě SnapShot.\nSnap.com je zadarmo, ale měli byste vědět, že *může* shromažďovat informace o odkazech na Vašich stránkách, ačkoliv ve svých obchodních podmínkách slibují, že to dělat nebudou.');
@define('PLUGIN_SNAPSHOTLINKS_DESC_DUMMY',          'Tento plugin zobrazuje náhledy odkazů v příspěvcích, když na ně návštěvník najede myší. Náhledy jsou generovány službou SnapShot (www.snap.com). \nSnap.com je zadarmo, ale měli byste vědět, že *může* shromažďovat informace o odkazech na Vašich stránkách, ačkoliv ve svých obchodních podmínkách slibují, že to dělat nebudou.');

@define('PLUGIN_SNAPSHOTLINKS_URL_NAME',            'Registrovaná doména');
@define('PLUGIN_SNAPSHOTLINKS_URL_DESC',            'Doména, kterou jste zaregistrovali na snap.com');
@define('PLUGIN_SNAPSHOTLINKS_KEY_NAME',            'SnapShot klíč');
@define('PLUGIN_SNAPSHOTLINKS_KEY_DESC',            'Poté, co zaregistrujete doménu a kontaktné email, obdržíte skript pro generování náhledů. Mezi "key=" a "&" uvidíte Váš unikátní uživatelský klíč, který zkopírujte a vložte sem (bez toho ukončujícího "&").');

@define('PLUGIN_SNAPSHOTLINKS_THEME_NAME',          'Barevné schéma');
@define('PLUGIN_SNAPSHOTLINKS_THEME_DESC',          'Vyberte barevné schéma pro náhledy odkazů');

@define('PLUGIN_SNAPSHOTLINKS_THEME_ASPHALT',       'Asfalt');
@define('PLUGIN_SNAPSHOTLINKS_THEME_GREEN',         'Zelená');
@define('PLUGIN_SNAPSHOTLINKS_THEME_ICE',           'Světle modrá');
@define('PLUGIN_SNAPSHOTLINKS_THEME_LINEN',         'Plátno');
@define('PLUGIN_SNAPSHOTLINKS_THEME_ORANGE',        'Pomeranč');
@define('PLUGIN_SNAPSHOTLINKS_THEME_PINK',          'Růžová');
@define('PLUGIN_SNAPSHOTLINKS_THEME_PURPLE',        'Nachová');
@define('PLUGIN_SNAPSHOTLINKS_THEME_SILVER',        'Stříbrná');

@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSIZE_NAME',    'Velikost náhledu');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSIZE_DESC',    'Pamatujte, že velká velikost náhledu znamená velkou velikost obrázku s náhledem a může prodloužit čas nahrávání stránky.');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSIZE_SMALL',   'malý');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSIZE_LARGE',   'velký');

@define('PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_NAME', 'Spínač pro zobrazení náhledu');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_DESC', 'Náhled je zobrazen, pokud myš najede nad odkaz a/nebo na ikonku vedle něj.');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_LINK', 'kurzor nad odkazem');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_ICON', 'kurzor nad ikonou');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_BOTH', 'jak nad odkazem, tak i nad ikonou');

@define('PLUGIN_SNAPSHOTLINKS_LINKICON_NAME',       'Zobrazovat ikonu odkazu');
@define('PLUGIN_SNAPSHOTLINKS_LINKICON_DESC',       'Má se vedle každého odkazu zobrazovat ikonka?');

@define('PLUGIN_SNAPSHOTLINKS_USERPREVIEW_NAME',    'Natahovat náhledy');
@define('PLUGIN_SNAPSHOTLINKS_USERPREVIEW_DESC',    'Nahrává náhledy odkazů předtím, než natáhne stránku. Doporučuje se vypnout, jinak se nahrávání stránek velmi zpomalí!');
@define('PLUGIN_SNAPSHOTLINKS_CUSTOMLOGO_NAME',     'Vlastní logo');
@define('PLUGIN_SNAPSHOTLINKS_CUSTOMLOGO_DESC',     'Pro zobrazení vlastního loga v náhledech odkazů ho musíte nahrát na server služby snap.com.');

// "Advanced options"
@define('PLUGIN_SNAPSHOTLINKS_SEARCHBOX_NAME',      'Vyhledávací okno');
@define('PLUGIN_SNAPSHOTLINKS_SEARCHBOX_DESC',      'Zobrazit vyhledávací okno k prohledání webu pomocí snap.com');
@define('PLUGIN_SNAPSHOTLINKS_ALLLINKS_NAME',       'Náhled pro odkazy mimo blog');
@define('PLUGIN_SNAPSHOTLINKS_ALLLINKS_DESC',       'Chcete zobrazovat náhledy odkazů vedoucích mimo Váš blog?');
@define('PLUGIN_SNAPSHOTLINKS_LOCALLINKS_NAME',     'Náhled pro interní odkazy');
@define('PLUGIN_SNAPSHOTLINKS_LOCALLINKS_DESC',     'Chcete zobrazovat náhledy na jinou stránku Vašeho vlastního blogu?');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSHOTS_NAME',   'Vždy zobrazovat obrázky náhledů');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSHOTS_DESC',   'Zobrazovat náhledy vždy jako obrázky. Pokud je vypnuto, jsou nataženy pouze textové náhledy (pomocí RSS kanálu). Vypnutí změnší objem dat přenášených po síti.');

// Wikipedia options:
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_NAME',         'Zobrazovat náhledy z Wikipedie');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_DESC',         'Jednotlivá slova mohou být následovana ikonkou a otevírat stránku na Wikipedii, které popisuje odkazované heslo. Chce používat tuto funkci?');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_LANG_NAME',    'Jazyk wikipedie');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_LANG_DESC',    'Které jazyková verze má být použita pro otvírání wikipedie. Pro českou verzi zde napište "cs".');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_NAME',    'Značkování (markup) wikipedia');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_DESC',    'Jak chcete zvýrazňovat v natažené stránce wikipedie odkazovaná hesla?');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_BOLD',    'Tučně');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_ITALIC',  'Kurzíva');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_SUBLINED','Podtržení');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_REMOVE_TYPE_NAME',     'Odstranit označování slov ve wikipedii?');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_REMOVE_TYPE_DESC',     'Chcete nahradit zvýrazňování pomocí nového SnapShot kódu, nebo chcete nechat zvýrazňování při zobrazení článku?');

?>