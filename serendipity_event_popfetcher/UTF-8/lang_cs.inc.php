<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/18
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/10/23
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/11/21
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/06/19
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/14
 */

@define('PLUGIN_MF_NAME', 'POP3 stahovač');
@define('PLUGIN_MF', 'POP3 stahovač');
@define('PLUGIN_MF_DESC', 'Stahuje zprávy z emailu a zobrazí je včetně příloh v bloku v postranním sloupci (speciální podpora pro mobilní telefony)');
@define('PLUGIN_MF_AM', 'Typ pluginu');
@define('PLUGIN_MF_AM_DESC', 'Pokud je nastaveno na "Interní", můžete spustit POP3 stahovač pouze z administrační sekce. Pokud je nastaveno "Externí", můžete spustit POP3 stahovač pouze zvnějšku (typicky jako úlohu cronu). Výchozí je "Interní".');
@define('PLUGIN_MF_HN', 'Jméno pro externí spouštění');
@define('PLUGIN_MF_HN_DESC', 'Tento název je použit pro spuštění stahovače zvnějšku. Nastavte na nějaké obtížně uhodnutelné jméno, aby Vám skript nemohla spustit neoprávněná osoba. Podtržítka nejsou povolena. Pokud je nastaven Typ na Interní, pak toto nastavení nemá žádný účinek. Výchozí: "popfetcher".');
@define('PLUGIN_MF_MS', 'Mailový server');
@define('PLUGIN_MF_MS_DESC', 'Doména, na které běží POP3 mailový server, např. "vasedomena.cz"');
@define('PLUGIN_MF_MD', 'Adresář pro upload');
@define('PLUGIN_MF_MD_DESC', 'Stažené přílohy budou uloženy do tohoto adresáře. Výchozí nastavení je shodné s upload adresářem Serendipity (zde prázdná hodnota). Pokud zadáte jiný adresář, musí jeho jméno končit lomítkem "/". Např: "dovolena/".');
@define('PLUGIN_MF_PP', 'POP3 port');
@define('PLUGIN_MF_PP_DESC', 'Číslo portu na serveru, na kterém běží služba POP3. Pokud je nastaveno na 995, POP3 stahovač se pokusí připojit zabezpečeným připojením (POP3 over SSL). Výchozí: 110.');
@define('PLUGIN_MF_MU', 'Uživatelské jméno');
@define('PLUGIN_MF_MU_DESC', 'Přihlašovací jméno k poště');
@define('PLUGIN_MF_CAT', 'Kategorie');
@define('PLUGIN_MF_CAT_DESC', 'Kategorie blogu, ve které se budou publikovat maily. Výchozí je žádná kategorie (prázdné políčko)');
@define('PLUGIN_MF_MP', 'Heslo');
@define('PLUGIN_MF_MP_DESC', 'Heslo k poště');
@define('PLUGIN_MF_TO', 'Timeout');
@define('PLUGIN_MF_TO_DESC', 'Počet vteřin, po kterých se ukončí pokus o připojení k mailovému serveru. Výchozí: 30.');
@define('PLUGIN_MF_DF', 'Příznak "Smazat"');
@define('PLUGIN_MF_PF_DESC', 'Pokud je nastaveno na "Publikovat", příspěvky blogu s emaily jsou po stažení okamžitě publikovány. Pokud je nastaveno "Koncept", pak jsou uloženy jako koncept a zveřejněny teprve po přepnutí administrátorem do stavu "publikovat". Výchozí: "Koncept". (Toto nastavení je ignorováno, pokud je příznak "Blog" nastaven na "Ne".)');
@define('PLUGIN_MF_PF', 'Příznak "Publikovat"');
@define('PLUGIN_MF_BF_DESC', 'Pokud nastaveno na "Ano", přílohy jsou uloženy do adresáře pro stahování, připojeny k textu mailu a dohromady jsou vystaveny jako příspěvek blogu. Pokud je nastaveno na "Ne", přílohy mailu jsou uloženy do adresáře pro stahování a zbytek mailu (tj. všechen text) je zahozen.');
@define('PLUGIN_MF_BF', 'Příznak "Blog"');
@define('PLUGIN_MF_DF_DESC', 'Pokud je nastaveno "Ano", pak je mail po stažení smazán ze serveru. Obvyklé nastavení je "Ano", pokud plugin netestujete.');
@define('PLUGIN_MF_AF', 'Příznak "APOP"');
@define('PLUGIN_MF_AF_DESC', 'Pokud je nastaveno "Ano", stahovač se pokusí přihlašovat metodou APOP. Výchozí: "Ne".');
@define('ERROR_CHECK', 'CHYBA:');
@define('INTERNAL_MF', 'Interní');
@define('EXTERNAL_MF', 'Externí');
@define('PUBLISH_MF', 'Publikovat');
@define('DRAFT_MF', 'Koncept');
@define('MF_ERROR1', 'CHYBA: nelze se připojit k mailovému serveru');
@define('MF_ERROR2', 'CHYBA: nepodařilo se přihlásit k mailovému účtu (chybné jméno a/nebo heslo)');
@define('MF_ERROR3', 'CHYBA: z poštovního účtu nelze získat UIDL info. Pravděpodobně nepodporuje UIDL.');
@define('MF_ERROR4', 'CHYBA: problém při stahování mailu');
@define('MF_ERROR5', 'CHYBA: nelze vytvořit soubor: ');
@define('MF_ERROR6', 'CHYBA: adresář pro stahování není zapisovatelný. Jděte do nastavení pluginu a změňte adresář nebo změňte přístupová práva k aktuálnímu adresáři.');
@define('MF_ERROR7', 'CHYBA: cesta k adresáři pro stahování musí končit lomítkem "/". Jděte do nastavení pluginu a opravte nastavení.');
@define('MF_ERROR8', 'CHYBA: Vámi zadaná kategorie blogu pro zveřejňování mailů neexistuje.');
@define('MF_ERROR9', 'CHYBA: nezdařilo se dekódování mailu, mail má chybný MIME formát. (Chyba je na straně odesílatele mailu.)');
@define('MF_ERROR10', 'CHYBA: Nelze nalézt SprintPCS Picture/Video Share URL.');
@define('MF_ERROR11', 'CHYBA: Nepodařilo se stáhnout SprintPCS Picture/Video URL.');
@define('MF_ERROR13', 'CHYBA: Nepodařilo se otevřít soubor s obrázkem/videem');
@define('MF_ERROR14', 'CHYBA: Nelze otevřít nový soubor pro SprintPCS sound memo.');
@define('MF_MSG1', 'Ve Vaší mailové schránce nejsou žádné zprávy');
@define('MF_MSG2', 'Počet mailů stažených z Vaší schránky');
@define('MF_MSG3', '[Hlavička s datem nenalezena]');
@define('MF_MSG4', '[Hlavička "Od" nenalezena - neznámý odesílatel]');
@define('MF_MSG5', 'Datum: ');
@define('MF_MSG6', 'Od: ');
@define('MF_MSG7', 'DATA MAILU');
@define('MF_MSG8', 'ČÁST MAILU -- Nalezena příloha se jménem: ');
@define('MF_MSG9', 'ČÁST MAILU -- Zpráva nalezena, žádné přílohy');
@define('MF_MSG10', 'V mailu nebyl nalezen žádný text ani přílohy');
@define('MF_MSG11', 'Všechny zprávy byly smazány z mailového serveru');
@define('MF_MSG12', 'Všechny zprávy jsou stále uloženy na mailovém serveru');
@define('MF_MSG13', 'Příloha byla uložena jako soubor: ');
@define('MF_MSG14', 'Soubor pojmenovaný jako příloha již existuje. Příloha bude uložena jako soubor: ');
@define('MF_MSG15', 'Publikuji nový příspěvek blogu s číslem');
@define('MF_MSG16', 'Předmět: ');
@define('MF_MSG17', '[Hlavička s předmětem nebyla nalezena]');
@define('MF_MSG18', 'Klikněte pro plnou velikost obrázku');
@define('MF_MSG19', 'Zpráva pravděpodobně obsahuje vir. Mail byl přeskočen kvůli příloze s podezřelým jménem.');
@define('MF_MSG20', 'Přeskočena zpráva bez příloh');
@define('MF_MSG21', 'Sound Memo');
@define('MF_MSG22', 'Klikněte pro video');
@define('MF_MSG23', 'Mobil @');
@define('MF_TEXTBODY', 'Zobrazit plaintextové přílohy v těle příspěvku?');
@define('MF_TEXTBODY_DESC', 'Pokud je aktivováno, všechny přílohy, které obsahují pouze text budou přidány do těla příspěvku na blogu. Pokud není aktivováno, tyto přílohy budou uloženy jako samostatné soubory a do příspěvku bude vložen pouze odkaz na ně.');
@define('MF_TEXTBODY_FIRST', 'První textová příloha je vložena jako tělo příspěvku, ostatní jako rozšířená textová část.');
@define('MF_TEXTBODY_FIRST_DESC', 'Nastavení je použito pouze pokud jsou plaintextové přílohy vkládány do těla příspěvku (viz. výše). Pokud je aktivováno, bude pouze první textová příloha použita jako tělo příspěvku (perex, teaser), ostatní budou uloženy do "rozšířené textové části" příspěvku. Budou se tudíž zobrazovat pouze při zobrazení jednoho konkrétního příspěvku a ne na přehledových stránkách, jako je např. hlavní stránka.');
@define('MF_MYSELF', 'Autor');
@define('MF_AUTHOR_DESC', 'Nastavte autora, který se bude zobrazovat jako autor u příspěvků obsahujících stažené maily.');
@define('PLUGIN_MF_STRIPTAGS', 'Odstranit z mailu všechny HTML tagy');
@define('PLUGIN_MF_STRIPTAGS_DESC', 'Odstraní z mailu všechny HTML tagy, případné formátování mailu tak bude ztraceno. Nehrozí ale rozházení stránky vlivem kukaččího HTML kódu.');

