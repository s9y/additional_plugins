/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/22
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/21
 */

@define('PLUGIN_EVENT_RECAPTCHA_TITLE', 'Recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_DESC', 'Pøi vkládání komentáøù pou¾ívá systém kryptogramù Recaptcha (je tøeba pøedem za¾ádat o pøístupový klíè)');

@define('PLUGIN_EVENT_RECAPTCHA_HIDE', 'Vypnout kryptogramy Recaptcha pro pøihlá¹ené u¾ivatele');
@define('PLUGIN_EVENT_RECAPTCHA_HIDE_DESC', 'U¾ivatelé ve zde vybraných skupinách mohou posílat komentáøe, ani¾ by museli zadávat Recaptcha kryptogramy');


@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA', 'Pou¾ít kryptogramy Recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_DESC', 'Pokud je nastaveno, budou pou¾ity kryptogramy Recaptcha. To je speciální druh kryptogramù, který pomáhá pøi digitalizaci knih. Viz http://www.recaptcha.net. U¾ivatel si mù¾e vybrat, ¾e místo zadávání zobrazených písmen mu bude pøehrána krátká zpráva obsahující èísla, která slou¾í jako kód. Pokud nejsou generovány ¾ádné kryptogramy, server je pravdìpodobnì mimo slu¾bu.');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_STYLE', 'Který typ kryptogramù pou¾ít?');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_STYLE_DESC', 'Vyberte jeden z následujících typù: red (èervený), white (bílý), blackglass (èerné sklo). Tato volba funguje pouze s povoleným javascriptem.');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PUB', 'Veøejný klíè pro kryptogramy Recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PUB_DESC', 'Zadejte veøejnou (public) èást klíèe pro komunikaci se serveren recaptcha.net. O vygenerování páru klíèe (veøejný + soukromý klíè) mù¾ete po¾ádat na http://www.recaptcha.net/api/getkey');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PRIV', 'Soukromý klíè recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PRIV_DESC', 'Zadejte soukromou (private) èást klíèe pro komunikaci se serveren recaptcha.net. O vygenerování páru klíèe (veøejný + soukromý klíè) mù¾ete po¾ádat na http://www.recaptcha.net/api/getkey');

@define('PLUGIN_EVENT_RECAPTCHA_CAPTCHAS_TTL', 'Vynutit kryptogramy po uplynutí kolika dní?');
@define('PLUGIN_EVENT_RECAPTCHA_CAPTCHAS_TTL_DESC', 'Pou¾ití kryptogramù mù¾e být vynuceno v závislosti na stáøí èlánkù. Zadejte poèet dní, po jejich¾ uplynutí od vydání èlánku je tøeba zadat kryptogram. Hodnota 0 znamená, ¾e kryptogramy budou pou¾ity v¾dy.');


@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE', 'Vyberte metodu logování');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_DESC', 'Odmítnuté komentáøe je mo¾né logovat buï do databáze nebo do textového souboru.');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_FILE', 'Soubor (viz volba "logfile" ní¾e)');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_DB', 'Databáze');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_NONE', 'Nelogovat');

@define('PLUGIN_EVENT_RECAPTCHA_LOGFILE', 'Umístìní souboru s logem');
@define('PLUGIN_EVENT_RECAPTCHA_LOGFILE_DESC', 'Informace o odmítnutých/schvalovaných pøíspìvcích je mo¾né zapisovat do souboru. Zadejte zde prázdný øetìzec pro vypnutí logování.');

@define('PLUGIN_EVENT_RECAPTCHA_ERROR_CAPTCHAS', 'Nezadal(a) jsi správný øetìzec podle antispamového obrázku. Podívej se na kryptogram prosím je¹tì jednou a zadej správné hodnoty.');
@define('PLUGIN_EVENT_RECAPTCHA_ERROR_RECAPTCHA', 'Nezadali jste veøejný/soukromý klíè v nastavení kryptogramù recaptcha. Kryptogramy budou vypnuty. Pokud je chcete pou¾ívat, zadejte prosím oba dva klíèe v nastavení pluginu Recaptcha, nebo pou¾ijte obyèejné kryptogramy (plugin "antispamové metody").');

@define('PLUGIN_EVENT_RECAPTCHA_INFO1', 'Recaptcha je zvlá¹tní druh <a href="http://en.wikipedia.com/wiki/Captcha">kryptogramu</a>. U¾ivatel musí rozpoznat dvì slova. První systémem výzva-odpovìï (ochrana pøed spamem), a druhé, které pomáhá pøi digitalizaci knih. Navíc zrakovì posti¾ení lidé mohou pou¾ít audio-kryptogram. Pro více informací se podívejte na stránku <a href="http://www.recaptcha.net">www.recaptcha.net</a>.<br/>Pamatujte, ¾e abyste mohli pou¾ívat tento plugin, musíte se registrovat na zmínìné webové stránce.O klíè mù¾ete po¾ádat  <a href="http://www.recaptcha.net/api/getkey?app=serendipity&domain=');
@define('PLUGIN_EVENT_RECAPTCHA_INFO2', '">tady</a>. <br/> Pamatujte také prosím, ¾e tento plugin se bude pøi ka¾dém komentáøi dotazovat serveru recaptcha, a mù¾e proto zpomalit naèítání stránek. Pokud bude server recaptcha vypnutý, pak nebudou pou¾ity ¾ádné kryptogramy.');