<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/08/14
 */

@define('PLUGIN_EVENT_CRONJOB_NAME', 'Plánovaè úloh');
@define('PLUGIN_EVENT_CRONJOB_DESC', 'Tento plugin periodicky vykonává pluginy, které poskytují/vy¾adují opakované vykonávání. Podrobnosti v konfiguraci pluginu.');
@define('PLUGIN_EVENT_CRONJOB_DETAILS', 'Tento plugin poskytuje nové API hooky pro ostatní pluginy (cronjob_5min, cronjob_30min, cronjob_1h, cronjob_12h, cronjob_daily, cronjob_weekly, cronjob_monthly). POZNÁMKA: Vykonání skriptù je závislé na Va¹ich náv¹tìvnících. Pokud nikdo nenav¹tìvuje Va¹e stránky, ¾ádné úlohy nemohou být spu¹tìny. Pokud vlastníte server s programem pro spou¹tìní úloh (jako napøíklad Cron), je lep¹ím øe¹ením pøidat do jeho konfiguraèní tabulky záznam <br /><br />5 * * * wget http://vasBlog/index.php?serendipity[cronjob]=all.<br /><br />A pak mù¾ete zakázat vykonávání úloh na základì náv¹tìv u¾ivatelù.');
@define('PLUGIN_EVENT_CRONJOB_VISITOR', 'Povolit spou¹tìní úloh na základì náv¹tìv u¾ivatelù?');
@define('PLUGIN_EVENT_CRONJOB_VISITOR_DESC', 'Pokud je tato volba povolena, plánované úlohy budou spou¹tìny náv¹tìvami blogu. K tomu bude do stránek blogu vlo¾en obrázek o rozmìrech 0 pixelù (který volá index.php?serendipity[cronjob]=true), který se stará o spu¹tìní úloh. Pro ty z Vás, kteøí nemáte mo¾nost spou¹tìt úlohy pøímo na serveru (nemáte mo¾nost pou¾ívat Cron nebo podobný nástro), je to jediná mo¾nost, jak periodicky opakovat nìkteré úlohy. Pamatujte, ¾e takovéto spou¹tìní úloh je závislé na náv¹tìvách Va¹ich stránek, tedy èasové prodlevy mezi jednotlivými spu¹tìními skriptu nebudou pøesné. (Napøíklad úloze nastavené na opakování ka¾dou hodinu se mù¾e stát, ¾e nebude bìhem 3 hodin spu¹tìna ani jednou, pokud bìhem tìch tøí hodin na blog nepøijde jediný náv¹tìvník.)');
@define('PLUGIN_EVENT_CRONJOB_LOG', 'Poslední aktivita plánovaèe úloh');
@define('PLUGIN_EVENT_CRONJOB_CHOOSE', 'Kdy spustit?');