@define('PLUGIN_MF_ADDFLAG', 'Ořezat reklamy?');
@define('PLUGIN_MF_ADDFLAG_DESC', 'Má POP3 stahovač odstraňovat z mailu reklamní grafku a texty? Tento filter v současnosti funguje pouze pro T-Mobile a O2.');

@define('PLUGIN_MF_STRIPTEXT', 'Oříznout text na speciálním znaku');
@define('PLUGIN_MF_STRIPTEXT_DESC', 'Pokud chcete ořezat z mailů reklamy nebo jiný nežádoucí text, můžete zde zadat "kouzelný řetězec". Všechen text, který se v mailu nachází za tímto řetězcem, bude odstraněn a nebude se zobrazovat v příspěvku.');

@define('PLUGIN_MF_ONLYFROM', 'Omezení na konkrétní odesílatele');
@define('PLUGIN_MF_ONLYFROM_DESC', 'Pokud chcete povolit posílání mailů do blogu pouze z jedné mailové adresy, jednoduše ji sem zadejte. Pokud ponecháte políčko prázdné, na blogu budou zobrazovány všechny stažené maily.');
@define('MF_ERROR_ONLYFROM', 'Emailová adresa %s se neshoduje s povolenou adresou %s. Mail byl ignorován.');
@define('MF_ERROR_NOAUTHOR', 'Žádný z autorů nemá adresu %s. Mail byl přeskočen.');

