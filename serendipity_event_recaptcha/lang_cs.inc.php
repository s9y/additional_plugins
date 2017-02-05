<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/22
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/21
 */

@define('PLUGIN_EVENT_RECAPTCHA_TITLE', 'Recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_DESC', 'Pøi vkládání komentáøù používá systém kryptogramù Recaptcha (je tøeba pøedem zažádat o pøístupový klíè)');

@define('PLUGIN_EVENT_RECAPTCHA_HIDE', 'Vypnout kryptogramy Recaptcha pro pøihlášené uživatele');
@define('PLUGIN_EVENT_RECAPTCHA_HIDE_DESC', 'Uživatelé ve zde vybraných skupinách mohou posílat komentáøe, aniž by museli zadávat Recaptcha kryptogramy');


@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA', 'Použít kryptogramy Recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_DESC', 'Pokud je nastaveno, budou použity kryptogramy Recaptcha. To je speciální druh kryptogramù, který pomáhá pøi digitalizaci knih. Viz https://www.google.com/recaptcha/. Uživatel si mùže vybrat, že místo zadávání zobrazených písmen mu bude pøehrána krátká zpráva obsahující èísla, která slouží jako kód. Pokud nejsou generovány žádné kryptogramy, server je pravdìpodobnì mimo službu.');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_STYLE', 'Který typ kryptogramù použít?');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_STYLE_DESC', 'Vyberte jeden z následujících typù: red (èervený), white (bílý), blackglass (èerné sklo). Tato volba funguje pouze s povoleným javascriptem.');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PUB', 'Veøejný klíè pro kryptogramy Recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PUB_DESC', 'Zadejte veøejnou (public) èást klíèe pro komunikaci se serveren recaptcha.net. O vygenerování páru klíèe (veøejný + soukromý klíè) mùžete požádat na https://www.google.com/recaptcha/admin');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PRIV', 'Soukromý klíè recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PRIV_DESC', 'Zadejte soukromou (private) èást klíèe pro komunikaci se serveren recaptcha.net. O vygenerování páru klíèe (veøejný + soukromý klíè) mùžete požádat na https://www.google.com/recaptcha/admin');

@define('PLUGIN_EVENT_RECAPTCHA_CAPTCHAS_TTL', 'Vynutit kryptogramy po uplynutí kolika dní?');
@define('PLUGIN_EVENT_RECAPTCHA_CAPTCHAS_TTL_DESC', 'Použití kryptogramù mùže být vynuceno v závislosti na stáøí èlánkù. Zadejte poèet dní, po jejichž uplynutí od vydání èlánku je tøeba zadat kryptogram. Hodnota 0 znamená, že kryptogramy budou použity vždy.');


@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE', 'Vyberte metodu logování');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_DESC', 'Odmítnuté komentáøe je možné logovat buï do databáze nebo do textového souboru.');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_FILE', 'Soubor (viz volba "logfile" níže)');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_DB', 'Databáze');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_NONE', 'Nelogovat');

@define('PLUGIN_EVENT_RECAPTCHA_LOGFILE', 'Umístìní souboru s logem');
@define('PLUGIN_EVENT_RECAPTCHA_LOGFILE_DESC', 'Informace o odmítnutých/schvalovaných pøíspìvcích je možné zapisovat do souboru. Zadejte zde prázdný øetìzec pro vypnutí logování.');

@define('PLUGIN_EVENT_RECAPTCHA_ERROR_CAPTCHAS', 'Nezadal(a) jsi správný øetìzec podle antispamového obrázku. Podívej se na kryptogram prosím ještì jednou a zadej správné hodnoty.');
@define('PLUGIN_EVENT_RECAPTCHA_ERROR_RECAPTCHA', 'Nezadali jste veøejný/soukromý klíè v nastavení kryptogramù recaptcha. Kryptogramy budou vypnuty. Pokud je chcete používat, zadejte prosím oba dva klíèe v nastavení pluginu Recaptcha, nebo použijte obyèejné kryptogramy (plugin "antispamové metody").');

@define('PLUGIN_EVENT_RECAPTCHA_INFO1', 'Recaptcha je zvláštní druh <a href="http://en.wikipedia.com/wiki/Captcha">kryptogramu</a>. Uživatel musí rozpoznat dvì slova. První systémem výzva-odpovìï (ochrana pøed spamem), a druhé, které pomáhá pøi digitalizaci knih. Navíc zrakovì postižení lidé mohou použít audio-kryptogram. Pro více informací se podívejte na stránku <a href="https://www.google.com/recaptcha/">https://www.google.com/recaptcha/</a>.<br/>Pamatujte, že abyste mohli používat tento plugin, musíte se registrovat na zmínìné webové stránce.O klíè mùžete požádat <a href="https://www.google.com/recaptcha/admin');
@define('PLUGIN_EVENT_RECAPTCHA_INFO2', '">tady</a>. <br/> Pamatujte také prosím, že tento plugin se bude pøi každém komentáøi dotazovat serveru recaptcha, a mùže proto zpomalit naèítání stránek. Pokud bude server recaptcha vypnutý, pak nebudou použity žádné kryptogramy.');