<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/13
 */

@define('PLUGIN_AUDIOSCROBBLER_TITLE', 'Audioscrobbler');
@define('PLUGIN_AUDIOSCROBBLER_TITLE_BLAHBLAH', 'Ze služby audioscrobbler.net (neblo last.fm) Zobrazuje naposledy pøehrávané skladby');
@define('PLUGIN_AUDIOSCROBBLER_NUMBER', 'Poèet skladeb');
@define('PLUGIN_AUDIOSCROBBLER_NUMBER_BLAHBLAH', 'Kolik posledních skladeb se má zobrazovat? (musí být vìtší nebo rovna 1; obvyklá hodnota: 1)');
@define('PLUGIN_AUDIOSCROBBLER_USERNAME', 'Uživatelské jméno na Audioscrobbleru');
@define('PLUGIN_AUDIOSCROBBLER_USERNAME_BLAHBLAH', 'Zadejte své uživatelské jméno ke službì audioscrobbler, aby se mohl plugin pøipojit k Vašemu RSS kanálu.');
@define('PLUGIN_AUDIOSCROBBLER_NEWWINDOW', 'Nové okno');
@define('PLUGIN_AUDIOSCROBBLER_NEWWINDOW_BLAHBLAH', 'Mají se odkazy otevírat v novém oknì? (používá javascript)');
@define('PLUGIN_AUDIOSCROBBLER_CACHETIME', 'Jak èasto se má aktualizovat seznam skladeb?');
@define('PLUGIN_AUDIOSCROBBLER_CACHETIME_BLAHBLAH', 'Obsah RSS kanálu z Audioscrobbleru se ukládá do cache. Ta je obnovována po uplynutí zde zadaného èasu v minutách. (výchozí: 30, minimální hodnota: 5 minut)');
@define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING', 'Formátování øádkù');
@define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLAHBLAH', 'Použijte promìnnou %ARTIST% pro umístìní jména interpreta, %SONG% pro název skladby, %ALBUM% pro název alba a %DATE% pro datum.');
@define('PLUGIN_AUDIOSCROBBLER_UTCDIFFERENCE', 'Posun èasu vùèi GMT (Greenwichský èas)');
@define('PLUGIN_AUDIOSCROBBLER_UTCDIFFERENCE_BLAHBLAH', 'Posun vùèi Greenwichskému èasu (napø. EST, tj. Boston a New York v USA = -5)');   
@define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLOCK', 'Formát postranního bloku Audioscrobbler');
@define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLOCK_BLAHBLAH', 'Použijte promìnnou %ENTRIES% pro seznam skladeb, %PROFILE% pro zobrazení odkazu na Váš profil na Audioscrobbleru a %LASTUPDATE% pro datum, kdy byl naposledy obnoven obsah cache s RSS kanálem.');
@define('PLUGIN_AUDIOSCROBBLER_PROFILETITLE', 'Text odkazu na profil');
@define('PLUGIN_AUDIOSCROBBLER_PROFILETITLE_BLAHBLAH', 'Text, který se zobrazuje jako odkaz na Váš profil Audioscrobbler. (uživatelské jméno vložíte pomocí %USER%)');
@define('PLUGIN_AUDIOSCROBBLER_SONGLINK', 'Skladby jako odkazy?');
@define('PLUGIN_AUDIOSCROBBLER_SONGLINK_BLAHBLAH', 'Mají být názvy skladeb jako odkazy na jejich stránku na Audioscrobbleru?');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK', 'Interpret jako odkaz?');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_BLAHBLAH', 'Mají se jména interpretù zobrazovat jako odkazy? (vyberte službu)');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_NONE', 'ne');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_SCROBBLER', 'Stránka interpreta na Audioscrobbleru');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_MUSICBRAINZ_ELSE_NONE', 'Musicbrainz, pokud je dostupný');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_MUSICBRAINZ_ELSE_SCROBBLER', 'Musicbrainz, pokud není dostupný, pak Audioscrobbler');
@define('PLUGIN_AUDIOSCROBBLER_SPACER', 'Oddìlovaè');
@define('PLUGIN_AUDIOSCROBBLER_SPACER_BLAHBLAH', 'Co se má použít jako oddìlovaè jednotlivých skladeb v seznamu skladeb?');
@define('PLUGIN_AUDIOSCROBBLER_COULD_NOT_WRITE', 'Cache nemohla být uložena');
@define('PLUGIN_AUDIOSCROBBLER_COULD_NOT_READ', 'Cache nemohla být pøeètena');
@define('PLUGIN_AUDIOSCROBBLER_FEED_OFFLINE', 'Audioscrobbler je offline');
@define('PLUGIN_AUDIOSCROBBLER_STACK', 'Použít vyplòování seznamu skladeb?');
@define('PLUGIN_AUDIOSCROBBLER_STACK_BLAHBLAH', 'Pokud je poèet skladeb ve Vašem seznamu skladeb menší, než kolik skladeb chcete zobrazovat v postranním bloku, mùžete povolit puginu, aby zbývající volná místa zaplnil poslední skladbou.');
@define('PLUGIN_AUDIOSCROBBLER_NUMBER_BLAHBLAH', 'Kolik posledních skladeb se má zobrazovat? (musí být vìtší nebo rovna 1; obvyklá hodnota: 1)');
@define('PLUGIN_AUDIOSCROBBLER_FORCE_ENCODING', 'Vynutit kódování:');
@define('PLUGIN_AUDIOSCROBBLER_FORCE_ENCODING_BLAHBLAH', 'Serendipity pøedpokládá, že data z Audioscrobbleru pøichází v kódování UTF-8. Pokud se nìkteré speciální znaky nezobrazují správnì, protože Váš blog nemá nastavenou znakovou sadu na UTF-8, zadejte zde odpovídající kódování.');