@define('PLUGIN_MF_SPLITTEXT', 'Zadejte řetězec, který odděluje tělo a rozšířenou textovou část příspěvku');
@define('PLUGIN_MF_SPLITTEXT_DESC', 'Pomocí tohoto nastavení můžete zajistit, že se část meilu bude ukládat do těla příspěvku a zbytek do rozšířené textové části. Pokud POP3 stahovač nalezne v mailu zde zadaný řetězec, všechno před ním vloží do těla příspěvku a všechno za ním do rozšířené textové části. Zvolte jedinečný text, který se nemůže ocitnout v běžném textu, jako např. "xxx-SPLIT-xxx". Zadání této volby může překrýt jiné nastavení pro zpracování mailů!');

@define('PLUGIN_MF_USETEXT', 'Text hledaný v mailu');
@define('PLUGIN_MF_USETEXT_DESC', 'Pokud chcete z mailů vkládat do příspěvků pouze určitou část, můžete zde zadat "kouzelný řetězec", podle které stahovač pozná, kterou část mailu má použít. Následně pak musíte tento řetězec napsat do každého mailu a označit tak text určený pro blog. Zadejte řetězec, který se v mailech nemůže náhodně objevit, dobré je např. "xxx-BLOG-xxx".');
@define('PLUGIN_MF_CRONJOB', 'Tento plugin lze aktivovat pomocí Serendipity Cronjob pluginu. Instalujte jej, pokud chcete spouštět stahovač v pravidelných intervalech.');

@define('PLUGIN_MF_TEXTPREF', 'Upřednostňovat text');
@define('PLUGIN_MF_TEXTPREF_DESC', 'Některá zařízení posílají maily, které jsou psané ve formátu HTML, ale zároveň mají ten samý obsah pouze v neformátovaném textu. Takže z mail dostanete dvakrát ten samý text. Pomocí této volby můžete určit, kterou část chcete používat.');
@define('PLUGIN_MF_TEXTPREF_BOTH', 'Obě části');
@define('PLUGIN_MF_TEXTPREF_HTML', 'HTML');
@define('PLUGIN_MF_TEXTPREF_PLAIN', 'Čistý text');

// Next lines were translated on 2009/10/23

@define('PLUGIN_MF_USEDATE', 'Upřednostnit čas odeslání příchozího mailu před časem doručení');
@define('PLUGIN_MF_REPLY', 'Komentář/odpověď místo příspěvku v blogu.');
@define('PLUGIN_MF_REPLY_ERROR1', 'Nebyl nalezen žádný příspěvek, který by se shodoval s předmětem mailu. Mail nebyl uložen.');
@define('PLUGIN_MF_REPLY_ERROR2', 'Nelze uložit komentář.');

// Next lines were translated on 2009/11/21

@define('PLUGIN_MF_SUBFOLDER', 'Ukládat přílohy v podadresářích pojmenovaných jako 2010/02/ pro zachování chronologického pořadí?');
@define('PLUGIN_MF_DEBUG', 'Ukládat ladicí zprávy do souboru uploads/popfetcher-RRRR-MM.log?');

// Next lines were translated on 2011/06/19

@define('THUMBNAIL_VIEW', 'Zobrazovat náhledy v těle příspěvku');
@define('THUMBNAIL_VIEW_DESC', 'Když chcete zobrazit v těle příspěvku náhledy připojených obrázků. Pokud nastavíte "NE", budou se zobrazovat obrázky v plné velikosti.');