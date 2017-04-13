<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/13
 */

@define('PLUGIN_AUDIOSCROBBLER_TITLE', 'Audioscrobbler');
@define('PLUGIN_AUDIOSCROBBLER_TITLE_BLAHBLAH', 'Ze služby audioscrobbler.net (neblo last.fm) Zobrazuje naposledy přehrávané skladby');
@define('PLUGIN_AUDIOSCROBBLER_NUMBER', 'Počet skladeb');
@define('PLUGIN_AUDIOSCROBBLER_NUMBER_BLAHBLAH', 'Kolik posledních skladeb se má zobrazovat? (musí být větší nebo rovna 1; obvyklá hodnota: 1)');
@define('PLUGIN_AUDIOSCROBBLER_USERNAME', 'Uživatelské jméno na Audioscrobbleru');
@define('PLUGIN_AUDIOSCROBBLER_USERNAME_BLAHBLAH', 'Zadejte své uživatelské jméno ke službě audioscrobbler, aby se mohl plugin připojit k Vašemu RSS kanálu.');
@define('PLUGIN_AUDIOSCROBBLER_NEWWINDOW', 'Nové okno');
@define('PLUGIN_AUDIOSCROBBLER_NEWWINDOW_BLAHBLAH', 'Mají se odkazy otevírat v novém okně? (používá javascript)');
@define('PLUGIN_AUDIOSCROBBLER_CACHETIME', 'Jak často se má aktualizovat seznam skladeb?');
@define('PLUGIN_AUDIOSCROBBLER_CACHETIME_BLAHBLAH', 'Obsah RSS kanálu z Audioscrobbleru se ukládá do cache. Ta je obnovována po uplynutí zde zadaného času v minutách. (výchozí: 30, minimální hodnota: 5 minut)');
@define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING', 'Formátování řádků');
@define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLAHBLAH', 'Použijte proměnnou %ARTIST% pro umístění jména interpreta, %SONG% pro název skladby, %ALBUM% pro název alba a %DATE% pro datum.');
@define('PLUGIN_AUDIOSCROBBLER_UTCDIFFERENCE', 'Posun času vůči GMT (Greenwichský čas)');
@define('PLUGIN_AUDIOSCROBBLER_UTCDIFFERENCE_BLAHBLAH', 'Posun vůči Greenwichskému času (např. EST, tj. Boston a New York v USA = -5)');   
@define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLOCK', 'Formát postranního bloku Audioscrobbler');
@define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLOCK_BLAHBLAH', 'Použijte proměnnou %ENTRIES% pro seznam skladeb, %PROFILE% pro zobrazení odkazu na Váš profil na Audioscrobbleru a %LASTUPDATE% pro datum, kdy byl naposledy obnoven obsah cache s RSS kanálem.');
@define('PLUGIN_AUDIOSCROBBLER_PROFILETITLE', 'Text odkazu na profil');
@define('PLUGIN_AUDIOSCROBBLER_PROFILETITLE_BLAHBLAH', 'Text, který se zobrazuje jako odkaz na Váš profil Audioscrobbler. (uživatelské jméno vložíte pomocí %USER%)');
@define('PLUGIN_AUDIOSCROBBLER_SONGLINK', 'Skladby jako odkazy?');
@define('PLUGIN_AUDIOSCROBBLER_SONGLINK_BLAHBLAH', 'Mají být názvy skladeb jako odkazy na jejich stránku na Audioscrobbleru?');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK', 'Interpret jako odkaz?');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_BLAHBLAH', 'Mají se jména interpretů zobrazovat jako odkazy? (vyberte službu)');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_NONE', 'ne');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_SCROBBLER', 'Stránka interpreta na Audioscrobbleru');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_MUSICBRAINZ_ELSE_NONE', 'Musicbrainz, pokud je dostupný');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_MUSICBRAINZ_ELSE_SCROBBLER', 'Musicbrainz, pokud není dostupný, pak Audioscrobbler');
@define('PLUGIN_AUDIOSCROBBLER_SPACER', 'Oddělovač');
@define('PLUGIN_AUDIOSCROBBLER_SPACER_BLAHBLAH', 'Co se má použít jako oddělovač jednotlivých skladeb v seznamu skladeb?');
@define('PLUGIN_AUDIOSCROBBLER_COULD_NOT_WRITE', 'Cache nemohla být uložena');
@define('PLUGIN_AUDIOSCROBBLER_COULD_NOT_READ', 'Cache nemohla být přečtena');
@define('PLUGIN_AUDIOSCROBBLER_FEED_OFFLINE', 'Audioscrobbler je offline');
@define('PLUGIN_AUDIOSCROBBLER_STACK', 'Použít vyplňování seznamu skladeb?');
@define('PLUGIN_AUDIOSCROBBLER_STACK_BLAHBLAH', 'Pokud je počet skladeb ve Vašem seznamu skladeb menší, než kolik skladeb chcete zobrazovat v postranním bloku, můžete povolit puginu, aby zbývající volná místa zaplnil poslední skladbou.');
@define('PLUGIN_AUDIOSCROBBLER_NUMBER_BLAHBLAH', 'Kolik posledních skladeb se má zobrazovat? (musí být větší nebo rovna 1; obvyklá hodnota: 1)');
@define('PLUGIN_AUDIOSCROBBLER_FORCE_ENCODING', 'Vynutit kódování:');
@define('PLUGIN_AUDIOSCROBBLER_FORCE_ENCODING_BLAHBLAH', 'Serendipity předpokládá, že data z Audioscrobbleru přichází v kódování UTF-8. Pokud se některé speciální znaky nezobrazují správně, protože Váš blog nemá nastavenou znakovou sadu na UTF-8, zadejte zde odpovídající kódování.');