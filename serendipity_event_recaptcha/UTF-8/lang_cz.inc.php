<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/22
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/21
 */

@define('PLUGIN_EVENT_RECAPTCHA_TITLE', 'Recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_DESC', 'Při vkládání komentářů používá systém kryptogramů Recaptcha (je třeba předem zažádat o přístupový klíč)');

@define('PLUGIN_EVENT_RECAPTCHA_HIDE', 'Vypnout kryptogramy Recaptcha pro přihlášené uživatele');
@define('PLUGIN_EVENT_RECAPTCHA_HIDE_DESC', 'Uživatelé ve zde vybraných skupinách mohou posílat komentáře, aniž by museli zadávat Recaptcha kryptogramy');


@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA', 'Použít kryptogramy Recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_DESC', 'Pokud je nastaveno, budou použity kryptogramy Recaptcha. To je speciální druh kryptogramů, který pomáhá při digitalizaci knih. Viz https://www.google.com/recaptcha/. Uživatel si může vybrat, že místo zadávání zobrazených písmen mu bude přehrána krátká zpráva obsahující čísla, která slouží jako kód. Pokud nejsou generovány žádné kryptogramy, server je pravděpodobně mimo službu.');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_STYLE', 'Který typ kryptogramů použít?');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_STYLE_DESC', 'Vyberte jeden z následujících typů: red (červený), white (bílý), blackglass (černé sklo). Tato volba funguje pouze s povoleným javascriptem.');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PUB', 'Veřejný klíč pro kryptogramy Recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PUB_DESC', 'Zadejte veřejnou (public) část klíče pro komunikaci se serveren recaptcha.net. O vygenerování páru klíče (veřejný + soukromý klíč) můžete požádat na https://www.google.com/recaptcha/admin');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PRIV', 'Soukromý klíč recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PRIV_DESC', 'Zadejte soukromou (private) část klíče pro komunikaci se serveren recaptcha.net. O vygenerování páru klíče (veřejný + soukromý klíč) můžete požádat na https://www.google.com/recaptcha/admin');

@define('PLUGIN_EVENT_RECAPTCHA_CAPTCHAS_TTL', 'Vynutit kryptogramy po uplynutí kolika dní?');
@define('PLUGIN_EVENT_RECAPTCHA_CAPTCHAS_TTL_DESC', 'Použití kryptogramů může být vynuceno v závislosti na stáří článků. Zadejte počet dní, po jejichž uplynutí od vydání článku je třeba zadat kryptogram. Hodnota 0 znamená, že kryptogramy budou použity vždy.');


@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE', 'Vyberte metodu logování');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_DESC', 'Odmítnuté komentáře je možné logovat buď do databáze nebo do textového souboru.');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_FILE', 'Soubor (viz volba "logfile" níže)');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_DB', 'Databáze');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_NONE', 'Nelogovat');

@define('PLUGIN_EVENT_RECAPTCHA_LOGFILE', 'Umístění souboru s logem');
@define('PLUGIN_EVENT_RECAPTCHA_LOGFILE_DESC', 'Informace o odmítnutých/schvalovaných příspěvcích je možné zapisovat do souboru. Zadejte zde prázdný řetězec pro vypnutí logování.');

@define('PLUGIN_EVENT_RECAPTCHA_ERROR_CAPTCHAS', 'Nezadal(a) jsi správný řetězec podle antispamového obrázku. Podívej se na kryptogram prosím ještě jednou a zadej správné hodnoty.');
@define('PLUGIN_EVENT_RECAPTCHA_ERROR_RECAPTCHA', 'Nezadali jste veřejný/soukromý klíč v nastavení kryptogramů recaptcha. Kryptogramy budou vypnuty. Pokud je chcete používat, zadejte prosím oba dva klíče v nastavení pluginu Recaptcha, nebo použijte obyčejné kryptogramy (plugin "antispamové metody").');

@define('PLUGIN_EVENT_RECAPTCHA_INFO1', 'Recaptcha je zvláštní druh <a href="http://en.wikipedia.com/wiki/Captcha">kryptogramu</a>. Uživatel musí rozpoznat dvě slova. První systémem výzva-odpověď (ochrana před spamem), a druhé, které pomáhá při digitalizaci knih. Navíc zrakově postižení lidé mohou použít audio-kryptogram. Pro více informací se podívejte na stránku <a href="https://www.google.com/recaptcha/">https://www.google.com/recaptcha/</a>.<br/>Pamatujte, že abyste mohli používat tento plugin, musíte se registrovat na zmíněné webové stránce.O klíč můžete požádat <a href="https://www.google.com/recaptcha/admin');
@define('PLUGIN_EVENT_RECAPTCHA_INFO2', '">tady</a>. <br/> Pamatujte také prosím, že tento plugin se bude při každém komentáři dotazovat serveru recaptcha, a může proto zpomalit načítání stránek. Pokud bude server recaptcha vypnutý, pak nebudou použity žádné kryptogramy.');