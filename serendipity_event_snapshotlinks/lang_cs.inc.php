/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/31
 */@define('PLUGIN_SNAPSHOTLINKS_NAME',                'Odkazy s náhledy pomocí služby www.snap.com');
@define('PLUGIN_SNAPSHOTLINKS_DESC',                'Tento plugin zobrazuje náhledy odkazù v pøíspìvcích, když na nì návštìvník najede myší. Náhledy jsou generovány službou SnapShot (www.snap.com). Je tøeba zaregistrovat si tam úèet, pak obdržíte klíè pro pøístup ke službì SnapShot.\nSnap.com je zadarmo, ale mìli byste vìdìt, že *mùže* shromažïovat informace o odkazech na Vašich stránkách, aèkoliv ve svých obchodních podmínkách slibují, že to dìlat nebudou.');
@define('PLUGIN_SNAPSHOTLINKS_DESC_DUMMY',          'Tento plugin zobrazuje náhledy odkazù v pøíspìvcích, když na nì návštìvník najede myší. Náhledy jsou generovány službou SnapShot (www.snap.com). \nSnap.com je zadarmo, ale mìli byste vìdìt, že *mùže* shromažïovat informace o odkazech na Vašich stránkách, aèkoliv ve svých obchodních podmínkách slibují, že to dìlat nebudou.');

@define('PLUGIN_SNAPSHOTLINKS_URL_NAME',            'Registrovaná doména');
@define('PLUGIN_SNAPSHOTLINKS_URL_DESC',            'Doména, kterou jste zaregistrovali na snap.com');
@define('PLUGIN_SNAPSHOTLINKS_KEY_NAME',            'SnapShot klíè');
@define('PLUGIN_SNAPSHOTLINKS_KEY_DESC',            'Poté, co zaregistrujete doménu a kontaktné email, obdržíte skript pro generování náhledù. Mezi "key=" a "&" uvidíte Váš unikátní uživatelský klíè, který zkopírujte a vložte sem (bez toho ukonèujícího "&").');

@define('PLUGIN_SNAPSHOTLINKS_THEME_NAME',          'Barevné schéma');
@define('PLUGIN_SNAPSHOTLINKS_THEME_DESC',          'Vyberte barevné schéma pro náhledy odkazù');

@define('PLUGIN_SNAPSHOTLINKS_THEME_ASPHALT',       'Asfalt');
@define('PLUGIN_SNAPSHOTLINKS_THEME_GREEN',         'Zelená');
@define('PLUGIN_SNAPSHOTLINKS_THEME_ICE',           'Svìtle modrá');
@define('PLUGIN_SNAPSHOTLINKS_THEME_LINEN',         'Plátno');
@define('PLUGIN_SNAPSHOTLINKS_THEME_ORANGE',        'Pomeranè');
@define('PLUGIN_SNAPSHOTLINKS_THEME_PINK',          'Rùžová');
@define('PLUGIN_SNAPSHOTLINKS_THEME_PURPLE',        'Nachová');
@define('PLUGIN_SNAPSHOTLINKS_THEME_SILVER',        'Støíbrná');

@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSIZE_NAME',    'Velikost náhledu');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSIZE_DESC',    'Pamatujte, že velká velikost náhledu znamená velkou velikost obrázku s náhledem a mùže prodloužit èas nahrávání stránky.');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSIZE_SMALL',   'malý');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSIZE_LARGE',   'velký');

@define('PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_NAME', 'Spínaè pro zobrazení náhledu');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_DESC', 'Náhled je zobrazen, pokud myš najede nad odkaz a/nebo na ikonku vedle nìj.');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_LINK', 'kurzor nad odkazem');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_ICON', 'kurzor nad ikonou');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_BOTH', 'jak nad odkazem, tak i nad ikonou');

@define('PLUGIN_SNAPSHOTLINKS_LINKICON_NAME',       'Zobrazovat ikonu odkazu');
@define('PLUGIN_SNAPSHOTLINKS_LINKICON_DESC',       'Má se vedle každého odkazu zobrazovat ikonka?');

@define('PLUGIN_SNAPSHOTLINKS_USERPREVIEW_NAME',    'Natahovat náhledy');
@define('PLUGIN_SNAPSHOTLINKS_USERPREVIEW_DESC',    'Nahrává náhledy odkazù pøedtím, než natáhne stránku. Doporuèuje se vypnout, jinak se nahrávání stránek velmi zpomalí!');
@define('PLUGIN_SNAPSHOTLINKS_CUSTOMLOGO_NAME',     'Vlastní logo');
@define('PLUGIN_SNAPSHOTLINKS_CUSTOMLOGO_DESC',     'Pro zobrazení vlastního loga v náhledech odkazù ho musíte nahrát na server služby snap.com.');

// "Advanced options"
@define('PLUGIN_SNAPSHOTLINKS_SEARCHBOX_NAME',      'Vyhledávací okno');
@define('PLUGIN_SNAPSHOTLINKS_SEARCHBOX_DESC',      'Zobrazit vyhledávací okno k prohledání webu pomocí snap.com');
@define('PLUGIN_SNAPSHOTLINKS_ALLLINKS_NAME',       'Náhled pro odkazy mimo blog');
@define('PLUGIN_SNAPSHOTLINKS_ALLLINKS_DESC',       'Chcete zobrazovat náhledy odkazù vedoucích mimo Váš blog?');
@define('PLUGIN_SNAPSHOTLINKS_LOCALLINKS_NAME',     'Náhled pro interní odkazy');
@define('PLUGIN_SNAPSHOTLINKS_LOCALLINKS_DESC',     'Chcete zobrazovat náhledy na jinou stránku Vašeho vlastního blogu?');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSHOTS_NAME',   'Vždy zobrazovat obrázky náhledù');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSHOTS_DESC',   'Zobrazovat náhledy vždy jako obrázky. Pokud je vypnuto, jsou nataženy pouze textové náhledy (pomocí RSS kanálu). Vypnutí zmìnší objem dat pøenášených po síti.');

// Wikipedia options:
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_NAME',         'Zobrazovat náhledy z Wikipedie');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_DESC',         'Jednotlivá slova mohou být následovana ikonkou a otevírat stránku na Wikipedii, které popisuje odkazované heslo. Chce používat tuto funkci?');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_LANG_NAME',    'Jazyk wikipedie');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_LANG_DESC',    'Které jazyková verze má být použita pro otvírání wikipedie. Pro èeskou verzi zde napište "cs".');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_NAME',    'Znaèkování (markup) wikipedia');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_DESC',    'Jak chcete zvýrazòovat v natažené stránce wikipedie odkazovaná hesla?');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_BOLD',    'Tuènì');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_ITALIC',  'Kurzíva');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_SUBLINED','Podtržení');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_REMOVE_TYPE_NAME',     'Odstranit oznaèování slov ve wikipedii?');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_REMOVE_TYPE_DESC',     'Chcete nahradit zvýrazòování pomocí nového SnapShot kódu, nebo chcete nechat zvýrazòování pøi zobrazení èlánku?');

?>