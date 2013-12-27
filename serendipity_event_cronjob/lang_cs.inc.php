/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/08/14
 */

@define('PLUGIN_EVENT_CRONJOB_NAME', 'Plánovaè úloh');
@define('PLUGIN_EVENT_CRONJOB_DESC', 'Tento plugin periodicky vykonává pluginy, které poskytují/vyžadují opakované vykonávání. Podrobnosti v konfiguraci pluginu.');
@define('PLUGIN_EVENT_CRONJOB_DETAILS', 'Tento plugin poskytuje nové API hooky pro ostatní pluginy (cronjob_5min, cronjob_30min, cronjob_1h, cronjob_12h, cronjob_daily, cronjob_weekly, cronjob_monthly). POZNÁMKA: Vykonání skriptù je závislé na Vašich návštìvnících. Pokud nikdo nenavštìvuje Vaše stránky, žádné úlohy nemohou být spuštìny. Pokud vlastníte server s programem pro spouštìní úloh (jako napøíklad Cron), je lepším øešením pøidat do jeho konfiguraèní tabulky záznam <br /><br />5 * * * wget http://vasBlog/index.php?serendipity[cronjob]=all.<br /><br />A pak mùžete zakázat vykonávání úloh na základì návštìv uživatelù.');
@define('PLUGIN_EVENT_CRONJOB_VISITOR', 'Povolit spouštìní úloh na základì návštìv uživatelù?');
@define('PLUGIN_EVENT_CRONJOB_VISITOR_DESC', 'Pokud je tato volba povolena, plánované úlohy budou spouštìny návštìvami blogu. K tomu bude do stránek blogu vložen obrázek o rozmìrech 0 pixelù (který volá index.php?serendipity[cronjob]=true), který se stará o spuštìní úloh. Pro ty z Vás, kteøí nemáte možnost spouštìt úlohy pøímo na serveru (nemáte možnost používat Cron nebo podobný nástro), je to jediná možnost, jak periodicky opakovat nìkteré úlohy. Pamatujte, že takovéto spouštìní úloh je závislé na návštìvách Vašich stránek, tedy èasové prodlevy mezi jednotlivými spuštìními skriptu nebudou pøesné. (Napøíklad úloze nastavené na opakování každou hodinu se mùže stát, že nebude bìhem 3 hodin spuštìna ani jednou, pokud bìhem tìch tøí hodin na blog nepøijde jediný návštìvník.)');
@define('PLUGIN_EVENT_CRONJOB_LOG', 'Poslední aktivita plánovaèe úloh');
@define('PLUGIN_EVENT_CRONJOB_CHOOSE', 'Kdy spustit?');