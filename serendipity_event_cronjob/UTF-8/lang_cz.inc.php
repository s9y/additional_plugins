/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/08/14
 */

@define('PLUGIN_EVENT_CRONJOB_NAME', 'Plánovač úloh');
@define('PLUGIN_EVENT_CRONJOB_DESC', 'Tento plugin periodicky vykonává pluginy, které poskytují/vyžadují opakované vykonávání. Podrobnosti v konfiguraci pluginu.');
@define('PLUGIN_EVENT_CRONJOB_DETAILS', 'Tento plugin poskytuje nové API hooky pro ostatní pluginy (cronjob_5min, cronjob_30min, cronjob_1h, cronjob_12h, cronjob_daily, cronjob_weekly, cronjob_monthly). POZNÁMKA: Vykonání skriptů je závislé na Vašich návštěvnících. Pokud nikdo nenavštěvuje Vaše stránky, žádné úlohy nemohou být spuštěny. Pokud vlastníte server s programem pro spouštění úloh (jako například Cron), je lepším řešením přidat do jeho konfigurační tabulky záznam <br /><br />5 * * * wget http://vasBlog/index.php?serendipity[cronjob]=all.<br /><br />A pak můžete zakázat vykonávání úloh na základě návštěv uživatelů.');
@define('PLUGIN_EVENT_CRONJOB_VISITOR', 'Povolit spouštění úloh na základě návštěv uživatelů?');
@define('PLUGIN_EVENT_CRONJOB_VISITOR_DESC', 'Pokud je tato volba povolena, plánované úlohy budou spouštěny návštěvami blogu. K tomu bude do stránek blogu vložen obrázek o rozměrech 0 pixelů (který volá index.php?serendipity[cronjob]=true), který se stará o spuštění úloh. Pro ty z Vás, kteří nemáte možnost spouštět úlohy přímo na serveru (nemáte možnost používat Cron nebo podobný nástro), je to jediná možnost, jak periodicky opakovat některé úlohy. Pamatujte, že takovéto spouštění úloh je závislé na návštěvách Vašich stránek, tedy časové prodlevy mezi jednotlivými spuštěními skriptu nebudou přesné. (Například úloze nastavené na opakování každou hodinu se může stát, že nebude během 3 hodin spuštěna ani jednou, pokud během těch tří hodin na blog nepřijde jediný návštěvník.)');
@define('PLUGIN_EVENT_CRONJOB_LOG', 'Poslední aktivita plánovače úloh');
@define('PLUGIN_EVENT_CRONJOB_CHOOSE', 'Kdy spustit?');